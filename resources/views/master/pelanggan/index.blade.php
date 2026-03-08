@extends('layouts.app')

@section('title', 'Master Pelanggan - Apotekku')
@section('page_title', 'Master Pelanggan')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 style="margin: 0; font-size: 1.1rem; color: var(--text-color);">Data Pelanggan</h3>
            <button class="btn btn-primary" onclick="openModal('addModal')">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Pelanggan
            </button>
        </div>

        @if(session('success'))
            <div style="padding: 1rem 2rem 0;">
                <div class="alert alert-success">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        
        @if($errors->any())
            <div style="padding: 1rem 2rem 0;">
                <div class="alert alert-danger">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="table-responsive">
            <table class="datatable">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Pelanggan</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th width="15%" style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $index => $customer)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td style="font-weight: 500;">{{ $customer->nama }}</td>
                            <td>{{ $customer->no_hp ?? '-' }}</td>
                            <td>{{ Str::limit($customer->alamat ?? '-', 50) }}</td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                    <button class="btn btn-edit btn-sm" onclick="openEditModal({{ $customer->toJson() }})" title="Edit">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <button class="btn btn-delete btn-sm" onclick="openDeleteModal({{ $customer->id }})" title="Hapus">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #6b7280; padding: 2rem;">
                                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-bottom: 1rem; opacity: 0.5;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <p>Belum ada data pelanggan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('modals')
    <!-- Add Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Pelanggan Baru</h3>
                <button type="button" class="close-btn" onclick="closeModal('addModal')">&times;</button>
            </div>
            <form action="{{ route('pelanggan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Pelanggan <span style="color:red">*</span></label>
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

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Data Pelanggan</h3>
                <button type="button" class="close-btn" onclick="closeModal('editModal')">&times;</button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="edit_nama">Nama Pelanggan <span style="color:red">*</span></label>
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
                    <button type="submit" class="btn btn-primary" style="background-color: #f59e0b;">Update Pelanggan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content" style="max-width: 400px; text-align: center;">
            <div style="margin-bottom: 1.5rem; color: #ef4444;">
                <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 style="margin-top: 0; color: var(--text-color);">Konfirmasi Hapus</h3>
            <p style="color: #6b7280; margin-bottom: 2rem;">Apakah Anda yakin ingin menghapus pelanggan ini? Data yang dihapus tidak dapat dikembalikan.</p>
            
            <form id="deleteForm" method="POST" style="display: flex; justify-content: center; gap: 1rem;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary" onclick="closeModal('deleteModal')" style="min-width: 100px;">Batal</button>
                <button type="submit" class="btn btn-delete" style="min-width: 100px;">Ya, Hapus</button>
            </form>
        </div>
    </div>
@endpush

@push('scripts')
<script>
    // Modal Management Functions
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('show');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('show');
    }

    function openEditModal(customer) {
        document.getElementById('edit_nama').value = customer.nama;
        document.getElementById('edit_no_hp').value = customer.no_hp || '';
        document.getElementById('edit_alamat').value = customer.alamat || '';
        
        document.getElementById('editForm').action = `/pelanggan/${customer.id}`;
        
        openModal('editModal');
    }

    function openDeleteModal(id) {
        document.getElementById('deleteForm').action = `/pelanggan/${id}`;
        openModal('deleteModal');
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.classList.remove('show');
        }
    }
</script>
@endpush
