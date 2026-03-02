<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'item_id',
        'buyer_id',
        'amount',
        'payment_method',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    // ステータスの定数
    const STATUS_PENDING   = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // ----------------------------
    // リレーション
    // ----------------------------

    // 購入された商品
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // 購入者（buyer_idで参照）
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    // この取引のレビュー
    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
