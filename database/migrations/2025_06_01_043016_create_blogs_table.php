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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id('blog_id')->index();
            $table->string('blog_title');
            $table->string('blog_slug')->unique();
            $table->longText('blog_description');
            $table->string('blog_image')->nullable();
            $table->json('tags')->nullable();
            $table->enum('blog_status', ['active', 'inactive'])->default('active');
            $table->string('meta_title')->nullable();
            $table->string('meta_desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
