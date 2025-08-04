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
        Schema::create('royalty_splits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_id')->constrained('works')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('role', ['artist', 'writer', 'producer', 'publisher', 'label'])->default('artist');
            $table->decimal('percentage', 5, 2);
            $table->string('split_type')->default('master');
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'inactive', 'pending'])->default('active');
            $table->timestamps();
            
            $table->index(['work_id', 'status']);
            $table->index(['user_id', 'role']);
            $table->unique(['work_id', 'user_id', 'role', 'split_type'], 'unique_work_user_role_split');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('royalty_splits');
    }
};