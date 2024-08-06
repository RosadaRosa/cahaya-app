<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Pengeluaran</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('pengeluaran'); ?>">Pengeluaran</a></li>
                        <li class="breadcrumb-item active">Tambah Data</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Tambah Pengeluaran</h5>
                            <a href="<?= base_url('pengeluaran'); ?>" class="btn btn-info btn-sm float-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" name="keterangan" id="keterangan" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="harga">harga</label>
                                    <input type="text" name="harga" id="harga" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="simpan" class="btn btn-success btn-sm">
                                        <i class="fa fa-save"></i> Simpan
                                    </button>
                                    <button type="reset" class="btn btn-danger btn-sm">
                                        <i class="fa fa-ban"></i> Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#id_komoditas').change(function() {
            var idKomoditas = $(this).val();

            // Menggunakan AJAX untuk mengambil data dari server
            $.ajax({
                url: '<?php echo base_url('Perta2/fungsi_pengambilan_data'); ?>',
                method: 'post',
                data: {
                    id_komoditas: idKomoditas
                },
                dataType: 'json',
                success: function(data) {
                    // Mengisi nilai kualitas, satuan, dan kode kualitas
                    $('#kualitas').val(data.kualitas);
                    $('#satuan').val(data.satuan);
                    $('#kode_kualitas').val(data.kode_kualitas);
                }
            });
        });
    });
</script>