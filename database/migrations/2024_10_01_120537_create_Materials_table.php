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
        Schema::create('Materials', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->string('Type')->nullable();
            $table->float('Width')->nullable()->default(0);
            $table->float('Height')->nullable()->default(0);
            $table->float('Thick')->nullable()->default(0);
            $table->float('WeightPerLength')->nullable()->default(0);
            $table->float('PricePerFoot')->nullable()->default(0);
            $table->string('Material')->nullable();
            $table->timestamp('QuoteDate')->useCurrent();
            $table->float('Length')->nullable()->default(0);
            $table->string('Alloy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Materials');
    }
};
