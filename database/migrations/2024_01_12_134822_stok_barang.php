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
        Schema::create('stok_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->unsignedInteger('stok')->default(0);
            $table->unsignedBigInteger('harga_per_biji')->default(0);
            $table->unsignedBigInteger('harga_grosir')->default(0);
            $table->unsignedBigInteger('qty_grosir')->default(0);
            $table->enum('kategori_barang', ['satuan_tetap', 'satuan_tidak_tetap'])->default('satuan_tetap');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_barang');
    }
};
