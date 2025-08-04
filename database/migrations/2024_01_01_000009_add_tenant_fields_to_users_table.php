<?php

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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->onDelete('cascade');
            $table->enum('role', ['super_admin', 'label_admin', 'artist'])->default('artist');
            $table->string('phone')->nullable();
            $table->string('avatar_url')->nullable();
            $table->json('preferences')->nullable();
            $table->timestamp('last_active_at')->nullable();
            
            $table->index(['tenant_id', 'role']);
            $table->index('role');
            $table->index('last_active_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropIndex(['tenant_id', 'role']);
            $table->dropIndex(['role']);
            $table->dropIndex(['last_active_at']);
            $table->dropColumn([
                'tenant_id',
                'role',
                'phone',
                'avatar_url',
                'preferences',
                'last_active_at'
            ]);
        });
    }
};