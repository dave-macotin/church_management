<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\People\Family;

class Ministry extends Model
{
    protected $table = 'ministries';
    protected $primaryKey = 'MinistryID';

    protected $fillable = [
        'FamilyID',
        'Name',
        'Address',
    ];

    public function getRouteKeyName() { return 'MinistryID'; }

    // The family associated with this ministry
    public function family()
    {
        return $this->belongsTo(Family::class, 'FamilyID', 'FamilyID');
    }

    // Donations given to this ministry
    public function donations()
    {
        return $this->hasMany(Donation::class, 'MinistryID', 'MinistryID');
    }

    // Expenses under this ministry
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'MinistryID', 'MinistryID');
    }
}
