<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Full Order Report</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 10px;
            color: #333;
        }
        .header {
            text-align: center;
            line-height: 1.2;
        }
        .header img {
            width: 120px;
            height: auto;
            margin-bottom: 10px;
        }
        .header h2 {
            font-family: 'Helvetica', sans-serif;
            font-weight: bold;
            margin: 0;
        }
        .header p {
            font-family: 'Helvetica', sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }
        hr {
            border: none;
            border-top: 1px solid #333;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 8px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('images/logo/LOGOFIX.png') }}" alt="Company Logo">
        
        <h2>PT. WANDERLUST CANTIGI INTERNASIONAL</h2>
        <p>
            Jalan Drs. Moh Hatta No.7, Binuang Kp. Dalam, Kec. Pauh, Kota Padang, Sumatera Barat 25161
        </p>
        <p>
            Telp.085363483996 Email:cantigitour@gmail.com
        </p>
    </div>

    <hr>

    <h2 align="center">Laporan Keuangan</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Mobil</th>
                <th>Plat Nomor</th>
                <th>Tanggal Transaksi</th>
                <th>Deskripsi</th>
                <th>Kategori</th>
                <th>Tipe</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalAmount = 0;
            @endphp
            @forelse ($reports as $report)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $report->vehicle->brand ?? 'N/A' }} {{ $report->vehicle->model ?? '' }}</td>
                    <td>{{ $report->vehicle->license_plate }}</td>
                    <td>{{ $report->transaction_date ? \Carbon\Carbon::parse($report->transaction_date)->locale('id')->isoFormat('D MMMM Y') : 'Belum tersedia' }}</td>
                    <td>{{ $report->description }}</td>
                    <td>{{ $report->category }}</td>
                    <td>{{ $report->type }}</td>
                    <td>Rp{{ number_format($report->amount, 0, ',', '.') ?? 'Belum tersedia' }}</td>
                </tr>
                @php
                    $totalAmount += $report->amount;
                @endphp
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada pesanan ditemukan.</td>
                </tr>
            @endforelse
            <tr>
                <td colspan="7" style="text-align: right;"><strong>Total</strong></td>
                <td colspan="1">Rp{{ number_format($totalAmount, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Total Orders: {{ $reports->count() }}
    </div>

</body>
</html>