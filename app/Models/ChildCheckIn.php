<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildCheckIn extends Model
{
    protected $fillable = ['child_id', 'parent_id', 'type', 'timestamp', 'session_name'];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function parent()
    {
        return $this->belongsTo(\App\Models\People\Member::class, 'parent_id', 'MemberID');
    }
}
