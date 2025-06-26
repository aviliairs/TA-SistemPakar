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
        $aturans = aturan::all();
        return view('admin.DaftarAturan', compact('aturans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_rule' => 'required|string|max:10',
            'kode_gejala' => 'required|string|max:255',
            'kategori' => 'required|in:reproduksi,gizi,mental',
            'kondisi' => 'required|string|max:15',
            'kesimpulan' => 'required|string|max:10000',

        ]);
        aturan::create($validated);

        return redirect()->route('DaftarAturan.index')->with('success', 'Aturan berhasil ditambahkan');
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
            'kondisi' => 'required|string|max:15',
            'kesimpulan' => 'required|string|max:10000',
        ]);

        $aturan = Aturan::findOrFail($id);
        $aturan->update($request->all());

        return redirect()->route('DaftarAturan.index')->with('success', 'Aturan berhasil diupdate');
    }
}
