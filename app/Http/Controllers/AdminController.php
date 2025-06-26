<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi;
use App\Models\User;
use App\Models\Gejala;
use App\Models\Pakar;

class AdminController extends Controller
{
    public function index()
    {
        $jumlahUser = User::count();
        $jumlahGejala = Gejala::count();
        $jumlahPakar = Pakar::count();
        $jumlahDiagnosa = Konsultasi::count();

        return view('admin.dashboard', compact(
            'jumlahUser',
            'jumlahGejala',
            'jumlahPakar',
            'jumlahDiagnosa'
        ));
    }
}
