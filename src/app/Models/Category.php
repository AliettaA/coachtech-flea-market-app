<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'order',
        'parent_id',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // 子カテゴリを取得（自己参照）
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
