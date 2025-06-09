<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageUrlToSaisonsEpisodesActeurs extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        
        // Ajout dans la table episodes
        Schema::table('episodes', function (Blueprint $table) {
            $table->string('image_url')->nullable()->after('resume');
        });

        // Ajout dans la table acteurs
        Schema::table('acteurs', function (Blueprint $table) {
            $table->string('image_url')->nullable()->after('biographie');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
       
        Schema::table('episodes', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });

        Schema::table('acteurs', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });
    }
}
