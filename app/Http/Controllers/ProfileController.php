<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
{
    $user = auth()->user(); // Ambil user yang login
    return view('profile', compact('user'));
}

public function setProfile(Request $request): RedirectResponse
{

    return redirect()->route('diagnosa.pertanyaan')->with('success', 'Profil berhasil diperbarui');
}
}
