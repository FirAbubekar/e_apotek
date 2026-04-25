<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penutupan Kasir - {{ $closing->closing_time }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 40px 0;
            color: #1e293b;
        }

        .report-wrapper {
            background-color: #fff;
            width: 148mm; /* A5 size common for POS reports */
            margin: 0 auto;
            padding: 30px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 25px;
            padding-bottom: 15px;
        }

        .brand-name {
            font-size: 20px;
            font-weight: 800;
            color: #0d9488;
            margin: 0;
        }

        .report-title {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-top: 10px;
            color: #64748b;
        }

        .meta-info {
            font-size: 11px;
            color: #64748b;
            margin-top: 5px;
        }

        .section-title {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 5px;
            margin: 20px 0 10px;
            color: #0f172a;
        }

        .data-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 13px;
        }

        .data-label {
            color: #64748b;
            font-weight: 500;
        }

        .data-value {
            font-weight: 700;
            color: #1e293b;
        }

        .highlight-row {
            background: #f8fafc;
            margin: 0 -15px;
            padding: 10px 15px;
            border-radius: 8px;
        }

        .total-box {
            margin-top: 25px;
            padding: 20px;
            background: #0f172a;
            color: white;
            border-radius: 12px;
            text-align: center;
        }

        .total-label {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
        }

        .total-amount {
            font-size: 24px;
            font-weight: 800;
            margin-top: 5px;
        }

        .difference-badge {
            margin-top: 15px;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            font-weight: 700;
        }

        .diff-success { background: #dcfce7; color: #166534; }
        .diff-danger { background: #fee2e2; color: #991b1b; }

        .signature-grid {
            margin-top: 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .sig-cell {
            text-align: center;
        }

        .sig-space {
            height: 50px;
        }

        .sig-name {
            font-size: 12px;
            font-weight: 700;
            border-bottom: 1px solid #1e293b;
            display: inline-block;
            min-width: 120px;
        }

        .print-actions {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 99px;
            font-weight: 700;
            text-decoration: none;
            font-size: 12px;
            cursor: pointer;
            border: none;
        }

        .btn-print { background: #0d9488; color: white; }
        .btn-back { background: white; color: #64748b; border: 1px solid #e2e8f0; }

        @media print {
            body { background: white; padding: 0; }
            .report-wrapper { box-shadow: none; border: none; width: 100%; }
            .print-actions { display: none; }
        }
    </style>
</head>
<body>
    <div class="report-wrapper">
        <div class="header">
            <h1 class="brand-name">{{ $apotek->nama_apotek ?? 'E-APOTEK' }}</h1>
            <div class="report-title">LAPORAN PENUTUPAN KASIR</div>
            <div class="meta-info">
                {{ \Carbon\Carbon::parse($closing->closing_time)->translatedFormat('l, d F Y - H:i') }}
            </div>
        </div>

        <div class="section-title">Informasi Sesi</div>
        <div class="data-row">
            <span class="data-label">Kasir / Operator</span>
            <span class="data-value">{{ $closing->user->name }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Waktu Buka Shift</span>
            <span class="data-value">{{ \Carbon\Carbon::parse($closing->opening_time)->format('d/m/Y H:i') }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Waktu Tutup Shift</span>
            <span class="data-value">{{ \Carbon\Carbon::parse($closing->closing_time)->format('d/m/Y H:i') }}</span>
        </div>

        <div class="section-title">Rekapitulasi Kas (Cash Flow)</div>
        <div class="data-row">
            <span class="data-label">Modal Awal Kasir</span>
            <span class="data-value">Rp {{ number_format($closing->opening_cash, 0, ',', '.') }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Total Penjualan Tunai (+)</span>
            <span class="data-value">Rp {{ number_format($closing->total_cash_sales, 0, ',', '.') }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Pemasukan Lain (+)</span>
            <span class="data-value">Rp {{ number_format($closing->total_income, 0, ',', '.') }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Pengeluaran / Kas Keluar (-)</span>
            <span class="data-value">Rp {{ number_format($closing->total_expense, 0, ',', '.') }}</span>
        </div>
        
        <div class="total-box">
            <div class="total-label">Saldo Kasir Seharusnya</div>
            <div class="total-amount">Rp {{ number_format($closing->expected_cash, 0, ',', '.') }}</div>
        </div>

        <div class="section-title">Informasi Non-Tunai</div>
        <div class="data-row">
            <span class="data-label">Total Penjualan Non-Tunai</span>
            <span class="data-value">Rp {{ number_format($closing->total_non_cash_sales, 0, ',', '.') }}</span>
        </div>

        <div class="section-title">Rekonsiliasi Fisik</div>
        <div class="data-row highlight-row">
            <span class="data-label">Uang Fisik Diterima</span>
            <span class="data-value" style="font-size: 16px;">Rp {{ number_format($closing->actual_cash, 0, ',', '.') }}</span>
        </div>

        @if($closing->difference != 0)
            <div class="difference-badge {{ $closing->difference > 0 ? 'diff-success' : 'diff-danger' }}">
                SELISIH: Rp {{ number_format($closing->difference, 0, ',', '.') }}
                <div style="font-size: 10px; font-weight: 500; margin-top: 5px;">
                    ({{ $closing->difference > 0 ? 'Kelebihan Uang Kas' : 'Kekurangan Uang Kas' }})
                </div>
            </div>
        @else
            <div class="difference-badge diff-success">
                SALDO SESUAI (PAS)
            </div>
        @endif

        @if($closing->notes)
        <div class="section-title">Catatan</div>
        <div style="font-size: 12px; font-style: italic; color: #64748b;">
            "{{ $closing->notes }}"
        </div>
        @endif

        <div class="signature-grid">
            <div class="sig-cell">
                <div class="meta-info" style="margin-bottom: 40px;">Kasir Pelaksana,</div>
                <div class="sig-name">{{ $closing->user->name }}</div>
            </div>
            <div class="sig-cell">
                <div class="meta-info" style="margin-bottom: 40px;">Pimpinan / Owner,</div>
                <div class="sig-name">&nbsp;</div>
            </div>
        </div>
    </div>

    <div class="print-actions">
        <a href="{{ route('tutup-kasir.index') }}" class="btn btn-back">Kembali</a>
        <button onclick="window.print()" class="btn btn-print">Cetak Laporan (Z-Report)</button>
    </div>
</body>
</html>
