<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Payment;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Http\Requests\AddressRequest;

class PaymentController extends Controller
{
    // 購入確認画面
    public function create(Item $item)
    {
        $user = auth()->user();
        return view('purchase.confirm', compact('item', 'user'));
    }

    // Stripeチェックアウトセッション作成
    public function store(PurchaseRequest $request, Item $item)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentMethod = $request->payment_method;
        $paymentMethodTypes = $paymentMethod === 'credit_card' ? ['card'] : ['konbini'];

        $session = Session::create([
            'payment_method_types' => $paymentMethodTypes,
            'line_items' => [[
                'price_data' => [
                    'currency'     => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount'  => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode'        => 'payment',
            'success_url' => url('/purchase/' . $item->id . '/success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => url('/purchase/' . $item->id),
        ]);

        // セッションにpayment_methodを保存
        session(['payment_method' => $paymentMethod, 'item_id' => $item->id]);

        return redirect($session->url);
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

    // 購入完了
    public function success(Item $item)
    {
        \Log::info('success called', ['item_id' => $item->id]);

        Payment::create([
            'item_id'        => $item->id,
            'buyer_id'       => auth()->id(),
            'amount'         => $item->price,
            'payment_method' => session('payment_method'),
            'status'         => 'completed',
            'paid_at'        => now(),
        ]);

        $item->update(['status' => Item::STATUS_SOLD_OUT]);

        return redirect('/')->with('success', '購入が完了しました');
    }
}
