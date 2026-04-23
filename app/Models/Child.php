<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $fillable = ['parent_id', 'FirstName', 'LastName', 'BirthDate', 'MedicalNotes', 'PickupCode', 'IsActive'];

    public function parent()
    {
        return $this->belongsTo(\App\Models\People\Member::class, 'parent_id', 'MemberID');
    }

    public function checkIns()
    {
        return $this->hasMany(ChildCheckIn::class);
    }
}
