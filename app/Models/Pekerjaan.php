<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{

    protected $guarded = [];

    public function laporans() {
        return $this->hasMany(Laporan::class);
    }

    public function lokasi() {
        return $this->belongsTo(Lokasi::class);
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
