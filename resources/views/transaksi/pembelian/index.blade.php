@extends('layouts.app')

@section('title', 'Transaksi Pembelian - Apotekku')
@section('page_title', 'Transaksi Pembelian')

@section('styles')
<style>
    .page-header-banner {
        background: linear-gradient(135deg, #1e3a5f 0%, #0d9488 55%, #10b981 100%);
        border-radius: 1.25rem; padding: 1.75rem 2rem; margin-bottom: 1.75rem;
        position: relative; overflow: hidden;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 10px 30px rgba(13,148,136,.25);
    }
    .page-header-banner::before { content:''; position:absolute; top:-40px; right:-40px; width:200px; height:200px; background:rgba(255,255,255,.08); border-radius:50%; }
    .page-header-banner::after  { content:''; position:absolute; bottom:-60px; right:160px; width:150px; height:150px; background:rgba(255,255,255,.05); border-radius:50%; }
    .page-header-left { position:relative; z-index:1; }
    .page-header-left h2 { margin:0 0 .3rem; font-size:1.6rem; font-weight:800; color:#1a1a1a; }
    .page-header-left p  { margin:0; font-size:.9rem; color:rgba(0,0,0,.60); }
    .page-header-right   { position:relative; z-index:1; }
    .btn-add-new { background:rgba(255,255,255,.18); backdrop-filter:blur(10px); border:1.5px solid rgba(255,255,255,.45); color:#fff; padding:.7rem 1.5rem; border-radius:.75rem; font-size:.9rem; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:.5rem; transition:all .2s; text-decoration:none; }
    .btn-add-new:hover { background:rgba(255,255,255,.3); transform:translateY(-2px); box-shadow:0 8px 20px rgba(0,0,0,.15); }

    /* MINI STATS */
    .mini-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:1.1rem; margin-bottom:1.75rem; }
    .mini-stat { background:#fff; border-radius:1rem; padding:1.2rem 1.5rem; display:flex; align-items:center; gap:1rem; border:1px solid var(--border-color); box-shadow:0 2px 12px rgba(0,0,0,.04); transition:transform .2s,box-shadow .2s; }
    .mini-stat:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,.08); }
    .mini-stat-icon { width:48px; height:48px; border-radius:.85rem; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .mini-stat-icon.teal   { background:linear-gradient(135deg,#ccfbf1,#d1fae5); color:#0d9488; }
    .mini-stat-icon.blue   { background:linear-gradient(135deg,#dbeafe,#eff6ff); color:#2563eb; }
    .mini-stat-icon.green  { background:linear-gradient(135deg,#d1fae5,#ecfdf5); color:#059669; }
    .mini-stat-lbl { font-size:.75rem; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; margin:0 0 .2rem; }
    .mini-stat-val { font-size:1.4rem; font-weight:800; color:var(--text-color); margin:0; line-height:1.1; }

    /* TABLE CARD */
    .table-card { background:#fff; border-radius:1.25rem; border:1px solid var(--border-color); box-shadow:0 4px 20px rgba(0,0,0,.04); overflow:hidden; }
    .table-card-header { padding:1.25rem 1.75rem; border-bottom:1px solid var(--border-color); display:flex; align-items:center; gap:.75rem; background:linear-gradient(to right,#fff,#f0fdfa); }
    .table-card-header .icon-box { width:38px; height:38px; background:linear-gradient(135deg,#ccfbf1,#d1fae5); border-radius:.65rem; display:flex; align-items:center; justify-content:center; color:#0d9488; }
    .table-card-header h3 { margin:0; font-size:1.05rem; font-weight:700; color:var(--text-color); }
    .table-card-body { padding:1.5rem 2rem 2rem; }

    /* FAKE BADGES */
    .faktur-chip { display:inline-block; background:#f0fdf4; border:1px solid #86efac; border-radius:.4rem; padding:.15rem .6rem; font-family:monospace; font-size:.82rem; color:#166534; font-weight:700; }
    .supplier-chip { display:inline-flex; align-items:center; gap:.3rem; background:#eff6ff; border:1px solid #bfdbfe; border-radius:.4rem; padding:.15rem .6rem; font-size:.8rem; color:#1d4ed8; font-weight:600; }
    .total-chip { font-weight:700; color:#0f766e; font-size:.92rem; }
    .status-badge { display:inline-block; padding:.2rem .65rem; border-radius:999px; font-size:.75rem; font-weight:700; }
    .status-done    { background:#d1fae5; color:#065f46; }
    .status-pending { background:#fef3c7; color:#92400e; }

    /* ACTION BUTTONS */
    .action-group { display:flex; gap:.4rem; justify-content:center; }
    .btn-view { display:inline-flex; align-items:center; gap:.3rem; padding:.35rem .75rem; border-radius:.5rem; font-size:.78rem; font-weight:700; cursor:pointer; border:none; transition:all .2s; background:linear-gradient(135deg,#dbeafe,#eff6ff); color:#1d4ed8; border:1px solid #bfdbfe; text-decoration:none; }
    .btn-view:hover { background:linear-gradient(135deg,#2563eb,#1d4ed8); color:#fff; border-color:#1d4ed8; transform:translateY(-1px); box-shadow:0 4px 10px rgba(37,99,235,.3); }
    .btn-del  { display:inline-flex; align-items:center; gap:.3rem; padding:.35rem .75rem; border-radius:.5rem; font-size:.78rem; font-weight:700; cursor:pointer; border:none; transition:all .2s; background:linear-gradient(135deg,#fee2e2,#fecaca); color:#991b1b; border:1px solid #fca5a5; }
    .btn-del:hover  { background:linear-gradient(135deg,#ef4444,#dc2626); color:#fff; border-color:#dc2626; transform:translateY(-1px); box-shadow:0 4px 10px rgba(239,68,68,.3); }

    .empty-state { text-align:center; padding:4rem 2rem; color:#9ca3af; }
    .empty-state p { margin:.5rem 0 0; font-size:.95rem; }
    table.dataTable tbody tr:hover > td { background:#f0fdfa !important; }
    .date-text { font-size:.85rem; color:#374151; font-weight:600; }
    .user-text  { font-size:.82rem; color:#6b7280; }
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
    <div class="page-header-left">
        <h2>🛒 Transaksi Pembelian</h2>
        <p>Kelola semua transaksi pembelian obat dari supplier dengan mudah dan cepat.</p>
    </div>
    <div class="page-header-right">
        <a href="{{ route('pembelian.create') }}" class="btn-add-new">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            + Buat Pembelian
        </a>
    </div>
</div>

<div class="mini-stats">
    <div class="mini-stat">
        <div class="mini-stat-icon teal">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Total Transaksi</p>
            <p class="mini-stat-val">{{ $totalPembelian }}</p>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon blue">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Bulan Ini</p>
            <p class="mini-stat-val">{{ $bulanIni }}</p>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon green">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Total Nilai</p>
            <p class="mini-stat-val" style="font-size:1.1rem;">Rp {{ number_format($totalNilai,0,',','.') }}</p>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="table-card-header">
        <div class="icon-box">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
        </div>
        <h3>Daftar Transaksi Pembelian</h3>
        <span style="margin-left:auto;background:#f0fdfa;border:1px solid #99f6e4;color:#0f766e;font-size:.78rem;font-weight:700;padding:.25rem .75rem;border-radius:999px;">{{ $totalPembelian }} Transaksi</span>
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
                        <span class="date-text">{{ \Carbon\Carbon::parse($p->tanggal_pembelian)->format('d/m/Y') }}</span>
                    </td>
                    <td>
                        <span class="user-text">{{ optional($p->user)->name ?? '—' }}</span>
                    </td>
                    <td style="text-align:right;">
                        <span class="total-chip">Rp {{ number_format($p->total_harga,0,',','.') }}</span>
                    </td>
                    <td style="text-align:center;">
                        <span style="background:#f0fdfa;border:1px solid #99f6e4;color:#0f766e;font-size:.78rem;font-weight:700;padding:.15rem .55rem;border-radius:999px;">
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
                            <a href="{{ route('pembelian.create') }}" style="display:inline-flex;align-items:center;gap:.4rem;margin-top:1rem;background:#0d9488;color:#fff;padding:.6rem 1.25rem;border-radius:.65rem;font-size:.88rem;font-weight:700;text-decoration:none;">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                Buat Pembelian Pertama
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
