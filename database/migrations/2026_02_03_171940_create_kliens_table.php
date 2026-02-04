<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kliens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jasa_id')->constrained('jasa')->onDelete('cascade');
            $table->foreignId('skema_id')->nullable()->constrained('skema')->onDelete('cascade');
            $table->year('tahun');
            $table->enum('tipe_klien', ['Personal', 'Perusahaan']);
            
            // Data Personal
            $table->string('nama_klien')->nullable();
            
            // Data Perusahaan
            $table->string('nama_perusahaan')->nullable();
            $table->string('nama_penanggung_jawab')->nullable();
            
            // Data Umum
            $table->string('email')->nullable();
            $table->string('no_whatsapp')->nullable();
            $table->date('sertifikat_terbit')->nullable();
            
            $table->timestamps();
            
            $table->index(['user_id', 'jasa_id', 'tahun']);
            $table->index('sertifikat_terbit');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kliens');
    }
};