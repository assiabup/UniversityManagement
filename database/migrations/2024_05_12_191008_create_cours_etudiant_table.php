<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursEtudiantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cours_etudiant', function (Blueprint $table) {
            $table->unsignedBigInteger('cours_id');
            $table->unsignedBigInteger('etudiant_id');
            
            
            // Clés étrangères
            $table->foreign('cours_id')->references('id')->on('cours')->onDelete('cascade');
            $table->foreign('etudiant_id')->references('id')->on('students')->onDelete('cascade');
            
            // Indiquez qu'il s'agit d'une clé primaire composée si nécessaire
            $table->primary(['cours_id', 'etudiant_id']);
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cours_etudiant');
    }
}
