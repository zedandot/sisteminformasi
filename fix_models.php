<?php

$models = [
    'User' => "
    public function laporans() {
        return \$this->hasMany(Laporan::class);
    }
",
    'Client' => "
    protected \$guarded = [];

    public function lokasis() {
        return \$this->hasMany(Lokasi::class);
    }
",
    'Lokasi' => "
    protected \$guarded = [];

    public function client() {
        return \$this->belongsTo(Client::class);
    }
",
    'Pekerjaan' => "
    protected \$guarded = [];

    public function laporans() {
        return \$this->hasMany(Laporan::class);
    }

    public function lokasi() {
        return \$this->belongsTo(Lokasi::class);
    }

    public function client() {
        return \$this->belongsTo(Client::class);
    }
",
    'Laporan' => "
    protected \$guarded = [];

    public function pekerjaan() {
        return \$this->belongsTo(Pekerjaan::class);
    }

    public function user() {
        return \$this->belongsTo(User::class);
    }

    public function fotos() {
        return \$this->hasMany(Foto::class);
    }

    public function pencairan() {
        return \$this->hasOne(Pencairan::class);
    }
",
    'Foto' => "
    protected \$guarded = [];

    public function laporan() {
        return \$this->belongsTo(Laporan::class);
    }
",
    'Pencairan' => "
    protected \$guarded = [];

    public function laporan() {
        return \$this->belongsTo(Laporan::class);
    }
",
    'Notifikasi' => "
    protected \$guarded = [];

    public function user() {
        return \$this->belongsTo(User::class);
    }
"
];

foreach ($models as $name => $code) {
    $file = 'app/Models/' . $name . '.php';
    if (file_exists($file)) {
        $content = file_get_contents($file);
        if ($name === 'User') {
            $content = preg_replace('/(use HasFactory, Notifiable;)/', "$1\n" . $code, $content);
        } else {
            $content = preg_replace('/\{\s*\/\/\s*\}/s', "{\n" . $code . "}", $content);
        }
        file_put_contents($file, $content);
        echo "Updated $name\n";
    }
}
