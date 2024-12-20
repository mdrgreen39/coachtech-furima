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
            "家電",
            "ホビー・エンタメ",
            "家具",
            "スポーツ・アウトドア",
            "美容・健康",
            "日用品・雑貨",
            "メンズ",
            "レディース",
            "靴",
            "バッグ",
            "カメラ",
            "パソコン",
            "時計",
            "オーディオ機器",
            "調理器具",
            "インテリア",
            "DIY工具",
            "小物",
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
            ]);
        }
    }
}
