<?php
$vendor = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($vendor)) {
    echo json_encode(['error' => 'vendor/autoload.php not found. Run composer install first.']);
    exit(1);
}
require $vendor;
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\InternshipApplication;

$statuses = ['approved', 'diterima', 'accepted'];

$apps = InternshipApplication::whereIn('status', $statuses)
    ->with('user')
    ->get()
    ->map(function($a){
        return [
            'id' => $a->id,
            'user_id' => $a->user_id,
            'user_email' => $a->user->email ?? null,
            'user_name' => $a->user->name ?? null,
            'status' => $a->status,
            'approved_at' => $a->approved_at ? $a->approved_at->toDateTimeString() : null,
        ];
    });

echo json_encode($apps, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
