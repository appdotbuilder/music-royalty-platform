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
        Schema::create('work_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_id')->constrained('works')->onDelete('cascade');
            $table->foreignId('royalty_report_id')->constrained('royalty_reports')->onDelete('cascade');
            $table->string('platform');
            $table->decimal('streams', 15, 0)->default(0);
            $table->decimal('revenue', 12, 2)->default(0);
            $table->decimal('rate_per_stream', 8, 6)->default(0);
            $table->string('territory')->default('WW');
            $table->date('period_start');
            $table->date('period_end');
            $table->timestamps();
            
            $table->index(['work_id', 'platform']);
            $table->index(['royalty_report_id', 'work_id']);
            $table->index(['period_start', 'period_end']);
            $table->index('platform');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_earnings');
    }
};