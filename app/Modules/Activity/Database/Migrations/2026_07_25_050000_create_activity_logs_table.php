<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('actor_member_id')->nullable()->constrained('organization_members')->nullOnDelete();
            $table->string('event');
            $table->nullableUuidMorphs('subject');
            $table->json('properties')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['organization_id', 'subject_type', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
