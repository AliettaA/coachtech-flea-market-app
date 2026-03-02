<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Item;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // いいね追加
    public function store(Item $item)
    {
        Like::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
        ]);

        return back();
    }

    // いいね削除
    public function destroy(Item $item)
    {
        Like::where('user_id', auth()->id())
            ->where('item_id', $item->id)
            ->delete();

        return back();
    }
}
