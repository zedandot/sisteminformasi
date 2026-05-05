<?php

$dir = 'database/migrations/';
$files = glob($dir . '*.php');

$replacements = [
    'create_clients_table' => "\$table->id();\n            \$table->string('nama');\n            \$table->text('alamat');\n            \$table->timestamps();",
    'create_lokasis_table' => "\$table->id();\n            \$table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();\n            \$table->string('nama_lokasi');\n            \$table->text('alamat');\n            \$table->timestamps();",
    'create_pekerjaans_table' => "\$table->id();\n            \$table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();\n            \$table->foreignId('lokasi_id')->constrained('lokasis')->cascadeOnDelete();\n            \$table->string('nama_pekerjaan');\n            \$table->date('tanggal');\n            \$table->timestamps();",
    'create_laporans_table' => "\$table->id();\n            \$table->foreignId('pekerjaan_id')->constrained('pekerjaans')->cascadeOnDelete();\n            \$table->foreignId('user_id')->constrained('users')->cascadeOnDelete();\n            \$table->date('tanggal');\n            \$table->enum('status', ['draft', 'dikirim', 'disetujui'])->default('draft');\n            \$table->timestamps();",
    'create_fotos_table' => "\$table->id();\n            \$table->foreignId('laporan_id')->constrained('laporans')->cascadeOnDelete();\n            \$table->enum('tipe', ['before', 'after']);\n            \$table->string('file_path');\n            \$table->string('gps')->nullable();\n            \$table->timestamp('timestamp')->useCurrent();\n            \$table->timestamps();",
    'create_pencairans_table' => "\$table->id();\n            \$table->foreignId('laporan_id')->constrained('laporans')->cascadeOnDelete();\n            \$table->date('tanggal_cair')->nullable();\n            \$table->string('status')->default('pending');\n            \$table->timestamps();",
    'create_notifikasis_table' => "\$table->id();\n            \$table->foreignId('user_id')->constrained('users')->cascadeOnDelete();\n            \$table->text('pesan');\n            \$table->timestamp('tanggal')->useCurrent();\n            \$table->boolean('status_baca')->default(false);\n            \$table->timestamps();"
];

foreach ($files as $file) {
    foreach ($replacements as $key => $rep) {
        if (strpos($file, $key) !== false) {
            $content = file_get_contents($file);
            $pattern = '/\$table->id\(\);(.*)\$table->timestamps\(\);/ms';
            $content = preg_replace($pattern, $rep, $content);
            file_put_contents($file, $content);
            echo 'Updated ' . $file . "\n";
        }
    }
}
