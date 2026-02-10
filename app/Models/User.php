<?php

namespace App\Models;

// 1. Import Interface MustVerifyEmail
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// 2. Tambahkan "implements MustVerifyEmail"
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nim',
        'school',
        'phone',
        'profile_photo_path',
        'major',      // Tambahan jika ada jurusan
        'semester',   // Tambahan jika ada semester
        'nidn',       // Tambahan jika ada dosen
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Laravel 10+ recommended
    ];

    // === METHOD CEK ROLE (Helper) ===
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isDosen()
    {
        return $this->role === 'dosen';
    }

    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }

    // === RELASI DATABASE ===
    
    public function internships()
    {
        return $this->hasMany(Internship::class, 'student_id');
    }

    public function supervisedInternships()
    {
        return $this->hasMany(Internship::class, 'advisor_id');
    }

    public function proposedCompanies()
    {
        return $this->hasMany(Company::class, 'proposed_by');
    }

    public function guidanceSessions()
    {
        return $this->hasManyThrough(GuidanceSession::class, Internship::class, 'student_id', 'internship_id');
    }

    public function reports()
    {
        return $this->hasManyThrough(Report::class, Internship::class, 'student_id', 'internship_id');
    }

    public function internshipApplications()
    {
        return $this->hasMany(InternshipApplication::class);
    }
}