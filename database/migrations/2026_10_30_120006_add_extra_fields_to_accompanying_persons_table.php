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
    Schema::table('accompanying_persons', function (Blueprint $table) {
        $table->string('title')->nullable()->after('name');
        $table->integer('age')->nullable()->after('relation');
        $table->string('gender')->nullable()->after('age');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accompanying_persons', function (Blueprint $table) {
            //
        });
    }
};
