<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('pendukungs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('jenis_kelamin');
            $table->integer('usia');
            $table->string('kec');
            $table->string('desa');
            $table->string('rt');
            $table->string('rw');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tps_id')->constrained('t_p_s')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('pendukungs');
    }
};
