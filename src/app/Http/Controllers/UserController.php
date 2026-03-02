<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;

class UserController extends Controller
{
    // マイページ
    public function index()
    {
        $user = auth()->user();
        $items = $user->items;
        $purchases = $user->purchases()->with('item')->get();
        $likedItems = $user->likes()->with('item')->get()->pluck('item');

        return view('mypage.index', compact('user', 'items', 'purchases', 'likedItems'));
    }

    // プロフィール編集フォーム
    public function edit()
    {
        $user = auth()->user();
        return view('mypage.edit', compact('user'));
    }

    // プロフィール更新
    public function update(ProfileRequest $request)
    {
        $user = auth()->user();

        $imagePath = $user->profile_image;
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profiles', 'public');
        }

        $user->update([
            'name'          => $request->name,
            'postal_code'   => $request->postal_code,
            'address'       => $request->address,
            'building'      => $request->building,
            'profile_image' => $imagePath,
        ]);

        return redirect('/mypage')->with('success', 'プロフィールを更新しました');
    }
}
