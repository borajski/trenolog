<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('target-muscle')->nullable();
            $table->string('other-muscle')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('description')->nullable();
            $table->string('type')->nullable();
            $table->string('private')->nullable();
            $table->string('public')->nullable();            
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
        Schema::dropIfExists('exercises');
    }
}
