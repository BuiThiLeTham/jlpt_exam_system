<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Level;
use App\Services\CategoryService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $service
    ) {
    }

    /**
     * Danh sách danh mục.
     */
    public function index(Request $request): View
    {
        $levelId = $request->integer('level_id') ?: null;

        return view('admin.categories.index', [
            'categories' => $this->service->paginate($levelId),
            'levels' => Level::query()
                ->orderByDesc('code')
                ->get(),
            'selectedLevelId' => $levelId,
        ]);
    }

    /**
     * Form tạo danh mục.
     */
    public function create(): View
    {
        return view('admin.categories.create', [
            'levels' => Level::query()
                ->orderByDesc('code')
                ->get(),
        ]);
    }

    /**
     * Lưu danh mục.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $this->service->create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Tạo danh mục thành công.');
    }

    /**
     * Form cập nhật danh mục.
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', [
            'category' => $category,
            'levels' => Level::query()
                ->orderByDesc('code')
                ->get(),
        ]);
    }

    /**
     * Cập nhật danh mục.
     */
    public function update(
        Request $request,
        Category $category
    ): RedirectResponse {
        $validated = $this->validateData(
            $request,
            $category
        );

        $this->service->update($category, $validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Cập nhật danh mục thành công.');
    }

    /**
     * Xóa danh mục.
     */
    public function destroy(
        Category $category
    ): RedirectResponse {
        try {
            $this->service->delete($category);

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Xóa danh mục thành công.');
        } catch (DomainException $exception) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', $exception->getMessage());
        }
    }

    /**
     * Validate dữ liệu tạo và cập nhật danh mục.
     */
    private function validateData(
        Request $request,
        ?Category $category = null
    ): array {
        $uniqueName = Rule::unique(
            'categories',
            'name'
        )->where(
            fn ($query) => $query->where(
                'level_id',
                $request->input('level_id')
            )
        );

        if ($category) {
            $uniqueName->ignore($category->id);
        }

        return $request->validate([
            'level_id' => [
                'required',
                'integer',
                'exists:levels,id',
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
}
