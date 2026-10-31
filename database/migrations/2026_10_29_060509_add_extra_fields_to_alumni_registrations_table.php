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
    Schema::table('alumni_registrations', function (Blueprint $table) {
       
        $table->decimal('donation_amount', 10, 2)->default(0)->after('comment');
        $table->string('practice_state')->nullable()->after('residence_country');
        $table->string('practice_specialty')->nullable()->after('practice_state');
    });
}

public function down(): void
{
    Schema::table('alumni_registrations', function (Blueprint $table) {
        $table->dropColumn([ 'donation_amount', 'practice_state', 'practice_specialty']);
    });
}
};
