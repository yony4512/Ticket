<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DirectPasswordResetController extends Controller
{
    public function showForm()
    {
        return view('auth.direct-password-reset');
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return view('auth.direct-password-reset', [
                'email' => $request->email,
                'showPasswordFields' => true
            ]);
        } else {
            return back()->withErrors(['email' => 'El correo no existe en el sistema.'])->withInput();
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('login')->with('status', '¡Contraseña actualizada correctamente! Ahora puedes iniciar sesión.');
        } else {
            return back()->withErrors(['email' => 'El correo no existe en el sistema.'])->withInput();
        }
    }
} 