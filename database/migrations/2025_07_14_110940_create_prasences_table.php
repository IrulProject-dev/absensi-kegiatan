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
        Schema::create('prasences', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->string('slug');
            $table->dateTime('tgl_kegiatan');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // $table->time('waktu_mulai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prasences');
    }
};
