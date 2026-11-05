<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_registration_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->date('date_of_birth')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('residence_country')->nullable();
            $table->string('practice_state')->nullable();
            $table->string('practice_specialty')->nullable();
            $table->string('degree_completed')->nullable();
            $table->string('department')->nullable();
            $table->year('year_of_passing')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_profiles');
    }
};