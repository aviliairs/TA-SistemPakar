<?php

namespace App\Http\Controllers;

use App\Models\Aturan;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AturanController extends Controller
{
    public function index()
    {
        $aturans = \App\Models\Aturan::all()->groupBy('kategori');
        return view('admin.DaftarAturan', compact('aturans')); //mengirim variabel ke view blade
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_rule' => 'required|string|max:10',
            'kode_gejala' => 'required|string|max:255',
            'kategori' => 'required|in:reproduksi,gizi,mental',
            'kondisi' => 'required|string|max:50',
            'kesimpulan' => 'required|string|max:10000',

        ]);
        aturan::create($validated);

        return redirect()->route('aturan.index')->with('success', 'Aturan berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $aturan = Aturan::findOrFail($id);
        $aturan->delete();

        return redirect()->back()->with('success', 'Aturan berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_rule' => 'required|string|max:10',
            'kode_gejala' => 'required|string|max:255',
            'kategori' => 'required|in:reproduksi,gizi,mental',
            'kondisi' => 'required|string|max:50',
            'kesimpulan' => 'required|string|max:10000',
        ]);

        $aturan = Aturan::findOrFail($id);
        $aturan->update($request->all());

        return redirect()->route('aturan.index')->with('success', 'Aturan berhasil diupdate');
    }
}
