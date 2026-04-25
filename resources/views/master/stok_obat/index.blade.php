@extends('layouts.app')

@section('title', 'Stok Obat - Apotekku')
@section('page_title', 'Informasi Stok Obat')

@section('styles')
<style>
    /* ===== PAGE HEADER ===== */
    .page-header-banner {
        background: linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #14b8a6 100%);
        border-radius: 1.25rem;
        padding: 1.75rem 2rem;
        margin-bottom: 1.75rem;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 10px 30px rgba(13, 148, 136, 0.25);
    }
    .page-header-banner::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.07);
        border-radius: 50%;
    }
    .page-header-banner::after {
        content: '';
        position: absolute;
        bottom: -60px;
        right: 180px;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .page-header-left { position: relative; z-index: 1; }
    .page-header-left h2 {
        margin: 0 0 0.3rem 0;
        font-size: 1.6rem;
        font-weight: 800;
        color: #fff;
    }
    .page-header-left p {
        margin: 0;
        font-size: 0.95rem;
        color: rgba(255,255,255,0.85);
    }

    /* ===== MINI STATS ===== */
    .mini-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.1rem;
        margin-bottom: 1.75rem;
    }
    .mini-stat {
        background: #fff;
        border-radius: 1rem;
        padding: 1.2rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .mini-stat:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    }
    .mini-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .mini-stat-icon.teal  { background: linear-gradient(135deg, #d1fae5, #ccfbf1); color: #0d9488; }
    .mini-stat-icon.orange { background: linear-gradient(135deg, #ffedd5, #ffedd5); color: #ea580c; }
    .mini-stat-icon.red { background: linear-gradient(135deg, #fee2e2, #fee2e2); color: #dc2626; }
    .mini-stat-lbl { font-size: 0.75rem; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 0.2rem; }
    .mini-stat-val { font-size: 1.5rem; font-weight: 800; color: var(--text-color); margin: 0; line-height: 1.1; }

    /* ===== TABLE CARD ===== */
    .table-card {
        background: #fff;
        border-radius: 1.25rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .table-card-header {
        padding: 1.25rem 1.75rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: linear-gradient(to right, #ffffff, #f0fdfa);
    }
    .table-card-header .icon-box {
        width: 38px;
        height: 38px;
        background: linear-gradient(135deg, #ccfbf1, #d1fae5);
        border-radius: 0.65rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0d9488;
    }
    .table-card-header h3 { margin: 0; font-size: 1.05rem; font-weight: 700; color: var(--text-color); }
    .table-card-body { padding: 1.5rem 2rem 2rem; }

    /* ===== CATEGORY & UNIT BADGES ===== */
    .cat-badge, .unit-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.7rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
    }
    .cat-tablet    { background: #dbeafe; color: #1d4ed8; }
    .cat-kapsul    { background: #fce7f3; color: #be185d; }
    .cat-sirup     { background: #d1fae5; color: #065f46; }
    .cat-salep     { background: #fef3c7; color: #92400e; }
    .cat-injeksi   { background: #ede9fe; color: #6d28d9; }
    .cat-default   { background: #f3f4f6; color: #4b5563; }
    .unit-badge    { background: #f0fdfa; color: #0f766e; border: 1px solid #99f6e4; }

    /* ===== STOCK STATUS BADGES ===== */
    .stock-badge {
        padding: 0.35rem 0.8rem;
        border-radius: 0.5rem;
        font-size: 0.85rem;
        font-weight: 700;
        display: inline-block;
        min-width: 60px;
        text-align: center;
    }
    .stock-safe { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .stock-warning { background: #fef9c3; color: #854d0e; border: 1px solid #fef08a; }
    .stock-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

    /* ===== CODE CHIP ===== */
    .code-chip {
        display: inline-block;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 0.4rem;
        padding: 0.15rem 0.55rem;
        font-family: 'Courier New', monospace;
        font-size: 0.78rem;
        color: #475569;
        font-weight: 600;
        letter-spacing: 0.03em;
    }

    .med-name {
        font-weight: 700;
        color: #0d9488;
        font-size: 0.95rem;
    }

    .action-group { flex-direction: row; }
    
    .btn-detail {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e3a8a;
        border: 1px solid #93c5fd;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.38rem 0.8rem;
        border-radius: 0.5rem;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-detail:hover {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        border-color: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(59,130,246,0.3);
    }
    
    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #9ca3af;
    }
    .empty-state svg { margin-bottom: 1rem; opacity: 0.4; }
    .empty-state p { margin: 0; font-size: 0.95rem; }
    
    /* ===== DATATABLES OVERRIDES ===== */
    .dataTables_wrapper .dataTables_filter input {
        border: 1.5px solid var(--border-color) !important;
        border-radius: 0.65rem !important;
        padding: 0.5rem 0.9rem !important;
        transition: border-color .2s, box-shadow .2s !important;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 3px var(--primary-light) !important;
        outline: none !important;
    }
    .dataTables_wrapper .dataTables_length select {
        border: 1.5px solid var(--border-color) !important;
        border-radius: 0.65rem !important;
        padding: 0.45rem 2rem 0.45rem 0.75rem !important;
        outline: none !important;
    }
    table.dataTable thead th { border-bottom: 2px solid var(--border-color) !important; }
    table.dataTable tbody tr:hover > td { background: #f0fdfa !important; }

</style>
@endsection

@section('content')

@php
    $totalStok = 0;
    $lowStokItems = [];
    $expiringItems = [];
    $now = \Carbon\Carbon::now();

    foreach($obats as $obat) {
        // Calculate Total Stocks & Low Stock check
        $jmlStok = $obat->medicineStocks->sum('stock_qty');
        $totalStok += $jmlStok;
        $minStok = $obat->minimum_stock ?? 10;
        
        if($jmlStok <= $minStok) {
            $lowStokItems[] = [
                'obat' => $obat,
                'qty' => $jmlStok,
                'min' => $minStok
            ];
        }

        // Check for Expiring Batches
        foreach($obat->medicineStocks as $stock) {
            if($stock->stock_qty > 0 && $stock->batch && $stock->batch->expired_date) {
                $ed = \Carbon\Carbon::parse($stock->batch->expired_date);
                $monthsToEd = $now->diffInMonths($ed, false);
                
                if($monthsToEd <= 3) {
                    $expiringItems[] = [
                        'obat' => $obat,
                        'batch' => $stock->batch->batch_number ?? 'Tanpa Batch',
                        'qty' => $stock->stock_qty,
                        'ed' => $ed,
                        'status' => ($monthsToEd < 0) ? 'Kadaluarsa' : 'Hampir Kadaluarsa'
                    ];
                }
            }
        }
    }
    
    // Sort logic
    $outOfStokCount = collect($lowStokItems)->where('qty', 0)->count();
    $lowStokCount = count($lowStokItems) - $outOfStokCount;
@endphp

{{-- ===== PAGE HEADER BANNER ===== --}}
<div class="page-header-banner">
    <div class="page-header-left">
        <h2>
            <svg style="display:inline-block;vertical-align:-4px;margin-right:0.5rem" width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            Informasi Stok Obat
        </h2>
        <p>Pantau ketersediaan, riwayat pergerakan stok, dan lakukan penyesuaian jika diperlukan.</p>
    </div>
</div>

{{-- ===== MINI STATS ===== --}}
<div class="mini-stats">
    <div class="mini-stat">
        <div class="mini-stat-icon teal">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Total Kuantitas Stok</p>
            <p class="mini-stat-val">{{ number_format($totalStok, 0, ',', '.') }}</p>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon orange">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Stok Menipis</p>
            <p class="mini-stat-val">{{ $lowStokCount }}</p>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon red">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Stok Habis</p>
            <p class="mini-stat-val">{{ $outOfStokCount }}</p>
        </div>
    </div>
</div>

{{-- ===== DYNAMIC ALERTS ===== --}}
@if(count($expiringItems) > 0)
<div class="alert alert-danger" style="display:flex; flex-direction:column; align-items:flex-start; margin-bottom:1.5rem;">
    <div style="display:flex; align-items:center;">
        <svg style="margin-right:0.75rem;flex-shrink:0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <strong>Peringatan Kadaluarsa!</strong> Terdapat {{ count($expiringItems) }} batch obat yang sudah atau hampir kadaluarsa (&le; 3 bulan).
    </div>
    <ul style="margin-top:0.5rem; margin-bottom:0; font-size:0.85rem; padding-left:2.5rem; width:100%;">
        @foreach(array_slice($expiringItems, 0, 5) as $item)
            <li><strong>{{ $item['obat']->medicine_name }}</strong> (Batch: {{ $item['batch'] }}) - Stok: {{ $item['qty'] }} - Status: {{ $item['status'] }} pada {{ $item['ed']->translatedFormat('d M Y') }}</li>
        @endforeach
        @if(count($expiringItems) > 5)
            <li><em>... dan {{ count($expiringItems) - 5 }} batch lainnya.</em></li>
        @endif
    </ul>
</div>
@endif

@if(count($lowStokItems) > 0)
<div class="alert" style="background-color:#fffbeb; color:#92400e; border:1px solid #fef3c7; border-left:4px solid #f59e0b; display:flex; flex-direction:column; align-items:flex-start; margin-bottom:1.5rem;">
    <div style="display:flex; align-items:center;">
        <svg style="margin-right:0.75rem;flex-shrink:0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <strong>Peringatan Stok Tipis!</strong> Terdapat {{ count($lowStokItems) }} obat yang stoknya minim atau habis.
    </div>
    <ul style="margin-top:0.5rem; margin-bottom:0; font-size:0.85rem; padding-left:2.5rem; width:100%;">
        @foreach(array_slice($lowStokItems, 0, 5) as $item)
            <li><strong>{{ $item['obat']->medicine_name }}</strong> - Sisa Stok: {{ $item['qty'] }} (Batas Min: {{ $item['min'] }})</li>
        @endforeach
        @if(count($lowStokItems) > 5)
            <li><em>... dan {{ count($lowStokItems) - 5 }} obat lainnya.</em></li>
        @endif
    </ul>
</div>
@endif

{{-- ===== TABLE CARD ===== --}}
<div class="table-card">
    <div class="table-card-header">
        <div class="icon-box">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
        </div>
        <h3>Daftar Stok Obat</h3>
    </div>
    <div class="table-card-body">
        <table class="datatable" style="border:none;border-radius:0;">
            <thead>
                <tr>
                    <th width="4%">No</th>
                    <th width="11%">Kode</th>
                    <th width="25%">Nama Obat</th>
                    <th width="15%">Kategori</th>
                    <th width="10%">Satuan</th>
                    <th width="15%" style="text-align:center;">Jumlah Stok</th>
                    <th width="10%" style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($obats as $index => $o)
                @php
                    $catName = strtolower(optional($o->kategori)->category_name ?? '');
                    $catClass = 'cat-default';
                    if (str_contains($catName, 'tablet'))   $catClass = 'cat-tablet';
                    elseif (str_contains($catName, 'kapsul')) $catClass = 'cat-kapsul';
                    elseif (str_contains($catName, 'sirup'))  $catClass = 'cat-sirup';
                    elseif (str_contains($catName, 'salep'))  $catClass = 'cat-salep';
                    elseif (str_contains($catName, 'injeksi') || str_contains($catName, 'suntik')) $catClass = 'cat-injeksi';

                    $qty = $o->medicineStocks->sum('stock_qty');
                    $minStok = $o->minimum_stock ?? 10;
                    
                    if ($qty == 0) {
                        $stockClass = 'stock-danger';
                    } elseif ($qty <= $minStok) {
                        $stockClass = 'stock-warning';
                    } else {
                        $stockClass = 'stock-safe';
                    }
                @endphp
                <tr>
                    <td style="color:#9ca3af;font-size:0.85rem;font-weight:600;">{{ $index + 1 }}</td>
                    <td><span class="code-chip">{{ $o->medicine_code }}</span></td>
                    <td>
                        <div class="med-name">{{ $o->medicine_name }}</div>
                    </td>
                    <td>
                        @if(optional($o->kategori)->category_name)
                            <span class="cat-badge {{ $catClass }}">{{ $o->kategori->category_name }}</span>
                        @else
                            <span style="color:#9ca3af;font-size:0.8rem;">—</span>
                        @endif
                    </td>
                    <td>
                        @if(optional($o->satuan)->unit_name)
                            <span class="unit-badge">{{ $o->satuan->unit_name }}</span>
                        @else
                            <span style="color:#9ca3af;font-size:0.8rem;">—</span>
                        @endif
                    </td>
                    <td style="text-align:center;">
                        <span class="stock-badge {{ $stockClass }}">{{ number_format($qty, 0, ',', '.') }}</span>
                    </td>
                    <td style="text-align:center;">
                        <div class="action-group" style="display:flex; justify-content:center;">
                            <a href="{{ route('stok-obat.show', $o->id) }}" class="btn-detail" style="text-decoration:none;">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <svg width="56" height="56" fill="none" stroke="#9ca3af" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p>Belum ada data obat atau stok. Silakan tambahkan pada menu <strong>Master Obat</strong>.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
