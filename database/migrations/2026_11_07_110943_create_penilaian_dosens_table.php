
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian_dosens', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mahasiswa_id')
                ->constrained('mahasiswas')
                ->cascadeOnDelete();

            $table->foreignId('dosen_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('nilai_angka', 5, 2);

            $table->decimal('prestasi_akademik', 5, 2);
            $table->decimal('kedisiplinan', 5, 2);
            $table->decimal('keaktifan', 5, 2);
            $table->decimal('tanggung_jawab', 5, 2);
            $table->decimal('perkembangan_akademik', 5, 2);
            $table->decimal('konsultasi_akademik', 5, 2);
            $table->decimal('sikap_etika', 5, 2);

            $table->decimal('nilai_kriteria', 5, 2);
            $table->decimal('nilai_akhir', 5, 2);

            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_dosens');
    }
};
