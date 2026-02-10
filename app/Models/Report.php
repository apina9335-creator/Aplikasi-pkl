<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * PERBAIKAN:
     * 1. Ganti 'photo_path' jadi 'image_path' (sesuai migrasi).
     * 2. Pastikan 'user_id' atau 'internship_id' sesuai dengan tabel database Anda.
     * (Jika tabelnya punya kolom internship_id, ganti user_id jadi internship_id).
     */
    protected $fillable = [
        'user_id',       // Ganti ke 'internship_id' jika tabel Anda pakai relasi ke tabel internships
        'activity_date', // Pastikan di database namanya memang 'activity_date'
        'description',   // Pastikan di database namanya 'description'
        'image_path'     // <--- WAJIB: Harus sama dengan yang kita buat di migrasi tadi
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    // Opsional: Jika Anda menggunakan internship_id
    /*
    public function internship() {
        return $this->belongsTo(Internship::class);
    }
    */
}