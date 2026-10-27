<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni_registrations', function (Blueprint $table) {
            $table->id();
            
            // Personal Details
            $table->string('title');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->date('date_of_birth');
            $table->string('contact_number');
            $table->string('whatsapp_number')->nullable();
            
            // PGIMER Details
            $table->string('degree_completed');
            $table->string('department');
            $table->year('year_of_passing')->nullable();
            
            // Account Details
            $table->string('email')->unique();
            $table->string('password');
            $table->string('residence_country');
            
            // Registration & Payment (Fetched from registration_types)
            $table->foreignId('registration_type_id')->constrained('registration_types')->onDelete('restrict');
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->date('payment_transaction_date');
            $table->string('payment_transaction_id')->unique();
            
            // Accompanying Person (Updated later via Dashboard)
            $table->boolean('has_accompanying_person')->default(false);
            $table->string('accompanying_name')->nullable();
            $table->string('accompanying_relation')->nullable();
            $table->boolean('accompanying_is_alumni')->default(false);
            $table->string('accompanying_alumni_id')->nullable();
            $table->decimal('accompanying_charge', 10, 2)->default(0);
            
            // Additional
            $table->text('comment')->nullable();
            $table->boolean('agreed_to_rules')->default(false);
            $table->enum('status', ['pending', 'approved', 'rejected', 'payment_pending'])->default('payment_pending');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_registrations');
    }
};