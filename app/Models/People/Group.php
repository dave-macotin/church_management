<?php

namespace App\Models\People;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\Ministry\Event;

class Group extends Model
{
    protected $table = 'groups';
    protected $primaryKey = 'GroupID';

    protected $fillable = [
        'EventID',
        'GroupName',
        'Description',
    ];

    public function getRouteKeyName() { return 'GroupID'; }

    public function event()
    {
        return $this->belongsTo(Event::class, 'EventID', 'EventID');
    }

    public function roles()
    {
        return $this->hasMany(Role::class, 'GroupID', 'GroupID');
    }

    // Members who joined this group
    public function members()
    {
        return $this->belongsToMany(Member::class, 'group_member', 'GroupID', 'MemberID')
                    ->withPivot('joined_at')
                    ->withTimestamps();
    }
}
