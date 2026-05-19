<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sensus_harian', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->unique();
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
            $table->decimal('bor', 5, 2)->nullable();
            $table->decimal('avlos', 5, 2)->nullable();
            $table->decimal('bto', 5, 2)->nullable();
            $table->decimal('toi', 5, 2)->nullable();
            $table->decimal('ndr', 5, 2)->nullable();
            $table->decimal('gdr', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensus_harian');
    }
};