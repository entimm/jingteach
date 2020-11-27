<?php

use App\Exports\DataExport;
use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('export', function () {
    ini_set('memory_limit', '102400M');
    $start = null;
    $end = null;

    $end = $end ?? $start;

    $filter = [
        'start' => $start,
        'end' => $end,
    ];

    (new DataExport($filter))->store('data.xlsx');
})->describe('export');
