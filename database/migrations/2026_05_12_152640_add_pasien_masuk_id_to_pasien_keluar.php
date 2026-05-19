<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pasien_keluar', function (Blueprint $table) {
            $table->unsignedBigInteger('pasien_masuk_id')->nullable()->after('pasien_id');
        });
    }

    public function down()
    {
        Schema::table('pasien_keluar', function (Blueprint $table) {
            $table->dropColumn('pasien_masuk_id');
        });
    }
};
