<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\QuestionType;
use App\Services\QuestionTypeService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class QuestionTypeController extends Controller
{
    public function __construct(
        private readonly QuestionTypeService $service
    ) {
    }

    /**
     * Danh sách Mondai.
     */
    public function index(Request $request): View
    {
        $categoryId = $request->integer('category_id') ?: null;

        return view('admin.question-types.index', [
            'questionTypes' => $this->service
                ->paginate($categoryId),
            'categories' => $this->getCategories(),
            'selectedCategoryId' => $categoryId,
        ]);
    }

    /**
     * Form tạo Mondai.
     */
    public function create(): View
    {
        return view('admin.question-types.create', [
            'categories' => $this->getCategories(),
        ]);
    }

    /**
     * Lưu Mondai.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $this->service->create($validated);

        return redirect()
            ->route('admin.question-types.index')
            ->with('success', 'Tạo Mondai thành công.');
    }

    /**
     * Form cập nhật Mondai.
     */
    public function edit(
        QuestionType $questionType
    ): View {
        return view('admin.question-types.edit', [
            'questionType' => $questionType,
            'categories' => $this->getCategories(),
        ]);
    }

    /**
     * Cập nhật Mondai.
     */
    public function update(
        Request $request,
        QuestionType $questionType
    ): RedirectResponse {
        $validated = $this->validateData(
            $request,
            $questionType
        );

        $this->service->update(
            $questionType,
            $validated
        );

        return redirect()
            ->route('admin.question-types.index')
            ->with('success', 'Cập nhật Mondai thành công.');
    }

    /**
     * Xóa Mondai.
     */
    public function destroy(
        QuestionType $questionType
    ): RedirectResponse {
        try {
            $this->service->delete($questionType);

            return redirect()
                ->route('admin.question-types.index')
                ->with('success', 'Xóa Mondai thành công.');
        } catch (DomainException $exception) {
            return redirect()
                ->route('admin.question-types.index')
                ->with('error', $exception->getMessage());
        }
    }

    /**
     * Validate dữ liệu Mondai.
     */
    private function validateData(
        Request $request,
        ?QuestionType $questionType = null
    ): array {
        $uniqueName = Rule::unique(
            'question_types',
            'name'
        )->where(
            fn ($query) => $query->where(
                'category_id',
                $request->input('category_id')
            )
        );

        if ($questionType) {
            $uniqueName->ignore($questionType->id);
        }

        return $request->validate([
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                $uniqueName,
            ],
            'description' => [
                'nullable',
                'string',
            ],
        ]);
    }

    /**
     * Lấy danh mục và cấp độ để hiển thị trong select.
     */
    private function getCategories()
    {
        return Category::query()
            ->with('level')
            ->orderByDesc('level_id')
            ->orderBy('name')
            ->get();
    }
}
