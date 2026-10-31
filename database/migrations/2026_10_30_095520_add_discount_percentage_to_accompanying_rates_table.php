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
    Schema::table('accompanying_person_rates', function (Blueprint $table) {
        $table->decimal('discount_percentage', 5, 2)->nullable()->after('is_discount_enabled');
        $table->dropColumn('discounted_rate'); // Purana column hata dein
    });
}
public function down(): void
{
    Schema::table('accompanying_person_rates', function (Blueprint $table) {
        $table->dropColumn('discount_percentage');
        $table->decimal('discounted_rate', 10, 2)->nullable();
    });
}
};
