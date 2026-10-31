<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accompanying_persons', function (Blueprint $table) {
            $table->id();
            // Foreign Key jo alumni_registrations table se judega
            $table->foreignId('registration_id')->constrained('alumni_registrations')->onDelete('cascade');
            
            $table->string('name');
            $table->string('relation');
            $table->boolean('is_alumni')->default(false);
            $table->string('alumni_membership_id')->nullable();
            $table->boolean('wants_membership')->default(false);
            $table->decimal('charge', 10, 2)->default(0);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accompanying_persons');
    }
};