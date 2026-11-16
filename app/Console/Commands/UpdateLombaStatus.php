<?php

namespace App\Console\Commands;

use App\Models\Lomba;
use Illuminate\Console\Command;

class UpdateLombaStatus extends Command
{
    /**
     * Nama dan signature perintah artisan.
     *
     * @var string
     */
    protected $signature = 'lomba:update-status';

    /**
     * Deskripsi perintah.
     *
     * @var string
     */
    protected $description = 'Menutup otomatis status lomba yang masa pendaftarannya telah kadaluarsa';

    /**
     * Jalankan perintah.
     */
    public function handle(): int
    {
        $today = now()->startOfDay();

        // Lomba yang deadline-nya sudah lewat dan statusnya belum ditutup.
        $expired = Lomba::whereDate('deadline', '<', $today)
            ->where('status', '!=', Lomba::STATUS_DITUTUP)
            ->get();

        if ($expired->isEmpty()) {
            $this->info('Tidak ada lomba yang perlu ditutup.');

            return self::SUCCESS;
        }

        foreach ($expired as $lomba) {
            $lomba->update(['status' => Lomba::STATUS_DITUTUP]);

            $this->line('Ditutup: ' . $lomba->nama);
        }

        $this->info($expired->count() . ' lomba berhasil ditutup otomatis.');

        return self::SUCCESS;
    }
}
