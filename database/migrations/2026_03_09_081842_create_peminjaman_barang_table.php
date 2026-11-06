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
        Schema::create('peminjaman_barang', function (Blueprint $table) {

            $table->id();

            $table->foreignId('barang_id')
                ->constrained('barang')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->dateTime('tanggal_pinjam');

            $table->dateTime('tanggal_kembali_rencana')->nullable();

            $table->dateTime('tanggal_kembali_real')->nullable();

            $table->string('status')->default('dipinjam');

            $table->integer('jumlah')->default(1);

            $table->string('foto_kondisi_pinjam')->nullable();

            $table->string('foto_kondisi_kembali')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_barang');
    }
};
