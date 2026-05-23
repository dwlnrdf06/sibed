<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sensus_pindahan', function (Blueprint $table) {
            $table->id();

            $table->date('tanggal');

            $table->string('nama_pasien');

            $table->string('no_rm');

            $table->string('dari_kamar')->nullable();

            $table->string('ke_kamar');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensus_pindahan');
    }
};