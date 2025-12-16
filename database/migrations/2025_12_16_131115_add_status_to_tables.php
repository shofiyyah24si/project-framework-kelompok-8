<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cek dulu apakah tabel punya kolom tertentu
        Schema::table('kejadian_bencana', function (Blueprint $table) {
            // HAPUS 'after()' atau ganti dengan kolom yang benar-benar ada
            $table->enum('status', ['aktif', 'selesai', 'draft'])
                  ->default('aktif');
                  // HAPUS ->after('deskripsi') karena kolom tidak ada
        });
        
        // Tambah ke posko_bencana juga
        Schema::table('posko_bencana', function (Blueprint $table) {
            $table->enum('status', ['aktif', 'tutup', 'penuh'])
                  ->default('aktif');
                  // HAPUS ->after('alamat') jika kolom tidak ada
        });
        
        // Update data yang sudah ada
        DB::table('kejadian_bencana')->update(['status' => 'aktif']);
        DB::table('posko_bencana')->update(['status' => 'aktif']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kejadian_bencana', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('posko_bencana', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};