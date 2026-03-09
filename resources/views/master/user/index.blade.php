@extends('layouts.app')

@section('title', 'User - Apotekku')
@section('page_title', 'Manajemen User')

@section('styles')
<style>
    .page-header-banner {
        background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 55%, #6366f1 100%);
        border-radius: 1.25rem; padding: 1.75rem 2rem; margin-bottom: 1.75rem;
        position: relative; overflow: hidden;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 10px 30px rgba(37,99,235,.25);
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
    .mini-stat-icon.blue   { background:linear-gradient(135deg,#dbeafe,#eff6ff); color:#2563eb; }
    .mini-stat-icon.indigo { background:linear-gradient(135deg,#e0e7ff,#eef2ff); color:#4338ca; }
    .mini-stat-lbl { font-size:.75rem; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; margin:0 0 .2rem; }
    .mini-stat-val { font-size:1.5rem; font-weight:800; color:var(--text-color); margin:0; line-height:1.1; }
    .table-card { background:#fff; border-radius:1.25rem; border:1px solid var(--border-color); box-shadow:0 4px 20px rgba(0,0,0,.04); overflow:hidden; }
    .table-card-header { padding:1.25rem 1.75rem; border-bottom:1px solid var(--border-color); display:flex; align-items:center; gap:.75rem; background:linear-gradient(to right,#fff,#eff6ff); }
    .table-card-header .icon-box { width:38px; height:38px; background:linear-gradient(135deg,#dbeafe,#eff6ff); border-radius:.65rem; display:flex; align-items:center; justify-content:center; color:#2563eb; }
    .table-card-header h3 { margin:0; font-size:1.05rem; font-weight:700; color:var(--text-color); }
    .table-card-body { padding:1.5rem 2rem 2rem; }
    .user-avatar-chip { width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,#dbeafe,#c7d2fe); display:inline-flex; align-items:center; justify-content:center; color:#3730a3; font-weight:800; font-size:.85rem; margin-right:.65rem; flex-shrink:0; border:2px solid #c7d2fe; }
    .user-name-wrap { display:flex; align-items:center; }
    .user-fullname { font-weight:700; color:#1e40af; font-size:.95rem; }
    .username-badge { display:inline-flex; align-items:center; gap:.25rem; background:#f1f5f9; border:1px solid #cbd5e1; border-radius:.4rem; padding:.15rem .55rem; font-family:monospace; font-size:.82rem; color:#475569; font-weight:600; }
    .role-badge { display:inline-block; padding:.2rem .65rem; border-radius:999px; font-size:.75rem; font-weight:700; }
    .role-admin { background:#dbeafe; color:#1d4ed8; }
    .role-kasir { background:#d1fae5; color:#065f46; }
    .role-default { background:#f3f4f6; color:#4b5563; }
    .you-badge { display:inline-block; background:#fef9c3; border:1px solid #fde047; border-radius:999px; font-size:.7rem; font-weight:700; color:#854d0e; padding:.1rem .5rem; margin-left:.4rem; }
    .action-group { display:flex; gap:.45rem; justify-content:center; }
    .btn-icon-edit, .btn-icon-delete { display:inline-flex; align-items:center; gap:.3rem; padding:.38rem .8rem; border-radius:.5rem; font-size:.78rem; font-weight:700; cursor:pointer; border:none; transition:all .2s; }
    .btn-icon-edit   { background:linear-gradient(135deg,#fef3c7,#fde68a); color:#92400e; border:1px solid #fcd34d; }
    .btn-icon-edit:hover { background:linear-gradient(135deg,#f59e0b,#d97706); color:#fff; border-color:#d97706; transform:translateY(-1px); box-shadow:0 4px 10px rgba(245,158,11,.3); }
    .btn-icon-delete { background:linear-gradient(135deg,#fee2e2,#fecaca); color:#991b1b; border:1px solid #fca5a5; }
    .btn-icon-delete:hover { background:linear-gradient(135deg,#ef4444,#dc2626); color:#fff; border-color:#dc2626; transform:translateY(-1px); box-shadow:0 4px 10px rgba(239,68,68,.3); }
    .empty-state { text-align:center; padding:4rem 2rem; color:#9ca3af; }
    .empty-state p { margin:0; font-size:.95rem; }
    table.dataTable tbody tr:hover > td { background:#eff6ff !important; }
</style>
@endsection

@section('content')
@if (session('success'))
    <div class="alert alert-success" style="margin-bottom:1.5rem;">
        <svg style="margin-right:.75rem;flex-shrink:0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger" style="margin-bottom:1.5rem;">
        <svg style="margin-right:.75rem;flex-shrink:0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('error') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger" style="margin-bottom:1.5rem;">
        <svg style="margin-right:.75rem;flex-shrink:0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Terdapat kesalahan. Silakan periksa kembali.
    </div>
@endif

<div class="page-header-banner">
    <div class="page-header-left">
        <h2>👥 Manajemen Akun User</h2>
        <p>Kelola akun pengguna sistem apotek, username, dan hak akses.</p>
    </div>
    <div class="page-header-right">
        <button type="button" class="btn-add-new" onclick="openModal('addModalUser')">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah User
        </button>
    </div>
</div>

<div class="mini-stats">
    <div class="mini-stat">
        <div class="mini-stat-icon blue">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Total User</p>
            <p class="mini-stat-val">{{ $users->count() }}</p>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon indigo">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        </div>
        <div>
            <p class="mini-stat-lbl">Akun Aktif</p>
            <p class="mini-stat-val">{{ $users->count() }}</p>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="table-card-header">
        <div class="icon-box">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
        </div>
        <h3>Daftar Akun Pengguna</h3>
        <span style="margin-left:auto;background:#eff6ff;border:1px solid #bfdbfe;color:#1d4ed8;font-size:.78rem;font-weight:700;padding:.25rem .75rem;border-radius:999px;">{{ $users->count() }} Akun</span>
    </div>
    <div class="table-card-body">
        <table class="datatable" style="border:none;border-radius:0;">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="35%">Nama Lengkap</th>
                    <th width="35%">Username</th>
                    <th width="25%" style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $u)
                <tr>
                    <td style="color:#9ca3af;font-size:.85rem;font-weight:600;">{{ $index + 1 }}</td>
                    <td>
                        <div class="user-name-wrap">
                            <div class="user-avatar-chip">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
                            <span class="user-fullname">{{ $u->name }}</span>
                            @if(auth()->id() === $u->id)
                                <span class="you-badge">Anda</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="username-badge">
                            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ $u->username }}
                        </span>
                    </td>
                    <td>
                        <div class="action-group">
                            <button type="button" class="btn-icon-edit" onclick="openEditUserModal({{ $u->id }},'{{ addslashes($u->name) }}','{{ addslashes($u->username) }}')">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                Edit
                            </button>
                            @if(auth()->id() !== $u->id)
                            <form action="{{ route('users.destroy', $u->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon-delete">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4"><div class="empty-state">
                    <svg width="56" height="56" fill="none" stroke="#9ca3af" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <p>Belum ada data user.</p>
                </div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('modals')
<div id="addModalUser" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div style="width:36px;height:36px;background:linear-gradient(135deg,#dbeafe,#eff6ff);border-radius:.6rem;display:flex;align-items:center;justify-content:center;color:#2563eb;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <h3 class="modal-title">Tambah User Baru</h3>
            </div>
            <button class="close-btn" onclick="closeModal('addModalUser')">&times;</button>
        </div>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nama Lengkap <span style="color:#ef4444;">*</span></label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso">
                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="username">Username <span style="color:#ef4444;">*</span></label>
                <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required placeholder="Contoh: budi.s">
                @error('username') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="password">Password <span style="color:#ef4444;">*</span></label>
                <input type="password" id="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                @error('password') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addModalUser')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan User</button>
            </div>
        </form>
    </div>
</div>

<div id="editModalUser" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div style="width:36px;height:36px;background:linear-gradient(135deg,#fef3c7,#fde68a);border-radius:.6rem;display:flex;align-items:center;justify-content:center;color:#92400e;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </div>
                <h3 class="modal-title">Edit Data User</h3>
            </div>
            <button class="close-btn" onclick="closeModal('editModalUser')">&times;</button>
        </div>
        <form id="editFormUser" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label for="edit_name">Nama Lengkap <span style="color:#ef4444;">*</span></label>
                <input type="text" id="edit_name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_username">Username <span style="color:#ef4444;">*</span></label>
                <input type="text" id="edit_username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_password">Password Baru</label>
                <input type="password" id="edit_password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin diubah">
                <div style="color:#6b7280;font-size:.8rem;margin-top:.25rem;">Biarkan kosong jika tidak ingin mengubah password.</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editModalUser')">Batal</button>
                <button type="submit" class="btn btn-primary">Update User</button>
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
    function openEditUserModal(id,name,username) {
        let url = "{{ route('users.update',':id') }}".replace(':id',id);
        $('#editFormUser').attr('action',url);
        $('#edit_name').val(name);
        $('#edit_username').val(username);
        $('#edit_password').val('');
        openModal('editModalUser');
    }
    $(document).ready(function() {
        @if($errors->any() && !old('_method')) openModal('addModalUser'); @endif
    });
</script>
@endpush
