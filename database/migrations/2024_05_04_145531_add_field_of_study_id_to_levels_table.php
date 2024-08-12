<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldOfStudyIdToLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('levels', function (Blueprint $table) {
            $table->unsignedBigInteger('field_of_study_id');

            // Création de la clé étrangère
            $table->foreign('field_of_study_id')
                  ->references('id')
                  ->on('field_of_studies')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('levels', function (Blueprint $table) {
            $table->dropForeign(['field_of_study_id']);
            $table->dropColumn('field_of_study_id');
        });
    }
    }

