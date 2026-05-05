<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Groups
        DB::table('groups')->insertOrIgnore([
            ['GroupName' => 'Choir', 'Description' => 'Sunday worship choir', 'EventID' => null, 'created_at' => now(), 'updated_at' => now()],
            ['GroupName' => 'Youth Ministry', 'Description' => 'Youth programs and activities', 'EventID' => null, 'created_at' => now(), 'updated_at' => now()],
            ['GroupName' => 'Finance Committee', 'Description' => 'Oversees church finances', 'EventID' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Roles
        DB::table('roles')->insertOrIgnore([
            ['GroupID' => 1, 'RoleName' => 'Choir Leader', 'Permission' => 'manage_choir', 'created_at' => now(), 'updated_at' => now()],
            ['GroupID' => 2, 'RoleName' => 'Youth Pastor', 'Permission' => 'manage_youth', 'created_at' => now(), 'updated_at' => now()],
            ['GroupID' => 3, 'RoleName' => 'Treasurer', 'Permission' => 'manage_finance', 'created_at' => now(), 'updated_at' => now()],
            ['GroupID' => null, 'RoleName' => 'General Member', 'Permission' => 'view_only', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Families
        DB::table('families')->insertOrIgnore([
            ['FamilyName' => 'Santos Family', 'HomeAddress' => '123 Rizal St, General Santos City', 'PhoneNumber' => '0912-345-6789', 'MemberID' => null, 'created_at' => now(), 'updated_at' => now()],
            ['FamilyName' => 'Reyes Family', 'HomeAddress' => '456 Mabini Ave, General Santos City', 'PhoneNumber' => '0923-456-7890', 'MemberID' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Members
        DB::table('members')->insertOrIgnore([
            ['RoleID' => 4, 'FamilyID' => 1, 'FirstName' => 'Juan', 'LastName' => 'Santos', 'Email' => 'juan@church.com', 'Password' => Hash::make('password'), 'PhoneNumber' => '0912-111-2222', 'Status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['RoleID' => 1, 'FamilyID' => 1, 'FirstName' => 'Maria', 'LastName' => 'Santos', 'Email' => 'maria@church.com', 'Password' => Hash::make('password'), 'PhoneNumber' => '0912-333-4444', 'Status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['RoleID' => 2, 'FamilyID' => 2, 'FirstName' => 'Pedro', 'LastName' => 'Reyes', 'Email' => 'pedro@church.com', 'Password' => Hash::make('password'), 'PhoneNumber' => '0923-555-6666', 'Status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Ministry
        DB::table('ministries')->insertOrIgnore([
            ['FamilyID' => 1, 'Name' => 'Grace Community Church', 'Address' => '789 Church Rd, General Santos City', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Assets
        DB::table('assets')->insertOrIgnore([
            ['ItemName' => 'Grand Piano', 'SerialNumber' => 'GP-2024-001', 'PurchaseDate' => '2023-01-15', 'Value' => 150000.00, 'created_at' => now(), 'updated_at' => now()],
            ['ItemName' => 'Sound System', 'SerialNumber' => 'SS-2024-002', 'PurchaseDate' => '2023-06-10', 'Value' => 80000.00, 'created_at' => now(), 'updated_at' => now()],
            ['ItemName' => 'Church Van', 'SerialNumber' => 'CV-2024-003', 'PurchaseDate' => '2022-08-20', 'Value' => 650000.00, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Donations
        DB::table('donations')->insertOrIgnore([
            ['MinistryID' => 1, 'Amount' => 5000.00, 'Date' => '2024-01-07', 'FundCategory' => 'Tithe', 'created_at' => now(), 'updated_at' => now()],
            ['MinistryID' => 1, 'Amount' => 2500.00, 'Date' => '2024-01-14', 'FundCategory' => 'Building Fund', 'created_at' => now(), 'updated_at' => now()],
            ['MinistryID' => 1, 'Amount' => 1000.00, 'Date' => '2024-01-21', 'FundCategory' => 'Mission', 'created_at' => now(), 'updated_at' => now()],
            ['MinistryID' => 1, 'Amount' => 3500.00, 'Date' => '2024-02-04', 'FundCategory' => 'Tithe', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Member donations
        DB::table('member_donations')->insertOrIgnore([
            ['MemberID' => 1, 'DonationID' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['MemberID' => 2, 'DonationID' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['MemberID' => 3, 'DonationID' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['MemberID' => 1, 'DonationID' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Expenses
        DB::table('expenses')->insertOrIgnore([
            ['MinistryID' => 1, 'AssetID' => null, 'DonationID' => null, 'Category' => 'Utilities', 'Amount' => 3500.00, 'Vendor' => 'Davao Light', 'Receipt' => null, 'created_at' => now(), 'updated_at' => now()],
            ['MinistryID' => 1, 'AssetID' => 2, 'DonationID' => 2, 'Category' => 'Equipment', 'Amount' => 80000.00, 'Vendor' => 'Audio Tech PH', 'Receipt' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Attendance
        DB::table('attendances')->insertOrIgnore([
            ['MemberID' => 1, 'Status' => 'Present', 'Timestamp' => '2024-01-07 09:00:00', 'created_at' => now(), 'updated_at' => now()],
            ['MemberID' => 2, 'Status' => 'Present', 'Timestamp' => '2024-01-07 09:00:00', 'created_at' => now(), 'updated_at' => now()],
            ['MemberID' => 3, 'Status' => 'Absent', 'Timestamp' => '2024-01-07 09:00:00', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Events
        DB::table('events')->insertOrIgnore([
            ['AttendanceID' => 1, 'ExpensesID' => 1, 'Title' => 'Sunday Worship Service', 'Location' => 'Main Sanctuary', 'StartDateTime' => '2024-01-07 09:00:00', 'EndDateTime' => '2024-01-07 11:00:00', 'created_at' => now(), 'updated_at' => now()],
            ['AttendanceID' => null, 'ExpensesID' => null, 'Title' => 'Youth Camp', 'Location' => 'Camp Grounds, Sarangani', 'StartDateTime' => '2024-02-10 08:00:00', 'EndDateTime' => '2024-02-12 17:00:00', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Users (auth)
        DB::table('users')->insertOrIgnore([
            ['name' => 'Admin User', 'email' => 'admin@church.com', 'password' => Hash::make('password'), 'role' => 'admin', 'MemberID' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Staff User', 'email' => 'staff@church.com', 'password' => Hash::make('password'), 'role' => 'staff', 'MemberID' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Juan Santos', 'email' => 'juan@church.com', 'password' => Hash::make('password'), 'role' => 'member', 'MemberID' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}