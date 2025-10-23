<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@uth\.edu\.mx$/',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:15',
                'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/',
            ],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'email.regex' => 'El correo debe tener el formato @uth.edu.mx',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.max' => 'La contraseña no puede tener más de 15 caracteres.',
            'password.regex' => 'La contraseña debe contener al menos una letra, un número y un carácter especial.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return $this->redirectToDashboard();
        }

        return back()
            ->withErrors([
                'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ])
            ->withInput($request->only('email'));
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('success', 'Sesión cerrada exitosamente.');
    }
    
    /**
     * Redirect user to appropriate dashboard based on their role
     */
    public function redirectToDashboard()
    {
        $user = Auth::user();
        
        // Check if user has a role assigned
        if (!$user->role) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'No tienes un rol asignado. Contacta al administrador.');
        }
        
        // Get user role name
        $roleName = $user->role->nombre;
        
        // Redirect based on role name
        switch ($roleName) {
            case 'Administrador':
                return redirect()->route('admin.dashboard');
            case 'Director':
                return redirect()->route('director.dashboard');
            case 'Profesor':
                return redirect()->route('teacher.dashboard');
            case 'Estudiante':
                return redirect()->route('student.dashboard');
            case 'Biblioteca':
                return redirect()->route('biblioteca.dashboard');
        }
        
        // If no specific permissions found, logout and redirect to login
        Auth::logout();
        return redirect()->route('login')->with('error', 'No tienes permisos para acceder al sistema.');
    }
}