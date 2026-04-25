@extends('layouts.app')

@section('title', 'Penjualan - Apotekku')
@section('page_title', 'Riwayat Penjualan')

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

    .btn-create-p:hover { background: rgba(255,255,255,0.2) !important; transform: translateY(-2px); }

    .stats-container { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2rem; }
    .stat-card { background: white; padding: 1.5rem; border-radius: 1.25rem; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 1rem; }
    .stat-icon { width: 48px; height: 48px; border-radius: 1rem; display: flex; align-items: center; justify-content: center; }
    .stat-icon.blue { background: #e0f2fe; color: #0369a1; }
    .stat-icon.green { background: #dcfce7; color: #15803d; }
    .stat-icon.purple { background: #f3e8ff; color: #7e22ce; }
    .stat-info h4 { margin: 0; color: #64748b; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .stat-info p { margin: 0; color: #1e293b; font-size: 1.25rem; font-weight: 800; }

    .table-container { background: white; border-radius: 1.25rem; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .btn-action { width: 32px; height: 32px; border-radius: 0.5rem; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s; }
    .btn-view { background: #f0fdf4; color: #16a34a; }
    .btn-view:hover { background: #16a34a; color: white; }
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
            <svg width="30" height="30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            Riwayat Penjualan
        </h2>
        <p>Lihat dan kelola seluruh transaksi penjualan retail apotek.</p>
    </div>
    <div class="page-header-right">
        <a href="{{ route('penjualan.create') }}" class="btn-create-p">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Transaksi Baru (POS)
        </a>
    </div>
</div>

<div class="stats-container">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <div class="stat-info">
            <h4>Total Transaksi</h4>
            <p>{{ number_format($totalPenjualan) }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="stat-info">
            <h4>Total Penjualan</h4>
            <p>Rp {{ number_format($totalNilai, 0, ',', '.') }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div class="stat-info">
            <h4>Transaksi Hari Ini</h4>
            <p>{{ number_format($hariIni) }}</p>
        </div>
    </div>
</div>

<div class="table-container">
    <div class="table-responsive">
        <table class="datatable">
            <thead>
                <tr>
                    <th>Tgl. Transaksi</th>
                    <th>No. Transaksi</th>
                    <th>Customer</th>
                    <th>Total Harga</th>
                    <th>Kasir</th>
                    <th width="80">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penjualans as $p)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_penjualan)->format('d/m/Y') }}</td>
                    <td><strong>{{ $p->no_transaksi }}</strong></td>
                    <td>{{ $p->pelanggan->nama ?? 'Umum' }}</td>
                    <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $p->user->name ?? '-' }}</td>
                    <td class="text-center">
                        <a href="{{ route('penjualan.show', $p->id) }}" class="btn-action btn-view" title="Detail">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
