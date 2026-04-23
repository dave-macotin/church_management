<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerRegistration extends Model
{
    protected $fillable = ['opportunity_id', 'member_id', 'status', 'notes'];

    public function opportunity()
    {
        return $this->belongsTo(VolunteerOpportunity::class, 'opportunity_id');
    }

    public function member()
    {
        return $this->belongsTo(\App\Models\People\Member::class, 'member_id', 'MemberID');
    }
}
