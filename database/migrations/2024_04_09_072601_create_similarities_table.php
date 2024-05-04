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
        Schema::create('similarities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_wisata1');
            $table->unsignedBigInteger('id_wisata2');
            $table->float('similarity');
            $table->timestamps();
            
            $table->foreign('id_wisata1')->references('id')->on('wisatas')->onDelete('cascade');
            $table->foreign('id_wisata2')->references('id')->on('wisatas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('similarities');
    }
};
