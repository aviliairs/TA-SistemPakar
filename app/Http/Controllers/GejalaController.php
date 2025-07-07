<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GejalaController extends Controller
{
    public function index()
    {
        $gejalas = \App\Models\Gejala::all()->groupBy('kategori');
        return view('admin.Gejala', compact('gejalas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_gejala' => 'required|string|max:255',
            'nama_gejala' => 'required|string|max:255',
            'kategori' => 'required|in:reproduksi,gizi,mental',

        ]);
        Gejala::create($validated);

        return redirect()->route('Gejala.index')->with('success', 'Gejala berhasil ditambahkan');
    }
    public function destroy($id_gejala)
    {
        $gejala = Gejala::findOrFail($id_gejala);
        $gejala->delete();

        return redirect()->back()->with('success', 'Data gejala berhasil dihapus.');
    }

    public function update(Request $request, $id_gejala)
    {
        $request->validate([
            'kode_gejala' => 'required|string|max:255',
            'nama_gejala' => 'required|string|max:255',
            'kategori' => 'required|in:reproduksi,gizi,mental',
        ]);

        $gejala = Gejala::findOrFail($id_gejala);
        $gejala->update($request->all());

        return redirect()->route('Gejala.index')->with('success', 'Data gejala berhasil diupdate');
    }
}
