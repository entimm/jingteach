<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class SettingsController extends Controller
{
    public function show(Request $request)
    {
        $settings = Redis::hgetall('settings');

        return $settings;
    }

    public function update(Request $request)
    {
        $settings = [
            't1' => $request->input('t1', 100),
            't2' => $request->input('t2', 400),
            't3' => $request->input('t3', 1700),
            'n' => $request->input('n', 10),
        ];
        Redis::hmset('settings', $settings);

        return $settings;
    }
}
