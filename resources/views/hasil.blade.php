@extends('app')

@section('title', 'Hasil Diagnosa')

@section('content')
<div class="container mt-5">
    <h2>Hasil Diagnosa</h2>

        @foreach ( $hasil as $h )
            <div class="card mt-4">
                <div class="card-body">
                    <p><strong>Kategori:</strong> {{ $h['kategori'] }}</p>
                    <p><strong>Kondisi:</strong> Dari Hasil Diagnosa yang sudah anda lakukan, menunjukkan hasil bahwa anda mengalami <strong> {{ $h['kondisi'] }} </strong></p>
                    <p><strong>Kesimpulan:</strong> Silakan klik Cetak PDF untuk melihat kesimpulan dan saran</p>
                    </div>
            </div>

        @endforeach
        <div class="d-flex justify-content-between mt-4">
    <a href="{{ route('diagnosa.cetakPdf', ['id_user' => $user->id_user]) }}" class="btn btn-primary mt-4" target="_blank">Cetak PDF</a>

    <!-- Tombol buka modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
        Logout
    </button>
</div>

<!-- Modal konfirmasi logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Logout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin logout?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn-danger">Logout</button>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection
