<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('department')->nullable();
            $table->foreignUuid('lead_member_id')->nullable()->constrained('organization_members')->nullOnDelete();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['organization_id', 'name']);
            $table->index(['organization_id', 'status']);
        });

        Schema::create('team_members', function (Blueprint $table): void {
            $table->foreignUuid('team_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('organization_member_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['team_id', 'organization_member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('teams');
    }
};
