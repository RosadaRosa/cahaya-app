<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?php echo base_url('assets/dist/img/cahayalogo.png') ?>" alt="CAHAYA Logo" class="brand-image img-circle elevation-3" style="opacity: .9; width: 65px; height: auto;">
        <span class="brand-text font-weight-light">CAHAYA-APP</span>
        <!-- <style>
        .main-sidebar {
            background-color: #2F3645; /* Set background color */
        }
    </style> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo base_url('assets/dist/img/user-9.png') ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a class="d-block"><?php $level = $this->session->userdata('level');
                                    if ($level == '1') {
                                        echo '<a class="d-block">Admin</a>';
                                    } elseif ($level == '2') {
                                        echo '<a class="d-block">Pegawai</a>';
                                    } else {
                                    }
                                    ?>
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
                    <li class="nav-item <?= ($this->uri->segment(1) == 'barang') ? 'menu-open' : ''; ?>">

                        <a href="<?= base_url('barang') ?>" class="nav-link <?= ($this->uri->segment(1) == 'barang') ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>Data Barang</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($level == '1' || $level == '2') : ?>
                    <!-- Hotel -->
                    <li class="nav-item <?= ($this->uri->segment(1) == 'hotel1' || $this->uri->segment(1) == 'hotel2') ? 'menu-open' : ''; ?>">
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
                    <!-- Hotel -->
                    <li class="nav-item <?= ($this->uri->segment(1) == 'penjualan' || $this->uri->segment(1) == 'penjualan') ? 'menu-open' : ''; ?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Transaksi
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('penjualan') ?>" class="nav-link <?= ($this->uri->segment(1) == 'penjualan') ? 'active' : ''; ?>">
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
                            <!-- <li class="nav-item">
                                <a href="<//?= base_url('returnbarang') ?>" class="nav-link <//?= ($this->uri->segment(1) == 'returnbarang') ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Return Barang</p>
                                </a>
                            </li> -->
                            <li class="nav-item">
                                <a href="<?= base_url('pengeluaran') ?>" class="nav-link <?= ($this->uri->segment(1) == 'pengeluaran') ? 'active' : ''; ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pengeluaran</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if ($level == '1' || $level == '2') : ?>
                    <!-- Laporan -->
                    <li class="nav-item <?= ($this->uri->segment(1) == 'stokkurang' || $this->uri->segment(1) == 'reporthotel') ? 'menu-open' : ''; ?>">
                        <a href="#" class="nav-link">
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
                                    <p>Terlaris</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if ($level == '1') : ?>
                    <!-- Master Data -->
                    <li class="nav-item <?= ($this->uri->segment(1) == 'hd4' || $this->uri->segment(1) == 'hd51' || $this->uri->segment(1) == 'hotel' || $this->uri->segment(1) == 'pengguna') ? 'menu-open' : ''; ?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-database"></i>
                            <p>
                                Master Data
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- <li class="nav-item">
                        <a href="<?= base_url('hd4') ?>" class="nav-link <?= ($this->uri->segment(1) == 'hd4') ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Data Peternakan</p>
                        </a>
                    </li> -->
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
                            <p>
                                <?php
                                // Teks berdasarkan level
                                if ($level == '1') {
                                    echo 'Data User';
                                }
                                ?>
                            </p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($level == '1' || $level == '2') : ?>
                    <!-- Pengguna -->
                    <li class="nav-item <?= ($this->uri->segment(1) == 'logout') ? 'menu-open' : ''; ?>">
                        <a href="<?= base_url('logout') ?>" class="nav-link <?= ($this->uri->segment(1) == 'logout') ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>


        <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
        <!-- Hotel -->


        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>