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
        Schema::create('clock_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->dateTime('clock_time')->nullable();
            $table->decimal('clock_lat', 10, 7)->nullable();
            $table->decimal('clock_long', 10, 7)->nullable();
            $table->string('job_name')->nullable();
            $table->string('task_name')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_clock_in')->nullable();
            $table->boolean('is_processed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clock_events');
    }
};
