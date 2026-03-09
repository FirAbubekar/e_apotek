@extends('layouts.app')

@section('title', 'Satuan Obat - Apotekku')
@section('page_title', 'Master Data Satuan Obat')

@section('styles')
<style>
    .page-header-banner {
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 60%, #0284c7 100%);
        border-radius: 1.25rem; padding: 1.75rem 2rem; margin-bottom: 1.75rem;
        position: relative; overflow: hidden;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 10px 30px rgba(13,148,136,.25);
    }
    .page-header-banner::before { content:''; position:absolute; top:-40px; right:-40px; width:200px; height:200px; background:rgba(255,255,255,.08); border-radius:50%; }
    .page-header-banner::after  { content:''; position:absolute; bottom:-60px; right:160px; width:150px; height:150px; background:rgba(255,255,255,.05); border-radius:50%; }
    .page-header-left { position:relative; z-index:1; }
    .page-header-left h2 { margin:0 0 .3rem; font-size:1.6rem; font-weight:800; color:#1a1a1a; }
    .page-header-left p  { margin:0; font-size:.9rem; color:rgba(0,0,0,0.60); }
    .page-header-right   { position:relative; z-index:1; }
    .btn-add-new { background:rgba(255,255,255,.18); backdrop-filter:blur(10px); border:1.5px solid rgba(255,255,255,.45); color:#fff; padding:.7rem 1.5rem; border-radius:.75rem; font-size:.9rem; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:.5rem; transition:all .2s; }
    .btn-add-new:hover { background:rgba(255,255,255,.3); transform:translateY(-2px); box-shadow:0 8px 20px rgba(0,0,0,.15); }
    .mini-stats { display:grid; grid-template-columns:repeat(2,1fr); gap:1.1rem; margin-bottom:1.75rem; }
    .mini-stat { background:#fff; border-radius:1rem; padding:1.2rem 1.5rem; display:flex; align-items:center; gap:1rem; border:1px solid var(--border-color); box-shadow:0 2px 12px rgba(0,0,0,.04); transition:transform .2s,box-shadow .2s; }
    .mini-stat:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,.08); }
    .mini-stat-icon { width:48px; height:48px; border-radius:.85rem; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .mini-stat-icon.teal { background:linear-gradient(135deg,#d1fae5,#ccfbf1); color:#0d9488; }
    .mini-stat-icon.cyan { background:linear-gradient(135deg,#cffafe,#ecfeff); color:#0891b2; }
    .mini-stat-lbl { font-size:.75rem; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; margin:0 0 .2rem; }
    .mini-stat-val { font-size:1.5rem; font-weight:800; color:var(--text-color); margin:0; line-height:1.1; }
    .table-card { background:#fff; border-radius:1.25rem; border:1px solid var(--border-color); box-shadow:0 4px 20px rgba(0,0,0,.04); overflow:hidden; }
    .table-card-header { padding:1.25rem 1.75rem; border-bottom:1px solid var(--border-color); display:flex; align-items:center; gap:.75rem; background:linear-gradient(to right,#fff,#f0fdfa); }
    .table-card-header .icon-box { width:38px; height:38px; background:linear-gradient(135deg,#ccfbf1,#d1fae5); border-radius:.65rem; display:flex; align-items:center; justify-content:center; color:#0d9488; }
    .table-card-header h3 { margin:0; font-size:1.05rem; font-weight:700; color:var(--text-color); }
    .table-card-body { padding:1.5rem 2rem 2rem; }
    .code-chip { display:inline-block; background:#f8fafc; border:1px solid #e2e8f0; border-radius:.4rem; padding:.15rem .55rem; font-family:monospace; font-size:.78rem; color:#475569; font-weight:600; }
    .unit-badge { display:inline-block; padding:.2rem .6rem; border-radius:.4rem; font-size:.78rem; font-weight:600; background:#f0fdfa; color:#0f766e; border:1px solid #99f6e4; }
    .desc-text  { font-size:.85rem; color:#6b7280; }
    .action-group { display:flex; gap:.45rem; justify-content:center; }
    .btn-icon-edit, .btn-icon-delete { display:inline-flex; align-items:center; gap:.3rem; padding:.38rem .8rem; border-radius:.5rem; font-size:.78rem; font-weight:700; cursor:pointer; border:none; transition:all .2s; }
    .btn-icon-edit   { background:linear-gradient(135deg,#fef3c7,#fde68a); color:#92400e; border:1px solid #fcd34d; }
    .btn-icon-edit:hover { background:linear-gradient(135deg,#f59e0b,#d97706); color:#fff; border-color:#d97706; transform:translateY(-1px); box-shadow:0 4px 10px rgba(245,158,11,.3); }
    .btn-icon-delete { background:linear-gradient(135deg,#fee2e2,#fecaca); color:#991b1b; border:1px solid #fca5a5; }
    .btn-icon-delete:hover { background:linear-gradient(135deg,#ef4444,#dc2626); color:#fff; border-color:#dc2626; transform:translateY(-1px); box-shadow:0 4px 10px rgba(239,68,68,.3); }
    .empty-state { text-align:center; padding:4rem 2rem; color:#9ca3af; }
    .empty-state p { margin:0; font-size:.95rem; }
    table.dataTable tbody tr:hover > td { background:#f0fdfa !important; }
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

<div class="page-header-banner">
    <div class="page-header-left">
        <h2>⚖️ Manajemen Satuan Obat</h2>
        <p>Kelola satuan ukuran obat seperti tablet, botol, strip, dan lainnya.</p>
    </div>
    <div class="page-header-right">
        <button type="button" class="btn-add-new" onclick="openModal('addModalSatuan')">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Satuan
        </button>
    </div>
</div>

<div class="mini-stats">
    <div class="mini-stat">
        <div class="mini-stat-icon teal">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Total Satuan</p>
            <p class="mini-stat-val">{{ $satuans->count() }}</p>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon cyan">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Ada Keterangan</p>
            <p class="mini-stat-val">{{ $satuans->filter(fn($s)=>$s->description)->count() }}</p>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="table-card-header">
        <div class="icon-box">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
        </div>
        <h3>Daftar Satuan Obat</h3>
        <span style="margin-left:auto;background:#f0fdfa;border:1px solid #99f6e4;color:#0f766e;font-size:.78rem;font-weight:700;padding:.25rem .75rem;border-radius:999px;">{{ $satuans->count() }} Entri</span>
    </div>
    <div class="table-card-body">
        <table class="datatable" style="border:none;border-radius:0;">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Kode</th>
                    <th width="25%">Nama Satuan</th>
                    <th width="40%">Keterangan</th>
                    <th width="15%" style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($satuans as $index => $s)
                <tr>
                    <td style="color:#9ca3af;font-size:.85rem;font-weight:600;">{{ $index + 1 }}</td>
                    <td><span class="code-chip">{{ $s->unit_code }}</span></td>
                    <td><span class="unit-badge">{{ $s->unit_name }}</span></td>
                    <td><span class="desc-text">{{ $s->description ?? '—' }}</span></td>
                    <td>
                        <div class="action-group">
                            <button type="button" class="btn-icon-edit" onclick="openEditSatuanModal({{ $s->id }},'{{ addslashes($s->unit_code) }}','{{ addslashes($s->unit_name) }}','{{ addslashes($s->description??'') }}')">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                Edit
                            </button>
                            <form action="{{ route('satuan.destroy', $s->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus satuan ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon-delete">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5"><div class="empty-state">
                    <svg width="56" height="56" fill="none" stroke="#9ca3af" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <p>Belum ada data satuan obat.</p>
                </div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('modals')
<div id="addModalSatuan" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div style="width:36px;height:36px;background:linear-gradient(135deg,#ccfbf1,#d1fae5);border-radius:.6rem;display:flex;align-items:center;justify-content:center;color:#0d9488;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <h3 class="modal-title">Tambah Satuan Baru</h3>
            </div>
            <button class="close-btn" onclick="closeModal('addModalSatuan')">&times;</button>
        </div>
        <form action="{{ route('satuan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="unit_code">Kode Satuan <span style="color:#ef4444;">*</span></label>
                <input type="text" id="unit_code" name="unit_code" class="form-control" value="{{ old('unit_code') }}" required placeholder="Contoh: STN-001">
                @error('unit_code') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="unit_name">Nama Satuan <span style="color:#ef4444;">*</span></label>
                <input type="text" id="unit_name" name="unit_name" class="form-control" value="{{ old('unit_name') }}" required placeholder="Contoh: Strip, Botol">
                @error('unit_name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="description">Keterangan</label>
                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Keterangan opsional...">{{ old('description') }}</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addModalSatuan')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Satuan</button>
            </div>
        </form>
    </div>
</div>

<div id="editModalSatuan" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div style="width:36px;height:36px;background:linear-gradient(135deg,#fef3c7,#fde68a);border-radius:.6rem;display:flex;align-items:center;justify-content:center;color:#92400e;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </div>
                <h3 class="modal-title">Edit Satuan Obat</h3>
            </div>
            <button class="close-btn" onclick="closeModal('editModalSatuan')">&times;</button>
        </div>
        <form id="editFormSatuan" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label for="edit_unit_code">Kode Satuan <span style="color:#ef4444;">*</span></label>
                <input type="text" id="edit_unit_code" name="unit_code" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_unit_name">Nama Satuan <span style="color:#ef4444;">*</span></label>
                <input type="text" id="edit_unit_name" name="unit_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_description">Keterangan</label>
                <textarea id="edit_description" name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editModalSatuan')">Batal</button>
                <button type="submit" class="btn btn-primary">Update Satuan</button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
    if (typeof openModal !== 'function') {
        window.openModal  = function(id) { $('#'+id).addClass('show'); }
        window.closeModal = function(id) { $('#'+id).removeClass('show'); }
        $(window).click(function(e) { if($(e.target).hasClass('modal')){ $(e.target).removeClass('show'); } });
    }
    function openEditSatuanModal(id,code,nama,keterangan) {
        let url = "{{ route('satuan.update',':id') }}".replace(':id',id);
        $('#editFormSatuan').attr('action',url);
        $('#edit_unit_code').val(code);
        $('#edit_unit_name').val(nama);
        $('#edit_description').val(keterangan);
        openModal('editModalSatuan');
    }
    $(document).ready(function() {
        @if($errors->any() && !old('_method')) openModal('addModalSatuan'); @endif
    });
</script>
@endpush
