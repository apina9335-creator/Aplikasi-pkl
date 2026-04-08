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
        'user_id',       // Ganti ke 'internship_id' jika tabel Anda pakai relasi ke tabel internships
        'activity_date', // Pastikan di database namanya memang 'activity_date'
        'description',   // Pastikan di database namanya 'description'
        'image_path',
        'status',        // <--- WAJIB: Harus sama dengan yang kita buat di migrasi tadi
    ];

    /**
     * PERBAIKAN: 
     * $casts diletakkan di SINI, terpisah dari $fillable.
     * Ini yang bertugas mengubah teks "2026-03-26" menjadi format Waktu/Tanggal.
     */
    protected $casts = [
        'activity_date' => 'date',
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