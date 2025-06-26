<!DOCTYPE html>
@php
function formatKesimpulanDanSaran($text) {
    // Pisahkan berdasarkan kata "Saran:"
    $parts = preg_split('/\bSaran\s*:/i', $text);

    if (count($parts) == 2) {
        $kesimpulan = trim($parts[0]);
        $saran = trim($parts[1]);

        return "<p>$kesimpulan</p><p><strong>Saran:</strong> $saran</p>";
    }

    // apabila tidak ditemukan kata "Saran:", tampilkan apa adanya
    return "<p>$text</p>";
}
@endphp

<html>
<head>
    <title>Laporan Hasil Diagnosa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 40px;
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #000;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .title {
            font-weight: bold;
            font-size: 18px;
            margin: 5px 0;
        }
        .subtitle {
            font-style: italic;
            font-size: 13px;
            margin-bottom: 10px;
        }
        .tanggal {
            text-align: right;
            margin-bottom: 20px;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 4px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        td ol {
            padding-left: 15px;
            margin: 0;
        }
        td li {
            margin-bottom: 10px;
            text-align: justify;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="title">LAPORAN HASIL DIAGNOSIS KESEHATAN CALON PENGANTIN</div>
        <div class="subtitle">(Menggunakan Metode Forward Chaining)</div>
    </div>

    <div class="tanggal">Tanggal
        {{ \Carbon\Carbon::now()->format('d M Y') }}
    </div>

    <div class="info">
        <p><strong>Nama pengguna :</strong> {{ $user->nama }}</p>
        <p><strong>Email pengguna :</strong> {{ $user->email }}</p>
        <p><strong>Jenis Kelamin :</strong> {{ $user->jenis_kelamin }}</p>

        <p>Berdasarkan pertanyaan yang telah anda jawab, maka hasil diagnosa kesehatan anda adalah sebagai berikut :</p>
    </div>

    <h4>Hasil Diagnosa</h4>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Hasil</th>
                <th>Kesimpulan dan Saran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hasil as $h)
                <tr>
                    <td>{{ $h->kategori }}</td>
                    <td>{{ $h->kondisi }}</td>
                    <td>
                        @php
                            // Ambil teks kesimpulan dari database
                            $items = preg_split('/\d+\.\s/', $h->kesimpulan, -1, PREG_SPLIT_NO_EMPTY);
                        @endphp

                        <ol>
                        @foreach($items as $item)
                            @php
                                // Tambahkan <strong> ke kata "Saran:"
                                $item = preg_replace('/Saran\s*:/i', '<br><strong>Saran:</strong>', $item);
                            @endphp
                            <li style="list-style-type: none; margin-bottom: 10px; text-align: justify;">
                                • {!! nl2br(trim($item)) !!}
                            </li>

                        @endforeach
                        </ol>
                    </td>

                </tr>
            @endforeach
        </tbody>

    </table>
<p><strong>Catatan : </strong>Ini hanya hasil diagnosa berdasarkan informasi yang Anda berikan. Untuk hasil yang lebih akurat dan penanganan lanjutan, disarankan untuk berkonsultasi langsung dengan tenaga medis profesional.</p>
</body>
</html>
