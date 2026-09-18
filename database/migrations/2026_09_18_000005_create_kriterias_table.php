<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('kriterias', function(Blueprint $table){
   $table->id(); $table->foreignId('lomba_id')->constrained()->cascadeOnDelete();
   $table->string('kode',10); $table->string('nama'); $table->decimal('bobot',8,4)->default(0);
   $table->enum('jenis',['benefit','cost'])->default('benefit'); $table->decimal('nilai_minimum',8,2)->default(0);
   $table->text('deskripsi')->nullable(); $table->timestamps();
  });
 }
 public function down(): void { Schema::dropIfExists('kriterias'); }
};
