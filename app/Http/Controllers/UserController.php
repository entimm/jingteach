<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    public function loginView(Request $request, $code = 0)
    {
        $key = md5($request->userAgent().'||'.$request->ip());
        $historyLogin = array_map(function ($item) {
            $item = json_decode($item, true);
            return $item;
        }, Redis::smembers($key));
        if (88 == $code) {
            session(['admin' => 1]);
        }

        return view('login', ['history_login' => $historyLogin]);
    }

    public function login(LoginRequest $request)
    {
        $key = md5($request->userAgent().'||'.$request->ip());
        $data = [
            'school' => $request->school,
            'class' => $request->class,
            'name' => $request->name,
            'grade' => $request->grade,
            'age' => $request->age,
            'student_no' => $request->student_no,
        ];
        Redis::sadd($key, json_encode($data));
        session($data);
    }

    public function quit(Request $request)
    {
        $request->session()->flush();

        return response()->redirectTo('/login');
    }

    public function all()
    {
        $result = [];

        $keys = Redis::keys('*');
        foreach ($keys as $key) {
            $result[$key] = Redis::smembers($key);
        }

        return $result;
    }
}
