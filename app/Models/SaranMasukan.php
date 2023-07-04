<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaranMasukan extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = ['custom_diff_for_humans'];

    //diffForHumans
    function getCustomDiffForHumansAttribute() {
        return $this->created_at->diffForHumans();
    }
}
