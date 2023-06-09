<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KabKota extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kecamatans(): HasMany
    {
        return $this->hasMany(Kecamatan::class, 'kabkota_id', 'id');
    }
}
