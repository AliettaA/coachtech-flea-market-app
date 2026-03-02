<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('mypage_profile', ['user' => Auth::user()]);
    }

    /**
     * プロフィール情報を更新（バリデーションなし）
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // フォームから送られてきた値をそのまま反映
        $user->update([
            'name'      => $request->name,
            'image'     => $request->image, // 画像パス（後でファイル保存処理を追加可能）
            'post_code' => $request->post_code,
            'address'   => $request->address,
            'building'  => $request->building,
        ]);

        // 更新後はトップページ（/）へ戻る
        return redirect()->route('index')->with('message', 'プロフィールを更新しました');
    }
}
