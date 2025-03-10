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
        Schema::create('counter_barang', function (Blueprint $table) {
            $table->string('kategori', 10)->primary(); // Menambahkan kolom kategori sebagai primary key
            $table->integer('jumlah')->default(0); // Menambahkan kolom jumlah dengan default 0
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counter_barang');
    }
};
