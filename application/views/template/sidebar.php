<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url('dashboard') ?>" class="brand-link">
        <img src="<?php echo base_url('assets/dist/img/cahayalogo.png') ?>" alt="CAHAYA Logo" class="brand-image img-circle elevation-3" style="opacity: .9; width: 65px; height: auto;">
        <span class="brand-text font-weight-light">CAHAYA-APP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo base_url('assets/dist/img/user-9.png') ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a class="d-block">
                    <?php
                    $level = $this->session->userdata('level');
                    if ($level == '1') {
                        echo 'Admin';
                    } elseif ($level == '2') {
                        echo 'Karyawan';
                    }
                    ?>
                </a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <?php if ($level == '1' || $level == '2') : ?>
                    <!-- Dashboard -->
                    <li class="nav-item <?= ($this->uri->segment(1) == 'dashboard') ? 'menu-open' : ''; ?>">
                        <a href="<?= base_url('dashboard') ?>" class="nav-link <?= ($this->uri->segment(1) == 'dashboard') ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($level == '1' || $level == '2') : ?>
                    <!-- Data Barang -->
                    <li class="nav-item <?= ($this->uri->segment(1) == 'barang' && $this->uri->segment(2) != 'report_barang') ? 'menu-open' : ''; ?>">
                        <a href="<?= base_url('barang') ?>" class="nav-link <?= ($this->uri->segment(1) == 'barang' && $this->uri->segment(2) != 'report_barang') ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>Data Barang</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($level == '1' || $level == '2') : ?>
                    <!-- Pelanggan -->
                    <li class="nav-item <?= ($this->uri->segment(1) == 'pelanggan' || $this->uri->segment(1) == 'suplier') ? 'menu-open' : ''; ?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-store"></i>
                            <p>
                                Pelanggan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('pelanggan') ?>" class="nav-link <?= ($this->uri->segment(1) == 'pelanggan') ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pelanggan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('suplier') ?>" class="nav-link <?= ($this->uri->segment(1) == 'suplier') ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Suplier</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if ($level == '1' || $level == '2') : ?>
                    <!-- Transaksi -->
                    <li class="nav-item <?= ($this->uri->segment(1) == 'penjualan' || $this->uri->segment(1) == 'transaksi' || $this->uri->segment(1) == 'pembelian' || $this->uri->segment(1) == 'pengeluaran') ? 'menu-open' : ''; ?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Transaksi
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('penjualan/index') ?>" class="nav-link <?= ($this->uri->segment(1) == 'penjualan') ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Penjualan</p>
                                </a>
                            </li>
                            <?php if ($level == '2') : ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('transaksi') ?>" class="nav-link <?= ($this->uri->segment(1) == 'transaksi') ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Transaksi</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a href="<?= base_url('pembelian') ?>" class="nav-link <?= ($this->uri->segment(1) == 'pembelian') ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pembelian</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('pengeluaran') ?>" class="nav-link <?= ($this->uri->segment(1) == 'pengeluaran') ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pengeluaran</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if ($level == '1') : ?>
                    <!-- Laporan -->
                    <li class="nav-item <?= ($this->uri->segment(1) == 'stokkurang' || $this->uri->segment(1) == 'labarugi' || $this->uri->segment(1) == 'terlaris' || $this->uri->segment(1) == 'barang/report_barang' || $this->uri->segment(1) == 'penjualan/report' || $this->uri->segment(1) == 'pembelian/report' || $this->uri->segment(1) == 'pengeluaran/report') ? 'menu-open' : ''; ?>">
                        <a href="#" class="nav-link <?= ($this->uri->segment(1) == 'stokkurang' || $this->uri->segment(1) == 'labarugi' || $this->uri->segment(1) == 'terlaris' || $this->uri->segment(1) == 'barang/report_barang' || $this->uri->segment(1) == 'penjualan/report' || $this->uri->segment(1) == 'pembelian/report' || $this->uri->segment(1) == 'pengeluaran/report') ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Laporan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('stokkurang') ?>" class="nav-link <?= ($this->uri->segment(1) == 'stokkurang') ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Stok Barang Kurang</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('labarugi') ?>" class="nav-link <?= ($this->uri->segment(1) == 'labarugi') ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Laba Rugi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('terlaris') ?>" class="nav-link <?= ($this->uri->segment(1) == 'terlaris') ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Barang Terlaris</p>
                                </a>
                            </li>
                            <li class="nav-item <?= ($this->uri->segment(1) == 'barang' && $this->uri->segment(2) == 'report_barang') ? 'menu-open' : ''; ?>">
                                <a href="<?= base_url('barang/report_barang') ?>" class="nav-link <?= ($this->uri->segment(1) == 'barang' && $this->uri->segment(2) == 'report_barang') ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Data Barang</p>
                                </a>
                            </li>
                            <li class="nav-item <?= ($this->uri->segment(1) == 'penjualan' && $this->uri->segment(2) == 'report') ? 'menu-open' : ''; ?>">
                                <a href="<?= base_url('penjualan/report') ?>" class="nav-link <?= ($this->uri->segment(1) == 'penjualan' && $this->uri->segment(2) == 'report') ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Data Penjualan</p>
                                </a>
                            </li>
                            <li class="nav-item <?= ($this->uri->segment(1) == 'pembelian' && $this->uri->segment(2) == 'report') ? 'menu-open' : ''; ?>">
                                <a href="<?= base_url('pembelian/report') ?>" class="nav-link <?= ($this->uri->segment(1) == 'pembelian' && $this->uri->segment(2) == 'report') ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Data Pembelian</p>
                                </a>
                            </li>
                            <li class="nav-item <?= ($this->uri->segment(1) == 'prospek' && $this->uri->segment(2) == 'prospek') ? 'menu-open' : ''; ?>">
                                <a href="<?= base_url('prospek') ?>" class="nav-link <?= ($this->uri->segment(1) == 'prospek' && $this->uri->segment(2) == 'prospek') ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Prospek Penjualan</p>
                                </a>
                            </li>
                            <li class="nav-item <?= ($this->uri->segment(1) == 'pengeluaran' && $this->uri->segment(2) == 'report') ? 'menu-open' : ''; ?>">
                                <a href="<?= base_url('pengeluaran/report') ?>" class="nav-link <?= ($this->uri->segment(1) == 'pengeluaran' && $this->uri->segment(2) == 'report') ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Pengeluaran</p>
                                </a>
                            </li>
                            <li class="nav-item <?= ($this->uri->segment(1) == 'suplier' && $this->uri->segment(2) == 'report') ? 'menu-open' : ''; ?>">
                                <a href="<?= base_url('suplier/report') ?>" class="nav-link <?= ($this->uri->segment(1) == 'suplier' && $this->uri->segment(2) == 'report') ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Suplier</p>
                                </a>
                            </li>
                            <li class="nav-item <?= ($this->uri->segment(1) == 'pelanggan' && $this->uri->segment(2) == 'report') ? 'menu-open' : ''; ?>">
                                <a href="<?= base_url('pelanggan/report') ?>" class="nav-link <?= ($this->uri->segment(1) == 'pelanggan' && $this->uri->segment(2) == 'report') ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Pelanggan</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                <?php endif; ?>

                <?php if ($level == '1') : ?>
                    <!-- Master Data -->
                    <li class="nav-item <?= ($this->uri->segment(1) == 'kategori' || $this->uri->segment(1) == 'merk') ? 'menu-open' : ''; ?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-database"></i>
                            <p>
                                Master Data
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('kategori') ?>" class="nav-link <?= ($this->uri->segment(1) == 'kategori') ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Kategori</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('merk') ?>" class="nav-link <?= ($this->uri->segment(1) == 'merk') ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Merk</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if ($level == '1') : ?>
                    <!-- Pengguna -->
                    <li class="nav-item <?= ($this->uri->segment(1) == 'user') ? 'menu-open' : ''; ?>">
                        <a href="<?= base_url('user') ?>" class="nav-link <?= ($this->uri->segment(1) == 'user') ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Data User</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($level == '1' || $level == '2') : ?>
                    <!-- Logout -->
                    <li class="nav-item <?= ($this->uri->segment(1) == 'logout') ? 'menu-open' : ''; ?>">
                        <a href="<?= base_url('logout') ?>" class="nav-link <?= ($this->uri->segment(1) == 'logout') ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>
    </div>
</aside>

<script>
    $(document).ready(function() {
        // Function to handle menu states
        function handleMenuState() {
            $('.nav-sidebar .nav-item').each(function() {
                var $item = $(this);
                if ($item.find('> .nav-link.active').length > 0 || $item.find('> .nav-treeview > .nav-item > .nav-link.active').length > 0) {
                    $item.addClass('menu-open');
                    $item.find('> .nav-link').addClass('active');
                } else {
                    $item.removeClass('menu-open');
                    $item.find('> .nav-link').removeClass('active');
                }
            });

            // Special handling for "Laporan Data Pembelian"
            if ($('.nav-link[href="<?= base_url('pembelian/report') ?>"]').hasClass('active')) {
                $('.nav-item:has(.nav-link[href="#"])').removeClass('menu-open');
                $('.nav-link[href="#"]').removeClass('active');
                $('.nav-item:has(.nav-link[href="<?= base_url('pembelian/report') ?>"])').addClass('menu-open');
            }
            
            // Special handling for "Laporan Data Pembelian"
            if ($('.nav-link[href="<?= base_url('prospek') ?>"]').hasClass('active')) {
                $('.nav-item:has(.nav-link[href="#"])').removeClass('menu-open');
                $('.nav-link[href="#"]').removeClass('active');
                $('.nav-item:has(.nav-link[href="<?= base_url('prospek') ?>"])').addClass('menu-open');
            }

            // Special handling for "Laporan Data Penjualan"
            if ($('.nav-link[href="<?= base_url('penjualan/report') ?>"]').hasClass('active')) {
                $('.nav-item:has(.nav-link[href="#"])').removeClass('menu-open');
                $('.nav-link[href="#"]').removeClass('active');
                $('.nav-item:has(.nav-link[href="<?= base_url('penjualan/report') ?>"])').addClass('menu-open');
            }

            if ($('.nav-link[href="<?= base_url('barang/report_barang') ?>"]').hasClass('active')) {
                $('.nav-item:has(.nav-link[href="#"])').removeClass('menu-open');
                $('.nav-link[href="#"]').removeClass('active');
                $('.nav-item:has(.nav-link[href="<?= base_url('barang/report_barang') ?>"])').addClass('menu-open');
            }

            if ($('.nav-link[href="<?= base_url('pengeluaran/report') ?>"]').hasClass('active')) {
                $('.nav-item:has(.nav-link[href="#"])').removeClass('menu-open');
                $('.nav-link[href="#"]').removeClass('active');
                $('.nav-item:has(.nav-link[href="<?= base_url('pengeluaran/report') ?>"])').addClass('menu-open');
            }

            if ($('.nav-link[href="<?= base_url('suplier/report') ?>"]').hasClass('active')) {
                $('.nav-item:has(.nav-link[href="#"])').removeClass('menu-open');
                $('.nav-link[href="#"]').removeClass('active');
                $('.nav-item:has(.nav-link[href="<?= base_url('suplier/report') ?>"])').addClass('menu-open');
            }

            if ($('.nav-link[href="<?= base_url('pelanggan/report') ?>"]').hasClass('active')) {
                $('.nav-item:has(.nav-link[href="#"])').removeClass('menu-open');
                $('.nav-link[href="#"]').removeClass('active');
                $('.nav-item:has(.nav-link[href="<?= base_url('pelanggan/report') ?>"])').addClass('menu-open');
            }
        }

        // Call the function on page load
        handleMenuState();

        // Handle sidebar toggle button
        $('[data-widget="pushmenu"]').on('click', function(e) {
            e.preventDefault();
            if ($('body').hasClass('sidebar-collapse')) {
                $('body').removeClass('sidebar-collapse').addClass('sidebar-open');
            }
        });
    });
</script>