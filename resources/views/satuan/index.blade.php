@extends('layouts.app')

@section('title', 'Satuan Obat - Apotekku')
@section('page_title', 'Master Data Satuan Obat')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        <svg style="margin-right: 0.75rem" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        {{ session('success') }}
    </div>
@endif

<!-- Validation Errors Alert -->
@if ($errors->any())
    <div class="alert alert-danger">
        <svg style="margin-right: 0.75rem" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h3 style="margin: 0; color: var(--text-color); font-size: 1.25rem;">Daftar Satuan Obat</h3>
        <button type="button" class="btn btn-primary" onclick="openModal('addModalSatuan')">
            <svg style="margin-right: 0.5rem;" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Satuan
        </button>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="30%">Nama Satuan</th>
                    <th width="45%">Keterangan</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($satuans as $index => $s)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-weight: 600; color: var(--primary-color);">{{ $s->nama_satuan }}</td>
                    <td style="color: #6b7280;">{{ $s->keterangan ?? '-' }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <button type="button" class="btn btn-edit btn-sm"
                                onclick="openEditSatuanModal({{ $s->id }}, '{{ addslashes($s->nama_satuan) }}', '{{ addslashes($s->keterangan ?? '') }}')">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit
                            </button>
                            <form action="{{ route('satuan.destroy', $s->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus satuan ini?');">
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
                    <td colspan="4" style="text-align: center; color: #9ca3af; padding: 3rem;">Belum ada data satuan obat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('modals')
<!-- Modal Tambah Satuan -->
<div id="addModalSatuan" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Tambah Satuan Baru</h3>
            <button class="close-btn" onclick="closeModal('addModalSatuan')">&times;</button>
        </div>
        <form action="{{ route('satuan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_satuan">Nama Satuan <span style="color: #ef4444;">*</span></label>
                <input type="text" id="nama_satuan" name="nama_satuan" class="form-control" value="{{ old('nama_satuan') }}" required placeholder="Contoh: Strip, Botol">
                @error('nama_satuan') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="keterangan_satuan">Keterangan</label>
                <textarea id="keterangan_satuan" name="keterangan" class="form-control" rows="3" placeholder="Keterangan opsional...">{{ old('keterangan') }}</textarea>
                @error('keterangan') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addModalSatuan')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Satuan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Satuan -->
<div id="editModalSatuan" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Edit Satuan Obat</h3>
            <button class="close-btn" onclick="closeModal('editModalSatuan')">&times;</button>
        </div>
        <form id="editFormSatuan" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_nama_satuan">Nama Satuan <span style="color: #ef4444;">*</span></label>
                <input type="text" id="edit_nama_satuan" name="nama_satuan" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_keterangan_satuan">Keterangan</label>
                <textarea id="edit_keterangan_satuan" name="keterangan" class="form-control" rows="3"></textarea>
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
    // Note: openModal and closeModal are globally defined in app.blade.php / or another index, 
    // but we can redefine/ensure they exist if this is the only page loaded.
    if (typeof openModal !== 'function') {
        window.openModal = function(modalId) { $('#' + modalId).addClass('show'); }
        window.closeModal = function(modalId) { $('#' + modalId).removeClass('show'); }
        $(window).click(function(event) { if ($(event.target).hasClass('modal')) { $(event.target).removeClass('show'); } });
    }

    function openEditSatuanModal(id, nama, keterangan) {
        let actionUrl = "{{ route('satuan.update', ':id') }}";
        actionUrl = actionUrl.replace(':id', id);
        
        $('#editFormSatuan').attr('action', actionUrl);
        $('#edit_nama_satuan').val(nama);
        $('#edit_keterangan_satuan').val(keterangan);
        
        openModal('editModalSatuan');
    }

    $(document).ready(function() {
        @if($errors->any() && !old('_method'))
            openModal('addModalSatuan');
        @endif
    });
</script>
@endpush
