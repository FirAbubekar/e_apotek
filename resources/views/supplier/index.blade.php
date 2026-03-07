@extends('layouts.app')

@section('title', 'Supplier - Apotekku')
@section('page_title', 'Master Data Supplier')

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
        <h3 style="margin: 0; color: var(--text-color); font-size: 1.25rem;">Daftar Supplier</h3>
        <button type="button" class="btn btn-primary" onclick="openModal('addModalSupplier')">
            <svg style="margin-right: 0.5rem;" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Supplier
        </button>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="25%">Nama Supplier</th>
                    <th width="35%">Alamat</th>
                    <th width="15%">No Telp</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $index => $s)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-weight: 600; color: var(--primary-color);">{{ $s->nama_supplier }}</td>
                    <td style="color: #6b7280;">{{ $s->alamat }}</td>
                    <td style="color: #6b7280;">{{ $s->no_telp }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <button type="button" class="btn btn-edit btn-sm" 
                                onclick="openEditSupplierModal({{ $s->id }}, '{{ addslashes($s->nama_supplier) }}', '{{ addslashes($s->no_telp) }}', '{{ addslashes($s->alamat) }}')">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit
                            </button>
                            <form action="{{ route('supplier.destroy', $s->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus supplier ini?');">
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
                    <td colspan="5" style="text-align: center; color: #9ca3af; padding: 3rem;">Belum ada data supplier.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('modals')
<!-- Modal Tambah Supplier -->
<div id="addModalSupplier" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Tambah Supplier Baru</h3>
            <button class="close-btn" onclick="closeModal('addModalSupplier')">&times;</button>
        </div>
        <form action="{{ route('supplier.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_supplier">Nama Supplier <span style="color: #ef4444;">*</span></label>
                <input type="text" id="nama_supplier" name="nama_supplier" class="form-control" value="{{ old('nama_supplier') }}" required placeholder="Contoh: PT. Kimia Farma">
                @error('nama_supplier') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="no_telp">No Telp <span style="color: #ef4444;">*</span></label>
                <input type="text" id="no_telp" name="no_telp" class="form-control" value="{{ old('no_telp') }}" required placeholder="Contoh: 021-1234567">
                @error('no_telp') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="alamat_supplier">Alamat <span style="color: #ef4444;">*</span></label>
                <textarea id="alamat_supplier" name="alamat" class="form-control" rows="3" required placeholder="Alamat lengkap supplier...">{{ old('alamat') }}</textarea>
                @error('alamat') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addModalSupplier')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Supplier</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Supplier -->
<div id="editModalSupplier" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Edit Supplier</h3>
            <button class="close-btn" onclick="closeModal('editModalSupplier')">&times;</button>
        </div>
        <form id="editFormSupplier" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_nama_supplier">Nama Supplier <span style="color: #ef4444;">*</span></label>
                <input type="text" id="edit_nama_supplier" name="nama_supplier" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_no_telp">No Telp <span style="color: #ef4444;">*</span></label>
                <input type="text" id="edit_no_telp" name="no_telp" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_alamat_supplier">Alamat <span style="color: #ef4444;">*</span></label>
                <textarea id="edit_alamat_supplier" name="alamat" class="form-control" rows="3" required></textarea>
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
        window.openModal = function(modalId) { $('#' + modalId).addClass('show'); }
        window.closeModal = function(modalId) { $('#' + modalId).removeClass('show'); }
        $(window).click(function(event) { if ($(event.target).hasClass('modal')) { $(event.target).removeClass('show'); } });
    }

    function openEditSupplierModal(id, nama, telp, alamat) {
        let actionUrl = "{{ route('supplier.update', ':id') }}";
        actionUrl = actionUrl.replace(':id', id);
        
        $('#editFormSupplier').attr('action', actionUrl);
        $('#edit_nama_supplier').val(nama);
        $('#edit_no_telp').val(telp);
        $('#edit_alamat_supplier').val(alamat);
        
        openModal('editModalSupplier');
    }

    $(document).ready(function() {
        @if($errors->any() && !old('_method'))
            openModal('addModalSupplier');
        @endif
    });
</script>
@endpush
