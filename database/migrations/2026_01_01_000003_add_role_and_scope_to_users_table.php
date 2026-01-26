<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('role', 32)->default('store_manager')->after('email');
            $table->foreignId('branch_id')->nullable()->after('role')->constrained()->nullOnDelete();
            $table->foreignId('store_id')->nullable()->after('branch_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropForeign(['branch_id']);
            $table->dropForeign(['store_id']);
            $table->dropColumn(['role', 'branch_id', 'store_id']);
        });
    }
};
