<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bib')->nullable();
            $table->string('nama_lengkap');
            $table->string('nama_bib');
            $table->string('email');
            $table->string('no_wa');
            $table->string('provinsi');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('kota');
            $table->text('alamat');
            $table->integer('usia');
            $table->enum('kategori', ['Pelajar', 'Umum', 'Master']);
            $table->foreignId('size_id')->constrained('sizes');
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O']);
            $table->boolean('ada_alergi')->default(false);
            $table->text('riwayat_penyakit')->nullable();
            $table->string('emergency_nama');
            $table->string('emergency_nomor');


            $table->enum('status_pembayaran', ['pending', 'paid', 'expired', 'failed'])->default('pending');
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('midtrans_payment_type')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->decimal('amount', 10, 2);


            $table->boolean('is_checked_in')->default(false);
            $table->timestamp('check_in_time')->nullable();
            $table->string('checked_in_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peserta');
    }
};