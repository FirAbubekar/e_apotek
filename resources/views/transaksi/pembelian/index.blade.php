@extends('layouts.app')

@section('title', 'Transaksi Pembelian - Apotekku')
@section('page_title', 'Transaksi Pembelian')

@section('styles')
<style>
    /* Header Banner Premium (Deep Emerald) - Copied from Supplier Style */
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
        font-weight: 800; margin: 0 0 0.4rem 0 !important; letter-spacing: -0.025em; 
        color: #ffffff !important; font-size: 1.75rem !important; display: flex; align-items: center; gap: 0.75rem; 
        position: relative; z-index: 1;
    }

    .header-content p { 
        color: #99f6e4 !important; font-size: 0.95rem !important; margin: 0 !important; font-weight: 500;
        position: relative; z-index: 1;
    }

    .btn-add-new {
        background: rgba(255,255,255,0.1) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2) !important;
        color: #fff !important;
        padding: 0.8rem 1.5rem !important;
        border-radius: 0.75rem !important;
        font-weight: 700 !important;
        position: relative; z-index: 1;
        transition: all 0.3s;
        display: inline-flex; align-items: center; gap: 0.5rem;
        text-decoration: none;
    }

    .btn-add-new:hover { background: rgba(255,255,255,0.2) !important; transform: translateY(-2px); color: white; }

    /* MINI STATS - Copied Colors from Supplier */
    .mini-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:1.1rem; margin-bottom:1.75rem; }
    .mini-stat { background:#fff; border-radius:1rem; padding:1.2rem 1.5rem; display:flex; align-items:center; gap:1rem; border:1px solid #e2e8f0; box-shadow:0 2px 12px rgba(0,0,0,.04); transition:transform .2s,box-shadow .2s; }
    .mini-stat:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,.08); }
    .mini-stat-icon { width:48px; height:48px; border-radius:.85rem; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    
    .mini-stat-icon.amber  { background:linear-gradient(135deg,#fef3c7,#fffbeb); color:#d97706; }
    .mini-stat-icon.red    { background:linear-gradient(135deg,#fee2e2,#fff5f5); color:#dc2626; }
    .mini-stat-icon.pink   { background:linear-gradient(135deg,#fce7f3,#fdf2f8); color:#be185d; }
    
    .mini-stat-lbl { font-size:.75rem; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; margin:0 0 .2rem; }
    .mini-stat-val { font-size:1.5rem; font-weight:800; color:#1e293b; margin:0; line-height:1.1; }

    /* TABLE CARD - Aligned with Supplier */
    .table-card { background:#fff; border-radius:1.25rem; border:1px solid #e2e8f0; box-shadow:0 4px 20px rgba(0,0,0,.04); overflow:hidden; }
    .table-card-header { padding:1.25rem 1.75rem; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; gap:.75rem; background:linear-gradient(to right,#fff,#fffbeb); }
    .table-card-header .icon-box { width:38px; height:38px; background:linear-gradient(135deg,#fef3c7,#fffbeb); border-radius:.65rem; display:flex; align-items:center; justify-content:center; color:#d97706; }
    .table-card-header h3 { margin:0; font-size:1.05rem; font-weight:700; color:#1e293b; }
    
    /* FAKE BADGES - Consistent with Supplier Style */
    .faktur-chip { display:inline-block; background:#f8fafc; border:1px solid #e2e8f0; border-radius:.4rem; padding:.15rem .6rem; font-family:monospace; font-size:.82rem; color:#475569; font-weight:700; }
    .supplier-chip { display:inline-flex; align-items:center; gap:.3rem; background:#fff7ed; border:1px solid #fed7aa; border-radius:.4rem; padding:.15rem .6rem; font-size:.8rem; color:#c2410c; font-weight:600; }
    .total-chip { font-weight:800; color:#b45309; font-size:.95rem; }

    /* ACTION BUTTONS */
    .action-group { display:flex; gap:.45rem; justify-content:center; }
    .btn-view, .btn-del { display:inline-flex; align-items:center; gap:.3rem; padding:.38rem .8rem; border-radius:.5rem; font-size:.78rem; font-weight:700; cursor:pointer; border:none; transition:all .2s; }
    .btn-view { background:linear-gradient(135deg,#fef3c7,#fde68a); color:#92400e; border:1px solid #fcd34d; text-decoration:none; }
    .btn-view:hover { background:linear-gradient(135deg,#f59e0b,#d97706); color:#fff; border-color:#d97706; transform:translateY(-1px); box-shadow:0 4px 10px rgba(245,158,11,.3); }
    .btn-del { background:linear-gradient(135deg,#fee2e2,#fecaca); color:#991b1b; border:1px solid #fca5a5; }
    .btn-del:hover { background:linear-gradient(135deg,#ef4444,#dc2626); color:#fff; border-color:#dc2626; transform:translateY(-1px); box-shadow:0 4px 10px rgba(239,68,68,.3); }

    .empty-state { text-align:center; padding:4rem 2rem; color:#9ca3af; }
    table.dataTable tbody tr:hover > td { background:#fffbeb !important; }
</style>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success" style="margin-bottom:1.5rem;">
        <svg style="margin-right:.75rem;flex-shrink:0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
@endif

<div class="page-header-banner">
    <div class="header-content">
        <h2>
            <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            Transaksi Pembelian
        </h2>
        <p>Kelola semua transaksi pembelian obat dari supplier dengan mudah dan cepat.</p>
    </div>
    <div class="page-header-right">
        <a href="{{ route('pembelian.create') }}" class="btn-add-new">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Pembelian
        </a>
    </div>
</div>

<div class="mini-stats">
    <div class="mini-stat">
        <div class="mini-stat-icon amber">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Total Transaksi</p>
            <p class="mini-stat-val">{{ $totalPembelian }}</p>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon red">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Bulan Ini</p>
            <p class="mini-stat-val">{{ $bulanIni }}</p>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon pink">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Total Nilai</p>
            <p class="mini-stat-val" style="font-size:1.2rem;">Rp {{ number_format($totalNilai,0,',','.') }}</p>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="table-card-header">
        <div class="icon-box">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
        </div>
        <h3>Daftar Transaksi Pembelian</h3>
        <span style="margin-left:auto;background:#fff7ed;border:1px solid #fed7aa;color:#c2410c;font-size:.78rem;font-weight:700;padding:.25rem .75rem;border-radius:999px;">{{ $totalPembelian }} Transaksi</span>
    </div>
    <div class="table-card-body">
        <table class="datatable" style="border:none;border-radius:0;">
            <thead>
                <tr>
                    <th width="4%">No</th>
                    <th width="16%">No. Faktur</th>
                    <th width="18%">Supplier</th>
                    <th width="14%">Tgl. Pembelian</th>
                    <th width="14%">Dibuat Oleh</th>
                    <th width="14%" style="text-align:right;">Total</th>
                    <th width="10%" style="text-align:center;">Item</th>
                    <th width="10%" style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembelians as $index => $p)
                <tr>
                    <td style="color:#9ca3af;font-size:.85rem;font-weight:600;">{{ $index+1 }}</td>
                    <td><span class="faktur-chip">{{ $p->no_faktur }}</span></td>
                    <td>
                        <span class="supplier-chip">
                            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                            {{ optional($p->supplier)->supplier_name ?? '—' }}
                        </span>
                    </td>
                    <td>
                        <span style="font-size:.85rem; color:#374151; font-weight:600;">{{ \Carbon\Carbon::parse($p->tanggal_pembelian)->format('d/m/Y') }}</span>
                    </td>
                    <td>
                        <span style="font-size:.82rem; color:#6b7280;">{{ optional($p->user)->name ?? '—' }}</span>
                    </td>
                    <td style="text-align:right;">
                        <span class="total-chip">Rp {{ number_format($p->total_harga,0,',','.') }}</span>
                    </td>
                    <td style="text-align:center;">
                        <span style="background:#fff7ed;border:1px solid #fed7aa;color:#b45309;font-size:.78rem;font-weight:700;padding:.15rem .55rem;border-radius:999px;">
                            {{ $p->detailPembelian->count() }} item
                        </span>
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('pembelian.show', $p->id) }}" class="btn-view">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </a>
                            <form action="{{ route('pembelian.destroy', $p->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-del">
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
                            <svg width="64" height="64" fill="none" stroke="#d1d5db" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <p>Belum ada transaksi pembelian.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
