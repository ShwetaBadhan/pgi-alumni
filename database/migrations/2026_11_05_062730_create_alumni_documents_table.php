<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_registration_id')->constrained()->onDelete('cascade');
            $table->string('profile_photo_path')->nullable();
            $table->string('documentary_proof_path')->nullable();
            $table->boolean('agreed_to_rules')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_documents');
    }
};