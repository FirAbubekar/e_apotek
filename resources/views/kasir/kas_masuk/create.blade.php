@extends('layouts.app')

@section('content')
<div class="ledger-container">
    <!-- Top Progress/Header -->
    <div class="ledger-header animate__animated animate__fadeIn">
        <div class="ledger-header-left">
            <h1 class="ledger-title">Pencatatan Arus Kas Masuk</h1>
            <div class="ledger-breadcrumb">
                <span class="step">Kasir Elektronik</span>
                <i class="fas fa-chevron-right separator"></i>
                <span class="step active">Input Transaksi Manual</span>
            </div>
        </div>
        <div class="ledger-header-right">
            <a href="{{ route('kas-masuk.index') }}" class="btn-ledger-outline">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Riwayat
            </a>
        </div>
    </div>

    <!-- Main Entry Board -->
    <div class="row justify-content-center">
        <div class="col-xl-11 col-lg-12">
            <div class="ledger-card animate__animated animate__fadeInUp">
                <!-- Card Branding/Info Bar -->
                <div class="ledger-side-info">
                    <div class="info-block">
                        <label>Tipe Entri</label>
                        <p><i class="fas fa-sign-in-alt text-emerald-600 me-2"></i>Incoming / Kredit</p>
                    </div>
                    <div class="divider"></div>
                    <div class="info-block">
                        <label>Status Sistem</label>
                        <p><span class="status-indicator"></span>Ready for Input</p>
                    </div>
                </div>

                <!-- Form Section -->
                <form action="{{ route('kas-masuk.store') }}" method="POST" id="kasForm" class="ledger-form">
                    @csrf
                    <div class="ledger-form-body">
                        
                        <!-- Reference Section -->
                        <div class="ledger-row align-items-center">
                            <div class="row w-100">
                                <div class="col-md-4">
                                    <label class="ledger-label">No. Referensi Internal</label>
                                    <span class="ledger-sublabel">ID Transaksi Audit Otomatis</span>
                                </div>
                                <div class="col-md-8">
                                    <div class="ledger-input-group readonly">
                                        <input type="text" value="{{ $noTransaksi }}" readonly class="ledger-input">
                                        <i class="fas fa-lock ledger-input-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Category Section -->
                        <div class="ledger-row align-items-center">
                            <div class="row w-100">
                                <div class="col-md-4">
                                    <label class="ledger-label">Kategori Transaksi <span class="required">*</span></label>
                                    <span class="ledger-sublabel">Klasifikasi Akuntansi Dana</span>
                                </div>
                                <div class="col-md-8">
                                    <div class="ledger-input-group">
                                        <select name="category" required class="ledger-input select-mode">
                                            <option value="" disabled selected>Pilih Klasifikasi...</option>
                                            <option value="Modal Awal">Modal Awal / Saldo Awal</option>
                                            <option value="Pendapatan Lain-lain">Pendapatan Lain-lain</option>
                                            <option value="Koreksi Saldo">Koreksi Saldo (Plus)</option>
                                            <option value="Setoran Tunai">Setoran Tunai</option>
                                        </select>
                                        <i class="fas fa-chevron-down ledger-input-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Date Section -->
                        <div class="ledger-row align-items-center">
                            <div class="row w-100">
                                <div class="col-md-4">
                                    <label class="ledger-label">Tanggal Efektif <span class="required">*</span></label>
                                    <span class="ledger-sublabel">Waktu Pencatatan Dana Masuk</span>
                                </div>
                                <div class="col-md-8">
                                    <div class="ledger-input-group">
                                        <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" required class="ledger-input">
                                        <i class="fas fa-calendar ledger-input-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Amount Section -->
                        <div class="ledger-row align-items-center highlight-row">
                            <div class="row w-100">
                                <div class="col-md-4">
                                    <label class="ledger-label text-emerald-900">Nominal Kredit (IDR) <span class="required">*</span></label>
                                    <span class="ledger-sublabel">Jumlah Dana yang Diterima</span>
                                </div>
                                <div class="col-md-8">
                                    <div class="ledger-amount-group">
                                        <span class="currency">Rp</span>
                                        <input type="number" name="amount" placeholder="0.00" min="1" step="0.01" required class="ledger-amount-field">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description Section -->
                        <div class="ledger-row border-none">
                            <div class="row w-100">
                                <div class="col-md-4">
                                    <label class="ledger-label">Keterangan Tambahan</label>
                                    <span class="ledger-sublabel">Catatan Memoranda (Opsional)</span>
                                </div>
                                <div class="col-md-8">
                                    <div class="ledger-input-group textarea-mode">
                                        <textarea name="description" rows="4" placeholder="Masukan catatan detail jika diperlukan..." class="ledger-input"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="ledger-footer">
                        <div class="footer-help">
                            <i class="fas fa-shield-alt text-emerald-600 me-2"></i>
                            Informasi ini akan tercatat dalam pembukuan resmi apotek.
                        </div>
                        <button type="submit" class="btn-ledger-submit" id="btnSimpan">
                            <span class="btn-text">Posting ke Jurnal Kas</span>
                            <span class="btn-loader d-none"><i class="fas fa-circle-notch fa-spin me-2"></i> Memproses Verifikasi...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --emerald-600: #059669;
        --emerald-700: #047857;
        --emerald-900: #064e3b;
        --emerald-50: #ecfdf5;
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --slate-300: #cbd5e1;
        --slate-400: #94a3b8;
        --slate-500: #64748b;
        --slate-600: #475569;
        --slate-800: #1e293b;
        --ledger-border: #eef1f6;
    }

    .ledger-container {
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding: 4rem 2rem;
        max-width: 95%;
        margin: 0 auto;
        background-color: #f7f9fc;
        min-height: 100vh;
        color: var(--slate-800);
    }

    /* Header */
    .ledger-header {
        max-width: 100%;
        margin-bottom: 3.5rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }
    .ledger-title { font-size: 2.25rem; font-weight: 800; letter-spacing: -0.05em; margin: 0; }
    .ledger-breadcrumb { margin-top: 0.75rem; display: flex; align-items: center; gap: 0.75rem; }
    .step { font-size: 0.9rem; font-weight: 600; color: var(--slate-400); }
    .step.active { color: var(--emerald-600); font-weight: 800; }
    .separator { font-size: 0.7rem; color: var(--slate-300); }

    .btn-ledger-outline {
        padding: 0.85rem 1.75rem;
        border: 2px solid var(--slate-200);
        border-radius: 12px;
        color: var(--slate-600);
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
        background: white;
    }
    .btn-ledger-outline:hover { background: var(--slate-800); color: white; border-color: var(--slate-800); }

    /* Card Board */
    .ledger-card {
        background: white;
        border-radius: 20px;
        border: 1px solid var(--ledger-border);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.01);
        overflow: hidden;
    }

    .ledger-side-info {
        background: var(--slate-50);
        padding: 1rem 3rem;
        display: flex;
        gap: 3rem;
        border-bottom: 1px solid var(--slate-100);
    }
    .info-block label { font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-400); margin-bottom: 0.25rem; display: block; }
    .info-block p { font-size: 0.95rem; font-weight: 700; color: var(--slate-600); margin: 0; display: flex; align-items: center; }
    .status-indicator { width: 8px; height: 8px; background: #10b981; border-radius: 50%; margin-right: 0.5rem; }
    .ledger-side-info .divider { width: 1px; background: var(--slate-200); }

    /* Form Body */
    .ledger-form { width: 100%; }
    .ledger-form-body { padding: 1.5rem 3rem; }

    .ledger-row {
        padding: 2.25rem 0;
        border-bottom: 1px solid var(--slate-100);
        display: flex;
    }
    .ledger-row.border-none { border-bottom: none; }
    .ledger-row.highlight-row { background: #fafdfc; margin: 0 -3rem; padding: 2.25rem 3rem; }

    .ledger-label { font-size: 1rem; font-weight: 700; color: var(--slate-700); margin-bottom: 0.2rem; display: block; }
    .ledger-sublabel { font-size: 0.8rem; font-weight: 500; color: var(--slate-400); display: block; }
    .required { color: var(--emerald-600); }

    /* Inputs */
    .ledger-input-group { position: relative; width: 100%; }
    .ledger-input {
        width: 100%;
        padding: 0.9rem 1rem;
        background: white;
        border: 1.5px solid var(--slate-200);
        border-radius: 10px;
        font-weight: 600;
        color: var(--slate-800);
        outline: none;
        transition: border-color 0.2s;
        font-size: 1rem;
    }
    .ledger-input:focus { border-color: var(--emerald-600); }
    .ledger-input.readonly { background: #f8fafc; color: var(--slate-400); border-style: dashed; }
    .ledger-input-icon { position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: var(--slate-300); font-size: 0.9rem; }
    
    .select-mode { appearance: none; padding-right: 2.5rem; cursor: pointer; }
    .textarea-mode textarea { resize: none; min-height: 120px; }

    /* Amount Field */
    .ledger-amount-group { display: flex; align-items: center; gap: 1rem; }
    .currency { font-size: 1.5rem; font-weight: 800; color: var(--emerald-700); }
    .ledger-amount-field {
        border: none;
        background: transparent;
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--emerald-900);
        outline: none;
        width: 100%;
        letter-spacing: -0.03em;
    }

    /* Footer */
    .ledger-footer {
        padding: 2.5rem 3rem;
        background: var(--slate-50);
        border-top: 1px solid var(--slate-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .footer-help { font-size: 0.85rem; font-weight: 600; color: var(--slate-500); }
    .btn-ledger-submit {
        background: var(--emerald-600);
        color: white;
        border: none;
        padding: 1rem 2.5rem;
        border-radius: 10px;
        font-weight: 800;
        font-size: 1.05rem;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 10px rgba(5, 150, 105, 0.2);
    }
    .btn-ledger-submit:hover { background: var(--emerald-700); transform: translateY(-2px); box-shadow: 0 8px 15px rgba(5, 150, 105, 0.3); }

    @media (max-width: 768px) {
        .ledger-container { padding: 2rem 1rem; }
        .ledger-row { flex-direction: column; padding: 1.5rem 0; }
        .ledger-label { margin-bottom: 0.5rem; }
        .col-md-4 { margin-bottom: 1rem; }
        .ledger-footer { flex-direction: column; gap: 1.5rem; text-align: center; }
    }
</style>

<script>
    document.getElementById('kasForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSimpan');
        const text = btn.querySelector('.btn-text');
        const loader = btn.querySelector('.btn-loader');
        
        btn.disabled = true;
        text.classList.add('d-none');
        loader.classList.remove('d-none');
        btn.style.opacity = '0.8';
    });
</script>
@endsection
