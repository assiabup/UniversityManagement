<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLevelToFieldOfStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('field_of_studies', function (Blueprint $table) {
            $table->integer('level')->default(1); // Ajoutez le champ 'level' à votre table 'filieres'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('filieres', function (Blueprint $table) {
            $table->dropColumn('level'); // Supprimez le champ 'level' si nécessaire
        });
    }
}
