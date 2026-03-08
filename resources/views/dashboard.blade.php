@extends('layouts.app')

@section('title', 'Dashboard - Apotekku')
@section('page_title', 'Dashboard Overview')

@section('styles')
<style>
    /* ================================
       HERO BANNER
    ================================ */
    .hero-banner {
        background: linear-gradient(135deg, #0d9488 0%, #0891b2 100%);
        border-radius: 1.5rem;
        padding: 2.2rem 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(13, 148, 136, 0.3);
    }
    .hero-banner::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 280px;
        height: 280px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }
    .hero-banner::after {
        content: '';
        position: absolute;
        bottom: -80px;
        right: 120px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }
    .hero-content {
        position: relative;
        z-index: 1;
    }
    .hero-greeting {
        font-size: 0.9rem;
        color: rgba(255,255,255,0.75);
        font-weight: 500;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        margin: 0 0 0.4rem 0;
    }
    .hero-name {
        font-size: 2rem;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 0.5rem 0;
        line-height: 1.2;
    }
    .hero-sub {
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
    }
    .hero-date {
        position: absolute;
        right: 2.5rem;
        top: 50%;
        transform: translateY(-50%);
        text-align: right;
        z-index: 1;
    }
    .hero-date .date-day {
        font-size: 3.5rem;
        font-weight: 900;
        color: rgba(255, 255, 255, 0.2);
        line-height: 1;
    }
    .hero-date .date-info {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.7);
    }

    /* ================================
       STAT CARDS
    ================================ */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background-color: var(--card-bg);
        border-radius: 1.25rem;
        padding: 1.5rem 1.75rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        display: flex;
        align-items: center;
        gap: 1.25rem;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        border: 1px solid var(--border-color);
        cursor: default;
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        border-radius: 1.25rem 1.25rem 0 0;
        transition: opacity 0.25s;
        opacity: 0;
    }
    .stat-card.blue::before  { background: linear-gradient(90deg, #60a5fa, #3b82f6); }
    .stat-card.green::before  { background: linear-gradient(90deg, #34d399, #10b981); }
    .stat-card.orange::before { background: linear-gradient(90deg, #fbbf24, #f59e0b); }
    .stat-card.red::before    { background: linear-gradient(90deg, #f87171, #ef4444); }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.1);
    }
    .stat-card:hover::before { opacity: 1; }

    .stat-icon-wrap {
        width: 60px;
        height: 60px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
    }
    .stat-card.blue  .stat-icon-wrap { background: linear-gradient(135deg, #dbeafe, #eff6ff); color: #2563eb; }
    .stat-card.green .stat-icon-wrap { background: linear-gradient(135deg, #d1fae5, #f0fdf4); color: #059669; }
    .stat-card.orange .stat-icon-wrap { background: linear-gradient(135deg, #fef3c7, #fffbeb); color: #d97706; }
    .stat-card.red .stat-icon-wrap { background: linear-gradient(135deg, #fee2e2, #fff5f5); color: #dc2626; }

    .stat-body { flex: 1; }
    .stat-label {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #9ca3af;
        margin: 0 0 0.3rem 0;
    }
    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-color);
        margin: 0;
        line-height: 1;
    }
    .stat-sub {
        font-size: 0.8rem;
        color: #10b981;
        margin-top: 0.3rem;
        font-weight: 600;
    }
    .stat-sub.warning { color: #f59e0b; }
    .stat-sub.danger  { color: #ef4444; }

    /* ================================
       ALERT TABLES
    ================================ */
    .alerts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(420px, 1fr));
        gap: 1.5rem;
    }
    .alert-card {
        background: var(--card-bg);
        border-radius: 1.25rem;
        border: 1px solid var(--border-color);
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }
    .alert-card-header {
        padding: 1.2rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border-bottom: 1px solid var(--border-color);
    }
    .alert-card-header.orange-header { background: linear-gradient(135deg, #fffbeb, #fef3c7); }
    .alert-card-header.red-header    { background: linear-gradient(135deg, #fff5f5, #fee2e2); }
    .alert-card-header .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .alert-card-header.orange-header .icon-circle { background: #f59e0b; }
    .alert-card-header.red-header    .icon-circle { background: #ef4444; }
    .alert-card-header h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
    }
    .alert-card-header.orange-header h3 { color: #92400e; }
    .alert-card-header.red-header    h3 { color: #991b1b; }
    .alert-count-badge {
        margin-left: auto;
        padding: 0.2rem 0.65rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
    }
    .orange-header .alert-count-badge { background: #f59e0b; color: white; }
    .red-header    .alert-count-badge { background: #ef4444; color: white; }

    .alert-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.88rem;
    }
    .alert-table thead th {
        padding: 0.65rem 1.25rem;
        text-align: left;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #9ca3af;
        background: #fafafa;
        border-bottom: 1px solid var(--border-color);
    }
    .alert-table thead th:not(:first-child) { text-align: right; }
    .alert-table tbody tr {
        transition: background 0.2s;
    }
    .alert-table tbody tr:hover { background: #f9fafb; }
    .alert-table tbody td {
        padding: 0.85rem 1.25rem;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-color);
        vertical-align: middle;
    }
    .alert-table tbody td:not(:first-child) { text-align: right; }
    .alert-table tbody tr:last-child td { border-bottom: none; }
    .alert-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 2.5rem 1rem;
        color: #9ca3af;
    }
    .alert-empty svg { opacity: 0.4; }
    .alert-empty p { margin: 0; font-size: 0.9rem; }

    /* Stock level pill */
    .stock-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.6rem;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 700;
    }
    .stock-pill.critical { background: #fee2e2; color: #b91c1c; }
    .stock-pill.warning  { background: #fef3c7; color: #92400e; }
    .expiry-pill {
        display: inline-block;
        padding: 0.2rem 0.65rem;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 700;
        border: 1.5px solid;
    }
    .expiry-pill.expired   { color: #991b1b; border-color: #fca5a5; background: #fef2f2; }
    .expiry-pill.near      { color: #b45309; border-color: #fde68a; background: #fffbeb; }

    /* Progress bar for stock */
    .progress-bar-wrap {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .progress-bar {
        flex: 1;
        height: 6px;
        background: #f3f4f6;
        border-radius: 999px;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        border-radius: 999px;
        transition: width 0.5s ease;
    }
</style>
@endsection

@section('content')

{{-- ====== HERO BANNER ====== --}}
<div class="hero-banner" style="padding-bottom:20px; color:black">
    <div class="hero-content">
        <p class="hero-greeting" style="color:#0c0c0c">Panel Kontrol Apotek</p>
        <h1 class="hero-name" style="color:#0c0c0c">Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}! 👋</h1>
        <p class="hero-sub" style="color:#0c0c0c">Pantau stok, transaksi, dan peringatan penting apotek Anda di sini secara real-time.</p>
    </div>
    <div class="hero-date">
        <div class="date-day">{{ date('d') }}</div>
        <div class="date-info">{{ date('l, F Y') }}</div>
    </div>
</div>

{{-- ====== STAT CARDS ====== --}}
<div class="stats-grid">
    {{-- Total Obat --}}
    <div class="stat-card blue">
        <div class="stat-icon-wrap">
            <svg width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
        </div>
        <div class="stat-body">
            <p class="stat-label">Total Obat</p>
            <p class="stat-value">{{ number_format($stats['total_medicines']) }}</p>
            <p class="stat-sub">Jenis Obat Terdaftar</p>
        </div>
    </div>

    {{-- Transaksi --}}
    <div class="stat-card green">
        <div class="stat-icon-wrap">
            <svg width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <div class="stat-body">
            <p class="stat-label">Transaksi Hari Ini</p>
            <p class="stat-value">{{ number_format($stats['transactions_today']) }}</p>
            <p class="stat-sub">Penjualan Terhitung</p>
        </div>
    </div>

    {{-- Pendapatan --}}
    <div class="stat-card orange">
        <div class="stat-icon-wrap">
            <svg width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="stat-body">
            <p class="stat-label">Pendapatan Hari Ini</p>
            <p class="stat-value" style="font-size:1.5rem;">Rp {{ number_format($stats['revenue_today'], 0, ',', '.') }}</p>
            <p class="stat-sub">Total Penjualan Kasir</p>
        </div>
    </div>

    {{-- Stok Kritis --}}
    <div class="stat-card red">
        <div class="stat-icon-wrap">
            <svg width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <div class="stat-body">
            <p class="stat-label">Stok Menipis</p>
            <p class="stat-value">{{ number_format($stats['low_stock_count']) }}</p>
            @if($stats['low_stock_count'] > 0)
                <p class="stat-sub danger">⚠ Perlu Segera Diisi</p>
            @else
                <p class="stat-sub">✓ Semua Aman</p>
            @endif
        </div>
    </div>
</div>

{{-- ====== ALERT TABLES ====== --}}
<div class="alerts-grid">

    {{-- LOW STOCK ALERT --}}
    <div class="alert-card">
        <div class="alert-card-header orange-header">
            <div class="icon-circle">
                <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3>⚠ Peringatan Stok Menipis</h3>
            <span class="alert-count-badge">{{ $lowStocks->count() }} Obat</span>
        </div>
        @if($lowStocks->isEmpty())
            <div class="alert-empty">
                <svg width="48" height="48" fill="none" stroke="#9ca3af" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p>Semua stok obat masih aman.</p>
            </div>
        @else
            <table class="alert-table">
                <thead>
                    <tr>
                        <th>Nama Obat</th>
                        <th>Level Stok</th>
                        <th>Fisik / Min.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStocks as $obat)
                    @php
                        $pct = $obat->minimum_stock > 0 ? min(100, ($obat->current_stock / $obat->minimum_stock) * 100) : 0;
                        $pillClass = $obat->current_stock == 0 ? 'critical' : 'warning';
                        $fillColor = $obat->current_stock == 0 ? '#ef4444' : '#f59e0b';
                    @endphp
                    <tr>
                        <td>
                            <div style="font-weight: 600; color: var(--text-color);">{{ $obat->medicine_name }}</div>
                        </td>
                        <td>
                            <div class="progress-bar-wrap">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $pct }}%; background: {{ $fillColor }};"></div>
                                </div>
                                <span style="font-size: 0.75rem; color: #9ca3af; width: 35px; text-align: right;">{{ round($pct) }}%</span>
                            </div>
                        </td>
                        <td>
                            <span class="stock-pill {{ $pillClass }}">{{ $obat->current_stock }} / {{ $obat->minimum_stock }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- EXPIRING SOON ALERT --}}
    <div class="alert-card">
        <div class="alert-card-header red-header">
            <div class="icon-circle">
                <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3>🕐 Obat Hampir Kedaluwarsa</h3>
            <span class="alert-count-badge">{{ $expiringBatches->count() }} Batch</span>
        </div>
        @if($expiringBatches->isEmpty())
            <div class="alert-empty">
                <svg width="48" height="48" fill="none" stroke="#9ca3af" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p>Semua Batch obat aman (&gt; 3 bulan).</p>
            </div>
        @else
            <table class="alert-table">
                <thead>
                    <tr>
                        <th>Keterangan Batch</th>
                        <th>Tgl. Kedaluwarsa</th>
                        <th>Sisa Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expiringBatches as $batch)
                    @php
                        $isExpired = \Carbon\Carbon::parse($batch->expired_date)->isPast();
                        $pillClass = $isExpired ? 'expired' : 'near';
                        $dateLabel = $isExpired ? '🔴 KADALUWARSA' : \Carbon\Carbon::parse($batch->expired_date)->format('d M Y');
                    @endphp
                    <tr>
                        <td>
                            <div style="font-weight: 600;">{{ $batch->medicine_name }}</div>
                            <div style="font-size: 0.78rem; color: #9ca3af;">{{ $batch->batch_number }}</div>
                        </td>
                        <td>
                            <span class="expiry-pill {{ $pillClass }}">{{ $dateLabel }}</span>
                        </td>
                        <td>
                            <span style="font-weight: 700;">{{ $batch->current_stock }}</span>
                            <span style="font-size: 0.75rem; color: #9ca3af; margin-left: 2px;">pcs</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>

@endsection
