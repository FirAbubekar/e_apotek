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
        <table class="datatable">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Kode Supplier</th>
                    <th width="25%">Nama Supplier</th>
                    <th width="35%">Alamat</th>
                    <th width="15%">No Telp</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $index => $s)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="color: #6b7280; font-family: monospace;">{{ $s->supplier_code }}</td>
                    <td style="font-weight: 600; color: var(--primary-color);">{{ $s->supplier_name }}</td>
                    <td style="color: #6b7280;">{{ $s->address }}</td>
                    <td style="color: #6b7280;">{{ $s->phone }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <button type="button" class="btn btn-edit btn-sm" 
                                onclick="openEditSupplierModal({{ $s->id }}, '{{ addslashes($s->supplier_code) }}', '{{ addslashes($s->supplier_name) }}', '{{ addslashes($s->phone) }}', '{{ addslashes($s->address) }}')">
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
                    <td colspan="6" style="text-align: center; color: #9ca3af; padding: 3rem;">Belum ada data supplier.</td>
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
                <label for="supplier_code">Kode Supplier <span style="color: #ef4444;">*</span></label>
                <input type="text" id="supplier_code" name="supplier_code" class="form-control" value="{{ old('supplier_code') }}" required placeholder="Contoh: SUP-001">
                @error('supplier_code') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="supplier_name">Nama Supplier <span style="color: #ef4444;">*</span></label>
                <input type="text" id="supplier_name" name="supplier_name" class="form-control" value="{{ old('supplier_name') }}" required placeholder="Contoh: PT. Kimia Farma">
                @error('supplier_name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="phone">No Telp <span style="color: #ef4444;">*</span></label>
                <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" required placeholder="Contoh: 021-1234567">
                @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="address">Alamat <span style="color: #ef4444;">*</span></label>
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
                <label for="edit_supplier_code">Kode Supplier <span style="color: #ef4444;">*</span></label>
                <input type="text" id="edit_supplier_code" name="supplier_code" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_supplier_name">Nama Supplier <span style="color: #ef4444;">*</span></label>
                <input type="text" id="edit_supplier_name" name="supplier_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_phone">No Telp <span style="color: #ef4444;">*</span></label>
                <input type="text" id="edit_phone" name="phone" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_address">Alamat <span style="color: #ef4444;">*</span></label>
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
        window.openModal = function(modalId) { $('#' + modalId).addClass('show'); }
        window.closeModal = function(modalId) { $('#' + modalId).removeClass('show'); }
        $(window).click(function(event) { if ($(event.target).hasClass('modal')) { $(event.target).removeClass('show'); } });
    }

    function openEditSupplierModal(id, code, nama, telp, alamat) {
        let actionUrl = "{{ route('supplier.update', ':id') }}";
        actionUrl = actionUrl.replace(':id', id);
        
        $('#editFormSupplier').attr('action', actionUrl);
        $('#edit_supplier_code').val(code);
        $('#edit_supplier_name').val(nama);
        $('#edit_phone').val(telp);
        $('#edit_address').val(alamat);
        
        openModal('editModalSupplier');
    }

    $(document).ready(function() {
        @if($errors->any() && !old('_method'))
            openModal('addModalSupplier');
        @endif
    });
</script>
@endpush
