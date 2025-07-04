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

    <table>
        <thead>
            <tr>
                <th rowspan="2">Nama Penyewa</th>
                <th rowspan="2">Email Penyewa</th>
                <th rowspan="2">Jenis Mobil</th>
                <th rowspan="2">Plat Nomor</th>
                <th colspan="4" style="text-align: center;">Pemesanan</th>
                <th colspan="4" style="text-align: center;">Pengembalian</th>
                <th rowspan="2">Total Biaya</th>
                <th rowspan="2">Keterangan</th>
            </tr>
            <tr>
                <th>Hari</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>BBM</th>
                <th>Hari</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>BBM</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->customer->user->name }}</td>
                    <td>{{ $order->customer->user->email }}</td>
                    <td>{{ $order->vehicle->brand ?? 'N/A' }} {{ $order->vehicle->model ?? '' }}</td>
                    <td>{{ $order->vehicle->license_plate }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->start_booking_date)->locale('id')->isoFormat('dddd') }}</td>
                    <td>{{ $order->start_booking_date ? \Carbon\Carbon::parse($order->start_booking_date)->locale('id')->isoFormat('D MMMM Y') : 'Belum tersedia' }}</td>
                    <td>{{ $order->start_booking_time ? \Carbon\Carbon::parse($order->start_booking_time)->locale('id')->isoFormat('HH:mm') : 'Belum tersedia' }}</td>
                    <td>{{ $order->return_log->fuel_level_on_rent ?? 'Belum tersedia' }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->return_log->returned_at)->locale('id')->isoFormat('dddd') }}</td>
                    <td>{{ $order->return_log->returned_at ? \Carbon\Carbon::parse($order->return_log->returned_at)->locale('id')->isoFormat('D MMMM Y') : 'Belum tersedia' }}</td>
                    <td>{{ $order->return_log->returned_at ? \Carbon\Carbon::parse($order->return_log->returned_at)->locale('id')->isoFormat('HH:mm') : 'Belum tersedia' }}</td>
                    <td>{{ $order->return_log->fuel_level_on_return ?? 'Belum tersedia' }}</td>
                    <td>Rp{{ $order->formatted_final_total ?? 'Belum tersedia' }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $order->status)) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="14" style="text-align: center;">Tidak ada pesanan ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Total Orders: {{ $orders->count() }}
    </div>

</body>
</html>