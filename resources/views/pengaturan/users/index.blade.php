@extends('layouts.app')

@section('page_title', 'User Management')

@section('content')
<div class="user-mgmt-container">
    <div class="user-mgmt-header animate__animated animate__fadeIn">
        <div class="header-left">
            <h1 class="page-title">User Management</h1>
            <p class="page-subtitle">Kelola akses staf, perawat, apoteker, dan kasir apotek.</p>
        </div>
        <div class="header-right">
            <button class="btn-create-user" onclick="openModal('modalCreateUser')">
                <i class="fas fa-user-plus me-2"></i> Tambah Akun Baru
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-emerald mb-4 animate__animated animate__fadeIn">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="user-grid mt-4 animate__animated animate__fadeInUp">
        @foreach($users as $user)
        <div class="user-card-premium">
            <div class="card-options">
                <button class="btn-option" onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->username) }}', '{{ $user->email }}', {{ $user->role_id }}, {{ $user->is_active }})">
                    <i class="fas fa-pen"></i>
                </button>
            </div>
            <div class="user-card-body">
                <div class="user-avatar-large {{ $user->is_active ? 'active' : 'inactive' }}">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                    <span class="status-dot"></span>
                </div>
                <h3 class="user-display-name">{{ $user->name }}</h3>
                <div class="user-role-badge role-{{ strtolower($user->role->role_name ?? 'default') }}">
                    <i class="fas fa-shield-alt me-1"></i> {{ $user->role->role_name ?? 'No Role' }}
                </div>
                
                <div class="user-meta-list mt-3">
                    <div class="meta-item">
                        <i class="fas fa-at"></i> {{ $user->username }}
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-envelope"></i> {{ $user->email }}
                    </div>
                </div>
            </div>
            <div class="user-card-footer">
                <span class="join-date">Terakhir update: {{ $user->updated_at ? $user->updated_at->diffForHumans() : 'Belum pernah' }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal Create User -->
<div class="modal-premium" id="modalCreateUser">
    <div class="modal-premium-content">
        <div class="modal-premium-header">
            <h3>Tambah Akun Pengguna</h3>
            <button class="btn-close-modal" onclick="closeModal('modalCreateUser')">&times;</button>
        </div>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="modal-premium-body">
                <div class="form-row">
                    <div class="form-group-premium">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" required placeholder="Contoh: Dr. Budi Santoso">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group-premium">
                        <label>Username</label>
                        <input type="text" name="username" required placeholder="username_login">
                    </div>
                    <div class="form-group-premium">
                        <label>Email</label>
                        <input type="email" name="email" required placeholder="user@apotek.com">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group-premium">
                        <label>Password</label>
                        <input type="password" name="password" required placeholder="Min. 6 karakter">
                    </div>
                    <div class="form-group-premium">
                        <label>Role / Jabatan</label>
                        <select name="role_id" required>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-check-premium mt-3">
                    <input type="checkbox" name="is_active" id="is_active_create" checked value="1">
                    <label for="is_active_create">Akun Langsung Aktif</label>
                </div>
            </div>
            <div class="modal-premium-footer">
                <button type="button" class="btn-premium-secondary" onclick="closeModal('modalCreateUser')">Batal</button>
                <button type="submit" class="btn-premium-primary">Simpan Akun</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal-premium" id="modalEditUser">
    <div class="modal-premium-content">
        <div class="modal-premium-header">
            <h3>Edit Akun Pengguna</h3>
            <button class="btn-close-modal" onclick="closeModal('modalEditUser')">&times;</button>
        </div>
        <form id="formEditUser" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-premium-body">
                <div class="form-row">
                    <div class="form-group-premium">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" id="edit_name" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group-premium">
                        <label>Username</label>
                        <input type="text" name="username" id="edit_username" required>
                    </div>
                    <div class="form-group-premium">
                        <label>Email</label>
                        <input type="email" name="email" id="edit_email" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group-premium">
                        <label>Password Baru (Opsional)</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah">
                    </div>
                    <div class="form-group-premium">
                        <label>Role / Jabatan</label>
                        <select name="role_id" id="edit_role_id" required>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-check-premium mt-3">
                    <input type="checkbox" name="is_active" id="edit_is_active" value="1">
                    <label for="edit_is_active">Akun Aktif</label>
                </div>
            </div>
            <div class="modal-premium-footer">
                <button type="button" class="btn-premium-secondary" onclick="closeModal('modalEditUser')">Batal</button>
                <button type="submit" class="btn-premium-primary">Update Akun</button>
            </div>
        </form>
    </div>
</div>

<style>
    :root {
        --primary-gold: #b45309;
        --light-gold: #fef3c7;
        --dark-gold: #92400e;
        --emerald-primary: #10b981;
        --emerald-dark: #065f46;
    }

    .user-mgmt-container { padding: 1.5rem; }
    .user-mgmt-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .page-title { font-size: 2rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.025em; }
    .page-subtitle { color: #64748b; margin-top: 0.25rem; font-size: 1rem; }
    
    .btn-create-user { background: #0f172a; color: white; padding: 0.875rem 1.5rem; border-radius: 0.75rem; font-weight: 700; border: none; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
    .btn-create-user:hover { background: #1e293b; transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }

    .user-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
    
    .user-card-premium { background: white; border-radius: 1.25rem; border: 1px solid #e2e8f0; position: relative; overflow: hidden; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .user-card-premium:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05); border-color: #cbd5e1; }
    
    .card-options { position: absolute; top: 1rem; right: 1rem; z-index: 10; }
    .btn-option { background: #f8fafc; border: 1px solid #e2e8f0; width: 2.25rem; height: 2.25rem; border-radius: 0.625rem; display: flex; align-items: center; justify-content: center; color: #64748b; cursor: pointer; transition: all 0.2s; }
    .btn-option:hover { background: #f1f5f9; color: #0f172a; }

    .user-card-body { padding: 2.5rem 1.5rem; text-align: center; }
    
    .user-avatar-large { width: 5.5rem; height: 5.5rem; border-radius: 2rem; background: #f1f5f9; margin: 0 auto 1.25rem; display: flex; align-items: center; justify-content: center; font-size: 2.25rem; font-weight: 800; color: #475569; position: relative; border: 4px solid white; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); }
    .user-avatar-large.active .status-dot { background: #10b981; }
    .user-avatar-large.inactive .status-dot { background: #94a3b8; }
    .status-dot { position: absolute; bottom: -2px; right: -2px; width: 1.25rem; height: 1.25rem; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }

    .user-display-name { font-size: 1.25rem; font-weight: 800; color: #1e293b; margin: 0 0 0.5rem; }
    
    .user-role-badge { display: inline-flex; align-items: center; padding: 0.35rem 1rem; border-radius: 99px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; }
    .role-admin { background: #ecfdf5; color: #065f46; }
    .role-kasir { background: #eff6ff; color: #1d4ed8; }
    .role-gudang { background: #fff7ed; color: #9a3412; }
    .role-default { background: #f1f5f9; color: #475569; }

    .user-meta-list { text-align: left; background: #f8fafc; border-radius: 0.75rem; padding: 0.75rem; border: 1px solid #f1f5f9; }
    .meta-item { display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #64748b; padding: 0.25rem 0; }
    .meta-item i { width: 1rem; text-align: center; color: #94a3b8; }

    .user-card-footer { padding: 1.25rem; border-top: 1px dashed #f1f5f9; text-align: center; background: #fafafa; }
    .join-date { font-size: 0.75rem; color: #94a3b8; font-weight: 600; }

    /* Modal Styles */
    .modal-premium { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center; z-index: 1000; padding: 1rem; }
    .modal-premium.show { display: flex; }
    .modal-premium-content { background: white; width: 100%; max-width: 600px; border-radius: 1.5rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: relative; animation: slideUp 0.3s ease-out; }
    
    @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

    .modal-premium-header { padding: 1.5rem 2rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
    .modal-premium-header h3 { font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0; }
    .btn-close-modal { background: none; border: none; font-size: 1.75rem; color: #94a3b8; cursor: pointer; line-height: 1; }
    
    .modal-premium-body { padding: 2rem; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem; }
    .form-group-premium { display: flex; flex-direction: column; gap: 0.5rem; }
    .form-group-premium label { font-size: 0.875rem; font-weight: 700; color: #475569; }
    .form-group-premium input, .form-group-premium select { padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1.5px solid #e2e8f0; font-size: 0.95rem; font-weight: 600; color: #1e293b; transition: all 0.2s; outline: none; }
    .form-group-premium input:focus { border-color: #0f172a; box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.05); }

    .form-check-premium { display: flex; align-items: center; gap: 0.75rem; cursor: pointer; }
    .form-check-premium input { width: 1.25rem; height: 1.25rem; cursor: pointer; accent-color: #0f172a; }
    .form-check-premium label { font-size: 0.95rem; font-weight: 600; color: #475569; cursor: pointer; }

    .modal-premium-footer { padding: 1.5rem 2rem; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 1rem; }
    .btn-premium-secondary { padding: 0.75rem 1.5rem; border-radius: 0.75rem; border: 1.5px solid #e2e8f0; background: white; font-weight: 700; color: #64748b; cursor: pointer; transition: all 0.2s; }
    .btn-premium-secondary:hover { background: #f8fafc; color: #0f172a; }
    .btn-premium-primary { padding: 0.75rem 1.75rem; border-radius: 0.75rem; border: none; background: #0f172a; color: white; font-weight: 700; cursor: pointer; transition: all 0.2s; }
    .btn-premium-primary:hover { background: #1e293b; transform: translateY(-1px); }

    .alert-emerald { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; border-radius: 1rem; padding: 1rem 1.5rem; font-weight: 600; font-size: 0.95rem; }

    @media (max-width: 640px) {
        .form-row { grid-template-columns: 1fr; }
        .user-mgmt-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
        .btn-create-user { width: 100%; }
    }
</style>

<script>
    function openModal(id) {
        document.getElementById(id).classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    function openEditModal(id, name, username, email, roleId, isActive) {
        const form = document.getElementById('formEditUser');
        form.action = `/users/${id}`;
        
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_username').value = username;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role_id').value = roleId;
        document.getElementById('edit_is_active').checked = isActive == 1;
        
        openModal('modalEditUser');
    }

    // Close on outside click
    window.onclick = function(event) {
        if (event.target.classList.contains('modal-premium')) {
            event.target.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    }
</script>
@endsection
