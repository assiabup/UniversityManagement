<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRattrapageStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rattrapage_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('field_of_study_id');
            $table->float('score'); // Exemple de champ pour la note
            $table->timestamps();

            // Déclaration des clés étrangères
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('module_id')->references('id')->on('modules');
            $table->foreign('field_of_study_id')->references('id')->on('field_of_studies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rattrapage_students');
    }
}
