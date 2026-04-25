@extends('layouts.app')

@section('title', 'Detail Penjualan - Apotekku')
@section('page_title', 'Detail Transaksi Penjualan')

@section('styles')
<style>
    :root {
        --invoice-emerald: #064e4b;
        --invoice-emerald-light: #0d9488;
        --invoice-slate: #0f172a;
        --invoice-text: #1e293b;
        --invoice-muted: #64748b;
        --invoice-border: #e2e8f0;
    }

    .invoice-card { 
        background: white; border-radius: 1.5rem; border: 1px solid var(--invoice-border); 
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05), 0 10px 10px -5px rgba(0,0,0,0.02); 
        overflow: hidden; max-width: 900px; margin: 0 auto; 
    }
    .invoice-header { 
        background: var(--invoice-emerald); color: white; padding: 3rem; 
        display: flex; justify-content: space-between; align-items: flex-start;
        position: relative;
    }
    .invoice-header::after {
        content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 6px;
        background: rgba(255,255,255,0.1);
    }

    .invoice-body { padding: 3rem; background: #fff; }
    
    .apotek-info h2 { margin: 0; font-size: 2rem; font-weight: 900; letter-spacing: -0.025em; }
    .apotek-info p { margin: 0.75rem 0 0; opacity: 0.85; font-size: 0.95rem; max-width: 350px; line-height: 1.6; font-weight: 500; }
    
    .invoice-meta { text-align: right; }
    .invoice-meta .title { margin: 0; font-size: 0.75rem; font-weight: 800; opacity: 0.7; text-transform: uppercase; letter-spacing: 0.1em; color: white; }
    .invoice-meta .id { margin: 0.25rem 0 0; font-size: 1.75rem; font-weight: 900; letter-spacing: -0.025em; }

    .transaction-grid { 
        display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; 
        margin-bottom: 3rem; padding-bottom: 2rem; border-bottom: 2px solid #f8fafc; 
    }
    .info-group label { 
        display: block; font-size: 0.7rem; font-weight: 800; color: var(--invoice-muted); 
        text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.75rem; 
    }
    .info-group .content-p { display: flex; flex-direction: column; gap: 0.5rem; }
    .info-group p { margin: 0; font-size: 1rem; font-weight: 700; color: var(--invoice-slate); display: flex; justify-content: space-between; }
    .info-group p span.label-s { color: var(--invoice-muted); font-weight: 500; font-size: 0.9rem; }

    .items-table { width: 100%; border-collapse: collapse; margin-bottom: 3rem; }
    .items-table th { 
        text-align: left; padding: 1rem 1.25rem; background: #f8fafc; color: var(--invoice-muted); 
        font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;
        border-bottom: 2px solid var(--invoice-border); 
    }
    .items-table td { padding: 1.5rem 1.25rem; border-bottom: 1px solid #f1f5f9; color: var(--invoice-text); font-size: 1rem; }
    
    .total-section { display: flex; justify-content: flex-end; }
    .total-box { width: 400px; background: #f8fafc; padding: 2rem; border-radius: 1.25rem; border: 1px solid var(--invoice-border); }
    .total-row { display: flex; justify-content: space-between; padding: 0.625rem 0; font-weight: 600; font-size: 0.95rem; }
    
    .total-row.grand-total { 
        border-top: 2px dashed var(--invoice-border); margin-top: 1rem; padding-top: 1.25rem; 
        color: var(--invoice-emerald); font-size: 1.1rem;
    }
    .total-label { color: var(--invoice-muted); }
    .total-value { font-weight: 800; color: var(--invoice-slate); }
    .grand-total .total-value { font-size: 1.75rem; font-weight: 900; color: var(--invoice-emerald); letter-spacing: -0.025em; }

    .payment-info { margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--invoice-border); }
    .pay-row { display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.9rem; }
    .pay-row.kembali { margin-top: 0.75rem; font-size: 1.1rem; font-weight: 800; color: #059669; }

    .btn-print { 
        background: var(--invoice-emerald); color: white; border: none; 
        padding: 1.125rem 2.5rem; border-radius: 1rem; font-weight: 800; 
        cursor: pointer; display: inline-flex; align-items: center; gap: 0.875rem; 
        transition: all 0.3s; margin-top: 3rem; font-size: 1rem;
        box-shadow: 0 10px 15px -3px rgba(6, 78, 75, 0.2);
    }
    .btn-print:hover { background: #042f2e; transform: translateY(-3px); box-shadow: 0 20px 25px -5px rgba(6, 78, 75, 0.3); }

    .badge-tipe { 
        font-size: 0.65rem; font-weight: 800; padding: 0.25rem 0.75rem; 
        border-radius: 0.5rem; text-transform: uppercase;
    }
    .tipe-retail { background: #dcfce7; color: #166534; }
    .tipe-resep { background: #fef3c7; color: #92400e; }

    /* Thermal Receipt Styles */
    .thermal-receipt { 
        display: none; width: 80mm; padding: 5mm; 
        background: white; color: black; font-family: 'Courier New', Courier, monospace; 
        font-size: 10pt; line-height: 1.2;
    }
    .thermal-receipt .header-t { text-align: center; margin-bottom: 10px; border-bottom: 1px dashed black; padding-bottom: 10px; }
    .thermal-receipt .info-t { margin-bottom: 10px; font-size: 9pt; }
    .thermal-receipt .item-row-t { display: flex; justify-content: space-between; margin-bottom: 2px; }
    .thermal-receipt .item-name-t { font-weight: bold; width: 100%; }
    .thermal-receipt .item-details-t { display: flex; justify-content: space-between; padding-left: 5px; margin-bottom: 5px; }
    .thermal-receipt .divider-t { border-top: 1px dashed black; margin: 8px 0; }
    .thermal-receipt .footer-t { text-align: center; margin-top: 15px; font-size: 9pt; }

    @media print {
        body.printing-thermal * { visibility: hidden; }
        body.printing-thermal .thermal-receipt, body.printing-thermal .thermal-receipt * { visibility: visible; }
        body.printing-thermal .thermal-receipt { 
            display: block !important; position: absolute; left: 0; top: 0; 
            width: 80mm !important; margin: 0 !important; padding: 2mm !important;
        }
    }

    .btn-thermal { 
        background: var(--invoice-slate); color: white; border: none; 
        padding: 1.125rem 2.5rem; border-radius: 1rem; font-weight: 800; 
        cursor: pointer; display: inline-flex; align-items: center; gap: 0.875rem; 
        transition: all 0.3s; margin-top: 3rem; font-size: 1rem;
        box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.2);
    }
    .btn-thermal:hover { background: #000; transform: translateY(-3px); }
</style>
@endsection

@section('content')

<div class="back-link-container" style="margin-bottom: 2rem">
    <a href="{{ route('penjualan.index') }}" style="color: var(--invoice-muted); text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 0.75rem; font-size: 0.9rem; transition: all 0.2s;">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar Penjualan
    </a>
</div>

<div class="invoice-card">
    <!-- Header -->
    <div class="invoice-header">
        <div class="apotek-info">
            <h2>{{ $apotek->nama_apotek ?? 'Apotekku' }}</h2>
            <p>{{ $apotek->alamat ?? 'Alamat Belum Diatur' }}<br>Telp: {{ $apotek->no_telp ?? '-' }}</p>
        </div>
        <div class="invoice-meta">
            <div class="title">Invoice Penjualan</div>
            <div class="id">{{ $penjualan->no_transaksi }}</div>
            <div style="margin-top: 0.5rem">
                <span class="badge-tipe {{ $penjualan->tipe_penjualan == 'Resep' ? 'tipe-resep' : 'tipe-retail' }}">
                    {{ $penjualan->tipe_penjualan }}
                </span>
            </div>
        </div>
    </div>

    <!-- Body -->
    <div class="invoice-body">
        <div class="transaction-grid">
            <div class="info-group">
                <label>Informasi Transaksi</label>
                <div class="content-p">
                    <p><span class="label-s">Metode Bayar</span> <span>{{ $penjualan->metode_pembayaran }}</span></p>
                    <p><span class="label-s">Tgl. Transaksi</span> <span>{{ \Carbon\Carbon::parse($penjualan->tanggal_penjualan)->format('d F Y') }}</span></p>
                    <p><span class="label-s">Petugas Kasir</span> <span>{{ $penjualan->user->name ?? '-' }}</span></p>
                </div>
            </div>
            <div class="info-group">
                <label>Detail Pasien / Resep</label>
                <div class="content-p">
                    <p><span class="label-s">Nama Pasien</span> <span>{{ $penjualan->pelanggan->nama ?? 'Customer Umum' }}</span></p>
                    @if($penjualan->tipe_penjualan == 'Resep')
                        <p><span class="label-s">Dokter</span> <span>{{ $penjualan->dokter ?? '-' }}</span></p>
                        <p><span class="label-s">No. Resep</span> <span>{{ $penjualan->no_resep ?? '-' }}</span></p>
                    @else
                        <p><span class="label-s">No. HP</span> <span>{{ $penjualan->pelanggan->no_hp ?? '-' }}</span></p>
                    @endif
                </div>
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Deskripsi Item / Obat</th>
                    <th width="80" class="text-center">Qty</th>
                    <th width="140" class="text-right">Harga Satuan</th>
                    <th width="140" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualan->detailPenjualan as $detail)
                <tr>
                    <td>
                        <div style="font-weight: 800; color: var(--invoice-slate); font-size: 1.05rem">{{ $detail->obat->medicine_name }}</div>
                        <div style="font-size: 0.8rem; color: var(--invoice-muted); margin-top: 0.25rem; font-weight: 500">
                            {{ $detail->obat->medicine_code }} | Satuan: {{ $detail->obat->satuan->unit_name ?? 'Pcs' }}
                        </div>
                    </td>
                    <td class="text-center" style="font-weight: 700">{{ $detail->jumlah }}</td>
                    <td class="text-right" style="font-weight: 600">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td class="text-right" style="font-weight: 800; color: var(--invoice-emerald-light)">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total Section -->
        <div class="total-section">
            <div class="total-box">
                <div class="total-row">
                    <span class="total-label">Subtotal Bruto</span>
                    <span class="total-value">Rp {{ number_format($penjualan->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="total-row">
                    <span class="total-label">Diskon Item</span>
                    <span class="total-value" style="color: #ef4444">- Rp {{ number_format($penjualan->diskon, 0, ',', '.') }}</span>
                </div>
                <div class="total-row">
                    <span class="total-label">PPN (11%)</span>
                    <span class="total-value">Rp {{ number_format($penjualan->ppn, 0, ',', '.') }}</span>
                </div>
                <div class="total-row grand-total">
                    <span class="total-label">Grand Total</span>
                    <span class="total-value">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</span>
                </div>
                
                <div class="payment-info">
                    <div class="pay-row">
                        <span class="label-s">Dibayar ({{ $penjualan->metode_pembayaran }})</span>
                        <span style="font-weight: 700">Rp {{ number_format($penjualan->bayar, 0, ',', '.') }}</span>
                    </div>
                    <div class="pay-row kembali">
                        <span>Kembalian</span>
                        <span>Rp {{ number_format($penjualan->kembali, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: center; margin-top: 4rem">
            <button onclick="printThermal()" class="btn-thermal">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h8a1 1 0 001-1zM13 16l4 2 4-2M17 18v3"/></svg>
                Cetak Struk Thermal (Kasir)
            </button>
        </div>
    </div>
</div>

<!-- Hidden Thermal Receipt Template -->
<div class="thermal-receipt" id="thermalReceipt">
    <div class="header-t">
        <h3 style="margin: 0; font-size: 14pt">{{ $apotek->nama_apotek ?? 'Apotekku' }}</h3>
        <p style="margin: 5px 0 0; font-size: 8pt">{{ $apotek->alamat ?? '-' }}</p>
        <p style="margin: 2px 0 0; font-size: 8pt">Telp: {{ $apotek->no_telp ?? '-' }}</p>
    </div>

    <div class="info-t">
        <div style="display: flex; justify-content: space-between">
            <span>No: {{ $penjualan->no_transaksi }}</span>
            <span>{{ \Carbon\Carbon::parse($penjualan->tanggal_penjualan)->format('d/m/y') }}</span>
        </div>
        <div>Kasir: {{ $penjualan->user->name ?? '-' }}</div>
        <div>Tipe: {{ $penjualan->tipe_penjualan }}</div>
        @if($penjualan->tipe_penjualan == 'Resep')
            <div>Pasien: {{ $penjualan->pelanggan->nama ?? 'Umum' }}</div>
            <div>Dokter: {{ $penjualan->dokter ?? '-' }}</div>
        @endif
    </div>

    <div class="divider-t"></div>

    @foreach($penjualan->detailPenjualan as $detail)
    <div class="item-row-t">
        <span class="item-name-t">{{ $detail->obat->medicine_name }}</span>
    </div>
    <div class="item-details-t">
        <span>{{ $detail->jumlah }} x {{ number_format($detail->harga_satuan, 0, ',', '.') }}</span>
        <span>{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
    </div>
    @endforeach

    <div class="divider-t"></div>

    <div class="item-row-t">
        <span>Subtotal</span>
        <span>{{ number_format($penjualan->subtotal, 0, ',', '.') }}</span>
    </div>
    <div class="item-row-t">
        <span>Diskon</span>
        <span>-{{ number_format($penjualan->diskon, 0, ',', '.') }}</span>
    </div>
    <div class="item-row-t">
        <span>PPN (11%)</span>
        <span>{{ number_format($penjualan->ppn, 0, ',', '.') }}</span>
    </div>
    <div class="item-row-t" style="font-weight: bold; font-size: 11pt; margin-top: 5px">
        <span>GRAND TOTAL</span>
        <span>{{ number_format($penjualan->total_harga, 0, ',', '.') }}</span>
    </div>

    <div class="divider-t"></div>

    <div class="item-row-t">
        <span>Bayar ({{ $penjualan->metode_pembayaran }})</span>
        <span>{{ number_format($penjualan->bayar, 0, ',', '.') }}</span>
    </div>
    <div class="item-row-t">
        <span>Kembalian</span>
        <span>{{ number_format($penjualan->kembali, 0, ',', '.') }}</span>
    </div>

    <div class="footer-t">
        <p>TERIMA KASIH</p>
        <p>Semoga Lekas Sembuh</p>
    </div>
</div>

<script>
    function printThermal() {
        document.body.classList.add('printing-thermal');
        window.print();
        setTimeout(() => {
            document.body.classList.remove('printing-thermal');
        }, 500);
    }
</script>

@endsection
