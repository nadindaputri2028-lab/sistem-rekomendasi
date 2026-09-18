<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('pendaftarans', function(Blueprint $table){
   $table->id(); $table->foreignId('mahasiswa_id')->constrained()->cascadeOnDelete(); $table->foreignId('lomba_id')->constrained()->cascadeOnDelete();
   $table->string('status')->default('Menunggu'); $table->text('catatan')->nullable(); $table->date('tanggal_daftar'); $table->timestamps();
   $table->unique(['mahasiswa_id','lomba_id']);
  });
 }
 public function down(): void { Schema::dropIfExists('pendaftarans'); }
};
