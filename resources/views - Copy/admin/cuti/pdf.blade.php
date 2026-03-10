<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Cuti Pegawai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .status-menunggu { color: #f59e0b; }
        .status-disetujui { color: #10b981; }
        .status-ditolak { color: #ef4444; }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA CUTI PEGAWAI</h1>
        <p>Bagian Tata Pemerintahan (Tatapem) SETDA</p>
        <p>Tanggal: {{ now()->format('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>NIP</th>
                <th>Jenis Cuti</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Jumlah Hari</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cuti as $index => $c)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $c->user->name }}</td>
                <td>{{ $c->NIP }}</td>
                <td>{{ $c->jenis_cuti_label }}</td>
                <td>{{ $c->tanggal_mulai->format('d/m/Y') }}</td>
                <td>{{ $c->tanggal_selesai->format('d/m/Y') }}</td>
                <td>{{ $c->jumlah_hari }} hari</td>
                <td class="status-{{ $c->status }}">{{ $c->status_label }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada data cuti</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
    </div>
</body>
</html>
