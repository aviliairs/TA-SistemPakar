@extends('app')

@section('title', 'Riwayat Konsultasi')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Riwayat Konsultasi Saya</h2>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>

            @if($riwayatKonsultasi->isEmpty())
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> Belum ada riwayat konsultasi.
                </div>
            @else
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Diagnosa</th>
                                        <th>Status</th>
                                        <th>Hasil Diagnosa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayatKonsultasi as $index => $konsultasi)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($konsultasi->tanggal)->format('d/m/Y H:i') }}
                                        </td>
                                        {{-- <td>
                                            <span class="badge bg-info">
                                                {{ $konsultasi->hasil ?? 'Proses Diagnosa' }}
                                            </span>
                                        </td> --}}
                                        <td>
                                            <span class="badge bg-success">Selesai</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('diagnosa.hasilPdf', ['id_user' => $konsultasi->id_user]) }}"
                                               target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="fa fa-file-pdf"></i> Download PDF
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="alert alert-light">
                        <i class="fa fa-info-circle text-primary"></i>
                        <strong>Total Konsultasi:</strong> {{ $riwayatKonsultasi->count() }} kali
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
