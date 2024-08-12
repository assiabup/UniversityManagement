<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('module_id');
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->boolean('archived')->default(false); // Champ pour indiquer si le cours est archivé
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cours');
    }
}
