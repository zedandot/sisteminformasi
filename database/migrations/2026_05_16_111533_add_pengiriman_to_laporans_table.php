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
        Schema::table('laporans', function (Blueprint $table) {
            $table->enum('status_pengiriman_bap', ['belum_dikirim', 'sudah_dikirim'])->default('belum_dikirim');
            $table->date('tanggal_kirim_bap')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn(['status_pengiriman_bap', 'tanggal_kirim_bap']);
        });
    }
};
