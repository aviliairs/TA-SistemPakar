@extends('app')

@section('title', 'Diagnosa')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            {{-- <div class="col-lg-8 col-md-10"> --}}
                <div class="card shadow-lg border-0" style="border-radius: 20px; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                    {{-- <div class="card-body p-5"> --}}
                        <!-- Progress indicator -->
                        <div class="text-center mb-4">
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                @php
                                    $kategori = session('kategori_saat_ini', 'gizi');
                                    $iconClass = match($kategori) {
                                        'reproduksi' => 'fas fa-venus-mars',
                                        'gizi' => 'fas fa-utensils',
                                        'mental' => 'fas fa-brain',
                                        default => 'fas fa-stethoscope'
                                    };
                                    $colorClass = match($kategori) {
                                        'reproduksi' => 'bg-blue',
                                        'gizi' => 'bg-success',
                                        'mental' => 'bg-warning',
                                        default => 'bg-primary'
                                    };
                                @endphp
                                <div class="rounded-circle {{ $colorClass }} text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="{{ $iconClass }} fs-4"></i>
                                </div>
                            </div>
                            <h2 class="fw-bold mb-2" style="color: {{ $kategori == 'reproduksi' ? '#e91e63' : ($kategori == 'gizi' ? '#28a745' : ($kategori == 'mental' ? '#ffc107' : '#b2cff1')) }}">
                                Diagnosa {{ ucfirst($kategori) }}
                            </h2>
                            <p class="text-muted mb-0">Silakan jawab pertanyaan berikut dengan jujur</p>

                            <!-- Category Progress -->
                            @php
                                $urutanKategori = session('urutan_kategori', []);
                                $indexSekarang = array_search($kategori, $urutanKategori);
                                $totalKategori = count($urutanKategori);
                            @endphp
                            <div class="mt-3">
                                <div class="row justify-content-center">
                                    @foreach($urutanKategori as $index => $kat)
                                        <div class="col-auto">
                                            <div class="d-flex flex-column align-items-center">
                                                @php
                                                    $katIcon = match($kat) {
                                                        'reproduksi' => 'fas fa-venus-mars',
                                                        'gizi' => 'fas fa-utensils',
                                                        'mental' => 'fas fa-brain',
                                                        default => 'fas fa-stethoscope'
                                                    };
                                                    $katColor = match($kat) {
                                                        'reproduksi' => '#e91e63',
                                                        'gizi' => '#28a745',
                                                        'mental' => '#b2cff1',
                                                        default => '#b2cff1'
                                                    };
                                                @endphp
                                                <div class="rounded-circle d-flex align-items-center justify-content-center mb-1 {{ $index <= $indexSekarang ? 'text-white' : 'text-muted' }}"
                                                     style="width: 30px; height: 30px; background: {{ $index <= $indexSekarang ? $katColor : '#b2cff1' }}">
                                                    <i class="{{ $katIcon }} fs-6"></i>
                                                </div>
                                                <small class="text-muted">{{ ucfirst($kat) }}</small>
                                            </div>
                                        </div>
                                        @if($index < count($urutanKategori) - 1)
                                            <div class="col-auto d-flex align-items-center">
                                                <i class="fas fa-arrow-right text-muted"></i>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="progress mt-2" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: {{ (($indexSekarang + 1) / $totalKategori) * 100 }}%; background: {{ $katColor ?? '#b2cff1' }}"
                                         aria-valuenow="{{ ($indexSekarang + 1) / $totalKategori * 100 }}"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Question Card -->
                        <div class="bg-light p-4 rounded-4 mb-4" style="border-left: 5px solid {{ $kategori == 'reproduksi' ? '#e91e63' : ($kategori == 'gizi' ? '#28a745' : ($kategori == 'mental' ? '#ffc107' : '#b2cff1')) }}">
                            <div class="d-flex align-items-start">
                                <div class="text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                     style="width: 35px; height: 35px; min-width: 35px; background: {{ $kategori == 'reproduksi' ? '#e91e63' : ($kategori == 'gizi' ? '#28a745' : ($kategori == 'mental' ? '#ffc107' : '#b2cff1')) }}">
                                    <i class="fas fa-question fs-6"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <h5 class="text-dark mb-0 me-2">Pertanyaan</h5>
                                        <span class="badge rounded-pill text-white" style="background: {{ $kategori == 'reproduksi' ? '#e91e63' : ($kategori == 'gizi' ? '#28a745' : ($kategori == 'mental' ? '#ffc107' : '#b2cff1')) }}">
                                            {{ ucfirst($kategori) }}
                                        </span>
                                    </div>
                                    <p class="text-dark mb-0 fs-6 lh-base">{{ $pertanyaanBelumDijawab->pertanyaan ?? $pertanyaan->pertanyaan }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Answer Form -->
                        <form method="POST" action="{{ route('diagnosa.jawab') }}" class="needs-validation" novalidate>
                            @csrf
                            <input type="hidden" name="id_pertanyaan" value="{{ $pertanyaanBelumDijawab->id ?? $pertanyaan->id }}">
                            <input type="hidden" name="kode_gejala" value="{{ $pertanyaanBelumDijawab->kode_gejala ?? $pertanyaan->kode_gejala }}">

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark mb-3">Pilih jawaban Anda:</label>

                                <!-- Option Ya -->
                                <div class="form-check-wrapper mb-3">
                                    <input type="radio" name="jawaban" value="ya" class="form-check-input d-none" id="ya" required>
                                    <label class="form-check-label-custom d-flex align-items-center p-3 border rounded-3 cursor-pointer transition-all" for="ya" style="cursor: pointer; transition: all 0.3s ease;">
                                        <div class="form-check-circle me-3"></div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-check-circle me-2 fs-5" style="color: {{ $kategori == 'reproduksi' ? '#b2cff1' : ($kategori == 'gizi' ? '#b2cff1' : ($kategori == 'mental' ? '#b2cff1' : '#b2cff1')) }}"></i>
                                            <span class="fw-semibold">Ya</span>
                                        </div>
                                    </label>
                                </div>

                                <!-- Option Tidak -->
                                <div class="form-check-wrapper mb-3">
                                    <input type="radio" name="jawaban" value="tidak" class="form-check-input d-none" id="tidak" required>
                                    <label class="form-check-label-custom d-flex align-items-center p-3 border rounded-3 cursor-pointer transition-all" for="tidak" style="cursor: pointer; transition: all 0.3s ease;">
                                        <div class="form-check-circle me-3"></div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-times-circle text-danger me-2 fs-5"></i>
                                            <span class="fw-semibold">Tidak</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-lg py-3 rounded-3 fw-semibold shadow-sm"
                                        style="background: linear-gradient(135deg, {{ $kategori == 'reproduksi' ? '#58A0C8' : ($kategori == 'gizi' ? '#58A0C8' : ($kategori == 'mental' ? '#58A0C8' : '#58A0C8')) }} 0%, {{ $kategori == 'reproduksi' ? '#58A0C8' : ($kategori == 'gizi' ? '#58A0C8' : ($kategori == 'mental' ? '#58A0C8' : '#58A0C8')) }} 100%); border: none; transition: all 0.3s ease; color: {{ $kategori == 'mental' ? '#000' : '#fff' }};">
                                    <i class="fas fa-arrow-right me-2"></i>
                                    Lanjut ke Pertanyaan Berikutnya
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-check-label-custom {
    border: 2px solid #e9ecef !important;
    background: #fff;
    transition: all 0.3s ease;
}

.form-check-label-custom:hover {
    border-color: #007bff !important;
    background: #f8f9ff;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.15);
}

.form-check-input:checked + .form-check-label-custom {
    border-color: var(--category-color) !important;
    background: var(--category-bg) !important;
    box-shadow: 0 4px 15px var(--category-shadow) !important;
}

.form-check-circle {
    width: 20px;
    height: 20px;
    border: 2px solid #dee2e6;
    border-radius: 50%;
    position: relative;
    transition: all 0.3s ease;
}

.form-check-input:checked + .form-check-label-custom .form-check-circle {
    border-color: var(--category-color);
    background: var(--category-color);
}

.form-check-input:checked + .form-check-label-custom .form-check-circle::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 8px;
    height: 8px;
    background: white;
    border-radius: 50%;
    transform: translate(-50%, -50%);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 123, 255, 0.3) !important;
}

.card {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.transition-all {
    transition: all 0.3s ease;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-body {
        padding: 2rem !important;
    }

    .form-check-label-custom {
        padding: 1rem !important;
    }
}
</style>

<!-- Font Awesome untuk icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set CSS variables berdasarkan kategori
    const kategori = '{{ $kategori }}';
    const body = document.body;

    if (kategori === 'reproduksi') {
        body.classList.add('kategori-reproduksi');
    } else if (kategori === 'gizi') {
        body.classList.add('kategori-gizi');
    } else if (kategori === 'mental') {
        body.classList.add('kategori-mental');
    }

    // Form validation
    const form = document.querySelector('.needs-validation');

    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();

            // Show error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger alert-dismissible fade show mt-3';
            errorDiv.innerHTML = `
                <i class="fas fa-exclamation-triangle me-2"></i>
                Silakan pilih salah satu jawaban sebelum melanjutkan.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            const existingAlert = form.querySelector('.alert');
            if (existingAlert) {
                existingAlert.remove();
            }

            form.appendChild(errorDiv);
        }

        form.classList.add('was-validated');
    });

    // Add loading state to button
    const submitBtn = form.querySelector('button[type="submit"]');
    form.addEventListener('submit', function() {
        if (form.checkValidity()) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
            submitBtn.disabled = true;
        }
    });
});
</script>
@endsection
