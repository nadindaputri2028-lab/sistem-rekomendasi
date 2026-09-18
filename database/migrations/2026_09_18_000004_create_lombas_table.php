<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('lombas', function(Blueprint $table){
   $table->id(); $table->string('nama'); $table->string('kategori'); $table->string('subkategori')->nullable();
   $table->string('penyelenggara'); $table->string('tingkat')->nullable(); $table->date('tanggal_pelaksanaan')->nullable();
   $table->date('deadline'); $table->string('lokasi')->nullable(); $table->text('deskripsi')->nullable();
   $table->text('persyaratan')->nullable(); $table->text('benefit')->nullable(); $table->string('panduan')->nullable();
   $table->string('status')->default('Aktif'); $table->timestamps();
  });
 }
 public function down(): void { Schema::dropIfExists('lombas'); }
};
