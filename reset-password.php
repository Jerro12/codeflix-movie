<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('email', 'admin@codeflix.com')->first();
if ($user) {
    $user->password = Hash::make('password');
    $user->save();
    echo "Password for admin@codeflix.com reset to 'password' successfully.\n";
} else {
    echo "User admin@codeflix.com not found.\n";
}
