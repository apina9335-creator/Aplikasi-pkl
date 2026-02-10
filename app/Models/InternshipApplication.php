<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipApplication extends Model
{
    protected $fillable = [
        'user_id',
        'school',      // <--- Tambahan Baru
        'start_date',  // <--- Tambahan Baru
        'end_date',
        'company_id',
        'status',
        'motivation',
        'attachment_path',
        'applied_at',
        'approved_at',
        'approved_by',
        'rejection_reason',
         'cv_path',
    ];

    protected $casts = [
        'applied_at' => 'date',
        'approved_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}

