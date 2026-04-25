@extends('layouts.app')

@section('title', 'Monitoring Obat Expired - Apotekku')
@section('page_title', 'Stok > Obat Expired')

@section('styles')
<style>
    /* ===== MODERN DESIGN SYSTEM ===== */
    :root {
        --primary-solid: #0d9488;
        --primary-deep: #064e4b;
        --primary-gradient: linear-gradient(135deg, #064e4b, #042f2e);
        --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
        
        --danger-soft: #fef2f2;
        --danger-deep: #991b1b;
        --warning-soft: #fff7ed;
        --warning-deep: #9a3412;
        --info-soft: #f0f9ff;
        --info-deep: #075985;
    }


    /* Header Banner Premium */
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

    /* TAB SYSTEM */
    .nav-tabs-premium {
        display: flex;
        gap: 1rem;
        background: white;
        padding: 0.75rem;
        border-radius: 1.25rem;
        border: 1px solid #f1f5f9;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .tab-link {
        flex: 1;
        text-align: center;
        padding: 1rem;
        border-radius: 0.75rem;
        font-weight: 800;
        text-decoration: none;
        color: #64748b;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
        border: 1px solid transparent;
    }

    .tab-link:hover { background: #f8fafc; color: #1e293b; }

    .tab-link.active[data-tab="expired"] { background: var(--danger-soft); color: var(--danger-deep); border-color: #fecaca; }
    .tab-link.active[data-tab="critical"] { background: var(--warning-soft); color: var(--warning-deep); border-color: #fed7aa; }
    .tab-link.active[data-tab="monitor"] { background: var(--info-soft); color: var(--info-deep); border-color: #bae6fd; }

    .tab-count {
        font-size: 1.5rem;
        line-height: 1;
    }
    .tab-label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; }

    /* TABLE MODERNA */
    .card-modern {
        background: white; border-radius: 1.5rem; border: 1px solid #f1f5f9;
        box-shadow: var(--card-shadow); overflow: hidden; margin-bottom: 2rem;
        display: none; /* Hidden by default */
    }
    .card-modern.active { display: block; animation: tabFade 0.4s ease-out; }

    @keyframes tabFade { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .table-modern { width: 100%; border-collapse: separate; border-spacing: 0; }
    .table-modern th { 
        background: #f8fafc; padding: 1.25rem 1.5rem; 
        font-weight: 700; color: #475569; text-transform: uppercase; 
        font-size: 0.75rem; border-bottom: 2px solid #f1f5f9;
    }
    .table-modern td { padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; font-size: 0.95rem; }

    .medicine-meta { display: flex; flex-direction: column; }
    .med-name { font-weight: 800; color: #1e293b; font-size: 1.05rem; }
    .batch-num { font-family: monospace; color: #64748b; font-size: 0.8rem; }

    .expiry-date { font-weight: 800; }
    .expiry-date.red { color: var(--danger-deep); }
    .expiry-date.orange { color: var(--warning-deep); }
    .expiry-date.yellow { color: #854d0e; }

    .stock-badge {
        background: #f1f5f9; padding: 0.5rem 0.75rem; border-radius: 0.75rem;
        font-weight: 800; color: #334155; display: inline-flex; align-items: center; gap: 0.5rem;
    }

    .btn-action-sm {
        padding: 0.5rem 0.75rem; border-radius: 0.5rem; font-weight: 700; font-size: 0.8rem;
        text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; transition: all 0.2s;
    }
    .btn-retur { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
    .btn-retur:hover { background: #991b1b; color: white; }
</style>
@endsection

@section('content')

{{-- HEADER BANNER --}}
<div class="page-header-banner">
    <div class="header-content">
        <h2>
            <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Monitoring Obat Expired
        </h2>
        <p>Kelola risiko kedaluwarsa obat untuk keamanan pasien dan efisiensi stok.</p>
    </div>
</div>

{{-- TAB SYSTEM --}}
<div class="nav-tabs-premium">
    <a href="#" class="tab-link active" data-tab="expired">
        <span class="tab-count expiry-date red">{{ $expired->count() }}</span>
        <span class="tab-label">Sudah Expired</span>
    </a>
    <a href="#" class="tab-link" data-tab="critical">
        <span class="tab-count expiry-date orange">{{ $critical->count() }}</span>
        <span class="tab-label">Hampir (< 3 Bln)</span>
    </a>
    <a href="#" class="tab-link" data-tab="monitor">
        <span class="tab-count expiry-date yellow">{{ $monitor->count() }}</span>
        <span class="tab-label">Monitor (< 6 Bln)</span>
    </a>
</div>

{{-- TAB CONTENT 1: EXPIRED --}}
<div id="expired" class="card-modern active">
    <table class="table-modern">
        <thead>
            <tr>
                <th width="35%">Informasi Obat</th>
                <th width="20%">Tanggal Expired</th>
                <th width="15%" class="text-center">Sisa Stok</th>
                <th width="20%" class="text-center">Aksi Rekomendasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expired as $item)
                <tr>
                    <td>
                        <div class="medicine-meta">
                            <span class="med-name">{{ $item->medicine_name }}</span>
                            <span class="batch-num">Batch: {{ $item->batch_number }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="expiry-date red">
                            {{ \Carbon\Carbon::parse($item->expired_date)->format('d M Y') }}
                            <div style="font-size: 0.75rem; font-weight: 500;">(Sudah Lewat)</div>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="stock-badge">
                            {{ $item->last_stock }} Unit
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="#" class="btn-action-sm btn-retur">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Musnahkan
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center p-5 text-muted">Tidak ada obat yang sudah expired. Bagus!</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- TAB CONTENT 2: CRITICAL --}}
<div id="critical" class="card-modern">
    <table class="table-modern">
        <thead>
            <tr>
                <th width="35%">Informasi Obat</th>
                <th width="20%">Tanggal Expired</th>
                <th width="15%" class="text-center">Sisa Stok</th>
                <th width="20%" class="text-center">Aksi Rekomendasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($critical as $item)
                <tr>
                    <td>
                        <div class="medicine-meta">
                            <span class="med-name">{{ $item->medicine_name }}</span>
                            <span class="batch-num">Batch: {{ $item->batch_number }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="expiry-date orange">
                            {{ \Carbon\Carbon::parse($item->expired_date)->format('d M Y') }}
                            <div style="font-size: 0.75rem; font-weight: 500;">
                                ({{ \Carbon\Carbon::now()->diffInDays($item->expired_date) }} Hari lagi)
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="stock-badge">
                            {{ $item->last_stock }} Unit
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="#" class="btn-action-sm btn-warning" style="background:#fff7ed; color:#9a3412; border:1px solid #fed7aa;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            Promo/Diskon
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center p-5 text-muted">Aman! Belum ada obat yang hampir expired (< 3 bln).</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- TAB CONTENT 3: MONITOR --}}
<div id="monitor" class="card-modern">
    <table class="table-modern">
        <thead>
            <tr>
                <th width="35%">Informasi Obat</th>
                <th width="20%">Tanggal Expired</th>
                <th width="15%" class="text-center">Sisa Stok</th>
                <th width="20%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($monitor as $item)
                <tr>
                    <td>
                        <div class="medicine-meta">
                            <span class="med-name">{{ $item->medicine_name }}</span>
                            <span class="batch-num">Batch: {{ $item->batch_number }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="expiry-date yellow">
                            {{ \Carbon\Carbon::parse($item->expired_date)->format('d M Y') }}
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="stock-badge">
                            {{ $item->last_stock }} Unit
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-light text-dark border">Monitor Rutin</span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center p-5 text-muted">Stok Anda dalam kondisi umur simpan yang aman.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.tab-link').on('click', function(e) {
            e.preventDefault();
            var target = $(this).data('tab');

            // Toggle Tab Links
            $('.tab-link').removeClass('active');
            $(this).addClass('active');

            // Toggle Content
            $('.card-modern').removeClass('active');
            $('#' + target).addClass('active');
        });
    });
</script>
@endpush
