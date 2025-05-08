<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kecamatan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kabkota(): BelongsTo
    {
        return $this->belongsTo(KabKota::class);
    }

    function kantors() {
        return $this->belongsToMany(Kantor::class,'kantor_kecamatans','kecamatan_id','kantor_id');
    }
}
