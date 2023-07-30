<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pegawai extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'role',
        'kantor_id',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'pendidikan_terakhir',
        'no_wa',
        'agama',
        'status_perkawinan',
        'nama_jabatan',
        'unit_eselon',
        'pangkat_golongan',
        'foto_profil',
        'foto_stp',
        'nik',
        'nip',
        'no_telp',
        'email'
    ];

    public function kantor(): BelongsTo
    {
        return $this->belongsTo(Kantor::class, 'kantor_id', 'id')->withDefault([
            'name'=>"Tidak ada kantor"
        ]);
    }

    function loginPegawai() {
        return $this->hasOne(LoginPegawai::class);
    }
}
