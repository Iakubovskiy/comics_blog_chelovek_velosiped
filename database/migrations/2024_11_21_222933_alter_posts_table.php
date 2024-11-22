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
        Schema::table('posts',function (Blueprint $table){
            $table->dropForeign("posts_chapter_id_foreign");
            $table->dropColumn("chapter_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('chapter_id')->nullable(); 
            $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('cascade');
        });
    }
};
