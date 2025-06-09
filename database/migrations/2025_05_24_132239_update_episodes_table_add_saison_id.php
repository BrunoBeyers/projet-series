<?php

// database/migrations/xxxx_xx_xx_update_episodes_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEpisodesTableAddSaisonId extends Migration
{
    public function up()
    {
        Schema::table('episodes', function (Blueprint $table) {
            // Supprimer la colonne serie_id
            $table->dropForeign(['serie_id']);
            $table->dropColumn('serie_id');

            // Ajouter la colonne saison_id
            $table->unsignedBigInteger('saison_id')->after('id');

            // Clé étrangère vers saisons
            $table->foreign('saison_id')->references('id')->on('saisons')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('episodes', function (Blueprint $table) {
            // Remettre la colonne serie_id
            $table->unsignedBigInteger('serie_id')->after('id');
            $table->foreign('serie_id')->references('id')->on('series')->onDelete('cascade');

            // Supprimer la colonne saison_id
            $table->dropForeign(['saison_id']);
            $table->dropColumn('saison_id');
        });
    }
}
