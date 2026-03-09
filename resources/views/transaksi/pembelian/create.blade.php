@extends('layouts.app')

@section('title', 'Buat Pembelian - Apotekku')
@section('page_title', 'Buat Transaksi Pembelian')

@section('styles')
<style>
    /* ===== BASE ===== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .po-page { font-family: 'Inter', sans-serif; }
    .po-page *, .po-page *::before, .po-page *::after { box-sizing: border-box; }

    /* ===== PAGE HEADER BAR ===== */
    .po-topbar {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.5rem;
    }
    .back-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        background: #fff; border: 1.5px solid #e2e8f0;
        color: #374151; padding: .5rem 1.1rem;
        border-radius: .7rem; font-size: .84rem; font-weight: 600;
        text-decoration: none; transition: all .2s;
        box-shadow: 0 1px 4px rgba(0,0,0,.06);
    }
    .back-btn:hover { background: #f8fafc; border-color: #94a3b8; color: #111827; }

    .po-title-group { }
    .po-title { font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0 0 .15rem; }
    .po-subtitle { font-size: .8rem; color: #64748b; margin: 0; }

    /* ===== POS GRID ===== */
    .pos-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 1.5rem;
        align-items: start;
    }
    @media (max-width: 1100px) { .pos-grid { grid-template-columns: 1fr; } }

    /* ===== LEFT PANEL (Info + Obat) ===== */

    /* INFO CARD */
    .info-card {
        background: #fff; border-radius: 1rem;
        border: 1.5px solid #e2e8f0;
        box-shadow: 0 2px 12px rgba(0,0,0,.04);
        margin-bottom: 1.25rem; overflow: hidden;
    }
    .info-card-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #0d9488 100%);
        padding: .9rem 1.4rem;
        display: flex; align-items: center; gap: .75rem;
    }
    .info-card-header .h-icon {
        width: 32px; height: 32px; border-radius: .5rem;
        background: rgba(255,255,255,.15);
        display: flex; align-items: center; justify-content: center;
        color: #fff; flex-shrink: 0;
    }
    .info-card-header h3 {
        margin: 0; font-size: .95rem; font-weight: 700; color: #fff;
    }
    .faktur-badge {
        margin-left: auto;
        background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
        color: #a7f3d0; font-size: .78rem; font-weight: 700;
        padding: .2rem .7rem; border-radius: 999px; font-family: monospace;
        letter-spacing: .02em;
    }
    .info-card-body { padding: 1.6rem 1.8rem; }

    /* FORM FIELDS */
    .field-grid { display: grid; grid-template-columns: 49% 49%; gap: 1rem; margin-bottom: 1.2rem; }
    .field { display: flex; flex-direction: column; gap: .35rem; }
    .field label {
        font-size: .78rem; font-weight: 700; color: #374151;
        display: flex; align-items: center; gap: .3rem; text-transform: uppercase; letter-spacing: .04em;
    }
    .field label svg { color: #0d9488; }
    .field-req { color: #ef4444; }
    .field input, .field select {
        width: 100%; padding: .65rem 1rem;
        border: 1.5px solid #e2e8f0; border-radius: .65rem;
        font-size: .88rem; color: #0f172a;
        background: #fff; transition: border-color .2s, box-shadow .2s;
        font-family: inherit; box-sizing: border-box;
    }
    .field input:focus, .field select:focus {
        outline: none; border-color: #0d9488;
        box-shadow: 0 0 0 3px rgba(13,148,136,.12);
    }
    .field input[readonly] {
        background: #f8fafc; color: #0f766e;
        font-family: 'Courier New', monospace; font-weight: 700;
        border-color: #d1fae5; font-size: .85rem;
    }

    /* ===== OBAT PANEL ===== */
    .obat-card {
        background: #fff; border-radius: 1rem;
        border: 1.5px solid #e2e8f0;
        box-shadow: 0 2px 12px rgba(0,0,0,.04);
        overflow: hidden;
    }
    .obat-card-header {
        padding: 1rem 1.8rem;
        border-bottom: 1.5px solid #f1f5f9;
        display: flex; align-items: center; gap: .7rem;
        background: #fafbfc;
    }
    .obat-card-header .h-icon {
        width: 30px; height: 30px; border-radius: .45rem;
        background: linear-gradient(135deg, #dbeafe, #eff6ff);
        display: flex; align-items: center; justify-content: center;
        color: #2563eb; flex-shrink: 0;
    }
    .obat-card-header h3 { margin: 0; font-size: .92rem; font-weight: 700; color: #0f172a; }
    .obat-count-badge {
        margin-left: auto;
        background: #eff6ff; border: 1px solid #bfdbfe;
        color: #1d4ed8; font-size: .72rem; font-weight: 700;
        padding: .15rem .65rem; border-radius: 999px;
    }
    .obat-card-body { padding: 1.2rem 1.8rem 1.6rem; }

    /* SEARCH */
    .search-wrap { position: relative; margin-bottom: .85rem; }
    .search-wrap svg { position: absolute; left: .8rem; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; }
    .search-wrap input {
        width: 100%; padding: .65rem 1rem .65rem 2.5rem;
        border: 1.5px solid #e2e8f0; border-radius: .75rem;
        font-size: .87rem; color: #0f172a; font-family: inherit;
        transition: border-color .2s, box-shadow .2s;
        background: #f8fafc;
    }
    .search-wrap input::placeholder { color: #94a3b8; }
    .search-wrap input:focus {
        outline: none; border-color: #0d9488; background: #fff;
        box-shadow: 0 0 0 3px rgba(13,148,136,.12);
    }

    /* OBAT LIST */
    .obat-list {
        border: 1.5px solid #e2e8f0; border-radius: .85rem;
        overflow: hidden; max-height: 360px; overflow-y: auto;
    }
    .obat-list::-webkit-scrollbar { width: 4px; }
    .obat-list::-webkit-scrollbar-track { background: #f8fafc; }
    .obat-list::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }

    .obat-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: .75rem 1.2rem; border-bottom: 1px solid #f1f5f9;
        transition: background .15s;
    }
    .obat-row:last-child { border-bottom: none; }
    .obat-row:hover { background: #f0fdfa; }
    .obat-row.hidden { display: none; }

    .obat-info { flex: 1; min-width: 0; }
    .obat-name { font-weight: 700; font-size: .86rem; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .obat-meta { display: flex; align-items: center; gap: .4rem; margin-top: .18rem; }
    .obat-code {
        background: #f0fdfa; border: 1px solid #99f6e4;
        border-radius: .3rem; padding: .05rem .4rem;
        font-size: .68rem; color: #0f766e; font-weight: 700; font-family: monospace;
    }
    .obat-unit { font-size: .72rem; color: #94a3b8; }

    .obat-right { display: flex; align-items: center; gap: .75rem; flex-shrink: 0; margin-left: .75rem; }
    .obat-price { font-weight: 700; color: #0f766e; font-size: .86rem; min-width: 80px; text-align: right; }

    .btn-add {
        display: inline-flex; align-items: center; justify-content: center;
        width: 28px; height: 28px;
        background: linear-gradient(135deg, #0d9488, #10b981);
        color: #fff; border-radius: 50%; border: none;
        cursor: pointer; font-size: 1.2rem; line-height: 1;
        transition: all .2s; flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(13,148,136,.3);
    }
    .btn-add:hover { transform: scale(1.15); box-shadow: 0 4px 14px rgba(13,148,136,.45); }
    .btn-add:active { transform: scale(.95); }

    /* ===== CART PANEL (RIGHT) ===== */
    .cart-card {
        background: #fff; border-radius: 1rem;
        border: 1.5px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0,0,0,.07);
        position: sticky; top: 1rem; overflow: hidden;
    }
    .cart-header {
        padding: 1rem 1.6rem;
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #0d9488 100%);
        display: flex; align-items: center; justify-content: space-between;
    }
    .cart-header-left { display: flex; align-items: center; gap: .6rem; }
    .cart-header-left svg { color: rgba(255,255,255,.8); }
    .cart-header h3 { margin: 0; font-size: .95rem; font-weight: 800; color: #fff; }
    .cart-badge {
        background: rgba(255,255,255,.2); color: #fff;
        font-size: .72rem; font-weight: 700; padding: .1rem .55rem;
        border-radius: 999px; border: 1px solid rgba(255,255,255,.25);
    }
    .btn-clear {
        background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2);
        color: rgba(255,255,255,.9); padding: .3rem .7rem;
        border-radius: .5rem; font-size: .75rem; font-weight: 600;
        cursor: pointer; transition: background .2s;
    }
    .btn-clear:hover { background: rgba(255,255,255,.22); }

    /* CART BODY */
    .cart-body { max-height: 360px; overflow-y: auto; }
    .cart-body::-webkit-scrollbar { width: 4px; }
    .cart-body::-webkit-scrollbar-track { background: #f8fafc; }
    .cart-body::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }

    .cart-empty {
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; padding: 3rem 1.5rem; color: #94a3b8;
    }
    .cart-empty svg { opacity: .35; margin-bottom: .6rem; }
    .cart-empty p { margin: 0; font-size: .84rem; text-align: center; line-height: 1.5; }

    .cart-item {
        padding: .9rem 1.5rem; border-bottom: 1px solid #f1f5f9;
        animation: slideIn .18s ease;
    }
    @keyframes slideIn { from { opacity:0; transform: translateY(-6px); } to { opacity:1; transform: none; } }
    .cart-item:last-child { border-bottom: none; }

    .cart-item-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: .45rem; }
    .cart-item-name { font-weight: 700; font-size: .86rem; color: #0f172a; }
    .cart-item-unit { font-size: .72rem; color: #94a3b8; font-weight: 400; margin-left: .3rem; }
    .btn-remove {
        background: none; border: none; color: #dc2626; cursor: pointer;
        padding: .2rem; border-radius: .4rem; display: flex; align-items: center;
        transition: background .15s; flex-shrink: 0; margin-left: .5rem;
    }
    .btn-remove:hover { background: #fee2e2; }

    .cart-item-controls { display: flex; align-items: center; gap: .45rem; }
    .inp-qty {
        width: 54px; text-align: center; padding: .32rem .3rem;
        border: 1.5px solid #e2e8f0; border-radius: .5rem;
        font-size: .84rem; font-weight: 700; color: #0f172a; font-family: inherit;
    }
    .inp-qty:focus { outline: none; border-color: #0d9488; }
    .inp-sep { font-size: .78rem; color: #94a3b8; }
    .inp-price {
        flex: 1; padding: .32rem .55rem;
        border: 1.5px solid #e2e8f0; border-radius: .5rem;
        font-size: .8rem; color: #0f172a; font-family: inherit;
    }
    .inp-price:focus { outline: none; border-color: #0d9488; }
    .cart-item-sub { font-size: .77rem; font-weight: 700; color: #0f766e; margin-top: .35rem; text-align: right; }

    /* BATCH ROW */
    .batch-row { display: grid; grid-template-columns: 1fr 140px; gap: .4rem; margin-top: .45rem; }
    .batch-label { font-size: .7rem; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: .04em; margin-bottom: .2rem; }
    .inp-batch, .inp-expired {
        width: 100%; padding: .3rem .55rem;
        border: 1.5px solid #e2e8f0; border-radius: .5rem;
        font-size: .78rem; color: #0f172a; font-family: inherit;
        box-sizing: border-box;
    }
    .inp-batch:focus, .inp-expired:focus { outline: none; border-color: #0d9488; }
    .autogen-row { display: flex; align-items: center; gap: .3rem; margin-bottom: .25rem; }
    .autogen-row input[type=checkbox] { width: 13px; height: 13px; accent-color: #0d9488; cursor: pointer; }
    .autogen-row label { font-size: .7rem; color: #0d9488; font-weight: 600; cursor: pointer; }

    /* CART FOOTER */
    .cart-footer { padding: 1.1rem 1.5rem; border-top: 1.5px solid #f1f5f9; background: #fafbfc; }
    .total-line { display: flex; justify-content: space-between; align-items: center; margin-bottom: .3rem; }
    .total-line .tl { font-size: .82rem; color: #6b7280; font-weight: 600; }
    .total-line .tv { font-size: .82rem; font-weight: 700; color: #0f172a; }
    .grand-line {
        display: flex; justify-content: space-between; align-items: center;
        padding-top: .7rem; margin-top: .4rem;
        border-top: 2px dashed #e2e8f0;
    }
    .grand-line .gl { font-size: .92rem; font-weight: 800; color: #0f172a; }
    .grand-line .gv { font-size: 1.2rem; font-weight: 800; color: #0f766e; }

    .btn-submit {
        display: flex; align-items: center; justify-content: center; gap: .5rem;
        width: 100%; margin-top: 1rem; padding: .85rem 1.5rem;
        background: linear-gradient(135deg, #0d9488, #10b981);
        border: none; border-radius: .8rem; color: #fff;
        font-size: .95rem; font-weight: 800; cursor: pointer;
        transition: all .2s; font-family: inherit;
        box-shadow: 0 4px 16px rgba(13,148,136,.35);
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(13,148,136,.45); }
    .btn-submit:active { transform: translateY(0); }
    .btn-submit:disabled {
        background: #e2e8f0; color: #94a3b8; cursor: not-allowed;
        box-shadow: none; transform: none;
    }

    /* PREVIEW BUTTON */
    .btn-preview {
        display: flex; align-items: center; justify-content: center; gap: .45rem;
        width: 100%; margin-top: .65rem; padding: .6rem 1rem;
        background: #fff; border: 1.5px solid #0d9488;
        color: #0d9488; border-radius: .75rem;
        font-size: .84rem; font-weight: 700; cursor: pointer;
        transition: all .2s; font-family: inherit;
    }
    .btn-preview:hover { background: #f0fdfa; transform: translateY(-1px); }
    .btn-preview:disabled { border-color: #e2e8f0; color: #94a3b8; cursor: not-allowed; transform: none; background: #fff; }

    /* PREVIEW MODAL */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(15,23,42,.55); backdrop-filter: blur(4px);
        z-index: 9999; align-items: center; justify-content: center;
        padding: 1rem;
    }
    .modal-overlay.open { display: flex; }
    .modal-box {
        background: #fff; border-radius: 1.25rem;
        box-shadow: 0 24px 64px rgba(0,0,0,.2);
        width: 100%; max-width: 560px;
        max-height: 90vh; overflow: hidden;
        display: flex; flex-direction: column;
        animation: modalIn .22s ease;
    }
    @keyframes modalIn { from { opacity:0; transform: scale(.94) translateY(12px); } to { opacity:1; transform: none; } }
    .modal-head {
        padding: 1.1rem 1.5rem;
        background: linear-gradient(135deg, #0f172a, #1e3a5f 60%, #0d9488);
        display: flex; align-items: center; justify-content: space-between;
    }
    .modal-head h4 { margin: 0; font-size: 1rem; font-weight: 800; color: #fff; display: flex; align-items: center; gap: .5rem; }
    .modal-close {
        background: rgba(255,255,255,.15); border: none; color: #fff;
        width: 28px; height: 28px; border-radius: 50%; cursor: pointer;
        font-size: 1.1rem; display: flex; align-items: center; justify-content: center;
        transition: background .2s;
    }
    .modal-close:hover { background: rgba(255,255,255,.3); }
    .modal-body { padding: 1.3rem 1.5rem; overflow-y: auto; flex: 1; }
    .preview-meta { background: #f8fafc; border-radius: .75rem; padding: .85rem 1rem; margin-bottom: 1rem; font-size: .82rem; color: #374151; }
    .preview-meta span { font-weight: 700; color: #0f172a; }
    .preview-table { width: 100%; border-collapse: collapse; font-size: .82rem; }
    .preview-table th { background: #f1f5f9; color: #374151; font-weight: 700; padding: .55rem .75rem; text-align: left; font-size: .76rem; text-transform: uppercase; letter-spacing: .04em; }
    .preview-table th:last-child, .preview-table td:last-child { text-align: right; }
    .preview-table td { padding: .6rem .75rem; border-bottom: 1px solid #f1f5f9; color: #0f172a; }
    .preview-table tr:last-child td { border-bottom: none; }
    .preview-table tr:hover td { background: #f8fafc; }
    .preview-total {
        background: linear-gradient(135deg, #f0fdfa, #ecfdf5);
        border: 1.5px solid #a7f3d0; border-radius: .75rem;
        padding: .9rem 1rem; margin-top: 1rem;
        display: flex; justify-content: space-between; align-items: center;
    }
    .preview-total .pt-label { font-size: .88rem; font-weight: 700; color: #065f46; }
    .preview-total .pt-value { font-size: 1.15rem; font-weight: 800; color: #0f766e; }
</style>
@endsection

@section('content')
<div class="po-page">

{{-- TOP BAR --}}
<div class="po-topbar">
    <a href="{{ route('pembelian.index') }}" class="back-btn">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
    <div class="po-title-group" style="text-align:right;">
        <p class="po-title">Buat Transaksi Pembelian</p>
        <p class="po-subtitle">{{ date('l, d F Y') }}</p>
    </div>
</div>

<form id="posForm" action="{{ route('pembelian.store') }}" method="POST">
@csrf
<div id="hiddenItems"></div>

<div class="pos-grid">

    {{-- ===== LEFT COLUMN ===== --}}
    <div>
        {{-- Info Card --}}
        <div class="info-card">
            <div class="info-card-header">
                <div class="h-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3>Informasi Pembelian</h3>
                <span class="faktur-badge">{{ $noFaktur }}</span>
            </div>
            <div class="info-card-body">
                <input type="hidden" name="no_faktur" value="{{ $noFaktur }}">
                <div class="field-grid">
                    <div class="field">
                        <label>
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            No. Faktur
                        </label>
                        <input type="text" value="{{ $noFaktur }}" readonly>
                    </div>
                    <div class="field">
                        <label>
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Tanggal Pembelian
                        </label>
                        <input type="date" id="tanggal_pembelian" name="tanggal_pembelian" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="field">
                    <label>
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                        Supplier <span class="field-req">*</span>
                    </label>
                    <select id="supplier_id" name="supplier_id" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $sup)
                            <option value="{{ $sup->id }}">{{ $sup->supplier_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Obat Card --}}
        <div class="obat-card">
            <div class="obat-card-header">
                <div class="h-icon">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h3>Pilih Obat</h3>
                <span class="obat-count-badge">{{ $obats->count() }} Obat</span>
            </div>
            <div class="obat-card-body">
                <div class="search-wrap">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" id="searchObat" placeholder="Cari nama atau kode obat..." oninput="filterObat(this.value)">
                </div>

                <div class="obat-list" id="obatList">
                    @forelse($obats as $obat)
                    <div class="obat-row"
                         id="obat-row-{{ $obat->id }}"
                         data-search="{{ strtolower($obat->medicine_name . ' ' . $obat->medicine_code) }}">
                        <div class="obat-info">
                            <div class="obat-name">{{ $obat->medicine_name }}</div>
                            <div class="obat-meta">
                                <span class="obat-code">{{ $obat->medicine_code }}</span>
                                @if($obat->satuan)
                                <span class="obat-unit">· {{ $obat->satuan->unit_name }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="obat-right">
                            <span class="obat-price">Rp {{ number_format($obat->purchase_price ?? 0, 0, ',', '.') }}</span>
                            <button type="button" class="btn-add"
                                onclick='addToCart({{ json_encode(["id"=>$obat->id,"name"=>$obat->medicine_name,"code"=>$obat->medicine_code,"unit"=>optional($obat->satuan)->unit_name,"price"=>$obat->purchase_price??0]) }})'
                                title="Tambah ke keranjang">+</button>
                        </div>
                    </div>
                    @empty
                    <div style="text-align:center;padding:2.5rem;color:#94a3b8;font-size:.88rem;">Tidak ada data obat.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- ===== RIGHT COLUMN: CART ===== --}}
    <div>
        <div class="cart-card">
            <div class="cart-header">
                <div class="cart-header-left">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <h3>Daftar Item</h3>
                    <span class="cart-badge" id="cartCount">0</span>
                </div>
                <button type="button" class="btn-clear" onclick="clearCart()">🗑 Kosongkan</button>
            </div>

            <div class="cart-body" id="cartBody">
                <div class="cart-empty" id="cartEmpty">
                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <p>Klik tombol <strong>+</strong> pada obat<br>untuk menambahkan ke keranjang</p>
                </div>
                <div id="cartItems"></div>
            </div>

            <div class="cart-footer">
                <div class="total-line">
                    <span class="tl">Subtotal</span>
                    <span class="tv" id="subtotalDisplay">Rp 0</span>
                </div>
                <div class="grand-line">
                    <span class="gl">Total Pembelian</span>
                    <span class="gv" id="grandTotalDisplay">Rp 0</span>
                </div>
                <button type="button" id="btnPreview" class="btn-preview" disabled onclick="showPreview()">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Preview Pesanan
                </button>
                <button type="button" id="btnSubmit" class="btn-submit" disabled onclick="submitPO()">
                    <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Simpan Transaksi Pembelian
                </button>
            </div>
        </div>
    </div>

</div>{{-- /pos-grid --}}
</form>
</div>{{-- /po-page --}}

{{-- PREVIEW MODAL --}}
<div class="modal-overlay" id="previewModal" onclick="closePreviewOnBg(event)">
    <div class="modal-box">
        <div class="modal-head">
            <h4>
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Preview Pesanan
            </h4>
            <button type="button" class="modal-close" onclick="closePreview()">✕</button>
        </div>
        <div class="modal-body" id="previewBody"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let cart = [];

function formatRp(n) {
    return 'Rp ' + Number(n).toLocaleString('id-ID');
}

function filterObat(q) {
    const t = q.toLowerCase();
    document.querySelectorAll('#obatList .obat-row').forEach(el => {
        el.classList.toggle('hidden', !el.dataset.search.includes(t));
    });
}

function addToCart(obat) {
    const ex = cart.find(c => c.id == obat.id);
    if (ex) { ex.qty++; ex.subtotal = ex.qty * ex.price; renderCart(); return; }
    cart.push({ ...obat, qty: 1, price: Number(obat.price), subtotal: Number(obat.price), batch_number: '', expired_date: '' });
    renderCart();
}

function removeFromCart(id) {
    cart = cart.filter(c => c.id != id);
    renderCart();
}

function clearCart() {
    if (!cart.length) return;
    if (confirm('Yakin ingin mengosongkan keranjang?')) { cart = []; renderCart(); }
}

function updateBatch(id, val) {
    const item = cart.find(c => c.id == id);
    if (item) item.batch_number = val;
}

function updateExpired(id, val) {
    const item = cart.find(c => c.id == id);
    if (item) item.expired_date = val;
}

function toggleAutoBatch(id, checked) {
    const item = cart.find(c => c.id == id);
    const inp  = document.getElementById('batch-' + id);
    if (!inp || !item) return;

    if (checked) {
        const faktur  = document.querySelector('input[name="no_faktur"]').value || 'PBL';
        const tanggal = (document.getElementById('tanggal_pembelian').value || new Date().toISOString().slice(0,10)).replace(/-/g,'');
        const idx     = cart.findIndex(c => c.id == id) + 1;
        const auto    = `BCH-${tanggal}-${faktur}-${String(idx).padStart(2,'0')}`;
        inp.value     = auto;
        inp.readOnly  = true;
        inp.style.background = '#f0fdfa';
        item.batch_number = auto;
    } else {
        inp.value     = '';
        inp.readOnly  = false;
        inp.style.background = '';
        item.batch_number = '';
    }
}


function updateQty(id, val) {
    const item = cart.find(c => c.id == id);
    if (!item) return;
    item.qty = Math.max(1, parseInt(val) || 1);
    item.subtotal = item.qty * item.price;
    updateTotals();
    updateSubLabel(id, item);
}

function updatePrice(id, val) {
    const item = cart.find(c => c.id == id);
    if (!item) return;
    item.price = parseFloat(String(val).replace(/[^0-9.]/g,'')) || 0;
    item.subtotal = item.qty * item.price;
    updateTotals();
    updateSubLabel(id, item);
}

function updateSubLabel(id, item) {
    const el = document.getElementById('sub-' + id);
    if (el) el.textContent = 'Subtotal: ' + formatRp(item.qty * item.price);
}

function renderCart() {
    const items = document.getElementById('cartItems');
    const empty = document.getElementById('cartEmpty');
    const count = document.getElementById('cartCount');

    if (!cart.length) {
        items.innerHTML = '';
        empty.style.display = 'flex';
        count.textContent = '0';
        document.getElementById('btnSubmit').disabled = true;
        document.getElementById('btnPreview').disabled = true;
        updateTotals();
        return;
    }

    empty.style.display = 'none';
    let html = '';
    cart.forEach(item => {
        html += `
        <div class="cart-item">
            <div class="cart-item-top">
                <div>
                    <span class="cart-item-name">${item.name}</span>
                    <span class="cart-item-unit">${item.unit || ''}</span>
                </div>
                <button type="button" class="btn-remove" onclick="removeFromCart(${item.id})" title="Hapus">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="cart-item-controls">
                <input type="number" class="inp-qty" value="${item.qty}" min="1"
                    oninput="updateQty(${item.id},this.value)" onchange="updateQty(${item.id},this.value)">
                <span class="inp-sep">×</span>
                <input type="text" class="inp-price" value="${item.price}"
                    oninput="updatePrice(${item.id},this.value)" onchange="updatePrice(${item.id},this.value)">
            </div>
            <div class="batch-row">
                <div>
                    <div class="autogen-row">
                        <input type="checkbox" id="autogen-${item.id}" onchange="toggleAutoBatch(${item.id},this.checked)">
                        <label for="autogen-${item.id}">Auto-generate batch number</label>
                    </div>
                    <div class="batch-label">Batch Number</div>
                    <input type="text" class="inp-batch" id="batch-${item.id}" placeholder="Contoh: BCH-001"
                        value="${item.batch_number}" oninput="updateBatch(${item.id},this.value)">
                </div>
                <div>
                    <div class="batch-label" style="margin-top:1.6rem">Expired Date</div>
                    <input type="date" class="inp-expired" id="expired-${item.id}"
                        value="${item.expired_date}" oninput="updateExpired(${item.id},this.value)">
                </div>
            </div>
            <div class="cart-item-sub" id="sub-${item.id}">Subtotal: ${formatRp(item.qty * item.price)}</div>
        </div>`;
    });
    items.innerHTML = html;
    count.textContent = cart.length;
    document.getElementById('btnSubmit').disabled = false;
    document.getElementById('btnPreview').disabled = false;
    updateTotals();
}

function updateTotals() {
    const total = cart.reduce((s, c) => s + c.qty * c.price, 0);
    document.getElementById('subtotalDisplay').textContent = formatRp(total);
    document.getElementById('grandTotalDisplay').textContent = formatRp(total);
}

function submitPO() {
    if (!cart.length) { alert('Keranjang masih kosong!'); return; }
    if (!document.getElementById('supplier_id').value) { alert('Silakan pilih supplier terlebih dahulu!'); return; }

    // Validasi batch number
    for (let i = 0; i < cart.length; i++) {
        const el = document.getElementById('batch-' + cart[i].id);
        if (el) cart[i].batch_number = el.value.trim();
        const ed = document.getElementById('expired-' + cart[i].id);
        if (ed) cart[i].expired_date = ed.value;
        if (!cart[i].batch_number) {
            alert('Batch number untuk "' + cart[i].name + '" wajib diisi!');
            document.getElementById('batch-' + cart[i].id)?.focus();
            return;
        }
    }

    const container = document.getElementById('hiddenItems');
    container.innerHTML = '';
    cart.forEach((item, idx) => {
        container.innerHTML += `
            <input type="hidden" name="items[${idx}][obat_id]" value="${item.id}">
            <input type="hidden" name="items[${idx}][jumlah]" value="${item.qty}">
            <input type="hidden" name="items[${idx}][harga_satuan]" value="${item.price}">
            <input type="hidden" name="items[${idx}][batch_number]" value="${item.batch_number}">
            <input type="hidden" name="items[${idx}][expired_date]" value="${item.expired_date || ''}">
        `;
    });

    document.getElementById('posForm').submit();
}

function showPreview() {
    if (!cart.length) return;
    const supplier = document.getElementById('supplier_id');
    const supplierText = supplier.options[supplier.selectedIndex]?.text || '— Belum dipilih —';
    const tanggal = document.getElementById('tanggal_pembelian').value;
    const noFaktur = document.querySelector('input[name="no_faktur"]').value;
    const total = cart.reduce((s, c) => s + c.qty * c.price, 0);

    let rows = '';
    cart.forEach((item, i) => {
        rows += `
        <tr>
            <td>${i + 1}</td>
            <td>
                <div style="font-weight:700;color:#0f172a">${item.name}</div>
                <div style="font-size:.73rem;color:#94a3b8">${item.unit || ''}</div>
            </td>
            <td style="text-align:center">${item.qty}</td>
            <td style="text-align:right">${formatRp(item.price)}</td>
            <td style="text-align:right;font-weight:700;color:#0f766e">${formatRp(item.qty * item.price)}</td>
        </tr>`;
    });

    document.getElementById('previewBody').innerHTML = `
        <div class="preview-meta">
            <div style="display:flex;gap:1.5rem;flex-wrap:wrap">
                <div>📋 No. Faktur &nbsp;<span>${noFaktur}</span></div>
                <div>📅 Tanggal &nbsp;<span>${tanggal}</span></div>
                <div>🏭 Supplier &nbsp;<span>${supplierText}</span></div>
            </div>
        </div>
        <table class="preview-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Obat</th>
                    <th style="text-align:center">Qty</th>
                    <th style="text-align:right">Harga</th>
                    <th style="text-align:right">Subtotal</th>
                </tr>
            </thead>
            <tbody>${rows}</tbody>
        </table>
        <div class="preview-total">
            <span class="pt-label">Total Pembelian</span>
            <span class="pt-value">${formatRp(total)}</span>
        </div>`;

    document.getElementById('previewModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closePreview() {
    document.getElementById('previewModal').classList.remove('open');
    document.body.style.overflow = '';
}

function closePreviewOnBg(e) {
    if (e.target === document.getElementById('previewModal')) closePreview();
}
</script>
@endpush
