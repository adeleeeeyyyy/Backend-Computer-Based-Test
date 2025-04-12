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
        Schema::create('siswa_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique();
            $table->string('nis', 20)->unique();
            $table->string('kelas', 20);
            $table->string('jurusan', 50);
            $table->enum('status', ['mengerjakan_ujian', 'nonaktif'])->default('aktif');
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_profiles');
    }
};
