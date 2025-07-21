
@extends('app')

@section('title', 'Diagnosa')

@section('content')
    {{-- CSS Swiper dan Bootstrap --}}
    <link rel="stylesheet" href="https://unpkg.com/swiper@10/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        .category-tab.active {
            background-color: #0d6efd;
            color: white;
        }
        .category-tab:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .gender-info {
            background-color: #f8f9fa;
            border-left: 4px solid #0d6efd;
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>

    {{-- Informasi Gender dan Akses --}}
    @php
        $selectedProfile = session('selected_profile');
        $user = App\Models\User::find($selectedProfile);
        $jenisKelamin = strtolower($user->jenis_kelamin);
        $isLakiLaki = ($jenisKelamin === 'laki-laki');
    @endphp

    <div class="gender-info">
        <p class="mb-1"><strong>Nama:</strong> {{ $user->nama }}</p>
        <p class="mb-1"><strong>Jenis Kelamin:</strong> {{ ucfirst($user->jenis_kelamin) }}</p>
        @if($isLakiLaki)
            <p class="mb-0"><small class="text-muted">
                <em>Catatan: Diagnosa reproduksi tidak tersedia untuk profil laki-laki pada sistem ini.</em>
            </small></p>
        @endif
    </div>

    {{-- Form Pertanyaan --}}
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h5>Pertanyaan {{ $id + 1 }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('diagnosa.pertanyaan') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <p class="fw-bold">{{ $pertanyaan->pertanyaan }}</p>
                        <input type="hidden" name="id_pertanyaan" value="{{ $pertanyaan->id }}">
                        <input type="hidden" name="kode_gejala" value="{{ $pertanyaan->kode_gejala }}">
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jawaban" value="ya" id="jawaban_ya" required>
                            <label class="form-check-label" for="jawaban_ya">
                                Ya
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jawaban" value="tidak" id="jawaban_tidak" required>
                            <label class="form-check-label" for="jawaban_tidak">
                                Tidak
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Lanjut</button>
                </form>
            </div>
        </div>
    </div>

@endsection
