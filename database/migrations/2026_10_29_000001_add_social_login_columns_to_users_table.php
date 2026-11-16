<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom login sosial (Google & LinkedIn) pada tabel users
     * serta membuat kolom password menjadi nullable (untuk SSO).
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable()->unique();
            $table->text('google_token')->nullable();
            $table->text('google_refresh_token')->nullable();
            $table->string('linkedin_id')->nullable()->unique();
            $table->text('linkedin_token')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable(false)->change();
            $table->dropColumn([
                'google_id',
                'google_token',
                'google_refresh_token',
                'linkedin_id',
                'linkedin_token',
            ]);
        });
    }
};
