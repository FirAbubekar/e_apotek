@extends('layouts.app')

@section('title', 'Obat - Apotekku')
@section('page_title', 'Master Data Obat')

@section('styles')
<style>
    /* ===== PAGE HEADER ===== */
    /* Header Banner Premium (Deep Emerald) */
    .page-header-banner {
        background-color: #064e4b !important;
        background-image: linear-gradient(135deg, #064e4b, #042f2e) !important;
        border-radius: 1.5rem;
        padding: 2.5rem 2rem;
        color: white;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 20px 25px -5px rgba(6, 78, 75, 0.2);
        position: relative;
        overflow: hidden;
        border: none !important;
    }

    .page-header-banner::before {
        content: ''; position: absolute; top: -50px; right: -50px;
        width: 250px; height: 250px; background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .page-header-banner::after {
        content: ''; position: absolute; bottom: -70px; right: 150px;
        width: 180px; height: 180px; background: rgba(255,255,255,0.03);
        border-radius: 50%;
    }

    .header-content h2 { 
        font-weight: 800; 
        margin: 0 0 0.4rem 0 !important; 
        letter-spacing: -0.025em; 
        color: #ffffff !important;
        font-size: 1.75rem !important;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        position: relative;
        z-index: 1;
    }

    .header-content p { 
        color: #99f6e4 !important; 
        font-size: 0.95rem !important; 
        margin: 0 !important; 
        font-weight: 500;
        position: relative;
        z-index: 1;
    }

    .btn-add-obat {
        background: rgba(255,255,255,0.1) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2) !important;
        color: #fff !important;
        padding: 0.8rem 1.5rem !important;
        border-radius: 0.75rem !important;
        font-weight: 700 !important;
        position: relative;
        z-index: 1;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-add-obat:hover {
        background: rgba(255,255,255,0.2) !important;
        transform: translateY(-2px);
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
    .mini-stat-icon.blue  { background: linear-gradient(135deg, #dbeafe, #eff6ff); color: #2563eb; }
    .mini-stat-icon.violet { background: linear-gradient(135deg, #ede9fe, #f5f3ff); color: #7c3aed; }
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

    /* ===== CATEGORY BADGE ===== */
    .cat-badge {
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

    /* ===== UNIT BADGE ===== */
    .unit-badge {
        display: inline-block;
        padding: 0.2rem 0.6rem;
        border-radius: 0.4rem;
        font-size: 0.78rem;
        font-weight: 600;
        background: #f0fdfa;
        color: #0f766e;
        border: 1px solid #99f6e4;
    }

    /* ===== PRICE CHIP ===== */
    .price-chip {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1f2937;
    }
    .price-chip.buy { color: #0369a1; }
    .price-chip.sell { color: #15803d; }

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

    /* ===== ACTION BUTTONS ===== */
    .action-group { display: flex; gap: 0.45rem; justify-content: center; }
    .btn-icon-edit, .btn-icon-delete {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.38rem 0.8rem;
        border-radius: 0.5rem;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
    }
    .btn-icon-edit {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
        border: 1px solid #fcd34d;
    }
    .btn-icon-edit:hover {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        border-color: #d97706;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(245,158,11,0.3);
    }
    .btn-icon-delete {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
        border: 1px solid #fca5a5;
    }
    .btn-icon-delete:hover {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        border-color: #dc2626;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(239,68,68,0.3);
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
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        color: white !important;
        border-radius: 0.5rem !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--primary-light) !important;
        color: var(--primary-hover) !important;
        border-color: var(--primary-color) !important;
        border-radius: 0.5rem !important;
    }
    table.dataTable thead th { border-bottom: 2px solid var(--border-color) !important; }
    table.dataTable tbody tr:hover > td { background: #f0fdfa !important; }

    /* Medicine name link style */
    .med-name {
        font-weight: 700;
        color: #0d9488;
        font-size: 0.95rem;
    }
</style>
@endsection

@section('content')

{{-- ===== FLASH MESSAGES ===== --}}
@if (session('success'))
    <div class="alert alert-success" style="margin-bottom:1.5rem;">
        <svg style="margin-right:0.75rem;flex-shrink:0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger" style="margin-bottom:1.5rem;">
        <svg style="margin-right:0.75rem;flex-shrink:0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.
    </div>
@endif

{{-- ===== PAGE HEADER BANNER ===== --}}
<div class="page-header-banner">
    <div class="header-content">
        <h2>
            <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            Manajemen Data Obat
        </h2>
        <p>Kelola data obat, kategori, satuan, harga beli dan harga jual dengan mudah.</p>
    </div>
    <div class="page-header-right">
        <button type="button" class="btn-add-obat" onclick="openModal('addModalObat')">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Obat
        </button>
    </div>
</div>

{{-- ===== MINI STATS ===== --}}
<div class="mini-stats">
    <div class="mini-stat">
        <div class="mini-stat-icon teal">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Total Obat</p>
            <p class="mini-stat-val">{{ $obats->count() }}</p>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon blue">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Kategori</p>
            <p class="mini-stat-val">{{ $obats->pluck('category_id')->unique()->filter()->count() }}</p>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon violet">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Jenis Satuan</p>
            <p class="mini-stat-val">{{ $obats->pluck('unit_id')->unique()->filter()->count() }}</p>
        </div>
    </div>
</div>

{{-- ===== TABLE CARD ===== --}}
<div class="table-card">
    <div class="table-card-header">
        <div class="icon-box">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <h3>Daftar Obat</h3>
        <span style="margin-left:auto;background:#f0fdfa;border:1px solid #99f6e4;color:#0f766e;font-size:0.78rem;font-weight:700;padding:0.25rem 0.75rem;border-radius:999px;">
            {{ $obats->count() }} Entri
        </span>
    </div>
    <div class="table-card-body">
        <table class="datatable" style="border:none;border-radius:0;">
            <thead>
                <tr>
                    <th width="4%">No</th>
                    <th width="11%">Kode</th>
                    <th width="22%">Nama Obat</th>
                    <th width="15%">Kategori</th>
                    <th width="9%">Satuan</th>
                    <th width="13%" style="text-align:right;">Harga Beli</th>
                    <th width="13%" style="text-align:right;">Harga Jual</th>
                    <th width="13%" style="text-align:center;">Aksi</th>
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
                    <td style="text-align:right;">
                        <span class="price-chip buy">Rp {{ number_format($o->purchase_price, 0, ',', '.') }}</span>
                    </td>
                    <td style="text-align:right;">
                        <span class="price-chip sell">Rp {{ number_format($o->selling_price, 0, ',', '.') }}</span>
                    </td>
                    <td>
                        <div class="action-group">
                            <button type="button" class="btn-icon-edit"
                                onclick="openEditObatModal({{ $o->id }}, '{{ addslashes($o->medicine_code) }}', '{{ addslashes($o->medicine_name) }}', {{ $o->category_id ?? 'null' }}, {{ $o->unit_id ?? 'null' }}, {{ $o->purchase_price }}, {{ $o->selling_price }})">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                Edit
                            </button>
                            <form action="{{ route('obat.destroy', $o->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus obat ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon-delete">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <svg width="56" height="56" fill="none" stroke="#9ca3af" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p>Belum ada data obat. Klik <strong>+ Tambah Obat</strong> untuk menambahkan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('modals')
<!-- ===== Modal Tambah Obat ===== -->
<div id="addModalObat" class="modal">
    <div class="modal-content modal-lg">
        <div class="modal-header">
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <div style="width:36px;height:36px;background:linear-gradient(135deg,#ccfbf1,#d1fae5);border-radius:0.6rem;display:flex;align-items:center;justify-content:center;color:#0d9488;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <h3 class="modal-title">Tambah Obat Baru</h3>
            </div>
            <button class="close-btn" onclick="closeModal('addModalObat')">&times;</button>
        </div>
        <form action="{{ route('obat.store') }}" method="POST">
            @csrf
            <div class="grid-2-col">
                <div class="form-group">
                    <label for="kode_obat">Kode Obat <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="kode_obat" name="kode_obat" class="form-control" value="{{ old('kode_obat') }}" required placeholder="Contoh: OBT-001">
                    @error('kode_obat') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="nama_obat">Nama Obat <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="nama_obat" name="nama_obat" class="form-control" value="{{ old('nama_obat') }}" required placeholder="Contoh: Paracetamol 500mg">
                    @error('nama_obat') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="grid-2-col">
                <div class="form-group">
                    <label for="kategori_id">Kategori <span style="color:#ef4444;">*</span></label>
                    <select id="kategori_id" name="kategori_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach(\App\Models\KategoriObat::all() as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->category_name }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="satuan_id">Satuan <span style="color:#ef4444;">*</span></label>
                    <select id="satuan_id" name="satuan_id" class="form-control" required>
                        <option value="">-- Pilih Satuan --</option>
                        @foreach(\App\Models\Satuan::all() as $s)
                            <option value="{{ $s->id }}" {{ old('satuan_id') == $s->id ? 'selected' : '' }}>{{ $s->unit_name }}</option>
                        @endforeach
                    </select>
                    @error('satuan_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="grid-2-col">
                <div class="form-group">
                    <label for="harga_beli">Harga Beli (Rp) <span style="color:#ef4444;">*</span></label>
                    <input type="number" id="harga_beli" name="harga_beli" class="form-control" value="{{ old('harga_beli') }}" required min="0">
                    @error('harga_beli') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="harga_jual">Harga Jual (Rp) <span style="color:#ef4444;">*</span></label>
                    <input type="number" id="harga_jual" name="harga_jual" class="form-control" value="{{ old('harga_jual') }}" required min="0">
                    @error('harga_jual') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addModalObat')">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Obat
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===== Modal Edit Obat ===== -->
<div id="editModalObat" class="modal">
    <div class="modal-content modal-lg">
        <div class="modal-header">
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <div style="width:36px;height:36px;background:linear-gradient(135deg,#fef3c7,#fde68a);border-radius:0.6rem;display:flex;align-items:center;justify-content:center;color:#92400e;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </div>
                <h3 class="modal-title">Edit Data Obat</h3>
            </div>
            <button class="close-btn" onclick="closeModal('editModalObat')">&times;</button>
        </div>
        <form id="editFormObat" method="POST">
            @csrf
            @method('PUT')
            <div class="grid-2-col">
                <div class="form-group">
                    <label for="edit_kode_obat">Kode Obat <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="edit_kode_obat" name="kode_obat" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit_nama_obat">Nama Obat <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="edit_nama_obat" name="nama_obat" class="form-control" required>
                </div>
            </div>
            <div class="grid-2-col">
                <div class="form-group">
                    <label for="edit_kategori_id">Kategori <span style="color:#ef4444;">*</span></label>
                    <select id="edit_kategori_id" name="kategori_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach(\App\Models\KategoriObat::all() as $k)
                            <option value="{{ $k->id }}">{{ $k->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_satuan_id">Satuan <span style="color:#ef4444;">*</span></label>
                    <select id="edit_satuan_id" name="satuan_id" class="form-control" required>
                        <option value="">-- Pilih Satuan --</option>
                        @foreach(\App\Models\Satuan::all() as $s)
                            <option value="{{ $s->id }}">{{ $s->unit_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid-2-col">
                <div class="form-group">
                    <label for="edit_harga_beli">Harga Beli (Rp) <span style="color:#ef4444;">*</span></label>
                    <input type="number" id="edit_harga_beli" name="harga_beli" class="form-control" required min="0">
                </div>
                <div class="form-group">
                    <label for="edit_harga_jual">Harga Jual (Rp) <span style="color:#ef4444;">*</span></label>
                    <input type="number" id="edit_harga_jual" name="harga_jual" class="form-control" required min="0">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editModalObat')">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    Update Obat
                </button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
    if (typeof openModal !== 'function') {
        window.openModal  = function(id) { $('#' + id).addClass('show'); }
        window.closeModal = function(id) { $('#' + id).removeClass('show'); }
        $(window).click(function(e) { if ($(e.target).hasClass('modal')) { $(e.target).removeClass('show'); } });
    }

    function openEditObatModal(id, kode, nama, kat_id, sat_id, hargabeli, hargajual) {
        let url = "{{ route('obat.update', ':id') }}".replace(':id', id);
        $('#editFormObat').attr('action', url);
        $('#edit_kode_obat').val(kode);
        $('#edit_nama_obat').val(nama);
        $('#edit_kategori_id').val(kat_id);
        $('#edit_satuan_id').val(sat_id);
        $('#edit_harga_beli').val(hargabeli);
        $('#edit_harga_jual').val(hargajual);
        openModal('editModalObat');
    }

    $(document).ready(function() {
        @if($errors->any() && !old('_method'))
            openModal('addModalObat');
        @endif
    });
</script>
@endpush
