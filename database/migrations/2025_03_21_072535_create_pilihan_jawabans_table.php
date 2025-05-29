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
        Schema::create('pilihan_jawabans', function (Blueprint $table) {
            $table->id();
            $table->string('jawaban_id')->unique();
            $table->string('soal_id');
            $table->longText('teks_pilihan');
            $table->boolean('is_benar')->default(false);
            $table->timestamps();

            //FK
            $table->foreign('soal_id')->references('soal_id')->on('soals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pilihan_jawabans');
    }
};
