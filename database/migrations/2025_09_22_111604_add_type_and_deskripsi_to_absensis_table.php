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
        Schema::table('absensis', function (Blueprint $table) {
            $table->enum('type', ['Masuk', 'Keluar', 'Izin'])->default('Masuk')->after('lokasi_keluar');
            $table->string('deskripsi')->nullable()->after('type');
        });
    }

    public function down()
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropColumn(['type', 'deskripsi']);
        });
    }
};
