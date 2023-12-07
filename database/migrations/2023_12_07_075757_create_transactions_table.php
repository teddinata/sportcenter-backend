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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');

            // trx code
            $table->string('invoice_code')->nullable();
            $table->string('unique_code')->nullable();

            $table->text('address')->nullable();
            $table->float('total_price')->nullable();
            $table->float('shipping_price')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('status')->nullable();
            $table->string('payment_url')->nullable();
            $table->text('notes')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
