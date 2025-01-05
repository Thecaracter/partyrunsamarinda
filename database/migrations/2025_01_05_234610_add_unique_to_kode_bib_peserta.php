<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('peserta', function (Blueprint $table) {
            // Tambahkan unique index dengan nama yang spesifik
            $table->unique('kode_bib', 'peserta_kode_bib_unique');
        });
    }

    public function down()
    {
        Schema::table('peserta', function (Blueprint $table) {
            // Drop unique index jika ingin rollback
            $table->dropUnique('peserta_kode_bib_unique');
        });
    }
};