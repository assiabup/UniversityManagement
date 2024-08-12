<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnonceFiliereTable extends Migration
{
    public function up()
    {
        Schema::create('annonce_filiere', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('annonce_id');
            $table->unsignedBigInteger('filiere_id');
            $table->timestamps();

            $table->foreign('annonce_id')->references('id')->on('annonces')->onDelete('cascade');
            $table->foreign('filiere_id')->references('id')->on('field_of_studies')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('annonce_filiere');
    }
}
