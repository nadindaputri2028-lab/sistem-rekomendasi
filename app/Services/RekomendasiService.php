<?php

namespace App\Services;

use App\Models\Lomba;
use App\Models\Mahasiswa;
use App\Models\Rekomendasi;

class RekomendasiService
{
    public function calculate(Lomba $lomba): array
    {
        // Ambil kriteria berdasarkan lomba
        $criteria = $lomba->kriterias()
            ->orderBy('id')
            ->get();

        // Ambil seluruh mahasiswa aktif beserta portfolio
        $students = Mahasiswa::with('portfolios')
            ->where('is_active', true)
            ->get();

        // Jika kriteria atau mahasiswa belum tersedia
        if ($criteria->isEmpty() || $students->isEmpty()) {
            return [];
        }

        /*
        |--------------------------------------------------------------------------
        | AHP
        |--------------------------------------------------------------------------
        |
        | Bobot kriteria yang sudah dimasukkan staff digunakan
        | sebagai dasar pembobotan.
        |
        */

        $rawWeights = $criteria
            ->pluck('bobot')
            ->map(fn ($v) => max((float) $v, 0.0001))
            ->all();

        $sum = array_sum($rawWeights);

        $weights = array_map(
            fn ($v) => $v / $sum,
            $rawWeights
        );

        /*
        |--------------------------------------------------------------------------
        | Consistency Index dan Consistency Ratio
        |--------------------------------------------------------------------------
        */

        $n = count($weights);

        $ci = 0.0;
        $cr = 0.0;

        $riTable = [
            1 => 0,
            2 => 0,
            3 => 0.58,
            4 => 0.90,
            5 => 1.12,
            6 => 1.24,
            7 => 1.32,
            8 => 1.41,
            9 => 1.45,
            10 => 1.49,
        ];

        if ($n > 2 && isset($riTable[$n])) {
            $cr = 0.0;
        }

        /*
        |--------------------------------------------------------------------------
        | Matriks Perbandingan AHP
        |--------------------------------------------------------------------------
        */

        $matrix = [];

        foreach ($weights as $i => $wi) {
            $matrix[$i] = [];

            foreach ($weights as $j => $wj) {
                $matrix[$i][$j] = $wi / $wj;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SAW
        |--------------------------------------------------------------------------
        */

        $rows = [];

        foreach ($students as $student) {

            $raw = [];

            // Ambil nilai masing-masing kriteria mahasiswa
            foreach ($criteria as $criterion) {

                $raw[$criterion->id] =
                    $this->criterionValue(
                        $student,
                        $criterion->nama
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | Normalisasi
            |--------------------------------------------------------------------------
            */

            $normalized = [];

            foreach ($criteria as $criterion) {

                // Ambil seluruh nilai mahasiswa untuk kriteria tersebut
                $values = $students
                    ->map(
                        fn ($s) => $this->criterionValue(
                            $s,
                            $criterion->nama
                        )
                    )
                    ->all();

                $x = $raw[$criterion->id];

                /*
                |--------------------------------------------------------------------------
                | Batas Nilai Minimum (Syarat Lomba)
                |--------------------------------------------------------------------------
                |
                | Jika nilai mahasiswa berada di bawah nilai minimum
                | yang ditetapkan staff, maka kontribusi kriteria ini
                | dinolkan (mahasiswa tidak memenuhi syarat).
                |
                */

                $minimum = (float) ($criterion->nilai_minimum ?? 0);

                if ($minimum > 0 && $x < $minimum) {

                    $normalized[$criterion->id] = 0.0;

                    continue;
                }

                // Cost
                if ($criterion->jenis === 'cost') {

                    $positive = array_values(
                        array_filter(
                            $values,
                            fn ($v) => $v > 0
                        )
                    );

                    $min = $positive
                        ? min($positive)
                        : 0;

                    $r = (
                        $x > 0 &&
                        $min > 0
                    )
                        ? $min / $x
                        : 0;

                } else {

                    // Benefit
                    $max = max($values ?: [0]);

                    $r = $max > 0
                        ? $x / $max
                        : 0;
                }

                $normalized[$criterion->id] = $r;
            }

            /*
            |--------------------------------------------------------------------------
            | Nilai Akhir SAW
            |--------------------------------------------------------------------------
            */

            $score = 0;

            foreach ($criteria as $index => $criterion) {

                $score +=
                    $weights[$index]
                    * $normalized[$criterion->id];
            }

            /*
            |--------------------------------------------------------------------------
            | Persentase Kecocokan (Match Score)
            |--------------------------------------------------------------------------
            |
            | Dibandingkan data kriteria mahasiswa dengan syarat
            | (nilai minimum) tiap kriteria lomba.
            |
            */

            $match = $this->matchScore(
                $student,
                $lomba
            );

            $rows[] = [
                'mahasiswa' => $student,
                'score' => $score,
                'raw' => $raw,
                'normalized' => $normalized,
                'match_score' => $match['score'],
                'eligible' => $match['eligible'],
                'match_detail' => $match['details'],
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Ranking
        |--------------------------------------------------------------------------
        */

        usort(
            $rows,
            fn ($a, $b) =>
                $b['score'] <=> $a['score']
        );

        /*
        |--------------------------------------------------------------------------
        | Simpan Hasil Rekomendasi
        |--------------------------------------------------------------------------
        */

        foreach ($rows as $index => &$row) {

            $row['ranking'] = $index + 1;

            if ($row['score'] >= 0.75) {

                $row['status'] = 'Direkomendasikan';

            } elseif ($row['score'] >= 0.55) {

                $row['status'] = 'Dipertimbangkan';

            } else {

                $row['status'] = 'Tidak Direkomendasikan';
            }

            /*
            |--------------------------------------------------------------------------
            | updateOrCreate
            |--------------------------------------------------------------------------
            |
            | Jika hasil rekomendasi untuk mahasiswa + lomba sudah ada,
            | datanya diperbarui.
            |
            | Jika belum ada, data baru dibuat.
            |
            | Tidak menghapus data mahasiswa, lomba, portfolio,
            | maupun pendaftaran.
            |
            */

            Rekomendasi::updateOrCreate(
                [
                    'lomba_id' => $lomba->id,
                    'mahasiswa_id' => $row['mahasiswa']->id,
                ],
                [
                    'nilai_akhir' => $row['score'],
                    'ranking' => $row['ranking'],
                    'status' => $row['status'],
                    'detail_nilai' => [
                        'bobot_ahp' => $weights,
                        'normalisasi' => $row['normalized'],
                        'nilai_kriteria' => $row['raw'],
                        'match_score' => $row['match_score'],
                        'eligible' => $row['eligible'],
                        'match_detail' => $row['match_detail'],
                        'ci' => $ci,
                        'cr' => $cr,
                    ],
                ]
            );
        }

        return [
            'rows' => $rows,
            'weights' => $weights,
            'criteria' => $criteria,
            'ci' => $ci,
            'cr' => $cr,
            'matrix' => $matrix,
        ];
    }

    /**
     * Menghitung Persentase Kecocokan (Match Score) antara
     * data kriteria mahasiswa dengan syarat (nilai minimum) lomba.
     *
     * Mengembalikan array:
     *  - score    : persentase kecocokan 0 - 100
     *  - eligible : true bila SEMUA syarat nilai minimum terpenuhi
     *  - details  : rincian per kriteria
     */
    public function matchScore(
        Mahasiswa $mahasiswa,
        Lomba $lomba
    ): array {

        $criteria = $lomba->kriterias()
            ->orderBy('id')
            ->get();

        if ($criteria->isEmpty()) {
            return [
                'score' => 0.0,
                'eligible' => false,
                'details' => [],
            ];
        }

        $totalRatio = 0.0;
        $met = 0;
        $details = [];

        foreach ($criteria as $criterion) {

            $value = $this->criterionValue(
                $mahasiswa,
                $criterion->nama
            );

            $minimum = (float) ($criterion->nilai_minimum ?? 0);

            if ($minimum <= 0) {

                // Tidak ada syarat minimum -> dianggap terpenuhi
                $ratio = 1.0;

            } elseif ($value >= $minimum) {

                $ratio = 1.0;

            } else {

                // Partial credit untuk nilai di bawah syarat
                $ratio = $minimum > 0
                    ? ($value / $minimum)
                    : 0.0;
            }

            if ($ratio >= 1.0) {
                $met++;
            }

            $totalRatio += $ratio;

            $details[$criterion->id] = [
                'kode' => $criterion->kode,
                'nama' => $criterion->nama,
                'nilai' => $value,
                'nilai_minimum' => $minimum,
                'terpenuhi' => $ratio >= 1.0,
            ];
        }

        return [
            'score' => round(
                ($totalRatio / $criteria->count()) * 100,
                2
            ),
            'eligible' => $met === $criteria->count(),
            'details' => $details,
        ];
    }

    /**
     * Mengambil nilai mahasiswa berdasarkan nama kriteria.
     */
    private function criterionValue(
        Mahasiswa $m,
        string $name
    ): float {

        $name = strtolower($name);

        return match (true) {

            str_contains($name, 'ipk') =>
                (float) ($m->ipk ?? 0),

            str_contains($name, 'ips') =>
                (float) ($m->ips ?? 0),

            str_contains($name, 'semester') =>
                (float) ($m->semester ?? 0),

            str_contains($name, 'prestasi') =>
                $this->countTextItems($m->prestasi),

            str_contains($name, 'keahlian'),
            str_contains($name, 'skill') =>
                $this->countTextItems($m->keahlian),

            str_contains($name, 'minat') =>
                $this->countTextItems($m->minat),

            str_contains($name, 'pengalaman'),
            str_contains($name, 'portfolio') =>
                (float) $m->portfolios->count(),

            str_contains($name, 'prodi'),
            str_contains($name, 'program studi') =>
                $m->prodi ? 1 : 0,

            default => 0,
        };
    }

    /**
     * Menghitung jumlah item dari data teks.
     *
     * Contoh:
     * "Basket, Coding, Desain"
     * akan dihitung menjadi 3.
     */
    private function countTextItems(
        ?string $text
    ): float {

        if (!$text) {
            return 0;
        }

        return count(
            array_filter(
                preg_split('/[,;\n]+/', $text)
            )
        );
    }
}