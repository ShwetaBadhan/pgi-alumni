<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'alumni_registration_id')) {
                $table->foreignId('alumni_registration_id')->nullable()->constrained('alumni_registrations')->onDelete('cascade');
            }
            if (!Schema::hasColumn('payments', 'registration_type_id')) {
                $table->foreignId('registration_type_id')->nullable()->constrained('registration_types');
            }
            if (!Schema::hasColumn('payments', 'payment_screenshot')) {
                $table->string('payment_screenshot')->nullable();
            }
            if (!Schema::hasColumn('payments', 'donation_amount')) {
                $table->decimal('donation_amount', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('payments', 'comment')) {
                $table->text('comment')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['alumni_registration_id']);
            $table->dropColumn([
                'alumni_registration_id',
                'registration_type_id',
                'payment_screenshot',
                'donation_amount',
                'comment'
            ]);
        });
    }
};