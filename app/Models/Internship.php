<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'school',
        'start_date',
        'end_date',
        'motivation',
        'cv_path',
        'status',
        'applied_at',
        'registration_type', // <--- TAMBAHKAN DI SINI KAK
        'group_members',     // <--- TAMBAHKAN DI SINI KAK
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'applied_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}