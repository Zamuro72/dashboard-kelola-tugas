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
        Schema::table('pesertas', function (Blueprint $table) {
            $table->string('nama_perusahaan')->nullable()->change();
            $table->string('no_whatsapp')->nullable()->change();
            $table->date('tanggal_lahir')->nullable()->change();
            $table->string('skema')->nullable()->change();
            $table->date('tanggal_sertifikat_diterima')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {
            $table->string('nama_perusahaan')->nullable(false)->change();
            $table->string('no_whatsapp')->nullable(false)->change();
            $table->date('tanggal_lahir')->nullable(false)->change();
            $table->string('skema')->nullable(false)->change();
            $table->date('tanggal_sertifikat_diterima')->nullable(false)->change();
        });
    }
};
