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
        Schema::create('log_siswa', function (Blueprint $table) {
            $table->id();
            $table->string("tes_id");
            $table->string("siswa_id");
            $table->timestamp(  "jam_mulai");
            $table->timestamp("jam_selesai");
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_siswa');
    }
};
