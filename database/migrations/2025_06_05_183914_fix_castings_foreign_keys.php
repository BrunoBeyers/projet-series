<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('castings', function (Blueprint $table) {
            // Supprimer l'ancienne contrainte de clé étrangère
            $table->dropForeign(['acteur_id']);
            
            // Ajouter la nouvelle contrainte de clé étrangère
            $table->foreign('acteur_id')
                  ->references('id')
                  ->on('acteurs')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('castings', function (Blueprint $table) {
            // Supprimer la nouvelle contrainte
            $table->dropForeign(['acteur_id']);
            
            // Restaurer l'ancienne contrainte
            $table->foreign('acteur_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }
}; 