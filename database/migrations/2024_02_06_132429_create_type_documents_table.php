<?php

// dans le fichier de migration create_type_documents_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('type_documents', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->unsignedBigInteger('id_type_procedure');
            $table->foreign('id_type_procedure')->references('id')->on('type_procedure')->onDelete('cascade');
            // Ajoutez d'autres colonnes au besoin
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('type_documents');
    }
}

