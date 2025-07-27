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
        Schema::create('prasence_details', function (Blueprint $table) {
            $table->id();
            // $table->bigInteger('prasence_id');
            $table->string('name');
            $table->string('jabatan');
            $table->string('asal_instansi');
            $table->string('tanda_tangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prasence_details');
    }
};
