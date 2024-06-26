<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('name')->nullable();
            $table->string('sort')->nullable();
            $table->string('ingredients')->nullable();
            $table->string('proteins')->nullable();
            $table->string('carbs')->nullable();
            $table->string('sugars')->nullable();
            $table->string('fibers')->nullable();
            $table->string('fats')->nullable();
            $table->string('saturated-fats')->nullable();
            $table->string('calories')->nullable();
            $table->string('photo')->nullable();
            $table->string('status')->nullable(); 
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
        Schema::dropIfExists('meals');
    }
}
