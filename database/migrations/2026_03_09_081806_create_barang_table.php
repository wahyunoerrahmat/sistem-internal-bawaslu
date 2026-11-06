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
        Schema::create('barang', function (Blueprint $table) {

            $table->id();

            $table->integer('no_urut')->nullable();

            $table->string('jenis_barang');

            $table->string('nup')->nullable();

            $table->string('merk')->nullable();

            $table->string('tipe')->nullable();

            $table->string('kondisi')->nullable();

            $table->string('status')->default('tersedia');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
