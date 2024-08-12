<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableFieldOfStudiesTeachers extends Migration
{
    public function up()
    {
        Schema::create('field_of_study_teacher', function (Blueprint $table) {
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('field_of_study_id');
            
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('field_of_study_id')->references('id')->on('field_of_studies')->onDelete('cascade');

            $table->primary(['teacher_id', 'field_of_study_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('field_of_study_teacher');
    }
}




