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
        Schema::create('pengajuan_lemburs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('departemen');
            $table->date('tanggal_pelaksanaan');
            $table->string('hari');
            $table->time('jam_kerja_mulai');
            $table->time('jam_kerja_selesai');
            $table->time('jam_lembur_mulai');
            $table->time('jam_lembur_selesai');
            $table->decimal('total_jam_lembur', 5, 2);
            $table->string('lokasi');
            $table->text('uraian_pekerjaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_lemburs');
    }
};
