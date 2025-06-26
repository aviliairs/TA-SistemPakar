<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DaftarUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.DaftarUser', compact('users'));
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Data user berhasil dihapus.');
    }

    // public function create()
    // {
    //     return view('admin.Create');
    // }
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'nama' => 'required|string|max:255',
    //         'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
    //         'email' => 'required|email|unique:user,email',
    //         'password' => 'required|email|unique:user,email',

    //     ]);

    //     User::create($validated);

    //     return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    // }
}
