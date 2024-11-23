<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $currentTab = $request->query('tab', null); // 現在のタブ情報を取得
        $items = $this->getItemsByTab($currentTab);

        if ($request->ajax()) {
            // AJAXリクエストの場合、JSON形式でデータを返す
            $html = view('components.item-grid', compact('items'))->render();
            return response()->json(['items_html' => $html]);
        } else {
            // 通常のページリクエストの場合
            return view('index', compact('items', 'currentTab'));
        }
    }

    protected function getItemsByTab($tab)
    {
        if ($tab === 'recommend') {
            // おすすめタブの場合：良い状態のアイテム
            return Item::where('condition_id', '<', 3)->get();
        } elseif ($tab === 'wishlist') {
            // マイリストタブの場合：ユーザーのマイリスト
            return Item::where('user_id', auth()->id())->get();
        }

        // デフォルトはすべてのアイテムを返す
        return Item::all();
    }

    public function searchJson(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = Item::where('name', 'like', '%' . $keyword . '%')
            ->orWhere('description', 'like', '%' . $keyword . '%')
            ->get();

        return response()->json($products);
    }
}
