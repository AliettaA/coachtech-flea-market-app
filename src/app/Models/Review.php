<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'payment_id',
        'reviewer_id',
        'reviewee_id',
        'rating',
        'comment',
    ];

    // ----------------------------
    // リレーション
    // ----------------------------

    // どの取引に対するレビューか
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    // レビューしたユーザー（購入者）
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    // レビューされたユーザー（出品者）
    public function reviewee()
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }
}
