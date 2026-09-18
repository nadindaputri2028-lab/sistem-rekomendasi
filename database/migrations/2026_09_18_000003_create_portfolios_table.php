<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('portfolios', function(Blueprint $table){
   $table->id(); $table->foreignId('mahasiswa_id')->constrained()->cascadeOnDelete();
   $table->string('nama_kegiatan'); $table->string('posisi')->nullable(); $table->string('organisasi')->nullable();
   $table->date('periode_mulai')->nullable(); $table->date('periode_selesai')->nullable();
   $table->text('deskripsi')->nullable(); $table->string('bukti')->nullable(); $table->timestamps();
  });
 }
 public function down(): void { Schema::dropIfExists('portfolios'); }
};
