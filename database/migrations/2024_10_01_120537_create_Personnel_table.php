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
        Schema::create('Personnel', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->string('ID_TEXT')->nullable()->index('id_text');
            $table->string('FullName')->nullable();
            $table->string('Email Address')->nullable();
            $table->string('Cell Phone')->nullable();
            $table->dateTime('Birthday')->nullable();
            $table->decimal('Rate', 19, 4)->nullable()->default(0);
            $table->float('VacationHours')->nullable()->default(0);
            $table->dateTime('DateJoined')->nullable();
            $table->string('Username')->nullable();
            $table->string('Password')->nullable();
            $table->boolean('Active')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Personnel');
    }
};
