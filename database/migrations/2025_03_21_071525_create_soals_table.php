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
        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            $table->string('soal_id')->unique();
            $table->string('tes_id');
            $table->string('jenis_soal');
            $table->longText('pertanyaan');
            $table->string('file_gambar')->nullable();
            $table->integer('poin');
            $table->timestamps();

            //FK
            $table->index('tes_id');
            $table->foreign('tes_id')->references('tes_id')->on('tes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soals');
    }
};
