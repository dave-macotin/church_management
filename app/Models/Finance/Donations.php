<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\People\Member;

class Donations extends Model
{
    use SoftDeletes;

    protected $table      = 'donations';
    protected $primaryKey = 'DonationID';

    protected $fillable = [
        'MinistryID',
        'Amount',
        'Date',
        'FundCategory',
        'PaymentMethod',
        'ReferenceNumber',
    ];

    protected $casts = [
        'Date'   => 'date',
        'Amount' => 'decimal:2',
    ];

    // A donation can belong to many members via member_donations pivot
    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_donations', 'DonationID', 'MemberID')
                    ->withPivot('is_anonymous')
                    ->withTimestamps();
    }
}
