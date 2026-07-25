<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table): void {
            // Nullable supports safe upgrade of the original starter projects table.
            $table->foreignUuid('organization_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            $table->string('key')->nullable()->after('organization_id');
            $table->foreignUuid('owner_member_id')->nullable()->after('status')->constrained('organization_members')->nullOnDelete();
            $table->date('start_date')->nullable()->after('owner_member_id');
            $table->date('end_date')->nullable()->after('start_date');
            $table->timestamp('archived_at')->nullable()->after('end_date');
            $table->unique(['organization_id', 'key']);
            $table->index(['organization_id', 'status']);
        });

        Schema::create('project_members', function (Blueprint $table): void {
            $table->foreignUuid('project_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('organization_member_id')->constrained()->cascadeOnDelete();
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();
            $table->unique(['project_id', 'organization_member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_members');

        Schema::table('projects', function (Blueprint $table): void {
            $table->dropUnique(['organization_id', 'key']);
            $table->dropIndex(['organization_id', 'status']);
            $table->dropConstrainedForeignId('organization_id');
            $table->dropConstrainedForeignId('owner_member_id');
            $table->dropColumn(['key', 'start_date', 'end_date', 'archived_at']);
        });
    }
};
