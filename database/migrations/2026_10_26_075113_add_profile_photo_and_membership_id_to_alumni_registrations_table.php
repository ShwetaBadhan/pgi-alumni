<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumni_registrations', function (Blueprint $table) {
            $table->string('membership_id')->unique()->nullable()->after('id');
            $table->string('profile_photo')->nullable()->after('lastname');
        });
    }

    public function down(): void
    {
        Schema::table('alumni_registrations', function (Blueprint $table) {
            $table->dropColumn(['membership_id', 'profile_photo']);
        });
    }
};