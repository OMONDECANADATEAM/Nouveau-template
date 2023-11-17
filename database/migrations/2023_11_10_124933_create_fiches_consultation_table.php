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
        Schema::create('fiches_consultation', function (Blueprint $table) {
            $table->id();
            $table->string('lien_cv');
            $table->string('reponse1')->nullable(true);
            $table->string('reponse2')->nullable(true);
            $table->string('reponse3')->nullable(true);
            $table->string('reponse4')->nullable(true);
            $table->string('reponse5')->nullable(true);
            $table->string('reponse6')->nullable(true);
            $table->string('reponse7')->nullable(true);
            $table->string('reponse8')->nullable(true);
            $table->string('reponse9')->nullable(true);
            $table->string('reponse10')->nullable(true);
            $table->string('reponse11')->nullable(true);
            $table->string('reponse12')->nullable(true);
            $table->string('reponse13')->nullable(true);
            $table->string('reponse14')->nullable(true);
            $table->string('reponse15')->nullable(true);
            $table->string('reponse16')->nullable(true);
            $table->string('reponse17')->nullable(true);
            $table->string('reponse18')->nullable(true);
            $table->string('reponse19')->nullable(true);
            $table->string('reponse20')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fiches_consultation');
    }
};
