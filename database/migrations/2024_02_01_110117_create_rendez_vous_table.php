<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRendezVousTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rendezVous', function (Blueprint $table) {
            $table->id();
            $table->date('date_rdv');
            $table->unsignedBigInteger('candidat_id');
            $table->unsignedBigInteger('commercial_id');
            
            // Ajoutez les clés étrangères
            $table->foreign('candidat_id')->references('id')->on('candidat')->onDelete('cascade');
            $table->foreign('commercial_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('RendezVous');
    }
}

