<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jasa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jasa');
            $table->boolean('has_skema')->default(false);
            $table->integer('masa_berlaku_tahun')->default(3); // 3 atau 5 tahun
            $table->timestamps();
        });

        // Insert default data
        DB::table('jasa')->insert([
            ['nama_jasa' => 'BNSP', 'has_skema' => true, 'masa_berlaku_tahun' => 3],
            ['nama_jasa' => 'Kemnaker RI', 'has_skema' => true, 'masa_berlaku_tahun' => 3],
            ['nama_jasa' => 'SMK3', 'has_skema' => false, 'masa_berlaku_tahun' => 3],
            ['nama_jasa' => 'SKK,SLO,SLF & SBU', 'has_skema' => false, 'masa_berlaku_tahun' => 5],
            ['nama_jasa' => 'ISO', 'has_skema' => true, 'masa_berlaku_tahun' => 3],
            ['nama_jasa' => 'Greenship & Edge', 'has_skema' => false, 'masa_berlaku_tahun' => 5],
            ['nama_jasa' => 'Uji Riksa', 'has_skema' => false, 'masa_berlaku_tahun' => 3],
            ['nama_jasa' => 'ANDALALIN', 'has_skema' => false, 'masa_berlaku_tahun' => 5],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('jasa');
    }
};