<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kantor extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id');
    }

    public function KabKota(): BelongsTo
    {
        return $this->belongsTo(KabKota::class, 'kabkota_id', 'id');
    }
}
