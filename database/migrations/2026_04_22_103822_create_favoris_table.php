<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favoris', function (Blueprint $table) {
            $table->id();

            // L'étudiant qui a mis en favori
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // L'offre mise en favori
            $table->foreignId('offre_id')->constrained()->onDelete('cascade');

            // unique : un étudiant ne peut pas mettre la même offre en favori 2 fois
            $table->unique(['user_id', 'offre_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favoris');
    }
};