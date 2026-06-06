<?php

namespace App\Services;

use App\Models\Level;
use App\Repositories\LevelRepository;
use DomainException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LevelService
{
    public function __construct(
        private readonly LevelRepository $repository
    ) {
    }

    /**
     * Lấy danh sách cấp độ.
     */
    public function paginate(): LengthAwarePaginator
    {
        return $this->repository->paginate();
    }

    /**
     * Tạo cấp độ.
     */
    public function create(array $data): Level
    {
        $data['code'] = strtoupper($data['code']);

        return $this->repository->create($data);
    }

    /**
     * Cập nhật cấp độ.
     */
    public function update(Level $level, array $data): Level
    {
        $data['code'] = strtoupper($data['code']);

        return $this->repository->update($level, $data);
    }

    /**
     * Xóa cấp độ nếu không có dữ liệu phụ thuộc.
     */
    public function delete(Level $level): void
    {
        if ($level->categories()->exists()) {
            throw new DomainException(
                'Không thể xóa cấp độ vì vẫn còn danh mục liên quan.'
            );
        }

        if ($level->exams()->exists()) {
            throw new DomainException(
                'Không thể xóa cấp độ vì vẫn còn đề thi liên quan.'
            );
        }

        $this->repository->delete($level);
    }
}
