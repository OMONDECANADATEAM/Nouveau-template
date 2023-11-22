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
        Schema::create('info_consultation', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('lien_zoom', 100)->nullable(true);
            $table->string('lien_zoom_demarrer', 100)->nullable(true);
            $table->dateTime('date_heure')->nullable(true);
            $table->string('nombre_candidats')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_consultation');
    }
};
