<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kantor extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kecamatans(): BelongsToMany
    {
        return $this->belongsToMany(Kecamatan::class, 'kantor_kecamatans', 'kantor_id', 'kecamatan_id');
    }

    public function KabKota(): BelongsTo
    {
        return $this->belongsTo(KabKota::class, 'kabkota_id', 'id')->withDefault([
            'name' => "Tidak ada kabupaten/kota"
        ]);
    }

    function pegawais() {
        return $this->hasMany(Pegawai::class);
    }
}
