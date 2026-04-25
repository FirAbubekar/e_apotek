@extends('layouts.app')

@section('title', 'Mutasi Stok - Apotekku')
@section('page_title', 'Stok > Mutasi Stok')

@section('styles')
<style>
    /* ===== MODERN DESIGN SYSTEM ===== */
    :root {
        --primary-solid: #0d9488;
        --primary-deep: #064e4b;
        --primary-gradient: linear-gradient(135deg, #064e4b, #042f2e);
        --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
    }

    /* Breadcrumb Capsule Style */
    .page-title {
        font-size: 0.95rem !important;
        font-weight: 500 !important;
        color: #64748b !important;
        background: #f8fafc;
        padding: 0.5rem 1rem;
        border-radius: 99px;
        border: 1px solid #e2e8f0;
        display: inline-block;
    }

    /* Header Banner Premium (Deep Emerald) */
    .page-header-banner {
        background-color: #064e4b !important;
        background-image: var(--primary-gradient) !important;
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

    .header-content h2 { 
        font-weight: 800; 
        margin-bottom: 0.4rem; 
        letter-spacing: -0.025em; 
        color: #ffffff !important;
        font-size: 1.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .header-content p { color: #99f6e4 !important; font-size: 0.95rem; margin-bottom: 0; font-weight: 500; }

    /* FILTER BAR */
    .filter-card {
        background: white;
        border-radius: 1.25rem;
        padding: 1.25rem 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .filter-item { display: flex; align-items: center; gap: 0.75rem; }
    .filter-item label { font-weight: 700; color: #475569; font-size: 0.85rem; text-transform: uppercase; }

    .modern-select, .modern-input {
        padding: 0.6rem 1rem;
        border-radius: 0.75rem;
        border: 1.5px solid #e2e8f0;
        font-size: 0.9rem;
        color: #1e293b;
        background: #f8fafc;
        outline: none;
        transition: all 0.2s;
    }
    .modern-select:focus, .modern-input:focus { border-color: #0d9488; background: white; box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1); }

    /* TABLE PREMIUM */
    .card-modern {
        background: white; border-radius: 1.5rem; border: 1px solid #f1f5f9;
        box-shadow: var(--card-shadow); overflow: hidden; margin-bottom: 2rem;
    }

    .table-modern { width: 100%; border-collapse: separate; border-spacing: 0; }
    .table-modern th { 
        background: #f8fafc; padding: 1.25rem 1rem; 
        font-weight: 700; color: #475569; text-transform: uppercase; 
        font-size: 0.75rem; border-bottom: 2px solid #f1f5f9;
    }
    .table-modern td { padding: 1.25rem 1rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; font-size: 0.9rem; }
    
    .status-badge {
        padding: 0.35rem 0.75rem; border-radius: 99px; font-weight: 800; font-size: 0.75rem;
        display: inline-flex; align-items: center; gap: 0.4rem;
    }
    .badge-in { background: #ecfdf5; color: #065f46; border: 1px solid #d1fae5; }
    .badge-out { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
    .badge-alt { background: #eff6ff; color: #1e40af; border: 1px solid #dbeafe; }

    .qty-box {
        display: flex; flex-direction: column; line-height: 1.2;
    }
    .qty-main { font-weight: 800; font-size: 1.05rem; }
    .qty-sub { font-size: 0.75rem; color: #94a3b8; font-weight: 600; }

    .ref-pill {
        background: #f1f5f9; color: #475569; padding: 0.3rem 0.6rem;
        border-radius: 0.5rem; font-size: 0.8rem; font-weight: 700;
        border: 1px solid #e2e8f0;
    }

    .medicine-info { display: flex; flex-direction: column; }
    .medicine-name { font-weight: 800; color: #1e293b; }
    .batch-tag { font-family: 'Courier New', monospace; font-size: 0.75rem; color: #64748b; font-weight: 700; }

    .pagination-wrapper { padding: 1.5rem; border-top: 1px solid #f1f5f9; background: #f8fafc; }
</style>
@endsection

@section('content')

{{-- HEADER BANNER --}}
<div class="page-header-banner">
    <div class="header-content">
        <h2>
            <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            Mutasi Stok Obat
        </h2>
        <p>Pantau riwayat pergerakan stok, penyesuaian opname, dan histori audit barang.</p>
    </div>
</div>

{{-- FILTER BAR --}}
<form action="{{ route('mutasi-stok.index') }}" method="GET" class="filter-card">
    <div class="filter-item">
        <label>Tipe Mutasi</label>
        <select name="type" class="modern-select" onchange="this.form.submit()">
            <option value="">Semua Tipe</option>
            <option value="Masuk" {{ request('type') == 'Masuk' ? 'selected' : '' }}>Stok Masuk</option>
            <option value="Keluar" {{ request('type') == 'Keluar' ? 'selected' : '' }}>Stok Keluar</option>
            <option value="Opname" {{ request('type') == 'Opname' ? 'selected' : '' }}>Stok Opname</option>
            <option value="Penyesuaian" {{ request('type') == 'Penyesuaian' ? 'selected' : '' }}>Penyesuaian</option>
        </select>
    </div>
    
    <div class="filter-item" style="flex-grow: 1;">
        <label>Pencarian</label>
        <input type="text" name="search" class="modern-input w-100" placeholder="Cari Nama Obat atau Referensi..." value="{{ request('search') }}">
    </div>

    <button type="submit" class="btn btn-primary" style="padding: 0.65rem 1.5rem; border-radius: 0.75rem;">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        Filter
    </button>
</form>

{{-- DATA TABLE CARD --}}
<div class="card-modern">
    <table class="table-modern w-100">
        <thead>
            <tr>
                <th width="5%" class="text-center">#</th>
                <th width="15%">Waktu & Tanggal</th>
                <th width="30%">Informasi Obat</th>
                <th width="10%" class="text-center">Tipe</th>
                <th width="10%" class="text-center">Perubahan</th>
                <th width="10%" class="text-center">Sisa Stok</th>
                <th width="20%">Referensi / Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mutations as $index => $mutation)
                <tr>
                    <td class="text-center" style="color: #94a3b8; font-weight: 700;">{{ ($mutations->currentPage() - 1) * $mutations->perPage() + $index + 1 }}</td>
                    <td>
                        <div style="font-weight: 700; color: #1e293b;">{{ $mutation->created_at->format('d M Y') }}</div>
                        <div style="font-size: 0.75rem; color: #64748b; font-family: monospace;">{{ $mutation->created_at->format('H:i:s') }}</div>
                    </td>
                    <td>
                        <div class="medicine-info">
                            <span class="medicine-name">{{ $mutation->medicineStock->obat->medicine_name ?? 'N/A' }}</span>
                            <span class="batch-tag">Batch: {{ $mutation->medicineStock->batch->batch_number ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="text-center">
                        @php
                            $badgeClass = match($mutation->type) {
                                'Masuk' => 'badge-in',
                                'Keluar' => 'badge-out',
                                default => 'badge-alt'
                            };
                            $icon = match($mutation->type) {
                                'Masuk' => '↓',
                                'Keluar' => '↑',
                                default => '±'
                            };
                        @endphp
                        <span class="status-badge {{ $badgeClass }}">
                            {{ $icon }} {{ $mutation->type }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="qty-box">
                            <span class="qty-main {{ $mutation->qty_change > 0 ? 'text-success' : 'text-danger' }}">
                                {{ $mutation->qty_change > 0 ? '+' : '' }}{{ $mutation->qty_change }}
                            </span>
                            <span class="qty-sub">Awal: {{ $mutation->qty_before }}</span>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="qty-box">
                            <span class="qty-main" style="color: #0d9488;">{{ $mutation->qty_after }}</span>
                            <span class="qty-sub">Unit</span>
                        </div>
                    </td>
                    <td>
                        <div class="ref-pill mb-1 d-inline-block">{{ $mutation->reference ?: '-' }}</div>
                        <div style="font-size: 0.75rem; color: #64748b; max-width: 200px; white-space: normal;">{{ $mutation->notes }}</div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 4rem 1rem;">
                        <svg width="48" height="48" fill="none" stroke="#e2e8f0" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p class="mt-3 text-secondary" style="font-weight: 600;">Belum ada riwayat mutasi stok.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($mutations->hasPages())
        <div class="pagination-wrapper">
            {{ $mutations->links() }}
        </div>
    @endif
</div>

@endsection
