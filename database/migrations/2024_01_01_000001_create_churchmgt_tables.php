<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Assets (no FK deps)
        Schema::create('assets', function (Blueprint $table) {
            $table->id('AssetID');
            $table->string('ItemName', 150);
            $table->string('SerialNumber', 100)->nullable();
            $table->date('PurchaseDate')->nullable();
            $table->decimal('Value', 15, 2)->nullable();
            $table->timestamps();
        });

        // Groups
        Schema::create('groups', function (Blueprint $table) {
            $table->id('GroupID');
            $table->string('GroupName', 150);
            $table->text('Description')->nullable();
            $table->timestamps();
        });

        // Roles → Groups
        Schema::create('roles', function (Blueprint $table) {
            $table->id('RoleID');
            $table->foreignId('GroupID')->nullable()->constrained('groups', 'GroupID')->nullOnDelete();
            $table->string('RoleName', 100);
            $table->text('Permission')->nullable();
            $table->timestamps();
        });

        // Family (MemberID added via alter after members)
        Schema::create('families', function (Blueprint $table) {
            $table->id('FamilyID');
            $table->string('FamilyName', 150);
            $table->string('HomeAddress', 255)->nullable();
            $table->string('PhoneNumber', 20)->nullable();
            $table->timestamps();
        });

        // Members → Roles, Families
        Schema::create('members', function (Blueprint $table) {
            $table->id('MemberID');
            $table->foreignId('RoleID')->nullable()->constrained('roles', 'RoleID')->nullOnDelete();
            $table->foreignId('FamilyID')->nullable()->constrained('families', 'FamilyID')->nullOnDelete();
            $table->string('FirstName', 100);
            $table->string('LastName', 100);
            $table->string('Email', 150)->unique()->nullable();
            $table->string('Password', 255)->nullable();
            $table->string('PhoneNumber', 20)->nullable();
            $table->enum('Status', ['Active', 'Inactive', 'Pending'])->default('Active');
            $table->timestamps();
        });

        // Add MemberID FK to families
        Schema::table('families', function (Blueprint $table) {
            $table->foreignId('MemberID')->nullable()->after('FamilyID')
                  ->constrained('members', 'MemberID')->nullOnDelete();
        });

        // Ministry → Family
        Schema::create('ministries', function (Blueprint $table) {
            $table->id('MinistryID');
            $table->foreignId('FamilyID')->nullable()->constrained('families', 'FamilyID')->nullOnDelete();
            $table->string('Name', 150);
            $table->string('Address', 255)->nullable();
            $table->timestamps();
        });

        // Donations → Ministry
        Schema::create('donations', function (Blueprint $table) {
            $table->id('DonationID');
            $table->foreignId('MinistryID')->nullable()->constrained('ministries', 'MinistryID')->nullOnDelete();
            $table->decimal('Amount', 15, 2)->default(0);
            $table->date('Date')->nullable();
            $table->string('FundCategory', 100)->nullable();
            $table->timestamps();
        });

        // Member_Donation junction
        Schema::create('member_donations', function (Blueprint $table) {
            $table->foreignId('MemberID')->constrained('members', 'MemberID')->cascadeOnDelete();
            $table->foreignId('DonationID')->constrained('donations', 'DonationID')->cascadeOnDelete();
            $table->primary(['MemberID', 'DonationID']);
            $table->timestamps();
        });

        // Expenses → Ministry, Assets, Donations
        Schema::create('expenses', function (Blueprint $table) {
            $table->id('ExpenseID');
            $table->foreignId('MinistryID')->nullable()->constrained('ministries', 'MinistryID')->nullOnDelete();
            $table->foreignId('AssetID')->nullable()->constrained('assets', 'AssetID')->nullOnDelete();
            $table->foreignId('DonationID')->nullable()->constrained('donations', 'DonationID')->nullOnDelete();
            $table->string('Category', 100)->nullable();
            $table->decimal('Amount', 15, 2)->default(0);
            $table->string('Vendor', 150)->nullable();
            $table->string('Receipt', 255)->nullable();
            $table->timestamps();
        });

        // Attendance → Members
        Schema::create('attendances', function (Blueprint $table) {
            $table->id('AttendanceID');
            $table->foreignId('MemberID')->nullable()->constrained('members', 'MemberID')->nullOnDelete();
            $table->enum('Status', ['Present', 'Absent', 'Excused'])->default('Present');
            $table->dateTime('Timestamp')->nullable();
            $table->timestamps();
        });

        // Events → Attendance, Expenses
        Schema::create('events', function (Blueprint $table) {
            $table->id('EventID');
            $table->foreignId('AttendanceID')->nullable()->constrained('attendances', 'AttendanceID')->nullOnDelete();
            $table->foreignId('ExpensesID')->nullable()->constrained('expenses', 'ExpenseID')->nullOnDelete();
            $table->string('Location', 255)->nullable();
            $table->dateTime('StartDateTime')->nullable();
            $table->dateTime('EndDateTime')->nullable();
            $table->string('Title', 150)->nullable();
            $table->timestamps();
        });

        // Add EventID to groups
        Schema::table('groups', function (Blueprint $table) {
            $table->foreignId('EventID')->nullable()->after('GroupID')
                  ->constrained('events', 'EventID')->nullOnDelete();
        });

        // Auth users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'staff', 'member'])->default('member');
            $table->foreignId('MemberID')->nullable()->constrained('members', 'MemberID')->nullOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('groups', fn($t) => $t->dropColumn('EventID'));
        Schema::dropIfExists('users');
        Schema::dropIfExists('events');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('member_donations');
        Schema::dropIfExists('donations');
        Schema::dropIfExists('ministries');
        Schema::table('families', fn($t) => $t->dropColumn('MemberID'));
        Schema::dropIfExists('members');
        Schema::dropIfExists('families');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('assets');
    }
};
