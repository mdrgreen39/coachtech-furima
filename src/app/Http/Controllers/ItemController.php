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
        // デフォルトで'recommend'タブを選択
        $currentTab = $request->query('tab', 'recommend');
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
            return Item::whereIn('id', function ($query) {
                $query->select('item_id')
                    ->from('likes')
                    ->where('user_id', auth()->id());
            })->get();
        }

        return Item::where('condition_id', '<', 3)->get();
    }

    // 検索クリア後ページ表示処理
    public function getRecommendItems()
    {
        $items = $this->getItemsByTab('recommend');
        return response()->json($items);
    }

    // 検索処理
    public function searchJson(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = Item::where('name', 'like', '%' . $keyword . '%')
        ->orWhere('description', 'like', '%' . $keyword . '%')
        ->orWhereHas('category', function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        })
        ->orWhereHas('condition', function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        })
        ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'image_url' => Storage::url($item->image),  // 画像のURLを追加
                ];
            });

        return response()->json($products);
    }

    // 商品詳細ページ表示
    public function show($item_id)
    {
        $item = Item::with('likes')->findOrFail($item_id); // キャッシュを削除
        $isLiked = auth()->check() && $item->likes->contains('user_id', auth()->id());

        return view('item-detail', compact('item', 'isLiked'));
    }

    public function getItemDetail($item_id)
    {
        // 商品と「いいね」の状態を取得
        $item = Item::with('likes')->findOrFail($item_id);
        $isLiked = auth()->check() && $item->likes->contains('user_id', auth()->id());

        // 商品情報と「いいね」の状態を返す
        return response()->json([
            'item' => $item,
            'isLiked' => $isLiked,
        ]);
    }


    // いいね追加・解除処理
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

        $isLiked = $status === 'liked';

        return response()->json([
            'status' => $status,
            'likes_count' => $likesCount,
            'is_liked' => $isLiked,
        ]);
    }

    // いいね状態収得
    public function getLikeStatus(Item $item)
    {

        if (!auth()->check()) {
            // ログインしていない場合は`false`を返す
            return response()->json(['is_liked' => false]);
        }

        $isLiked = $item->likes()->where('user_id', auth()->id())->exists();

        return response()->json(['is_liked' => $isLiked]);
    }

}
