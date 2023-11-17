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
        Schema::table('users', function(Blueprint $table){
            $table->foreignId('id_poste_occupe')->constrained('postes_occupe')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_role_utilisateur')->constrained('roles_utilisateur')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_succursale')->constrained('succursales')->onUpdate('cascade')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table->dropForeign('id_poste_occupe');
        $table->dropForeign('id_role_utilisateur');
        $table->dropForeign('id_succursale');
    }
};
