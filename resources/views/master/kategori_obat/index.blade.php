@extends('layouts.app')

@section('title', 'Kategori Obat - Apotekku')
@section('page_title', 'Master Data Kategori Obat')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        <svg style="margin-right: 0.75rem" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        {{ session('success') }}
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
        <h3 style="margin: 0; color: var(--text-color); font-size: 1.25rem;">Daftar Kategori Obat</h3>
        <button type="button" class="btn btn-primary" onclick="openModal('addModal')">
            <svg style="margin-right: 0.5rem;" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Kategori
        </button>
    </div>
    <div class="table-responsive">
        <table class="datatable">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Kode Kategori</th>
                    <th width="30%">Nama Kategori</th>
                    <th width="30%">Keterangan</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategoris as $index => $k)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="color: #6b7280; font-family: monospace;">{{ $k->category_code }}</td>
                    <td style="font-weight: 600; color: var(--primary-color);">{{ $k->category_name }}</td>
                    <td style="color: #6b7280;">{{ $k->description ?? '-' }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <button type="button" class="btn btn-edit btn-sm"
                                onclick="openEditModal({{ $k->id }}, '{{ addslashes($k->category_code) }}', '{{ addslashes($k->category_name) }}', '{{ addslashes($k->description ?? '') }}')">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit
                            </button>
                            <form action="{{ route('kategori-obat.destroy', $k->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete btn-sm">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #9ca3af; padding: 3rem;">Belum ada data kategori obat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('modals')
<!-- Modal Tambah -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Tambah Kategori Baru</h3>
            <button class="close-btn" onclick="closeModal('addModal')">&times;</button>
        </div>
        <form action="{{ route('kategori-obat.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="category_code">Kode Kategori <span style="color: #ef4444;">*</span></label>
                <input type="text" id="category_code" name="category_code" class="form-control" value="{{ old('category_code') }}" required placeholder="Contoh: KTG-001">
                @error('category_code') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="category_name">Nama Kategori <span style="color: #ef4444;">*</span></label>
                <input type="text" id="category_name" name="category_name" class="form-control" value="{{ old('category_name') }}" required placeholder="Contoh: Obat Bebas">
                @error('category_name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="description">Keterangan</label>
                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Keterangan opsional...">{{ old('description') }}</textarea>
                @error('description') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addModal')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Edit Kategori Obat</h3>
            <button class="close-btn" onclick="closeModal('editModal')">&times;</button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_category_code">Kode Kategori <span style="color: #ef4444;">*</span></label>
                <input type="text" id="edit_category_code" name="category_code" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_category_name">Nama Kategori <span style="color: #ef4444;">*</span></label>
                <input type="text" id="edit_category_name" name="category_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_description">Keterangan</label>
                <textarea id="edit_description" name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editModal')">Batal</button>
                <button type="submit" class="btn btn-primary">Update Kategori</button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
    // General Modal Functions
    function openModal(modalId) {
        $('#' + modalId).addClass('show');
    }

    function closeModal(modalId) {
        $('#' + modalId).removeClass('show');
    }

    // Close modal when clicking outside of it
    $(window).click(function(event) {
        if ($(event.target).hasClass('modal')) {
            $(event.target).removeClass('show');
        }
    });

    // specific to Kategori Obat
    function openEditModal(id, code, nama, keterangan) {
        // Set Action URL directly replacing a dummy ID with the real ID
        let actionUrl = "{{ route('kategori-obat.update', ':id') }}";
        actionUrl = actionUrl.replace(':id', id);
        
        $('#editForm').attr('action', actionUrl);
        $('#edit_category_code').val(code);
        $('#edit_category_name').val(nama);
        $('#edit_description').val(keterangan);
        
        openModal('editModal');
    }

    // Auto-open Add modal if there are validation errors on creation
    $(document).ready(function() {
        @if($errors->any() && !old('_method'))
            openModal('addModal');
        @endif
    });
</script>
@endpush
