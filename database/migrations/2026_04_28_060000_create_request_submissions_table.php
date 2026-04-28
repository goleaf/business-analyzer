<?php

use App\Enums\AiProcessingStatus;
use App\Enums\RequestSubmissionStatus;
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
        Schema::create('request_submissions', function (Blueprint $table) {
            $table->id();
            $table->text('business_description');
            $table->text('achievements');
            $table->text('expected_results');
            $table->string('status', 30)->default(RequestSubmissionStatus::New->value)->index();
            $table->text('admin_notes')->nullable();
            $table->string('ai_processing_status', 30)->default(AiProcessingStatus::NotStarted->value)->index();
            $table->timestamp('ai_processing_started_at')->nullable();
            $table->timestamp('ai_processing_completed_at')->nullable();
            $table->text('ai_processing_error')->nullable();
            $table->timestamps();

            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_submissions');
    }
};
