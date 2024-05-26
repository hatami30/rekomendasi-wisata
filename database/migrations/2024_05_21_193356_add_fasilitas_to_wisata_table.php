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
        Schema::table('wisatas', function (Blueprint $table) {
            $table->text('fasilitas')->nullable()->after('desk_wisata');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wisatas', function (Blueprint $table) {
            $table->dropColumn('fasilitas');
        });
    }
};
