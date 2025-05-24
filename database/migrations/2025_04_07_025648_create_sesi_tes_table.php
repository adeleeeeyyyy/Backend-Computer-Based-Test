<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSesiTesTable extends Migration
{
    public function up()
    {
        Schema::create('sesi_tes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('tes_id');
            $table->timestamp('waktu_mulai')->nullable();
            $table->timestamp('waktu_selesai')->nullable();
            $table->string('status')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('browser', 100)->nullable();
            $table->timestamps();
            

            $table->index('siswa_id');
            $table->index('tes_id');
            $table->foreign('siswa_id')->references('id')->on('siswa_profiles')->onDelete('cascade');
            $table->foreign('tes_id')->references('id')->on('tes')->onDelete('cascade');
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('sesi_tes');
    }
}
