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
        Schema::create('royalty_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->string('platform');
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('total_streams', 15, 0)->default(0);
            $table->decimal('total_revenue', 12, 2)->default(0);
            $table->json('platform_data')->nullable();
            $table->enum('status', ['pending', 'processed', 'paid'])->default('pending');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            
            $table->index(['tenant_id', 'platform']);
            $table->index(['period_start', 'period_end']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('royalty_reports');
    }
};