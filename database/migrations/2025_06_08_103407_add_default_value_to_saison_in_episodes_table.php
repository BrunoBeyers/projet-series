<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValueToSaisonInEpisodesTable extends Migration
{
    public function up()
    {
        Schema::table('episodes', function (Blueprint $table) {
            // Modifier la colonne 'saison' pour qu'elle ait une valeur par défaut
            $table->string('saison')->default('default_value')->change();
        });
    }

    public function down()
    {
        Schema::table('episodes', function (Blueprint $table) {
            // Enlever la valeur par défaut
            $table->string('saison')->default(null)->change();
        });
    }
}
