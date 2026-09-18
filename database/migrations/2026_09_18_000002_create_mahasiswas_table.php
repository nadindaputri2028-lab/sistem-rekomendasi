<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('mahasiswas', function(Blueprint $table){
   $table->id(); $table->foreignId('user_id')->nullable()->unique()->constrained()->nullOnDelete();
   $table->string('nama_lengkap'); $table->string('nim')->unique(); $table->string('prodi');
   $table->unsignedTinyInteger('semester'); $table->string('email'); $table->string('no_hp')->nullable();
   $table->decimal('ipk',3,2)->nullable(); $table->decimal('ips',3,2)->nullable();
   $table->string('foto')->nullable(); $table->text('prestasi')->nullable(); $table->text('keahlian')->nullable(); $table->text('minat')->nullable();
   $table->timestamps();
  });
 }
 public function down(): void { Schema::dropIfExists('mahasiswas'); }
};
