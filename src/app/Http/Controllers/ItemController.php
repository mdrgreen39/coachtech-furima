<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;

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

    // 検索クリア後の商品詳細ページ表示処理
    public function getItemDetail($item_id)
    {
        $item = Item::with('likes')->findOrFail($item_id);
        $isLiked = auth()->check() && $item->likes->contains('user_id', auth()->id());

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
            return response()->json(['is_liked' => false]);
        }

        $isLiked = $item->likes()->where('user_id', auth()->id())->exists();
        $likesCount = $item->likes()->count();

        return response()->json([
            'is_liked' => $isLiked,
            'likes_count' => $likesCount
        ]);
    }

    // コメントページ表示
    public function comments($id)
    {
        $item = Item::with(['comments.user', 'likes'])->findOrFail($id);

        $userProfile = auth()->user()->profile;

        $profileImageUrl = null;
        if ($userProfile && $userProfile->image
        ) {
            if (config('filesystems.default') == 's3') {
                $profileImageUrl = Storage::disk('s3')->url($userProfile->image);
            } else {
                $profileImageUrl = Storage::disk('public')->url($userProfile->image);
            }
        }

        // いいねの状態
        $isLiked = auth()->check() && $item->likes->contains('user_id', auth()->id());

        $commentCount = $item->comments->count();

        return view('comment', compact('item', 'isLiked', 'commentCount', 'profileImageUrl', 'userProfile'));
    }


    // コメント処理
    public function storeComment(CommentRequest $request, $itemId)
    {
        $item = Item::findOrFail($itemId);

        if ($item->user_id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => '自分が出品した商品にはコメントできません',
            ], 403);
        }

        try {
            $comment = new Comment();
            $comment->user_id = auth()->id();
            $comment->item_id = $item->id;
            $comment->comment = $request->comment;
            $comment->save();

            $commentCount = $item->comments->count();

            return response()->json([
                'success' => true,
                'comment' => $comment->comment,
                'message' => 'コメントを送信しました',
                'comment_count' => $commentCount,
                'profileImageUrl' => $comment->user->profile_image_url ?? null,
                'userName' => $comment->user->name ?? '名前',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '予期しないエラーが発生しました。',
            ], 500);
        }
    }







}
