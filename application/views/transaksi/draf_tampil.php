<?php
// Ambil level pengguna dari sesi 
$level = $this->session->userdata('level');
$id_pengguna = $this->session->userdata('id_pengguna');
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tampil Draf Transaksi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Draf Transaksi</li>
                        <li class="breadcrumb-item active">Tampil Data</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <?php $this->load->view('template/notifikasi'); ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Data Draf Transaksi</h5>
                            <?php if ($level != "admin" && $level != "pengawas") : ?>
                                <a href="<?= base_url('transaksi') ?>" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i>Transaksi Baru</a>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-hover table-bordered" width="auto">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Pelanggan </th>
                                            <th>Barang</th>
                                            <th>jumlah</th>
                                            <th>Harga Jual</th>
                                            <th>Diskon</th>
                                            <th>total</th>
                                            <th>Status Penjualan</th>
                                            <th>tanggal input</th>
                                            <th>Penambah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($penjualan as $row) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row->nama_pelanggan; ?></td>
                                                <td>
                                                    <?php
                                                    // Memisahkan nilai jumlah menjadi array
                                                    $id_barang_array = explode('"', $row->id_barang);

                                                    // Menampilkan id_barang untuk setiap nilai yang ditemukan
                                                    foreach ($id_barang_array as $id_barang) {
                                                        foreach ($barang as $i) {
                                                            if ($i->id_barang == $id_barang) {
                                                                echo $i->merk . ' - ' . $i->bahan . ' - ' . $i->ukuran . '<br>'; // Tampilkan merk, bahan, dan ukuran
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    // Memisahkan nilai jumlah menjadi array
                                                    $jumlah_array = explode('"', $row->jumlah);

                                                    // Menampilkan jumlah untuk setiap nilai yang ditemukan
                                                    foreach ($jumlah_array as $jumlah) {
                                                        echo $jumlah . '<br>'; // Tampilkan jumlah
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    foreach ($id_barang_array as $id_barang) {
                                                        foreach ($barang as $i) {
                                                            if ($i->id_barang == $id_barang) {
                                                                echo number_format($i->harga_jual, 0, ',', '.') . '<br>';
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= $row->diskon; ?></td>
                                                <td><?= $row->total; ?></td>
                                                <td><?= $row->status; ?></td>
                                                <td><?= $row->tanggal_input; ?></td>
                                                <td><?= $row->nama_lengkap; ?></td>
                                                <td>
                                                <a href="<?= base_url('transaksi/ubah/' . $row->id_penjualan) ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- /.card -->
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

 