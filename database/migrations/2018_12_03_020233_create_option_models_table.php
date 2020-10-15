<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_models', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quiz_model_id');
            $table->string('option_desc');

            $table->foreign('quiz_model_id')
                ->references('id')
                ->on('quiz_models')
                ->onDelete('cascade')
                ->onUpdated('cascade');

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
        Schema::dropIfExists('option_models');
    }
}
