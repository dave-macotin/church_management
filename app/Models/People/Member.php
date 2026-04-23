<?php

namespace App\Models\People;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\Finance\Donations;
use App\Models\Ministry\Attendance;
use App\Models\Ministry\Event;

class Member extends Model
{
    protected $table = 'members';
    protected $primaryKey = 'MemberID';

    protected $fillable = [
        'RoleID',
        'FamilyID',
        'FirstName',
        'LastName',
        'Email',
        'profile_picture',
        'Password',
        'PhoneNumber',
        'Status',
    ];

    protected $hidden = ['Password'];

    protected $casts = [
        'Status' => 'string',
    ];

    public function getRouteKeyName() { return 'MemberID'; }

    public function getFullNameAttribute(): string
    {
        return "{$this->FirstName} {$this->LastName}";
    }

    // A member belongs to one family
    public function family()
    {
        return $this->belongsTo(Family::class, 'FamilyID', 'FamilyID');
    }

    // A member has one role
    public function role()
    {
        return $this->belongsTo(Role::class, 'RoleID', 'RoleID');
    }

    // A member has many attendance records
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'MemberID', 'MemberID');
    }

    // A member can have many donations (pivot: member_donations)
    public function donations()
    {
        return $this->belongsToMany(Donations::class, 'member_donations', 'MemberID', 'DonationID');
    }

    // A member can be linked to a user account
    public function user()
    {
        return $this->hasOne(\App\Models\User::class, 'MemberID', 'MemberID');
    }

    // Events a member has registered for
    public function registeredEvents()
    {
        return $this->belongsToMany(Event::class, 'event_member', 'MemberID', 'EventID')
                    ->withPivot('registered_at')
                    ->withTimestamps();
    }

    // Groups a member has joined
    public function joinedGroups()
    {
        return $this->belongsToMany(Group::class, 'group_member', 'MemberID', 'GroupID')
                    ->withPivot('joined_at')
                    ->withTimestamps();
    }
}
