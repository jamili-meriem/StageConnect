<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Ajoute la colonne "role" après la colonne "email"
            // default('etudiant') : tout nouvel utilisateur est étudiant par défaut
            // Les 3 rôles possibles : etudiant, entreprise, admin
            $table->string('role')->default('etudiant')->after('email');

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Supprime la colonne role si on fait un rollback
            $table->dropColumn('role');

        });
    }
};