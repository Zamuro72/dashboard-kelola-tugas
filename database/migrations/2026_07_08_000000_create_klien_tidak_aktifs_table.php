<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klien_tidak_aktifs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('tipe_klien', ['Personal', 'Perusahaan']);
            $table->year('tahun');
            
            // Data Personal
            $table->string('nama_klien')->nullable();
            $table->date('tanggal_lahir')->nullable();
            
            // Data Perusahaan
            $table->string('nama_perusahaan')->nullable();
            $table->string('nama_penanggung_jawab')->nullable();
            
            // Data Umum
            $table->string('email')->nullable();
            $table->string('no_whatsapp')->nullable();
            
            // Status
            $table->enum('status', ['ongoing proses deal', 'belum jelas', 'follow up']);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klien_tidak_aktifs');
    }
};
