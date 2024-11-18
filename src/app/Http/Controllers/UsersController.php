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

    public function mypage()
    {
        $user = Auth::user();
        $profile = $user->profile;

        $items = Item::all();

        return view('mypage', compact('user', 'profile', 'items'));
    }

    // プロフィール編集画面を表示
    public function editProfile()
    {
        $user = Auth::user()->profile;

        return view('profile', compact('profile'));

    }

    public function updateProfile(ProfileRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();

        $profile = $user->profile ?: new Profile();

        if ($request->hasFile('img_url')) {
            $path = 'profile_images/' . $user->id . '.png';

            if (app()->environment('production')) {
                Storage::disk('s3')->put($path, file_get_contents($request->file('img_url')));
            } else {
                Storage::disk('public')->put($path, file_get_contents($request->file('img_url')));
            }

            if ($profile->img_url) {
                Storage::delete('public/' . $profile->img_url);
            }

            $profile->img_url = $path;
        }

        $profile->fill([
            'user_id' => $user->id,
            'postcode' => $validated['postcode'] ?? $profile->postcode,
            'address' => $validated['address'] ?? $profile->address,
            'building' => $validated['building'] ?? $profile->building,
        ]);
        $profile->save();

        if ($validated['name'] !== $user->name) {
            $user->update([
                'name' => $validated['name'],
            ]);
        }

        return redirect()->route('mypage', $user->id);
    }

}
