<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kejadian_files', function (Blueprint $table) {
            if (!Schema::hasColumn('kejadian_files', 'deleted_at')) {
                $table->softDeletes(); // menambah kolom deleted_at
            }
        });
    }

    public function down(): void
    {
        Schema::table('kejadian_files', function (Blueprint $table) {
            if (Schema::hasColumn('kejadian_files', 'deleted_at')) {
                $table->dropColumn('deleted_at');
            }
        });
    }
};
