@extends('layouts.app')

@section('title', 'Detail Stok Opname - Apotekku')
@section('page_title', 'Stok > Stok Opname > Detail')

@section('styles')
<style>
    /* ===== MODERN DESIGN SYSTEM ===== */
    :root {
        --primary-solid: #0d9488;
        --primary-deep: #064e4b; /* Sangat Gelap */
        --primary-dark: #042f2e; /* Hampir Hitam-Teal */
        --primary-gradient: linear-gradient(135deg, #064e4b, #042f2e);
        --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
    }

    /* Mendandani Judul Halaman (Breadcrumb) agar lebih estetik & kecil */
    .page-title {
        font-size: 0.95rem !important;
        font-weight: 500 !important;
        color: #64748b !important;
        background: #f8fafc;
        padding: 0.5rem 1rem;
        border-radius: 99px;
        border: 1px solid #e2e8f0;
    }

    .page-header-banner {
        background-color: #064e4b !important; /* Warna dasar sangat gelap */
        background-image: var(--primary-gradient) !important; /* Gradient pekat */
        border-radius: 1.25rem;
        padding: 3.5rem 3rem;
        color: #ffffff !important;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 25px 50px -12px rgba(6, 78, 75, 0.35); /* Shadow lebih kuat */
        position: relative;
        overflow: hidden;
        border: none !important;
        opacity: 1 !important;
        z-index: 1; /* Pastikan di atas layer lain */
    }

    .page-header-banner::before {
        content: ''; position: absolute; top: -50px; right: -50px;
        width: 300px; height: 300px; background: rgba(255,255,255,0.05); /* Sangat tipis */
        border-radius: 50%;
        z-index: -1;
    }

    .header-content h2 { 
        font-weight: 800; 
        margin-bottom: 0.75rem; 
        letter-spacing: -0.025em; 
        color: #ffffff !important; 
        text-shadow: 0 2px 10px rgba(0,0,0,0.3); 
        font-size: 2.2rem;
    }
    .header-content p { 
        color: #99f6e4 !important; /* Teal terang yang sangat kontras */
        font-size: 1.1rem; 
        margin-bottom: 0; 
        font-weight: 500;
        max-width: 600px;
    }

    .btn-back {
        background: #0d9488 !important; /* Lebih terang agar kontras di BG gelap */
        color: #ffffff !important;
        border: none !important;
        padding: 1rem 2rem;
        border-radius: 1rem;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
    }
    .btn-back:hover { 
        background: #14b8a6 !important; 
        transform: translateY(-3px) scale(1.02); 
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.25);
    }

    /* ===== INFO CARDS ===== */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-card {
        background: white;
        padding: 1.5rem;
        border-radius: 1.25rem;
        border: 1px solid #f1f5f9;
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease;
    }
    .info-card:hover { transform: translateY(-5px); }

    .info-icon {
        width: 42px; height: 42px;
        background: #f0fdfa;
        border-radius: 0.75rem;
        display: flex; align-items: center; justify-content: center;
        color: #0d9488; margin-bottom: 1rem;
    }

    .info-label { font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.4rem; }
    .info-value { font-size: 1.1rem; font-weight: 800; color: #1e293b; }

    /* ===== TABLE SECTION ===== */
    .card-modern {
        background: white;
        border-radius: 1.5rem;
        border: 1px solid #f1f5f9;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }
    .card-modern-header {
        padding: 1.75rem 2rem;
        background: #fff;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .card-modern-header h3 { font-weight: 800; color: #1e293b; margin: 0; font-size: 1.25rem; }

    .table-modern { width: 100%; border-collapse: separate; border-spacing: 0; }
    .table-modern th { 
        background: #f8fafc; padding: 1.25rem 1rem; 
        font-weight: 700; color: #475569; text-transform: uppercase; 
        font-size: 0.75rem; border-bottom: 2px solid #f1f5f9;
    }
    .table-modern td { padding: 1.25rem 1rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .table-modern tr:hover { background: #fcfdfe; }

    .medicine-info { display: flex; align-items: center; gap: 1rem; }
    .medicine-icon { 
        width: 40px; height: 40px; background: #f1f5f9; border-radius: 0.75rem;
        display: flex; align-items: center; justify-content: center; color: #94a3b8;
    }
    .medicine-name { font-weight: 800; color: #0f172a; display: block; font-size: 1rem; margin-bottom: 0.2rem; }
    .medicine-batch { font-family: 'Courier New', monospace; font-size: 0.8rem; color: #64748b; background: #f1f5f9; padding: 0.1rem 0.5rem; border-radius: 0.3rem; }

    .qty-badge { font-size: 1.2rem; font-weight: 800; color: #334155; }
    
    .selisih-pill {
        padding: 0.5rem 1rem; border-radius: 99px; font-weight: 800;
        font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.45rem;
    }
    .pill-surplus { background: #dcfce7; color: #166534; }
    .pill-deficit { background: #fee2e2; color: #991b1b; }
    .pill-balanced { background: #f1f5f9; color: #64748b; }

    .alasan-box {
        font-size: 0.9rem; color: #475569; display: flex; align-items: center; gap: 0.5rem;
    }

    @media (max-width: 1024px) {
        .info-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endsection

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header-banner">
    <div class="header-content">
        <h2>Laporan Detail Opname</h2>
        <p>Ringkasan perbandingan stok sistem dengan hasil perhitungan fisik di lapangan.</p>
    </div>
    <a href="{{ route('stok-opname.index') }}" class="btn-back">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar
    </a>
</div>

{{-- INFO CARDS --}}
<div class="info-grid">
    <div class="info-card">
        <div class="info-icon">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div class="info-label">Tanggal Pelaksanaan</div>
        <div class="info-value">{{ \Carbon\Carbon::parse($opname->tanggal_opname)->format('d M Y') }}</div>
    </div>
    <div class="info-card">
        <div class="info-icon" style="background: #eff6ff; color: #1d4ed8;">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <div class="info-label">Penanggung Jawab</div>
        <div class="info-value">{{ $opname->user->name ?? 'Administrator' }}</div>
    </div>
    <div class="info-card" style="grid-column: span 2;">
        <div class="info-icon" style="background: #fff7ed; color: #c2410c;">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="info-label">Keterangan / Referensi Dokumen</div>
        <div class="info-value">{{ $opname->keterangan ?: 'Tanpa keterangan tambahan' }}</div>
    </div>
</div>

{{-- TABLE DETAILS --}}
<div class="card-modern">
    <div class="card-modern-header">
        <svg width="24" height="24" fill="none" stroke="#0d9488" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
        <h3>Rincian Perbandingan Stok ({{ $opname->detail->count() }} Item)</h3>
    </div>
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th width="5%" class="text-center">#</th>
                    <th width="35%">Nama Obat & Batch</th>
                    <th class="text-center">Stok Komputer</th>
                    <th class="text-center">Hasil Fisik</th>
                    <th class="text-center">Selisih</th>
                    <th width="20%">Catatan / Alasan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($opname->detail as $index => $item)
                <tr>
                    <td class="text-center" style="color:#94a3b8; font-weight:600;">{{ $index + 1 }}</td>
                    <td>
                        <div class="medicine-info">
                            <div class="medicine-icon">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            </div>
                            <div>
                                <span class="medicine-name">{{ $item->medicineStock->obat->medicine_name }}</span>
                                <span class="medicine-batch">Batch: {{ $item->medicineStock->batch->batch_number ?? '-' }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="qty-badge" style="color: #64748b;">{{ $item->stok_sistem }}</span>
                    </td>
                    <td class="text-center">
                        <span class="qty-badge">{{ $item->stok_fisik }}</span>
                    </td>
                    <td class="text-center">
                        @if($item->selisih > 0)
                            <div class="selisih-pill pill-surplus">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                +{{ $item->selisih }}
                            </div>
                        @elseif($item->selisih < 0)
                            <div class="selisih-pill pill-deficit">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                                {{ $item->selisih }}
                            </div>
                        @else
                            <div class="selisih-pill pill-balanced">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                Sesuai
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="alasan-box">
                            @if($item->selisih != 0)
                                <svg width="16" height="16" fill="none" stroke="#ef4444" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>{{ $item->alasan ?: 'Alasan belum diisi' }}</span>
                            @else
                                <svg width="16" height="16" fill="none" stroke="#10b981" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span style="color:#10b981">Data Sinkron</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
