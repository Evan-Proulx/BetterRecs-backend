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
        Schema::create('album_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id');
            $table->foreign('album_id')->references('id')->on('albums')->onDelete('cascade');

            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('album_user');
    }
};
