<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDossiersTable extends Migration
{
    public function up()
    {
        Schema::create('dossiers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_candidat');
            $table->unsignedBigInteger('id_agent');
            $table->string('nom');
           

            // Clés étrangères
            $table->foreign('id_candidat')->references('id')->on('candidat')->onDelete('cascade');
            $table->foreign('id_agent')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dossiers');
    }
}
