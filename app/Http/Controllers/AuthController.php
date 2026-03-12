<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
public function index() {
    $users = User::where('UserID', '!=', Auth::id())->get();
    return view('admin.user_management', compact('users'));
}

public function storePetugas(Request $request) {
    $request->validate([
        'Username' => 'required|unique:user',
        'Password' => 'required|min:5',
        'Email' => 'required|email|unique:user',
        'Role' => 'required|in:admin,petugas' 
    ]);

    User::create([
        'Username' => $request->Username,
        'Password' => Hash::make($request->Password),
        'Email' => $request->Email,
        'NamaLengkap' => $request->NamaLengkap ?? 'Petugas Perpustakaan',
        'Alamat' => $request->Alamat ?? '-',
        'Role' => $request->Role,
    ]);

    return back()->with('success', 'User berhasil didaftarkan!');
}

public function destroy($id) {
    try {
        $user = User::findOrFail($id);

        \DB::table('ulasanbuku')->where('UserID', $id)->delete();

        if (\Schema::hasTable('koleksipribadi')) {
            \DB::table('koleksipribadi')->where('UserID', $id)->delete();
        }

        \DB::table('peminjaman')->where('UserID', $id)->delete();

        $user->delete();

        return back()->with('success', 'User dan semua datanya (ulasan & peminjaman) berhasil dihapus!');
    } catch (\Exception $e) {
        return back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
    }
}
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'Username' => 'required',
            'Password' => 'required',
        ]);

        $user = User::where('Username', $request->Username)->first();

        if ($user && Hash::check($request->Password, $user->Password)) {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['loginError' => 'Username atau Password salah!']);
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
    $request->validate([
        'Username' => 'required|unique:user',
        'Password' => 'required|min:5',
        'Email' => 'required|email|unique:user',
        'NamaLengkap' => 'required',
        'Alamat' => 'required',
    ]);

    $isFirstUser = User::count() === 0;
    $role = $isFirstUser ? 'admin' : 'peminjam';

    User::create([
        'Username' => $request->Username,
        'Password' => Hash::make($request->Password),
        'Email' => $request->Email,
        'NamaLengkap' => $request->NamaLengkap,
        'Alamat' => $request->Alamat,
        'Role' => $role,
    ]);

    if ($isFirstUser) {
        return redirect('/')->with('success_admin', 'Selamat! Anda adalah pendaftar pertama. Akun Anda otomatis menjadi Admin.');
    }

    return redirect('/')->with('success', 'Registrasi berhasil! Silakan login.');
}

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
public function update(Request $request, $id) {
    $user = User::findOrFail($id);

    $request->validate([
        'Username' => 'required|unique:user,Username,'.$id.',UserID',
        'Email' => 'required|email|unique:user,Email,'.$id.',UserID',
        'Role' => 'required|in:admin,petugas'
    ]);

    $data = [
        'Username' => $request->Username,
        'Email' => $request->Email,
        'Role' => $request->Role,
    ];

    if ($request->filled('Password')) {
        $data['Password'] = Hash::make($request->Password);
    }

    $user->update($data);

    return back()->with('success', 'Data user berhasil diperbarui!');
}
}