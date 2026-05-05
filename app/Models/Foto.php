<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{

    protected $guarded = [];

    public function laporan() {
        return $this->belongsTo(Laporan::class);
    }
}
