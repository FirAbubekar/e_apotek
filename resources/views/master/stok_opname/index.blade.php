@extends('layouts.app')

@section('title', 'Riwayat Stok Opname - Apotekku')
@section('page_title', 'Stok > Stok Opname')

@section('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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

    /* Action Button Styles */
    .btn-create-premium {
        background: #0d9488 !important;
        color: white !important;
        padding: 1rem 1.75rem;
        border-radius: 1rem;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
        border: none !important;
        z-index: 2;
    }
    .btn-create-premium:hover { 
        background: #14b8a6 !important; 
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.25);
        color: white !important;
    }

    /* CARD & TABLE PREMIUM */
    .card-modern {
        background: white;
        border-radius: 1.5rem;
        border: 1px solid #f1f5f9;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .table-modern { width: 100%; border-collapse: separate; border-spacing: 0; }
    .table-modern th { 
        background: #f8fafc; padding: 1.25rem 1.5rem; 
        font-weight: 700; color: #475569; text-transform: uppercase; 
        font-size: 0.75rem; border-bottom: 2px solid #f1f5f9;
    }
    .table-modern td { padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; font-size: 0.95rem; }
    .table-modern tr:hover { background: #fcfdfe; }

    .date-badge {
        background: #f1f5f9;
        color: #334155;
        font-weight: 700;
        padding: 0.4rem 0.75rem;
        border-radius: 0.6rem;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid #e2e8f0;
    }

    .user-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #1e293b;
        font-weight: 700;
    }
    .user-avatar-sm {
        width: 28px; height: 28px; background: #e2e8f0; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 0.7rem;
    }

    .btn-detail-pill {
        background: #eff6ff; color: #1e40af; border: 1px solid #dbeafe;
        padding: 0.5rem 1rem; border-radius: 99px; font-weight: 700;
        font-size: 0.8rem; text-decoration: none; transition: all 0.2s;
        display: inline-flex; align-items: center; gap: 0.4rem;
    }
    .btn-detail-pill:hover { background: #1e40af; color: white; transform: scale(1.05); }

    /* Custom DataTables search input */
    .dataTables_filter input {
        border-radius: 0.75rem !important;
        border: 1.5px solid #e2e8f0 !important;
        padding: 0.5rem 1rem !important;
    }
    .dataTables_filter input:focus {
        border-color: #0d9488 !important; box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1) !important;
    }
</style>
@endsection

@section('content')

{{-- HEADER BANNER --}}
<div class="page-header-banner">
    <div class="header-content">
        <h2>
            <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            Riwayat Stok Opname
        </h2>
        <p>Kelola dan tinjau seluruh aktivitas penyesuaian stok per batch di sistem Anda.</p>
    </div>
    <a href="{{ route('stok-opname.create') }}" class="btn-create-premium">
        <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
        Stok Opname Baru
    </a>
</div>

{{-- ALERT SESSION --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 1rem; border-left:5px solid #10b981; padding: 1.25rem 1.5rem; background: #ecfdf5; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border: 1px solid #d1fae5; margin-bottom: 2rem;">
        <div class="d-flex align-items-center gap-3">
            <svg width="24" height="24" fill="#10b981" viewBox="0 0 24 24" style="flex-shrink:0;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            <span style="font-weight: 600; color: #065f46;">{{ session('success') }}</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- DATA TABLE CARD --}}
<div class="card-modern">
    <div class="p-0">
        <div class="table-responsive" style="padding: 1.5rem !important;">
            <table id="opnameTable" class="table-modern w-100">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th width="20%">Tanggal Opname</th>
                        <th width="35%">Keterangan / Dokumen</th>
                        <th width="20%">Penanggung Jawab</th>
                        <th width="10%" class="text-center">Waktu</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($opnames as $index => $opname)
                        <tr>
                            <td class="text-center" style="color:#94a3b8; font-weight:700;">{{ $index + 1 }}</td>
                            <td>
                                <div class="date-badge">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ \Carbon\Carbon::parse($opname->tanggal_opname)->format('d M Y') }}
                                </div>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: #334155;">{{ $opname->keterangan ?: 'Tanpa keterangan' }}</span>
                            </td>
                            <td>
                                <div class="user-pill">
                                    <div class="user-avatar-sm">
                                        {{ substr($opname->user->name ?? 'S', 0, 1) }}
                                    </div>
                                    {{ $opname->user->name ?? 'Sistem' }}
                                </div>
                            </td>
                            <td class="text-center" style="font-family: 'Courier New', monospace; font-weight: 700; color: #64748b;">
                                {{ $opname->created_at->format('H:i') }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('stok-opname.show', $opname->id) }}" class="btn-detail-pill">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#opnameTable').DataTable({
            language: { 
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                search: "_INPUT_",
                searchPlaceholder: "Cari riwayat opname...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    previous: "<i class='fas fa-chevron-left'></i>",
                    next: "<i class='fas fa-chevron-right'></i>"
                }
            },
            "pageLength": 10,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "dom": '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip>'
        });
    });
</script>
@endpush
