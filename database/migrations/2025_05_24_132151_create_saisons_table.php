<?php

// database/migrations/xxxx_xx_xx_create_saisons_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaisonsTable extends Migration
{
    public function up()
    {
        Schema::create('saisons', function (Blueprint $table) {
            $table->id();
            $table->integer('numero'); // numéro de la saison
            $table->unsignedBigInteger('serie_id');
            $table->text('description')->nullable();
            $table->integer('annee_sortie')->nullable();
            $table->timestamps();

            $table->foreign('serie_id')->references('id')->on('series')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('saisons');
    }
}
