<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conditions = [
            "新品、未使用",
            "未使用に近い",
            "目立った傷や汚れなし",
            "やや傷や汚れあり",
            "傷や汚れあり",
            "全体的に状態が悪い",
        ];

        foreach ($conditions as $condition) {
            DB::table('conditions')->insert([
                'condition' => $condition,
            ]);
        }
    }
}
