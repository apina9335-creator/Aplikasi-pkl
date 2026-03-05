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

$users = User::where('role','mahasiswa')->get(['id','name','email'])->toArray();
echo json_encode($users, JSON_PRETTY_PRINT);
