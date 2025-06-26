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

    <form action="{{ route('diagnosa.submit') }}" method="POST">
        @csrf

        {{-- Informasi Gender dan Akses --}}
        @php
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

        {{-- Tab Kategori --}}
        <div class="category-tabs d-flex gap-2 mb-3">
            @foreach ($pertanyaansTerurut as $kategori => $listPertanyaan)
                <button type="button" class="btn btn-outline-secondary category-tab" data-category="{{ $loop->index }}">
                    {{ ucfirst($kategori) }}
                </button>
            @endforeach
        </div>

        {{-- Slide Kategori --}}
        <div class="category-slides">
            @foreach ($pertanyaansTerurut as $kategori => $listPertanyaan)
                <div class="category-slide" style="display: none;">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">{{ ucfirst($kategori) }}</h4>
                            <small class="text-muted">Jawab semua pertanyaan berikut dengan jujur</small>
                        </div>
                        <div class="card-body">
                            @foreach ($listPertanyaan as $pertanyaan)
                                <div class="mb-4 p-3 border rounded">
                                    <p class="fw-bold mb-3">{{ $pertanyaan->pertanyaan }}</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"
                                               name="jawaban[{{ $pertanyaan->id }}]"
                                               id="ya_{{ $pertanyaan->id }}"
                                               value="ya" required>
                                        <label class="form-check-label" for="ya_{{ $pertanyaan->id }}">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"
                                               name="jawaban[{{ $pertanyaan->id }}]"
                                               id="tidak_{{ $pertanyaan->id }}"
                                               value="tidak" required>
                                        <label class="form-check-label" for="tidak_{{ $pertanyaan->id }}">
                                            Tidak
                                        </label>
                                    </div>
                                    <input type="hidden" name="kode_gejala[{{ $pertanyaan->id }}]" value="{{ $pertanyaan->kode_gejala }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Navigation Buttons --}}
        <div class="d-flex justify-content-between mt-4">
            <button type="button" id="prevCategory" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Sebelumnya
            </button>
            <div>
                <span id="categoryProgress" class="me-3"></span>
                <button type="button" id="nextCategory" class="btn btn-primary">
                    Selanjutnya <i class="fas fa-arrow-right"></i>
                </button>
                <button type="submit" id="submitBtn" class="btn btn-success" style="display:none;">
                    <i class="fas fa-check"></i> Proses Diagnosa
                </button>
            </div>
        </div>
    </form>

<script>
    const categorySlides = document.querySelectorAll('.category-slide');
    const categoryTabs = document.querySelectorAll('.category-tab');
    const progressElement = document.getElementById('categoryProgress');
    let currentCategory = 0;

    function updateProgress() {
        if (progressElement) {
            progressElement.textContent = `${currentCategory + 1} dari ${categorySlides.length}`;
        }
    }

    function showCategory(index) {
        // Hide all slides
        categorySlides.forEach((slide, i) => {
            slide.style.display = (i === index) ? 'block' : 'none';
        });

        // Update tab active state
        categoryTabs.forEach((tab, i) => {
            tab.classList.toggle('active', i === index);
        });

        // Update navigation buttons
        document.getElementById('prevCategory').style.display = (index === 0) ? 'none' : 'inline-block';
        document.getElementById('nextCategory').style.display = (index === categorySlides.length - 1) ? 'none' : 'inline-block';
        document.getElementById('submitBtn').style.display = (index === categorySlides.length - 1) ? 'inline-block' : 'none';

        updateProgress();
    }

    function validateCurrentCategory() {
        const currentSlide = categorySlides[currentCategory];
        const questions = currentSlide.querySelectorAll('input[type="radio"][required]');
        const questionNames = new Set();

        questions.forEach(input => questionNames.add(input.name));

        let allAnswered = true;
        for (let name of questionNames) {
            const checked = currentSlide.querySelector(`input[name="${name}"]:checked`);
            if (!checked) {
                allAnswered = false;
                break;
            }
        }

        return allAnswered;
    }

    // Tab click handlers
    categoryTabs.forEach((tab, i) => {
        tab.addEventListener('click', () => {
            if (i > currentCategory) {
                // Validasi kategori saat ini sebelum lanjut
                if (!validateCurrentCategory()) {
                    alert('Silakan jawab semua pertanyaan di kategori ini terlebih dahulu.');
                    return;
                }
            }

            currentCategory = i;
            showCategory(i);
        });
    });

    // Previous button
    document.getElementById('prevCategory').addEventListener('click', () => {
        if (currentCategory > 0) {
            currentCategory--;
            showCategory(currentCategory);
        }
    });

    // Next button
    document.getElementById('nextCategory').addEventListener('click', () => {
        if (!validateCurrentCategory()) {
            alert('Silakan jawab semua pertanyaan di kategori ini sebelum melanjutkan.');
            return;
        }

        if (currentCategory < categorySlides.length - 1) {
            currentCategory++;
            showCategory(currentCategory);
        }
    });

    // Form submission validation
    document.querySelector('form').addEventListener('submit', function(e) {
        // Validate all categories
        for (let i = 0; i < categorySlides.length; i++) {
            const slide = categorySlides[i];
            const questions = slide.querySelectorAll('input[type="radio"][required]');
            const questionNames = new Set();

            questions.forEach(input => questionNames.add(input.name));

            for (let name of questionNames) {
                const checked = slide.querySelector(`input[name="${name}"]:checked`);
                if (!checked) {
                    e.preventDefault();
                    alert(`Silakan lengkapi semua pertanyaan di kategori ${i + 1}.`);
                    currentCategory = i;
                    showCategory(i);
                    return;
                }
            }
        }
    });

    // Initialize
    if (categorySlides.length > 0) {
        showCategory(currentCategory);
    } else {
        document.getElementById('prevCategory').style.display = 'none';
        document.getElementById('nextCategory').style.display = 'none';
        document.getElementById('submitBtn').style.display = 'none';

        // Show message if no categories available
        document.querySelector('.category-slides').innerHTML = `
            <div class="alert alert-warning text-center">
                <h5>Tidak ada kategori diagnosa yang tersedia</h5>
                <p>Silakan hubungi administrator untuk informasi lebih lanjut.</p>
            </div>
        `;
    }
</script>

@endsection
