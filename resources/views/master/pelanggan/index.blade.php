@extends('layouts.app')

@section('title', 'Master Pelanggan - Apotekku')
@section('page_title', 'Master Pelanggan')

@section('styles')
<style>
    .page-header-banner {
        background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
        border-radius: 1.25rem; padding: 1.75rem 2rem; margin-bottom: 1.75rem;
        position: relative; overflow: hidden;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 10px 30px rgba(16,185,129,.25);
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
    .mini-stat-icon.green { background:linear-gradient(135deg,#d1fae5,#ecfdf5); color:#059669; }
    .mini-stat-icon.teal  { background:linear-gradient(135deg,#ccfbf1,#f0fdfa); color:#0d9488; }
    .mini-stat-lbl { font-size:.75rem; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; margin:0 0 .2rem; }
    .mini-stat-val { font-size:1.5rem; font-weight:800; color:var(--text-color); margin:0; line-height:1.1; }
    .table-card { background:#fff; border-radius:1.25rem; border:1px solid var(--border-color); box-shadow:0 4px 20px rgba(0,0,0,.04); overflow:hidden; }
    .table-card-header { padding:1.25rem 1.75rem; border-bottom:1px solid var(--border-color); display:flex; align-items:center; gap:.75rem; background:linear-gradient(to right,#fff,#ecfdf5); }
    .table-card-header .icon-box { width:38px; height:38px; background:linear-gradient(135deg,#d1fae5,#ecfdf5); border-radius:.65rem; display:flex; align-items:center; justify-content:center; color:#059669; }
    .table-card-header h3 { margin:0; font-size:1.05rem; font-weight:700; color:var(--text-color); }
    .table-card-body { padding:1.5rem 2rem 2rem; }
    .cust-avatar-chip { width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,#d1fae5,#a7f3d0); display:inline-flex; align-items:center; justify-content:center; color:#065f46; font-weight:800; font-size:.82rem; margin-right:.65rem; flex-shrink:0; border:2px solid #6ee7b7; }
    .cust-name-wrap { display:flex; align-items:center; }
    .cust-fullname { font-weight:700; color:#065f46; font-size:.95rem; }
    .phone-badge { display:inline-flex; align-items:center; gap:.3rem; background:#ecfdf5; border:1px solid #a7f3d0; border-radius:.4rem; padding:.15rem .5rem; font-size:.8rem; color:#065f46; font-weight:600; }
    .addr-text { font-size:.83rem; color:#6b7280; }
    .action-group { display:flex; gap:.45rem; justify-content:center; }
    .btn-icon-edit, .btn-icon-delete { display:inline-flex; align-items:center; gap:.3rem; padding:.38rem .8rem; border-radius:.5rem; font-size:.78rem; font-weight:700; cursor:pointer; border:none; transition:all .2s; }
    .btn-icon-edit   { background:linear-gradient(135deg,#fef3c7,#fde68a); color:#92400e; border:1px solid #fcd34d; }
    .btn-icon-edit:hover { background:linear-gradient(135deg,#f59e0b,#d97706); color:#fff; border-color:#d97706; transform:translateY(-1px); box-shadow:0 4px 10px rgba(245,158,11,.3); }
    .btn-icon-delete { background:linear-gradient(135deg,#fee2e2,#fecaca); color:#991b1b; border:1px solid #fca5a5; }
    .btn-icon-delete:hover { background:linear-gradient(135deg,#ef4444,#dc2626); color:#fff; border-color:#dc2626; transform:translateY(-1px); box-shadow:0 4px 10px rgba(239,68,68,.3); }
    .empty-state { text-align:center; padding:4rem 2rem; color:#9ca3af; }
    .empty-state p { margin:0; font-size:.95rem; }
    table.dataTable tbody tr:hover > td { background:#ecfdf5 !important; }
</style>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success" style="margin-bottom:1.5rem;">
        <svg style="margin-right:.75rem;flex-shrink:0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger" style="margin-bottom:1.5rem;">
        <svg style="margin-right:.75rem;flex-shrink:0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Terdapat kesalahan. Silakan periksa kembali.
    </div>
@endif

<div class="page-header-banner">
    <div class="page-header-left">
        <h2>🛒 Manajemen Data Pelanggan</h2>
        <p>Kelola data pelanggan tetap apotek, no. HP, dan alamat mereka.</p>
    </div>
    <div class="page-header-right">
        <button class="btn-add-new" onclick="openModal('addModal')">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Pelanggan
        </button>
    </div>
</div>

<div class="mini-stats">
    <div class="mini-stat">
        <div class="mini-stat-icon green">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Total Pelanggan</p>
            <p class="mini-stat-val">{{ $customers->count() }}</p>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon teal">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Ada No. HP</p>
            <p class="mini-stat-val">{{ $customers->filter(fn($c)=>$c->no_hp)->count() }}</p>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="table-card-header">
        <div class="icon-box">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
        </div>
        <h3>Daftar Pelanggan</h3>
        <span style="margin-left:auto;background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46;font-size:.78rem;font-weight:700;padding:.25rem .75rem;border-radius:999px;">{{ $customers->count() }} Pelanggan</span>
    </div>
    <div class="table-card-body">
        <table class="datatable" style="border:none;border-radius:0;">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="30%">Nama Pelanggan</th>
                    <th width="18%">No HP</th>
                    <th width="32%">Alamat</th>
                    <th width="15%" style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $index => $customer)
                <tr>
                    <td style="color:#9ca3af;font-size:.85rem;font-weight:600;">{{ $index + 1 }}</td>
                    <td>
                        <div class="cust-name-wrap">
                            <div class="cust-avatar-chip">{{ strtoupper(substr($customer->nama, 0, 1)) }}</div>
                            <span class="cust-fullname">{{ $customer->nama }}</span>
                        </div>
                    </td>
                    <td>
                        @if($customer->no_hp)
                            <span class="phone-badge">
                                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $customer->no_hp }}
                            </span>
                        @else
                            <span style="color:#9ca3af;font-size:.8rem;">—</span>
                        @endif
                    </td>
                    <td><span class="addr-text">{{ Str::limit($customer->alamat ?? '—', 50) }}</span></td>
                    <td style="text-align:center;">
                        <div class="action-group">
                            <button class="btn-icon-edit" onclick="openEditModal({{ $customer->toJson() }})">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                Edit
                            </button>
                            <button class="btn-icon-delete" onclick="openDeleteModal({{ $customer->id }})">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5"><div class="empty-state">
                    <svg width="56" height="56" fill="none" stroke="#9ca3af" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <p>Belum ada data pelanggan.</p>
                </div></td></tr>
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
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div style="width:36px;height:36px;background:linear-gradient(135deg,#d1fae5,#ecfdf5);border-radius:.6rem;display:flex;align-items:center;justify-content:center;color:#059669;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <h3 class="modal-title">Tambah Pelanggan Baru</h3>
            </div>
            <button type="button" class="close-btn" onclick="closeModal('addModal')">&times;</button>
        </div>
        <form action="{{ route('pelanggan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama">Nama Pelanggan <span style="color:#ef4444;">*</span></label>
                <input type="text" name="nama" id="nama" class="form-control" required placeholder="Masukkan nama pelanggan">
            </div>
            <div class="form-group">
                <label for="no_hp">No HP</label>
                <input type="text" name="no_hp" id="no_hp" class="form-control" placeholder="Contoh: 08123456789">
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" rows="3" class="form-control" placeholder="Masukkan alamat lengkap"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addModal')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Pelanggan</button>
            </div>
        </form>
    </div>
</div>

<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div style="width:36px;height:36px;background:linear-gradient(135deg,#fef3c7,#fde68a);border-radius:.6rem;display:flex;align-items:center;justify-content:center;color:#92400e;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </div>
                <h3 class="modal-title">Edit Data Pelanggan</h3>
            </div>
            <button type="button" class="close-btn" onclick="closeModal('editModal')">&times;</button>
        </div>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label for="edit_nama">Nama Pelanggan <span style="color:#ef4444;">*</span></label>
                <input type="text" name="nama" id="edit_nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_no_hp">No HP</label>
                <input type="text" name="no_hp" id="edit_no_hp" class="form-control">
            </div>
            <div class="form-group">
                <label for="edit_alamat">Alamat</label>
                <textarea name="alamat" id="edit_alamat" rows="3" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editModal')">Batal</button>
                <button type="submit" class="btn btn-primary">Update Pelanggan</button>
            </div>
        </form>
    </div>
</div>

<div id="deleteModal" class="modal">
    <div class="modal-content" style="max-width:400px;text-align:center;">
        <div style="margin-bottom:1.5rem;color:#ef4444;">
            <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <h3 style="margin-top:0;color:var(--text-color);">Konfirmasi Hapus</h3>
        <p style="color:#6b7280;margin-bottom:2rem;">Apakah Anda yakin ingin menghapus pelanggan ini? Data tidak dapat dikembalikan.</p>
        <form id="deleteForm" method="POST" style="display:flex;justify-content:center;gap:1rem;">
            @csrf @method('DELETE')
            <button type="button" class="btn btn-secondary" onclick="closeModal('deleteModal')" style="min-width:100px;">Batal</button>
            <button type="submit" class="btn btn-delete" style="min-width:100px;">Ya, Hapus</button>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function openModal(modalId)  { document.getElementById(modalId).classList.add('show'); }
    function closeModal(modalId) { document.getElementById(modalId).classList.remove('show'); }
    function openEditModal(customer) {
        document.getElementById('edit_nama').value  = customer.nama;
        document.getElementById('edit_no_hp').value = customer.no_hp || '';
        document.getElementById('edit_alamat').value = customer.alamat || '';
        document.getElementById('editForm').action = `/pelanggan/${customer.id}`;
        openModal('editModal');
    }
    function openDeleteModal(id) {
        document.getElementById('deleteForm').action = `/pelanggan/${id}`;
        openModal('deleteModal');
    }
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) { event.target.classList.remove('show'); }
    }
</script>
@endpush
