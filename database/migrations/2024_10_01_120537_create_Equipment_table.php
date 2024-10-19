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
        Schema::create('Equipment', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->string('VehicleName')->nullable();
            $table->dateTime('InspectionExpires')->nullable();
            $table->boolean('Alert')->nullable()->default(false);
            $table->string('Plate')->nullable();
            $table->integer('LastOilChangeMileHour')->nullable()->default(0);
            $table->integer('ServiceInterval')->nullable()->default(0);
            $table->string('VIN-Serial')->nullable();
            $table->string('Description')->nullable();
            $table->integer('WeightLimit')->nullable()->default(0);
            $table->dateTime('InsuranceExpires')->nullable();
            $table->string('InsurancePolicy')->nullable();
            $table->dateTime('RegistrationExpires')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Equipment');
    }
};
