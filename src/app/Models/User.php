<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'postal_code',
        'address',
        'building',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ----------------------------
    // リレーション
    // ----------------------------

    // 出品した商品一覧
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    // いいねした商品一覧
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // 購入した取引一覧（buyer_idで参照）
    public function purchases()
    {
        return $this->hasMany(Payment::class, 'buyer_id');
    }

    // 自分が書いたレビュー一覧
    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    // 自分が受け取ったレビュー一覧
    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }
}
