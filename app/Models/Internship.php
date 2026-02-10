<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'company_id',
        'advisor_id',
        'start_date',
        'end_date',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function advisor()
    {
        return $this->belongsTo(User::class, 'advisor_id');
    }

    public function guidanceSessions()
    {
        return $this->hasMany(GuidanceSession::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function score()
    {
        return $this->hasOne(Score::class);
    }
}