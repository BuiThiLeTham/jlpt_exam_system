<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionType;
use App\Services\QuestionService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function __construct(
        private readonly QuestionService $service
    ) {
    }

    /**
     * Danh sách câu hỏi.
     */
    public function index(Request $request): View
    {
        $filters = $request->only([
            'keyword',
            'category_id',
            'question_type_id',
            'difficulty',
            'status',
        ]);

        return view('admin.questions.index', [
            'questions' => $this->service->paginate(
                $filters
            ),
            'categories' => $this->getCategories(),
            'questionTypes' => $this->getQuestionTypes(),
            'filters' => $filters,
        ]);
    }

    /**
     * Form tạo câu hỏi.
     */
    public function create(): View
    {
        return view('admin.questions.create', [
            'categories' => $this->getCategories(),
            'questionTypes' => $this->getQuestionTypes(),
        ]);
    }

    /**
     * Lưu câu hỏi mới.
     */
    public function store(
        Request $request
    ): RedirectResponse {
        $validated = $this->validateData($request);

        try {
            $question = $this->service->create(
                $validated,
                $request->file('image'),
                $request->file('audio')
            );

            return redirect()
                ->route('admin.questions.show', $question)
                ->with('success', 'Tạo câu hỏi thành công.');
        } catch (DomainException $exception) {
            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }
    }

    /**
     * Xem chi tiết câu hỏi.
     */
    public function show(Question $question): View
    {
        return view('admin.questions.show', [
            'question' => $question->load([
                'category.level',
                'questionType',
                'creator',
                'options',
            ]),
        ]);
    }

    /**
     * Form cập nhật câu hỏi.
     */
    public function edit(Question $question): View
    {
        return view('admin.questions.edit', [
            'question' => $question->load('options'),
            'categories' => $this->getCategories(),
            'questionTypes' => $this->getQuestionTypes(),
        ]);
    }

    /**
     * Cập nhật câu hỏi.
     */
    public function update(
        Request $request,
        Question $question
    ): RedirectResponse {
        $validated = $this->validateData($request);

        try {
            $this->service->update(
                $question,
                $validated,
                $request->file('image'),
                $request->file('audio')
            );

            return redirect()
                ->route('admin.questions.show', $question)
                ->with('success', 'Cập nhật câu hỏi thành công.');
        } catch (DomainException $exception) {
            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }
    }

    /**
     * Xóa câu hỏi.
     */
    public function destroy(
        Question $question
    ): RedirectResponse {
        try {
            $this->service->delete($question);

            return redirect()
                ->route('admin.questions.index')
                ->with('success', 'Xóa câu hỏi thành công.');
        } catch (DomainException $exception) {
            return redirect()
                ->route('admin.questions.index')
                ->with('error', $exception->getMessage());
        }
    }

    /**
     * Validate dữ liệu tạo và cập nhật.
     */
    private function validateData(Request $request): array
    {
        return $request->validate([
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'question_type_id' => [
                'required',
                'integer',
                'exists:question_types,id',
            ],

            'content' => [
                'required',
                'string',
            ],

            'explanation' => [
                'nullable',
                'string',
            ],

            'difficulty' => [
                'required',
                Rule::in([
                    'easy',
                    'medium',
                    'hard',
                ]),
            ],

            'status' => [
                'required',
                Rule::in([
                    'draft',
                    'published',
                ]),
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'audio' => [
                'nullable',
                'file',
                'mimes:mp3,wav,ogg,m4a',
                'max:10240',
            ],

            'options' => [
                'required',
                'array',
                'size:4',
            ],

            'options.*.label' => [
                'required',
                'string',
                'distinct',
                Rule::in([
                    'A',
                    'B',
                    'C',
                    'D',
                ]),
            ],

            'options.*.content' => [
                'required',
                'string',
            ],

            'correct_option' => [
                'required',
                Rule::in([
                    'A',
                    'B',
                    'C',
                    'D',
                ]),
            ],
        ]);
    }

    /**
     * Lấy danh mục cùng cấp độ.
     */
    private function getCategories()
    {
        return Category::query()
            ->with('level')
            ->orderByDesc('level_id')
            ->orderBy('name')
            ->get();
    }

    /**
     * Lấy Mondai cùng danh mục.
     */
    private function getQuestionTypes()
    {
        return QuestionType::query()
            ->with('category.level')
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();
    }
}
