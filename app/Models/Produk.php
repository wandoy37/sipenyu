<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function uptd()
    {
        return $this->belongsTo(uptd::class);
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class);
    }
}
