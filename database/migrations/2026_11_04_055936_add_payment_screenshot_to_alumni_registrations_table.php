<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumni_registrations', function (Blueprint $table) {
           
            if (!Schema::hasColumn('alumni_registrations', 'payment_screenshot')) {
                $table->string('payment_screenshot')->nullable()->after('payment_transaction_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('alumni_registrations', function (Blueprint $table) {
            $table->dropColumn('payment_screenshot');
        });
    }
};