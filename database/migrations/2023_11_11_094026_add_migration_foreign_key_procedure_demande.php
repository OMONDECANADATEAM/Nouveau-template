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
        Schema::table('procedure_demande', function(Blueprint $table){
            $table->foreignId('id_candidat')->constrained('candidats')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_type_procedure')->constrained('type_procedure')->onUpdate('cascade')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table->dropForeign('id_candidat');
        $table->foreignId('id_type_procedure');
    }
};
