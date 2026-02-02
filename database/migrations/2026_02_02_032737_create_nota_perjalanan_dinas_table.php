<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nota_perjalanan_dinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama');
            $table->string('jabatan');
            $table->string('unit_kerja');
            $table->date('tanggal_berangkat');
            $table->time('jam_berangkat');
            $table->date('tanggal_kembali');
            $table->time('jam_kembali');
            $table->text('tujuan_keperluan');
            
            // Detail biaya (JSON untuk menyimpan array baris)
            $table->json('detail_biaya')->nullable();
            
            // Perhitungan (tanpa desimal - pakai bigInteger untuk rupiah)
            $table->bigInteger('sub_total_biaya')->default(0);
            $table->integer('km_kendaraan')->default(0);
            $table->bigInteger('km_x_rp')->default(0);
            $table->integer('uang_saku_hari')->default(0);
            $table->bigInteger('hari_x_rp')->default(0);
            $table->bigInteger('sub_total')->default(0);
            $table->bigInteger('potongan_uang_muka')->default(0);
            $table->bigInteger('total')->default(0);
            
            $table->string('lokasi_pengajuan')->default('Jakarta');
            $table->date('tanggal_pengajuan');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nota_perjalanan_dinas');
    }
};