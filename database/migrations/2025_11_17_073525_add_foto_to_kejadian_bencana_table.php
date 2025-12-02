<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kejadian_bencana', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('lokasi_text');
        });
    }

    public function down()
    {
        Schema::table('kejadian_bencana', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};
