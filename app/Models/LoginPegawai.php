<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class LoginPegawai extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];

    function pegawai() {
        return $this->belongsTo(Pegawai::class);
    }

    function loginPegawaiApiToken() {
        return $this->hasMany(LoginPegawaiApiToken::class);
    }
}
