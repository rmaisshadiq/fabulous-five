<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengingat Pengembalian Kendaraan</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { font-size: 24px; font-weight: bold; color: #c70000; }
        .details-table { width: 100%; margin: 20px 0; border-collapse: collapse; }
        .details-table th, .details-table td { padding: 8px; border: 1px solid #eee; text-align: left; }
        .details-table th { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <div class="container">
        <p class="header">Pengingat Pengembalian</p>
        <p>Halo, {{ $order->customer->user->name ?? 'Pelanggan' }}!</p>
        <p>
            Ini adalah pengingat bahwa masa sewa kendaraan Anda telah berakhir hari ini.
            Mohon segera mengembalikan kendaraan sesuai dengan detail berikut:
        </p>

        <table class="details-table">
            <tr>
                <th>Kendaraan</th>
                <td>{{ $order->vehicle->brand }} {{ $order->vehicle->model }} ({{ $order->vehicle->license_plate }})</td>
            </tr>
            <tr>
                <th>Tanggal Pengembalian</th>
                <td>{{ \Carbon\Carbon::parse($order->end_booking_date)->isoFormat('dddd, D MMMM Y') }}</td>
            </tr>
        </table>

        <p>
            Jika Anda memiliki pertanyaan atau memerlukan perpanjangan waktu, silakan hubungi kami segera.
            Terima kasih atas kerja sama Anda.
        </p>
        <p>
            Hormat kami,<br>
            Tim {{ config('app.name') }}
        </p>
    </div>
</body>
</html>