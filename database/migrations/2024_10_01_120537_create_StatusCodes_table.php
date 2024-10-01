<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('StatusCodes', function (Blueprint $table) {
            $table->increments('idStatusCodes')->unique('idstatuscodes_unique');
            $table->string('StatusName', 45);
            $table->integer('Value')->nullable();

            $table->primary(['idStatusCodes']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('StatusCodes');
    }
};
