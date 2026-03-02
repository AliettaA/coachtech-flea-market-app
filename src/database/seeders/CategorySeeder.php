<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'ファッション',   'order' => 1,  'parent_id' => null],
            ['name' => '家電',       'order' => 2,  'parent_id' => null],
            ['name' => 'インテリア',       'order' => 3,  'parent_id' => null],
            ['name' => 'レディース',     'order' => 4,  'parent_id' => null],
            ['name' => 'メンズ',     'order' => 5,  'parent_id' => null],
            ['name' => 'コスメ',       'order' => 6,  'parent_id' => null],
            ['name' => '本',         'order' => 7,  'parent_id' => null],
            ['name' => 'ゲーム',   'order' => 8,  'parent_id' => null],
            ['name' => 'スポーツ',       'order' => 9,  'parent_id' => null],
            ['name' => 'キッチン',     'order' => 10, 'parent_id' => null],
            ['name' => 'ハンドメイド',       'order' => 11, 'parent_id' => null],
            ['name' => 'アクセサリー',       'order' => 12, 'parent_id' => null],
            ['name' => 'おもちゃ',       'order' => 13, 'parent_id' => null],
            ['name' => 'ベビー・キッズ',       'order' => 14, 'parent_id' => null],
        ];

        DB::table('categories')->insert($categories);
    }
}
