@extends('layouts.app')

@section('content')
<div class="ret-container">
    <!-- Header -->
    <div class="ret-header">
        <div class="ret-header-info">
            <h2 class="fw-bold text-slate-800 mb-1">Detail Return Penjualan</h2>
            <div class="d-flex align-items-center gap-2 mt-2">
                <span class="badge-accent">No: {{ $return->no_return_pj }}</span>
                <span class="text-slate-400 fs-sm">|</span>
                <span class="text-slate-500 fs-sm">{{ \Carbon\Carbon::parse($return->tanggal_return)->format('d F Y') }}</span>
            </div>
        </div>
        <div class="ret-header-actions no-print">
            <button onclick="window.print()" class="btn-slate">
                <i class="fas fa-print"></i> Cetak Dokumen
            </button>
            <a href="{{ route('return-penjualan.index') }}" class="btn-emerald">
                <i class="fas fa-list"></i> Riwayat Return
            </a>
        </div>
    </div>

    <div class="grid-receipt">
        <!-- Left Column: Summary & Items -->
        <div class="receipt-card main-card">
            <div class="receipt-body">
                <!-- Branding Context -->
                <div class="receipt-context">
                    <div class="brand">
                        <div class="brand-name">{{ $apotek->nama_apotek ?? 'Apotekku' }}</div>
                        <div class="brand-sub">{{ $apotek->alamat ?? 'Alamat Belum Diatur' }}</div>
                        <div class="brand-sub">Telp: {{ $apotek->telepon ?? '-' }}</div>
                    </div>
                    <div class="status-stamp">
                        SALES RETURN
                    </div>
                </div>

                <hr class="receipt-divider">

                <!-- Metadata Grid -->
                <div class="meta-grid">
                    <div class="meta-item">
                        <label>Faktur Penjualan Asal</label>
                        <div class="value fw-bold text-emerald-700">{{ $return->penjualan->no_transaksi }}</div>
                    </div>
                    <div class="meta-item text-end">
                        <label>Pelanggan</label>
                        <div class="value">{{ $return->penjualan->pelanggan->nama ?? 'Umum' }}</div>
                    </div>
                    <div class="meta-item">
                        <label>Petugas (Apoteker)</label>
                        <div class="value">{{ $return->user->name ?? '-' }}</div>
                    </div>
                    <div class="meta-item text-end">
                        <label>Waktu Input</label>
                        <div class="value">{{ $return->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>

                <!-- Product Table -->
                <div class="table-title mt-4">Rincian Barang Direturn</div>
                <table class="receipt-table">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($return->details as $detail)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $detail->obat->medicine_name }}</div>
                                <div class="text-slate-400 fs-xs">{{ $detail->obat->satuan->satuan_name ?? '' }}</div>
                            </td>
                            <td class="text-center fw-semibold">{{ $detail->jumlah }}</td>
                            <td class="text-end">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td class="text-end fw-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Summary Row -->
                <div class="grand-total-section">
                    <div class="total-label">Total Nilai Return</div>
                    <div class="total-value">Rp {{ number_format($return->total_return, 0, ',', '.') }}</div>
                </div>

                <!-- Footer / Signatures -->
                <div class="signature-section mt-5">
                    <div class="sig-box">
                        <label>Pelanggan,</label>
                        <div class="sig-space"></div>
                        <div class="sig-name">( {{ $return->penjualan->pelanggan->nama ?? '..........................' }} )</div>
                    </div>
                    <div class="sig-box">
                        <label>Apoteker/Petugas,</label>
                        <div class="sig-space"></div>
                        <div class="sig-name">( {{ $return->user->name }} )</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Sidebar Info -->
        <div class="receipt-card info-sidebar no-print">
            <div class="receipt-header">Detail Informasi</div>
            <div class="receipt-body">
                <div class="info-group">
                    <label>Alasan Pengembalian</label>
                    <p class="text-slate-600 italic">"{{ $return->alasan ?? 'Tidak ada alasan spesifik recorded.' }}"</p>
                </div>
                <div class="info-group mt-3">
                    <label>Metode Penjualan Asal</label>
                    <div class="badge-emerald">{{ $return->penjualan->metode_pembayaran }}</div>
                </div>
                <div class="alert-info mt-4">
                    <i class="fas fa-info-circle"></i>
                    Return ini direkam sebagai mutasi **STOK MASUK**. Periksa laporan mutasi untuk verifikasi.
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --emerald-600: #059669; --emerald-700: #047857;
        --slate-800: #1e293b; --slate-600: #475569; --slate-400: #94a3b8;
        --slate-100: #f1f5f9;
    }

    .ret-container { display: flex; flex-direction: column; gap: 2rem; max-width: 1200px; margin: auto; }
    .ret-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 1rem; }
    
    .badge-accent { background: var(--slate-800); color: white; padding: 0.3rem 0.8rem; border-radius: 6px; font-weight: 700; font-size: 0.9rem; }
    .fs-sm { font-size: 0.875rem; }
    .fs-xs { font-size: 0.75rem; }

    .btn-slate { background: #64748b; color: white; padding: 0.6rem 1.25rem; border-radius: 0.5rem; text-decoration: none; border: none; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; }
    .btn-emerald { background: var(--emerald-600); color: white; padding: 0.6rem 1.25rem; border-radius: 0.5rem; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; }
    .btn-emerald:hover { background: var(--emerald-700); color: white; }

    .grid-receipt { display: grid; grid-template-columns: 1fr 320px; gap: 2rem; align-items: start; }
    .receipt-card { background: white; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); border: 1px solid var(--slate-100); overflow: hidden; }
    .receipt-header { background: var(--slate-50); padding: 1rem 1.5rem; font-weight: 800; border-bottom: 1px solid var(--slate-100); color: var(--slate-800); }
    .receipt-body { padding: 2rem; }

    .receipt-context { display: flex; justify-content: space-between; align-items: center; }
    .brand-name { font-size: 1.5rem; font-weight: 900; color: var(--emerald-700); letter-spacing: -0.5px; }
    .brand-sub { font-size: 0.85rem; color: var(--slate-400); }
    .status-stamp { border: 3px solid #fecaca; color: #ef4444; font-weight: 950; padding: 0.5rem 1rem; border-radius: 8px; transform: rotate(-5deg); font-size: 1.1rem; }

    .receipt-divider { border: 0; border-top: 2px dashed var(--slate-100); margin: 2rem 0; }

    .meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
    .meta-item label { display: block; font-size: 0.75rem; color: var(--slate-400); text-transform: uppercase; font-weight: 800; margin-bottom: 0.25rem; }
    .meta-item .value { font-size: 0.95rem; color: var(--slate-800); }

    .table-title { font-weight: 800; color: var(--slate-800); margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--slate-100); }
    .receipt-table { width: 100%; border-collapse: collapse; }
    .receipt-table th { padding: 0.75rem 0.5rem; border-bottom: 2px solid var(--slate-100); text-align: left; font-size: 0.8rem; text-transform: uppercase; color: var(--slate-400); }
    .receipt-table td { padding: 1rem 0.5rem; border-bottom: 1px solid var(--slate-100); color: var(--slate-800); }

    .grand-total-section { margin-top: 2rem; padding: 1.5rem; background: var(--slate-50); border-radius: 12px; display: flex; justify-content: space-between; align-items: center; }
    .total-label { font-weight: 800; color: var(--slate-400); text-transform: uppercase; }
    .total-value { font-size: 1.75rem; font-weight: 900; color: var(--emerald-700); }

    .signature-section { display: flex; justify-content: space-between; }
    .sig-box { width: 180px; text-align: center; }
    .sig-box label { font-size: 0.85rem; font-weight: 700; color: var(--slate-600); }
    .sig-space { height: 80px; }
    .sig-name { font-weight: 700; border-top: 1px solid var(--slate-800); padding-top: 0.5rem; }

    .info-group label { display: block; font-weight: 800; font-size: 0.8rem; color: var(--slate-400); text-transform: uppercase; margin-bottom: 0.5rem; }
    .badge-emerald { background: var(--emerald-50); color: var(--emerald-700); padding: 0.4rem 0.8rem; border-radius: 6px; font-weight: 700; display: inline-block; font-size: 0.85rem; }
    .alert-info { background: #eff6ff; color: #1e40af; padding: 1rem; border-radius: 10px; font-size: 0.85rem; border: 1px solid #bfdbfe; }
    .alert-info i { margin-right: 0.5rem; }

    @media print {
        .no-print { display: none !important; }
        .main-card { border: none !important; box-shadow: none !important; width: 100% !important; margin: 0 !important; }
        .ret-container { padding: 0 !important; max-width: 100% !important; }
        .grid-receipt { grid-template-columns: 1fr !important; }
        body { background: white !important; }
    }

    @media (max-width: 768px) {
        .grid-receipt { grid-template-columns: 1fr; }
        .signature-section { flex-direction: column; gap: 2rem; align-items: center; }
    }
</style>
@endsection
