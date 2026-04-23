<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sermon extends Model
{
    protected $fillable = [
        'title',
        'preacher',
        'description',
        'preached_at',
        'video_url',
        'series',
        'is_approved',
        'submitted_by',
    ];

    protected $casts = [
        'preached_at' => 'date',
        'is_approved' => 'boolean',
    ];

    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by', 'id');
    }
}
