<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumni_registrations', function (Blueprint $table) {
            // Profile related columns drop karein
            $columnsToDrop = [
                'title', 'firstname', 'middlename', 'lastname', 'date_of_birth',
                'contact_number', 'whatsapp_number', 'degree_completed', 'department',
                'year_of_passing', 'residence_country', 'practice_state', 'practice_specialty',
                
                // Documents related columns drop karein
                'profile_photo', 'documentary_proof', 'agreed_to_rules',
                
                // Payment related columns drop karein
                'amount_paid', 'payment_transaction_date', 'payment_transaction_id', 
                'payment_screenshot', 'donation_amount', 'comment',
                
                // Accompanying person related columns (jo ab alag table me hain) drop karein
                'has_accompanying_person', 'accompanying_name', 'accompanying_relation',
                'accompanying_is_alumni', 'accompanying_alumni_id', 'accompanying_charge'
            ];

            // Sirf wo columns drop karein jo actually table me exist karte hain
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('alumni_registrations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    public function down(): void
    {
        // Rollback ke liye (agar galti ho jaye)
        Schema::table('alumni_registrations', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->date('date_of_birth')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('degree_completed')->nullable();
            $table->string('department')->nullable();
            $table->year('year_of_passing')->nullable();
            $table->string('residence_country')->nullable();
            $table->string('practice_state')->nullable();
            $table->string('practice_specialty')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('documentary_proof')->nullable();
            $table->boolean('agreed_to_rules')->default(false);
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->date('payment_transaction_date')->nullable();
            $table->string('payment_transaction_id')->nullable();
            $table->string('payment_screenshot')->nullable();
            $table->decimal('donation_amount', 10, 2)->default(0);
            $table->text('comment')->nullable();
            $table->boolean('has_accompanying_person')->default(false);
            $table->string('accompanying_name')->nullable();
            $table->string('accompanying_relation')->nullable();
            $table->boolean('accompanying_is_alumni')->default(false);
            $table->string('accompanying_alumni_id')->nullable();
            $table->decimal('accompanying_charge', 10, 2)->default(0);
        });
    }
};