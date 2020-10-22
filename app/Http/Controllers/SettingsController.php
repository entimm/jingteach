<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;

class SettingsController extends Controller
{
    public function show(Request $request)
    {
        $settings = Redis::hgetall('settings');

        $settings = [
            't1' => $settings['t1'] ?? 100,
            't2' => $settings['t2'] ?? 400,
            't3' => $settings['t3'] ?? 1700,
            'n' => $settings['n'] ?? 10,
            'nn' => $settings['nn'] ?? 0,
        ];

        echo '<pre>';
        echo json_encode($settings, JSON_PRETTY_PRINT);
        echo '</pre>';
    }

    public function update(Request $request)
    {
        $settings = array_filter(Arr::only($request->all(), ['t1', 't2', 't3', 'n', 'nn']), function ($item) {
            return $item === null;
        });
        $settings = array_merge(Redis::hgetall('settings'), $settings);
        $settings = [
            't1' => $settings['t1'] ?? 100,
            't2' => $settings['t2'] ?? 400,
            't3' => $settings['t3'] ?? 1700,
            'n' => $settings['n'] ?? 10,
            'nn' => $settings['nn'] ?? 0,
        ];

        Redis::hmset('settings', $settings);

        echo '<pre>';
        echo json_encode($settings, JSON_PRETTY_PRINT);
        echo '</pre>';
    }
}
