<div style="font-family: Arial, sans-serif; max-w: 600px; margin: auto; padding: 20px; border: 1px solid #e5e7eb; border-radius: 10px;">
    <h2 style="color: #dc2626;">Pendaftaran PKL Ditolak ❌</h2>
    <p>Halo, <strong>{{ $application->name }}</strong>.</p>
    <p>Mohon maaf, pendaftaran Praktek Kerja Lapangan (PKL) Anda saat ini belum dapat kami setujui.</p>
    
    <p><strong>Alasan Penolakan dari Admin:</strong></p>
    <div style="background-color: #fef2f2; border-left: 4px solid #ef4444; padding: 15px; border-radius: 0 8px 8px 0; margin: 10px 0; color: #991b1b;">
        <em>"{{ $application->rejection_reason }}"</em>
    </div>

    <p>Silakan perbaiki data Anda sesuai dengan catatan di atas dan lakukan pendaftaran ulang melalui website kami.</p>
    
    <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">
    <p style="font-size: 12px; color: #9ca3af;">Email ini dikirim otomatis oleh Sistem Informasi PKL (SIPKL).</p>
</div>