<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldOfStudyIdToCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cours', function (Blueprint $table) {
            $table->unsignedBigInteger('field_of_study_id')->nullable();
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
        Schema::table('cours', function (Blueprint $table) {
            $table->dropForeign(['field_of_study_id']);
            $table->dropColumn('field_of_study_id');
        });
    }
}
