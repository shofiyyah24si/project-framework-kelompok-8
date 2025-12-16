<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Menampilkan form login
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Proses login user
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'string'],
                'password' => ['required', 'string'],
            ], [
                'email.required' => 'Email atau username harus diisi.',
                'password.required' => 'Password harus diisi.',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // Tentukan field untuk login (email atau username)
            $field = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            
            $credentials = [
                $field => $request->email,
                'password' => $request->password,
            ];

            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                $user = Auth::user();

                return $this->redirectBasedOnRole($user)
                    ->with('success', 'Login berhasil! Selamat datang ' . $user->name);
            }

            throw ValidationException::withMessages([
                'email' => 'Kredensial tidak valid.',
            ]);

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput($request->except('password'))
                ->with('error', 'Login gagal. Silakan cek kredensial Anda.');

        } catch (\Exception $e) {
            return back()
                ->withInput($request->except('password'))
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Redirect berdasarkan role user
     * SEMUA ROLE DIARAHKAN KE DASHBOARD YANG SAMA
     * Middleware akan mengatur pembatasan akses
     */
    private function redirectBasedOnRole($user)
    {
        // SEMUA ROLE DIARAHKAN KE ROUTE 'dashboard' YANG SAMA
        // DashboardController akan menampilkan konten berbeda berdasarkan role
        // Middleware akan membatasi akses warga ke route lain
        
        return redirect()->route('dashboard');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')
            ->with('success', 'Anda telah logout.');
    }

    /**
     * Halaman unauthorized (opsional, bisa juga dihandle oleh middleware)
     */
    public function unauthorized()
    {
        return response()->view('errors.403', [], 403);
    }
}