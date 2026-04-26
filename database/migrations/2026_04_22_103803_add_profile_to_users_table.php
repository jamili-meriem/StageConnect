<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Informations de base
            $table->string('phone')->nullable()->after('role');
            $table->text('bio')->nullable()->after('phone');
            $table->string('avatar')->nullable()->after('bio');

            // Informations entreprise
            $table->string('secteur')->nullable()->after('avatar');
            $table->string('taille_entreprise')->nullable()->after('secteur');
            $table->string('site_web')->nullable()->after('taille_entreprise');
            $table->string('adresse')->nullable()->after('site_web');
            $table->string('ville')->nullable()->after('adresse');
            $table->decimal('latitude', 10, 8)->nullable()->after('ville');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');

            // Informations étudiant
            $table->string('universite')->nullable()->after('longitude');
            $table->string('filiere')->nullable()->after('universite');
            $table->string('niveau')->nullable()->after('filiere');
            $table->string('cv_path')->nullable()->after('niveau');
            $table->string('linkedin')->nullable()->after('cv_path');

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'bio', 'avatar', 'secteur',
                'taille_entreprise', 'site_web', 'adresse',
                'ville', 'latitude', 'longitude',
                'universite', 'filiere', 'niveau',
                'cv_path', 'linkedin'
            ]);
        });
    }
};