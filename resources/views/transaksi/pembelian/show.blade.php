@extends('layouts.app')

@section('title', 'Detail Pembelian #{{ $pembelian->no_faktur }} - Apotekku')
@section('page_title', 'Detail Transaksi Pembelian')

@section('styles')
<style>
    .back-btn { display:inline-flex; align-items:center; gap:.5rem; background:#fff; border:1px solid var(--border-color); color:var(--text-color); padding:.55rem 1.2rem; border-radius:.75rem; font-size:.88rem; font-weight:700; text-decoration:none; margin-bottom:1.5rem; transition:all .2s; box-shadow:0 2px 8px rgba(0,0,0,.05); }
    .back-btn:hover { background:#f8fafc; border-color:#94a3b8; transform:translateY(-1px); }
    .detail-grid { display:grid; grid-template-columns:1fr 380px; gap:1.5rem; align-items:start; }
    @media(max-width:1100px){ .detail-grid { grid-template-columns:1fr; } }
    .panel-card { background:#fff; border-radius:1.25rem; border:1px solid var(--border-color); box-shadow:0 4px 20px rgba(0,0,0,.04); overflow:hidden; margin-bottom:1.5rem; }
    .panel-header { padding:1.1rem 1.5rem; border-bottom:1px solid var(--border-color); display:flex; align-items:center; gap:.65rem; }
    .panel-icon { width:34px; height:34px; border-radius:.6rem; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .panel-icon.teal  { background:linear-gradient(135deg,#ccfbf1,#d1fae5); color:#0d9488; }
    .panel-icon.blue  { background:linear-gradient(135deg,#dbeafe,#eff6ff); color:#2563eb; }
    .panel-icon.green { background:linear-gradient(135deg,#d1fae5,#ecfdf5); color:#059669; }
    .panel-header h3 { margin:0; font-size:.98rem; font-weight:700; color:var(--text-color); }
    .info-table { width:100%; border-collapse:collapse; }
    .info-table tr td { padding:.65rem 1.4rem; font-size:.88rem; border-bottom:1px solid #f1f5f9; }
    .info-table tr:last-child td { border-bottom:none; }
    .info-table .lbl { color:#9ca3af; font-weight:700; font-size:.78rem; text-transform:uppercase; width:35%; }
    .info-table .val { color:var(--text-color); font-weight:600; }
    .faktur-badge { display:inline-block; background:#f0fdf4; border:1px solid #86efac; border-radius:.4rem; padding:.2rem .7rem; font-family:monospace; font-size:.9rem; color:#166534; font-weight:800; }
    .detail-items { width:100%; border-collapse:collapse; }
    .detail-items th { padding:.65rem 1.25rem; font-size:.75rem; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:.04em; border-bottom:1.5px solid var(--border-color); background:#f8fafc; }
    .detail-items td { padding:.75rem 1.25rem; font-size:.88rem; border-bottom:1px solid #f1f5f9; }
    .detail-items tr:last-child td { border-bottom:none; }
    .detail-items tr:hover td { background:#f0fdfa; }
    .obat-code { display:inline-block; background:#f8fafc; border:1px solid #e2e8f0; border-radius:.35rem; padding:.1rem .45rem; font-family:monospace; font-size:.75rem; color:#475569; }
    .obat-name { font-weight:700; color:#1f2937; }
    .num-val { font-weight:700; color:#374151; }
    .subtot { font-weight:700; color:#0f766e; }

    /* Summary Card */
    .summary-card { background:#fff; border-radius:1.25rem; border:1px solid var(--border-color); box-shadow:0 4px 20px rgba(0,0,0,.06); overflow:hidden; position:sticky; top:1rem; }
    .summary-header { padding:1.1rem 1.5rem; background:linear-gradient(135deg,#1e3a5f,#0d9488); }
    .summary-header h3 { margin:0; font-size:1rem; font-weight:800; color:#fff; }
    .summary-body { padding:1.4rem 1.5rem; }
    .sum-row { display:flex; justify-content:space-between; align-items:center; padding:.45rem 0; border-bottom:1px dashed #e2e8f0; }
    .sum-row:last-child { border-bottom:none; }
    .sum-row .sl { font-size:.85rem; color:#6b7280; font-weight:600; }
    .sum-row .sv { font-size:.85rem; font-weight:700; color:var(--text-color); }
    .grand-sum { display:flex; justify-content:space-between; align-items:center; padding:1rem 1.5rem; background:linear-gradient(135deg,#f0fdfa,#ecfdf5); border-top:1.5px solid #a7f3d0; }
    .grand-sum .gl { font-size:1rem; font-weight:800; color:#1f2937; }
    .grand-sum .gv { font-size:1.25rem; font-weight:900; color:#0f766e; }

    .btn-print { display:flex; align-items:center; justify-content:center; gap:.5rem; width:100%; padding:.8rem 1.5rem; background:linear-gradient(135deg,#1e3a5f,#2563eb); border:none; border-radius:.85rem; color:#fff; font-size:.9rem; font-weight:700; cursor:pointer; margin:1rem 1.5rem 0; width:calc(100% - 3rem); transition:all .2s; }
    .btn-print:hover { opacity:.9; transform:translateY(-1px); }

    /* ===== PRINT STYLES ===== */
    .print-header { display: none; padding-bottom: 2rem; border-bottom: 2px solid #334155; margin-bottom: 2rem; }
    .print-header-content { display: flex; justify-content: space-between; align-items: center; }
    .pharmacy-info h2 { margin: 0; color: #0d9488; font-size: 1.8rem; font-weight: 800; }
    .pharmacy-info p { margin: 2px 0; color: #475569; font-size: 0.9rem; font-weight: 500; }
    .invoice-label { text-align: right; }
    .invoice-label h1 { margin: 0; font-size: 2.2rem; color: #1e293b; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; }
    
    @media print {
        @page { size: A4; margin: 1.5cm; }
        body { background: white !important; padding: 0 !important; }
        .sidebar, .top-navbar, .back-btn, .btn-print, .summary-header, .summary-body > .btn-back-wrapper { display: none !important; }
        .main-content { padding: 0 !important; margin: 0 !important; }
        .detail-grid { display: block !important; }
        .panel-card, .summary-card { border: none !important; box-shadow: none !important; margin-bottom: 1rem !important; }
        .summary-card { position: static !important; }
        .panel-header { border-bottom: 1px solid #e2e8f0 !important; padding: 0.5rem 0 !important; }
        .panel-icon { display: none !important; }
        .print-header { display: block !important; }
        .faktur-badge { border: none !important; padding: 0 !important; font-size: 1.1rem !important; color: black !important; }
        .detail-items th { background: #f1f5f9 !important; color: black !important; border-bottom: 1px solid black !important; }
        .grand-sum { border: 1px solid #e2e8f0 !important; background: transparent !important; margin-top: 2rem; }
        .grand-sum .gv { color: black !important; }
        .no-print { display: none !important; }
        .back-btn-wrapper { display: none !important; }
    }
</style>
@endsection

@section('content')
</a>

{{-- PRINT HEADER (KOP SURAT) --}}
<div class="print-header">
    <div class="print-header-content">
        <div class="pharmacy-info">
            <h2>{{ $apotek->nama_apotek ?? 'APOTEKKU' }}</h2>
            <p>{{ $apotek->alamat ?? 'Jl. Raya Sehat No. 123' }}</p>
            <p>Telp: {{ $apotek->no_telp ?? '-' }} | Email: {{ $apotek->email ?? '-' }}</p>
            <p>SIA: {{ $apotek->sia ?? '-' }} | SIP: {{ $apotek->sip ?? '-' }}</p>
        </div>
        <div class="invoice-label">
            <h1>FAKTUR</h1>
            <p style="font-weight: 700; color: #64748b;">ASLI PEMBELIAN</p>
        </div>
    </div>
</div>

<div class="detail-grid">
    {{-- KIRI: Info + Tabel Detail --}}
    <div>
        {{-- Info Header --}}
        <div class="panel-card">
            <div class="panel-header">
                <div class="panel-icon teal">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3>Informasi Transaksi</h3>
                <span style="margin-left:auto;" class="faktur-badge">{{ $pembelian->no_faktur }}</span>
            </div>
            <table class="info-table">
                <tr>
                    <td class="lbl">No. Faktur</td>
                    <td class="val"><span style="font-family:monospace;font-weight:800;color:#166534;">{{ $pembelian->no_faktur }}</span></td>
                </tr>
                <tr>
                    <td class="lbl">Tanggal</td>
                    <td class="val">{{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td class="lbl">Supplier</td>
                    <td class="val">
                        <span style="display:inline-flex;align-items:center;gap:.3rem;background:#eff6ff;border:1px solid #bfdbfe;border-radius:.4rem;padding:.2rem .65rem;font-size:.85rem;color:#1d4ed8;font-weight:700;">
                            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                            {{ optional($pembelian->supplier)->supplier_name ?? '—' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="lbl">Dibuat Oleh</td>
                    <td class="val">{{ optional($pembelian->user)->name ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="lbl">Dibuat Pada</td>
                    <td class="val">{{ $pembelian->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>

        {{-- Tabel Detail Item --}}
        <div class="panel-card">
            <div class="panel-header">
                <div class="panel-icon blue">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                </div>
                <h3>Detail Item Pembelian</h3>
                <span style="margin-left:auto;background:#eff6ff;border:1px solid #bfdbfe;color:#1d4ed8;font-size:.78rem;font-weight:700;padding:.2rem .65rem;border-radius:999px;">{{ $pembelian->detailPembelian->count() }} item</span>
            </div>
            <table class="detail-items">
                <thead>
                    <tr>
                        <th style="text-align:left;">No</th>
                        <th style="text-align:left;" class="no-print">Kode</th>
                        <th style="text-align:left;">Nama Obat</th>
                        <th style="text-align:left;">Satuan</th>
                        <th style="text-align:center;">Qty</th>
                        <th style="text-align:right;">Harga Satuan</th>
                        <th style="text-align:right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembelian->detailPembelian as $i => $detail)
                    <tr>
                        <td style="color:#9ca3af;font-size:.82rem;">{{ $i + 1 }}</td>
                        <td class="no-print"><span class="obat-code">{{ optional($detail->obat)->medicine_code ?? '—' }}</span></td>
                        <td><span class="obat-name">{{ optional($detail->obat)->medicine_name ?? '—' }}</span></td>
                        <td style="color:#6b7280;font-size:.85rem;">{{ optional(optional($detail->obat)->satuan)->unit_name ?? '—' }}</td>
                        <td style="text-align:center;"><span class="num-val">{{ $detail->jumlah }}</span></td>
                        <td style="text-align:right;color:#374151;font-size:.88rem;">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                        <td style="text-align:right;"><span class="subtot">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align:center;padding:2rem;color:#9ca3af;">Tidak ada item.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- KANAN: Summary --}}
    <div>
        <div class="summary-card">
            <div class="summary-header">
                <h3>📊 Ringkasan Pembelian</h3>
            </div>
            <div class="summary-body">
                <div class="sum-row">
                    <span class="sl">Jumlah Item</span>
                    <span class="sv">{{ $pembelian->detailPembelian->count() }} item</span>
                </div>
                <div class="sum-row">
                    <span class="sl">Total Qty</span>
                    <span class="sv">{{ $pembelian->detailPembelian->sum('jumlah') }} pcs</span>
                </div>
                <div class="sum-row">
                    <span class="sl">Supplier</span>
                    <span class="sv">{{ optional($pembelian->supplier)->supplier_name ?? '—' }}</span>
                </div>
                <div class="sum-row">
                    <span class="sl">Tanggal Beli</span>
                    <span class="sv">{{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->format('d/m/Y') }}</span>
                </div>
            </div>
            <div class="grand-sum">
                <span class="gl">Total Pembayaran</span>
                <span class="gv">Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</span>
            </div>
            <button type="button" class="btn-print" onclick="window.print()">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak / Print
            </button>
            <div class="back-btn-wrapper" style="padding:.75rem 1.5rem 1.25rem;">
                <a href="{{ route('pembelian.index') }}" style="display:flex;align-items:center;justify-content:center;gap:.5rem;width:100%;padding:.75rem;background:#f8fafc;border:1.5px solid var(--border-color);border-radius:.75rem;color:var(--text-color);font-size:.88rem;font-weight:700;text-decoration:none;transition:background .2s;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
