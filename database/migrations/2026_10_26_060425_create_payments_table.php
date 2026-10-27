<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Sirf naya payments table banayein - kuch drop nahi karna
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('alumni_registrations')->onDelete('cascade');
            
            // Payment Details
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('INR');
            $table->string('gateway'); // razorpay, stripe, manual
            
            // Gateway IDs
            $table->string('gateway_order_id')->nullable();
            $table->string('gateway_payment_id')->nullable();
            $table->enum('status', ['pending', 'success', 'failed', 'refunded'])->default('pending');
            
            // Raw Response (JSON)
            $table->json('response_payload')->nullable();
            
            // Refund Details
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->text('refund_reason')->nullable();
            $table->string('refund_transaction_id')->nullable();
            $table->timestamp('refunded_at')->nullable();
            
            $table->timestamps();
            
            // Index for faster queries
            $table->index('gateway_payment_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};