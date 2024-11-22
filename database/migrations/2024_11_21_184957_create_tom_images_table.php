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
        Schema::create('tom_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId("tom_id")->constrained()->onDelete('cascade');
            $table->foreignId("photo_id")->constrained()->onDelete('cascade');
            $table->integer("photo_number");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tom_images');
    }
};
