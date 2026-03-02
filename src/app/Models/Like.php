<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    // updated_atは不要なのでcreated_atのみ
    public $timestamps = false;
    const CREATED_AT = 'created_at';

    protected $fillable = [
        'user_id',
        'item_id',
    ];

    // ----------------------------
    // リレーション
    // ----------------------------

    // いいねしたユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // いいねされた商品
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
