<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

echo "=== LOGIN DEBUG ===\n";

$email = 'admin@codeflix.com';
$password = 'password';

$user = User::where('email', $email)->first();

if (!$user) {
    echo "❌ User not found!\n";
    exit;
}

echo "1. User found: {$user->name} (ID: {$user->id})\n";
echo "2. Stored Hash: " . substr($user->password, 0, 10) . "...\n";

if (Hash::check($password, $user->password)) {
    echo "✅ Hash Check: SUCCESS\n";
} else {
    echo "❌ Hash Check: FAILED\n";
}

echo "3. Attempting Auth::attempt(['email' => '$email', 'password' => '$password'])\n";

if (Auth::attempt(['email' => $email, 'password' => $password])) {
    echo "✅ Auth::attempt returned TRUE\n";
    echo "   User ID in session: " . Auth::id() . "\n";
    
    // Force save session to driver
    session()->save();
    $sessionId = session()->getId();
    echo "   Session ID: " . $sessionId . "\n";

    // Check Redis/File Existence
    $driver = config('session.driver');
    echo "   Session Driver: " . $driver . "\n";

    if ($driver === 'file') {
        $path = storage_path('framework/sessions/' . $sessionId);
        echo "   File Path: " . $path . "\n";
        echo "   File Exists: " . (file_exists($path) ? "YES" : "NO") . "\n";
    } elseif ($driver === 'redis') {
        try {
            $redis = \Illuminate\Support\Facades\Redis::connection('default');
            
            $prefix = config('database.redis.options.prefix');
            echo "   Redis Prefix Configured: " . $prefix . "\n";
            
            // Redis client should handle prefix automatically if configured in options.
            // So we just ask for the key.
            // Typically session key is "laravel_cache_:ID" or just "ID" depending on store.
            // But if we are using 'redis' driver directly, it likely uses 'cache' store? 
            // config/session.php: 'store' => env('SESSION_STORE', 'redis'),
            // If store is 'redis', it uses the setup in cache.php? 
            // No, session.php driver 'redis' uses Cache store.
            
            // Let's try raw ID and with common prefixes, but assuming client handles connection prefix.
            $keysToCheck = [
                $sessionId,
                'laravel_cache_:' . $sessionId,
                $prefix . $sessionId // In case client DOESNT handle it
            ];
            
            $found = false;
            foreach ($keysToCheck as $key) {
                // We use SCAN or KEYS if we are unsure, but let me try getting.
                // Note: exists() might apply prefix.
                try {
                    if ($redis->exists($key)) {
                        echo "   ✅ Redis Key Found (via client): $key\n";
                         echo "      Type: " . $redis->type($key) . "\n";
                        $found = true;
                        break;
                    }
                } catch (\Exception $e) { echo "      Error checking $key: ".$e->getMessage()."\n"; }
            }
            
            if (!$found) {
                echo "   ❌ Redis Key NOT Found via Client.\n";
                // Final hail mary: List ALL keys (careful if many keys)
                $keys = $redis->keys('*' . substr($sessionId, 0, 5) . '*');
                echo "   Matching Keys (*" . substr($sessionId, 0, 5) . "*): " . implode(', ', $keys) . "\n";
            }
            
        } catch (\Exception $e) {
            echo "   Redis Error: " . $e->getMessage() . "\n";
        }
    }

} else {
    echo "❌ Auth::attempt returned FALSE\n";
}
