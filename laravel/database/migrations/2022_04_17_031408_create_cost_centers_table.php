<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_centers', function (Blueprint $table) {
            // columns
            $table->increments('id');
            $table->string('long_name');
            $table->string('short_name');
            $table->string('description');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->timestamps();
            
            // relationships
            $table->foreign('parent_id')
                    ->references('id')->on('cost_centers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cost_centers');
    }
}