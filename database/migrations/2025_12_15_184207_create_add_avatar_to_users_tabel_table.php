<?php
// database/migrations/2025_11_20_000001_add_avatar_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('email')
                ->comment('Foto profil user');
            $table->timestamp('avatar_updated_at')->nullable()
                ->comment('Waktu terakhir update avatar');
            $table->string('avatar_disk')->default('public')
                ->comment('Storage disk untuk avatar');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'avatar_updated_at', 'avatar_disk']);
        });
    }
};