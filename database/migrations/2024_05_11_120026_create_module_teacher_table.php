<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleTeacherTable extends Migration
{
    public function up()
    {
        Schema::create('module_teacher', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('teacher_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');

            // Ensure unique combination of module_id and teacher_id
            $table->unique(['module_id', 'teacher_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('module_teacher');
    }
}
