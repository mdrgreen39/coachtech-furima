<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;

class ItemController extends Controller
{
    // トップページ表示
    public function index(Request $request)
    {
        $currentTab = $request->query('tab', null);
        $items = $this->getItemsByTab($currentTab);

        if ($request->ajax()) {
            $html = view('components.item-grid', compact('items'))->render();
            return response()->json(['items_html' => $html]);
        } else {
            return view('index', compact('items', 'currentTab'));
        }
    }

    // タブ切り替え処理
    protected function getItemsByTab($tab)
    {
        if ($tab === 'recommend') {
            return Item::where('condition_id', '<', 3)->get();
        } elseif ($tab === 'wishlist') {
            return Item::where('user_id', auth()->id())->get();
        }

        return Item::all();
    }

    // 商品詳細ページ表示
    public function show($item_id)
    {
        $item = Cache::remember("item_{$item_id}", 60, function () use ($item_id) {
            return Item::findOrFail($item_id);
        });
        $isLiked = $item->likes->contains('user_id', auth()->id());

        return view('item-detail', compact('item', 'isLiked'));
    }

    // 検索処理
    public function searchJson(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = Item::where('name', 'like', '%' . $keyword . '%')
        ->orWhere('description', 'like', '%' . $keyword . '%')
        ->get()
            ->map(function ($item) {
                // 必要なフィールドのみを返す
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'image_url' => Storage::url($item->image),  // 画像のURLを追加
                ];
            });

        return response()->json($products);
    }

    // お気に入り追加・解除処理
    public function toggleLike(Item $item)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['redirect' => route('login')]);
        }

        $existingLike = $item->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $item->likes()->detach($user->id);
            $status = 'unliked';
        } else {
            $item->likes()->attach($user->id);
            $status = 'liked';
        }

        $likesCount = $item->likes()->count();

        return response()->json([
            'status' => $status,
            'likes_count' => $likesCount,
        ]);
    }
}
