<?php

namespace App\Models\People;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ministry;

class Family extends Model
{
    protected $table = 'families';
    protected $primaryKey = 'FamilyID';

    protected $fillable = [
        'MemberID',
        'FamilyName',
        'HomeAddress',
        'PhoneNumber',
    ];

    public function getRouteKeyName() { return 'FamilyID'; }

    // The head/primary member of the family
    public function headMember()
    {
        return $this->belongsTo(Member::class, 'MemberID', 'MemberID');
    }

    // All members belonging to this family
    public function members()
    {
        return $this->hasMany(Member::class, 'FamilyID', 'FamilyID');
    }

    // Ministries associated with this family
    public function ministries()
    {
        return $this->hasMany(Ministry::class, 'FamilyID', 'FamilyID');
    }
}
