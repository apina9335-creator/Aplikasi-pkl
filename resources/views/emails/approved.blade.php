<div style="font-family: Arial, sans-serif; max-w: 600px; margin: auto; padding: 20px; border: 1px solid #e5e7eb; border-radius: 10px;">
    <h2 style="color: #059669;">Pendaftaran PKL Disetujui! 🎉</h2>
    <p>Halo, <strong>{{ $application->name }}</strong>!</p>
    <p>Selamat, pendaftaran Praktek Kerja Lapangan (PKL) Anda telah di-Approve oleh Admin.</p>
    
    <div style="background-color: #f3f4f6; padding: 15px; border-radius: 8px; text-align: center; margin: 20px 0;">
        <p style="margin: 0; color: #6b7280; font-size: 14px;">TOKEN AKSES LOGBOOK ANDA:</p>
        <h1 style="margin: 5px 0 0 0; color: #2563eb; letter-spacing: 3px;">{{ $application->token }}</h1>
    </div>

    <p>Silakan gunakan Token tersebut di halaman utama web kami untuk masuk ke form <strong>Logbook Harian</strong>. Harap berikan juga token ini kepada Guru/Dosen Pembimbing Anda agar mereka bisa memantau kegiatan Anda.</p>
    <p>Semangat dan sukses untuk magangnya!</p>
    
    <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">
    <p style="font-size: 12px; color: #9ca3af;">Email ini dikirim otomatis oleh Sistem Informasi PKL (SIPKL).</p>
</div>