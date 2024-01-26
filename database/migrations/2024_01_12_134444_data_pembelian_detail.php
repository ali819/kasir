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
        Schema::create('data_pembelian_detail', function (Blueprint $table) {
            $table->id();
            $table->string('id_transaksi');
            $table->string('nama_barang');
            $table->string('satuan');
            $table->unsignedInteger('qty');
            $table->unsignedBigInteger('harga');
            $table->unsignedBigInteger('total_harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pembelian_detail');
    }
};
