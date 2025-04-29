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
        Schema::create('jawaban_pesertas', function (Blueprint $table) {
            $table->id();
            $table->string('siswa_id');
            $table->string('tes_id');
            $table->string('soal_id');
            $table->string('jawaban');  
            $table->timestamps();

            //FK
            $table->index('jawaban');
            $table->index('siswa_id');
            $table->index('tes_id');

            //FK
            $table->foreign('jawaban')->references('jawaban_id')->on('pilihan_jawabans')->onDelete('cascade');
            $table->foreign('soal_id')->references('soal_id')->on('soals')->onDelete('cascade');
            $table->foreign('siswa_id')->references('user_id')->on('siswa_profiles')->onDelete('cascade');
            $table->foreign('tes_id')->references('tes_id')->on('tes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_pesertas');
    }
};
