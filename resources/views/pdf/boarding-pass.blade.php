<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Boarding Pass</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .boarding-pass {
            max-width: 700px;
            border: 1px solid #ddd;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .details {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 16px;
            color: #555;
        }

        .details div {
            width: 48%;
        }

        .passenger-info,
        .flight-info,
        .footer {
            margin-top: 20px;
        }

        .info-item {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }

        .barcode {
            text-align: center;
            margin-top: 30px;
        }

        img.qr-code {
            width: 150px;
            height: 150px;
        }

        /* Styling similar to the boarding pass in the image */
        .header-flight-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: #0056b3;
            color: white;
            font-size: 20px;
        }

        .header-flight-info .from,
        .header-flight-info .to {
            font-weight: bold;
        }

        .from,
        .to {
            width: 45%;
        }

        .section-title {
            font-size: 22px;
            margin-top: 20px;
            color: #0056b3;
            font-weight: bold;
        }

        .boarding-pass-container {
            padding: 10px;
            background-color: white;
            border: 1px solid #0056b3;
        }
    </style>
</head>

<body>
    <div class="boarding-pass">
        <div class="header-flight-info">
            <div class="from">
                <div>FROM:</div>
                <div>{{ $transaction->keberangkatan->segmentKeberangkatan->first()->kota }}</div>
                <div>{{ $transaction->keberangkatan->segmentKeberangkatan->first()->time->format('d F y') }}</div>
            </div>
            <div class="to">
                <div>TO:</div>
                <div>{{ $transaction->keberangkatan->segmentKeberangkatan->last()->kota }}</div>
                <div>{{ $transaction->keberangkatan->segmentKeberangkatan->last()->time->format('d F y') }}</div>
            </div>
        </div>

        <div class="details">
            <div>
                <div class="info-item">Passenger: <strong>{{ $transaction->nama }}</strong></div>
                <div class="info-item">Transaction Code: <strong>{{ $transaction->kode }}</strong></div>
                <div class="info-item">Flight: <strong>{{ $transaction->keberangkatan->nomor_keberangkatan }}</strong></div>
                <div class="info-item">Class: <strong>
                    {{ \Str::ucfirst($transaction->classKeberangkatan->tipe_kelas) }}
                </strong></div>
            </div>
            <div>
                <div class="info-item">Seats:</div>
                <ul>
                    @foreach ($transaction->transaksiPessenger as $passenger)
                        <li>{{ $passenger->nama }} - Seat: {{ $passenger->kursi->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="barcode">
            <img class="qr-code"
                src="{{ $qrCode }}"
                alt="QR Code">
        </div>

        <div class="footer">
            <p style="text-align:center; font-size:14px; color:#555;">Please present this boarding pass at the airport.
                Safe travels!</p>
        </div>
    </div>
</body>

</html>
