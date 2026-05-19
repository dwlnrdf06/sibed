<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        \DB::statement("ALTER TABLE kamar MODIFY COLUMN status ENUM('kosong', 'sebagian', 'terisi') DEFAULT 'kosong'");
    }

    public function down(): void
    {
        \DB::statement("ALTER TABLE kamar MODIFY COLUMN status ENUM('kosong', 'terisi') DEFAULT 'kosong'");
    }
};