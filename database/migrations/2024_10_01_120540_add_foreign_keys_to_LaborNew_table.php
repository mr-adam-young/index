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
        Schema::table('LaborNew', function (Blueprint $table) {
            $table->foreign(['LaborTypeID'], 'Labor Type')->references(['ID'])->on('LaborTypes')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('LaborNew', function (Blueprint $table) {
            $table->dropForeign('Labor Type');
        });
    }
};
