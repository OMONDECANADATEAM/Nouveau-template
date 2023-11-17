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
        Schema::create('candidats', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('lien_photo')->nullable(true);
            $table->string('numero_telephone');
            $table->string('email');
            $table->string('profession');
            $table->dateTime('date_naissance');
            $table->boolean('consultation_payee');
            $table->boolean('consultation_effectuee')->nullable(true);
            $table->boolean('versement_effectuee')->nullable(true);
            $table->dateTime('date_enregistrement')->nullable(true);
            $table->string('remarque_consultante', 2000)->nullable(true);
            $table->string('remarque_agent', 2000)->nullable(true);
            $table->string('ville');
            $table->string('pays');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidats');
    }
};
