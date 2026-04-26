<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();

            // La candidature concernée
            $table->foreignId('candidature_id')->constrained()->onDelete('cascade');

            // Qui évalue
            $table->foreignId('evaluateur_id')->constrained('users')->onDelete('cascade');

            // Qui est évalué
            $table->foreignId('evalue_id')->constrained('users')->onDelete('cascade');

            // Note de 1 à 5
            $table->tinyInteger('note');

            $table->text('commentaire')->nullable();

            // Type : entreprise évalue étudiant ou étudiant évalue entreprise
            $table->enum('type', ['entreprise_evalue', 'etudiant_evalue']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};