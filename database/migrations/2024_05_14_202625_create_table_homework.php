<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
  
{
    public function up()
    {
        Schema::create('homework', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('student_id');
            $table->string('pdf_path');
            $table->timestamps();

            $table->foreign('module_id')->references('id')->on('modules');
            $table->foreign('student_id')->references('id')->on('students');
        });
    }

    public function down()
    {
        Schema::dropIfExists('homeworks');
    }
};