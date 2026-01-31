<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update existing 'Operator' records to 'Operasional'
        DB::table('users')
            ->where('jabatan', 'Operator')
            ->update(['jabatan' => 'Operasional']);
        
        // Modify enum to replace Operator with Operasional
        DB::statement("ALTER TABLE users MODIFY COLUMN jabatan ENUM('Admin', 'Karyawan', 'Marketing', 'Operasional', 'Supporting') NOT NULL");
    }

    public function down(): void
    {
        // Revert 'Operasional' back to 'Operator'
        DB::table('users')
            ->where('jabatan', 'Operasional')
            ->update(['jabatan' => 'Operator']);
        
        // Revert enum
        DB::statement("ALTER TABLE users MODIFY COLUMN jabatan ENUM('Admin', 'Karyawan', 'Marketing', 'Operator', 'Supporting') NOT NULL");
    }
};