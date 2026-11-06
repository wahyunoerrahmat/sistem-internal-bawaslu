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
        Schema::create('tamu', function (Blueprint $table) {

            $table->id();

            $table->string('nama_lengkap');

            $table->text('alamat')->nullable();

            $table->string('kontak')->nullable();

            $table->text('keperluan');

            $table->string('pihak_dituju')->nullable();

            $table->string('nama_penerima')->nullable();

            $table->string('dokumentasi')->nullable();

            $table->dateTime('waktu_datang');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tamu');
    }
};
