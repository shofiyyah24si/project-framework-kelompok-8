<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->id('warga_id');
            $table->string('no_ktp')->unique();
            $table->string('nama');
            // 🔧 UBAH INI:
            // DARI: $table->enum('jenis_kelamin', ['L', 'P']);
            // MENJADI:
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            // ---------------------------------------
            $table->string('agama');
            $table->string('pekerjaan');
            $table->string('telp')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('warga');
    }
};