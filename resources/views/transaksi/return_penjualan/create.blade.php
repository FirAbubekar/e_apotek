@extends('layouts.app')

@section('content')
<div class="ret-container">
    <!-- Header -->
    <div class="ret-header">
        <div class="ret-header-info">
            <h2 class="fw-bold text-slate-800 mb-1">Buat Return Penjualan</h2>
            <p class="text-slate-500 mb-0">Input pengembalian barang dari pelanggan secara akurat</p>
        </div>
        <div class="ret-header-actions">
            <a href="{{ route('return-penjualan.index') }}" class="btn-outline-slate">
                <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
            </a>
        </div>
    </div>

    <!-- Alerts Section -->
    @if(session('success'))
    <div class="alert alert-success d-flex align-items-center mb-4">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger d-flex align-items-center mb-4">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger mb-4">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Search Section -->
    <div class="search-section">
        <div class="data-card search-card">
            <div class="data-body p-4">
                <form action="{{ route('return-penjualan.create') }}" method="GET">
                    <div class="search-input-wrapper">
                        <div class="input-info">
                            <i class="fas fa-receipt text-emerald-500"></i>
                            <div class="input-texts">
                                <label class="mb-0">Nomor Transaksi Penjualan</label>
                                <input type="text" name="no_transaksi" placeholder="Masukkan No. Faktur (Contoh: PJN-20240314-001)" value="{{ request('no_transaksi') }}" required>
                            </div>
                        </div>
                        <button type="submit" class="btn-search">
                            <i class="fas fa-search me-2"></i> Cari Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        @if(!request('no_transaksi'))
        <div class="search-tip mt-3">
            <i class="fas fa-info-circle me-1"></i> 
            Pastikan nomor transaksi yang dimasukkan sesuai dengan yang tercetak di struk penjualan.
        </div>
        @endif
    </div>

    @if($penjualan)
    <form action="{{ route('return-penjualan.store') }}" method="POST" id="returnForm">
        @csrf
        <input type="hidden" name="penjualan_id" value="{{ $penjualan->id }}">
        
        <div class="grid-main">
            <!-- Left: Transaction Info & Return Header -->
            <div class="side-content">
                <!-- Transaction Info -->
                <div class="premium-card mb-4 mt-1">
                    <div class="card-header-custom">
                        <i class="fas fa-info-circle text-emerald-500"></i>
                        <span>Info Transaksi Asal</span>
                    </div>
                    <div class="card-body-custom">
                        <div class="info-row">
                            <span class="label">No. Faktur</span>
                            <span class="value fw-bold text-slate-800">{{ $penjualan->no_transaksi }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Tanggal Jual</span>
                            <span class="value">{{ \Carbon\Carbon::parse($penjualan->tanggal_penjualan)->format('d M Y') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Pelanggan</span>
                            <span class="value text-emerald-600 fw-semibold">{{ $penjualan->pelanggan->nama ?? 'Umum / Walk-in' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Tipe / Metode</span>
                            <span class="value"><span class="badge-slate">{{ $penjualan->tipe_penjualan }}</span> / {{ $penjualan->metode_pembayaran }}</span>
                        </div>
                    </div>
                </div>

                <!-- Return Header -->
                <div class="premium-card">
                    <div class="card-header-custom">
                        <i class="fas fa-edit text-emerald-500"></i>
                        <span>Header Return</span>
                    </div>
                    <div class="card-body-custom">
                        <div class="form-grid-2">
                            <div class="input-group-premium">
                                <label>No. Return</label>
                                <div class="input-readonly">
                                    <input type="text" name="no_return_pj" value="{{ $noReturn }}" readonly>
                                </div>
                            </div>
                            <div class="input-group-premium">
                                <label>Tanggal Return</label>
                                <input type="date" name="tanggal_return" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="input-group-premium mt-3">
                            <label>Alasan Return</label>
                            <textarea name="alasan" rows="3" placeholder="Masukkan alasan pengembalian barang..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Items Table -->
            <div class="main-table-content">
                <div class="premium-card h-100">
                    <div class="card-header-custom between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-box-open text-emerald-500"></i>
                            <span>Pilih Barang yang Dikembalikan</span>
                        </div>
                        <span class="count-badge">{{ count($penjualan->detailPenjualan) }} Item</span>
                    </div>
                    <div class="table-responsive-custom">
                        <table class="premium-table">
                            <thead>
                                <tr>
                                    <th class="ps-4">Item Obat</th>
                                    <th class="text-center">Jual</th>
                                    <th class="text-center">Sisa</th>
                                    <th class="text-center" width="160">Return</th>
                                    <th class="text-end">Harga</th>
                                    <th class="pe-4 text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($penjualan->detailPenjualan as $index => $detail)
                                <tr>
                                    <td class="ps-4">
                                        <input type="hidden" name="items[{{ $index }}][obat_id]" value="{{ $detail->obat_id }}">
                                        <div class="item-info">
                                            <div class="item-name">{{ $detail->obat->medicine_name }}</div>
                                            <div class="item-meta">{{ $detail->obat->satuan->satuan_name ?? 'Unit' }}</div>
                                        </div>
                                    </td>
                                    <td class="text-center"><span class="qty-badge gray">{{ $detail->jumlah }}</span></td>
                                    <td class="text-center"><span class="qty-badge emerald">{{ $detail->max_return }}</span></td>
                                    <td class="text-center">
                                        <div class="qty-stepper">
                                            <button type="button" class="step-btn" onclick="changeQty(this, -1)">-</button>
                                            <input type="number" 
                                                   name="items[{{ $index }}][jumlah]" 
                                                   value="0" 
                                                   min="0" 
                                                   max="{{ $detail->max_return }}" 
                                                   data-price="{{ $detail->harga_satuan }}"
                                                   oninput="updateRowSubtotal(this)"
                                                   class="qty-field">
                                            <button type="button" class="step-btn" onclick="changeQty(this, 1)">+</button>
                                        </div>
                                    </td>
                                    <td class="text-end text-slate-500">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="pe-4 text-end fw-bold text-slate-800">
                                        <span class="row-subtotal">Rp 0</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="card-footer-premium">
                        <div class="total-display">
                            <div class="total-texts">
                                <span class="total-label">Subtotal Nilai Return</span>
                                <h2 class="total-amount" id="grandTotal">Rp 0</h2>
                            </div>
                            <button type="submit" class="btn-save-premium" id="btnSimpan" disabled>
                                <div class="btn-content">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Simpan Transaksi Return</span>
                                </div>
                                <div class="btn-loader d-none"><i class="fas fa-circle-notch fa-spin"></i></div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endif
</div>

<style>
    :root {
        --slate-900: #0f172a; --slate-800: #1e293b; --slate-700: #334155;
        --slate-600: #475569; --slate-500: #64748b; --slate-400: #94a3b8;
        --slate-100: #f1f5f9; --slate-50: #f8fafc;
        --emerald-700: #047857; --emerald-600: #059669; --emerald-500: #10b981; --emerald-50: #ecfdf5;
        --rose-600: #e11d48; --rose-700: #be123c;
    }

    .ret-container { display: flex; flex-direction: column; gap: 1.5rem; }
    .ret-header { display: flex; justify-content: space-between; align-items: center; }

    .btn-emerald { background: var(--emerald-600); color: white; padding: 0.6rem 1.25rem; border-radius: 0.5rem; border: none; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s; }
    .btn-emerald:hover { background: var(--emerald-700); transform: translateY(-1px); }

    .btn-rose { background: var(--rose-600); color: white; padding: 0.8rem 2rem; border-radius: 0.75rem; border: none; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 0.75rem; transition: all 0.2s; opacity: 1; }
    .btn-rose:hover { background: var(--rose-700); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(225, 29, 72, 0.3); }
    .btn-rose:disabled { opacity: 0.5; cursor: not-allowed; transform: none; box-shadow: none; }

    .btn-outline-slate { border: 1px solid var(--slate-200); color: var(--slate-600); padding: 0.6rem 1.25rem; border-radius: 0.5rem; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; }
    .btn-outline-slate:hover { background: var(--slate-50); }

    /* Search Section UI */
    .search-card { border-radius: 1.5rem !important; margin-bottom: 2.5rem; border: none !important; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02) !important; }
    .search-input-wrapper { display: flex; align-items: center; gap: 1rem; background: #fff; padding: 0.75rem 0.75rem 0.75rem 1.75rem; border-radius: 1.25rem; border: 1.5px solid var(--slate-100); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .search-input-wrapper:focus-within { border-color: var(--emerald-500); box-shadow: 0 0 0 4px var(--emerald-50); transform: translateY(-2px); }
    
    .input-info { display: flex; align-items: center; gap: 1.25rem; flex: 1; }
    .input-info i { font-size: 1.5rem; opacity: 0.8; }
    .input-texts { flex: 1; display: flex; flex-direction: column; }
    .input-texts label { font-size: 0.7rem; font-weight: 900; color: var(--slate-400); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.15rem; }
    .input-texts input { border: none; background: transparent; padding: 0; font-size: 1.1rem; font-weight: 700; color: var(--slate-800); outline: none; width: 100%; }
    .input-texts input::placeholder { color: var(--slate-300); font-weight: 500; font-size: 0.95rem; }
    
    .btn-search { background: var(--emerald-600); color: white; border: none; padding: 1rem 2rem; border-radius: 1rem; font-weight: 800; cursor: pointer; transition: all 0.2s; white-space: nowrap; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2); }
    .btn-search:hover { background: var(--emerald-700); transform: scale(1.02); }
    .search-tip { font-size: 0.85rem; color: var(--slate-500); display: flex; align-items: center; justify-content: center; background: var(--slate-50); padding: 0.75rem; border-radius: 0.75rem; border: 1px dashed var(--slate-200); }

    /* Premium Grid Layout */
    .grid-main { display: grid; grid-template-columns: 350px 1fr; gap: 1.5rem; align-items: start; }
    
    .premium-card { background: white; border-radius: 1.25rem; border: 1px solid var(--slate-100); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; display: flex; flex-direction: column; }
    .card-header-custom { padding: 1.25rem; background: var(--slate-50); border-bottom: 1px solid var(--slate-100); display: flex; align-items: center; gap: 0.75rem; font-weight: 800; color: var(--slate-800); }
    .card-header-custom.between { justify-content: space-between; }
    .card-body-custom { padding: 1.25rem; }
    
    /* Info Rows */
    .info-row { display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; border-bottom: 1px dashed var(--slate-100); }
    .info-row:last-child { border-bottom: none; }
    .info-row .label { color: var(--slate-400); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; }
    .info-row .value { font-size: 0.95rem; color: var(--slate-700); }

    /* Inputs Premium */
    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .input-group-premium label { display: block; font-size: 0.75rem; font-weight: 800; color: var(--slate-400); text-transform: uppercase; margin-bottom: 0.35rem; }
    .input-group-premium input, .input-group-premium textarea { width: 100%; padding: 0.75rem; border-radius: 0.75rem; border: 1.5px solid var(--slate-100); background: var(--slate-50); outline: none; transition: all 0.2s; font-weight: 600; color: var(--slate-800); }
    .input-group-premium input:focus, .input-group-premium textarea:focus { background: white; border-color: var(--emerald-500); box-shadow: 0 0 0 3px var(--emerald-50); }
    .input-readonly input { background: #f1f5f9; color: var(--slate-500); cursor: not-allowed; border-color: var(--slate-100); }

    /* Table Premium */
    .table-responsive-custom { flex: 1; }
    .premium-table { width: 100%; border-collapse: collapse; }
    .premium-table th { background: var(--slate-50); padding: 1rem; text-align: left; font-size: 0.7rem; color: var(--slate-400); font-weight: 800; text-transform: uppercase; border-bottom: 2px solid var(--slate-100); }
    .premium-table td { padding: 1.25rem 1rem; border-bottom: 1px solid var(--slate-50); vertical-align: middle; }
    
    .item-info .item-name { font-weight: 700; color: var(--slate-800); }
    .item-info .item-meta { font-size: 0.75rem; color: var(--slate-400); margin-top: 0.15rem; }
    
    .qty-badge { padding: 0.35rem 0.6rem; border-radius: 6px; font-weight: 800; font-size: 0.85rem; }
    .qty-badge.gray { background: var(--slate-100); color: var(--slate-500); }
    .qty-badge.emerald { background: var(--emerald-50); color: var(--emerald-600); }
    
    /* Stepper */
    .qty-stepper { display: inline-flex; align-items: center; background: white; border: 1.5px solid var(--slate-100); border-radius: 0.75rem; overflow: hidden; height: 40px; }
    .step-btn { background: var(--slate-50); border: none; width: 40px; height: 100%; color: var(--slate-600); font-weight: bold; cursor: pointer; transition: background 0.2s; }
    .step-btn:hover { background: var(--slate-100); }
    .qty-field { width: 50px; border: none; text-align: center; font-weight: 900; color: var(--emerald-700); background: transparent; -moz-appearance: textfield; }
    .qty-field::-webkit-outer-spin-button, .qty-field::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

    /* Footer Premium */
    .card-footer-premium { background: var(--slate-900); padding: 1.75rem; border-top: 1px solid var(--slate-800); }
    .total-display { display: flex; justify-content: space-between; align-items: center; }
    .total-texts { display: flex; flex-direction: column; }
    .total-label { color: var(--slate-400); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; }
    .total-amount { color: white; font-size: 2.25rem; font-weight: 900; margin: 0; }
    
    .btn-save-premium { background: linear-gradient(135deg, var(--emerald-500), var(--emerald-600)); color: white; border: none; padding: 1rem 2.5rem; border-radius: 1rem; cursor: pointer; transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3); }
    .btn-save-premium:hover:not(:disabled) { transform: translateY(-4px) scale(1.02); box-shadow: 0 20px 25px -5px rgba(16, 185, 129, 0.4); }
    .btn-save-premium:active:not(:disabled) { transform: translateY(0); }
    .btn-save-premium:disabled { background: var(--slate-700); cursor: not-allowed; opacity: 0.6; box-shadow: none; }
    .btn-content { display: flex; align-items: center; gap: 0.75rem; font-size: 1.1rem; font-weight: 900; }
    
    .count-badge { background: var(--emerald-500); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 800; }
    .badge-slate { background: var(--slate-200); color: var(--slate-700); padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 700; }

    .data-card { background: white; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid var(--slate-100); overflow: hidden; }

    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .bg-gray-lighter { background-color: #f9f9f9; cursor: not-allowed; }

    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { background: var(--slate-50); padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; color: var(--slate-500); font-weight: 800; border-bottom: 2px solid var(--slate-100); }
    .custom-table td { padding: 1rem; border-bottom: 1px solid var(--slate-50); }

    .qty-input-group { display: inline-flex; border: 1px solid var(--slate-200); border-radius: 0.5rem; overflow: hidden; background: white; }
    .qty-input-group button { background: var(--slate-50); border: none; padding: 0.5rem 0.75rem; color: var(--slate-600); cursor: pointer; font-weight: bold; }
    .qty-input-group button:hover { background: var(--slate-100); }
    .qty-field { width: 60px; text-align: center; border: none; border-left: 1px solid var(--slate-200); border-right: 1px solid var(--slate-200); font-weight: bold; outline: none; }
    
    .badge-slate { background: var(--slate-100); color: var(--slate-600); padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600; }
    
    @media (max-width: 992px) { .grid-layout { grid-template-columns: 1fr; } }
</style>

<script>
    function changeQty(btn, delta) {
        const input = btn.parentElement.querySelector('input');
        let val = parseInt(input.value) + delta;
        const max = parseInt(input.getAttribute('max'));
        
        if (val < 0) val = 0;
        if (val > max) val = max;
        
        input.value = val;
        updateRowSubtotal(input);
    }

    function updateRowSubtotal(input) {
        const qty = parseInt(input.value) || 0;
        const price = parseFloat(input.dataset.price);
        const subtotal = qty * price;
        const row = input.closest('tr');
        row.querySelector('.row-subtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
        
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let total = 0;
        document.querySelectorAll('.qty-field').forEach(input => {
            const qty = parseInt(input.value) || 0;
            const price = parseFloat(input.dataset.price);
            total += qty * price;
        });

        document.getElementById('grandTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
        
        // Enable/disable button
        const btn = document.getElementById('btnSimpan');
        if (total > 0) {
            btn.disabled = false;
        } else {
            btn.disabled = true;
        }
    }
    
    // Loading state for submit
    document.getElementById('returnForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSimpan');
        btn.disabled = true;
        btn.querySelector('.btn-content').classList.add('d-none');
        btn.querySelector('.btn-loader').classList.remove('d-none');
    });

    // Initial call
    document.addEventListener('DOMContentLoaded', calculateGrandTotal);
</script>
@endsection
