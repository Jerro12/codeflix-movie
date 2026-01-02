<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\UserDevice;

$user = User::where('email', 'admin@codeflix.com')->first();
$count = UserDevice::where('user_id', $user->id)->count();

echo "User: {$user->name}\n";
echo "Current Device Count: {$count}\n";

// Clear devices
UserDevice::where('user_id', $user->id)->delete();
echo "Cleared all devices.\n";
