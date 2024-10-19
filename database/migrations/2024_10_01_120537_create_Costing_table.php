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
        Schema::create('Costing', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->string('JobID')->nullable()->index('jobid');
            $table->longText('Description')->nullable();
            $table->decimal('Cost', 19, 4)->nullable()->default(0);
            $table->string('Vendor')->nullable();
            $table->dateTime('PurchaseDate')->nullable();
            $table->string('ReceiptID')->nullable()->index('receiptid');
            $table->boolean('Inventory')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Costing');
    }
};
