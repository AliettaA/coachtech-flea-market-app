<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $items = [
            ['name' => 'ノートパソコン', 'price' => 50000, 'description' => '美品のノートパソコンです。', 'category_id' => 1, 'condition_id' => 1],
            ['name' => 'スマートフォン', 'price' => 30000, 'description' => '使用感少なめです。', 'category_id' => 1, 'condition_id' => 2],
            ['name' => 'ワイヤレスイヤホン', 'price' => 8000, 'description' => '音質良好です。', 'category_id' => 1, 'condition_id' => 1],
            ['name' => 'デニムジャケット', 'price' => 5000, 'description' => 'Mサイズです。', 'category_id' => 2, 'condition_id' => 2],
            ['name' => 'スニーカー', 'price' => 7000, 'description' => '26cm、ほぼ未使用です。', 'category_id' => 2, 'condition_id' => 1],
            ['name' => 'ソファ', 'price' => 20000, 'description' => '2人掛けソファです。', 'category_id' => 3, 'condition_id' => 3],
            ['name' => 'コーヒーテーブル', 'price' => 10000, 'description' => 'おしゃれなテーブルです。', 'category_id' => 3, 'condition_id' => 2],
            ['name' => 'フライパンセット', 'price' => 3000, 'description' => '3点セットです。', 'category_id' => 4, 'condition_id' => 2],
            ['name' => 'ギター', 'price' => 25000, 'description' => 'アコースティックギターです。', 'category_id' => 5, 'condition_id' => 1],
            ['name' => 'サッカーボール', 'price' => 2000, 'description' => '公式サイズです。', 'category_id' => 5, 'condition_id' => 2],
        ];

        foreach ($items as $index => $item) {
            \App\Models\Item::create([
                'user_id'      => 1,
                'category_id'  => $item['category_id'],
                'condition_id' => $item['condition_id'],
                'name'         => $item['name'],
                'description'  => $item['description'],
                'price'        => $item['price'],
                'image'        => 'https://placehold.co/300x300?text=' . urlencode($item['name']),
            ]);
        }
    }
}
