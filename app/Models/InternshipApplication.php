<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipApplication extends Model
{
    protected $fillable = [
        'token',
        'name',
        'email',
        'school',
        'registration_type',
        'group_members',
        'motivation',
        'status',
        'user_id',
        'company_id',
        'attachment_path',
        'rejection_reason',  // <--- Tambah koma di sini
        'start_date',        // <--- Tambah koma di sini
        'end_date',
        'phone',
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