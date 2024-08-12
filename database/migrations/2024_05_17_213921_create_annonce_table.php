<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnonceTable extends Migration
{
    
   
    
    
        public function up()
        {
            Schema::create('annonces', function (Blueprint $table) {
                $table->id();
                $table->string('file_path');
                $table->timestamps();
            });
        }
    
        public function down()
        {
            Schema::dropIfExists('annonces');
        }
    }
    


