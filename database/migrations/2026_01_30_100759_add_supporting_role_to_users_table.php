<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify enum to add 'Supporting'
        DB::statement("ALTER TABLE users MODIFY COLUMN jabatan ENUM('Admin', 'Karyawan', 'Marketing', 'Operator', 'Supporting') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum
        DB::statement("ALTER TABLE users MODIFY COLUMN jabatan ENUM('Admin', 'Karyawan', 'Marketing', 'Operator') NOT NULL");
    }
};
