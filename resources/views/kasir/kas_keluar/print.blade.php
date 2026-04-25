<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Kas Keluar - {{ $transaction->no_transaksi }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 40px 0;
            color: #1e293b;
        }

        .document-wrapper {
            background-color: #fff;
            width: 210mm;
            min-height: 148mm;
            margin: 0 auto;
            padding: 40px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            position: relative;
            border-radius: 8px;
        }

        .header-table {
            width: 100%;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .brand-name {
            font-size: 24px;
            font-weight: 800;
            color: #e11d48;
            margin: 0;
            letter-spacing: -0.025em;
        }

        .brand-info {
            font-size: 12px;
            color: #64748b;
            margin-top: 5px;
            line-height: 1.5;
        }

        .doc-title-container {
            text-align: right;
        }

        .doc-title {
            font-size: 18px;
            font-weight: 800;
            margin: 0;
            text-transform: uppercase;
            color: #0f172a;
        }

        .doc-no {
            font-size: 14px;
            color: #e11d48;
            font-weight: 700;
            margin-top: 5px;
        }

        .content-section {
            margin-bottom: 40px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 30px;
        }

        .info-box label {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: block;
            margin-bottom: 5px;
        }

        .info-box p {
            font-size: 14px;
            font-weight: 600;
            margin: 0;
            color: #1e293b;
        }

        .amount-highlight {
            background-color: #fff1f2;
            border: 1px solid #ffe4e6;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 30px;
        }

        .amount-big {
            font-size: 32px;
            font-weight: 800;
            color: #e11d48;
            margin: 0;
        }

        .amount-label {
            font-size: 11px;
            font-weight: 700;
            color: #be123c;
            text-transform: uppercase;
            margin-bottom: 5px;
            display: block;
        }

        .description-box {
            border-left: 4px solid #e11d48;
            padding: 15px 20px;
            background-color: #f8fafc;
            border-radius: 0 12px 12px 0;
        }

        .description-box label {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            display: block;
            margin-bottom: 5px;
        }

        .description-box p {
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
            font-weight: 500;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 60px;
            padding: 0 20px;
        }

        .signature-cell {
            text-align: center;
            width: 200px;
        }

        .sig-label {
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 60px;
        }

        .sig-name {
            font-size: 14px;
            font-weight: 700;
            border-bottom: 1.5px solid #1e293b;
            padding-bottom: 5px;
            display: inline-block;
            min-width: 150px;
        }

        .sig-role {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 5px;
        }

        .print-actions {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 15px;
        }

        .btn-print {
            padding: 12px 24px;
            background-color: #e11d48;
            color: #fff;
            border: none;
            border-radius: 99px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 10px 15px -3px rgba(225, 29, 72, 0.4);
            transition: all 0.2s;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-back {
            padding: 12px 24px;
            background-color: #fff;
            color: #64748b;
            border: 1px solid #e2e8f0;
            border-radius: 99px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            font-size: 14px;
        }

        @media print {
            body {
                background-color: #fff;
                padding: 0;
            }
            .document-wrapper {
                box-shadow: none;
                margin: 0;
                width: 100%;
            }
            .print-actions {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="document-wrapper">
        <table class="header-table">
            <tr>
                <td>
                    <h1 class="brand-name">{{ $apotek->nama_apotek ?? 'APOTEK E-APOTEK' }}</h1>
                    <div class="brand-info">
                        {{ $apotek->alamat ?? '-' }}<br>
                        Telp/WA: {{ $apotek->telepon ?? '-' }}
                    </div>
                </td>
                <td class="doc-title-container">
                    <h2 class="doc-title">BUKTI KAS KELUAR</h2>
                    <div class="doc-no">{{ $transaction->no_transaksi }}</div>
                </td>
            </tr>
        </table>

        <div class="content-section">
            <div class="info-grid">
                <div class="info-box">
                    <label>Tanggal & Waktu</label>
                    <p>{{ \Carbon\Carbon::parse($transaction->transaction_date)->translatedFormat('d F Y, H:i') }}</p>
                </div>
                <div class="info-box" style="text-align: right;">
                    <label>Kategori Biaya</label>
                    <p>{{ $transaction->category }}</p>
                </div>
            </div>

            <div class="amount-highlight">
                <span class="amount-label">Jumlah Dana Keluar</span>
                <h3 class="amount-big">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</h3>
            </div>

            <div class="description-box">
                <label>Keterangan / Deskripsi Pengeluaran</label>
                <p>{{ $transaction->description ?: 'Tanpa keterangan tambahan.' }}</p>
            </div>
        </div>

        <div class="signature-section">
            <div class="signature-cell">
                <div class="sig-label">Disetujui Oleh,</div>
                <div class="sig-space"></div>
                <div class="sig-name">&nbsp;</div>
                <div class="sig-role">Pimpinan / Finance</div>
            </div>
            <div class="signature-cell">
                <div class="sig-label">Penerima Dana,</div>
                <div class="sig-space"></div>
                <div class="sig-name">&nbsp;</div>
                <div class="sig-role">Nama & Tanda Tangan</div>
            </div>
            <div class="signature-cell">
                <div class="sig-label">Dikeluarkan Oleh,</div>
                <div class="sig-space"></div>
                <div class="sig-name">{{ $transaction->user->name ?? '-' }}</div>
                <div class="sig-role">Kasir Operasional</div>
            </div>
        </div>
    </div>

    <div class="print-actions">
        <a href="javascript:history.back()" class="btn-back">Kembali</a>
        <button onclick="window.print()" class="btn-print">Cetak Sekarang</button>
    </div>
</body>
</html>
