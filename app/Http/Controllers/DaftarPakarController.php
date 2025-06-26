<?php

namespace App\Http\Controllers;

use App\Models\pakar;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarPakarController extends Controller
{
    public function index()
    {
        $pakars = pakar::all();
        return view('admin.DaftarPakar', compact('pakars'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pakar' => 'required|string|max:255',
            'email_pakar' => 'required|email|unique:pakar,email_pakar',
            'jabatan' => 'required|string|max:25',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        pakar::create($validated);

        return redirect()->route('DaftarPakar.index')->with('success', 'Data pakar berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $pakar = Pakar::findOrFail($id);
        $pakar->delete();

        return redirect()->back()->with('success', 'Data pakar berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pakar' => 'required|string|max:255',
            'email_pakar' => 'required|email|unique:pakar,email_pakar,' . $id,
            'jabatan' => 'required|string|max:25',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        $pakar = Pakar::findOrFail($id);
        $pakar->update($request->all());

        return redirect()->route('DaftarPakar.index')->with('success', 'Data pakar berhasil diupdate');
    }
}
