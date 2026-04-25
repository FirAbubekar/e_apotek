@extends('layouts.app')

@section('page_title', 'Tutup Kasir / End of Shift')

@section('content')
<div class="closing-container">
    <div class="closing-header animate__animated animate__fadeIn">
        <h1 class="closing-title">Tutup Kasir & Rekonsiliasi</h1>
        <p class="closing-subtitle">Pastikan semua transaksi telah tercatat sebelum menutup shift ini.</p>
    </div>

    <form action="{{ route('tutup-kasir.store') }}" method="POST" id="closingForm">
        @csrf
        <div class="row">
            <!-- Left: Stats Summary -->
            <div class="col-xl-8 col-lg-7">
                <div class="stats-grid">
                    <div class="stat-card bg-emerald-50">
                        <label>Modal Awal</label>
                        <div class="val">Rp {{ number_format($openingCash, 0, ',', '.') }}</div>
                        <input type="hidden" name="opening_cash" value="{{ $openingCash }}">
                        <input type="hidden" name="opening_time" value="{{ $openingTime }}">
                    </div>
                    <div class="stat-card bg-sky-50">
                        <label>Penjualan Tunai</label>
                        <div class="val">+ Rp {{ number_format($cashSales, 0, ',', '.') }}</div>
                        <input type="hidden" name="total_cash_sales" value="{{ $cashSales }}">
                    </div>
                    <div class="stat-card bg-indigo-50">
                        <label>Pemasukan Lain</label>
                        <div class="val">+ Rp {{ number_format($otherIncome, 0, ',', '.') }}</div>
                        <input type="hidden" name="total_income" value="{{ $otherIncome }}">
                    </div>
                    <div class="stat-card bg-rose-50">
                        <label>Total Pengeluaran (Kas Keluar)</label>
                        <div class="val">- Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
                        <input type="hidden" name="total_expense" value="{{ $totalExpense }}">
                    </div>
                </div>

                <div class="info-card mt-4">
                    <div class="info-header">
                        <i class="fas fa-info-circle me-2"></i> Rincian Non-Tunai (Informasi)
                    </div>
                    <div class="info-body">
                        <div class="d-flex justify-content-between align-items-center mb-0">
                            <span>Total Penjualan Non-Tunai (Debit/QRIS/Transfer)</span>
                            <span class="font-bold">Rp {{ number_format($nonCashSales, 0, ',', '.') }}</span>
                        </div>
                        <input type="hidden" name="total_non_cash_sales" value="{{ $nonCashSales }}">
                    </div>
                </div>

                <div class="expected-card mt-4">
                    <div class="label">Saldo Kasir Seharusnya (Sistem)</div>
                    <div class="amount">Rp {{ number_format($expectedCash, 0, ',', '.') }}</div>
                    <input type="hidden" name="expected_cash" id="expected_cash" value="{{ $expectedCash }}">
                </div>
            </div>

            <!-- Right: Input Actual Cash -->
            <div class="col-xl-4 col-lg-5">
                <div class="input-card">
                    <div class="card-title">Perhitungan Fisik</div>
                    
                    <div class="form-group mb-4">
                        <label class="form-label">Total Uang Fisik di Laci (IDR)</label>
                        <div class="amount-input-group">
                            <span class="prefix">Rp</span>
                            <input type="number" name="actual_cash" id="actual_cash" step="0.01" required placeholder="0.00" class="amount-input">
                        </div>
                        <small class="text-muted">Gunakan nominal tanpa pemisah ribuan.</small>
                    </div>

                    <div class="diff-box" id="diffBox">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Selisih:</span>
                            <span id="diffValue" class="font-bold">Rp 0</span>
                        </div>
                        <div id="diffTag" class="status-tag tag-neutral">Belum Input</div>
                    </div>

                    <div class="form-group mt-4">
                        <label class="form-label">Catatan Tambahan (Optional)</label>
                        <textarea name="notes" rows="3" class="form-control-premium" placeholder="Misal: Selisih Rp 500 karena tidak ada kembalian..."></textarea>
                    </div>

                    <div class="btn-group-closing mt-4">
                        <button type="submit" class="btn-closing-submit" id="btnSubmit">
                            <i class="fas fa-check-circle me-2"></i> Proses Tutup Kasir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .closing-container { padding: 2rem; max-width: 1200px; margin: 0 auto; }
    .closing-title { font-size: 2rem; font-weight: 800; color: #1e293b; margin: 0; letter-spacing: -0.025em; }
    .closing-subtitle { color: #64748b; margin-top: 0.5rem; }
    
    .stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
    .stat-card { padding: 1.5rem; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); }
    .stat-card label { font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 0.5rem; display: block; }
    .stat-card .val { font-size: 1.25rem; font-weight: 800; color: #1e293b; }

    .info-card { background: white; border-radius: 1rem; border: 1px solid #e2e8f0; overflow: hidden; }
    .info-header { padding: 0.75rem 1.25rem; background: #f8fafc; font-size: 0.85rem; font-weight: 700; color: #475569; }
    .info-body { padding: 1.25rem; font-size: 0.95rem; }

    .expected-card { background: #0f172a; color: white; padding: 2.5rem; border-radius: 1.5rem; text-align: center; }
    .expected-card .label { font-size: 0.9rem; font-weight: 600; color: #94a3b8; margin-bottom: 0.5rem; }
    .expected-card .amount { font-size: 3rem; font-weight: 800; letter-spacing: -0.05em; }

    .input-card { background: white; border-radius: 1.5rem; border: 1px solid #e2e8f0; padding: 2rem; position: sticky; top: 2rem; }
    .input-card .card-title { font-size: 1.25rem; font-weight: 800; margin-bottom: 1.5rem; color: #1e293b; }
    
    .amount-input-group { display: flex; align-items: center; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 1rem; padding: 0.75rem 1.25rem; transition: all 0.2s; }
    .amount-input-group:focus-within { border-color: var(--primary-color); background: white; box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.1); }
    .amount-input-group .prefix { font-weight: 800; color: #64748b; font-size: 1.25rem; margin-right: 0.75rem; }
    .amount-input { border: none; background: transparent; width: 100%; font-size: 1.5rem; font-weight: 800; color: #1e293b; outline: none; }

    .diff-box { margin-top: 1.5rem; padding: 1.25rem; border-radius: 1rem; background: #f8fafc; }
    .status-tag { padding: 0.4rem 1rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; margin-top: 0.5rem; display: inline-block; }
    .tag-neutral { background: #e2e8f0; color: #64748b; }
    .tag-success { background: #dcfce7; color: #166534; }
    .tag-danger { background: #fee2e2; color: #991b1b; }

    .form-control-premium { width: 100%; padding: 0.75rem 1rem; border: 1px solid #e2e8f0; border-radius: 0.75rem; outline: none; transition: border-color 0.2s; }
    .form-control-premium:focus { border-color: var(--primary-color); }

    .btn-closing-submit { width: 100%; background: #0f172a; color: white; border: none; padding: 1.25rem; border-radius: 1rem; font-weight: 800; font-size: 1.1rem; cursor: pointer; transition: all 0.3s; }
    .btn-closing-submit:hover { background: #1e293b; transform: translateY(-3px); box-shadow: 0 10px 20px -5px rgba(0,0,0,0.2); }

    .font-bold { font-weight: 700; }
    .text-rose-600 { color: #e11d48; }
    .text-emerald-600 { color: #10b981; }

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
        .expected-card .amount { font-size: 2rem; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const expectedInput = document.getElementById('expected_cash');
        const actualInput = document.getElementById('actual_cash');
        const diffValue = document.getElementById('diffValue');
        const diffTag = document.getElementById('diffTag');
        const expected = parseFloat(expectedInput.value);

        actualInput.addEventListener('input', function() {
            const actual = parseFloat(this.value) || 0;
            const diff = actual - expected;
            
            diffValue.textContent = 'Rp ' + diff.toLocaleString('id-ID');
            
            if (diff === 0) {
                diffTag.textContent = 'Saldo Sesuai';
                diffTag.className = 'status-tag tag-success';
                diffValue.className = 'font-bold text-emerald-600';
            } else if (Math.abs(diff) < 1) {
                diffTag.textContent = 'Saldo Sesuai';
                diffTag.className = 'status-tag tag-success';
                diffValue.className = 'font-bold text-emerald-600';
            } else {
                diffTag.textContent = diff > 0 ? 'Kelebihan Kas' : 'Kekurangan Kas';
                diffTag.className = 'status-tag tag-danger';
                diffValue.className = 'font-bold text-rose-600';
            }
        });

        document.getElementById('closingForm').addEventListener('submit', function() {
            document.getElementById('btnSubmit').disabled = true;
            document.getElementById('btnSubmit').innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Sedang Memproses...';
        });
    });
</script>
@endsection
