<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function index()
    {
        return view('welcome');
    }

    public function login(Request $request)
    {
        $request->validate([
            'rut' => 'required',
            'password' => 'required',
        ]);
 
        $credentials = $request->only('rut', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('leykarin.info');
        }
 
        return redirect()->back()->withErrors(['rut' => 'Credenciales inválidas']);
       
    }
}
