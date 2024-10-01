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
        Schema::create('LaborTypes', function (Blueprint $table) {
            $table->integer('ID', true)->unique('id_unique');
            $table->string('LaborType')->nullable();
            $table->decimal('Rate', 19, 4)->nullable()->default(0);

            $table->primary(['ID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('LaborTypes');
    }
};
