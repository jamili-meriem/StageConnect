<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offres', function (Blueprint $table) {

            // id() : clé primaire auto-incrémentée (1, 2, 3...)
            $table->id();

            // foreignId('user_id') : crée une colonne "user_id" de type entier
            // constrained() : user_id DOIT exister dans la table users
            // onDelete('cascade') : si l'entreprise est supprimée, ses offres aussi
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // string() : colonne texte courte, max 255 caractères
            $table->string('titre');
            $table->string('domaine');
            $table->string('lieu');

            // text() : colonne texte longue, pour les descriptions détaillées
            $table->text('description');

            // nullable() : ce champ est optionnel, peut être vide
            $table->string('duree')->nullable();
            $table->date('date_limite')->nullable();

            // boolean() : true ou false
            // default(true) : une offre est active dès sa création
            $table->boolean('is_active')->default(true);

            // timestamps() : crée automatiquement created_at et updated_at
            $table->timestamps();

        });
    }

    public function down(): void
    {
        // Supprime la table offres si on fait un rollback
        Schema::dropIfExists('offres');
    }
};