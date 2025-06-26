<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use App\Models\Diagnosa;
use App\Models\Aturan;
use App\Models\Konsultasi;
use Carbon\Carbon;
use App\Models\Gejala;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;


class DiagnosaController extends Controller
{
    public function index()
    {
        return view('diagnosa');
    }

    public function pilihProfil($id_user)
    {
        $user = User::find($id_user);

        if (!$user) {
            return redirect()->route('home.index')->with('error', 'Profil tidak ditemukan');
        }

        session(['selected_profile' => $id_user]);

    //Simpan data lengkap profile ke session untuk navbar
        session(['user_profile' => [
                'id' => $user->id_user,
                'nama' => $user->nama,
                'avatar' => $user->avatar, // atau field avatar sesuai database
                'jenis_kelamin' => $user->jenis_kelamin,
    ]]);

    return redirect()->route('diagnosa.form');
    }

    public function formDiagnosa()
    {
        $selectedProfile = session('selected_profile');
        $profile = User::find($selectedProfile);

        if (!$profile) {
            return redirect()->route('home.index')->with('error', 'Profil tidak ditemukan');
        }

        $jenisKelamin = strtolower($profile->jenis_kelamin); // untuk memastikan lowercase: 'laki-laki' atau 'perempuan'

        if ($jenisKelamin === 'laki-laki') {
            $kategoriYangDitampilkan = ['gizi', 'mental'];
        } else {
            $kategoriYangDitampilkan = ['reproduksi', 'gizi', 'mental'];
        }

        $pertanyaans = Pertanyaan::where('tampilkan_di_user', true)
            ->whereIn('kategori', $kategoriYangDitampilkan)
            ->get()
            ->groupBy('kategori');

        $pertanyaansTerurut = [];
            foreach ($kategoriYangDitampilkan as $kategori) {
                if (isset($pertanyaans[$kategori])) {
                    $pertanyaansTerurut[$kategori] = $pertanyaans[$kategori];
            }
        }

        return view('diagnosa', [
        'pertanyaansTerurut' => $pertanyaansTerurut,
        'user' => $profile
]);
    }

    //METODE
    public function submitDiagnosa(Request $request)
    {
        $selectedProfile = session('selected_profile');
        $user = User::find($selectedProfile);

        if (!$user) {
            return redirect()->route('profile')->with('error', 'Profil tidak ditemukan');
        }
         $jenisKelamin = strtolower($user->jenis_kelamin);
         $userID = $user->id_user;


        $jawaban = $request->input('jawaban', []); // ['id_pertanyaan' => 'ya' / 'tidak']
        $pertanyaanIDs = array_keys($jawaban);
        $pertanyaans = Pertanyaan::whereIn('id', $pertanyaanIDs)->get();

        // Memisahkan gejala per kategori
        $gejalaPerKategori = [];
        foreach ($pertanyaans as $p) {
            if (!empty($jawaban[$p->id]) && strtolower($jawaban[$p->id]) === 'ya') {
                $gejalaPerKategori[$p->kategori][] = $p->kode_gejala;
            }
        }

        $hasilDiagnosa = [];
        $jenisKelamin = strtolower($user->jenis_kelamin);
        $userID = auth()->user()->id_user;

        if ($jenisKelamin === 'laki-laki') {
            $kategoriDiagnosa = ['gizi', 'mental'];
        } else {
            $kategoriDiagnosa = ['reproduksi', 'gizi', 'mental'];
        }

        foreach ($kategoriDiagnosa as $kategori) {
           $gejalaUser = array_map(function ($item) {return strtoupper(trim($item));}, $gejalaPerKategori[$kategori] ?? []);
           $rules = Aturan::where('kategori', $kategori)->get();

           $bestMatch = null;
           $maxMatchCount = 0;
           $maxRuleGejala = 0;
           $bestScore = -1;

            foreach ($rules as $rule) {
                $kode_rule = array_map(function ($item) {return strtoupper(trim($item));}, explode(',', $rule->kode_gejala));
                $jumlahCocok = count(array_intersect($gejalaUser, $kode_rule));
                $jumlahRuleGejala = count($kode_rule);
                $jumlahUserGejala = count($gejalaUser);

                if ($jumlahCocok == 0) {
                    continue;
                }

            // Skor berdasarkan dua sisi:
            $persenRuleTerpenuhi = $jumlahRuleGejala > 0 ? $jumlahCocok / $jumlahRuleGejala : 0;
            $persenInputTerpenuhi = $jumlahUserGejala > 0 ? $jumlahCocok / $jumlahUserGejala : 0;

            $score = ($persenRuleTerpenuhi + $persenInputTerpenuhi) * 100;

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestMatch = $rule;
            }

            }

            Diagnosa::create([
                'id_user' => auth()->user()->id_user,
                'kode_gejala' => json_encode($gejalaUser),
                'kategori' => $kategori,
                'kondisi' => $bestMatch ? $bestMatch->kondisi : 'Tidak Teridentifikasi',
                'kesimpulan' => $bestMatch ? $bestMatch->kesimpulan : 'Tidak ada aturan yang sesuai dengan gejala Anda.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $hasilDiagnosa[] = [
                'kategori' => $kategori,
                'kondisi' => $bestMatch ? $bestMatch->kondisi : 'Tidak Teridentifikasi',
                'kesimpulan' => $bestMatch ? $bestMatch->kesimpulan : 'Tidak ada aturan yang sesuai dengan gejala Anda.',
            ];
        }
            Konsultasi::create([
                'id_user' => $user->id_user,
                'nama' => $user->nama,
                'tanggal' => Carbon::now()->toDateString(),
                'hasil' => json_encode($hasilDiagnosa)
]);
        return view('hasil', ['hasil' => $hasilDiagnosa, 'user'=>$user]);
}


    public function cetakPdf($id_user)
    {
        $user = User::where('id_user', $id_user)->firstOrFail();

        $hasil = Diagnosa::with('user')
            ->where('id_user', $user->id_user)
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('kategori');

        // Debug cek data hasil
        if ($hasil->isEmpty()) {
            return "Data diagnosa untuk user ($user->nama) tidak ditemukan!";
        }

        $pdf = Pdf::loadView('pdf', compact('hasil', 'user'));
        return $pdf->stream('hasil diagnosa.pdf');
    }

}

