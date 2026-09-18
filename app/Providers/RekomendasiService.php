<?php

namespace App\Services;

use App\Models\Lomba;
use App\Models\Mahasiswa;
use App\Models\Rekomendasi;

class RekomendasiService
{
    public function calculate(Lomba $lomba): array
    {
        $criteria = $lomba->kriterias()->orderBy('id')->get();
        $students = Mahasiswa::with('portfolios')->get();

        if ($criteria->isEmpty() || $students->isEmpty()) {
            return [];
        }

        // AHP: bobot kriteria dari nilai bobot yang dimasukkan admin.
        // Matriks perbandingan dibentuk dengan rasio bobot sehingga konsisten.
        $rawWeights = $criteria->pluck('bobot')->map(fn($v) => max((float)$v, 0.0001))->all();
        $sum = array_sum($rawWeights);
        $weights = array_map(fn($v) => $v / $sum, $rawWeights);

        // CI/CR untuk matriks rasio bobot. Matriks ini konsisten secara matematis.
        $n = count($weights);
        $ci = 0.0;
        $cr = 0.0;

        $riTable = [1=>0,2=>0,3=>0.58,4=>0.90,5=>1.12,6=>1.24,7=>1.32,8=>1.41,9=>1.45,10=>1.49];
        if ($n > 2 && isset($riTable[$n])) {
            $cr = 0.0;
        }

        $matrix = [];
        foreach ($weights as $i => $wi) {
            $matrix[$i] = [];
            foreach ($weights as $j => $wj) {
                $matrix[$i][$j] = $wi / $wj;
            }
        }

        $rows = [];
        foreach ($students as $student) {
            $raw = [];
            foreach ($criteria as $criterion) {
                $raw[$criterion->id] = $this->criterionValue($student, $criterion->nama);
            }

            $normalized = [];
            foreach ($criteria as $criterion) {
                $values = $students->map(fn($s) => $this->criterionValue($s, $criterion->nama))->all();
                $x = $raw[$criterion->id];
                if ($criterion->jenis === 'cost') {
                    $positive = array_values(array_filter($values, fn($v) => $v > 0));
                    $min = $positive ? min($positive) : 0;
                    $r = $x > 0 && $min > 0 ? $min / $x : 0;
                } else {
                    $max = max($values ?: [0]);
                    $r = $max > 0 ? $x / $max : 0;
                }
                $normalized[$criterion->id] = $r;
            }

            $score = 0;
            foreach ($criteria as $index => $criterion) {
                $score += $weights[$index] * $normalized[$criterion->id];
            }

            $rows[] = [
                'mahasiswa' => $student,
                'score' => $score,
                'raw' => $raw,
                'normalized' => $normalized,
            ];
        }

        usort($rows, fn($a,$b) => $b['score'] <=> $a['score']);

        foreach ($rows as $index => &$row) {
            $row['ranking'] = $index + 1;
            $row['status'] = $row['score'] >= 0.75 ? 'Direkomendasikan'
                : ($row['score'] >= 0.55 ? 'Dipertimbangkan' : 'Tidak Direkomendasikan');

            Rekomendasi::updateOrCreate(
                ['lomba_id'=>$lomba->id,'mahasiswa_id'=>$row['mahasiswa']->id],
                [
                    'nilai_akhir'=>$row['score'],
                    'ranking'=>$row['ranking'],
                    'status'=>$row['status'],
                    'detail_nilai'=>[
                        'bobot_ahp'=>$weights,
                        'normalisasi'=>$row['normalized'],
                        'nilai_kriteria'=>$row['raw'],
                        'ci'=>$ci,
                        'cr'=>$cr,
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

    private function criterionValue(Mahasiswa $m, string $name): float
    {
        $name = strtolower($name);

        return match (true) {
            str_contains($name, 'ipk') => (float) ($m->ipk ?? 0),
            str_contains($name, 'ips') => (float) ($m->ips ?? 0),
            str_contains($name, 'semester') => (float) ($m->semester ?? 0),
            str_contains($name, 'prestasi') => $this->countTextItems($m->prestasi),
            str_contains($name, 'keahlian'), str_contains($name, 'skill') => $this->countTextItems($m->keahlian),
            str_contains($name, 'minat') => $this->countTextItems($m->minat),
            str_contains($name, 'pengalaman'), str_contains($name, 'portfolio') => (float) $m->portfolios->count(),
            str_contains($name, 'prodi'), str_contains($name, 'program studi') => $m->prodi ? 1 : 0,
            default => 0,
        };
    }

    private function countTextItems(?string $text): float
    {
        if (!$text) return 0;
        return count(array_filter(preg_split('/[,;\n]+/', $text)));
    }
}
