@extends('layouts.app')

@section('title', 'Profil Apotek - Apotekku')
@section('page_title', 'Pengaturan > Profil Apotek')

@section('styles')
<style>
    /* ===== PAGE HEADER ===== */
    .page-header-banner {
        background: linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #14b8a6 100%);
        border-radius: 1.25rem;
        padding: 1.75rem 2rem;
        margin-bottom: 1.75rem;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 10px 30px rgba(13, 148, 136, 0.25);
    }
    .page-header-banner::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.07);
        border-radius: 50%;
    }
    .page-header-banner::after {
        content: '';
        position: absolute;
        bottom: -60px;
        right: 180px;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .page-header-left { position: relative; z-index: 1; }
    .page-header-left h2 {
        margin: 0 0 0.3rem 0;
        font-size: 1.6rem;
        font-weight: 800;
        color: #fff;
    }
    .page-header-left p {
        margin: 0;
        font-size: 0.95rem;
        color: rgba(255,255,255,0.85);
    }

    /* ===== PROFILE LAYOUT ===== */
    .profile-container {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 2rem;
        align-items: flex-start;
    }

    .card-modern {
        background: #fff;
        border-radius: 1.25rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }
    .card-modern::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 6px; height: 100%;
        background: linear-gradient(to bottom, #0f766e, #14b8a6);
    }
    
    .card-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px dashed #e5e7eb;
    }
    .card-header h3 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 700;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* ===== LOGO UPLOAD ===== */
    .logo-preview-wrapper {
        width: 100%;
        aspect-ratio: 1;
        border-radius: 1rem;
        border: 2px dashed #cbd5e1;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 1rem;
    }
    .logo-preview-wrapper:hover {
        border-color: #0f766e;
        background: #f0fdfa;
    }
    .logo-preview-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0; left: 0;
        z-index: 10;
    }
    .logo-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        color: #64748b;
        position: relative;
        z-index: 5;
    }
    .logo-placeholder svg { width: 40px; height: 40px; stroke: #94a3b8; }
    .logo-input {
        opacity: 0;
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        cursor: pointer;
        z-index: 20;
    }
    .logo-helper { font-size: 0.8rem; color: #94a3b8; text-align: center; }

    /* ===== FORM STYLES ===== */
    .form-group { margin-bottom: 1.25rem; }
    .form-group label {
        display: block;
        margin-bottom: 0.4rem;
        font-weight: 600;
        font-size: 0.9rem;
        color: #4b5563;
    }
    .modern-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px solid var(--border-color);
        border-radius: 0.75rem;
        font-size: 0.95rem;
        color: var(--text-color);
        transition: all 0.2s;
        background: #f8fafc;
        font-family: inherit;
    }
    .modern-input:focus {
        border-color: var(--primary-color);
        background: #fff;
        box-shadow: 0 0 0 3px var(--primary-light);
        outline: none;
    }
    textarea.modern-input { resize: vertical; min-height: 100px; }
    
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }

    /* ===== BUTTONS ===== */
    .btn-save {
        background: linear-gradient(135deg, #0d9488, #0f766e);
        color: white;
        border: none;
        padding: 0.85rem 2rem;
        border-radius: 0.75rem;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.2);
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(13, 148, 136, 0.3);
    }
    
    /* ===== ALERT ===== */
    .alert-success {
        background-color: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        padding: 1rem 1.5rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 600;
        font-size: 0.95rem;
    }

</style>
@endsection

@section('content')

{{-- ===== PAGE HEADER BANNER ===== --}}
<div class="page-header-banner">
    <div class="page-header-left">
        <h2>
            <svg style="display:inline-block;vertical-align:-4px;margin-right:0.5rem" width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            Profil Apotek
        </h2>
        <p>Lengkapi dan atur informasi dasar apotek Anda untuk keperluan struk dan faktur.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert-success">
        <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger" style="margin-bottom:1.5rem; border-radius:0.75rem;">
        <ul style="margin:0; padding-left:1.5rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('profil-apotek.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="profile-container">
        
        <!-- BAGIAN KIRI: LOGO -->
        <div class="card-modern" style="text-align:center;">
            <div class="card-header" style="text-align:left;">
                <h3><svg width="20" height="20" fill="none" stroke="currentcolor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Logo Apotek</h3>
            </div>
            
            <div class="logo-preview-wrapper">
                <input type="file" name="logo" class="logo-input" accept="image/*" onchange="previewImage(event)">
                
                @if($apotik->logo)
                    <img id="imgPreview" src="{{ asset('storage/' . $apotik->logo) }}" class="logo-preview-image" alt="Logo">
                @else
                    <img id="imgPreview" src="#" class="logo-preview-image" style="display:none;" alt="Preview Logo">
                @endif
                
                <div class="logo-placeholder" id="placeholder-text" style="{{ $apotik->logo ? 'display:none;' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <span>Klik atau Drag Gambar</span>
                </div>
            </div>
            <p class="logo-helper">Format: JPG/PNG, Max 2MB<br>Rekomendasi rasio 1:1 (Persegi)</p>
        </div>

        <!-- BAGIAN KANAN: INFORMASI -->
        <div class="card-modern">
            <div class="card-header">
                <h3><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Informasi Identitas & Kontak</h3>
            </div>
            
            <div class="form-group">
                <label for="nama_apotek">Nama Apotek <span style="color:#ef4444;">*</span></label>
                <input type="text" id="nama_apotek" name="nama_apotek" class="modern-input" value="{{ old('nama_apotek', $apotik->nama_apotek) }}" required placeholder="Contoh: Apotek Kimia Farma">
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label for="no_telp">Nomor Telepon / WhatsApp <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="no_telp" name="no_telp" class="modern-input" value="{{ old('no_telp', $apotik->no_telp) }}" required placeholder="Contoh: 08123456789">
                </div>
                <div class="form-group">
                    <label for="email">Alamat Email <span style="color:#ef4444;">*</span></label>
                    <input type="email" id="email" name="email" class="modern-input" value="{{ old('email', $apotik->email) }}" required placeholder="Contoh: kontak@apotekku.com">
                </div>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat Lengkap <span style="color:#ef4444;">*</span></label>
                <textarea id="alamat" name="alamat" class="modern-input" required placeholder="Masukkan alamat lengkap apotek beserta kodepos...">{{ old('alamat', $apotik->alamat) }}</textarea>
            </div>

            <div class="card-header" style="margin-top:2rem;">
                <h3><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> Informasi Izin (SIP/SIA)</h3>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label for="sip">Nomor SIP (Surat Izin Praktik)</label>
                    <input type="text" id="sip" name="sip" class="modern-input" value="{{ old('sip', $apotik->sip) }}" placeholder="Opsional">
                </div>
                <div class="form-group">
                    <label for="sia">Nomor SIA (Surat Izin Apotek)</label>
                    <input type="text" id="sia" name="sia" class="modern-input" value="{{ old('sia', $apotik->sia) }}" placeholder="Opsional">
                </div>
            </div>

            <div style="text-align: right; margin-top: 1.5rem; border-top: 1px solid #f1f5f9; padding-top: 1.5rem;">
                <button type="submit" class="btn-save">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                    Simpan Perubahan
                </button>
            </div>
            
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
    function previewImage(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function(){
            var dataURL = reader.result;
            var output = document.getElementById('imgPreview');
            var placeholder = document.getElementById('placeholder-text');
            
            output.src = dataURL;
            output.style.display = 'block';
            placeholder.style.display = 'none';
        };
        if(input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
