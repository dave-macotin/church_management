<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sermons', function (Blueprint $table) {
            $table->boolean('is_approved')->default(false)->after('series');
            $table->unsignedBigInteger('submitted_by')->nullable()->after('is_approved');
            $table->foreign('submitted_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('sermons', function (Blueprint $table) {
            $table->dropForeign(['submitted_by']);
            $table->dropColumn(['is_approved', 'submitted_by']);
        });
    }
};
