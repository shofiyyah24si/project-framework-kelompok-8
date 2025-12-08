<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posko_bencana', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('penanggung_jawab');
        });
    }

    public function down()
    {
        Schema::table('posko_bencana', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};
