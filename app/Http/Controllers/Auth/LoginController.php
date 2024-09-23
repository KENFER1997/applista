<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Mostrar el formulario de inicio de sesión
    public function showLoginForm()
    {
        return view('Iniciosesion.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $ipAddress = $request->ip();

        if (Auth::attempt($credentials)) {
            LoginAttempt::create([
                'user_id' => Auth::id(),
                'ip_address' => $ipAddress,
                'successful' => true,
            ]);

            return redirect()->route('listas.index')->with('success', 'Has iniciado sesión correctamente.'); // Cambiado aquí
        } else {
            LoginAttempt::create([
                'user_id' => null, 
                'ip_address' => $ipAddress,
                'successful' => false,
            ]);

            return back()->withErrors([
                'email' => 'Las credenciales proporcionadas son incorrectas.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Has cerrado sesión.');
    }
}
