<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            [
                'code' => 'N5',
                'name' => 'JLPT N5',
                'description' => 'Cấp độ nhập môn.',
            ],
            [
                'code' => 'N4',
                'name' => 'JLPT N4',
                'description' => 'Cấp độ sơ cấp.',
            ],
            [
                'code' => 'N3',
                'name' => 'JLPT N3',
                'description' => 'Cấp độ trung cấp.',
            ],
            [
                'code' => 'N2',
                'name' => 'JLPT N2',
                'description' => 'Cấp độ trung cao cấp.',
            ],
            [
                'code' => 'N1',
                'name' => 'JLPT N1',
                'description' => 'Cấp độ cao cấp.',
            ],
        ];

        foreach ($levels as $level) {
            DB::table('levels')->updateOrInsert(
                [
                    'code' => $level['code'],
                ],
                [
                    'name' => $level['name'],
                    'description' => $level['description'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
