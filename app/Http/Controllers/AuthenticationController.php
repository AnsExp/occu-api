<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function index()
    {
        return view('authentication.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Las credenciales no son correctas.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function changePassword(Request $request, User $user)
    {
        $credentials = $request->validate(['password' => ['required', 'string', 'confirmed', 'min:8']]);

        $user->password = bcrypt($credentials['password']);
        $user->save();

        return redirect()->back()->with('status', 'Contraseña actualizada correctamente.');
    }
}
