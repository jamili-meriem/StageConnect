<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications_stageconnect', function (Blueprint $table) {
            $table->id();

            // L'utilisateur qui reçoit la notification
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Titre et message
            $table->string('titre');
            $table->text('message');

            // Type de notification pour l'icône et la couleur
            $table->enum('type', ['info', 'success', 'warning', 'danger'])
                  ->default('info');

            // Lien vers lequel rediriger au clic
            $table->string('lien')->nullable();

            // null = non lue, date = lue à cette date
            $table->timestamp('lue_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications_stageconnect');
    }
};