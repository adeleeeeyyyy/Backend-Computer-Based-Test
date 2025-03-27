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
        Schema::create('tes', function (Blueprint $table) {
            $table->id();
            $table->string('tes_id')->unique();
            $table->string('kode_tes')->unique();
            $table->string('guru_id');
            $table->string('jenis_ujian');
            $table->string('judul', 200);
            $table->string('mapel');
            $table->json('kelas');
            $table->string('deskripsi');
            $table->enum("semester", [0, 1, 2, 3, 4, 5, 6])->default("0");
            $table->time('jam_mulai');
            $table->integer('durasi_menit');
            $table->timestamp('tanggal_mulai');
            $table->timestamp('tanggal_selesai');
            $table->integer('batas_percobaan');
            $table->enum('status', ['aktif','nonaktif','pemeliharaan'])->default('nonaktif');
            $table->string('password_tes');
            $table->timestamps();

            //FK
            $table->index('guru_id');
            $table->foreign('guru_id')->references('user_id')->on('guru_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tes');
    }
};
