<?php

namespace App\Models\Ministry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\People\Group;

class Event extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'EventID';

    protected $fillable = [
        'AttendanceID',
        'ExpensesID',
        'Location',
        'StartDateTime',
        'EndDateTime',
        'Title',
        'image',
        'is_approved',
        'submitted_by',
    ];

    protected $casts = [
        'StartDateTime' => 'datetime',
        'EndDateTime'   => 'datetime',
        'is_approved'   => 'boolean',
    ];

    public function getRouteKeyName() { return 'EventID'; }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'AttendanceID', 'AttendanceID');
    }

    public function expense()
    {
        return $this->belongsTo(\App\Models\Finance\Expense::class, 'ExpensesID', 'ExpenseID');
    }

    public function groups()
    {
        return $this->hasMany(Group::class, 'EventID', 'EventID');
    }

    public function registeredMembers()
    {
        return $this->belongsToMany(\App\Models\People\Member::class, 'event_member', 'EventID', 'MemberID')
                    ->withPivot('registered_at')
                    ->withTimestamps();
    }

    public function submittedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'submitted_by', 'id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function isUpcoming(): bool
    {
        return $this->StartDateTime && $this->StartDateTime->isFuture();
    }
}
