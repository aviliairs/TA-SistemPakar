@extends('app')

@section('title', 'Hasil Diagnosa')

@section('content')
<div class="container mt-5">
    <h2>Hasil Diagnosa</h2>

        @foreach ( $hasil as $h )
            <div class="card mt-4">
                <div class="card-body">
                    <p><strong>Kategori:</strong> {{ $h['kategori'] }}</p>
                    <p><strong>Kondisi:</strong> Dari Hasil Diagnosa, anda dinilai <strong> {{ $h['kondisi'] }} </strong></p>
                    <p><strong>Kesimpulan:</strong> Silakan klik Cetak PDF untuk melihat kesimpulan dan saran</p>
                    </div>
            </div>

        @endforeach
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('diagnosa.cetakPdf', ['id_user' => $user->id_user]) }}" class="btn btn-primary mt-4" target="_blank">Cetak PDF</a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;"
                onsubmit="return confirm('Apakah Anda yakin ingin logout?')">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>


@endsection
