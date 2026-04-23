<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\People\Member;

$users = User::all();
foreach($users as $user) {
    echo "ID: {$user->id}, Name: {$user->name}, Role: {$user->role}, MemberID: {$user->MemberID}\n";
    if ($user->MemberID) {
        $member = Member::find($user->MemberID);
        if ($member) {
            echo "   -> Member Found: {$member->FirstName} {$member->LastName}, Pic: {$member->profile_picture}\n";
        } else {
            echo "   -> Member NOT FOUND in database!\n";
        }
    } else {
        echo "   -> No MemberID linked.\n";
    }
}
