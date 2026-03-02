<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conditions = [
            ['name' => '良品',              'order' => 1],
            ['name' => '目立った傷や汚れなし', 'order' => 2],
            ['name' => 'やや傷や汚れあり',    'order' => 3],
            ['name' => '状態が悪い',         'order' => 4],
        ];

        DB::table('conditions')->insert($conditions);
    }
}
