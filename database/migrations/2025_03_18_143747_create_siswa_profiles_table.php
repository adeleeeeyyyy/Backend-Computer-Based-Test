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
            $table->string('user_id');
            $table->string('nis', 10)->unique();
            $table->string('kelas', 20);
            $table->string('jurusan', 5);
            $table->timestamps();

            //FK
            $table->index('user_id');
            $table->foreign('user_id')->references('siswa_user_id')->on('users')->onDelete('cascade');
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
