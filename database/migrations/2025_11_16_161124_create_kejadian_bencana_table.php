<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kejadian_bencana', function (Blueprint $table) {
            $table->id('kejadian_id');
            $table->string('jenis_bencana');
            $table->date('tanggal');
            $table->string('lokasi_text');
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('dampak')->nullable();
            $table->string('status_kejadian')->default('Baru');
            $table->text('keterangan')->nullable();
            $table->string('foto')->nullable(); // media kejadian_bencana
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kejadian_bencana');
    }
};
