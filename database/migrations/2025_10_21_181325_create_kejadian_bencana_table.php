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
        Schema::create('kejadian_bencana', function (Blueprint $table) {
        $table->id('kejadian_id');
        $table->string('jenis_bencana');
        $table->date('tanggal');
        $table->string('lokasi_text');
        $table->string('rt', 10)->nullable();
        $table->string('rw', 10)->nullable();
        $table->string('dampak')->nullable();
        $table->enum('status_kejadian', ['aktif', 'selesai', 'dalam_penanganan']);
        $table->text('keterangan')->nullable();
        $table->string('media')->nullable(); // untuk path file foto/berita acara
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
