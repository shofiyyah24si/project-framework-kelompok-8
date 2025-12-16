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
        Schema::create('kejadian_files', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('kejadian_id')->index();
            $table->string('nama_file');
            $table->string('tipe')->nullable(); // png, jpg, mp4, pdf, dll

            $table->timestamps();
            $table->softDeletes(); // untuk mendukung fitur SoftDeletes di model

            $table->foreign('kejadian_id')
                ->references('kejadian_id')
                ->on('kejadian_bencana')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kejadian_files');
    }
};
