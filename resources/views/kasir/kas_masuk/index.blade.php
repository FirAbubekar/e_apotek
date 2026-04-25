@extends('layouts.app')

@section('content')
<div class="kas-container">
    <!-- Header Section -->
    <div class="kas-header-premium">
        <div class="header-left">
            <h1 class="page-title">Kas Masuk</h1>
            <p class="page-subtitle">Kelola dan pantau semua aliran kas masuk apotek secara real-time</p>
        </div>
        <div class="header-right">
            <a href="{{ route('kas-masuk.create') }}" class="btn-emerald-premium">
                <i class="fas fa-plus-circle"></i> Catat Kas Masuk
            </a>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-grid-premium">
        <div class="stat-card-premium">
            <div class="stat-icon-wrapper bg-emerald-50 text-emerald-600">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Total Kas Masuk</span>
                <div class="stat-value-group">
                    <span class="stat-currency">Rp</span>
                    <span class="stat-number">{{ number_format($totalMasuk, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="stat-card-premium">
            <div class="stat-icon-wrapper bg-blue-50 text-blue-600">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Masuk Bulan Ini</span>
                <div class="stat-value-group">
                    <span class="stat-currency">Rp</span>
                    <span class="stat-number">{{ number_format($masukBulanIni, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts Section -->
    @if(session('success'))
    <div class="alert alert-emerald mb-4 animate__animated animate__fadeIn">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
    @endif

    <!-- Data Table Card -->
    <div class="content-card-premium">
        <div class="card-header-premium">
            <div class="header-inner">
                <h5 class="card-title-premium">Riwayat Transaksi Kas Masuk</h5>
                <span class="badge-count-premium">{{ $transactions->total() }} Transaksi</span>
            </div>
        </div>
        
        <div class="card-body-premium">
            <div class="table-responsive-premium">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th width="180" class="ps-4">No. Transaksi</th>
                            <th width="160">Tanggal & Waktu</th>
                            <th width="150">Kategori</th>
                            <th>Keterangan</th>
                            <th width="180" class="text-end">Jumlah</th>
                            <th width="150">Oleh</th>
                            <th width="80" class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                        <tr>
                            <td class="ps-4">
                                <span class="trx-number">{{ $trx->no_transaksi }}</span>
                            </td>
                            <td>
                                <div class="date-text">{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d/m/Y') }}</div>
                                <div class="time-text">{{ \Carbon\Carbon::parse($trx->transaction_date)->format('H:i') }}</div>
                            </td>
                            <td>
                                <span class="badge-category">{{ $trx->category }}</span>
                            </td>
                            <td>
                                <span class="description-text">{{ $trx->description ?? '-' }}</span>
                            </td>
                            <td class="text-end">
                                <span class="amount-text-premium text-emerald-600">Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <div class="user-pill">
                                    <div class="user-avatar-tiny">{{ substr($trx->user->name ?? 'U', 0, 1) }}</div>
                                    <span class="user-name-tiny">{{ $trx->user->name ?? 'User' }}</span>
                                </div>
                            </td>
                            <td class="text-center pe-4">
                                <button class="btn-action-view" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-container">
                                    <div class="empty-icon-wrapper">
                                        <i class="fas fa-receipt"></i>
                                    </div>
                                    <h5 class="empty-title">Belum ada data kas masuk</h5>
                                    <p class="empty-subtitle">Silakan catat kas masuk pertama Anda untuk memulai pelacakan keuangan.</p>
                                    <a href="{{ route('kas-masuk.create') }}" class="btn-emerald-sm">
                                        Catat Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($transactions->hasPages())
        <div class="card-footer-pagination">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --primary-emerald: #059669;
        --light-emerald: #ecfdf5;
        --dark-emerald: #047857;
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --slate-400: #94a3b8;
        --slate-500: #64748b;
        --slate-600: #475569;
        --slate-700: #334155;
        --slate-800: #1e293b;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    }

    .kas-container {
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding: 2rem 1rem;
        max-width: 95%;
        margin: 0 auto;
    }

    /* Header Styling */
    .kas-header-premium {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    .page-title {
        font-size: 1.875rem;
        font-weight: 800;
        color: var(--slate-800);
        margin: 0;
        letter-spacing: -0.025em;
    }
    .page-subtitle {
        color: var(--slate-500);
        margin-top: 0.25rem;
        font-size: 0.95rem;
    }

    /* Button Styling */
    .btn-emerald-premium {
        background: var(--primary-emerald);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }
    .btn-emerald-premium:hover {
        background: var(--dark-emerald);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(5, 150, 105, 0.3);
        color: white;
    }

    /* Stats Grid */
    .stats-grid-premium {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .stat-card-premium {
        background: white;
        padding: 1.5rem;
        border-radius: 1.25rem;
        border: 1px solid var(--slate-200);
        display: flex;
        align-items: center;
        gap: 1.25rem;
        box-shadow: var(--shadow-sm);
        transition: transform 0.2s;
    }
    .stat-card-premium:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    .stat-icon-wrapper {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .stat-content {
        display: flex;
        flex-direction: column;
    }
    .stat-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--slate-400);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .stat-value-group {
        display: flex;
        align-items: baseline;
        gap: 0.25rem;
        margin-top: 0.125rem;
    }
    .stat-currency {
        font-size: 1rem;
        font-weight: 700;
        color: var(--slate-800);
    }
    .stat-number {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--slate-800);
    }

    /* Table Card */
    .content-card-premium {
        background: white;
        border-radius: 1.25rem;
        border: 1px solid var(--slate-200);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }
    .card-header-premium {
        padding: 1.5rem;
        background: var(--slate-50);
        border-bottom: 1px solid var(--slate-100);
    }
    .header-inner {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-title-premium {
        font-weight: 800;
        color: var(--slate-800);
        margin: 0;
        font-size: 1.1rem;
    }
    .badge-count-premium {
        background: var(--slate-200);
        color: var(--slate-600);
        padding: 0.375rem 0.875rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 700;
    }

    /* Table Styling */
    .table-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .table-modern th {
        padding: 1rem;
        background: white;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--slate-500);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid var(--slate-100);
    }
    .table-modern td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--slate-50);
    }
    .table-modern tr:hover td {
        background: var(--slate-50);
    }

    .trx-number { font-weight: 700; color: var(--slate-800); }
    .date-text { font-size: 0.9rem; font-weight: 600; color: var(--slate-700); }
    .time-text { font-size: 0.75rem; color: var(--slate-400); }
    
    .badge-category {
        background: var(--slate-100);
        color: var(--slate-600);
        padding: 0.25rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 700;
        white-space: nowrap;
    }
    
    .description-text { font-size: 0.9rem; color: var(--slate-600); }
    .amount-text-premium { font-size: 1.05rem; font-weight: 800; }
    
    .user-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--slate-50);
        padding: 0.25rem 0.75rem 0.25rem 0.25rem;
        border-radius: 2rem;
        border: 1px solid var(--slate-100);
    }
    .user-avatar-tiny {
        width: 1.5rem;
        height: 1.5rem;
        background: var(--primary-emerald);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 800;
    }
    .user-name-tiny { font-size: 0.8rem; font-weight: 600; color: var(--slate-700); }

    .btn-action-view {
        background: white;
        border: 1px solid var(--slate-200);
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 0.625rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--slate-400);
        transition: all 0.2s;
        cursor: pointer;
    }
    .btn-action-view:hover {
        color: var(--primary-emerald);
        border-color: var(--primary-emerald);
        background: var(--light-emerald);
    }

    /* Empty State Styling */
    .empty-container {
        padding: 4rem 1rem;
        color: var(--slate-400);
    }
    .empty-icon-wrapper {
        font-size: 4rem;
        color: var(--slate-200);
        margin-bottom: 1.5rem;
    }
    .empty-title {
        font-weight: 800;
        color: var(--slate-700);
        margin-bottom: 0.5rem;
    }
    .empty-subtitle {
        font-size: 0.95rem;
        max-width: 400px;
        margin: 0 auto 1.5rem;
    }
    .btn-emerald-sm {
        background: var(--primary-emerald);
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 0.5rem;
        font-weight: 700;
        text-decoration: none;
        font-size: 0.875rem;
        display: inline-block;
        transition: all 0.2s;
    }
    .btn-emerald-sm:hover {
        background: var(--dark-emerald);
        color: white; transform: scale(1.05);
    }

    /* Misc */
    .alert-emerald {
        background: var(--light-emerald);
        border: 1px solid #a7f3d0;
        color: #065f46;
        border-radius: 0.75rem;
        padding: 1rem;
    }

    @media (max-width: 768px) {
        .kas-header-premium {
            flex-direction: column;
            align-items: flex-start;
            gap: 1.25rem;
        }
        .header-right {
            width: 100%;
        }
        .btn-emerald-premium {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection
