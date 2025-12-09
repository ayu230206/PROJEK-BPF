<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bpdpks\Kampus; // Pastikan namespace Kampus benar (App\Models\Bpdpks\Kampus atau App\Models\Kampus)
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite; // Tambahkan untuk Google login

class AuthController extends Controller
{
    // --- REGISTER (Fitur ini mungkin jarang dipakai jika Admin yang buatkan akun) ---
    public function showRegister()
    {
        $kampus = Kampus::all(); 
        return view('auth.register', compact('kampus'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6|confirmed',
            'asal_kampus'  => 'required|exists:kampus,id',
            'angkatan'     => 'required|numeric'
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role'         => 'mahasiswa', // Default Role
            'asal_kampus'  => $request->asal_kampus,
            'angkatan'     => $request->angkatan,
            'status_aktif' => true
        ]);

        return redirect()->route('login')->with('status', 'Registrasi berhasil, silakan login.');
    }

    // --- LOGIN ---
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'email'    => $request->email,
            'password' => $request->password
        ];

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->status_aktif == 0) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun Anda dinonaktifkan. Silakan hubungi Admin.']);
            }

            switch ($user->role) {
                case 'admin':
                    return redirect()->intended('/admin/dashboard');
                case 'bpdpks':
                    return redirect()->intended('/bpdpks/dashboard');
                case 'mahasiswa':
                    return redirect()->intended('/mahasiswa/dashboard');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['email' => 'Role akun tidak dikenali.']);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // --- LOGOUT ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('status', 'Berhasil logout.');
    }

    // --- GOOGLE LOGIN ---
    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        // Cek apakah user sudah ada
        $user = User::where('email', $googleUser->email)->first();

        if (!$user) {
            $user = User::create([
                'nama_lengkap' => $googleUser->name,
                'email'        => $googleUser->email,
                'password'     => bcrypt('google_login'), // password default
                'role'         => 'mahasiswa', // default role
                'status_aktif' => true,
                'google_id'    => $googleUser->id
            ]);
        }

        Auth::login($user);

        return redirect('/mahasiswa/dashboard'); // sesuaikan route dashboard
    }
}
