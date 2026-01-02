<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

echo "=== CODEFLIX INFRASTRUCTURE TEST ===\n\n";

// 1. Test Redis Cache
echo "1. REDIS CACHE TEST\n";
try {
    Cache::put('infra-test', 'Redis working at ' . now(), 60);
    $result = Cache::get('infra-test');
    echo "   ✅ SUCCESS: $result\n";
} catch (Exception $e) {
    echo "   ❌ ERROR: " . $e->getMessage() . "\n";
}
echo "\n";

// 2. Test Minio Storage  
echo "2. MINIO STORAGE TEST\n";
try {
    $testContent = "Minio test file created at " . now();
    Storage::disk('s3')->put('test-codeflix.txt', $testContent);
    echo "   ✅ File uploaded successfully\n";
    
    $retrieved = Storage::disk('s3')->get('test-codeflix.txt');
    echo "   ✅ File retrieved: $retrieved\n";
    
    Storage::disk('s3')->delete('test-codeflix.txt');
    echo "   ✅ File deleted\n";
} catch (Exception $e) {
    echo "   ❌ ERROR: " . $e->getMessage() . "\n";
}
echo "\n";

// 3. Test Mailpit  
echo "3. MAILPIT EMAIL TEST\n";
try {
    Mail::raw('This is a test email from Codeflix infrastructure test. Time: ' . now(), function ($message) {
        $message->to('test@example.com')
                ->subject('Codeflix Infrastructure Test');
    });
    echo "   ✅ Email sent! Check Mailpit at http://127.0.0.1:8025\n";
} catch (Exception $e) {
    echo "   ❌ ERROR: " . $e->getMessage() . "\n";
}
echo "\n";

echo "=== TEST COMPLETE ===\n";
