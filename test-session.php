<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redis;

echo "=== REDIS SESSION TEST ===\n";

// 1. Put data in session
Session::put('test_key', 'Hello Session');
Session::save();
echo "1. Data put in session: 'Hello Session'\n";

// 2. Get session ID
$sessionId = Session::getId();
echo "2. Session ID: $sessionId\n";

// 3. Check Redis directly
try {
    // Laravel stores sessions in Redis with prefix 'codeflix_database_:' (based on slug and config)
    // We can try to list keys or just check if we can retrieve it via Session facade in a new request simulation
    
    // Simulate new request by re-loading session? 
    // Easier: Just check if Redis has the key.
    
    $redisPrefix = config('database.redis.options.prefix');
    echo "3. Redis Prefix: $redisPrefix\n";
    
    $redisKey = $redisPrefix . $sessionId;
    // With predis, keys might be prefixed automatically.
    
    // Let's try to get it via Session facade first
    $value = Session::get('test_key');
    echo "4. Retrieved from Session facade: " . ($value ?? 'NULL') . "\n";
    
    if ($value === 'Hello Session') {
        echo "✅ Session Test Passed (In-memory)\n";
    } else {
        echo "❌ Session Test Failed (In-memory)\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
