<?php
// app/Models/GuidanceSession.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuidanceSession extends Model
{
    protected $fillable = [
        'internship_id', 'session_date', 'session_time', 'topic', 
        'notes', 'status', 'advisor_notes'
    ];

    protected $casts = [
        'session_date' => 'date',
    ];

    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class);
    }
}