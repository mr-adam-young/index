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
        Schema::create('Jobs', function (Blueprint $table) {
            $table->string('ID')->nullable();
            $table->string('Title')->nullable();
            $table->double('EstMaterialCost')->nullable();
            $table->mediumText('EstMaterialDesc')->nullable();
            $table->double('Handling')->nullable();
            $table->double('MeasureFit')->nullable();
            $table->double('Layout')->nullable();
            $table->double('Assembly')->nullable();
            $table->double('Finish')->nullable();
            $table->double('Paint')->nullable();
            $table->double('Install')->nullable();
            $table->double('Travel')->nullable();
            $table->string('Description', 1024)->nullable();
            $table->integer('Drawing')->nullable();
            $table->integer('Design')->nullable();
            $table->string('Invoice')->nullable();
            $table->string('Street', 100)->nullable();
            $table->string('City', 100)->nullable();
            $table->string('State', 45)->nullable();
            $table->integer('ZipCode')->nullable();
            $table->timestamp('lastUpdated');
            $table->unsignedInteger('Status')->nullable();
            $table->string('CustomerName', 100)->nullable();
            $table->string('CustomerPhone', 45)->nullable();
            $table->string('CustomerEmail', 45)->nullable();
            $table->double('Length')->nullable();
            $table->string('Material', 45)->nullable();
            $table->double('EstimatedHours')->nullable();
            $table->double('ActualHours')->nullable();
            $table->string('Color', 45)->nullable();
            $table->string('FinishType', 45)->nullable();
            $table->string('AccountID', 100)->nullable();
            $table->float('PostSize')->nullable();
            $table->float('PicketSize')->nullable();
            $table->float('ChannelSize')->nullable();
            $table->float('HeightInches')->nullable();
            $table->float('CapSize')->nullable();
            $table->float('ProfitMargin')->nullable();
            $table->float('Billed')->nullable();
            $table->boolean('is_active')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Jobs');
    }
};
