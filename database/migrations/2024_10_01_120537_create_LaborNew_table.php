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
        Schema::create('LaborNew', function (Blueprint $table) {
            $table->increments('LaborID')->unique('laborid_unique');
            $table->float('Hours')->nullable()->default(0);
            $table->integer('LaborTypeID')->default(0)->index('labor type_idx');
            $table->timestamp('Timestamp')->useCurrent();
            $table->dateTime('Date');
            $table->integer('EmployeeID')->nullable();
            $table->string('JobID', 45)->nullable();
            $table->tinyInteger('Migrated')->nullable()->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->primary(['LaborID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('LaborNew');
    }
};
