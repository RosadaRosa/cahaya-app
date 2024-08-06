<?php
// Ambil peran pengguna dari sesi 
$peran = $this->session->userdata('peran');
$id_pengguna = $this->session->userdata('id_pengguna');
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ubah Data Penjualan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('penjualan'); ?>">Penjualan</a></li>
                        <li class="breadcrumb-item active">Ubah</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">
        <div class="container-fluid">
            <?php $this->load->view('template/notifikasi'); ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Form Ubah Data Penjualan</h5>
                            <div class="card-tools">
                                <a href="<?= base_url('penjualan'); ?>" class="btn btn-tool" data-toggle="tooltip" title="Kembali"><i class="fas fa-arrow-left"></i></a>
                            </div>
                        </div>
                        <form action="<?= base_url('penjualan/ubah_simpan/' . $penjualan->id_penjualan); ?>" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="id_pelanggan">ID Pelanggan</label>
                                    <input type="text" id="id_pelanggan" name="id_pelanggan" class="form-control" value="<?= $penjualan->id_pelanggan; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="id_barang">ID Barang</label>
                                    <input type="text" id="id_barang" name="id_barang" class="form-control" value="<?= $penjualan->id_barang; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="number" id="jumlah" name="jumlah" class="form-control" value="<?= $penjualan->jumlah; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="harga_jual">Harga Jual</label>
                                    <input type="text" id="harga_jual" name="harga_jual" class="form-control" value="<?= $penjualan->harga_jual; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="diskon">Diskon</label>
                                    <input type="text" id="diskon" name="diskon" class="form-control" value="<?= $penjualan->diskon; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="text" id="total" name="total" class="form-control" value="<?= $penjualan->total; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_input">Tanggal Input</label>
                                    <input type="date" id="tanggal_input" name="tanggal_input" class="form-control" value="<?= $penjualan->tanggal_input; ?>" required>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="<?= base_url('penjualan'); ?>" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div><!-- /.card -->
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    <!-- /.content -->
</div>

<!-- Tambahkan skrip ini di tampilan Anda -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Ganti selector berikut menjadi selector yang sesuai
        var idHotel = <?= $hotel1->id_hotel ?>;

        $.ajax({
            type: 'POST',
            url: '<?= base_url('hotel1/fungsi_pengambilan_data'); ?>',
            data: {
                id_hotel: idHotel
            },
            dataType: 'json',
            success: function(data) {
                // Isi kolom formulir dengan data yang diambil
                $('#alamat').val(data.alamat);
                $('#jenis_akomodasi').val(data.jenis_akomodasi);
                $('#kelas_akomodasi').val(data.kelas_akomodasi);
                $('#id_wilkerstat').val(data.id_wilkerstat);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    // Ganti selector form berikut menjadi selector yang sesuai
    $('form').submit(function(e) {
        e.preventDefault();

        // Ganti URL form berikut menjadi URL yang sesuai
        var formUrl = '<?= site_url('hotel1/ubah/' . $hotel1->id_hotel_hal1); ?>';

        $.ajax({
            type: 'POST',
            url: formUrl,
            data: $('form').serialize(),
            dataType: 'json',
            success: function(response) {
                // Tambahkan logika penanganan respons dari server jika diperlukan
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
</script>