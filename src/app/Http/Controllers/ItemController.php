<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // 商品一覧
    public function index(Request $request)
    {
        $query = Item::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $items = $query->get();

        // マイリスト（ログイン時のみ）
        $likedItems = collect();
        if (auth()->check()) {
            $likedItems = auth()->user()->likes()->with('item')->get()->pluck('item');
        }

        $tab = $request->get('tab', 'recommend');

        return view('items.index', compact('items', 'likedItems', 'tab'));
    }

    // 商品詳細
    public function show($id)
    {
        $item = Item::findOrFail($id);
        return view('items.show', compact('item'));
    }

    // 出品フォーム
    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('items.create', compact('categories', 'conditions'));
    }

    // 出品保存
    public function store(ExhibitionRequest $request)
    {
        // 画像保存
        $imagePath = $request->file('image')->store('items', 'public');

        Item::create([
            'user_id'      => auth()->id(),
            'name'         => $request->name,
            'description'  => $request->description,
            'price'        => $request->price,
            'category_id'  => $request->category_id,
            'condition_id' => $request->condition_id,
            'image'        => $imagePath,
            'brand'        => $request->brand,
        ]);

        return redirect('/')->with('success', '商品を出品しました');
    }
}