<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->decimal('score', 5, 2);
            $table->foreignId('field_of_study_id')->constrained('field_of_studies')->onDelete('cascade');
            $table->boolean('is_pass')->default(false);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('grades');
    }
}
