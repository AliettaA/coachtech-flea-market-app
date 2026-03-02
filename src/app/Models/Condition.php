<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'order',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
