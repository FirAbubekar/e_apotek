@extends('layouts.app')

@section('title', 'Kategori Obat - Apotekku')
@section('page_title', 'Master Data Kategori Obat')

@section('styles')
<style>
    /* PAGE HEADER */

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
        border: none !important;
    }

    .page-header-banner::before {
        content: ''; position: absolute; top: -50px; right: -50px;
        width: 250px; height: 250px; background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .page-header-banner::after {
        content: ''; position: absolute; bottom: -70px; right: 150px;
        width: 180px; height: 180px; background: rgba(255,255,255,0.03);
        border-radius: 50%;
    }

    .header-content h2 { 
        font-weight: 800; 
        margin: 0 0 0.4rem 0 !important; 
        letter-spacing: -0.025em; 
        color: #ffffff !important;
        font-size: 1.75rem !important;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        position: relative;
        z-index: 1;
    }

    .header-content p { 
        color: #99f6e4 !important; 
        font-size: 0.95rem !important; 
        margin: 0 !important; 
        font-weight: 500;
        position: relative;
        z-index: 1;
    }

    .btn-add-new {
        background: rgba(255,255,255,0.1) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2) !important;
        color: #fff !important;
        padding: 0.8rem 1.5rem !important;
        border-radius: 0.75rem !important;
        font-weight: 700 !important;
        position: relative;
        z-index: 1;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-add-new:hover {
        background: rgba(255,255,255,0.2) !important;
        transform: translateY(-2px);
    }

    /* MINI STATS */
    .mini-stats { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.1rem; margin-bottom: 1.75rem; }
    .mini-stat {
        background: #fff; border-radius: 1rem;
        padding: 1.2rem 1.5rem;
        display: flex; align-items: center; gap: 1rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .mini-stat:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
    .mini-stat-icon {
        width: 48px; height: 48px; border-radius: 0.85rem;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .mini-stat-icon.violet { background: linear-gradient(135deg, #ede9fe, #f5f3ff); color: #7c3aed; }
    .mini-stat-icon.blue   { background: linear-gradient(135deg, #dbeafe, #eff6ff); color: #2563eb; }
    .mini-stat-lbl { font-size: 0.75rem; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 0.2rem; }
    .mini-stat-val { font-size: 1.5rem; font-weight: 800; color: var(--text-color); margin: 0; line-height: 1.1; }

    /* TABLE CARD */
    .table-card { background: #fff; border-radius: 1.25rem; border: 1px solid var(--border-color); box-shadow: 0 4px 20px rgba(0,0,0,0.04); overflow: hidden; }
    .table-card-header {
        padding: 1.25rem 1.75rem; border-bottom: 1px solid var(--border-color);
        display: flex; align-items: center; gap: 0.75rem;
        background: linear-gradient(to right, #fff, #faf5ff);
    }
    .table-card-header .icon-box {
        width: 38px; height: 38px;
        background: linear-gradient(135deg, #ede9fe, #f5f3ff);
        border-radius: 0.65rem;
        display: flex; align-items: center; justify-content: center; color: #7c3aed;
    }
    .table-card-header h3 { margin: 0; font-size: 1.05rem; font-weight: 700; color: var(--text-color); }
    .table-card-body { padding: 1.5rem 2rem 2rem; }

    /* TABLE ENHANCEMENTS */
    .code-chip { display: inline-block; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.4rem; padding: 0.15rem 0.55rem; font-family: monospace; font-size: 0.78rem; color: #475569; font-weight: 600; }
    .item-name  { font-weight: 700; color: #6d28d9; font-size: 0.95rem; }
    .desc-text  { font-size: 0.85rem; color: #6b7280; max-width: 260px; }

    /* ACTION BUTTONS */
    .action-group { display: flex; gap: 0.45rem; justify-content: center; }
    .btn-icon-edit, .btn-icon-delete {
        display: inline-flex; align-items: center; gap: 0.3rem;
        padding: 0.38rem 0.8rem; border-radius: 0.5rem;
        font-size: 0.78rem; font-weight: 700; cursor: pointer; border: none; transition: all 0.2s;
    }
    .btn-icon-edit   { background: linear-gradient(135deg,#fef3c7,#fde68a); color: #92400e; border: 1px solid #fcd34d; }
    .btn-icon-edit:hover { background: linear-gradient(135deg,#f59e0b,#d97706); color: #fff; border-color: #d97706; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(245,158,11,.3); }
    .btn-icon-delete { background: linear-gradient(135deg,#fee2e2,#fecaca); color: #991b1b; border: 1px solid #fca5a5; }
    .btn-icon-delete:hover { background: linear-gradient(135deg,#ef4444,#dc2626); color: #fff; border-color: #dc2626; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(239,68,68,.3); }

    /* EMPTY STATE */
    .empty-state { text-align: center; padding: 4rem 2rem; color: #9ca3af; }
    .empty-state svg { margin-bottom: 1rem; opacity: 0.4; }
    .empty-state p { margin: 0; font-size: 0.95rem; }

    table.dataTable tbody tr:hover > td { background: #faf5ff !important; }
</style>
@endsection

@section('content')

@if (session('success'))
    <div class="alert alert-success" style="margin-bottom:1.5rem;">
        <svg style="margin-right:.75rem;flex-shrink:0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger" style="margin-bottom:1.5rem;">
        <svg style="margin-right:.75rem;flex-shrink:0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.
    </div>
@endif

{{-- PAGE HEADER --}}
<div class="page-header-banner">
    <div class="header-content">
        <h2>
            <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
            Manajemen Kategori Obat
        </h2>
        <p>Kelola dan klasifikasikan kategori obat yang tersedia di apotek Anda.</p>
    </div>
    <div class="page-header-right">
        <button type="button" class="btn btn-add-new" onclick="openModal('addModal')">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Kategori
        </button>
    </div>
</div>

{{-- MINI STATS --}}
<div class="mini-stats">
    <div class="mini-stat">
        <div class="mini-stat-icon violet">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Total Kategori</p>
            <p class="mini-stat-val">{{ $kategoris->count() }}</p>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon blue">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Ada Keterangan</p>
            <p class="mini-stat-val">{{ $kategoris->filter(fn($k)=>$k->description)->count() }}</p>
        </div>
    </div>
</div>

{{-- TABLE CARD --}}
<div class="table-card">
    <div class="table-card-header">
        <div class="icon-box">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
        </div>
        <h3>Daftar Kategori Obat</h3>
        <span style="margin-left:auto;background:#f5f3ff;border:1px solid #c4b5fd;color:#6d28d9;font-size:0.78rem;font-weight:700;padding:0.25rem 0.75rem;border-radius:999px;">
            {{ $kategoris->count() }} Entri
        </span>
    </div>
    <div class="table-card-body">
        <table class="datatable" style="border:none;border-radius:0;">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Kode</th>
                    <th width="30%">Nama Kategori</th>
                    <th width="35%">Keterangan</th>
                    <th width="15%" style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategoris as $index => $k)
                <tr>
                    <td style="color:#9ca3af;font-size:0.85rem;font-weight:600;">{{ $index + 1 }}</td>
                    <td><span class="code-chip">{{ $k->category_code }}</span></td>
                    <td><span class="item-name">{{ $k->category_name }}</span></td>
                    <td><span class="desc-text">{{ $k->description ?? '—' }}</span></td>
                    <td>
                        <div class="action-group">
                            <button type="button" class="btn-icon-edit"
                                onclick="openEditModal({{ $k->id }}, '{{ addslashes($k->category_code) }}', '{{ addslashes($k->category_name) }}', '{{ addslashes($k->description ?? '') }}')">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                Edit
                            </button>
                            <form action="{{ route('kategori-obat.destroy', $k->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon-delete">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <svg width="56" height="56" fill="none" stroke="#9ca3af" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                            <p>Belum ada data kategori obat.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('modals')
<div id="addModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <div style="width:36px;height:36px;background:linear-gradient(135deg,#ede9fe,#f5f3ff);border-radius:0.6rem;display:flex;align-items:center;justify-content:center;color:#7c3aed;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <h3 class="modal-title">Tambah Kategori Baru</h3>
            </div>
            <button class="close-btn" onclick="closeModal('addModal')">&times;</button>
        </div>
        <form action="{{ route('kategori-obat.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="category_code">Kode Kategori <span style="color:#ef4444;">*</span></label>
                <input type="text" id="category_code" name="category_code" class="form-control" value="{{ old('category_code') }}" required placeholder="Contoh: KTG-001">
                @error('category_code') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="category_name">Nama Kategori <span style="color:#ef4444;">*</span></label>
                <input type="text" id="category_name" name="category_name" class="form-control" value="{{ old('category_name') }}" required placeholder="Contoh: Obat Tablet">
                @error('category_name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="description">Keterangan</label>
                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Keterangan opsional...">{{ old('description') }}</textarea>
                @error('description') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addModal')">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>

<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <div style="width:36px;height:36px;background:linear-gradient(135deg,#fef3c7,#fde68a);border-radius:0.6rem;display:flex;align-items:center;justify-content:center;color:#92400e;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </div>
                <h3 class="modal-title">Edit Kategori Obat</h3>
            </div>
            <button class="close-btn" onclick="closeModal('editModal')">&times;</button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_category_code">Kode Kategori <span style="color:#ef4444;">*</span></label>
                <input type="text" id="edit_category_code" name="category_code" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_category_name">Nama Kategori <span style="color:#ef4444;">*</span></label>
                <input type="text" id="edit_category_name" name="category_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_description">Keterangan</label>
                <textarea id="edit_description" name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editModal')">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    Update Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function openModal(modalId)  { $('#' + modalId).addClass('show'); }
    function closeModal(modalId) { $('#' + modalId).removeClass('show'); }
    $(window).click(function(e) { if ($(e.target).hasClass('modal')) { $(e.target).removeClass('show'); } });

    function openEditModal(id, code, nama, keterangan) {
        let url = "{{ route('kategori-obat.update', ':id') }}".replace(':id', id);
        $('#editForm').attr('action', url);
        $('#edit_category_code').val(code);
        $('#edit_category_name').val(nama);
        $('#edit_description').val(keterangan);
        openModal('editModal');
    }

    $(document).ready(function() {
        @if($errors->any() && !old('_method'))
            openModal('addModal');
        @endif
    });
</script>
@endpush
