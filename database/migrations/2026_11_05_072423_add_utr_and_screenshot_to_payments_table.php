<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Check karein ki column pehle se nahi hai, phir hi add karein
            if (!Schema::hasColumn('payments', 'utr_number')) {
                $table->string('utr_number')->nullable()->after('gateway_payment_id');
            }
            if (!Schema::hasColumn('payments', 'screenshot_path')) {
                $table->string('screenshot_path')->nullable()->after('utr_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['utr_number', 'screenshot_path']);
        });
    }
};