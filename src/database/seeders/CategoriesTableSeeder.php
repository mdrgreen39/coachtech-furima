<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            "ファッション",
            "家電・ガジェット",
            "ホビー・エンタメ",
            "家具・インテリア",
            "キッズ・ベビー用品",
            "スポーツ・アウトドア",
            "美容・健康",
            "食品・飲料",
            "車・バイク関連",
            "日用品・雑貨",
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
            ]);
        }
    }
}
