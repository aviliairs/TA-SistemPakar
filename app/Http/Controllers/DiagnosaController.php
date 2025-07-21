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
                'avatar' => $user->avatar,
                'jenis_kelamin' => $user->jenis_kelamin,
    ]]);

    return redirect()->route('diagnosa.mulai');
    }

   public function mulaiDiagnosa()
    {
        session()->forget([
            'jawaban_diagnosa',
            'pertanyaan_terjawab',
            'antrian_gejala',
            'kategori_saat_ini',
            'urutan_kategori'
        ]);

        $userId = session('selected_profile');
        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('home.index')->with('error', 'Profil tidak ditemukan.');
        }

        // Tentukan kategori berdasarkan jenis kelamin
        $jenisKelamin = strtolower($user->jenis_kelamin);
        $kategoriList = $jenisKelamin === 'laki-laki'
            ? ['gizi', 'mental']
            : ['reproduksi', 'gizi', 'mental'];

        session(['urutan_kategori' => $kategoriList, 'kategori_saat_ini' => $kategoriList[0]]);

        // Ambil semua pertanyaan dari kategori pertama
        $pertanyaans = Pertanyaan::where('tampilkan_di_user', true)
            ->where('kategori', $kategoriList[0])
            ->pluck('kode_gejala')
            ->toArray();

        session([
            'antrian_gejala' => $pertanyaans,
            'pertanyaan_terjawab' => []
        ]);

        return redirect()->route('diagnosa.pertanyaan');
    }

   public function tampilkanPertanyaan()
    {
        $antrian = session('antrian_gejala', []);
        $terjawab = session('pertanyaan_terjawab', []);
        $kategoriSaatIni = session('kategori_saat_ini');

        foreach ($antrian as $kodeGejala) {
            if (!in_array($kodeGejala, $terjawab)) {
                $pertanyaan = Pertanyaan::where('kode_gejala', $kodeGejala)->first();
                if ($pertanyaan) {
                    return view('diagnosa.per_pertanyaan', compact('pertanyaan'));
                }
            }
        }

        // Semua pertanyaan di kategori ini selesai, pindah ke kategori berikutnya
        $urutanKategori = session('urutan_kategori', []);
        $indexSekarang = array_search($kategoriSaatIni, $urutanKategori);

        if ($indexSekarang !== false && isset($urutanKategori[$indexSekarang + 1])) {
            $kategoriSelanjutnya = $urutanKategori[$indexSekarang + 1];

            $pertanyaansBaru = Pertanyaan::where('tampilkan_di_user', true)
                ->where('kategori', $kategoriSelanjutnya)
                ->pluck('kode_gejala')
                ->toArray();

            session([
                'kategori_saat_ini' => $kategoriSelanjutnya,
                'antrian_gejala' => $pertanyaansBaru,
                'pertanyaan_terjawab' => []
            ]);

            return redirect()->route('diagnosa.pertanyaan');
        }

        // Semua kategori selesai → proses diagnosa
        return redirect()->route('diagnosa.selesai');
    }

    public function jawabPertanyaan(Request $request)
    {
        $idPertanyaan = $request->input('id_pertanyaan');
        $jawaban = $request->input('jawaban');
        $kodeGejala = $request->input('kode_gejala');

        // Simpan jawaban ke session
        $jawabanSebelumnya = session('jawaban_diagnosa', []);
        $jawabanSebelumnya[$idPertanyaan] = $jawaban;
        session(['jawaban_diagnosa' => $jawabanSebelumnya]);

        // Tandai gejala sudah dijawab
        $terjawab = session('pertanyaan_terjawab', []);
        $terjawab[] = $kodeGejala;
        session(['pertanyaan_terjawab' => $terjawab]);

        // Ambil antrian gejala saat ini
        $antrian = session('antrian_gejala', []);

        // Jika jawaban "ya", cari pertanyaan lanjutan dari rule yang sama
        if ($jawaban === 'ya') {
            $gejalaUserYa = [];

            // Ambil semua kode gejala yang dijawab "ya"
            foreach ($jawabanSebelumnya as $id => $val) {
                if ($val === 'ya') {
                    $pertanyaan = Pertanyaan::find($id);
                    if ($pertanyaan) {
                        $gejalaUserYa[] = $pertanyaan->kode_gejala;
                    }
                }
            }

            $kategoriSaatIni = session('kategori_saat_ini');
            $aturanSesuai = Aturan::where('kategori', $kategoriSaatIni)->get();

            $pertanyaanPrioritas = [];
            $pertanyaanBiasa = [];

            foreach ($aturanSesuai as $aturan) {
                $listGejala = explode(',', $aturan->kode_gejala);
                $listGejala = array_map('trim', $listGejala);

                // Cek apakah gejala saat ini ada di rule ini
                if (in_array($kodeGejala, $listGejala)) {
                    // Ambil gejala lain di rule ini yang belum dijawab
                    foreach ($listGejala as $g) {
                        if (!in_array($g, $terjawab)) {
                            $pertanyaanPrioritas[] = $g;
                        }
                    }
                } else {
                    // Rule lain - hitung kecocokan
                    $jumlahCocok = count(array_intersect($listGejala, $gejalaUserYa));

                    // Kalau cocok sebagian tapi belum semua, tambahkan sisanya
                    if ($jumlahCocok > 0 && $jumlahCocok < count($listGejala)) {
                        foreach ($listGejala as $g) {
                            if (!in_array($g, $terjawab)) {
                                $pertanyaanBiasa[] = $g;
                            }
                        }
                    }
                }
            }

            // Hapus gejala yang sudah dijawab dari antrian
            $antrian = array_diff($antrian, $terjawab);

            // Susun ulang antrian: prioritas dulu, kemudian sisanya
            $pertanyaanPrioritas = array_unique($pertanyaanPrioritas);
            $pertanyaanBiasa = array_unique($pertanyaanBiasa);
            $sisaAntrian = array_diff($antrian, $pertanyaanPrioritas, $pertanyaanBiasa);

            $antrian = array_merge($pertanyaanPrioritas, $pertanyaanBiasa, $sisaAntrian);

        } else {
            // Jika jawaban "tidak", lanjut ke pertanyaan berikutnya di antrian
            // Hapus gejala yang sudah dijawab dari antrian
            $antrian = array_diff($antrian, $terjawab);
            $antrian = array_values($antrian); // Re-index array
        }

        // Update session antrian gejala
        session(['antrian_gejala' => $antrian]);

        return redirect()->route('diagnosa.pertanyaan');
    }
    public function submitDariSession()
    {
        // Ambil jawaban dari session dan buat request object
        $jawaban = session('jawaban_diagnosa', []);

        $request = new Request([
            'jawaban' => $jawaban
        ]);

        return $this->submitDiagnosa($request);
    }

    public function submitDiagnosa(Request $request)
    {
        $jawaban = $request->input('jawaban', []);
        $userId = session('selected_profile');
        $user = User::find($userId);
        $hasilDiagnosa = [];

        if (!$user) {
            return redirect()->route('home.index')->with('error', 'Profil tidak ditemukan.');
        }

        // Kelompokkan jawaban berdasarkan kategori gejala
        $jenisKelamin = strtolower($user->jenis_kelamin);
        $kategoriList = $jenisKelamin === 'laki-laki'
            ? ['gizi', 'mental']
            : ['reproduksi', 'gizi', 'mental'];

        // Inisialisasi array gejala per kategori
        $gejalaUser = [];
        foreach ($kategoriList as $kategori) {
            $gejalaUser[$kategori] = [];
        }

        // Proses jawaban 'ya' dan kelompokkan gejala berdasarkan kategori
        foreach ($jawaban as $id => $isi) {
            if ($isi == 'ya') {
                $pertanyaan = Pertanyaan::find($id);
                if ($pertanyaan && in_array($pertanyaan->kategori, $kategoriList)) {
                    $gejalaUser[$pertanyaan->kategori][] = $pertanyaan->kode_gejala;
                }
            }
        }

        // Proses diagnosa berdasarkan aturan per kategori
        foreach ($kategoriList as $kategori) {
            $gejala = $gejalaUser[$kategori] ?? [];

            // Debug: tampilkan gejala yang dijawab ya
            \Log::info("Kategori: $kategori, Gejala user: " . json_encode($gejala));

            $bestMatch = null;
            $maxMatch = 0;

            $aturanList = Aturan::where('kategori', $kategori)->get();

            foreach ($aturanList as $aturan) {
                // Parse kode_gejala dari format string dengan koma
                $aturanGejala = explode(',', $aturan->kode_gejala);
                $aturanGejala = array_map('trim', $aturanGejala);

                // Hitung kecocokan
                $matchCount = count(array_intersect($aturanGejala, $gejala));
                $totalGejalaAturan = count($aturanGejala);

                // Prioritaskan berdasarkan jumlah gejala yang cocok (lebih banyak = lebih baik)
                // Jika jumlah sama, prioritaskan yang persentase kecocokannya lebih tinggi
                $currentPercentage = $totalGejalaAturan > 0 ? ($matchCount / $totalGejalaAturan) : 0;

                if ($bestMatch) {
                    $bestMatchGejala = explode(',', $bestMatch->kode_gejala);
                    $bestMatchGejala = array_map('trim', $bestMatchGejala);
                    $bestPercentage = count($bestMatchGejala) > 0 ? ($maxMatch / count($bestMatchGejala)) : 0;
                } else {
                    $bestPercentage = 0;
                }

                if ($matchCount > $maxMatch ||
                    ($matchCount == $maxMatch && $matchCount > 0 && $currentPercentage > $bestPercentage)) {
                    $maxMatch = $matchCount;
                    $bestMatch = $aturan;
                }
            }

            
            Diagnosa::create([
                'id_user' => $user->id_user,
                'kode_gejala' => json_encode($gejala),
                'kategori' => $kategori,
                'kondisi' => $bestMatch ? $bestMatch->kondisi : 'Tidak Teridentifikasi',
                'kesimpulan' => $bestMatch ? $bestMatch->kesimpulan : 'Tidak ada aturan yang sesuai.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $hasilDiagnosa[] = [
                'kategori' => $kategori,
                'kondisi' => $bestMatch ? $bestMatch->kondisi : 'Tidak Teridentifikasi',
                'kesimpulan' => $bestMatch ? $bestMatch->kesimpulan : 'Tidak ada aturan yang sesuai.',
                'kode_aturan' => $bestMatch ? $bestMatch->kode_aturan : null, // Tambahkan untuk debug
                'gejala_cocok' => $maxMatch // Tambahkan untuk debug
            ];
        }

        // Simpan ke riwayat konsultasi
        Konsultasi::create([
            'id_user' => $user->id_user,
            'nama' => $user->nama,
            'tanggal' => now()->toDateString(),
            'hasil' => json_encode($hasilDiagnosa),
        ]);

        return view('hasil', [
            'hasil' => $hasilDiagnosa,
            'user' => $user
        ]);
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

