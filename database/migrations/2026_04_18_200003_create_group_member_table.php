<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('group_member', function (Blueprint $table) {
            $table->unsignedBigInteger('GroupID');
            $table->unsignedBigInteger('MemberID');
            $table->timestamp('joined_at')->nullable();
            $table->primary(['GroupID', 'MemberID']);
            $table->foreign('GroupID')->references('GroupID')->on('groups')->cascadeOnDelete();
            $table->foreign('MemberID')->references('MemberID')->on('members')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_member');
    }
};
