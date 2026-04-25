@extends('layouts.app')

@section('title', 'Return Pembelian - Apotekku')
@section('page_title', 'Riwayat Return Pembelian')

@section('styles')
<style>
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
    }

    .page-header-banner::before {
        content: ''; position: absolute; top: -50px; right: -50px;
        width: 250px; height: 250px; background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .header-content h2 { 
        font-weight: 800; margin: 0 0 0.4rem 0 !important; letter-spacing: -0.025em; 
        color: #ffffff !important; font-size: 1.75rem !important; display: flex; align-items: center; gap: 0.75rem; 
    }

    .header-content p { color: #99f6e4 !important; font-size: 0.95rem !important; margin: 0 !important; font-weight: 500; }

    .btn-create-p {
        background: rgba(255,255,255,0.1) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2) !important;
        color: #fff !important;
        padding: 0.8rem 1.5rem !important;
        border-radius: 0.75rem !important;
        font-weight: 700 !important;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-create-p:hover { background: rgba(255,255,255,0.2) !important; transform: translateY(-2px); color: white; }

    .stats-container { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2rem; }
    .stat-card { background: white; padding: 1.5rem; border-radius: 1.25rem; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 1rem; }
    .stat-icon { width: 48px; height: 48px; border-radius: 1rem; display: flex; align-items: center; justify-content: center; }
    .stat-icon.blue { background: #f1f5f9; color: #475569; }
    .stat-icon.green { background: #ecfdf5; color: #047857; }
    .stat-icon.emerald-solid { background: #059669; color: white; }
    
    .stat-info h4 { margin: 0; color: #64748b; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; }
    .stat-info p { margin: 0; color: #1e293b; font-size: 1.25rem; font-weight: 800; }
    .stat-info p span { font-size: 0.85rem; font-weight: 400; color: #94a3b8; }

    .table-container { background: white; border-radius: 1.25rem; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .action-group { display: flex; justify-content: center; gap: 0.5rem; }
    .btn-action { width: 32px; height: 32px; border-radius: 0.5rem; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s; border: 1px solid #e2e8f0; background: white; color: #64748b; }
    .btn-view:hover { background: #f0fdf4; color: #16a34a; border-color: #16a34a; }
    .btn-print:hover { background: #f8fafc; color: #0f172a; border-color: #0f172a; }

    .text-link { font-weight: 700; color: #059669; text-decoration: none; }
    .text-link:hover { text-decoration: underline; }
    
    .petugas-info { display: flex; align-items: center; gap: 0.5rem; }
    .mini-avatar { width: 28px; height: 28px; border-radius: 50%; background: #ecfdf5; color: #047857; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.75rem; border: 1px solid #10b981; }
    
    .time-badge { font-size: 0.65rem; background: #f1f5f9; color: #64748b; padding: 0.15rem 0.45rem; border-radius: 4px; display: inline-block; margin-top: 0.25rem; }
</style>
@endsection

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.75rem"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
@endif

<div class="page-header-banner">
    <div class="header-content">
        <h2>
            <svg width="30" height="30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/></svg>
            Riwayat Return Pembelian
        </h2>
        <p>Kelola pengembalian barang ke supplier dengan akurat dan cepat.</p>
    </div>
    <div class="page-header-right">
        <a href="{{ route('return-pembelian.create') }}" class="btn-create-p">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Buat Return Baru
        </a>
    </div>
</div>

<div class="stats-container">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
        </div>
        <div class="stat-info">
            <h4>Total Return</h4>
            <p>{{ number_format($stats['total_count']) }} <span>Transaksi</span></p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <div class="stat-info">
            <h4>Nilai Return (Total)</h4>
            <p>Rp {{ number_format($stats['total_value'], 0, ',', '.') }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon emerald-solid">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
        </div>
        <div class="stat-info">
            <h4>Transaksi Bulan Ini</h4>
            <p>{{ number_format($stats['this_month_count']) }} <span>Transaksi</span></p>
        </div>
    </div>
</div>

<div class="table-container">
    <div class="table-responsive">
        <table class="datatable">
            <thead>
                <tr>
                    <th class="ps-4">No. Return</th>
                    <th>Tanggal</th>
                    <th>Faktur Asal / Supplier</th>
                    <th>Petugas</th>
                    <th class="text-end">Total Nilai</th>
                    <th class="text-center" width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($returns as $ret)
                <tr>
                    <td class="ps-4">
                        <span class="fw-bold text-slate-800 d-block">{{ $ret->no_return }}</span>
                        <span class="time-badge">{{ $ret->created_at->diffForHumans() }}</span>
                    </td>
                    <td>
                        <div class="fw-semibold text-slate-700">{{ \Carbon\Carbon::parse($ret->tanggal_return)->format('d M Y') }}</div>
                        <div class="small text-slate-400 font-mono">{{ \Carbon\Carbon::parse($ret->tanggal_return)->format('H:i') }}</div>
                    </td>
                    <td>
                        <a href="{{ route('pembelian.show', $ret->pembelian_id) }}" class="text-link">
                            {{ $ret->pembelian->no_faktur }}
                        </a>
                        <div class="small text-slate-500 mt-1"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:inline; margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg> {{ $ret->pembelian->supplier->supplier_name }}</div>
                    </td>
                    <td>
                        <div class="petugas-info">
                            <div class="mini-avatar">{{ substr($ret->user->name ?? 'U', 0, 1) }}</div>
                            <span>{{ $ret->user->name ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="text-end fw-bold text-emerald-700">Rp {{ number_format($ret->total_return, 0, ',', '.') }}</td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('return-pembelian.show', $ret->id) }}" class="btn-action btn-view" title="Lihat Detail">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <button class="btn-action btn-print" title="Cetak">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="text-slate-400 mb-3">
                            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mx-auto"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </div>
                        <h5 class="fw-bold text-slate-600">Belum Ada Transaksi Return</h5>
                        <p class="text-slate-500 mb-4">Semua pengembalian barang akan muncul di sini.</p>
                        <a href="{{ route('return-pembelian.create') }}" class="btn btn-success">Mulai Buat Return</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
