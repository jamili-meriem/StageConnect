<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidatures', function (Blueprint $table) {

            // Clé primaire auto-incrémentée
            $table->id();

            // user_id : l'étudiant qui envoie la candidature
            // constrained() : doit exister dans la table users
            // onDelete('cascade') : si l'étudiant est supprimé, ses candidatures aussi
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // offre_id : l'offre concernée par cette candidature
            // onDelete('cascade') : si l'offre est supprimée, ses candidatures aussi
            $table->foreignId('offre_id')->constrained()->onDelete('cascade');

            // longText() : texte très long, pour la lettre de motivation
            $table->longText('motivation');

            // string() : stocke le chemin du fichier CV sur le serveur
            // exemple : "cvs/etudiant_cv.pdf"
            $table->string('cv_path');

            // enum() : la valeur doit être exactement une de ces 3 options
            // default('en_attente') : toute nouvelle candidature est en attente
            $table->enum('statut', ['en_attente', 'acceptee', 'refusee'])
                  ->default('en_attente');

            // created_at et updated_at automatiques
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};