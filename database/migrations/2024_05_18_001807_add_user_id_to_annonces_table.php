<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToAnnoncesTable extends Migration
{
    public function up()
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');

            // Optionnel : ajouter une clé étrangère
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
