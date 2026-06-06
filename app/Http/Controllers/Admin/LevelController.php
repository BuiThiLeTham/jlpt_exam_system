<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Services\LevelService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LevelController extends Controller
{
    public function __construct(
        private readonly LevelService $service
    ) {
    }

    /**
     * Danh sách cấp độ JLPT.
     */
    public function index(): View
    {
        return view('admin.levels.index', [
            'levels' => $this->service->paginate(),
        ]);
    }

    /**
     * Form tạo cấp độ.
     */
    public function create(): View
    {
        return view('admin.levels.create');
    }

    /**
     * Lưu cấp độ mới.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:10',
                'regex:/^N[1-5]$/i',
                'unique:levels,code',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
            ],
        ]);

        $this->service->create($validated);

        return redirect()
            ->route('admin.levels.index')
            ->with('success', 'Tạo cấp độ JLPT thành công.');
    }

    /**
     * Form cập nhật cấp độ.
     */
    public function edit(Level $level): View
    {
        return view('admin.levels.edit', [
            'level' => $level,
        ]);
    }

    /**
     * Cập nhật cấp độ.
     */
    public function update(
        Request $request,
        Level $level
    ): RedirectResponse {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:10',
                'regex:/^N[1-5]$/i',
                Rule::unique('levels', 'code')
                    ->ignore($level->id),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
            ],
        ]);

        $this->service->update($level, $validated);

        return redirect()
            ->route('admin.levels.index')
            ->with('success', 'Cập nhật cấp độ thành công.');
    }

    /**
     * Xóa cấp độ.
     */
    public function destroy(Level $level): RedirectResponse
    {
        try {
            $this->service->delete($level);

            return redirect()
                ->route('admin.levels.index')
                ->with('success', 'Xóa cấp độ thành công.');
        } catch (DomainException $exception) {
            return redirect()
                ->route('admin.levels.index')
                ->with('error', $exception->getMessage());
        }
    }
}
