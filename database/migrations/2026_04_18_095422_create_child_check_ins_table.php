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
        Schema::create('child_check_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('children')->onDelete('cascade');
            $table->foreignId('parent_id')->constrained('members', 'MemberID')->onDelete('cascade');
            $table->enum('type', ['check-in', 'check-out']);
            $table->timestamp('timestamp');
            $table->string('session_name')->nullable(); // e.g., "Sunday Morning Service"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_check_ins');
    }
};
