<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Payment;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;

class PaymentController extends Controller
{
    // 購入確認画面
    public function create(Item $item)
    {
        $user = auth()->user();
        return view('purchase.create', compact('item', 'user'));
    }

    // 購入処理
    public function store(PurchaseRequest $request, Item $item)
    {
        Payment::create([
            'item_id'        => $item->id,
            'buyer_id'       => auth()->id(),
            'amount'         => $item->price,
            'payment_method' => $request->payment_method,
        ]);

        // 商品のステータスを売り切れに変更
        $item->update(['status' => Item::STATUS_SOLD_OUT]);

        return redirect('/')->with('success', '購入が完了しました');
    }

    // 配送先変更フォーム
    public function editAddress(Item $item)
    {
        $user = auth()->user();
        return view('purchase.address', compact('item', 'user'));
    }

    // 配送先更新
    public function updateAddress(AddressRequest $request, Item $item)
    {
        $user = auth()->user();
        $user->update([
            'postal_code' => $request->postal_code,
            'address'     => $request->address,
            'building'    => $request->building,
        ]);

        return redirect('/purchase/' . $item->id)->with('success', '配送先を変更しました');
    }
}
