<?php
// database/migrations/2025_12_01_000000_create_donasi_bencana_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donasi_bencana', function (Blueprint $table) {
            $table->id('donasi_id');
            $table->unsignedBigInteger('kejadian_id');
            $table->string('donatur_nama', 255);
            $table->string('jenis', 100);
            $table->decimal('nilai', 15, 2);
            $table->string('bukti_donasi')->nullable();
            $table->text('keterangan')->nullable();
            $table->date('tanggal_donasi');
            $table->string('metode_pembayaran', 100)->nullable();
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->timestamps();

            $table->foreign('kejadian_id')
                  ->references('kejadian_id')
                  ->on('kejadian_bencana')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donasi_bencana');
    }
};