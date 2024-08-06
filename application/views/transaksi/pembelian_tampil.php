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
                    <h1 class="m-0">pembelian</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">pembelian</li>
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
                            <h5 class="card-title">Data pembelian</h5>
                            <?php if ($level != "admin" && $level != "pengawas") : ?>
                                <a href="<?= base_url('pembelian/tambah') ?>" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i> Tambah Data</a>
                            <?php endif; ?>
                            <button onclick="cetakLaporanPembelian()" class="btn btn-info btn-sm float-right mr-2"><i class="fa fa-print"></i> Cetak Laporan</button>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <select id="filter_barang" class="form-control">
                                        <option value="">Semua Barang</option>
                                        <?php
                                        $unique_barang = array_unique(array_column($pembelian, 'id_barang'));
                                        foreach ($unique_barang as $id_barang) {
                                            foreach ($barang as $b) {
                                                if ($b->id_barang == $id_barang) {
                                                    echo "<option value='" . $b->merk . " - " . $b->bahan . " - " . $b->ukuran . "'>" . $b->merk . " - " . $b->bahan . " - " . $b->ukuran . "</option>";
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="month" id="filter_bulan_tahun" class="form-control" value="<?= date('Y-m') ?>">
                                </div>
                                <div class="col-md-2">
                                    <button id="btn_filter" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="table table-hover table-bordered" width="auto">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Supplier </th>
                                            <th>Barang</th>
                                            <th>jumlah</th>
                                            <th>Harga Beli</th>
                                            <th>total</th>
                                            <th>tanggal input</th>
                                            <th>Penambah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($pembelian as $row) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row->nama_suplier; ?></td>
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
                                                                echo number_format($i->harga_beli, 0, ',', '.') . '<br>';
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= $row->total; ?></td>
                                                <td><?= $row->tanggal_input; ?></td>
                                                <td><?= $row->nama_lengkap; ?></td>
                                                <td>

                                                    <a href="<?= base_url('pembelian/ubah/' . $row->id_pembelian) ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                                   

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

<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            scrollX: true
        });

        // Fungsi untuk memfilter data
        function filterData() {
            var barang = $('#filter_barang').val();
            var bulanTahun = $('#filter_bulan_tahun').val();

            table.columns(2).search(barang); // Kolom Barang

            if (bulanTahun) {
                var [tahun, bulan] = bulanTahun.split('-');
                var regex = '^' + tahun + '-' + bulan;
                table.column(6).search(regex, true, false); // Kolom tanggal input
            } else {
                table.column(6).search('');
            }

            table.draw();
        }

        // Event listener untuk tombol filter
        $('#btn_filter').on('click', function() {
            filterData();
        });

        // Fungsi cetak laporan yang sudah ada
        function cetakLaporanPembelian() {
            var filteredData = table.rows({
                search: 'applied'
            }).data().toArray();

            var printContents = `
            <div style="text-align: center; font-family: Arial, sans-serif;">
            <img src="<?= base_url('assets/dist/img/cahayalogo.png') ?>" alt="Logo" style="width: 100px; height: auto;">
            <h2>LAPORAN PEMBELIAN BARANG</h2>
                <h3>TOKO CAHAYA - APP</h3>
                <p>Jl. Sasaran, Keraton, Kec. Martapura, Kota Martapura, Kalimantan Selatan 70714</p>
                <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Supplier</th>
                            <th>Barang</th>
                            <th>jumlah</th>
                            <th>Harga Beli</th>
                            <th>total</th>
                            <th>tanggal input</th>
                            <th>Penambah</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${filteredData.map((row, index) => `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${row[1]}</td>
                                <td>${row[2]}</td>
                                <td>${row[3]}</td>
                                <td>${row[4]}</td>
                                <td>${row[5]}</td>
                                <td>${row[6]}</td>
                                <td>${row[7]}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
                <p style="text-align: right; margin-top: 20px;">Martapura, ${new Date().toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})}</p>
                <p style="text-align: right; margin-top: 80px;">Kepala Toko Cahaya</p>
            </div>
        `;

            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

        // Event listener untuk tombol cetak
        $('button[onclick="cetakLaporanPembelian()"]').on('click', function(e) {
            e.preventDefault();
            cetakLaporanPembelian();
        });
    });
</script>

<style type="text/css" media="print">
    @page {
        size: landscape;
    }

    body {
        -webkit-print-color-adjust: exact;
    }
</style>