<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Penduduk</title>
    <style>
        body {
            font-family: sans-serif;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    {{-- KOP SURAT (Opsional, bisa disesuaikan nanti) --}}
    <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">PEMERINTAH DESA [NAMA DESA]</h2>
        <p style="margin: 0;">Laporan Data Penduduk</p>
        <p style="margin: 0; font-size: 10px;">Tanggal Cetak: {{ date('d-m-Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>L/P</th>
                <th>TTL</th>
                <th>Pekerjaan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penduduks as $index => $warga)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $warga->nik }}</td>
                    <td>{{ $warga->nama_lengkap }}</td>
                    <td>{{ $warga->jenis_kelamin }}</td>
                    <td>{{ $warga->tempat_lahir }}, {{ $warga->tanggal_lahir }}</td>
                    <td>{{ $warga->pekerjaan ?? '-' }}</td>
                    <td>{{ $warga->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
