<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');



// php artisan schedule:list        untuk liat list schedule yang ada
// php artisan schedule:run         untuk ngepush schedule ke queue tabel jobs
// php artisan queue:work           untuk menjalankan queue di tabel jobs