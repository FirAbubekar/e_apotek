@extends('layouts.app')

@section('title', 'Supplier - Apotekku')
@section('page_title', 'Master Data Supplier')

@section('styles')
<style>
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
    .mini-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:1.1rem; margin-bottom:1.75rem; }
    .mini-stat { background:#fff; border-radius:1rem; padding:1.2rem 1.5rem; display:flex; align-items:center; gap:1rem; border:1px solid var(--border-color); box-shadow:0 2px 12px rgba(0,0,0,.04); transition:transform .2s,box-shadow .2s; }
    .mini-stat:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,.08); }
    .mini-stat-icon { width:48px; height:48px; border-radius:.85rem; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .mini-stat-icon.amber  { background:linear-gradient(135deg,#fef3c7,#fffbeb); color:#d97706; }
    .mini-stat-icon.red    { background:linear-gradient(135deg,#fee2e2,#fff5f5); color:#dc2626; }
    .mini-stat-icon.pink   { background:linear-gradient(135deg,#fce7f3,#fdf2f8); color:#be185d; }
    .mini-stat-lbl { font-size:.75rem; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; margin:0 0 .2rem; }
    .mini-stat-val { font-size:1.5rem; font-weight:800; color:var(--text-color); margin:0; line-height:1.1; }
    .table-card { background:#fff; border-radius:1.25rem; border:1px solid var(--border-color); box-shadow:0 4px 20px rgba(0,0,0,.04); overflow:hidden; }
    .table-card-header { padding:1.25rem 1.75rem; border-bottom:1px solid var(--border-color); display:flex; align-items:center; gap:.75rem; background:linear-gradient(to right,#fff,#fffbeb); }
    .table-card-header .icon-box { width:38px; height:38px; background:linear-gradient(135deg,#fef3c7,#fffbeb); border-radius:.65rem; display:flex; align-items:center; justify-content:center; color:#d97706; }
    .table-card-header h3 { margin:0; font-size:1.05rem; font-weight:700; color:var(--text-color); }
    .table-card-body { padding:1.5rem 2rem 2rem; }
    .code-chip  { display:inline-block; background:#f8fafc; border:1px solid #e2e8f0; border-radius:.4rem; padding:.15rem .55rem; font-family:monospace; font-size:.78rem; color:#475569; font-weight:600; }
    .sup-name   { font-weight:700; color:#b45309; font-size:.95rem; }
    .addr-text  { font-size:.83rem; color:#6b7280; max-width:220px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .phone-badge { display:inline-flex; align-items:center; gap:.3rem; background:#fff7ed; border:1px solid #fed7aa; border-radius:.4rem; padding:.15rem .5rem; font-size:.8rem; color:#c2410c; font-weight:600; }
    .action-group { display:flex; gap:.45rem; justify-content:center; }
    .btn-icon-edit, .btn-icon-delete { display:inline-flex; align-items:center; gap:.3rem; padding:.38rem .8rem; border-radius:.5rem; font-size:.78rem; font-weight:700; cursor:pointer; border:none; transition:all .2s; }
    .btn-icon-edit   { background:linear-gradient(135deg,#fef3c7,#fde68a); color:#92400e; border:1px solid #fcd34d; }
    .btn-icon-edit:hover { background:linear-gradient(135deg,#f59e0b,#d97706); color:#fff; border-color:#d97706; transform:translateY(-1px); box-shadow:0 4px 10px rgba(245,158,11,.3); }
    .btn-icon-delete { background:linear-gradient(135deg,#fee2e2,#fecaca); color:#991b1b; border:1px solid #fca5a5; }
    .btn-icon-delete:hover { background:linear-gradient(135deg,#ef4444,#dc2626); color:#fff; border-color:#dc2626; transform:translateY(-1px); box-shadow:0 4px 10px rgba(239,68,68,.3); }
    .empty-state { text-align:center; padding:4rem 2rem; color:#9ca3af; }
    .empty-state p { margin:0; font-size:.95rem; }
    table.dataTable tbody tr:hover > td { background:#fffbeb !important; }
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
        Terdapat kesalahan. Silakan periksa kembali.
    </div>
@endif

<div class="page-header-banner">
    <div class="header-content">
        <h2>
            <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            Manajemen Supplier
        </h2>
        <p>Kelola data pemasok / distributor obat apotek Anda di sini.</p>
    </div>
    <div class="page-header-right">
        <button type="button" class="btn btn-add-new" onclick="openModal('addModalSupplier')">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Supplier
        </button>
    </div>
</div>

<div class="mini-stats">
    <div class="mini-stat">
        <div class="mini-stat-icon amber">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Total Supplier</p>
            <p class="mini-stat-val">{{ $suppliers->count() }}</p>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon red">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Ada Telepon</p>
            <p class="mini-stat-val">{{ $suppliers->filter(fn($s)=>$s->phone)->count() }}</p>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon pink">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Ada Alamat</p>
            <p class="mini-stat-val">{{ $suppliers->filter(fn($s)=>$s->address)->count() }}</p>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="table-card-header">
        <div class="icon-box">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
        </div>
        <h3>Daftar Supplier</h3>
        <span style="margin-left:auto;background:#fff7ed;border:1px solid #fed7aa;color:#c2410c;font-size:.78rem;font-weight:700;padding:.25rem .75rem;border-radius:999px;">{{ $suppliers->count() }} Entri</span>
    </div>
    <div class="table-card-body">
        <table class="datatable" style="border:none;border-radius:0;">
            <thead>
                <tr>
                    <th width="4%">No</th>
                    <th width="12%">Kode</th>
                    <th width="22%">Nama Supplier</th>
                    <th width="35%">Alamat</th>
                    <th width="14%">No Telp</th>
                    <th width="13%" style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $index => $s)
                <tr>
                    <td style="color:#9ca3af;font-size:.85rem;font-weight:600;">{{ $index + 1 }}</td>
                    <td><span class="code-chip">{{ $s->supplier_code }}</span></td>
                    <td><span class="sup-name">{{ $s->supplier_name }}</span></td>
                    <td><span class="addr-text" title="{{ $s->address }}">{{ $s->address ?? '—' }}</span></td>
                    <td>
                        @if($s->phone)
                            <span class="phone-badge">
                                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $s->phone }}
                            </span>
                        @else
                            <span style="color:#9ca3af;font-size:.8rem;">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            <button type="button" class="btn-icon-edit" onclick="openEditSupplierModal({{ $s->id }},'{{ addslashes($s->supplier_code) }}','{{ addslashes($s->supplier_name) }}','{{ addslashes($s->phone) }}','{{ addslashes($s->address) }}')">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                Edit
                            </button>
                            <form action="{{ route('supplier.destroy', $s->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus supplier ini?');">
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
                <tr><td colspan="6"><div class="empty-state">
                    <svg width="56" height="56" fill="none" stroke="#9ca3af" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <p>Belum ada data supplier.</p>
                </div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('modals')
<div id="addModalSupplier" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div style="width:36px;height:36px;background:linear-gradient(135deg,#fef3c7,#fffbeb);border-radius:.6rem;display:flex;align-items:center;justify-content:center;color:#d97706;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <h3 class="modal-title">Tambah Supplier Baru</h3>
            </div>
            <button class="close-btn" onclick="closeModal('addModalSupplier')">&times;</button>
        </div>
        <form action="{{ route('supplier.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="supplier_code">Kode Supplier <span style="color:#ef4444;">*</span></label>
                <input type="text" id="supplier_code" name="supplier_code" class="form-control" value="{{ old('supplier_code') }}" required placeholder="Contoh: SUP-001">
                @error('supplier_code') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="supplier_name">Nama Supplier <span style="color:#ef4444;">*</span></label>
                <input type="text" id="supplier_name" name="supplier_name" class="form-control" value="{{ old('supplier_name') }}" required placeholder="Contoh: PT. Kimia Farma">
                @error('supplier_name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="phone">No Telp <span style="color:#ef4444;">*</span></label>
                <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" required placeholder="Contoh: 021-1234567">
                @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="address">Alamat <span style="color:#ef4444;">*</span></label>
                <textarea id="address" name="address" class="form-control" rows="3" required placeholder="Alamat lengkap supplier...">{{ old('address') }}</textarea>
                @error('address') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addModalSupplier')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Supplier</button>
            </div>
        </form>
    </div>
</div>

<div id="editModalSupplier" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div style="width:36px;height:36px;background:linear-gradient(135deg,#fef3c7,#fde68a);border-radius:.6rem;display:flex;align-items:center;justify-content:center;color:#92400e;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </div>
                <h3 class="modal-title">Edit Supplier</h3>
            </div>
            <button class="close-btn" onclick="closeModal('editModalSupplier')">&times;</button>
        </div>
        <form id="editFormSupplier" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label for="edit_supplier_code">Kode Supplier <span style="color:#ef4444;">*</span></label>
                <input type="text" id="edit_supplier_code" name="supplier_code" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_supplier_name">Nama Supplier <span style="color:#ef4444;">*</span></label>
                <input type="text" id="edit_supplier_name" name="supplier_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_phone">No Telp <span style="color:#ef4444;">*</span></label>
                <input type="text" id="edit_phone" name="phone" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_address">Alamat <span style="color:#ef4444;">*</span></label>
                <textarea id="edit_address" name="address" class="form-control" rows="3" required></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editModalSupplier')">Batal</button>
                <button type="submit" class="btn btn-primary">Update Supplier</button>
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
    function openEditSupplierModal(id,code,nama,telp,alamat) {
        let url = "{{ route('supplier.update',':id') }}".replace(':id',id);
        $('#editFormSupplier').attr('action',url);
        $('#edit_supplier_code').val(code);
        $('#edit_supplier_name').val(nama);
        $('#edit_phone').val(telp);
        $('#edit_address').val(alamat);
        openModal('editModalSupplier');
    }
    $(document).ready(function() {
        @if($errors->any() && !old('_method')) openModal('addModalSupplier'); @endif
    });
</script>
@endpush
