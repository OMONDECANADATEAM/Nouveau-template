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
        Schema::table('entree', function(Blueprint $table){
            $table->foreignId('id_utilisateur')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_candidat')->constrained('candidat')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_type_paiement')->constrained('type_paiement')->onUpdate('cascade')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table->dropForeign('id_utilisateur');
        $table->dropForeign('id_candidat');
        $table->foreignId('id_type_paiement');
    }
};
