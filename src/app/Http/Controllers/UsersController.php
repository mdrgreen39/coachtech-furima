<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile;
use App\Models\User;
use App\Models\Item;
use App\Http\Requests\ProfileRequest;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('role:user');
    }

    // マイページ表示
    public function mypage(Request $request)
    {
        $currentTab = $request->query('tab', 'recommend');
        $items = $this->getItemsByTab($currentTab);

        if ($request->ajax()) {
            $html = view('components.item-grid', compact('items'))->render();
            return response()->json(['items_html' => $html]);
        } else {
            $user = Auth::user();
            $profile = $user->profile;

            return view('mypage', compact('user', 'profile', 'items', 'currentTab'));
        }
    }

    // タブ切り替え処理
    protected function getItemsByTab($tab)
    {
        if ($tab === 'recommend') {
            return Item::where('user_id', auth()->id())->get();
        } elseif ($tab === 'purchase') {
            return Item::whereHas('users', function ($query) {
                $query->where('user_id', auth()->id());
            })->get();
        } elseif ($tab === 'wishlist') {
            return Item::whereIn('id', function ($query) {
                $query->select('item_id')
                ->from('likes')
                ->where('user_id', auth()->id());
            })->get();
        }

        return Item::where('user_id', auth()->id())->get();
    }

    public function getMypageItems(Request $request)
    {
        $items = Item::where('user_id', auth()->id())->get();

        return response()->json($items);
    }


    // プロフィール編集画面を表示
    public function editProfile()
    {
        $profile = Auth::user()->profile;

        if (!$profile) {
            $profile = new Profile(); // 空のプロフィールオブジェクトを作成
        }

        return view('profile', compact('profile'));

    }

    // プロフィール編集処理
    public function updateProfile(ProfileRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();

        // プロフィールが存在しない場合は新しく作成
        $profile = $user->profile ?: new Profile();

        if ($request->hasFile('image')) {

            $directory = 'profile_images/';
            $path = $directory . $user->id . '.png';

            if (app()->environment('local')) {
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory);
                }
            }

            if (app()->environment('production')) {
                Storage::disk('s3')->put($path, file_get_contents($request->file('image')));
            } else {
                Storage::disk('public')->put($path, file_get_contents($request->file('image')));
            }

            // すでにプロフィール画像が保存されていれば削除
            if ($profile->image) {
                Storage::delete($profile->image);
            }

            // 新しい画像のパスをデータベースに保存
            $profile->image = $path;
        }

        // プロフィール情報を更新
        $profile->fill([
            'user_id' => $user->id,
            'postcode' => $validated['postcode'] ?? $profile->postcode,
            'address' => $validated['address'] ?? $profile->address,
            'building' => $validated['building'] ?? $profile->building,
        ]);
        $profile->save();

        // ユーザー名が変更されていれば更新
        if ($validated['name'] !== $user->name) {
            $user->update([
                'name' => $validated['name'],
            ]);
        }

        // マイページにリダイレクト
        return redirect()->route('user.mypage', $user->id)->with('message', 'プロフィールを更新しました。');
    }

}
