<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('nama');
            $table->unsignedBigInteger('terapi_id');
            $table->string('nama_terapi');
            $table->string('tempat');
            $table->string('tanggal');
            $table->string('hari');
            $table->string('jam');
            $table->string('alamat')->nullable();
            $table->string('jenis_kelamin');
            $table->string('nohp');
            $table->integer('jumlah');
            $table->unsignedBigInteger('total_harga');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
