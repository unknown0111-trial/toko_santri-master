<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('/') }}" class="brand-link">
        <span class="brand-text font-weight-light">Toko Santri</span>
    </a>
    
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                
                <!-- ==================== DASHBOARD ==================== -->
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <!-- ==================== DATA MASTER (Dropdown) ==================== -->
                <li class="nav-item has-treeview {{ (in_array($activeMenu, ['karyawan', 'kitab', 'kategori', 'pengarang', 'penerbit', 'supplier'])) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Data Master
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- Data Karyawan -->
                        <li class="nav-item">
                            <a href="{{ url('/karyawan') }}" class="nav-link {{ ($activeMenu == 'karyawan') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Data Karyawan</p>
                            </a>
                        </li>
                        
                        <!-- Data Kitab -->
                        <li class="nav-item">
                            <a href="{{ url('/kitab') }}" class="nav-link {{ ($activeMenu == 'kitab') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Data Kitab</p>
                            </a>
                        </li>
                        
                        <!-- Data Kategori Kitab -->
                        <li class="nav-item">
                            <a href="{{ url('/kategori') }}" class="nav-link {{ ($activeMenu == 'kategori') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tag"></i>
                                <p>Kategori Kitab</p>
                            </a>
                        </li>
                        
                        <!-- Data Pengarang -->
                        <li class="nav-item">
                            <a href="{{ url('/pengarang') }}" class="nav-link {{ ($activeMenu == 'pengarang') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-edit"></i>
                                <p>Data Pengarang</p>
                            </a>
                        </li>
                        
                        <!-- Data Penerbit -->
                        <li class="nav-item">
                            <a href="{{ url('/penerbit') }}" class="nav-link {{ ($activeMenu == 'penerbit') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-building"></i>
                                <p>Data Penerbit</p>
                            </a>
                        </li>
                        
                        <!-- Data Supplier -->
                        <li class="nav-item">
                            <a href="{{ url('/supplier') }}" class="nav-link {{ ($activeMenu == 'supplier') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-truck"></i>
                                <p>Data Supplier</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- ==================== TRANSAKSI (Dropdown) ==================== -->
                <li class="nav-item has-treeview {{ (in_array($activeMenu, ['pembelian', 'penjualan'])) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-exchange-alt"></i>
                        <p>
                            Transaksi
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- Pembelian (dari supplier) -->
                        <li class="nav-item">
                            <a href="{{ url('/pembelian') }}" class="nav-link {{ ($activeMenu == 'pembelian') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>Pembelian</p>
                            </a>
                        </li>
                        
                        <!-- Penjualan (POS) -->
                        <li class="nav-item">
                            <a href="{{ url('/penjualan') }}" class="nav-link {{ ($activeMenu == 'penjualan') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cash-register"></i>
                                <p>Penjualan (POS)</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- ==================== MANAJEMEN STOK ==================== -->
                <li class="nav-item">
                    <a href="{{ url('/stok') }}" class="nav-link {{ ($activeMenu == 'stok') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>Manajemen Stok</p>
                    </a>
                </li>
                
                <!-- ==================== DATA PELANGGAN & SANTRI (Dropdown) ==================== -->
                <li class="nav-item has-treeview {{ (in_array($activeMenu, ['pelanggan', 'santri', 'paket_kitab'])) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Pelanggan & Santri
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/pelanggan') }}" class="nav-link {{ ($activeMenu == 'pelanggan') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Data Pelanggan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/santri') }}" class="nav-link {{ ($activeMenu == 'santri') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>Data Santri</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/paket-kitab') }}" class="nav-link {{ ($activeMenu == 'paket_kitab') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-boxes"></i>
                                <p>Paket Kitab</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- ==================== LAPORAN (Dropdown) ==================== -->
                <li class="nav-item has-treeview {{ (in_array($activeMenu, ['laporan_penjualan', 'laporan_persediaan'])) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Laporan
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/laporan/penjualan') }}" class="nav-link {{ ($activeMenu == 'laporan_penjualan') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>Laporan Penjualan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/laporan/persediaan') }}" class="nav-link {{ ($activeMenu == 'laporan_persediaan') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Laporan Persediaan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
            </ul>
        </nav>
    </div>
</aside>