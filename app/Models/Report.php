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
        'internship_id',
        'application_id', // <--- TAMBAHKAN BARIS INI
        'activity_date',
        'description',
        'title',
        'file_path',
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