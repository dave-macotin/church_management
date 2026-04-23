<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerOpportunity extends Model
{
    protected $fillable = ['title', 'description', 'category', 'date', 'time_slot', 'needed_volunteers', 'is_active'];

    public function registrations()
    {
        return $this->hasMany(VolunteerRegistration::class, 'opportunity_id');
    }
}
