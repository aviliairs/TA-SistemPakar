@extends('admin.admin')

@section('content')
    <div class="container mt-4">
    <h4>Detail Diagnosa</h4>


    @php
        $pdfPath = storage_path('app/public/pdf/diagnosa-' . $user->id_user . '.pdf');
        $pdfUrl = asset('storage/pdf/diagnosa-' . $user->id_user . '.pdf');
    @endphp

    {{-- Debug info --}}
    {{-- <div class="alert alert-info">
        <strong>Debug Info:</strong><br>
        File Path: {{ $pdfPath }}<br>
        File Exists: {{ file_exists($pdfPath) ? 'Yes' : 'No' }}<br>
        PDF URL: {{ $pdfUrl }}
    </div> --}}

    @if(file_exists($pdfPath))
        <iframe src="{{ asset('storage/pdf/diagnosa-' . $user->id_user . '.pdf') }}" width="100%" height="600px" frameborder="0"></iframe>
    @else
        <div class="alert alert-danger">
            <strong>Error:</strong> File PDF tidak ditemukan!<br>
            Expected path: {{ $pdfPath }}
        </div>
    @endif
    </div>

@endsection
