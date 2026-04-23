<?php

namespace App\Models\Ministry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\People\Member;

class Attendance extends Model
{
    use SoftDeletes;

    protected $table      = 'attendances';
    protected $primaryKey = 'AttendanceID';

    protected $fillable = [
        'MemberID',
        'EventID',
        'Status',
        'Timestamp',
        'CheckInTime',
        'CheckOutTime',
    ];

    protected $casts = [
        'Timestamp'    => 'datetime',
        'CheckInTime'  => 'datetime',
        'CheckOutTime' => 'datetime',
    ];

    public function getRouteKeyName() { return 'AttendanceID'; }

    public function member()
    {
        return $this->belongsTo(Member::class, 'MemberID', 'MemberID');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'EventID', 'EventID');
    }
}
