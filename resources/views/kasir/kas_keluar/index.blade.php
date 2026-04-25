@extends('layouts.app')

@section('content')
<div class="kas-container">
    <!-- Header Section -->
    <div class="kas-header-premium">
        <div class="header-left">
            <h1 class="page-title">Kas Keluar</h1>
            <p class="page-subtitle">Kelola dan pantau semua pengeluaran operasional apotek secara transparan</p>
        </div>
        <div class="header-right">
            <a href="{{ route('kas-keluar.create') }}" class="btn-rose-premium">
                <i class="fas fa-minus-circle"></i> Catat Kas Keluar
            </a>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-grid-premium">
        <div class="stat-card-premium border-left-rose">
            <div class="stat-icon-wrapper bg-rose-50 text-rose-600">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Total Kas Keluar</span>
                <div class="stat-value-group">
                    <span class="stat-currency">Rp</span>
                    <span class="stat-number">{{ number_format($totalKeluar, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="stat-card-premium border-left-orange">
            <div class="stat-icon-wrapper bg-orange-50 text-orange-600">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Keluar Bulan Ini</span>
                <div class="stat-value-group">
                    <span class="stat-currency">Rp</span>
                    <span class="stat-number">{{ number_format($keluarBulanIni, 0, ',', '.') }}</span>
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
        <div class="card-header-premium border-bottom-rose">
            <div class="header-inner">
                <h5 class="card-title-premium text-slate-700">Audit Pengeluaran Kasir</h5>
                <span class="badge-count-premium bg-rose-100 text-rose-700">{{ $transactions->total() }} Transaksi</span>
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
                                <span class="trx-number text-rose-700">{{ $trx->no_transaksi }}</span>
                            </td>
                            <td>
                                <div class="date-text">{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d/m/Y') }}</div>
                                <div class="time-text">{{ \Carbon\Carbon::parse($trx->transaction_date)->format('H:i') }}</div>
                            </td>
                            <td>
                                <span class="badge-category-keluar">{{ $trx->category }}</span>
                            </td>
                            <td>
                                <span class="description-text">{{ $trx->description ?? '-' }}</span>
                            </td>
                            <td class="text-end">
                                <span class="amount-text-premium text-rose-600">-Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <div class="user-pill">
                                    <div class="user-avatar-tiny bg-rose-500">{{ substr($trx->user->name ?? 'U', 0, 1) }}</div>
                                    <span class="user-name-tiny">{{ $trx->user->name ?? 'User' }}</span>
                                </div>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group-action">
                                    <button class="btn-action-view-keluar" title="Detail" onclick="showDetail({{ $trx->id }})">
                                        <i class="fas fa-search-dollar"></i>
                                    </button>
                                    <a href="{{ route('kas-keluar.print', $trx->id) }}" target="_blank" class="btn-action-print-keluar" title="Cetak Bukti">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-container">
                                    <div class="empty-icon-wrapper text-slate-200">
                                        <i class="fas fa-receipt"></i>
                                    </div>
                                    <h5 class="empty-title">Belum ada data kas keluar</h5>
                                    <p class="empty-subtitle">Catat pengeluaran pertama Anda untuk menjaga integritas pembukuan.</p>
                                    <a href="{{ route('kas-keluar.create') }}" class="btn-rose-sm">
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

<!-- Transaction Detail Modal -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem;">
            <div class="modal-header border-0 pb-0 ps-4 pt-4">
                <h5 class="modal-title font-800 text-slate-800" id="detailTitle">Detail Pengeluaran</h5>
                <button type="button" class="btn-close me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="detailContent">
                <div class="loading-state text-center py-5">
                    <div class="spinner-border text-rose-500" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <a href="#" id="btnPrintDetail" target="_blank" class="btn-print-premium w-100">
                    <i class="fas fa-print me-2"></i> Cetak Kwitansi
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --primary-rose: #e11d48;
        --light-rose: #fff1f2;
        --dark-rose: #be123c;
        --primary-orange: #f97316;
        --light-orange: #fff7ed;
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --slate-400: #94a3b8;
        --slate-500: #64748b;
        --slate-600: #475569;
        --slate-700: #334155;
        --slate-800: #1e293b;
    }

    .kas-container {
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding: 2rem 1rem;
        max-width: 95%;
        margin: 0 auto;
    }

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

    .btn-rose-premium {
        background: var(--primary-rose);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(225, 29, 72, 0.25);
    }
    .btn-rose-premium:hover {
        background: var(--dark-rose);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(225, 29, 72, 0.3);
        color: white;
    }

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
        transition: transform 0.2s;
    }
    .border-left-rose { border-left: 5px solid var(--primary-rose); }
    .border-left-orange { border-left: 5px solid var(--primary-orange); }

    .stat-icon-wrapper {
        width: 3.5rem; height: 3.5rem;
        border-radius: 1rem;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem;
    }
    .bg-rose-50 { background: var(--light-rose); }
    .text-rose-600 { color: var(--primary-rose); }
    .bg-orange-50 { background: var(--light-orange); }
    .text-orange-600 { color: var(--primary-orange); }

    .stat-label { font-size: 0.75rem; font-weight: 700; color: var(--slate-400); text-transform: uppercase; letter-spacing: 0.05em; }
    .stat-value-group { display: flex; align-items: baseline; gap: 0.25rem; margin-top: 0.125rem; }
    .stat-currency { font-size: 1rem; font-weight: 700; color: var(--slate-800); }
    .stat-number { font-size: 1.5rem; font-weight: 800; color: var(--slate-800); }

    .content-card-premium {
        background: white;
        border-radius: 1.25rem;
        border: 1px solid var(--slate-200);
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        overflow: hidden;
    }
    .card-header-premium {
        padding: 1.5rem;
        background: var(--slate-50);
        border-bottom: 1px solid var(--slate-100);
    }
    .border-bottom-rose { border-bottom: 1px solid var(--light-rose); }
    .header-inner { display: flex; justify-content: space-between; align-items: center; }
    .card-title-premium { font-weight: 800; margin: 0; font-size: 1.1rem; }
    .badge-count-premium { padding: 0.375rem 0.875rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 700; }

    .table-modern { width: 100%; border-collapse: separate; border-spacing: 0; }
    .table-modern th { padding: 1rem; background: white; font-size: 0.75rem; font-weight: 700; color: var(--slate-500); text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid var(--slate-100); }
    .table-modern td { padding: 1.25rem 1rem; vertical-align: middle; border-bottom: 1px solid var(--slate-50); }
    .table-modern tr:hover td { background: var(--slate-50); }

    .badge-category-keluar {
        background: #fff1f2;
        color: #e11d48;
        padding: 0.25rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 700;
        white-space: nowrap;
        border: 1px solid #fecdd3;
    }

    .amount-text-premium { font-size: 1.05rem; font-weight: 800; }
    .user-pill { display: inline-flex; align-items: center; gap: 0.5rem; background: var(--slate-50); padding: 0.25rem 0.75rem 0.25rem 0.25rem; border-radius: 2rem; border: 1px solid var(--slate-100); }
    .user-avatar-tiny { width: 1.5rem; height: 1.5rem; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 800; }
    .user-name-tiny { font-size: 0.8rem; font-weight: 600; color: var(--slate-700); }

    .btn-action-view-keluar {
        background: white; border: 1px solid var(--slate-200); width: 2.25rem; height: 2.25rem; border-radius: 0.625rem; display: flex; align-items: center; justify-content: center; color: var(--slate-400); transition: all 0.2s; cursor: pointer;
    }
    .btn-action-view-keluar:hover { color: var(--primary-rose); border-color: var(--primary-rose); background: var(--light-rose); }

    .btn-action-print-keluar {
        background: white; border: 1px solid var(--slate-200); width: 2.25rem; height: 2.25rem; border-radius: 0.625rem; display: flex; align-items: center; justify-content: center; color: var(--slate-400); transition: all 0.2s; text-decoration: none;
    }
    .btn-action-print-keluar:hover { color: var(--slate-800); border-color: var(--slate-800); background: var(--slate-50); }

    .btn-group-action {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .btn-rose-sm { background: var(--primary-rose); color: white; padding: 0.5rem 1.25rem; border-radius: 0.5rem; font-weight: 700; text-decoration: none; font-size: 0.875rem; display: inline-block; transition: all 0.2s; }
    .btn-rose-sm:hover { background: var(--dark-rose); color: white; transform: scale(1.05); }

    .alert-emerald { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; border-radius: 0.75rem; padding: 1rem; }

    /* Modal Styling */
    .font-800 { font-weight: 800; }
    .detail-item { margin-bottom: 1.25rem; border-bottom: 1px dashed var(--slate-200); padding-bottom: 0.75rem; }
    .detail-item:last-child { border-bottom: none; }
    .detail-label { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-400); font-weight: 700; display: block; margin-bottom: 0.25rem; }
    .detail-value { font-size: 1.1rem; font-weight: 700; color: var(--slate-800); display: block; }
    .detail-value.amount { font-size: 1.5rem; color: var(--primary-rose); }
    
    .btn-print-premium {
        background: var(--slate-800);
        color: white;
        padding: 0.875rem 1.5rem;
        border-radius: 0.875rem;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .btn-print-premium:hover { background: black; color: white; transform: translateY(-2px); }

    @media (max-width: 768px) {
        .kas-header-premium { flex-direction: column; align-items: flex-start; gap: 1.25rem; }
        .btn-rose-premium { width: 100%; justify-content: center; }
    }
</style>

<script>
    function showDetail(id) {
        const modal = new bootstrap.Modal(document.getElementById('modalDetail'));
        const content = document.getElementById('detailContent');
        const printBtn = document.getElementById('btnPrintDetail');
        
        content.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-rose-500" role="status"></div>
            </div>
        `;
        printBtn.classList.add('d-none');
        
        modal.show();
        
        fetch(`/kas-keluar/${id}`)
            .then(response => response.json())
            .then(res => {
                if(res.success) {
                    const d = res.data;
                    content.innerHTML = `
                        <div class="detail-container">
                            <div class="detail-item">
                                <span class="detail-label">Nomor Transaksi</span>
                                <span class="detail-value text-rose-600">${d.no_transaksi}</span>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="detail-item">
                                        <span class="detail-label">Tanggal</span>
                                        <span class="detail-value">${d.date}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="detail-item">
                                        <span class="detail-label">Waktu</span>
                                        <span class="detail-value">${d.time}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Kategori</span>
                                <span class="badge-category-keluar">${d.category}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Nominal Pengeluaran</span>
                                <span class="detail-value amount">Rp ${d.amount_formatted}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Keterangan</span>
                                <span class="detail-value" style="font-weight: 500;">${d.description}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Operator / Kasir</span>
                                <div class="user-pill mt-1">
                                    <div class="user-avatar-tiny bg-slate-500">${d.user.charAt(0)}</div>
                                    <span class="user-name-tiny">${d.user}</span>
                                </div>
                            </div>
                        </div>
                    `;
                    printBtn.href = d.print_url;
                    printBtn.classList.remove('d-none');
                }
            });
    }

    // Add click event to buttons if not done inline
    document.addEventListener('DOMContentLoaded', function() {
        const detailButtons = document.querySelectorAll('.btn-action-view-keluar');
        detailButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Get the closest row id or use a data attribute
                // For now, let's update the blade template to pass ID more easily
            });
        });
    });
</script>
@endsection
