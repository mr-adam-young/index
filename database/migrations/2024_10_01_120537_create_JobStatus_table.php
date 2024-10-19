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
        Schema::create('JobStatus', function (Blueprint $table) {
            $table->increments('idJobStatus')->unique('idjobstatus_unique');
            $table->string('StatusJobID', 45)->nullable();
            $table->unsignedInteger('StatusCode');
            $table->timestamp('Timestamp')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('StatusDate');

            $table->primary(['idJobStatus']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('JobStatus');
    }
};
