<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table): void {
            $table->foreign('organization_id')->references('id')->on('organizations')->cascadeOnDelete();
            $table->text('description')->nullable()->after('guard_name');
            $table->string('color', 20)->nullable()->after('description');
            $table->boolean('is_system')->default(false)->after('color');
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table): void {
            $table->dropForeign(['organization_id']);
            $table->dropColumn(['description', 'color', 'is_system']);
        });
    }
};
