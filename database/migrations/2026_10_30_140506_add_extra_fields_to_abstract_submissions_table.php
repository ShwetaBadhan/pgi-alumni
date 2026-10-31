<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('abstract_submissions', function (Blueprint $table) {
            // Agar columns pehle se nahi hain, toh add karein
            if (!Schema::hasColumn('abstract_submissions', 'authors')) {
                $table->text('authors')->nullable()->after('title');
            }
            if (!Schema::hasColumn('abstract_submissions', 'co_author')) {
                $table->string('co_author')->nullable()->after('authors');
            }
            if (!Schema::hasColumn('abstract_submissions', 'primary_author_affiliation')) {
                $table->string('primary_author_affiliation')->nullable()->after('co_author');
            }
        });
    }

    public function down(): void
    {
        Schema::table('abstract_submissions', function (Blueprint $table) {
            $table->dropColumn(['authors', 'co_author', 'primary_author_affiliation']);
        });
    }
};