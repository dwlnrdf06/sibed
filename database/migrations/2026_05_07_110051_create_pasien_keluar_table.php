<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasien_keluar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->foreignId('kamar_id')->constrained('kamar')->onDelete('cascade');
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar');
            $table->integer('lama_dirawat')->nullable();
            $table->enum('cara_keluar', [
                'Sembuh',
                'Pulang Paksa',
                'Dirujuk',
                'Dipindahkan',
                'Meninggal < 48 Jam',
                'Meninggal >= 48 Jam'
            ]);
            $table->string('dirujuk_ke')->nullable();
            $table->foreignId('kamar_pindahan_id')->nullable()->constrained('kamar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasien_keluar');
    }
};