<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skema', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jasa_id')->constrained('jasa')->onDelete('cascade');
            $table->string('nama_skema');
            $table->timestamps();
        });

        // Insert BNSP schemes
        $bnspId = DB::table('jasa')->where('nama_jasa', 'BNSP')->first()->id;
        $bnspSkema = [
            'PPPA & POPAL',
            'PPPU & POIPPU',
            'OPLB3 & MPLB3',
            'PCUA',
            'Auditor Energi',
            'Manajer Energi Industri & Bangunan Gedung',
            'Petugas P3K',
            'Ahli K3 Umum',
            'Ahli K3 Listrik',
            'Petugas Investigasi Insiden',
            'Pengkaji Teknis Proteksi Kebakaran',
            'Pengawas K3 Laboratorium',
            'POP POM & Pertambangan Minerba',
            'Fire Safety Manager',
        ];

        foreach ($bnspSkema as $skema) {
            DB::table('skema')->insert([
                'jasa_id' => $bnspId,
                'nama_skema' => $skema,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Insert Kemnaker RI schemes
        $kemnakerIdRaw = DB::table('jasa')->where('nama_jasa', 'Kemnaker RI')->first();
        if ($kemnakerIdRaw) {
            $kemnakerSkema = [
                'Ahli K3 Muda Lingkungan Kerja',
                'Operator Forklift Kelas 2',
                'Operator Forklift Kelas 1',
                'Petugas Pemadam Kebakaran (Kelas D)',
                'Regu Penanggulangan Kebakaran (Kelas C)',
                'Ahli Muda K3 Konstruksi',
                'Petugas P3K',
                'Ahli K3 Umum',
                'Auditor SMK3',
                'Teknisi K3 Listrik',
                'Ahli K3 Listrik',
                'Supervisor Perancah',
                'Petugas K3 Penyelamat Ruang Terbatas',
                'Teknisi Deteksi Gas Ruang Terbatas',
                'Teknisi K3 Ruang Terbatas',
                'Tenaga Kerja Bangunan Tinggi Tingkat 2',
                'Tenaga Kerja Pada Ketinggian Tingkat 1',
                'Teknisi K3 Perancah',
            ];

            foreach ($kemnakerSkema as $skema) {
                DB::table('skema')->insert([
                    'jasa_id' => $kemnakerIdRaw->id,
                    'nama_skema' => $skema,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Insert ISO schemes
        $isoIdRaw = DB::table('jasa')->where('nama_jasa', 'ISO')->first();
        if ($isoIdRaw) {
            $isoSkema = [
                '9001',
                '14001',
                '45001',
                '27001',
            ];

            foreach ($isoSkema as $skema) {
                DB::table('skema')->insert([
                    'jasa_id' => $isoIdRaw->id,
                    'nama_skema' => $skema,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('skema');
    }
};