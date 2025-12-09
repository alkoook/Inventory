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
        // For MySQL/MariaDB, we need to modify the enum
        DB::statement("ALTER TABLE products MODIFY COLUMN unit_of_measure ENUM('غرام', 'كيلو', 'قطعة', 'علبة', 'كيس', 'ظرف', 'تنكة', 'طرد') DEFAULT 'قطعة'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE products MODIFY COLUMN unit_of_measure ENUM('غرام', 'كيلو', 'قطعة', 'علبة', 'كيس', 'ظرف', 'تنكة') DEFAULT 'قطعة'");
    }
};

