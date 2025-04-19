<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('monitoring_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sesi_id');
            $table->string('jenis_aktivitas');
            $table->timestamp('waktu');
            $table->string('screenshot', 255)->nullable();
            $table->timestamps();

            $table->foreign('sesi_id')->references('id')->on('sesi_tes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitoring_aktivitas');
    }
};
