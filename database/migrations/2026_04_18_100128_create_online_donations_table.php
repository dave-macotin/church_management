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
        Schema::create('online_donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members', 'MemberID')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->string('payment_method')->default('gcash'); // e.g., "card", "gcash"
            $table->string('payment_id')->nullable(); // External Reference
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('fund_category')->default('General');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_donations');
    }
};
