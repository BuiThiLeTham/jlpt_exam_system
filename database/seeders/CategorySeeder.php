<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Kanji',
                'slug_suffix' => 'kanji',
                'description' => 'Câu hỏi chữ Hán.',
            ],
            [
                'name' => 'Từ vựng',
                'slug_suffix' => 'tu-vung',
                'description' => 'Câu hỏi từ vựng.',
            ],
            [
                'name' => 'Ngữ pháp',
                'slug_suffix' => 'ngu-phap',
                'description' => 'Câu hỏi ngữ pháp.',
            ],
            [
                'name' => 'Đọc hiểu',
                'slug_suffix' => 'doc-hieu',
                'description' => 'Câu hỏi đọc hiểu.',
            ],
            [
                'name' => 'Nghe hiểu',
                'slug_suffix' => 'nghe-hieu',
                'description' => 'Câu hỏi nghe hiểu.',
            ],
        ];

        $levels = DB::table('levels')->get();

        foreach ($levels as $level) {
            foreach ($categories as $category) {
                DB::table('categories')->updateOrInsert(
                    [
                        'slug' => strtolower($level->code)
                            . '-'
                            . $category['slug_suffix'],
                    ],
                    [
                        'level_id' => $level->id,
                        'name' => $category['name'],
                        'description' => $category['description'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
