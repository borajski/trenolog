<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('ingredients')->nullable();
            $table->string('proteins')->nullable();
            $table->string('carbs')->nullable();
            $table->string('sugars')->nullable();
            $table->string('fibers')->nullable();
            $table->string('fats')->nullable();
            $table->string('saturated-fats')->nullable();
            $table->string('calories')->nullable();
            $table->string('meals')->nullable();
            $table->string('date')->nullable(); 
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
        Schema::dropIfExists('menus');
    }
}
