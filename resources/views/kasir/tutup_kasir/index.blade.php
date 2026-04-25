@extends('layouts.app')

@section('page_title', 'Riwayat Tutup Kasir')

@section('content')
<div class="kas-container">
    <div class="kas-header-premium">
        <div class="header-left">
            <h1 class="page-title">Riwayat Tutup Kasir</h1>
            <p class="page-subtitle">Daftar rekonsiliasi kas harian dan penutupan shift kasir</p>
        </div>
        <div class="header-right">
            <a href="{{ route('tutup-kasir.create') }}" class="btn-primary-premium">
                <i class="fas fa-lock me-2"></i> Tutup Kasir Baru
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-emerald mb-4 animate__animated animate__fadeIn">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="content-card-premium">
        <div class="card-header-premium">
            <h5 class="card-title-premium">Data Penutupan Kasir</h5>
        </div>
        
        <div class="card-body-premium">
            <div class="table-responsive-premium">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Waktu Tutup</th>
                            <th>Operator</th>
                            <th>Modal Awal</th>
                            <th>Saldo Sistem</th>
                            <th>Saldo Fisik</th>
                            <th>Selisih</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($closings as $closing)
                        <tr>
                            <td>
                                <div class="date-text">{{ \Carbon\Carbon::parse($closing->closing_time)->format('d/m/Y') }}</div>
                                <div class="time-text">{{ \Carbon\Carbon::parse($closing->closing_time)->format('H:i') }}</div>
                            </td>
                            <td>
                                <div class="user-pill">
                                    <div class="user-avatar-tiny bg-teal-500">{{ substr($closing->user->name, 0, 1) }}</div>
                                    <span class="user-name-tiny">{{ $closing->user->name }}</span>
                                </div>
                            </td>
                            <td>Rp {{ number_format($closing->opening_cash, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($closing->expected_cash, 0, ',', '.') }}</td>
                            <td class="font-bold">Rp {{ number_format($closing->actual_cash, 0, ',', '.') }}</td>
                            <td>
                                @if($closing->difference > 0)
                                    <span class="text-emerald-600 font-bold">+Rp {{ number_format($closing->difference, 0, ',', '.') }}</span>
                                @elseif($closing->difference < 0)
                                    <span class="text-rose-600 font-bold">-Rp {{ number_format(abs($closing->difference), 0, ',', '.') }}</span>
                                @else
                                    <span class="text-slate-400">Pas</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('tutup-kasir.show', $closing->id) }}" class="btn-action-view" title="Detail Laporan">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">Belum ada data penutupan kasir.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $closings->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .kas-container { padding: 1rem; }
    .kas-header-premium { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .page-title { font-size: 1.75rem; font-weight: 800; color: #1e293b; margin: 0; }
    .page-subtitle { color: #64748b; margin-top: 0.25rem; }
    .btn-primary-premium { background: var(--primary-color); color: white; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 700; text-decoration: none; transition: all 0.2s; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
    .btn-primary-premium:hover { background: var(--primary-hover); transform: translateY(-1px); color: white; }
    .content-card-premium { background: white; border-radius: 1rem; border: 1px solid #e2e8f0; overflow: hidden; }
    .card-header-premium { padding: 1.25rem; background: #f8fafc; border-bottom: 1px solid #e2e8f0; }
    .card-title-premium { font-weight: 700; margin: 0; font-size: 1.1rem; }
    .table-modern { width: 100%; border-collapse: collapse; }
    .table-modern th { text-align: left; padding: 1rem; background: white; font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 700; border-bottom: 1px solid #e2e8f0; }
    .table-modern td { padding: 1rem; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; }
    .user-pill { display: inline-flex; align-items: center; gap: 0.5rem; }
    .user-avatar-tiny { width: 1.5rem; height: 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.7rem; font-weight: 700; }
    .btn-action-view { color: #64748b; font-size: 1.1rem; transition: color 0.2s; }
    .btn-action-view:hover { color: var(--primary-color); }
    .font-bold { font-weight: 700; }
    .alert-emerald { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; border-radius: 0.75rem; padding: 1rem; }
</style>
@endsection
