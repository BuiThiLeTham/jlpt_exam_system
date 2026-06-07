<?php

namespace App\Services;

use App\Models\Question;
use App\Models\QuestionType;
use App\Repositories\QuestionRepository;
use DomainException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class QuestionService
{
    public function __construct(
        private readonly QuestionRepository $repository
    ) {
    }

    /**
     * Lấy danh sách câu hỏi.
     */
    public function paginate(
        array $filters
    ): LengthAwarePaginator {
        return $this->repository->paginate($filters);
    }

    /**
     * Tạo câu hỏi và 4 đáp án.
     */
    public function create(
        array $data,
        ?UploadedFile $image,
        ?UploadedFile $audio
    ): Question {
        $this->ensureQuestionTypeMatchesCategory(
            (int) $data['category_id'],
            (int) $data['question_type_id']
        );

        $imagePath = $this->storeImage($image);
        $audioPath = $this->storeAudio($audio);

        try {
            return DB::transaction(function () use (
                $data,
                $imagePath,
                $audioPath
            ): Question {
                $questionData = $this->extractQuestionData($data);

                $questionData['created_by'] = auth()->id();
                $questionData['image_path'] = $imagePath;
                $questionData['audio_path'] = $audioPath;

                $question = $this->repository->create(
                    $questionData
                );

                $question->options()->createMany(
                    $this->prepareOptions(
                        $data['options'],
                        $data['correct_option']
                    )
                );

                return $question->load([
                    'category.level',
                    'questionType',
                    'options',
                ]);
            });
        } catch (Throwable $exception) {
            $this->deleteFile($imagePath);
            $this->deleteFile($audioPath);

            throw $exception;
        }
    }

    /**
     * Cập nhật câu hỏi và đáp án.
     */
    public function update(
        Question $question,
        array $data,
        ?UploadedFile $image,
        ?UploadedFile $audio
    ): Question {
        $this->ensureQuestionTypeMatchesCategory(
            (int) $data['category_id'],
            (int) $data['question_type_id']
        );

        $oldImagePath = $question->image_path;
        $oldAudioPath = $question->audio_path;

        $newImagePath = $image
            ? $this->storeImage($image)
            : $oldImagePath;

        $newAudioPath = $audio
            ? $this->storeAudio($audio)
            : $oldAudioPath;

        try {
            $updatedQuestion = DB::transaction(function () use (
                $question,
                $data,
                $newImagePath,
                $newAudioPath
            ): Question {
                $questionData = $this->extractQuestionData($data);

                $questionData['image_path'] = $newImagePath;
                $questionData['audio_path'] = $newAudioPath;

                $this->repository->update(
                    $question,
                    $questionData
                );

                $question->options()->delete();

                $question->options()->createMany(
                    $this->prepareOptions(
                        $data['options'],
                        $data['correct_option']
                    )
                );

                return $question->load([
                    'category.level',
                    'questionType',
                    'options',
                ]);
            });

            if ($image && $oldImagePath !== $newImagePath) {
                $this->deleteFile($oldImagePath);
            }

            if ($audio && $oldAudioPath !== $newAudioPath) {
                $this->deleteFile($oldAudioPath);
            }

            return $updatedQuestion;
        } catch (Throwable $exception) {
            if ($image && $newImagePath !== $oldImagePath) {
                $this->deleteFile($newImagePath);
            }

            if ($audio && $newAudioPath !== $oldAudioPath) {
                $this->deleteFile($newAudioPath);
            }

            throw $exception;
        }
    }

    /**
     * Xóa câu hỏi nếu chưa được dùng trong đề thi.
     */
    public function delete(Question $question): void
    {
        if ($question->examQuestions()->exists()) {
            throw new DomainException(
                'Không thể xóa câu hỏi vì câu hỏi đang được sử dụng trong đề thi.'
            );
        }

        $imagePath = $question->image_path;
        $audioPath = $question->audio_path;

        DB::transaction(function () use ($question): void {
            $question->options()->delete();

            $this->repository->delete($question);
        });

        $this->deleteFile($imagePath);
        $this->deleteFile($audioPath);
    }

    /**
     * Kiểm tra Mondai có thuộc danh mục đã chọn hay không.
     */
    private function ensureQuestionTypeMatchesCategory(
        int $categoryId,
        int $questionTypeId
    ): void {
        $exists = QuestionType::query()
            ->whereKey($questionTypeId)
            ->where('category_id', $categoryId)
            ->exists();

        if (! $exists) {
            throw new DomainException(
                'Mondai không thuộc danh mục đã chọn.'
            );
        }
    }

    /**
     * Chỉ lấy các trường thuộc bảng questions.
     */
    private function extractQuestionData(array $data): array
    {
        return [
            'category_id' => $data['category_id'],
            'question_type_id' => $data['question_type_id'],
            'content' => $data['content'],
            'explanation' => $data['explanation'] ?? null,
            'difficulty' => $data['difficulty'],
            'status' => $data['status'],
        ];
    }

    /**
     * Chuyển 4 đáp án từ form sang dữ liệu lưu database.
     */
    private function prepareOptions(
        array $options,
        string $correctOption
    ): array {
        return collect($options)
            ->map(
                fn (array $option): array => [
                    'label' => $option['label'],
                    'content' => $option['content'],
                    'is_correct' => $option['label']
                        === $correctOption,
                ]
            )
            ->values()
            ->all();
    }

    /**
     * Lưu ảnh vào storage/app/public/questions/images.
     */
    private function storeImage(
        ?UploadedFile $image
    ): ?string {
        return $image?->store(
            'questions/images',
            'public'
        );
    }

    /**
     * Lưu audio vào storage/app/public/questions/audio.
     */
    private function storeAudio(
        ?UploadedFile $audio
    ): ?string {
        return $audio?->store(
            'questions/audio',
            'public'
        );
    }

    /**
     * Xóa file khỏi storage nếu tồn tại.
     */
    private function deleteFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
