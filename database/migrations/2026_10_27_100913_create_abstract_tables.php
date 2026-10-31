<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Abstract Categories
        Schema::create('abstract_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        // 2. Abstract Themes
        Schema::create('abstract_themes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        // 3. Abstract Submissions
        Schema::create('abstract_submissions', function (Blueprint $table) {
            $table->id();
            
            // membership_id varchar(100) se relation
            $table->string('user_id', 100); 
            $table->foreign('user_id')->references('membership_id')->on('alumni_registrations')->onDelete('cascade');

            $table->foreignId('category_id')->nullable()->constrained('abstract_categories')->nullOnDelete();
            $table->foreignId('theme_id')->nullable()->constrained('abstract_themes')->nullOnDelete();
            
            $table->string('title');
            $table->text('abstract_text');
            $table->text('keywords')->nullable();
            $table->enum('status', [
                'submitted', 'resubmitted', 'reviewer_accepted', 'reviewer_rejected',
                'sent_back', 'organizer_accepted', 'organizer_rejected', 'sent_to_reviewer'
            ])->default('submitted');

            // ✅ FIX: Spatie users table ki 'id' se link kiya
            $table->unsignedBigInteger('reviewer_id')->nullable();
            $table->foreign('reviewer_id')->references('id')->on('users')->nullOnDelete();

            $table->integer('reviewer_score')->nullable();
            $table->text('reviewer_remark')->nullable();

            $table->unsignedBigInteger('organizer_id')->nullable();
            $table->foreign('organizer_id')->references('id')->on('users')->nullOnDelete();

            $table->text('organizer_remark')->nullable();
            $table->timestamp('organizer_decided_at')->nullable();
            $table->timestamps();
        });

        // 4. Abstract Files
        Schema::create('abstract_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('abstract_submissions')->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_type');
            $table->integer('file_size');
            $table->timestamps();
        });

        // 5. Abstract Logs
        Schema::create('abstract_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('abstract_submissions')->onDelete('cascade');
            $table->enum('actor_type', ['admin', 'reviewer', 'organizer', 'user']);
            $table->unsignedBigInteger('actor_id'); // User ID store karne ke liye
            $table->string('actor_name');
            $table->string('action');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        // 6. Reviewer Assignments
        Schema::create('abstract_reviewer_assignments', function (Blueprint $table) {
            $table->id();
            
            // ✅ FIX: Spatie users table ki 'id' se link kiya
            $table->unsignedBigInteger('reviewer_id');
            $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->foreignId('category_id')->constrained('abstract_categories')->onDelete('cascade');
            $table->foreignId('theme_id')->nullable()->constrained('abstract_themes')->nullOnDelete();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abstract_reviewer_assignments');
        Schema::dropIfExists('abstract_logs');
        Schema::dropIfExists('abstract_files');
        Schema::dropIfExists('abstract_submissions');
        Schema::dropIfExists('abstract_themes');
        Schema::dropIfExists('abstract_categories');
    }
};