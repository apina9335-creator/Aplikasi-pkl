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

use App\Models\User;

$q = $argv[1] ?? null;
if (!$q) {
    echo json_encode(['error' => 'Usage: php find_user.php <email-or-part>']);
    exit(1);
}

$users = User::where('email', 'like', "%$q%")
    ->orWhere('email', $q)
    ->get(['id','name','email','role','created_at'])
    ->toArray();

echo json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
