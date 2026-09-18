<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('rekomendasis', function(Blueprint $table){
   $table->id(); $table->foreignId('lomba_id')->constrained()->cascadeOnDelete(); $table->foreignId('mahasiswa_id')->constrained()->cascadeOnDelete();
   $table->decimal('nilai_akhir',10,6); $table->unsignedInteger('ranking'); $table->string('status'); $table->json('detail_nilai')->nullable(); $table->timestamps();
   $table->unique(['lomba_id','mahasiswa_id']);
  });
 }
 public function down(): void { Schema::dropIfExists('rekomendasis'); }
};
