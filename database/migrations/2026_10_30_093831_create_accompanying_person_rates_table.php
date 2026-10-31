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
    Schema::create('accompanying_person_rates', function (Blueprint $table) {
        $table->id();
        $table->decimal('base_rate', 10, 2); // Normal charge
        $table->boolean('is_discount_enabled')->default(false); 
        $table->decimal('discounted_rate', 10, 2)->nullable(); 
        $table->boolean('status')->default(true); 
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accompanying_person_rates');
    }
};
