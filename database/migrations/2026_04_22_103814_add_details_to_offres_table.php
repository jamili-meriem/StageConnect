<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('offres', function (Blueprint $table) {

            // Rémunération
            // nullable car certains stages ne sont pas rémunérés
            $table->integer('salaire_min')->nullable()->after('date_limite');
            $table->integer('salaire_max')->nullable()->after('salaire_min');

            // Type de travail
            // enum : valeur fixe parmi ces options
            $table->enum('type_travail', ['presentiel', 'remote', 'hybride'])
                  ->default('presentiel')->after('salaire_max');

            // Niveau requis
            $table->enum('niveau_requis', ['bac', 'bac+2', 'bac+3', 'bac+4', 'bac+5'])
                  ->default('bac+3')->after('type_travail');

            // Compétences requises stockées en JSON
            // ex: ["PHP", "Laravel", "MySQL"]
            $table->json('competences_requises')->nullable()->after('niveau_requis');

            // Nombre de postes disponibles
            $table->integer('nombre_postes')->default(1)->after('competences_requises');

            // Nombre de vues de l'offre
            $table->integer('vues')->default(0)->after('nombre_postes');

        });
    }

    public function down(): void
    {
        Schema::table('offres', function (Blueprint $table) {
            $table->dropColumn([
                'salaire_min', 'salaire_max', 'type_travail',
                'niveau_requis', 'competences_requises',
                'nombre_postes', 'vues'
            ]);
        });
    }
};