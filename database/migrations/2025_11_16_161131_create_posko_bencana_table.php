<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posko_bencana', function (Blueprint $table) {
            $table->id('posko_id');
            $table->foreignId('kejadian_id')
                  ->constrained('kejadian_bencana')
                  ->onDelete('cascade');
            $table->string('nama');
            $table->string('alamat');
            $table->string('kontak');
            $table->string('penanggung_jawab');
            $table->string('foto')->nullable(); // media posko_bencana
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posko_bencana');
    }
};
