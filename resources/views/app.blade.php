<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    {{-- NAVBAR --}}
    <nav class="navbar px-4 d-flex justify-content-between" style="background-color: #b2cff1;">
        <a class="navbar-brand ms-3" href="#">Sistem Pakar</a>

        @if(session('user_profile'))
            @php
                $idUser = session('user_profile.id');

                // Cek apakah user memiliki konsultasi
                $hasKonsultasi = false;
                if ($idUser) {
                    $konsultasiData = \App\Models\Konsultasi::where('id_user', $idUser)->count();
                    $hasKonsultasi = $konsultasiData > 0;
                }
            @endphp

            <div class="d-flex align-items-center">

                @if($hasKonsultasi)
                    <!-- Tombol Riwayat Konsultasi -->
                    <a href="{{ route('user.riwayat') }}" class="btn btn-sm btn-outline-primary me-2">
                        <i class="fa fa-history"></i> Riwayat Diagnosa
                    </a>

                @else
                    <span class="badge"></span>
                @endif

                <img src="{{ asset(session('user_profile.avatar') ?? 'default-avatar.png') }}"
                     alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                <a href="{{ route('profile.show') }}" class="text-decoration-none text-dark fw-semibold me-3">
                    {{ session('user_profile.nama') }}
                </a>


            </div>
        @else
            <div class="alert alert-danger">
                User belum login atau session hilang
            </div>
        @endif
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="container mt-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
