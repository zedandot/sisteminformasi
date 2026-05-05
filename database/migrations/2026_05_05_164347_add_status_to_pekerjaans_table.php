<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pekerjaans', function (Blueprint $table) {
            $table->enum('status', ['Aktif', 'Selesai', 'Pending'])->default('Aktif')->after('tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pekerjaans', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
