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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('nama_lengkap');
            $table->enum('role', ['admin', 'guru', 'siswa'])->default('siswa');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->string('siswa_profile_id')->nullable();
            $table->string('guru_profile_id')->nullable();
            $table->string('admin_profile_id')->nullable();
            $table->rememberToken();
            $table->timestamps();

            //FK
            $table->foreign('siswa_profile_id')->references('user_id')->on('siswa_profiles')->onDelete('cascade');
            $table->foreign('guru_profile_id')->references('user_id')->on('guru_profiles')->onDelete('cascade');
            $table->foreign('admin_profile_id')->references('user_id')->on('admin_profiles')->onDelete('cascade');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
