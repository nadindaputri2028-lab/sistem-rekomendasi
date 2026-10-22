<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            // Cek apakah kolom catatan belum ada
            if (!Schema::hasColumn('pendaftarans', 'catatan')) {
                $table->text('catatan')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            if (Schema::hasColumn('pendaftarans', 'catatan')) {
                $table->dropColumn('catatan');
            }
        });
    }
};