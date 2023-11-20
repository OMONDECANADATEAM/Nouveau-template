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
        Schema::table('candidat', function(Blueprint $table){
            $table->foreignId('id_utilisateur')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_info_consultation')->constrained('info_consultation')->onUpdate('cascade')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table->dropForeign('id_utilisateur');
        $table->dropForeign('id_info_consultation');
    }
};
