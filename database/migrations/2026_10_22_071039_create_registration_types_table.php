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
        Schema::create('registration_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Type ka name
            $table->decimal('amount', 10, 2); // Amount (10 digits total, 2 after decimal)
            $table->enum('status', ['active', 'inactive'])->default('active'); // Status active/inactive
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at (Optional but recommended)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_types');
    }
};