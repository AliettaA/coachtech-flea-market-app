<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'condition_id',
        'name',
        'description',
        'brand',
        'price',
        'image',
        'status',
    ];

    const STATUS_ON_SALE  = 'on_sale';
    const STATUS_SOLD_OUT = 'sold';
    const STATUS_DRAFT    = 'draft';

    // ----------------------------
    // リレーション
    // ----------------------------

    // 出品者（この商品を出品したユーザー）
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // カテゴリ
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 商品の状態
    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    // いいね一覧
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // 取引情報
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }


    // ログイン中のユーザーがいいね済みかチェック
    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    // 売り切れかどうかチェック
    public function isSoldOut(): bool
    {
        return $this->status === self::STATUS_SOLD_OUT;
    }

    // コメントの表示
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
