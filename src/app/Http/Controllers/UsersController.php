<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function mypage()
    {
        return view('mypage');

        // $items = Item::all();

        // return view('index', compact('items'));
    }

    // プロフィール編集画面を表示
    public function editProfile()
    {
        // ログイン中のユーザーを取得
        // $user = Auth::user();

        // ビューにユーザー情報を渡して表示
        // return view('mypage.profile.edit', compact('user'));

        return view('profile');

    }
}
