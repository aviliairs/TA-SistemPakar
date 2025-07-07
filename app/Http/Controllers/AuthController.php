<?php

namespace App\Http\Controllers;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(): View
    {
        return view('auth.login');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration(): View
    {
        return view('auth.registration');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function postLogin(Request $request): RedirectResponse
    {
   $credentials = $request-> only('email', 'password');

   // Validasi input login
   $request->validate([
       'email' => 'required|email',
       'password' => 'required',
   ]);

    if (auth()->attempt($credentials)) {
        $user = Auth::user();

        $request->session()->regenerate();

       // Jika status aktif, periksa role pengguna
       if ($user->role === 'Admin') {
           return redirect()->route('admin.dashboard');  // Arahkan ke dashboard admin
       } else {
           session(['selected_profile' => $user->id_user,
                    'user_profile' => [
                        'id' => $user->id_user,
                        'nama' => $user->nama,
                        'email' => $user->email,
                        'jenis_kelamin' => $user->jenis_kelamin,
                        'avatar' => $user->avatar ?? 'default-avatar.png'
               ]]);

            return redirect()->route('diagnosa.form');
        }
   }

   // Jika login gagal
   return redirect()->route('login')->with('error', 'Email atau Password salah.');
}


/**
* Write code on Method
*
* @return response()
*/
    public function postRegistration(Request $request) : RedirectResponse
    {

    $validatedData = $request->validate([
    'nama'=> 'required|string|max:50',
    'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
    'email' => 'required|email|unique:user,email',
    'password' => 'required|string|min:6|confirmed',
    ]);

    // Debugging setelah validasi
    \Log::info('Data validasi: ' . print_r($validatedData, true));

    // Hash password sebelum disimpan
    $validatedData['password'] = bcrypt($validatedData['password']);
    $validatedData['status'] = 'Aktif';
    $validatedData['role'] = 'User';

    // Debugging sebelum insert database
    \Log::info('Data sebelum disimpan: ' . print_r($validatedData, true));

    // Simpan ke database
    $user = User::create($validatedData);

    if ($user) {
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
    return back()->with('error', 'Registrasi gagal, coba lagi.');

    }
     public function logout(Request $request): RedirectResponse
    {
        // Ambil role user sebelum logout
        $userRole = Auth::user()->role ?? null;

        // Logout user dari sistem autentikasi
        Auth::logout();

        // Hapus semua session
        $request->session()->invalidate();

        // Regenerate session token untuk keamanan
        $request->session()->regenerateToken();

        // Redirect berdasarkan role
        if ($userRole === 'Admin') {
            return redirect()->route('login')->with('success', 'Admin berhasil logout.');
        } else {
            return redirect()->route('login')->with('success', 'Anda berhasil logout.');
        }
    }
}
