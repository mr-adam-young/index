<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClockEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clock_events', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->datetime('clock_time')->nullable();
            $table->decimal('clock_lat', 10, 7)->nullable(); // Assuming latitude with up to 7 decimal places
            $table->decimal('clock_long', 10, 7)->nullable(); // Assuming longitude with up to 7 decimal places
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clock_events');
    }
}

