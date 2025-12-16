<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('posko_bencana', function (Blueprint $table) {
    $table->id('posko_id');

    $table->unsignedBigInteger('kejadian_id'); // FK
    $table->foreign('kejadian_id')
          ->references('kejadian_id')
          ->on('kejadian_bencana')
          ->onDelete('cascade')
          ->onUpdate('cascade');

    $table->string('nama');
    $table->string('alamat');
    $table->string('kontak');
    $table->string('penanggung_jawab');
    $table->string('foto')->nullable();
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('posko_bencana');
    }
};
