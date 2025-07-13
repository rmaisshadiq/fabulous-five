<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #{{ $order->id }}</title>
    <style>
        /* Basic styling for the PDF */
        .header {
            text-align: center;
            line-height: 1.2;
        }
        .header img {
            width: 120px; /* Adjust size as needed */
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
        body {
            font-family: 'Helvetica', sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
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
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>Terimakasih atas pemesanan Anda!</strong><br>
                            </td>
                            <td class="text-right">
                                Invoice #: {{ $order->payment->midtrans_order_id }}<br>
                                Created: {{ $order->start_booking_date }}<br>
                                Due: {{ $order->end_booking_date }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>Bill To</strong><br>
                                {{ $order->customer->user->name }}<br>
                                {{ $order->customer->user->email }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Item</td>
                <td class="text-right">Harga</td>
            </tr>
            <tr class="item">
                <td>{{ $order->vehicle->brand }} {{ $order->vehicle->model }}</td>
                <td class="text-right">Rp{{ $order->formatted_total_price }}</td>
            </tr>
            <tr class="item">
                <td>PPN (11%)</td>
                <td class="text-right">Rp{{ $order->formatted_tax }}</td>
            </tr>
            <tr class="item">
                <td>Biaya Admin</td>
                <td class="text-right">Rp{{ $order->admin_fee }}</td>
            </tr>
            <tr class="total">
                <td></td>
                <td class="text-right">
                   <strong>Total: Rp{{ $order->formatted_final_total }}</strong>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>