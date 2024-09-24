<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('LaborNew', function (Blueprint $table) {
            // Add the standard Laravel timestamps
            $table->timestamps();

            // Drop the existing StampIn and StampOut columns
            $table->dropColumn(['StampIn', 'StampOut']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('LaborNew', function (Blueprint $table) {
            // Add back the StampIn and StampOut columns
            $table->timestamp('StampIn')->nullable();
            $table->timestamp('StampOut')->nullable();

            // Drop the Laravel timestamps
            $table->dropTimestamps();
        });
    }
};
