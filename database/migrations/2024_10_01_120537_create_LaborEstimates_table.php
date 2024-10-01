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
        Schema::create('LaborEstimates', function (Blueprint $table) {
            $table->integer('LaborEstimateID', true)->unique('laborestimateid_unique');
            $table->string('JobID', 45);
            $table->integer('LaborTypeID')->default(1);
            $table->float('Hours')->default(0);
            $table->timestamp('Timestamp')->useCurrentOnUpdate()->useCurrent();
            $table->integer('Migrated')->default(0);

            $table->primary(['LaborEstimateID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('LaborEstimates');
    }
};
