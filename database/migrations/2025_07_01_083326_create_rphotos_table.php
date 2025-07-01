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
        Schema::create('rphotos', function (Blueprint $table) {
            $table->id('rphoto_id')->index();
            $table->string('rphoto_url');
            $table->foreignId('photo_id')->constrained('photos','photo_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rphotos');
    }
};
