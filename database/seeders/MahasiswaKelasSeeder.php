<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use RuntimeException;

class MahasiswaKelasSeeder extends Seeder
{
    public function run(): void
    {
        $daftarMahasiswa = [
            ['Abrahamsyah', '2501301057', 3.85],
            ['Ahmad Arif Hidayat', '2501301091', 3.90],
            ['Ani Kusuma Ning Tias', '2501301005', 3.88],
            ['Betanael Mandrus Dw itomo', '2501301029', 3.82],
            ['Ike Nur Hidayah', '2501301088', 3.84],
            ['Melda Sari', '2501301059', 3.90],
            ['Meylyn Pratama Putri', '2501301056', 3.86],
            ['Muhammad Aditia Rahmadani', '2501301038', 3.92],
            ['Muhammad Akmal Rabbani', '2501301090', 3.89],
            ['Muhammad Khusyairi', '2501301051', 3.90],
            ["Muhammad Mushlih Da'i", '2501301004', 3.87],
            ['Muhammad Nadhir Akbar', '2501301082', 3.85],
            ['Mutia Rikma', '2501301033', 3.88],
            ['Nadia Mahfuzah', '2501301024', 3.91],
            ['Nadia Pratiwi', '2501301034', 3.94],
            ['Nor Ihsan Dwis etya Harjo', '2501301014', 3.83],
            ['Nur Hikmah Suciyanti', '2501301037', 3.92],
            ['Rabiatul Adawiah', '2501301015', 3.84],
            ['Rama Dhani Mahardhika', '2501301048', 3.90],
            ['Rendy Dwi Sapta Kusuma', '2501301089', 3.95],
            ['Risya Aulia Putri', '2501301083', 3.88],
            ['Siti Nur Annisa', '2501301040', 3.87],
            ['Vinny Azura Ramadhani', '2501301081', 3.93],
            ['Wahidah', '2501301079', 3.82],
            ['Muhammad Ali Yafi', '2501301052', 3.88],
        ];

        DB::transaction(function () use ($daftarMahasiswa) {
            foreach ($daftarMahasiswa as [$nama, $nim, $ipk]) {

                $email = Str::slug($nama, '') . '25@mhs.politala.ac.id';

                // Cari data mahasiswa berdasarkan NIM.
                $mahasiswa = Mahasiswa::where('nim', $nim)->first();

                // Gunakan akun lama jika sudah terhubung.
                $user = $mahasiswa?->user;

                // Jika belum terhubung, cari berdasarkan email.
                if (!$user) {
                    $user = User::where('email', $email)->first();
                }

                // Buat akun jika belum tersedia.
                if (!$user) {
                    $user = User::create([
                        'name' => $nama,
                        'email' => $email,
                        'password' => Hash::make($nim),
                        'role' => 'mahasiswa',
                    ]);
                } else {
                    if ($user->role !== 'mahasiswa') {
                        throw new RuntimeException(
                            "Email {$email} sudah digunakan akun non-mahasiswa."
                        );
                    }

                    $user->update([
                        'name' => $nama,
                        'email' => $email,
                    ]);
                }

                $dataMahasiswa = [
                    'user_id' => $user->id,
                    'nama_lengkap' => $nama,
                    'nim' => $nim,
                    'prodi' => 'Teknologi Informasi',
                    'semester' => 3,
                    'email' => $email,
                    'ipk' => $ipk,
                ];

                // Isi is_active hanya jika kolomnya tersedia.
                if (Schema::hasColumn('mahasiswas', 'is_active')) {
                    $dataMahasiswa['is_active'] = true;
                }

                Mahasiswa::updateOrCreate(
                    ['nim' => $nim],
                    $dataMahasiswa
                );
            }
        });

        $this->command->info('Berhasil memproses 25 data mahasiswa.');
    }
}
