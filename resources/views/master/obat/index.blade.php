@extends('layouts.app')

@section('title', 'Obat - Apotekku')
@section('page_title', 'Master Data Obat')

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
        <h3 style="margin: 0; color: var(--text-color); font-size: 1.25rem;">Daftar Obat</h3>
        <button type="button" class="btn btn-primary" onclick="openModal('addModalObat')">
            <svg style="margin-right: 0.5rem;" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Obat
        </button>
    </div>
    <div class="table-responsive">
        <table class="datatable">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">Kode</th>
                    <th width="20%">Nama Obat</th>
                    <th width="15%">Kategori</th>
                    <th width="10%">Satuan</th>
                    <th width="12%" style="text-align: right;">Harga Beli</th>
                    <th width="12%" style="text-align: right;">Harga Jual</th>
                    <th width="16%" style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($obats as $index => $o)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="color: #6b7280; font-family: monospace;">{{ $o->medicine_code }}</td>
                    <td style="font-weight: 600; color: var(--primary-color);">{{ $o->medicine_name }}</td>
                    <td style="color: #4b5563;">{{ optional($o->kategori)->category_name }}</td>
                    <td style="color: #4b5563;">{{ optional($o->satuan)->unit_name }}</td>
                    <td style="text-align: right;">Rp {{ number_format($o->purchase_price, 0, ',', '.') }}</td>
                    <td style="text-align: right;">Rp {{ number_format($o->selling_price, 0, ',', '.') }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem; justify-content: center;">
                            <button type="button" class="btn btn-edit btn-sm"
                                onclick="openEditObatModal({{ $o->id }}, '{{ addslashes($o->medicine_code) }}', '{{ addslashes($o->medicine_name) }}', {{ $o->category_id ?? 'null' }}, {{ $o->unit_id ?? 'null' }}, {{ $o->purchase_price }}, {{ $o->selling_price }})">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit
                            </button>
                            <form action="{{ route('obat.destroy', $o->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus obat ini?');">
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
                    <td colspan="8" style="text-align: center; color: #9ca3af; padding: 3rem;">Belum ada data obat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('modals')
<!-- Modal Tambah Obat -->
<div id="addModalObat" class="modal">
    <div class="modal-content modal-lg">
        <div class="modal-header">
            <h3 class="modal-title">Tambah Obat Baru</h3>
            <button class="close-btn" onclick="closeModal('addModalObat')">&times;</button>
        </div>
        <form action="{{ route('obat.store') }}" method="POST">
            @csrf
            
            <div class="grid-2-col">
                <div class="form-group">
                    <label for="kode_obat">Kode Obat <span style="color: #ef4444;">*</span></label>
                    <input type="text" id="kode_obat" name="kode_obat" class="form-control" value="{{ old('kode_obat') }}" required placeholder="Contoh: OBT-001">
                    @error('kode_obat') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="nama_obat">Nama Obat <span style="color: #ef4444;">*</span></label>
                    <input type="text" id="nama_obat" name="nama_obat" class="form-control" value="{{ old('nama_obat') }}" required placeholder="Contoh: Paracetamol 500mg">
                    @error('nama_obat') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="grid-2-col">
                <div class="form-group">
                    <label for="kategori_id">Kategori <span style="color: #ef4444;">*</span></label>
                    <select id="kategori_id" name="kategori_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach(\App\Models\KategoriObat::all() as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->category_name }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="satuan_id">Satuan <span style="color: #ef4444;">*</span></label>
                    <select id="satuan_id" name="satuan_id" class="form-control" required>
                        <option value="">-- Pilih Satuan --</option>
                        @foreach(\App\Models\Satuan::all() as $s)
                            <option value="{{ $s->id }}" {{ old('satuan_id') == $s->id ? 'selected' : '' }}>{{ $s->unit_name }}</option>
                        @endforeach
                    </select>
                    @error('satuan_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="grid-2-col">
                <div class="form-group">
                    <label for="harga_beli">Harga Beli (Rp) <span style="color: #ef4444;">*</span></label>
                    <input type="number" id="harga_beli" name="harga_beli" class="form-control" value="{{ old('harga_beli') }}" required min="0">
                    @error('harga_beli') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="harga_jual">Harga Jual (Rp) <span style="color: #ef4444;">*</span></label>
                    <input type="number" id="harga_jual" name="harga_jual" class="form-control" value="{{ old('harga_jual') }}" required min="0">
                    @error('harga_jual') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addModalObat')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Obat</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Obat -->
<div id="editModalObat" class="modal">
    <div class="modal-content modal-lg">
        <div class="modal-header">
            <h3 class="modal-title">Edit Obat</h3>
            <button class="close-btn" onclick="closeModal('editModalObat')">&times;</button>
        </div>
        <form id="editFormObat" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid-2-col">
                <div class="form-group">
                    <label for="edit_kode_obat">Kode Obat <span style="color: #ef4444;">*</span></label>
                    <input type="text" id="edit_kode_obat" name="kode_obat" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit_nama_obat">Nama Obat <span style="color: #ef4444;">*</span></label>
                    <input type="text" id="edit_nama_obat" name="nama_obat" class="form-control" required>
                </div>
            </div>

            <div class="grid-2-col">
                <div class="form-group">
                    <label for="edit_kategori_id">Kategori <span style="color: #ef4444;">*</span></label>
                    <select id="edit_kategori_id" name="kategori_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach(\App\Models\KategoriObat::all() as $k)
                            <option value="{{ $k->id }}">{{ $k->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_satuan_id">Satuan <span style="color: #ef4444;">*</span></label>
                    <select id="edit_satuan_id" name="satuan_id" class="form-control" required>
                        <option value="">-- Pilih Satuan --</option>
                        @foreach(\App\Models\Satuan::all() as $s)
                            <option value="{{ $s->id }}">{{ $s->unit_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid-2-col">
                <div class="form-group">
                    <label for="edit_harga_beli">Harga Beli (Rp) <span style="color: #ef4444;">*</span></label>
                    <input type="number" id="edit_harga_beli" name="harga_beli" class="form-control" required min="0">
                </div>
                <div class="form-group">
                    <label for="edit_harga_jual">Harga Jual (Rp) <span style="color: #ef4444;">*</span></label>
                    <input type="number" id="edit_harga_jual" name="harga_jual" class="form-control" required min="0">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editModalObat')">Batal</button>
                <button type="submit" class="btn btn-primary">Update Obat</button>
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

    function openEditObatModal(id, kode, nama, kat_id, sat_id, hargabeli, hargajual) {
        let actionUrl = "{{ route('obat.update', ':id') }}";
        actionUrl = actionUrl.replace(':id', id);
        
        $('#editFormObat').attr('action', actionUrl);
        $('#edit_kode_obat').val(kode);
        $('#edit_nama_obat').val(nama);
        $('#edit_kategori_id').val(kat_id);
        $('#edit_satuan_id').val(sat_id);
        $('#edit_harga_beli').val(hargabeli);
        $('#edit_harga_jual').val(hargajual);
        
        openModal('editModalObat');
    }

    $(document).ready(function() {
        @if($errors->any() && !old('_method'))
            openModal('addModalObat');
        @endif
    });
</script>
@endpush
