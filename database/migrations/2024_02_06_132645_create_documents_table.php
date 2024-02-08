<?php
// dans le fichier de migration create_documents_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_dossier');
            $table->foreign('id_dossier')->references('id')->on('dossiers')->onDelete('cascade');
            $table->unsignedBigInteger('id_type_document');
            $table->foreign('id_type_document')->references('id')->on('type_documents')->onDelete('cascade');
            $table->string('url');
           
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
