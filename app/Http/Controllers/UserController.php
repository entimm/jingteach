<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        session(['school' => $request->school]);
        session(['class' => $request->class]);
        session(['student_no' => $request->student_no]);
    }

    public function quit(Request $request)
    {
        $request->session()->flush();

        return response()->redirectTo('/login');
    }
}
