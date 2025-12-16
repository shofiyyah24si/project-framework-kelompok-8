<?php
// database/migrations/2025_12_01_000001_create_logistik_bencana_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logistik_bencana', function (Blueprint $table) {
            $table->id('logistik_id');
            $table->unsignedBigInteger('kejadian_id');
            $table->string('nama_barang', 255);
            $table->string('satuan', 50);
            $table->integer('stok');
            $table->string('sumber', 255);
            $table->text('keterangan')->nullable();
            $table->date('tanggal_masuk');
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->enum('status', ['tersedia', 'dipinjam', 'habis', 'kadaluarsa'])->default('tersedia');
            $table->timestamps();

            $table->foreign('kejadian_id')
                  ->references('kejadian_id')
                  ->on('kejadian_bencana')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logistik_bencana');
    }
};