<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{

    protected $guarded = [];

    public function pekerjaan() {
        return $this->belongsTo(Pekerjaan::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function fotos() {
        return $this->hasMany(Foto::class);
    }

    public function pencairan() {
        return $this->hasOne(Pencairan::class);
    }
}
