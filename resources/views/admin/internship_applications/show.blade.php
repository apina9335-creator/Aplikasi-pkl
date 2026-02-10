@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.internship-applications.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Kembali ke Daftar
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-3 gap-6 mb-8">
            <!-- Mahasiswa Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-sm font-semibold text-gray-600 mb-3">Mahasiswa</h3>
                <p class="text-lg font-bold text-gray-900">{{ $internshipApplication->user->name }}</p>
                <p class="text-sm text-gray-600">{{ $internshipApplication->user->email }}</p>
            </div>

            <!-- Perusahaan Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-sm font-semibold text-gray-600 mb-3">Perusahaan</h3>
                <p class="text-lg font-bold text-gray-900">{{ $internshipApplication->company->name }}</p>
                <p class="text-sm text-gray-600">{{ $internshipApplication->company->city }}</p>
            </div>

            <!-- Status Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-sm font-semibold text-gray-600 mb-3">Status</h3>
                <span class="inline-block px-3 py-1 text-sm font-medium rounded-full
                    @if ($internshipApplication->status === 'pending')
                        bg-yellow-100 text-yellow-800
                    @elseif ($internshipApplication->status === 'approved')
                        bg-green-100 text-green-800
                    @else
                        bg-red-100 text-red-800
                    @endif
                ">
                    {{ ucfirst($internshipApplication->status) }}
                </span>
            </div>
        </div>

        <!-- Motivasi -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Motivasi Aplikasi</h3>
            <div class="bg-gray-50 p-4 rounded text-gray-700 whitespace-pre-line">
                {{ $internshipApplication->motivation }}
            </div>
        </div>

        <!-- File Lampiran -->
        @if ($internshipApplication->attachment_path)
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">File Lampiran</h3>
                <a href="{{ Storage::url($internshipApplication->attachment_path) }}" target="_blank"
                   class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    📥 Download File
                </a>
            </div>
        @endif

        <!-- Rejection Reason (jika ditolak) -->
        @if ($internshipApplication->isRejected())
            <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-red-900 mb-2">Alasan Penolakan</h3>
                <p class="text-red-700">{{ $internshipApplication->rejection_reason }}</p>
                <p class="text-sm text-red-600 mt-2">Oleh: {{ $internshipApplication->approved_by }}</p>
            </div>
        @endif

        <!-- Approval Reason (jika disetujui) -->
        @if ($internshipApplication->isApproved())
            <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-green-900 mb-2">Disetujui</h3>
                <p class="text-green-700">Disetujui oleh {{ $internshipApplication->approved_by }} pada {{ $internshipApplication->approved_at?->format('d F Y') }}</p>
            </div>
        @endif

        <!-- Action Buttons -->
        @if ($internshipApplication->isPending())
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tindakan</h3>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <!-- Approve -->
                    <form action="{{ route('admin.internship-applications.approve', $internshipApplication) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-6 py-3 bg-green-500 text-white rounded font-semibold hover:bg-green-600 transition"
                                onclick="return confirm('Setujui aplikasi ini?')">
                            ✓ Setujui Aplikasi
                        </button>
                    </form>

                    <!-- Reject Button Toggle -->
                    <button onclick="toggleRejectForm()" class="w-full px-6 py-3 bg-red-500 text-white rounded font-semibold hover:bg-red-600 transition">
                        ✗ Tolak Aplikasi
                    </button>
                </div>

                <!-- Reject Form (Hidden) -->
                <div id="rejectForm" class="hidden border-t pt-6">
                    <form action="{{ route('admin.internship-applications.reject', $internshipApplication) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                                Alasan Penolakan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="rejection_reason" id="rejection_reason" rows="4" required 
                                      placeholder="Jelaskan alasan penolakan aplikasi ini..."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"></textarea>
                            @error('rejection_reason')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex gap-4">
                            <button type="submit" class="flex-1 px-6 py-2 bg-red-500 text-white rounded hover:bg-red-600 font-semibold"
                                    onclick="return confirm('Tolak aplikasi ini?')">
                                Konfirmasi Penolakan
                            </button>
                            <button type="button" onclick="toggleRejectForm()" class="flex-1 px-6 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    function toggleRejectForm() {
        const form = document.getElementById('rejectForm');
        form.classList.toggle('hidden');
    }
</script>
@endsection
