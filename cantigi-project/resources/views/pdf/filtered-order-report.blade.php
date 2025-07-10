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

        th,
        td {
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

    <h2 align="center">LAPORAN BULAN RENTAL</h2>

    @if ($orders->isNotEmpty())
        @php
            $firstOrder = $orders->first();
        @endphp
        Nama Mobil: {{ $firstOrder->vehicle->brand }} {{ $firstOrder->vehicle->model }}<br>
        Plat Nomor: {{ $firstOrder->vehicle->license_plate }}<br>
        Bulan: {{ \Carbon\Carbon::parse($firstOrder->start_booking_date)->locale('id')->isoFormat('MMMM Y') }}
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Penyewa</th>
                <th>Jumlah Hari</th>
                <th>Harga</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            {{-- Check if there are any orders to process --}}
            @if ($orders->isNotEmpty())

                @php
                    // --- STEP 1 & 2: Prepare the data ---

                    // Get the date of the first order to determine the month and year
                    $reportDate = \Carbon\Carbon::parse($orders->first()->start_booking_date);
                    $daysInMonth = $reportDate->daysInMonth; // Get total days in the month (e.g., 31)

                    // Create a lookup map where the key is the day number (e.g., 1, 15, 31)
                    $ordersByDay = $orders->keyBy(function ($order) {
                        return \Carbon\Carbon::parse($order->start_booking_date)->day;
                    });
                @endphp

                {{-- --- STEP 3: Loop through every day of the month --- --}}
                @for ($day = 1; $day <= $daysInMonth; $day++)

                    @php
                        // --- STEP 4: Find the order for the current day ---
                        // The get() method will return the order or null if not found
                        $order = $ordersByDay->get($day);
                    @endphp

                    <tr>
                        {{-- Column 1: The Day of the month --}}
                        <td>{{ $day }}</td>

                        {{-- Column 2: Renter Name (if order exists) --}}
                        <td>{{ $order ? $order->customer->user->name ?? $order->customer->name : '' }}</td>

                        {{-- Column 3: Duration (if order exists) --}}
                        <td>{{ $order ? ($order->duration_in_days ?? 'N/A') : '' }}</td>

                        {{-- Column 4: Price (if order exists) --}}
                        <td>{{ $order ? 'Rp' . ($order->financial_report->formatted_amount ?? $order->formatted_final_total) : '' }}</td>

                        {{-- Column 5: Status (if order exists) --}}
                        <td>{{ $order ? ucfirst(str_replace('_', ' ', $order->status)) : '' }}</td>
                    </tr>
                @endfor

                {{-- This is the TOTAL row, it remains unchanged --}}
                <tr">
                    <td colspan="3" style="text-align: center;"><b>TOTAL</b></td>
                    <td colspan="2"><b>Rp{{ number_format($orders->sum('final_total'), 0, ',', '.') }}</b></td>
                </tr>

            @else
                {{-- This part runs only if there are no orders at all for the filtered month --}}
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada pesanan ditemukan.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        Total Orders: {{ $orders->count() }}
    </div>

</body>

</html>