@extends('layouts.app')

@section('title', 'Kasir (POS) - Apotekku')
@section('page_title', 'Kasir (POS)')

@section('styles')
<style>
    :root {
        --pos-emerald: #064e4b;
        --pos-emerald-light: #0d9488;
        --pos-bg: #f8fafc;
        --pos-border: #e2e8f0;
        --pos-text-main: #1e293b;
        --pos-text-muted: #64748b;
    }

    body { background-color: var(--pos-bg); color: var(--pos-text-main); font-family: 'Inter', system-ui, -apple-system, sans-serif; }

    .pos-wrapper {
        display: grid;
        grid-template-columns: 1fr 420px;
        gap: 1.25rem;
        max-width: 1600px;
        margin: 0 auto;
        padding: 0 1rem 2rem 1rem;
    }

    /* Top Header */
    .pos-header-info {
        background: white; border: 1px solid var(--pos-border);
        color: var(--pos-text-main); border-radius: 1rem;
        padding: 1rem 1.5rem; margin-bottom: 1rem;
        display: flex; justify-content: space-between; align-items: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .header-item-p label {
        display: block; font-size: 0.65rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.05rem;
        color: var(--pos-text-muted); margin-bottom: 0.15rem;
    }
    .header-item-p .val { font-size: 0.95rem; font-weight: 800; color: var(--pos-emerald); }

    /* Cards */
    .card-pos {
        background: white; border-radius: 1rem;
        border: 1px solid var(--pos-border);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.01);
        overflow: hidden;
    }

    /* Search Section */
    .search-section-p { position: relative; padding: 1.25rem; background: white; border-bottom: 1px solid var(--pos-border); }
    .pos-input-group { position: relative; display: flex; align-items: center; }
    .pos-input-group .icon {
        position: absolute; left: 1.25rem; top: 50%; transform: translateY(-50%);
        color: var(--pos-text-muted);
        display: flex; align-items: center; justify-content: center;
        pointer-events: none;
    }
    .input-search-p {
        width: 100%; height: 3.5rem; padding: 0 1.5rem 0 3.5rem;
        font-size: 1rem; font-weight: 500; border: 1px solid var(--pos-border);
        border-radius: 0.75rem; background: #f1f5f9; transition: all 0.2s;
    }
    .input-search-p:focus {
        background: white; border-color: var(--pos-emerald-light); outline: none;
        box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.08);
    }

    /* Table Styling */
    .pos-table { width: 100%; border-collapse: collapse; }
    .pos-table th { 
        padding: 0.875rem 1.25rem; background: #f8fafc; color: var(--pos-text-muted);
        font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.05rem; border-bottom: 1px solid var(--pos-border);
    }
    .pos-table td { padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .pos-table tr:hover td { background: #fcfdfe; }

    .p-item-name { font-weight: 700; color: var(--pos-text-main); display: block; font-size: 0.95rem; }
    .p-item-sub { font-size: 0.75rem; color: var(--pos-text-muted); font-weight: 500; }

    .p-qty-input {
        width: 60px; height: 36px; border-radius: 0.5rem;
        border: 1px solid var(--pos-border); text-align: center; font-weight: 700;
        background: #f8fafc;
    }
    .p-qty-input:focus { border-color: var(--pos-emerald-light); outline: none; background: white; }

    .btn-rem-p {
        width: 32px; height: 32px; border-radius: 0.5rem;
        border: none; background: #fee2e2; color: #ef4444;
        cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center;
    }
    .btn-rem-p:hover { background: #ef4444; color: white; }

    /* Payment Sidebar */
    .sidebar-pos { position: sticky; top: 1rem; }
    .payment-section-title {
        font-size: 0.75rem; font-weight: 700; color: var(--pos-text-muted);
        text-transform: uppercase; letter-spacing: 0.05rem;
        display: block; margin-bottom: 1rem; border-bottom: 1px solid var(--pos-border);
        padding-bottom: 0.5rem;
    }

    .form-group-p { margin-bottom: 1rem; }
    .form-group-p label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--pos-text-main); margin-bottom: 0.35rem; }
    
    .select-p, .input-p { 
        width: 100%; height: 2.75rem; padding: 0 0.875rem; border-radius: 0.625rem; 
        border: 1px solid var(--pos-border); background: #f8fafc; font-weight: 500;
        transition: all 0.2s; font-size: 0.9rem;
    }
    .select-p:focus, .input-p:focus { border-color: var(--pos-emerald-light); outline: none; background: white; }

    .btn-tipe { 
        flex: 1; padding: 0.625rem; text-align: center; border: 1px solid var(--pos-border); 
        border-radius: 0.625rem; font-size: 0.85rem; font-weight: 600; 
        color: var(--pos-text-muted); cursor: pointer; transition: all 0.2s;
    }
    .btn-tipe.active { background: var(--pos-emerald); color: white; border-color: var(--pos-emerald); }

    .sum-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; }
    .sum-row label { color: var(--pos-text-muted); font-weight: 500; font-size: 0.85rem; }
    .sum-row .val { font-weight: 700; color: var(--pos-text-main); font-size: 0.85rem; }

    .total-display-p {
        background: #0f172a; color: white; padding: 1.25rem; border-radius: 0.875rem;
        margin: 1.25rem 0; text-align: right; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    }
    .total-display-p .label-t { font-size: 0.65rem; font-weight: 600; text-transform: uppercase; opacity: 0.6; letter-spacing: 0.05rem; }
    .total-display-p .val-t { font-size: 1.875rem; font-weight: 800; margin-top: 0.15rem; letter-spacing: -0.025rem; }

    .inp-pay-big {
        width: 100%; height: 3.75rem; padding: 0 1.25rem;
        font-size: 1.75rem; font-weight: 800; text-align: right;
        border: 1px solid var(--pos-border); border-radius: 0.875rem;
        color: var(--pos-emerald); background: white; 
    }
    .inp-pay-big:focus { border-color: var(--pos-emerald-light); box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.08); outline: none; }

    .change-box-p {
        margin-top: 0.75rem; padding: 0.875rem 1.25rem; border-radius: 0.875rem;
        background: #f1f5f9; display: flex; justify-content: space-between; align-items: center;
        border: 1px solid var(--pos-border);
    }
    .change-box-p label { font-size: 0.75rem; font-weight: 700; color: var(--pos-text-muted); text-transform: uppercase; }
    .change-box-p .val-c { font-size: 1.25rem; font-weight: 800; color: var(--pos-text-main); }

    .btn-finish-p {
        width: 100%; height: 3.75rem; margin-top: 1.25rem;
        background: var(--pos-emerald-light); color: white;
        border: none; border-radius: 0.875rem; font-size: 1.1rem; font-weight: 700;
        cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 0.625rem;
    }
    .btn-finish-p:hover:not(:disabled) { background: #0d8a7f; transform: translateY(-1px); }
    .btn-finish-p:disabled { opacity: 0.5; cursor: not-allowed; }

    /* Results Dropdown */
    .p-results {
        position: absolute; top: 100%; left: 1.25rem; right: 1.25rem;
        background: white; border-radius: 0.875rem; border: 1px solid var(--pos-border);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
        z-index: 9999; max-height: 400px; overflow-y: auto; display: none;
        margin-top: -0.5rem; /* Slightly overlap to look integrated */
    }
    .p-result-item {
        padding: 0.875rem 1.25rem; cursor: pointer; border-bottom: 1px solid #f1f5f9;
        display: flex; justify-content: space-between; align-items: center;
        transition: all 0.2s;
    }
    .p-result-item:hover { background: #f8fafc; }
    .p-result-item:last-child { border-bottom: none; }
    .p-result-item .name-p { font-weight: 700; color: var(--pos-text-main); font-size: 0.95rem; }
    .p-result-item .info-p { font-size: 0.75rem; color: var(--pos-text-muted); margin-top: 0.1rem; }
    .p-result-item .price-p { font-weight: 800; color: var(--pos-emerald-light); font-size: 1rem; }

    .text-right { text-align: right !important; }
    .text-center { text-align: center !important; }
    .d-none { display: none; }

    /* Expiry Badges */
    .badge-expiry { font-size: 0.6rem; font-weight: 700; padding: 1px 6px; border-radius: 4px; text-transform: uppercase; }
    .expiry-safe { background: #dcfce7; color: #15803d; }
    .expiry-danger { background: #fee2e2; color: #b91c1c; }

    .btn-back-p {
        display: flex; align-items: center; gap: 0.5rem;
        padding: 0.625rem 1rem; border-radius: 0.75rem;
        background: #f8fafc; color: var(--pos-text-main);
        text-decoration: none; font-weight: 700; font-size: 0.85rem;
        transition: all 0.2s; border: 1px solid var(--pos-border);
    }
    .btn-back-p:hover { background: #f1f5f9; color: var(--pos-emerald); border-color: var(--pos-emerald-light); transform: translateX(-3px); }
</style>
@endsection

@section('content')

<form action="{{ route('penjualan.store') }}" method="POST" id="posForm" style="padding: 1.5rem">
    @csrf

    @if($errors->any())
    <div style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.25rem;">
        <ul style="margin: 0; padding-left: 1.25rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <!-- Top Header Info -->
    <div class="pos-header-info" style="max-width: 1600px; margin: 0 auto 1.25rem auto;">
        <div style="display: flex; align-items: center; gap: 2.5rem;">
            <a href="{{ route('penjualan.index') }}" class="btn-back-p">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
            
            <div style="width: 1px; height: 32px; background: var(--pos-border);"></div>

            <div class="header-item-p">
                <label>Nomor Transaksi</label>
                <div class="val">{{ $noTransaksi }}</div>
                <input type="hidden" name="no_transaksi" value="{{ $noTransaksi }}">
            </div>

            <div class="header-item-p">
                <label>Petugas Kasir</label>
                <div class="val">{{ Auth::user()->name }}</div>
            </div>
        </div>

        <div class="header-item-p" style="text-align: right">
            <label>Tanggal</label>
            <div class="val">{{ date('d M Y') }}</div>
            <input type="hidden" name="tanggal_penjualan" value="{{ date('Y-m-d') }}">
        </div>
    </div>

    <div class="pos-wrapper">
        <!-- Main Area: Cart -->
        <div class="pos-main">
            <div class="card-pos">
                <div class="search-section-p">
                    <div class="pos-input-group">
                        <div class="icon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" id="medicineSearch" class="input-search-p" placeholder="Cari Nama Obat, Kode, atau Scan Barcode..." autocomplete="off">
                    </div>
                    <div id="searchResults" class="p-results"></div>
                </div>

                <div style="min-height: 400px">
                    <table class="pos-table" id="posTable">
                        <thead>
                            <tr>
                                <th class="text-left">Deskripsi Obat</th>
                                <th width="140" class="text-right">Harga</th>
                                <th width="100" class="text-center">Qty</th>
                                <th width="140" class="text-right">Subtotal</th>
                                <th width="60" class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody id="cartItems">
                            <!-- Populated by JS -->
                        </tbody>
                    </table>
                    
                    <div id="emptyCart" style="padding: 10rem 2rem; text-align: center;">
                        <div style="opacity: 0.1; margin-bottom: 1.5rem">
                            <svg width="80" height="80" fill="currentColor" viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
                        </div>
                        <h4 style="color: #94a3b8; font-weight: 700; font-size: 1.1rem">Keranjang masih kosong</h4>
                        <p style="color: #cbd5e1; font-size: 0.9rem; margin-top: 0.5rem">Cari dan tambahkan obat untuk memulai transaksi</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Area: Transaction Info -->
        <div class="sidebar-pos">
            <div class="card-pos" style="padding: 1.75rem">
                <span class="payment-section-title">Konfigurasi Transaksi</span>
                
                <div class="form-group-p">
                    <label>Tipe Penjualan</label>
                    <div style="display: flex; gap: 0.5rem">
                        <input type="radio" name="tipe_penjualan" value="Retail" id="tRetail" class="d-none" checked>
                        <label for="tRetail" class="btn-tipe active" onclick="setTipe('Retail')">Retail</label>
                        
                        <input type="radio" name="tipe_penjualan" value="Resep" id="tResep" class="d-none">
                        <label for="tResep" class="btn-tipe" onclick="setTipe('Resep')">Resep</label>
                    </div>
                </div>

                <div id="resepFields" style="display: none; border-left: 3px solid var(--pos-emerald-light); padding-left: 1rem; margin-bottom: 1rem;">
                    <div class="form-group-p">
                        <label>Dokter Pemeriksa</label>
                        <input type="text" name="dokter" class="select-p" placeholder="Nama dokter...">
                    </div>
                    <div class="form-group-p">
                        <label>No. Resep</label>
                        <input type="text" name="no_resep" class="select-p" placeholder="e.g. R/123-ABC">
                    </div>
                </div>

                <div class="form-group-p">
                    <label>Pelanggan / Pasien</label>
                    <select name="pelanggan_id" class="select-p">
                        <option value="">-- Customer Umum --</option>
                        @foreach($pelanggans as $c)
                            <option value="{{ $c->id }}">{{ $c->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group-p">
                    <label>Metode Pembayaran</label>
                    <select name="metode_pembayaran" id="metodePembayaran" class="select-p" onchange="updateChange()">
                        <option value="Tunai">💰 Tunai</option>
                        <option value="Debit">💳 Kartu Debit</option>
                        <option value="Transfer">🏦 Transfer Bank</option>
                        <option value="QRIS">📱 QRIS</option>
                    </select>
                </div>

                <div style="margin: 1.5rem 0; padding: 1rem 0; border-top: 1px solid var(--pos-border); border-bottom: 1px solid var(--pos-border);">
                    <div class="sum-row">
                        <label>Subtotal Bruto</label>
                        <span class="val" id="labelSubtotal">Rp 0</span>
                        <input type="hidden" name="subtotal" id="inputSubtotal" value="0">
                    </div>
                    <div class="sum-row">
                        <label>Diskon (Nominal)</label>
                        <input type="number" name="diskon" id="inputDiskon" value="0" class="text-right" style="width: 100px; border: 1px solid var(--pos-border); border-radius: 4px; font-weight: 700; color: #ef4444;" oninput="calculateTotal()">
                    </div>
                    <div class="sum-row">
                        <label>PPN (11%)</label>
                        <span class="val" id="labelPPN">Rp 0</span>
                        <input type="hidden" name="ppn" id="inputPPN" value="0">
                    </div>
                </div>

                <div class="total-display-p">
                    <div class="label-t">Total Tagihan</div>
                    <div class="val-t" id="labelGrandTotal">Rp 0</div>
                    <input type="hidden" name="total_harga" id="inputGrandTotal" value="0">
                </div>

                <div class="form-group-p" style="margin-top: 3rem">
                    <label style="color: var(--pos-emerald); font-weight: 800; opacity: 0.8">CASH / BAYAR (F8)</label>
                    <input type="number" name="bayar" id="inputBayar" class="inp-pay-big" placeholder="0">
                </div>

                <div class="change-box-p">
                    <label>Kembalian</label>
                    <span class="val-c" id="labelKembali">Rp 0</span>
                </div>

                <button type="submit" class="btn-finish-p" id="btnSubmit" disabled>
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Selesaikan (F9)
                </button>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<style>
    .btn-tipe { 
        flex: 1; padding: 0.75rem; text-align: center; border: 2px solid #f3f4f6; border-radius: 0.75rem; 
        cursor: pointer; font-weight: 700; color: #6b7280; transition: all 0.2s;
    }
    .btn-tipe.active { border-color: var(--pos-emerald); background: #f0fdf4; color: var(--pos-emerald); }
    .d-none { display: none; }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<script>
    const obats = @json($obats);
    let cart = [];

    const searchInput = document.getElementById('medicineSearch');
    const searchResults = document.getElementById('searchResults');
    const cartItems = document.getElementById('cartItems');
    const emptyCart = document.getElementById('emptyCart');

    function setTipe(tipe) {
        const tRetail = document.getElementById('tRetail');
        const tResep = document.getElementById('tResep');
        const resepFields = document.getElementById('resepFields');
        
        document.querySelectorAll('.btn-tipe').forEach(b => b.classList.remove('active'));
        
        if (tipe === 'Resep') {
            if(tResep) tResep.checked = true;
            const lbl = document.querySelector('label[for="tResep"]');
            if(lbl) lbl.classList.add('active');
            if(resepFields) resepFields.style.display = 'block';
        } else {
            if(tRetail) tRetail.checked = true;
            const lbl = document.querySelector('label[for="tRetail"]');
            if(lbl) lbl.classList.add('active');
            if(resepFields) resepFields.style.display = 'none';
        }
    }

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        if (query.length < 1) {
            searchResults.style.display = 'none';
            return;
        }

        const filtered = obats.filter(o => 
            o.medicine_name.toLowerCase().includes(query) || 
            (o.medicine_code && o.medicine_code.toLowerCase().includes(query))
        ).slice(0, 10);

        if (filtered.length > 0) {
            searchResults.innerHTML = filtered.map(o => {
                const totalStock = o.medicine_stocks.reduce((acc, s) => acc + s.stock_qty, 0);
                const expiry = o.medicine_stocks[0]?.batch?.expired_date;
                const expiryDate = expiry ? new Date(expiry) : null;
                const isNearExpiry = expiryDate && (expiryDate - new Date()) / (1000 * 60 * 60 * 24) < 90;
                
                return `
                    <div class="p-result-item" onclick='addToCart(${JSON.stringify(o).replace(/'/g, "&apos;")})'>
                        <div class="meta-p">
                            <span class="name-p">${o.medicine_name}</span>
                            <div style="display: flex; gap: 0.5rem; align-items: center; margin-top: 0.25rem">
                                <span class="info-p">${o.medicine_code || '-'} | Stok: ${totalStock}</span>
                                ${expiry ? `<span class="badge-expiry ${isNearExpiry ? 'expiry-danger' : 'expiry-safe'}">${expiry}</span>` : ''}
                            </div>
                        </div>
                        <span class="price-p">Rp ${new Intl.NumberFormat('id-ID').format(o.selling_price)}</span>
                    </div>
                `;
            }).join('');
            searchResults.style.display = 'block';
        } else {
            searchResults.style.display = 'none';
        }
    });

    window.addToCart = (medicine) => {
        try {
            const existing = cart.find(item => item.id === medicine.id);
            const totalStock = medicine.medicine_stocks.reduce((acc, s) => acc + (parseInt(s.stock_qty) || 0), 0);

            if (existing) {
                if (existing.qty + 1 > totalStock) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({ icon: 'warning', title: 'Stok Terbatas', text: 'Hanya tersedia ' + totalStock + ' unit.' });
                    } else {
                        alert('Stok Terbatas: Hanya tersedia ' + totalStock + ' unit.');
                    }
                    return;
                }
                existing.qty += 1;
            } else {
                if (totalStock < 1) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({ icon: 'error', title: 'Stok Kosong', text: 'Obat ini sedang tidak tersedia.' });
                    } else {
                        alert('Stok Kosong: Obat ini sedang tidak tersedia.');
                    }
                    return;
                }
                cart.push({
                    id: medicine.id,
                    name: medicine.medicine_name,
                    code: medicine.medicine_code,
                    unit: medicine.satuan ? medicine.satuan.unit_name : 'Pcs',
                    price: medicine.selling_price,
                    qty: 1,
                    stock: totalStock
                });
            }

            searchInput.value = '';
            if (searchResults) searchResults.style.display = 'none';
            renderCart();
            if (searchInput) searchInput.focus();
        } catch (e) {
            console.error("Add to cart error:", e);
        }
    };

    function renderCart() {
        if (cart.length === 0) {
            cartItems.innerHTML = '';
            emptyCart.style.display = 'block';
        } else {
            emptyCart.style.display = 'none';
            cartItems.innerHTML = cart.map((item, index) => `
                <tr>
                    <td>
                        <span class="p-item-name">${item.name}</span>
                        <span class="p-item-sub">${item.code || '-'} | ${item.unit}</span>
                        <input type="hidden" name="items[${index}][obat_id]" value="${item.id}">
                    </td>
                    <td class="text-right" style="color: #4b5563; font-weight: 700">
                        Rp ${new Intl.NumberFormat('id-ID').format(item.price)}
                        <input type="hidden" name="items[${index}][harga]" value="${item.price}">
                    </td>
                    <td class="text-center">
                        <input type="number" name="items[${index}][jumlah]" class="p-qty-input" value="${item.qty}" min="1" max="${item.stock}" onchange="updateQty(${index}, this.value)">
                    </td>
                    <td class="text-right" style="font-weight: 800; color: var(--pos-emerald-light); font-size: 1rem">
                        Rp ${new Intl.NumberFormat('id-ID').format(item.price * item.qty)}
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn-rem-p" onclick="removeFromCart(${index})">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </td>
                </tr>
            `).join('');
        }
        calculateTotal();
    }

    window.updateQty = (index, val) => {
        val = parseInt(val);
        if (isNaN(val) || val < 1) val = 1;
        if (val > cart[index].stock) {
            Swal.fire({ icon: 'warning', title: 'Stok Terbatas', text: 'Stok tersedia: ' + cart[index].stock });
            val = cart[index].stock;
        }
        cart[index].qty = val;
        renderCart();
    };

    window.removeFromCart = (index) => {
        cart.splice(index, 1);
        renderCart();
    };

    function calculateTotal() {
        if (!cartItems) return;

        const subtotal = cart.reduce((acc, item) => acc + (Number(item.price) * item.qty), 0);
        const inputDiskon = document.getElementById('inputDiskon');
        const diskon = inputDiskon ? (parseInt(inputDiskon.value) || 0) : 0;
        const ppn = Math.round((subtotal - diskon) * 0.11);
        const grandTotal = Math.max(0, (subtotal - diskon) + ppn);

        const lblSubtotal = document.getElementById('labelSubtotal');
        if (lblSubtotal) lblSubtotal.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
        const inpSubtotal = document.getElementById('inputSubtotal');
        if (inpSubtotal) inpSubtotal.value = subtotal;
        
        const lblPPN = document.getElementById('labelPPN');
        if (lblPPN) lblPPN.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(ppn);
        const inpPPN = document.getElementById('inputPPN');
        if (inpPPN) inpPPN.value = ppn;
        
        const lblGrandTotal = document.getElementById('labelGrandTotal');
        if (lblGrandTotal) lblGrandTotal.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(grandTotal);
        const inpGrandTotal = document.getElementById('inputGrandTotal');
        if (inpGrandTotal) inpGrandTotal.value = grandTotal;
        
        updateChange();
    }

    function updateChange() {
        const inpGrandTotal = document.getElementById('inputGrandTotal');
        const total = inpGrandTotal ? parseInt(inpGrandTotal.value) : 0;
        
        const inputBayar = document.getElementById('inputBayar');
        const bayar = inputBayar ? (parseInt(inputBayar.value) || 0) : 0;
        
        const selectMetode = document.getElementById('metodePembayaran');
        const metode = selectMetode ? selectMetode.value : 'Tunai';
        
        const kembali = bayar - total;
        
        const labelKembali = document.getElementById('labelKembali');
        if (labelKembali) {
            labelKembali.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.max(0, kembali));
        }

        const btnSubmit = document.getElementById('btnSubmit');
        if (btnSubmit) {
            if (metode !== 'Tunai') {
                btnSubmit.disabled = (total <= 0);
                if (labelKembali) labelKembali.style.color = '#111827';
            } else {
                btnSubmit.disabled = (total <= 0 || bayar < total);
                if (labelKembali) labelKembali.style.color = (bayar >= total && total > 0) ? '#16a34a' : '#111827';
            }
        }
    }

    const inputBayar = document.getElementById('inputBayar');
    if (inputBayar) {
        inputBayar.addEventListener('input', updateChange);
    }

    // KEYBOARD SHORTCUTS
    document.addEventListener('keydown', function(e) {
        if (e.key === 'F8') { e.preventDefault(); inputBayar.focus(); }
        if (e.key === 'F9' && !btnSubmit.disabled) { 
            e.preventDefault(); 
            console.log("Submitting form...");
            document.getElementById('posForm').submit(); 
        }
        if (e.key === 'Escape') { if (confirm('Batalkan transaksi ini?')) window.location.href = "{{ route('penjualan.index') }}"; }
        if (e.key === 'Enter' && document.activeElement === searchInput && searchResults.style.display === 'block') {
             // Logic to pick first result
             const firstResult = searchResults.querySelector('.p-result-item');
             if (firstResult) firstResult.click();
        }
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });
</script>
@endpush
