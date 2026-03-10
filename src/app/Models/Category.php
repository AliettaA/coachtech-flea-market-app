<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    
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
