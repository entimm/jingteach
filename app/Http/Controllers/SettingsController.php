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
            't_guide' => $settings['t_guide'] ?? 100,
            't_interval' => $settings['t_interval'] ?? 400,
            't_rt_max' => $settings['t_rt_max'] ?? 1700,
            'n' => $settings['n'] ?? 10,
            't_total' => $settings['t_total'] ?? 3500,
            // 'nn' => $settings['nn'] ?? 0,
        ];

        return view('settings', ['settings' => $settings]);
    }

    public function update(Request $request)
    {
        $settings = array_filter(Arr::only($request->all(), ['t_guide', 't_interval', 't_rt_max', 'n', 'nn']), function ($item) {
            return $item !== null;
        });
        $settings = array_merge(Redis::hgetall('settings'), $settings);
        $settings = [
            't_guide' => $settings['t_guide'] ?? 100,
            't_interval' => $settings['t_interval'] ?? 400,
            't_rt_max' => $settings['t_rt_max'] ?? 1700,
            'n' => $settings['n'] ?? 10,
            't_total' => $settings['t_total'] ?? 3500
            // 'nn' => $settings['nn'] ?? 0,
        ];

        Redis::hmset('settings', $settings);

        return view('settings', ['settings' => $settings]);
    }
}
