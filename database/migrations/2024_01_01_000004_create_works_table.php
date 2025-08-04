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
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('artist_id')->constrained('artists')->onDelete('cascade');
            $table->string('title');
            $table->string('isrc')->unique()->nullable();
            $table->string('upc')->nullable();
            $table->json('genres')->nullable();
            $table->string('language')->default('en');
            $table->integer('duration_seconds')->nullable();
            $table->date('release_date')->nullable();
            $table->string('album_name')->nullable();
            $table->string('cover_art_url')->nullable();
            $table->string('audio_file_url')->nullable();
            $table->json('metadata')->nullable();
            $table->enum('status', ['draft', 'pending_review', 'approved', 'distributed', 'takedown'])->default('draft');
            $table->json('distribution_platforms')->nullable();
            $table->timestamp('distributed_at')->nullable();
            $table->timestamps();
            
            $table->index(['tenant_id', 'status']);
            $table->index(['artist_id', 'status']);
            $table->index('title');
            $table->index('release_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};