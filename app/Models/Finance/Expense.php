<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ministry\Event;

class Expense extends Model
{
    protected $table      = 'expenses';
    protected $primaryKey = 'ExpenseID';

    protected $fillable = [
        'MinistryID',
        'AssetID',
        'DonationID',
        'EventID',
        'Category',
        'Amount',
        'Vendor',
        'Receipt',
    ];

    protected $casts = [
        'Amount' => 'decimal:2',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'EventID', 'EventID');
    }
}
