@extends('layouts.app')

@section('content')
<div class="ret-container">
    <div class="ret-header">
        <div class="ret-header-info">
            <h2 class="fw-bold text-slate-800 mb-1">Return Pembelian</h2>
            <p class="text-slate-500 mb-0">Pengembalian barang ke supplier</p>
        </div>
        <div class="ret-header-actions">
            <a href="{{ route('return-pembelian.index') }}" class="btn-outline">
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

    <!-- Search Invoice Section -->
    <div class="data-card mb-4">
        <div class="data-body p-4">
            <form action="{{ route('return-pembelian.create') }}" method="GET" class="search-form">
                <div class="form-group-search">
                    <label class="stats-label mb-2 d-block">Cari Faktur Pembelian Asal</label>
                    <div class="search-input-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" name="no_faktur" 
                               placeholder="Masukkan Nomor Faktur (contoh: PBL-2026...)" 
                               value="{{ request('no_faktur') }}" required>
                    </div>
                </div>
                <button type="submit" class="btn-emerald">
                    <i class="fas fa-search"></i> Cari Faktur
                </button>
            </form>
        </div>
    </div>

    @if($pembelian)
    <form action="{{ route('return-pembelian.store') }}" method="POST">
        @csrf
        <input type="hidden" name="pembelian_id" value="{{ $pembelian->id }}">
        
        <div class="ret-main-layout">
            <!-- Left Column: Items to Return -->
            <div class="ret-items-section">
                <div class="data-card h-100">
                    <div class="data-header">
                        <h5 class="fw-bold text-slate-800 mb-0">Daftar Item Faktur #{{ $pembelian->no_faktur }}</h5>
                    </div>
                    <div class="data-body p-0">
                        <div class="table-container">
                            <table class="custom-table smaller">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Obat / Produk</th>
                                        <th class="text-center">Batch</th>
                                        <th class="text-center">Qty Beli</th>
                                        <th class="text-end">Qty Return</th>
                                        <th class="pe-4 text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $idx = 0; @endphp
                                    @foreach($pembelian->detailPembelian as $detail)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-slate-800">{{ $detail->obat->medicine_name }}</div>
                                            <div class="small text-slate-500 font-mono">{{ $detail->obat->medicine_code }}</div>
                                            <input type="hidden" name="items[{{ $idx }}][obat_id]" value="{{ $detail->obat_id }}">
                                        </td>
                                        <td class="text-center">
                                            @php 
                                                $batch = \App\Models\MedicineBatch::where('pembelian_id', $pembelian->id)
                                                    ->where('medicine_id', $detail->obat_id)->first();
                                            @endphp
                                            <span class="batch-badge">
                                                {{ $batch->batch_number ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center fw-semibold text-slate-600">{{ $detail->jumlah }} {{ $detail->obat->satuan->unit_name ?? '' }}</td>
                                        <td class="text-end">
                                            <div class="input-qty-wrapper">
                                                <input type="number" name="items[{{ $idx }}][jumlah]" 
                                                       class="return-qty" 
                                                       min="0" max="{{ $detail->jumlah }}" value="0"
                                                       data-price="{{ $detail->harga_satuan }}"
                                                       onchange="updateRowSubtotal(this)">
                                            </div>
                                        </td>
                                        <td class="pe-4 text-end fw-bold text-slate-700">
                                            Rp <span class="row-subtotal">0</span>
                                        </td>
                                    </tr>
                                    @php $idx++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Return Details -->
            <div class="ret-sidebar-section">
                <div class="data-card sticky-sidebar">
                    <div class="data-body p-4">
                        <h5 class="fw-bold mb-4 text-slate-800 border-bottom-slate pb-2">Informasi Return</h5>
                        
                        <div class="form-group mb-3">
                            <label class="stats-label">No. Return</label>
                            <input type="text" name="no_return" class="form-control-static" value="{{ $noReturn }}" readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label class="stats-label">Tanggal Return</label>
                            <input type="date" name="tanggal_return" class="form-input" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="stats-label">Supplier</label>
                            <input type="text" class="form-control-static" value="{{ $pembelian->supplier->supplier_name }}" readonly>
                        </div>

                        <div class="form-group mb-4">
                            <label class="stats-label">Alasan Return</label>
                            <textarea name="alasan" class="form-input" rows="3" placeholder="Contoh: Barang Rusak, Expired..."></textarea>
                        </div>

                        <div class="total-box mb-4">
                            <div class="total-label">TOTAL RETURN</div>
                            <div class="total-value">Rp <span id="grand-total-return">0</span></div>
                        </div>

                        <button type="submit" class="btn-emerald w-100 py-3" id="btn-submit" disabled>
                            Simpan Transaksi Return
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @elseif(request('no_faktur'))
    <!-- Empty State for Search -->
    <div class="data-card">
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-search fa-3x"></i></div>
            <h5 class="fw-bold text-slate-600">Faktur Tidak Ditemukan</h5>
            <p class="text-slate-500">Periksa kembali nomor faktur yang Anda masukkan.</p>
        </div>
    </div>
    @endif
</div>

<style>
    :root {
        --slate-900: #0f172a; --slate-800: #1e293b; --slate-700: #334155;
        --slate-600: #475569; --slate-500: #64748b; --slate-400: #94a3b8;
        --slate-100: #f1f5f9; --slate-50: #f8fafc;
        --emerald-700: #047857; --emerald-600: #059669; --emerald-500: #10b981; --emerald-50: #ecfdf5;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .ret-container { display: flex; flex-direction: column; gap: 2rem; }
    .mb-4 { margin-bottom: 1.5rem; }

    /* Header */
    .ret-header { display: flex; justify-content: space-between; align-items: center; }
    .btn-emerald { 
        background-color: var(--emerald-600); color: white; padding: 0.75rem 1.5rem; 
        border-radius: 0.75rem; font-weight: 700; text-decoration: none; 
        box-shadow: var(--shadow); transition: all 0.2s; border: none; cursor: pointer;
        display: inline-flex; align-items: center; gap: 0.5rem; justify-content: center;
    }
    .btn-emerald:hover:not(:disabled) { background-color: var(--emerald-700); transform: translateY(-2px); }
    .btn-emerald:disabled { background-color: var(--slate-100); color: var(--slate-400); cursor: not-allowed; box-shadow: none; }
    
    .btn-outline {
        border: 2px solid var(--slate-200); color: #64748b; padding: 0.6rem 1.25rem;
        border-radius: 0.75rem; font-weight: 700; text-decoration: none !important; transition: all 0.2s;
        display: inline-flex; align-items: center; gap: 0.5rem;
    }
    .btn-outline:hover { background: var(--slate-50); border-color: var(--slate-300); }

    /* Search Form */
    .search-form { display: flex; gap: 1rem; align-items: flex-end; }
    .form-group-search { flex: 1; }
    .search-input-wrapper { position: relative; }
    .search-input-wrapper i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--slate-400); font-size: 1.25rem; }
    .search-input-wrapper input { 
        width: 100%; padding: 1rem 1rem 1rem 3rem; background: var(--slate-50); 
        border: 2px solid var(--slate-100); border-radius: 0.75rem; outline: none; 
        font-weight: 700; color: var(--slate-700); font-size: 1.1rem; box-sizing: border-box;
    }
    .search-input-wrapper input:focus { border-color: var(--emerald-500); background: white; }

    /* Main Layout */
    .ret-main-layout { display: grid; grid-template-columns: 1fr 380px; gap: 1.5rem; align-items: start; }

    /* Data Card */
    .data-card { background: white; border-radius: 1rem; box-shadow: var(--shadow); overflow: hidden; border: 1px solid var(--slate-100); }
    .data-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--slate-100); }
    .data-body.p-4 { padding: 1.5rem; }
    .data-body.p-0 { padding: 0; }
    .border-bottom-slate { border-bottom: 1px solid var(--slate-100); }

    /* Sidebar Components */
    .form-group { margin-bottom: 1.25rem; }
    .stats-label { color: var(--slate-500); font-weight: 700; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.5rem; }
    .form-control-static { 
        width: 100%; padding: 0.75rem 1rem; background: var(--slate-50); 
        border-radius: 0.5rem; font-weight: 700; color: var(--slate-800); border: none; box-sizing: border-box;
    }
    .form-input { 
        width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--slate-50); 
        border-radius: 0.5rem; outline: none; font-weight: 500; box-sizing: border-box;
    }
    .form-input:focus { border-color: var(--emerald-500); }
    
    .total-box { 
        background: var(--emerald-50); padding: 1.25rem; border-radius: 1rem; 
        border: 1px solid var(--emerald-100); display: flex; justify-content: space-between; align-items: center;
    }
    .total-label { color: var(--emerald-700); font-weight: 800; font-size: 0.85rem; }
    .total-value { font-size: 1.5rem; font-weight: 800; color: var(--emerald-700); }

    /* Table */
    .table-container { width: 100%; overflow-x: auto; }
    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { background: var(--slate-50); padding: 0.75rem 1rem; text-align: left; font-size: 0.7rem; text-transform: uppercase; color: var(--slate-500); font-weight: 800; }
    .custom-table td { padding: 1rem; border-bottom: 1px solid var(--slate-50); }
    .custom-table.smaller td { padding: 0.75rem 1rem; }
    
    .batch-badge { background: var(--slate-50); border: 1px solid var(--slate-200); padding: 0.25rem 0.75rem; border-radius: 0.5rem; font-size: 0.85rem; font-weight: 600; color: var(--slate-700); }
    
    .input-qty-wrapper { max-width: 100px; margin-left: auto; }
    .return-qty { 
        width: 100%; text-align: right; border: 2px solid var(--slate-100); 
        border-radius: 0.5rem; padding: 0.5rem; font-weight: 700; color: var(--slate-700); box-sizing: border-box;
    }
    .return-qty:focus { border-color: var(--emerald-500); outline: none; }

    /* Empty State */
    .empty-state { text-align: center; padding: 4rem 2rem; }
    .empty-icon { color: var(--slate-200); margin-bottom: 1rem; opacity: 0.5; }

    .sticky-sidebar { position: sticky; top: 1.5rem; }

    @media (max-width: 1024px) {
        .ret-main-layout { grid-template-columns: 1fr; }
        .sticky-sidebar { position: static; }
        .search-form { flex-direction: column; align-items: stretch; }
        .btn-emerald { width: 100%; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        calculateGrandTotal();
    });

    function updateRowSubtotal(input) {
        const row = input.closest('tr');
        const price = parseFloat(input.dataset.price);
        const qty = parseInt(input.value) || 0;
        const subtotal = price * qty;
        
        row.querySelector('.row-subtotal').innerText = new Intl.NumberFormat('id-ID').format(subtotal);
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let grandTotal = 0;
        document.querySelectorAll('.return-qty').forEach(input => {
            const price = parseFloat(input.dataset.price);
            const qty = parseInt(input.value) || 0;
            grandTotal += price * qty;
        });
        
        document.getElementById('grand-total-return').innerText = new Intl.NumberFormat('id-ID').format(grandTotal);
        
        // Enable/Disable submit button
        const btnSubmit = document.getElementById('btn-submit');
        if (grandTotal > 0) {
            btnSubmit.disabled = false;
        } else {
            btnSubmit.disabled = true;
        }
    }
</script>
@endsection
