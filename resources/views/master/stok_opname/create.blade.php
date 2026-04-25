@extends('layouts.app')

@section('title', 'Buat Stok Opname - Apotekku')
@section('page_title', 'Stok > Stok Opname > Buat Baru')

@section('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* ===== MODERN DESIGN SYSTEM ===== */
    :root {
        --primary-solid: #0d9488;
        --primary-deep: #064e4b;
        --primary-dark: #042f2e;
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

    /* ===== PAGE HEADER ===== */
    .page-header-banner {
        background-color: #064e4b !important;
        background-image: var(--primary-gradient) !important;
        border-radius: 1.25rem;
        padding: 2.5rem 2rem;
        color: #ffffff !important;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 20px 25px -5px rgba(6, 78, 75, 0.2);
        position: relative;
        overflow: hidden;
        border: none !important;
        opacity: 1 !important;
    }
    .page-header-banner::before {
        content: ''; position: absolute; top: -40px; right: -40px; width: 200px; height: 200px;
        background: rgba(255,255,255,0.07); border-radius: 50%;
    }
    .page-header-banner::after {
        content: ''; position: absolute; bottom: -60px; right: 180px; width: 150px; height: 150px;
        background: rgba(255,255,255,0.05); border-radius: 50%;
    }
    .page-header-left { position: relative; z-index: 1; }
    .page-header-left h2 { 
        margin: 0 0 0.5rem 0; 
        font-weight: 800; 
        color: #fff !important; 
        display: flex; 
        align-items: center; 
        gap: 0.75rem;
        font-size: 1.75rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .page-header-left p { margin: 0; font-size: 1rem; color: #ccfbf1 !important; font-weight: 500; }

    .btn-back {
        background: #0d9488 !important;
        color: #ffffff !important;
        border: none !important;
        padding: 0.75rem 1.5rem;
        border-radius: 1rem;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
        position: relative;
        z-index: 2;
    }
    .btn-back:hover { 
        background: #14b8a6 !important; 
        transform: translateY(-3px); 
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.25);
        color: white !important;
    }

    /* ===== CARDS ===== */
    .card-modern {
        background: #fff; border-radius: 1.25rem; border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0,0,0,0.04); margin-bottom: 2rem; overflow: hidden;
    }
    .card-modern-header {
        padding: 1.25rem 1.75rem; border-bottom: 1px solid var(--border-color);
        display: flex; align-items: center; gap: 0.75rem;
        background: linear-gradient(to right, #ffffff, #f0fdfa);
    }
    .card-modern-header .icon-box {
        width: 38px; height: 38px; background: linear-gradient(135deg, #ccfbf1, #d1fae5);
        border-radius: 0.65rem; display: flex; align-items: center; justify-content: center; color: #0d9488;
    }
    .card-modern-header h3 { margin: 0; font-size: 1.05rem; font-weight: 700; color: var(--text-color); }
    .card-modern-body { padding: 1.5rem 2rem; }

    /* ===== INPUT FORMS ===== */
    .form-group label { display: block; margin-bottom: 0.4rem; font-weight: 600; font-size: 0.9rem; color: #4b5563; }
    .modern-input {
        width: 100%; padding: 0.75rem 1rem; border: 1.5px solid var(--border-color); border-radius: 0.75rem;
        font-size: 0.95rem; color: var(--text-color); transition: all 0.2s; background: #f8fafc; font-family: inherit;
    }
    .modern-input:focus { border-color: var(--primary-color); background: #fff; box-shadow: 0 0 0 3px var(--primary-light); outline: none; }
    
    .input-fisik {
        text-align: center; font-size: 1.1rem; font-weight: 700; width: 120px;
    }

    /* ===== SELECT2 PREMIUM REWRITE ===== */
    .select2-container--default .select2-selection--single {
        border: 1.5px solid var(--border-color) !important;
        border-radius: 0.75rem !important;
        height: 52px !important;
        background-color: #f8fafc !important;
        display: flex !important;
        align-items: center !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #0d9488 !important;
        box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.1) !important;
        background-color: #fff !important;
    }
    .select2-dropdown {
        background-color: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 1rem !important;
        box-shadow: 0 15px 35px rgba(0,0,0,0.12) !important;
        overflow: hidden !important;
        margin-top: 8px;
        z-index: 9999 !important;
        animation: select2SlideUp 0.2s ease-out;
    }

    @keyframes select2SlideUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Scrollbar & Height Limit */
    .select2-results__options {
        max-height: 380px !important;
        overflow-y: auto !important;
        padding: 0.5rem !important;
        scrollbar-width: thin;
        scrollbar-color: #0d9488 #f1f5f9;
    }
    .select2-results__options::-webkit-scrollbar { width: 6px; }
    .select2-results__options::-webkit-scrollbar-track { background: #f1f5f9; }
    .select2-results__options::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .select2-results__options::-webkit-scrollbar-thumb:hover { background: #0d9488; }

    .select2-results__option {
        background-color: #ffffff !important;
        border-radius: 0.65rem !important;
        padding: 0.85rem 1rem !important;
        margin-bottom: 0.25rem;
        transition: all 0.2s;
        border: 1px solid transparent;
    }
    .select2-results__option--highlighted[aria-selected] {
        background: linear-gradient(135deg, #0d9488, #0f766e) !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.2);
    }

    /* Search Field Inside Dropdown */
    .select2-search--dropdown {
        padding: 12px !important;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }
    .select2-search__field {
        width: 100% !important;
        border: 1.5px solid #e2e8f0 !important;
        border-radius: 0.5rem !important;
        padding: 10px 14px !important;
        background: white !important;
        outline: none !important;
        transition: all 0.2s;
        font-family: inherit;
        font-size: 0.9rem !important;
        box-sizing: border-box !important;
    }
    .select2-search__field:focus {
        border-color: #0d9488 !important;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1) !important;
    }

    /* Result Item Layout */
    .search-result-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.75rem;
    }
    .result-icon {
        width: 36px; height: 36px;
        background: #f0fdfa; border-radius: 0.6rem;
        display: flex; align-items: center; justify-content: center;
        color: #0d9488; flex-shrink: 0; transition: all 0.2s;
    }
    .select2-results__option--highlighted .result-icon {
        background: rgba(255,255,255,0.2); color: white;
    }
    .result-content { flex-grow: 1; min-width: 0; }
    .result-title {
        display: block; font-weight: 800; color: #1e293b;
        font-size: 0.95rem; margin-bottom: 0.1rem;
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .result-sub {
        display: flex; align-items: center; gap: 0.6rem;
        font-size: 0.75rem; color: #64748b;
    }
    .badge-meta {
        background: #f1f5f9; padding: 0.15rem 0.45rem;
        border-radius: 0.35rem; font-family: 'Courier New', monospace; font-weight: 600;
    }
    .result-stock-box { text-align: right; min-width: 65px; }
    .stock-val { display: block; font-weight: 800; color: #0d9488; font-size: 1.1rem; line-height: 1; }
    .stock-lbl { display: block; font-size: 0.65rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; margin-top: 2px; }

    .select2-results__option--highlighted .result-title,
    .select2-results__option--highlighted .result-sub,
    .select2-results__option--highlighted .stock-val,
    .select2-results__option--highlighted .stock-lbl {
        color: white !important;
    }
    .select2-results__option--highlighted .badge-meta {
        background: rgba(255,255,255,0.15); color: white;
    }

    /* ===== TABLET OPNAME ===== */
    .table-opname { width: 100%; border-collapse: separate; border-spacing: 0; }
    .table-opname th { background: #f8fafc; font-weight: 600; color: #4b5563; font-size: 0.85rem; text-transform: uppercase; padding: 1rem; border-bottom: 2px solid #e5e7eb; }
    .table-opname td { padding: 1rem; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
    
    .selisih-badge { padding: 0.4rem 0.8rem; border-radius: 0.5rem; font-weight: 700; display: inline-block; min-width: 70px; text-align: center; }

    .btn-save { background: linear-gradient(135deg, #0d9488, #0f766e); color: white; border: none; padding: 0.85rem 2rem; border-radius: 0.75rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s; box-shadow: 0 4px 12px rgba(13, 148, 136, 0.2); }
    .btn-save:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(13, 148, 136, 0.3); }
    .btn-save:disabled { background: #cbd5e1; cursor: not-allowed; box-shadow: none; transform: none; }

</style>
@endsection

@section('content')

{{-- ===== PAGE HEADER BANNER ===== --}}
<div class="page-header-banner">
    <div class="page-header-left">
        <h2>
            <svg width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            Stok Opname Baru
        </h2>
        <p>Masukkan hasil perhitungan fisik untuk disinkronkan dengan sistem secara akurat.</p>
    </div>
    <a href="{{ route('stok-opname.index') }}" class="btn-back">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Riwayat
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-danger" style="border-radius:0.75rem; border-left:4px solid #ef4444; background:#fef2f2; color:#991b1b; padding:1rem 1.5rem; margin-bottom:1.5rem;">
        <div style="font-weight:700; margin-bottom:0.5rem;">Ups! Terjadi kesalahan:</div>
        <ul style="margin:0; padding-left:1.5rem; font-size:0.95rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('stok-opname.store') }}" method="POST">
    @csrf
    
    <div class="card-modern">
        <div class="card-modern-header">
            <div class="icon-box">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3>Profil Dokumen Opname</h3>
        </div>
        <div class="card-modern-body">
            <div style="display:grid; grid-template-columns: 280px 1fr; gap:3rem; margin-bottom:1.5rem;">
                <div class="form-group">
                    <label for="tanggal_opname">Tanggal Pelaksanaan <span style="color:#ef4444;">*</span></label>
                    <input type="date" class="modern-input" id="tanggal_opname" name="tanggal_opname" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label for="keterangan">Referensi / Keterangan Dokumen</label>
                    <input type="text" class="modern-input" id="keterangan" name="keterangan" placeholder="Contoh: Stok Opname Rutin Bulan Maret 2026">
                </div>
            </div>
            
            <div style="border-top:1px dashed #cbd5e1; padding-top:1.5rem; margin-top:2rem;">
                <div class="form-group" style="margin:0;">
                    <label style="color:#0f766e; font-size:1rem; display:flex; align-items:center; gap:0.5rem;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Pencarian Obat
                    </label>
                    <p style="font-size:0.85rem; color:#64748b; margin-bottom:0.75rem;">Ketikkan nama obat atau nomor batch untuk menambahkannya ke tabel perhitungan di bawah.</p>
                    <div style="width: 100%;">
                        <select id="obatSearch" class="form-control" style="width: 100%; display: none;">
                            <option value="">Cari Obat...</option>
                            @foreach($stocks as $stock)
                                <option value="{{ $stock->id }}" 
                                        data-name="{{ $stock->obat->medicine_name }}" 
                                        data-batch="{{ $stock->batch->batch_number ?? '-' }}"
                                        data-ed="{{ $stock->batch->expired_date ? \Carbon\Carbon::parse($stock->batch->expired_date)->format('d M Y') : '-' }}"
                                        data-sysqty="{{ $stock->stock_qty }}">
                                    {{ $stock->obat->medicine_name }} | Batch: {{ $stock->batch->batch_number ?? 'Tanpa Batch' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-modern">
        <div class="card-modern-header" style="justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div class="icon-box" style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1e40af;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <h3>Rincian Item Opname</h3>
            </div>
            <span style="background:#f1f5f9; color:#475569; padding:0.4rem 1rem; border-radius:99px; font-weight:700; font-size:0.85rem;" id="itemCount">0 Item Terpilih</span>
        </div>
        <div class="table-responsive">
            <table class="table-opname" id="opnameItemsTable">
                <thead>
                    <tr>
                        <th width="35%">Nama Obat & Batch</th>
                        <th width="15%" style="text-align:center;">Stok Sistem</th>
                        <th width="15%" style="text-align:center;">Stok Fisik <span style="color:#ef4444;">*</span></th>
                        <th width="10%" style="text-align:center;">Selisih</th>
                        <th width="20%">Alasan / Catatan</th>
                        <th width="5%" style="text-align:center;">Hapus</th>
                    </tr>
                </thead>
                <tbody id="opnameItemsBody">
                    <tr id="emptyRow">
                        <td colspan="6" style="text-align:center; padding: 4rem 2rem; color: #94a3b8;">
                            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity:0.5; margin-bottom:1rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg><br>
                            Belum ada obat yang dipilih. Silakan cari obat pada kotak pencarian di atas.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="padding: 1.5rem 2rem; border-top: 1px solid #f1f5f9; background: #fafafa; text-align: right;">
            <button type="submit" class="btn-save" id="btnSubmit" disabled>
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Transaksi & Sesuaikan Stok
            </button>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#obatSearch').select2({
            placeholder: "Ketik Nama Obat atau Batch disini...",
            allowClear: true,
            templateResult: formatObat,
            templateSelection: formatObatSelection,
            language: {
                noResults: function() {
                    return "Obat tidak ditemukan";
                }
            }
        });

        function formatObat(state) {
            if (!state.id) return state.text;
            
            var $option = $(state.element);
            
            // Pengambilan data atribut (paling akurat)
            var name = $option.data('name') || $option.attr('data-name');
            var batch = $option.data('batch') || $option.attr('data-batch');
            var ed = $option.data('ed') || $option.attr('data-ed');
            var sysQty = $option.data('sysqty') || $option.attr('data-sysqty');

            // Fallback Ekstra: Jika data atribut gagal, potong dari state.text
            if (!name || name === 'undefined') {
                if (state.text && state.text.includes('|')) {
                    var parts = state.text.split('|');
                    name = parts[0].trim();
                    if (!batch || batch === '-') batch = parts[1].replace('Batch: ', '').trim();
                } else {
                    name = state.text || 'Obat Tidak Teridentifikasi';
                }
            }

            var $container = $(
                `<div class="search-result-item">
                    <div class="result-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </div>
                    <div class="result-content">
                        <span class="result-title" style="display:block; font-weight:800; color:#1e293b; font-size:0.95rem; margin-bottom:2px;">${name}</span>
                        <div class="result-sub">
                            <span>Batch: <span class="badge-meta">${batch}</span></span>
                            <span>Exp: <span class="badge-meta">${ed}</span></span>
                        </div>
                    </div>
                    <div class="result-stock-box">
                        <span class="stock-val">${sysQty}</span>
                        <span class="stock-lbl">Stok</span>
                    </div>
                </div>`
            );
            return $container;
        }

        function formatObatSelection(state) {
            if (!state.id) return state.text;
            var $option = $(state.element);
            var name = $option.data('name') || $option.attr('data-name') || (state.text ? state.text.split('|')[0].trim() : 'Obat');
            var batch = $option.data('batch') || $option.attr('data-batch') || '-';
            return '<span style="font-weight:700; color:#0d9488;">📦 ' + name + '</span> <small style="color:#64748b;">(' + batch + ')</small>';
        }

        $('#obatSearch').on('select2:select', function (e) {
            var data = e.params.data;
            var id = data.id;
            
            // Check if already added
            if ($('#row_' + id).length > 0) {
                alert('Obat pada Batch ini sudah ada di dalam tabel konfirmasi. Jika ingin merubah, sesuaikan jumlah fisik-nya langsung di tabel.');
                $(this).val(null).trigger('change');
                return;
            }

            var $option = $(data.element);
            var name = $option.data('name');
            var batch = $option.data('batch');
            var ed = $option.data('ed');
            var sysQty = $option.data('sysqty');

            // Remove empty row message
            $('#emptyRow').hide();

            var newRow = `
                <tr id="row_${id}">
                    <td>
                        <input type="hidden" name="opname_items[]" value="${id}">
                        <div style="font-weight:700; color:#0f766e; font-size:1.05rem; margin-bottom:0.2rem;">${name}</div>
                        <div style="font-size:0.85rem; color:#64748b; font-family:'Courier New', monospace; background:#f1f5f9; padding:0.2rem 0.5rem; border-radius:0.3rem; display:inline-block;">Batch: ${batch} | ED: ${ed}</div>
                    </td>
                    <td style="text-align:center;">
                        <span style="font-size:1.25rem; font-weight:800; color:#475569;">${sysQty}</span>
                    </td>
                    <td style="text-align:center;">
                        <input type="number" name="stok_fisik[]" class="modern-input input-fisik" 
                               min="0" required onkeyup="calculateSelisih(${id}, ${sysQty})" onchange="calculateSelisih(${id}, ${sysQty})" id="fisik_${id}">
                    </td>
                    <td style="text-align:center;">
                        <span class="selisih-badge" style="background:#f1f5f9; color:#94a3b8; border:1px solid #e2e8f0;" id="badge_${id}">-</span>
                    </td>
                    <td>
                        <input type="text" name="alasan[]" class="modern-input" placeholder="Wajib diisi jika selisih" id="alasan_${id}">
                    </td>
                    <td style="text-align:center;">
                        <button type="button" style="background:transparent; border:none; color:#ef4444; font-size:1.2rem; cursor:pointer; padding:0.5rem;" onclick="removeRow(${id})" title="Hapus Item">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </td>
                </tr>
            `;

            $('#opnameItemsBody').prepend(newRow);
            
            // Reset Select2
            $(this).val(null).trigger('change');
            
            updateItemCount();
        });
    });

    function calculateSelisih(id, sysQty) {
        var fisikInput = $('#fisik_' + id).val();
        var badge = $('#badge_' + id);
        var alasanInput = $('#alasan_' + id);
        
        if (fisikInput === '') {
            badge.css({ 'background': '#f1f5f9', 'color': '#94a3b8', 'border-color' : '#e2e8f0' }).text('-');
            alasanInput.prop('required', false);
            return;
        }

        var selisih = parseInt(fisikInput) - parseInt(sysQty);
        
        if (selisih > 0) {
            badge.css({ 'background': '#dcfce7', 'color': '#166534', 'border-color' : '#bbf7d0' }).text('+' + selisih);
            alasanInput.prop('required', true).attr('placeholder', 'Jelaskan alasan kelebihan...');
        } else if (selisih < 0) {
            badge.css({ 'background': '#fee2e2', 'color': '#991b1b', 'border-color' : '#fecaca' }).text(selisih);
            alasanInput.prop('required', true).attr('placeholder', 'Jelaskan alasan kekurangan...');
        } else {
            badge.css({ 'background': '#f8fafc', 'color': '#475569', 'border-color' : '#e2e8f0' }).text('Sesuai');
            alasanInput.prop('required', false).attr('placeholder', 'Tidak perlu diisi');
        }
    }

    function removeRow(id) {
        $('#row_' + id).animate({ opacity: 0 }, 200, function() {
            $(this).remove();
            updateItemCount();
        });
    }

    function updateItemCount() {
        var count = $('input[name="opname_items[]"]').length;
        $('#itemCount').text(count + ' Item Terpilih');
        
        if (count > 0) {
            $('#btnSubmit').prop('disabled', false).css('opacity', '1');
        } else {
            $('#btnSubmit').prop('disabled', true).css('opacity', '0.7');
            $('#emptyRow').fadeIn(200);
        }
    }
</script>
@endpush
