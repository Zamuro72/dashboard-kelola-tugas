<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('pesertas', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->string('nama');
            $table->string('nama_perusahaan');
            $table->string('no_whatsapp');
            $table->date('tanggal_lahir');
            $table->string('skema');
            $table->date('tanggal_sertifikat_diterima');
            $table->boolean('suka_telat_bayar')->default(false);
            $table->timestamps();
            
            $table->index('tahun');
            $table->index('tanggal_sertifikat_diterima');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesertas');
    }
};
