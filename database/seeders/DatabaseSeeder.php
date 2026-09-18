<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Lomba;
use App\Models\Kriteria;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin=User::updateOrCreate(['email'=>'admin@politala.ac.id'],['name'=>'Admin Akademik','password'=>Hash::make('admin123'),'role'=>'staff']);

        $samples=[
            ['Olivia Rodrigo','2301301001','Teknologi Informasi',5,'oliviarodrigo@kampus.ac.id',3.85,3.90,'Pemrograman, UI/UX, Web','Teknologi, desain','Frontend Developer Intern, Juara 1 Kompetisi Nasional'],
            ['Nadin Putri','2301301002','Teknologi Informasi',5,'nadin@kampus.ac.id',3.75,3.80,'PHP, Laravel, Database','Software engineering','Peserta lomba pemrograman'],
            ['Justin Bieber','2301301003','Teknik Informatika',4,'justin@kampus.ac.id',3.70,3.85,'Java, Algoritma','Coding, kompetisi','Finalis lomba pemrograman'],
            ['Bruno Mars','2301301004','Teknik Elektro',6,'bruno@kampus.ac.id',3.60,3.70,'Elektronika, IoT','IoT, robotika','Peserta lomba inovasi'],
            ['Billie Eilish','2301301005','Bisnis Digital',4,'billie@kampus.ac.id',3.55,3.65,'Marketing, desain','Business, creative','Juara desain poster'],
        ];
        foreach($samples as $s){
            $u=User::updateOrCreate(['email'=>$s[4]],['name'=>$s[0],'password'=>Hash::make('password'),'role'=>'mahasiswa']);
            $m=Mahasiswa::updateOrCreate(['nim'=>$s[1]],[
                'user_id'=>$u->id,'nama_lengkap'=>$s[0],'prodi'=>$s[2],'semester'=>$s[3],'email'=>$s[4],
                'ipk'=>$s[5],'ips'=>$s[6],'keahlian'=>$s[7],'minat'=>$s[8],'prestasi'=>$s[9]
            ]);
            Portfolio::updateOrCreate(['mahasiswa_id'=>$m->id,'nama_kegiatan'=>'Pengalaman Kompetisi'],['posisi'=>'Peserta','organisasi'=>'Kampus','periode_mulai'=>'2025-01-01','periode_selesai'=>'2026-01-01','deskripsi'=>'Pengalaman kompetisi mahasiswa.']);
        }

        $lombas=[
            ['Gemastik 2026: Divisi Pemrograman','Akademik','Pemrograman','Universitas Indonesia','Nasional','2026-10-15','2026-09-30','Jakarta','Kompetisi pemrograman mahasiswa tingkat nasional.'],
            ['KIIBN 2026','Akademik','Business Plan','Politala','Nasional','2026-10-20','2026-10-01','Online','Kompetisi business plan mahasiswa.'],
            ['PIMNAS 2026','Akademik','Karya Tulis','Kemdiktisaintek','Nasional','2026-11-10','2026-10-10','Surabaya','Kompetisi karya ilmiah mahasiswa.'],
            ['Design Challenge 2026','Nonakademik','Desain','Creative Hub','Nasional','2026-10-05','2026-09-25','Online','Kompetisi desain kreatif mahasiswa.'],
        ];
        foreach($lombas as $i=>$l){
            $lomba=Lomba::updateOrCreate(['nama'=>$l[0]],['kategori'=>$l[1],'subkategori'=>$l[2],'penyelenggara'=>$l[3],'tingkat'=>$l[4],'tanggal_pelaksanaan'=>$l[5],'deadline'=>$l[6],'lokasi'=>$l[7],'deskripsi'=>$l[8],'persyaratan'=>'Mahasiswa aktif, sesuai ketentuan lomba.','benefit'=>'Sertifikat, pengalaman, dan kesempatan berprestasi.','status'=>'Aktif']);
            $criteria = [
                ['C1','IPK',30,'benefit'],['C2','Prestasi',25,'benefit'],['C3','Keahlian',20,'benefit'],['C4','Pengalaman',15,'benefit'],['C5','Minat',10,'benefit']
            ];
            foreach($criteria as $c) Kriteria::updateOrCreate(['lomba_id'=>$lomba->id,'kode'=>$c[0]],['nama'=>$c[1],'bobot'=>$c[2],'jenis'=>$c[3],'nilai_minimum'=>0]);
        }
    }
}
