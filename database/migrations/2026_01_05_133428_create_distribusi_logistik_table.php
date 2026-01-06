<?php
// database/migrations/xxxx_xx_xx_create_distribusi_logistik_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('distribusi_logistik', function (Blueprint $table) {
            $table->id('distribusi_id');
            $table->unsignedBigInteger('logistik_id');
            $table->unsignedBigInteger('posko_id');
            $table->date('tanggal');
            $table->integer('jumlah');
            $table->string('penerima', 100);
            $table->string('bukti_distribusi')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('logistik_id')->references('logistik_id')->on('logistik')->onDelete('cascade');
            $table->foreign('posko_id')->references('posko_id')->on('posko')->onDelete('cascade');

            // Indexes
            $table->index('tanggal');
            $table->index(['logistik_id', 'posko_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('distribusi_logistik');
    }
};