@extends('layouts.app')

@section('content')
<div class="ret-container">
    <div class="ret-header no-print">
        <div class="ret-header-info">
            <h2 class="fw-bold text-slate-800 mb-1">Detail Return #{{ $return->no_return }}</h2>
            <p class="text-slate-500 mb-0">Informasi pengembalian barang ke supplier</p>
        </div>
        <div class="ret-header-actions">
            <a href="{{ route('return-pembelian.index') }}" class="btn-outline">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn-emerald">
                <i class="fas fa-print"></i> Cetak Nota
            </button>
        </div>
    </div>

    <div class="nota-card">
        <div class="nota-header">
            <div class="nota-header-left">
                <h4 class="fw-bold mb-1">{{ $apotek->nama_apotek ?? 'Apotek POS' }}</h4>
                <p class="mb-0 small opacity-80">{{ $apotek->alamat ?? '-' }}</p>
            </div>
            <div class="nota-header-right text-end">
                <h3 class="fw-bold mb-1 text-uppercase letter-spacing-1">NOTA RETURN</h3>
                <p class="mb-0 small opacity-80">Faktur Asal: {{ $return->pembelian->no_faktur }}</p>
            </div>
        </div>
        
        <div class="nota-body">
            <div class="nota-info-grid">
                <div class="nota-info-block">
                    <h6 class="stats-label mb-3">Informasi Transaksi</h6>
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">No. Return</span>
                            <span class="info-value">: {{ $return->no_return }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tanggal</span>
                            <span class="info-value">: {{ \Carbon\Carbon::parse($return->tanggal_return)->format('d F Y') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Petugas</span>
                            <span class="info-value">: {{ $return->user->name ?? '-' }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="nota-info-block border-left-slate ps-4">
                    <h6 class="stats-label mb-3">Supplier</h6>
                    <div class="fw-bold text-slate-800 h5 mb-1">{{ $return->pembelian->supplier->supplier_name }}</div>
                    <p class="text-slate-600 mb-1 small"><i class="fas fa-map-marker-alt me-2"></i>{{ $return->pembelian->supplier->supplier_address ?? '-' }}</p>
                    <p class="text-slate-600 mb-0 small"><i class="fas fa-phone me-2"></i>{{ $return->pembelian->supplier->supplier_phone ?? '-' }}</p>
                </div>
                
                <div class="nota-info-block border-left-slate ps-4">
                    <h6 class="stats-label mb-3">Alasan Return</h6>
                    <div class="reason-box">
                        "{{ $return->alasan ?: 'Tidak ada keterangan' }}"
                    </div>
                </div>
            </div>

            <h6 class="stats-label mb-3 mt-5">Daftar Barang yang Dikembalikan</h6>
            <div class="table-container mb-5">
                <table class="custom-table formal">
                    <thead>
                        <tr>
                            <th class="ps-4">No.</th>
                            <th>Nama Obat / Produk</th>
                            <th class="text-center">Satuan</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Harga Beli</th>
                            <th class="pe-4 text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($return->details as $idx => $detail)
                        <tr>
                            <td class="ps-4">{{ $idx + 1 }}</td>
                            <td>
                                <div class="fw-bold text-slate-800">{{ $detail->obat->medicine_name }}</div>
                            </td>
                            <td class="text-center">{{ $detail->obat->satuan->unit_name ?? '-' }}</td>
                            <td class="text-center fw-bold">{{ $detail->jumlah }}</td>
                            <td class="text-end text-slate-600">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td class="pe-4 text-end fw-bold text-slate-800">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td colspan="5" class="text-end fw-bold text-emerald-700 py-3">TOTAL NILAI RETURN</td>
                            <td class="pe-4 text-end fw-bold text-emerald-700 py-3 h5 mb-0">Rp {{ number_format($return->total_return, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="nota-footer-grid">
                <div class="signature-block">
                    <p class="mb-5 text-slate-500 italic small">Dikeluarkan oleh,</p>
                    <div class="signature-line">
                        {{ $return->user->name ?? '-' }}
                    </div>
                </div>
                <div class="signature-block text-end">
                    <p class="mb-5 text-slate-500 italic small">Diterima oleh Supplier,</p>
                    <div class="signature-line ml-auto">
                        Tanda Tangan & Cap
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --slate-900: #0f172a; --slate-800: #1e293b; --slate-700: #334155;
        --slate-600: #475569; --slate-500: #64748b; --slate-400: #94a3b8;
        --slate-100: #f1f5f9; --slate-50: #f8fafc;
        --emerald-700: #047857; --emerald-600: #059669; --emerald-500: #10b981; --emerald-50: #ecfdf5;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .ret-container { display: flex; flex-direction: column; gap: 2rem; }
    
    /* Header */
    .ret-header { display: flex; justify-content: space-between; align-items: center; }
    .ret-header-actions { display: flex; gap: 1rem; }
    
    .btn-emerald { 
        background-color: var(--emerald-600); color: white; padding: 0.75rem 1.5rem; 
        border-radius: 0.75rem; font-weight: 700; text-decoration: none; 
        box-shadow: var(--shadow); transition: all 0.2s; border: none; cursor: pointer;
        display: inline-flex; align-items: center; gap: 0.5rem;
    }
    .btn-emerald:hover { background-color: var(--emerald-700); transform: translateY(-2px); }
    
    .btn-outline {
        border: 2px solid var(--slate-200); color: #64748b; padding: 0.6rem 1.25rem;
        border-radius: 0.75rem; font-weight: 700; text-decoration: none !important; transition: all 0.2s;
        display: inline-flex; align-items: center; gap: 0.5rem;
    }
    .btn-outline:hover { background: var(--slate-50); border-color: var(--slate-300); }

    /* Nota Card */
    .nota-card { background: white; border-radius: 1.25rem; box-shadow: var(--shadow); overflow: hidden; border: 1px solid var(--slate-100); }
    .nota-header { background: var(--slate-900); color: white; padding: 2rem 3rem; display: flex; justify-content: space-between; align-items: center; }
    .nota-body { padding: 3rem; }

    /* Info Grid */
    .nota-info-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 2rem; }
    .nota-info-block { flex: 1; }
    .border-left-slate { border-left: 1px solid var(--slate-100); }
    .ps-4 { padding-left: 1.5rem; }
    
    .stats-label { color: var(--slate-500); font-weight: 700; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.5rem; }
    .info-list { display: flex; flex-direction: column; gap: 0.5rem; }
    .info-item { display: flex; align-items: center; gap: 0.5rem; }
    .info-label { width: 100px; color: var(--slate-500); font-size: 0.9rem; }
    .info-value { font-weight: 700; color: var(--slate-800); }
    
    .reason-box { background: var(--slate-50); padding: 1rem; border-radius: 0.75rem; border: 1px solid var(--slate-100); font-style: italic; color: var(--slate-700); }

    /* Table */
    .table-container { width: 100%; overflow-x: auto; }
    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { background: var(--slate-50); padding: 0.75rem 1rem; text-align: left; font-size: 0.7rem; text-transform: uppercase; color: var(--slate-500); font-weight: 800; }
    .custom-table td { padding: 1rem; border-bottom: 1px solid var(--slate-50); }
    .custom-table.formal td { border-bottom: 1px solid #eee; }
    
    .total-row { background: var(--emerald-50); }
    
    /* Footer */
    .nota-footer-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; margin-top: 5rem; }
    .signature-block { display: flex; flex-direction: column; }
    .signature-line { width: 200px; border-top: 1.5px solid var(--slate-800); padding-top: 0.5rem; font-weight: 800; color: var(--slate-800); text-align: center; }
    .ml-auto { margin-left: auto; }
    .text-end { text-align: right; }

    @media print {
        .no-print { display: none !important; }
        .nota-card { box-shadow: none !important; border: 1px solid #000 !important; border-radius: 0 !important; }
        .nota-header { background-color: #000 !important; color: #fff !important; padding: 1.5rem !important; }
        .nota-body { padding: 1.5rem !important; }
        body { background: white !important; }
        .ret-container { gap: 0 !important; }
    }

    @media (max-width: 768px) {
        .nota-info-grid { grid-template-columns: 1fr; gap: 1.5rem; }
        .border-left-slate { border-left: none; padding-left: 0; border-top: 1px solid var(--slate-100); padding-top: 1.5rem; }
        .nota-footer-grid { grid-template-columns: 1fr; gap: 3rem; }
        .signature-line { margin: 0 auto !important; }
        .text-end { text-align: center; }
    }
</style>
@endsection
