@extends('layouts.app')

@section('title', 'User - Apotekku')
@section('page_title', 'Manajemen User')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        <svg style="margin-right: 0.75rem" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        <svg style="margin-right: 0.75rem" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <svg style="margin-right: 0.75rem" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h3 style="margin: 0; color: var(--text-color); font-size: 1.25rem;">Daftar Akun Pengguna</h3>
        <button type="button" class="btn btn-primary" onclick="openModal('addModalUser')">
            <svg style="margin-right: 0.5rem;" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah User
        </button>
    </div>
    <div class="table-responsive">
        <table class="datatable">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="35%">Nama Lengkap</th>
                    <th width="35%">Username</th>
                    <th width="25%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $u)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-weight: 600; color: var(--primary-color);">{{ $u->name }}</td>
                    <td style="color: #6b7280;">{{ $u->username }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <button type="button" class="btn btn-edit btn-sm"
                                onclick="openEditUserModal({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ addslashes($u->username) }}')">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit
                            </button>
                            @if(auth()->id() !== $u->id)
                            <form action="{{ route('users.destroy', $u->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete btn-sm">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #9ca3af; padding: 3rem;">Belum ada data user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('modals')
<!-- Modal Tambah User -->
<div id="addModalUser" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Tambah User Baru</h3>
            <button class="close-btn" onclick="closeModal('addModalUser')">&times;</button>
        </div>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nama Lengkap <span style="color: #ef4444;">*</span></label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso">
                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="username">Username <span style="color: #ef4444;">*</span></label>
                <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required placeholder="Contoh: budi.s">
                @error('username') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="password">Password <span style="color: #ef4444;">*</span></label>
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

<!-- Modal Edit User -->
<div id="editModalUser" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Edit User</h3>
            <button class="close-btn" onclick="closeModal('editModalUser')">&times;</button>
        </div>
        <form id="editFormUser" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_name">Nama Lengkap <span style="color: #ef4444;">*</span></label>
                <input type="text" id="edit_name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_username">Username <span style="color: #ef4444;">*</span></label>
                <input type="text" id="edit_username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_password">Password Baru</label>
                <input type="password" id="edit_password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin diubah">
                <div style="color: #6b7280; font-size: 0.8rem; margin-top: 0.25rem;">Biarkan kosong jika tidak ingin mengubah password.</div>
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
        window.openModal = function(modalId) { $('#' + modalId).addClass('show'); }
        window.closeModal = function(modalId) { $('#' + modalId).removeClass('show'); }
        $(window).click(function(event) { if ($(event.target).hasClass('modal')) { $(event.target).removeClass('show'); } });
    }

    function openEditUserModal(id, name, username) {
        let actionUrl = "{{ route('users.update', ':id') }}";
        actionUrl = actionUrl.replace(':id', id);
        
        $('#editFormUser').attr('action', actionUrl);
        $('#edit_name').val(name);
        $('#edit_username').val(username);
        // Clear password field whenever opening edit modal
        $('#edit_password').val('');
        
        openModal('editModalUser');
    }

    $(document).ready(function() {
        @if($errors->any() && !old('_method'))
            openModal('addModalUser');
        @endif
    });
</script>
@endpush
