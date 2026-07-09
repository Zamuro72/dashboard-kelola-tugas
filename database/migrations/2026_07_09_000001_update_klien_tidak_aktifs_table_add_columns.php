<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('klien_tidak_aktifs', function (Blueprint $table) {
            $table->string('bidang_usaha')->nullable()->after('nama_perusahaan');
            $table->string('kota')->nullable()->after('bidang_usaha');
            $table->string('produk_minat')->nullable()->after('no_whatsapp');
            $table->string('pic_sales')->nullable()->after('produk_minat');
            $table->dateTime('terakhir_blasting_wa')->nullable()->after('status');
            $table->dateTime('terakhir_blasting_email')->nullable()->after('terakhir_blasting_wa');
            
            // Drop old unused columns
            $table->dropColumn(['tipe_klien', 'tanggal_lahir', 'nama_penanggung_jawab']);
        });

        // Modify ENUM status via DB statement
        DB::statement("ALTER TABLE klien_tidak_aktifs MODIFY COLUMN status ENUM('ongoing proses deal', 'belum jelas', 'follow up', 'belum dihubungi', 'sudah diblasting', 'menunggu respon', 'deal', 'tidak berminat') NOT NULL");
    }

    public function down(): void
    {
        // Revert ENUM status
        DB::statement("ALTER TABLE klien_tidak_aktifs MODIFY COLUMN status ENUM('ongoing proses deal', 'belum jelas', 'follow up') NOT NULL");

        Schema::table('klien_tidak_aktifs', function (Blueprint $table) {
            $table->dropColumn([
                'bidang_usaha',
                'kota',
                'produk_minat',
                'pic_sales',
                'terakhir_blasting_wa',
                'terakhir_blasting_email'
            ]);

            $table->enum('tipe_klien', ['Personal', 'Perusahaan'])->default('Perusahaan')->after('user_id');
            $table->date('tanggal_lahir')->nullable()->after('nama_klien');
            $table->string('nama_penanggung_jawab')->nullable()->after('nama_perusahaan');
        });
    }
};
