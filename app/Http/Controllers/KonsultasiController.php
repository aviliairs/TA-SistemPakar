<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Diagnosa;
use Illuminate\Support\Facades\Storage;

class KonsultasiController extends Controller
{
    public function riwayatDiagnosa()
    {
        $konsultasis = Konsultasi::with('user')->orderByDesc('tanggal')->get();
        return view('admin.konsultasi', compact('konsultasis'));
    }

    public function detailPdf($id_user)
    {
        $user = User::findOrFail($id_user);

        $hasil = Diagnosa::with('user')
            ->where('id_user', $user->id_user)
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('kategori');

        if ($hasil->isEmpty()) {
            return "Data diagnosa untuk user {$user->nama} tidak ditemukan.";
        }

        $pdfDirectory = storage_path('app/public/pdf');
        if (!file_exists($pdfDirectory)) {
            mkdir($pdfDirectory, 0755, true);
        }

        // Generate PDF ke file sementara
        $pdf = Pdf::loadView('pdf', compact('hasil', 'user'));
        $filename = "diagnosa-{$user->id_user}.pdf";
        $pdfPath = storage_path("app/public/pdf/{$filename}");
        $pdf->save($pdfPath);

        // Kirim ke blade untuk ditampilkan dalam iframe
        return view('admin.DetailKonsultasi', [
            'pdfUrl' => asset("storage/pdf/{$filename}"),
            'user' => $user,
            'pdfPath' => $pdfPath
        ]);
    }
   public function hasilPdf($id_user)
    {

        // if (session('user_profile.id_user') != $id_user && !session('is_admin')){
        //     return abort(403, 'Akses Ditolak');
        // }
        $user = User::findOrFail($id_user);

        $hasil = Diagnosa::with('user')
            ->where('id_user', $user->id_user)
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('kategori');

        if ($hasil->isEmpty()) {
            return back()->with('error', 'Belum ada hasil diagnosa.');
        }

        $filename = "diagnosa-{$user->id_user}.pdf";
        $pdfPath = storage_path("app/public/pdf/{$filename}");

        // Jika belum ada PDF-nya, buat dulu
        if (!file_exists($pdfPath)) {
            $pdfDirectory = storage_path('app/public/pdf');
            if (!file_exists($pdfDirectory)) {
                mkdir($pdfDirectory, 0755, true);
            }

            $pdf = Pdf::loadView('pdf', compact('hasil', 'user'));
            $pdf->save($pdfPath);
        }

        return response()->file($pdfPath);
    }

    public function riwayatUser()
    {
        if (!session('user_profile')) {
            return redirect()->route('login');
        }

        $userId = session('user_profile.id_user') ?? session('user_profile.id');

        $riwayatKonsultasi = Diagnosa::with('user')
            ->where('id_user', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('RiwayatDiagnosa', compact('riwayatKonsultasi'));
    }

}
