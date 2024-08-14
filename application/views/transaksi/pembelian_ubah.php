<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ubah Data Pembelian</title>
    <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/adminlte.min.css') ?>">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar and Sidebar if any -->
        
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Ubah Data Pembelian</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url('pembelian'); ?>">Pembelian</a></li>
                                <li class="breadcrumb-item active">Ubah Data</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    <!-- Notification -->
                    <?php $this->load->view('template/notifikasi'); ?>

                    <!-- Form Start -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Form Ubah Data Pembelian</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('pembelian/update/' . $pembelian->id_pembelian) ?>" method="post">
                                <div class="form-group">
                                    <label for="supplier">Supplier</label>
                                    <input type="text" class="form-control" id="supplier" name="supplier" value="<?= set_value('supplier', $pembelian->nama_suplier) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="barang">Barang</label>
                                    <select id="barang" class="form-control" name="barang[]" multiple required>
                                        <?php foreach ($barang as $b) : ?>
                                            <option value="<?= $b->id_barang ?>" <?= in_array($b->id_barang, explode('"', $pembelian->id_barang)) ? 'selected' : '' ?>>
                                                <?= $b->merk . ' - ' . $b->bahan . ' - ' . $b->ukuran ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="text" class="form-control" id="jumlah" name="jumlah[]" value="<?= set_value('jumlah', implode('"', explode('"', $pembelian->jumlah))) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="harga_beli">Harga Beli</label>
                                    <input type="text" class="form-control" id="harga_beli" name="harga_beli[]" value="<?= set_value('harga_beli', implode('"', array_map(function($id) use ($barang) {
                                        foreach ($barang as $b) {
                                            if ($b->id_barang == $id) {
                                                return $b->harga_beli;
                                            }
                                        }
                                    }, explode('"', $pembelian->id_barang)))) ?>" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update Data</button>
                                    <a href="<?= base_url('pembelian'); ?>" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>

    <script>
        // Additional JS for handling form functionality if needed
    </script>
</body>

</html>
