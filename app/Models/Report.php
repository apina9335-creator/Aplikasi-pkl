<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * Kolom-kolom yang boleh diisi secara massal (Mass Assignment)
     */
    protected $fillable = [
        'internship_id', // Kita pakai internship_id, bukan user_id lagi
        'activity_date',
        'description',
        'title',         // Bawaan dari migrasi
        'file_path',     // Bawaan dari migrasi
        'image_path',
        'status',
        'feedback',
        'reviewed_by',
        'reviewed_at',
    ];

    /**
     * Mengubah format data saat diambil dari database
     */
    protected $casts = [
        'activity_date' => 'date',
        'reviewed_at'   => 'datetime',
    ];

    /**
     * Relasi ke tabel internships
     */
    public function internship() 
    {
        return $this->belongsTo(Internship::class);
    }

    /**
     * Relasi ke tabel users (Dosen/Admin yang mereview)
     */
    public function reviewer() 
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}