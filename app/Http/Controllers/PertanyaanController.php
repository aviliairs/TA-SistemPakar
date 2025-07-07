<?php

namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanController extends Controller
{
    public function index()
    {
        $pertanyaans = \App\Models\Pertanyaan::all()->groupBy('kategori');

        return view('admin.Pertanyaan', compact('pertanyaans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_gejala' => 'required|string|max:255',
            'pertanyaan' => 'required|string|max:255',
            'kategori' => 'required|in:reproduksi,gizi,mental',

        ]);

        $validated['tampilkan_di_user'] = $request->has('tampilkan_di_user');
        Pertanyaan::create($validated);

        return redirect()->route('Pertanyaan.index')->with('success', 'Pertanyaan berhasil ditambahkan');
    }
    public function destroy($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->delete();

        return redirect()->back()->with('success', 'Pertanyaan berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
       $validated = $request->validate([
            'kode_gejala' => 'required|string|max:255',
            'pertanyaan' => 'required|string|max:255',
            'kategori' => 'required|in:reproduksi,gizi,mental',
        ]);

        $validated['tampilkan_di_user'] = $request->has('tampilkan_di_user');

        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->update($validated);

        return redirect()->route('Pertanyaan.index')->with('success', 'Pertanyaan berhasil diupdate');
    }
}
