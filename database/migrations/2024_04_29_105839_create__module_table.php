<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleTable extends Migration
{
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom du module
            $table->string('code')->unique(); // Code unique du module
            $table->text('description'); // Description du module
            $table->foreignId('field_of_study_id')->constrained()->onDelete('cascade'); // Clé étrangère pour la filière
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('modules');
    }
}
