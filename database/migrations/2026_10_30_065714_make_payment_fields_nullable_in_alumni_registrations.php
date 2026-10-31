<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       
        DB::statement('ALTER TABLE alumni_registrations MODIFY payment_transaction_date DATE NULL');
        DB::statement('ALTER TABLE alumni_registrations MODIFY payment_transaction_id VARCHAR(255) NULL');
    }

    public function down(): void
    {
        
        DB::statement('ALTER TABLE alumni_registrations MODIFY payment_transaction_date DATE NOT NULL');
        DB::statement('ALTER TABLE alumni_registrations MODIFY payment_transaction_id VARCHAR(255) NOT NULL');
    }
};