<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->integer('saison');
            $table->integer('numero_episode');
            $table->string('titre');
            $table->text('resume');
            $table->foreignId('serie_id')->constrained('series')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
