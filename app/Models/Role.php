<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\People\Group;
use App\Models\People\Member;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'RoleID';

    protected $fillable = [
        'GroupID',
        'RoleName',
        'Permission',
    ];

    public function getRouteKeyName() { return 'RoleID'; }

    // The group this role belongs to
    public function group()
    {
        return $this->belongsTo(Group::class, 'GroupID', 'GroupID');
    }

    // Members assigned this role
    public function members()
    {
        return $this->hasMany(Member::class, 'RoleID', 'RoleID');
    }
}
