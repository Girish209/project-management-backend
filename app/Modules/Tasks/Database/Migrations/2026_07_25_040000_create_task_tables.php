<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('project_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('parent_task_id')->nullable()->constrained('tasks')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('todo');
            $table->string('priority')->default('medium');
            $table->foreignUuid('created_by_member_id')->nullable()->constrained('organization_members')->nullOnDelete();
            $table->foreignUuid('reporter_member_id')->nullable()->constrained('organization_members')->nullOnDelete();
            $table->date('due_date')->nullable();
            $table->unsignedInteger('estimated_minutes')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['organization_id', 'project_id', 'status']);
            $table->index(['organization_id', 'due_date']);
        });

        Schema::create('task_assignees', function (Blueprint $table): void {
            $table->foreignUuid('task_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('organization_member_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
            $table->unique(['task_id', 'organization_member_id']);
        });

        Schema::create('labels', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('color', 20);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['organization_id', 'name']);
        });

        Schema::create('label_task', function (Blueprint $table): void {
            $table->foreignUuid('label_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('task_id')->constrained()->cascadeOnDelete();
            $table->unique(['label_id', 'task_id']);
        });

        Schema::create('task_comments', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('task_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('author_member_id')->nullable()->constrained('organization_members')->nullOnDelete();
            $table->text('body');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['organization_id', 'task_id']);
        });

        Schema::create('task_watchers', function (Blueprint $table): void {
            $table->foreignUuid('task_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('organization_member_id')->constrained()->cascadeOnDelete();
            $table->unique(['task_id', 'organization_member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_watchers');
        Schema::dropIfExists('task_comments');
        Schema::dropIfExists('label_task');
        Schema::dropIfExists('labels');
        Schema::dropIfExists('task_assignees');
        Schema::dropIfExists('tasks');
    }
};
