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
        Schema::create('t_p_s', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alamat');
            $table->char('village_code', 7);
            $table->timestamps();
            $table->foreign('village_code')
                ->references('code')
                ->on(config('laravolt.indonesia.table_prefix').'villages')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_p_s');
    }
};
