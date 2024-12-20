<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;


class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (app()->environment('local') && !Storage::disk('public')->exists('items')) {
            Storage::disk('public')->makeDirectory('items');
        }

        $userIds = User::pluck('id')->toArray();

        $items = [
            [
                'name' => '一眼レフカメラ（本体＋レンズ)',
                'price' => 100000,
                'description' => "高性能な一眼レフカメラです。\n"
                . "セット内容:\n"
                . "- カメラ本体\n"
                . "- 標準ズームレンズ\n"
                . "- レンズキャップ\n"
                . "- バッテリー（2個）\n"
                . "- バッテリーチャージャー\n"
                . "状態:\n"
                . "- 使用期間1年未満\n"
                . "- 目立つ傷や汚れなし\n",
                'image' => 'images/items/SLR-camera.jpg',
                'category_ids' => [2, 12],
                'condition_id' => 3,

            ],
            [
                'name' => '携帯ラジオ',
                'price' => 2500,
                'description' => "ポケットサイズの携帯ラジオ。\n"
                . "- AM/FM対応\n"
                . "- 電池式で持ち運びに便利\n"
                . "状態:\n"
                . "- 使用感が少なくきれいです。",
                'image' => 'images/items/radio.jpg',
                'category_ids' => [2, 15],
                'condition_id' => 2,
            ],
            [
                'name' => 'ワイヤレスイヤホン',
                'price' => 12000,
                'description' => "人気ブランドのワイヤレスイヤホン。\n"
                . "- クリアな音質\n"
                . "- 長時間バッテリー\n"
                . "状態:\n"
                . "- 未使用に近い美品です。",
                'image' => 'images/items/airpodspro.jpg',
                'category_ids' => [2, 15],
                'condition_id' => 1,
            ],
            [
                'name' => 'スマートウォッチ',
                'price' => 30000,
                'description' => "フィットネス機能搭載のスマートウォッチ。\n"
                . "- 心拍数計測\n"
                . "- メッセージ通知\n"
                . "状態:\n"
                . "- やや小傷がありますが動作良好です。",
                'image' => 'images/items/smart-watch.jpg',
                'category_ids' => [2, 13],
                'condition_id' => 4,
            ],
            [
                'name' => 'ヘッドフォン',
                'price' => 8000,
                'description' => "迫力のある低音が楽しめるヘッドフォン。\n"
                . "- 折りたたみ式\n"
                . "- 長時間使用でも快適\n"
                . "状態:\n"
                . "- 傷や汚れはほとんどありません。",
                'image' => 'images/items/headset.jpg',
                'category_ids' => [2, 15],
                'condition_id' => 3,
            ],
            [
                'name' => 'USB-C充電ケーブル',
                'price' => 1500,
                'description' => "高耐久のUSB-C充電ケーブル。\n"
                . "- 長さ1.5m\n"
                . "- 速い充電スピード\n"
                . "状態:\n"
                . "- 新品未使用品です。",
                'image' => 'images/items/USB-C.jpg',
                'category_ids' => [2, 13],
                'condition_id' => 1,
            ],
            [
                'name' => 'ノートパソコン',
                'price' => 75000,
                'description' => "軽量で持ち運びに便利なノートパソコン。\n"
                . "- Core i5搭載\n"
                . "- メモリ8GB、SSD256GB\n"
                . "状態:\n"
                . "- 使用感がありますが、正常に動作します。",
                'image' => 'images/items/PC.jpg',
                'category_ids' => [2, 13],
                'condition_id' => 4,
            ],
            [
                'name' => '壁掛け時計',
                'price' => 5000,
                'description' => "シンプルでスタイリッシュな壁掛け時計。\n"
                . "- 盤面: 透明なガラス素材\n"
                . "- 長針と短針のみのシンプルなデザイン\n"
                . "状態:\n"
                . "- 新品、未使用\n",
                'image' => 'images/items/wall-clock.jpg',
                'category_ids' => [4, 17],
                'condition_id' => 1,
            ],
            [
                'name' => '南京錠',
                'price' => 800,
                'description' => "小型で頑丈な南京錠。\n"
                . "- 鍵2本付き\n"
                . "状態:\n"
                . "- 軽い使用感がありますが、正常に使えます。",
                'image' => 'images/items/padlock.jpg',
                'category_ids' => [7, 19],
                'condition_id' => 3,
            ],
            [
                'name' => 'スニーカー',
                'price' => 6000,
                'description' => "普段使いにぴったりのスニーカー。\n"
                . "- サイズ26cm\n"
                . "- 快適なクッション性\n"
                . "状態:\n"
                . "- やや使用感がありますが良好です。",
                'image' => 'images/items/sneakers.jpg',
                'category_ids' => [5, 10],
                'condition_id' => 4,
            ],
            [
                'name' => 'マウス(コードレス)',
                'price' => 2500,
                'description' => "使いやすいコードレスマウス。\n"
                . "- 接続方式: Bluetooth\n"
                . "- 対応OS: Windows/Mac\n"
                . "状態:\n"
                . "- 使用感がありますが動作良好です。",
                'image' => 'images/items/mouse.jpg',
                'category_ids' => [2, 13],
                'condition_id' => 3,
            ],
            [
                'name' => '手鍋',
                'price' => 1200,
                'description' => "シンプルで使いやすい手鍋。\n"
                . "- サイズ: 18cm\n"
                . "- 素材: ステンレス\n"
                . "状態:\n"
                . "- やや傷がありますが問題なく使えます。",
                'image' => 'images/items/pot.jpg',
                'category_ids' => [7, 16],
                'condition_id' => 4,
            ],
            [
                'name' => 'ビー玉(50個セット)',
                'price' => 800,
                'description' => "カラフルなビー玉50個セット。\n"
                . "- 各種サイズ・カラーがミックス\n"
                . "状態:\n"
                . "- 新品、未使用。",
                'image' => 'images/items/marbles.jpg',
                'category_ids' => [7, 19],
                'condition_id' => 1,
            ],
            [
                'name' => 'アロマオイル(5本セット)',
                'price' => 1500,
                'description' => "リラックス効果のあるアロマオイルセット。\n"
                . "- 種類: ラベンダー、ミントなど\n"
                . "- 内容量: 10ml x 5本\n"
                . "状態:\n"
                . "- 未使用に近い状態です。",
                'image' => 'images/items/aroma-oil.jpg',
                'category_ids' => [7, 19],
                'condition_id' => 2,
            ],
            [
                'name' => 'コンベックスメジャー5.5m',
                'price' => 700,
                'description' => "DIYや日常作業に便利なメジャー。\n"
                . "- 長さ: 最大5.5m\n"
                . "- ロック機能付き\n"
                . "状態:\n"
                . "- 使用感がありますが正常に機能します。",
                'image' => 'images/items/measure.jpg',
                'category_ids' => [7, 18],
                'condition_id' => 3,
            ],
            [
                'name' => 'メイクブラシセット',
                'price' => 2000,
                'description' => "メイクに必要なブラシが揃ったセット。\n"
                . "- 種類: ファンデーション、アイシャドウブラシなど\n"
                . "- ケース付き\n"
                . "状態:\n"
                . "- やや使用感がありますが清潔に保たれています。",
                'image' => 'images/items/makeup-brush.jpg',
                'category_ids' => [6, 19],
                'condition_id' => 4,
            ],
            [
                'name' => '十二支置物',
                'price' => 3000,
                'description' => "日本の伝統を感じさせる十二支置物。\n"
                . "- 素材: 陶器\n"
                . "- サイズ: 高さ15cm\n"
                . "状態:\n"
                . "- 新品、未使用。",
                'image' => 'images/items/figurine.jpg',
                'category_ids' => [7, 17],
                'condition_id' => 1,
            ],
            [
                'name' => 'Bluetoothスピーカー',
                'price' => 5000,
                'description' => "コンパクトで高音質なBluetoothスピーカー。\n"
                . "- 再生時間: 最大10時間\n"
                . "- ワイヤレス接続\n"
                . "状態:\n"
                . "- 未使用に近い状態です。",
                'image' => 'images/items/speaker.jpg',
                'category_ids' => [2, 15],
                'condition_id' => 2,
            ],
            [
                'name' => '下駄(女性用)',
                'price' => 2500,
                'description' => "日本の伝統的な履物、女性用下駄。\n"
                . "- サイズ: 24cm\n"
                . "- 素材: 木製、布鼻緒\n"
                . "状態:\n"
                . "- 使用感がありますが良好です。",
                'image' => 'images/items/geta.jpg',
                'category_ids' => [1, 10],
                'condition_id' => 3,
            ],
            [
                'name' => 'かご巾着',
                'price' => 1800,
                'description' => "和装に合うおしゃれなかご巾着。\n"
                . "- サイズ: 高さ20cm x 幅15cm\n"
                . "- 素材: 竹、布\n"
                . "状態:\n"
                . "- やや使用感がありますが全体的に綺麗です。",
                'image' => 'images/items/pouch.jpg',
                'category_ids' => [1, 11],
                'condition_id' => 4,
            ],

        ];

        foreach ($items as $itemData) {
            $storedImagePath = $this->storeImage($itemData['image']);

            $itemId = DB::table('items')->insertGetId([
                'name' => $itemData['name'],
                'price' => $itemData['price'],
                'description' => $itemData['description'],
                'image' => $storedImagePath,
                'user_id' => $this->getRandomUserId($userIds),
                'condition_id' => $itemData['condition_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($itemData['category_ids'] as $categoryId) {
                DB::table('category_item')->insert([
                    'item_id' => $itemId,
                    'category_id' => $categoryId,
                ]);
            }
        }
    }

    protected function storeImage($relativePath)
    {
        $localPath = public_path($relativePath);

        if (!file_exists($localPath)) {
            return null;
        }

        $storagePath = 'items/' . basename($relativePath);

        if (app()->environment('production')) {
            Storage::disk('s3')->put($storagePath, file_get_contents($localPath));
        } else {
            Storage::disk('public')->put($storagePath, file_get_contents($localPath));
        }

        return $storagePath;

    }

    protected function getRandomUserId($userIds)
    {
        return $userIds[array_rand($userIds)];
    }
}
