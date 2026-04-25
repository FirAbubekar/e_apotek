@extends('layouts.app')

@section('title', 'Detail Stok Obat - Apotekku')
@section('page_title', 'Detail & Riwayat Stok')

@section('styles')
<style>
    /* ===== BACK BUTTON ===== */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #4b5563;
        font-weight: 600;
        text-decoration: none;
        margin-bottom: 1.5rem;
        transition: color 0.2s;
        font-size: 0.95rem;
    }
    .btn-back:hover { color: var(--primary-color); }
    
    /* ===== SUMMARY CARD ===== */
    .summary-card {
        background: #fff;
        border-radius: 1.25rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    .summary-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 6px; height: 100%;
        background: linear-gradient(to bottom, #0f766e, #14b8a6);
    }
    .summary-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 1px dashed #e5e7eb;
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .med-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1a1a1a;
        margin: 0 0 0.5rem 0;
    }
    .med-meta {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    
    /* ===== STOCKS HIGHLIGHT ===== */
    .stock-highlight {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 1rem 1.75rem;
        border-radius: 1rem;
        text-align: center;
        min-width: 140px;
    }
    .stock-highlight-val {
        font-size: 2.2rem;
        font-weight: 900;
        line-height: 1;
        margin-bottom: 0.3rem;
    }
    .stock-highlight-val.safe { color: #0d9488; }
    .stock-highlight-val.warn { color: #d97706; }
    .stock-highlight-val.danger { color: #dc2626; }
    .stock-highlight-lbl {
        font-size: 0.8rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    /* ===== INFO GRID ===== */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
    }
    .info-item { display: flex; flex-direction: column; gap: 0.4rem; }
    .info-lbl { font-size: 0.8rem; color: #9ca3af; font-weight: 600; text-transform: uppercase; }
    .info-val { font-size: 1.05rem; font-weight: 700; color: #1f2937; }

    /* ===== TABS UI ===== */
    .tab-container {
        background: #fff;
        border-radius: 1.25rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .tab-header {
        display: flex;
        border-bottom: 1px solid var(--border-color);
        background: #f8fafc;
    }
    .tab-btn {
        padding: 1.25rem 2rem;
        font-size: 0.95rem;
        font-weight: 700;
        color: #64748b;
        background: transparent;
        border: none;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        transition: all 0.2s;
    }
    .tab-btn:hover { color: #0f766e; background: #f0fdfa; }
    .tab-btn.active {
        color: #0f766e;
        border-bottom-color: #0d9488;
        background: #fff;
    }
    
    .tab-content { display: none; padding: 2rem; }
    .tab-content.active { display: block; animation: fadeIn 0.3s ease-in-out; }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ===== CHIPS/BADGES DARI INDEX ===== */
    .cat-badge, .unit-badge {
        display: inline-flex; align-items: center; padding: 0.25rem 0.7rem;
        border-radius: 999px; font-size: 0.78rem; font-weight: 600;
    }
    .cat-tablet { background: #dbeafe; color: #1d4ed8; }
    .cat-kapsul { background: #fce7f3; color: #be185d; }
    .cat-sirup { background: #d1fae5; color: #065f46; }
    .cat-salep { background: #fef3c7; color: #92400e; }
    .cat-injeksi { background: #ede9fe; color: #6d28d9; }
    .cat-default { background: #f3f4f6; color: #4b5563; }
    .unit-badge { background: #f0fdfa; color: #0f766e; border: 1px solid #99f6e4; }
    .code-chip {
        display: inline-block; background: #f8fafc; border: 1px solid #e2e8f0;
        border-radius: 0.4rem; padding: 0.15rem 0.55rem; font-family: 'Courier New', monospace;
        font-size: 0.78rem; color: #475569; font-weight: 600; letter-spacing: 0.03em;
    }
    
    /* ===== ED BADGES ===== */
    .ed-safe { background: #dcfce7; color: #166534; padding: 0.25rem 0.6rem; border-radius: 0.4rem; font-size: 0.75rem; font-weight: 700; }
    .ed-warn { background: #fef9c3; color: #854d0e; padding: 0.25rem 0.6rem; border-radius: 0.4rem; font-size: 0.75rem; font-weight: 700; }
    .ed-danger { background: #fee2e2; color: #991b1b; padding: 0.25rem 0.6rem; border-radius: 0.4rem; font-size: 0.75rem; font-weight: 700; }
    
    /* ===== EMPTY STATE ===== */
    .empty-state { text-align: center; padding: 3rem 1rem; color: #9ca3af; }
    .empty-state svg { margin-bottom: 1rem; opacity: 0.4; }
    .empty-state p { margin: 0; font-size: 0.95rem; }
    
    /* DATATABLES */
    table.dataTable thead th { border-bottom: 2px solid var(--border-color) !important; background: #f8fafc; }
    table.dataTable tbody tr:hover > td { background: #f0fdfa !important; }

</style>
@endsection

@section('content')

@php
    $minStok = $obat->minimum_stock ?? 10;
    if ($totalStock == 0) {
        $stockClass = 'danger';
    } elseif ($totalStock <= $minStok) {
        $stockClass = 'warn';
    } else {
        $stockClass = 'safe';
    }
    
    $catName = strtolower(optional($obat->kategori)->category_name ?? '');
    $catClass = 'cat-default';
    if (str_contains($catName, 'tablet'))   $catClass = 'cat-tablet';
    elseif (str_contains($catName, 'kapsul')) $catClass = 'cat-kapsul';
    elseif (str_contains($catName, 'sirup'))  $catClass = 'cat-sirup';
    elseif (str_contains($catName, 'salep'))  $catClass = 'cat-salep';
    elseif (str_contains($catName, 'injeksi') || str_contains($catName, 'suntik')) $catClass = 'cat-injeksi';
@endphp

<a href="{{ route('stok-obat.index') }}" class="btn-back">
    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    Kembali ke Daftar Stok
</a>

<div class="summary-card">
    <div class="summary-header">
        <div>
            <h2 class="med-title">{{ $obat->medicine_name }}</h2>
            <div class="med-meta">
                <span class="code-chip">{{ $obat->medicine_code }}</span>
                @if(optional($obat->kategori)->category_name)
                    <span class="cat-badge {{ $catClass }}">{{ $obat->kategori->category_name }}</span>
                @endif
                @if(optional($obat->satuan)->unit_name)
                    <span class="unit-badge">{{ $obat->satuan->unit_name }}</span>
                @endif
            </div>
        </div>
        <div class="stock-highlight">
            <div class="stock-highlight-val {{ $stockClass }}">{{ number_format($totalStock, 0, ',', '.') }}</div>
            <div class="stock-highlight-lbl">Total Stok</div>
        </div>
    </div>
    
    <div class="info-grid">
        <div class="info-item">
            <span class="info-lbl">Batas Minimum Stok</span>
            <span class="info-val">{{ number_format($minStok, 0, ',', '.') }} {{ optional($obat->satuan)->unit_name }}</span>
        </div>
        <div class="info-item">
            <span class="info-lbl">Harga Beli Rata-rata</span>
            <span class="info-val" style="color:#0369a1;">Rp {{ number_format($obat->purchase_price, 0, ',', '.') }}</span>
        </div>
        <div class="info-item">
            <span class="info-lbl">Harga Jual Reguler</span>
            <span class="info-val" style="color:#15803d;">Rp {{ number_format($obat->selling_price, 0, ',', '.') }}</span>
        </div>
        <div class="info-item">
            <span class="info-lbl">Status Referensi</span>
            <span class="info-val">
                @if($obat->is_active)
                    <span style="color:#16a34a;display:inline-flex;align-items:center;gap:0.3rem;"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Aktif</span>
                @else
                    <span style="color:#dc2626;display:inline-flex;align-items:center;gap:0.3rem;"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Non-aktif</span>
                @endif
            </span>
        </div>
    </div>
</div>

<div class="tab-container">
    <div class="tab-header">
        <button class="tab-btn active" onclick="switchTab(event, 'tab-batch')">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            Rincian Batch & Kedaluwarsa
        </button>
        <button class="tab-btn" onclick="switchTab(event, 'tab-history')">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Riwayat Pengadaan Masuk
        </button>
    </div>
    
    <!-- TAB 1: BATCHES -->
    <div id="tab-batch" class="tab-content active">
        <table class="datatable" style="border:none;border-radius:0;">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">No. Batch</th>
                    <th width="25%">Tanggal Kadaluarsa (ED)</th>
                    <th width="20%">Status ED</th>
                    <th width="15%" style="text-align:right;">Sisa Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse($obat->medicineStocks as $index => $stock)
                @php
                    $batch = $stock->batch;
                    $ed = $batch ? \Carbon\Carbon::parse($batch->expired_date) : null;
                    $now = \Carbon\Carbon::now();
                    
                    $edStatus = 'ed-safe';
                    $edText = 'Aman';
                    
                    if($ed) {
                        $monthsToEd = $now->diffInMonths($ed, false);
                        if($monthsToEd < 0) {
                            $edStatus = 'ed-danger';
                            $edText = 'Kadaluarsa';
                        } elseif ($monthsToEd <= 3) {
                            $edStatus = 'ed-warn';
                            $edText = 'Hampir Kadaluarsa';
                        }
                    }
                @endphp
                <tr>
                    <td style="color:#9ca3af;font-size:0.85rem;font-weight:600;">{{ $index + 1 }}</td>
                    <td>
                        <span class="code-chip">{{ $batch->batch_number ?? 'Tanpa Batch' }}</span>
                    </td>
                    <td>
                        {{ $ed ? $ed->translatedFormat('d F Y') : '-' }}
                    </td>
                    <td>
                        @if($ed)
                            <span class="{{ $edStatus }}">{{ $edText }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td style="text-align:right;font-weight:700;">
                        {{ number_format($stock->stock_qty, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <svg width="48" height="48" fill="none" stroke="#9ca3af" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <p>Tidak ada rincian batch tersedia.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- TAB 2: PURCHASE HISTORY -->
    <div id="tab-history" class="tab-content">
        <table class="datatable" style="border:none;border-radius:0;">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Tanggal Masuk</th>
                    <th width="25%">No. Faktur (Pembelian)</th>
                    <th width="25%">Supplier</th>
                    <th width="15%" style="text-align:right;">Kuantitas Masuk</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchaseHistory as $index => $history)
                @php
                    $pembelian = $history->pembelian;
                @endphp
                <tr>
                    <td style="color:#9ca3af;font-size:0.85rem;font-weight:600;">{{ $index + 1 }}</td>
                    <td>
                        {{ $pembelian ? \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->translatedFormat('d F Y') : '-' }}
                    </td>
                    <td>
                        <span class="code-chip" style="background:#f0fdf4; border-color:#bbf7d0; color:#166534;">
                            {{ $pembelian->no_faktur ?? '-' }}
                        </span>
                    </td>
                    <td>
                        {{ optional($pembelian->supplier)->nama_supplier ?? '-' }}
                    </td>
                    <td style="text-align:right;font-weight:700;color:#0d9488;">
                        +{{ number_format($history->jumlah, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <svg width="48" height="48" fill="none" stroke="#9ca3af" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p>Belum ada riwayat pengadaan untuk obat ini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection

@push('scripts')
<script>
    function switchTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
            tabcontent[i].classList.remove("active");
        }
        tablinks = document.getElementsByClassName("tab-btn");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        document.getElementById(tabName).classList.add("active");
        evt.currentTarget.className += " active";
        
        // Handle datatables responsive resize bug on hidden tabs
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    }
</script>
@endpush
