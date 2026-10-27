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
        $table->string('documentary_proof')->nullable()->after('agreed_to_rules');
    });
}

public function down(): void
{
    Schema::table('alumni_registrations', function (Blueprint $table) {
        $table->dropColumn('documentary_proof');
    });
}
};
