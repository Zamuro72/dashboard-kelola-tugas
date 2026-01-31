<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marketing_user_id')->constrained('users')->onDelete('cascade');
            $table->string('skema');
            $table->date('tanggal');
            $table->string('timeline');
            
            // Operasional inputs
            $table->boolean('need_surat_tugas')->default(false);
            $table->boolean('need_invoice')->default(false);
            $table->boolean('need_jadwal_meeting')->default(false);
            $table->text('catatan_operasional')->nullable();
            $table->timestamp('operasional_submitted_at')->nullable();
            
            // Supporting inputs
            $table->string('surat_tugas_file')->nullable();
            $table->string('invoice_file')->nullable();
            $table->date('jadwal_meeting_tanggal')->nullable();
            $table->time('jadwal_meeting_waktu')->nullable();
            $table->text('catatan_supporting')->nullable();
            $table->timestamp('supporting_submitted_at')->nullable();
            
            $table->enum('status', ['draft', 'waiting_operasional', 'waiting_supporting', 'completed'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};