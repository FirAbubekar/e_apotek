    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Apotekku</h2>
        </div>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link active">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
            </li>

            <!-- Master Data -->
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" onclick="toggleDropdown(this)">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span>Master Data</span>
                    <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('obat.index') }}" class="dropdown-item">Obat</a></li>
                    <li><a href="{{ route('kategori-obat.index') }}" class="dropdown-item">Kategori Obat</a></li>
                    <li><a href="{{ route('satuan.index') }}" class="dropdown-item">Satuan</a></li>
                    <li><a href="{{ route('supplier.index') }}" class="dropdown-item">Supplier</a></li>
                    <li><a href="{{ route('pelanggan.index') }}" class="dropdown-item">Pelanggan</a></li>
                    <li><a href="#" class="dropdown-item">Dokter</a></li>
                    <li><a href="{{ route('users.index') }}" class="dropdown-item">User</a></li>
                </ul>
            </li>

            <!-- Transaksi -->
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" onclick="toggleDropdown(this)">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>Transaksi</span>
                    <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('pembelian.index') }}" class="dropdown-item">Pembelian</a></li>
                    <li><a href="#" class="dropdown-item">Penjualan</a></li>
                    <li><a href="#" class="dropdown-item">Penjualan Resep</a></li>
                    <li><a href="#" class="dropdown-item">Retur Pembelian</a></li>
                    <li><a href="#" class="dropdown-item">Retur Penjualan</a></li>
                </ul>
            </li>

            <!-- Stok -->
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" onclick="toggleDropdown(this)">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span>Stok</span>
                    <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#" class="dropdown-item">Stok Obat</a></li>
                    <li><a href="#" class="dropdown-item">Stok Opname</a></li>
                    <li><a href="#" class="dropdown-item">Mutasi Stok</a></li>
                    <li><a href="#" class="dropdown-item">Obat Expired</a></li>
                </ul>
            </li>

            <!-- Kasir -->
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" onclick="toggleDropdown(this)">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    <span>Kasir</span>
                    <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#" class="dropdown-item">Kas Masuk</a></li>
                    <li><a href="#" class="dropdown-item">Kas Keluar</a></li>
                    <li><a href="#" class="dropdown-item">Tutup Kasir</a></li>
                </ul>
            </li>

            <!-- Laporan -->
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" onclick="toggleDropdown(this)">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Laporan</span>
                    <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#" class="dropdown-item">Laporan Penjualan</a></li>
                    <li><a href="#" class="dropdown-item">Laporan Pembelian</a></li>
                    <li><a href="#" class="dropdown-item">Laporan Stok</a></li>
                    <li><a href="#" class="dropdown-item">Laporan Keuangan</a></li>
                </ul>
            </li>

            <!-- Pengaturan -->
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" onclick="toggleDropdown(this)">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Pengaturan</span>
                    <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#" class="dropdown-item">Profil Apotek</a></li>
                    <li><a href="#" class="dropdown-item">User Management</a></li>
                    <li><a href="#" class="dropdown-item">Backup Database</a></li>
                </ul>
            </li>
        </ul>

        <div class="user-profile">
            <div class="user-info">
                <div class="user-avatar">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <div>
                    <div class="user-name">{{ Auth::user()->name ?? 'User' }}</div>
                    <div class="user-role">{{ Auth::user()->role ?? 'Admin' }}</div>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
                @csrf
            </form>
            <button class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Logout">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </button>
        </div>
    </aside>

    <!-- Sidebar Dropdown Script -->
    <script>
        function toggleDropdown(element) {
            // Prevent default link behavior
            event.preventDefault();
            
            // Toggle active class on the link
            element.classList.toggle('active');
            
            // Get the next element (the ul)
            var dropdownMenu = element.nextElementSibling;
            
            // Toggle its visibility
            if (dropdownMenu.style.maxHeight) {
                dropdownMenu.style.maxHeight = null;
                dropdownMenu.style.opacity = 0;
            } else {
                dropdownMenu.style.maxHeight = dropdownMenu.scrollHeight + "px";
                dropdownMenu.style.opacity = 1;
            }
        }
    </script>
