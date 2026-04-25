@extends('layouts.app')

@section('content')
<div class="ledger-container">
    <!-- Top Progress/Header -->
    <div class="ledger-header animate__animated animate__fadeIn">
        <div class="ledger-header-left">
            <h1 class="ledger-title text-rose-900">Pencatatan Arus Kas Keluar</h1>
            <div class="ledger-breadcrumb">
                <span class="step">Kasir Elektronik</span>
                <i class="fas fa-chevron-right separator"></i>
                <span class="step active text-rose-600">Disbursement / Pengeluaran</span>
            </div>
        </div>
        <div class="ledger-header-right">
            <a href="{{ route('kas-keluar.index') }}" class="btn-ledger-outline">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Riwayat
            </a>
        </div>
    </div>

    <!-- Main Entry Board -->
    <div class="row justify-content-center">
        <div class="col-xl-11 col-lg-12">
            <div class="ledger-card border-top-rose animate__animated animate__fadeInUp">
                <!-- Card Branding/Info Bar -->
                <div class="ledger-side-info bg-rose-50">
                    <div class="info-block">
                        <label class="text-rose-400">Tipe Entri</label>
                        <p class="text-rose-700"><i class="fas fa-sign-out-alt me-2"></i>Outgoing / Debit</p>
                    </div>
                    <div class="divider bg-rose-200"></div>
                    <div class="info-block">
                        <label class="text-rose-400">Verifikasi Sistem</label>
                        <p class="text-slate-600"><span class="status-indicator bg-rose-500"></span>Ready for Disbursement</p>
                    </div>
                </div>

                <!-- Form Section -->
                <form action="{{ route('kas-keluar.store') }}" method="POST" id="kasForm" class="ledger-form">
                    @csrf
                    <div class="ledger-form-body">
                        
                        <!-- Reference Section -->
                        <div class="ledger-row align-items-center">
                            <div class="row w-100">
                                <div class="col-md-4">
                                    <label class="ledger-label">No. Referensi Manual</label>
                                    <span class="ledger-sublabel">ID Transaksi Audit (Auto-KSK)</span>
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
                                    <label class="ledger-label">Kategori Pengeluaran <span class="required">*</span></label>
                                    <span class="ledger-sublabel">Klasifikasi Biaya Operasional</span>
                                </div>
                                <div class="col-md-8">
                                    <div class="ledger-input-group">
                                        <select name="category" required class="ledger-input select-mode border-rose-100">
                                            <option value="" disabled selected>Pilih Klasifikasi Biaya...</option>
                                            <option value="Biaya Listrik/Air">Biaya Listrik/Air</option>
                                            <option value="Biaya Gaji Karyawan">Biaya Gaji Karyawan</option>
                                            <option value="Biaya Sewa Tempat">Biaya Sewa Tempat</option>
                                            <option value="Biaya Kebersihan">Biaya Kebersihan</option>
                                            <option value="Pembelian ATK">Pembelian ATK</option>
                                            <option value="Biaya Lain-lain">Biaya Lain-lain</option>
                                        </select>
                                        <i class="fas fa-chevron-down ledger-input-icon text-rose-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Date Section -->
                        <div class="ledger-row align-items-center">
                            <div class="row w-100">
                                <div class="col-md-4">
                                    <label class="ledger-label">Tanggal Pengeluaran <span class="required">*</span></label>
                                    <span class="ledger-sublabel">Waktu Dana Dikeluarkan</span>
                                </div>
                                <div class="col-md-8">
                                    <div class="ledger-input-group">
                                        <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" required class="ledger-input border-rose-100">
                                        <i class="fas fa-calendar ledger-input-icon text-rose-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Amount Section -->
                        <div class="ledger-row align-items-center highlight-row-rose">
                            <div class="row w-100">
                                <div class="col-md-4">
                                    <label class="ledger-label text-rose-900">Nominal Keluar (IDR) <span class="required">*</span></label>
                                    <span class="ledger-sublabel">Jumlah Dana yang Dibayarkan</span>
                                </div>
                                <div class="col-md-8">
                                    <div class="ledger-amount-group">
                                        <span class="currency text-rose-600">Rp</span>
                                        <input type="number" name="amount" placeholder="0.00" min="1" step="0.01" required class="ledger-amount-field text-rose-700">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description Section -->
                        <div class="ledger-row border-none">
                            <div class="row w-100">
                                <div class="col-md-4">
                                    <label class="ledger-label">Keterangan Biaya</label>
                                    <span class="ledger-sublabel">Catatan detail untuk laporan keuangan</span>
                                </div>
                                <div class="col-md-8">
                                    <div class="ledger-input-group textarea-mode">
                                        <textarea name="description" rows="4" placeholder="Contoh: Pembayaran listrik periode Maret 2024..." class="ledger-input border-rose-100"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="ledger-footer bg-slate-50">
                        <div class="footer-help">
                            <i class="fas fa-exclamation-triangle text-rose-500 me-2"></i>
                            Pastikan bukti fisik pengeluaran telah disimpan.
                        </div>
                        <button type="submit" class="btn-ledger-submit-rose" id="btnSimpan">
                            <span class="btn-text">Posting Pengeluaran</span>
                            <span class="btn-loader d-none"><i class="fas fa-spinner fa-spin me-2"></i> Sedang Memverifikasi...</span>
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
        --rose-600: #e11d48;
        --rose-700: #be123c;
        --rose-900: #881337;
        --rose-50: #fff1f2;
        --rose-100: #ffe4e6;
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --slate-400: #94a3b8;
        --slate-700: #334155;
        --slate-800: #1e293b;
        --ledger-border: #f8fafc;
    }

    .ledger-container {
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding: 4rem 2rem;
        max-width: 95%;
        margin: 0 auto;
        background-color: #fdfdfd;
        min-height: 100vh;
        color: var(--slate-800);
    }

    .ledger-header { max-width: 100%; margin-bottom: 3.5rem; display: flex; justify-content: space-between; align-items: flex-end; }
    .ledger-title { font-size: 2.25rem; font-weight: 800; letter-spacing: -0.05em; margin: 0; }
    .ledger-breadcrumb { margin-top: 0.75rem; display: flex; align-items: center; gap: 0.75rem; }
    .step { font-size: 0.9rem; font-weight: 600; color: var(--slate-400); }
    .step.active { font-weight: 800; }
    .separator { font-size: 0.7rem; color: var(--slate-300); }

    .btn-ledger-outline { padding: 0.85rem 1.75rem; border: 2px solid var(--slate-200); border-radius: 12px; color: var(--slate-600); font-weight: 700; text-decoration: none; transition: all 0.2s; background: white; }
    .btn-ledger-outline:hover { background: var(--slate-800); color: white; border-color: var(--slate-800); }

    .ledger-card { background: white; border-radius: 20px; border: 1px solid var(--slate-100); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.02); overflow: hidden; }
    .border-top-rose { border-top: 5px solid var(--rose-600); }

    .ledger-side-info { padding: 1.25rem 3.5rem; display: flex; gap: 4rem; }
    .info-block label { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem; display: block; }
    .info-block p { font-size: 1rem; font-weight: 700; margin: 0; display: flex; align-items: center; }
    .status-indicator { width: 10px; height: 10px; border-radius: 50%; margin-right: 0.6rem; }
    .ledger-side-info .divider { width: 1px; }

    .ledger-form-body { padding: 2rem 3.5rem; }
    .ledger-row { padding: 2.5rem 0; border-bottom: 1px solid #f8fafc; display: flex; }
    .ledger-row.border-none { border-bottom: none; }
    .ledger-row.highlight-row-rose { background: #fffbff; margin: 0 -3.5rem; padding: 2.5rem 3.5rem; border-top: 1px solid #fff1f2; border-bottom: 1px solid #fff1f2; }

    .ledger-label { font-size: 1.05rem; font-weight: 700; color: var(--slate-700); margin-bottom: 0.2rem; display: block; }
    .ledger-sublabel { font-size: 0.85rem; font-weight: 500; color: var(--slate-400); display: block; }
    .required { color: var(--rose-600); }

    .ledger-input-group { position: relative; width: 100%; }
    .ledger-input { width: 100%; padding: 1rem 1.25rem; background: white; border: 2px solid var(--slate-100); border-radius: 12px; font-weight: 600; color: var(--slate-800); outline: none; transition: all 0.2s; font-size: 1rem; }
    .ledger-input:focus { border-color: var(--rose-600); box-shadow: 0 0 0 4px rgba(225, 29, 72, 0.05); }
    .ledger-input.readonly { background: #fbfcfd; color: var(--slate-400); border-style: dashed; }
    .ledger-input-icon { position: absolute; right: 1.25rem; top: 50%; transform: translateY(-50%); font-size: 0.9rem; }
    
    .select-mode { appearance: none; padding-right: 3rem; cursor: pointer; }
    .textarea-mode textarea { resize: none; min-height: 140px; }

    .ledger-amount-group { display: flex; align-items: center; gap: 1.25rem; }
    .currency { font-size: 1.75rem; font-weight: 800; }
    .ledger-amount-field { border: none; background: transparent; font-size: 3rem; font-weight: 800; outline: none; width: 100%; letter-spacing: -0.04em; }

    .ledger-footer { padding: 3rem 3.5rem; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f8fafc; }
    .footer-help { font-size: 0.9rem; font-weight: 600; color: var(--slate-500); }
    .btn-ledger-submit-rose { background: var(--rose-600); color: white; border: none; padding: 1.1rem 3rem; border-radius: 14px; font-weight: 800; font-size: 1.1rem; cursor: pointer; transition: all 0.3s; box-shadow: 0 10px 20px -5px rgba(225, 29, 72, 0.3); }
    .btn-ledger-submit-rose:hover { background: var(--rose-700); transform: translateY(-3px); box-shadow: 0 15px 30px -5px rgba(225, 29, 72, 0.4); }

    @media (max-width: 768px) {
        .ledger-container { padding: 2rem 1rem; }
        .ledger-row { flex-direction: column; padding: 2rem 0; }
        .col-md-4 { margin-bottom: 1.25rem; }
        .ledger-footer { flex-direction: column; gap: 2rem; text-align: center; }
        .ledger-side-info { flex-direction: column; gap: 1.5rem; }
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
        btn.style.opacity = '0.85';
    });
</script>
@endsection
