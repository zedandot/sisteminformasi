<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $guarded = [];

    public function lokasis() {
        return $this->hasMany(Lokasi::class);
    }
}
