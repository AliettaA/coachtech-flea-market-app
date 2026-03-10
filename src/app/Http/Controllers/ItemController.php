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
        \Log::info('request', ['search' => $request->search, 'filled' => $request->filled('search')]);

        $query = Item::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 自分の出品した商品を除外
        if (auth()->check()) {
            $query->where('user_id', '!=', auth()->id());
        }

        $items = $query->get();

        $likedItems = collect();
        if (auth()->check()) {
            $likedQuery = auth()->user()->likes()->with('item');

            $likedItems = $likedQuery->get()->pluck('item')->filter();

            if ($request->filled('search')) {
                $likedItems = Item::whereIn('id', $likedItems->pluck('id'))
                    ->where('name', 'like', '%' . $request->search . '%')
                    ->get();
            }
        }

        $tab = $request->get('tab', 'recommend');

        return view('index', compact('items', 'likedItems', 'tab'));
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

        $item = Item::create([
            'user_id'      => auth()->id(),
            'name'         => $request->name,
            'description'  => $request->description,
            'price'        => $request->price,
            'condition_id' => $request->condition_id,
            'image'        => $imagePath,
            'brand'        => $request->brand,
        ]);

        // カテゴリの紐付け
        $item->categories()->attach($request->category_id);

        return redirect('/')->with('success', '商品を出品しました');
    }
}