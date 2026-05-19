<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekapitulasi', function (Blueprint $table) {
            $table->id();
            $table->integer('bulan');
            $table->integer('tahun');
            $table->date('tanggal');
            $table->integer('pasien_awal')->default(0);
            $table->integer('pasien_baru')->default(0);
            $table->integer('pasien_pindahan')->default(0);
            $table->integer('pasien_rujukan')->default(0);
            $table->integer('pasien_dipindahkan')->default(0);
            $table->integer('pasien_pulang_sembuh')->default(0);
            $table->integer('pasien_pulang_paksa')->default(0);
            $table->integer('meninggal_lt48')->default(0);
            $table->integer('meninggal_gte48')->default(0);
            $table->integer('dirujuk')->default(0);
            $table->integer('pasien_masih_dirawat')->default(0);
            $table->decimal('bor', 5, 2)->default(0);
            $table->decimal('avlos', 5, 2)->default(0);
            $table->decimal('bto', 5, 2)->default(0);
            $table->decimal('toi', 5, 2)->default(0);
            $table->unique(['tanggal']); // 1 baris per tanggal
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekapitulasi');
    }
};