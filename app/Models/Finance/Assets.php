<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class Assets extends Model
{
    protected $table      = 'assets';
    protected $primaryKey = 'AssetID';

    // Exact columns from DB: AssetID, ItemName, SerialNumber, PurchaseDate, Value
    protected $fillable = [
        'ItemName',
        'SerialNumber',
        'PurchaseDate',
        'Value',
    ];

    protected $casts = [
        'PurchaseDate' => 'date',
        'Value'        => 'decimal:2',
    ];
}
