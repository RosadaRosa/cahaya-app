<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Distributor</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Distributor</li>
                        <li class="breadcrumb-item active">Ubah Data Distributor</li>
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
                            <h5 class="card-title">Perbaharui Data Distributor</h5>
                            <a href="<?= base_url('distributor'); ?>" class="btn btn-info btn-sm float-right">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="nama_suplier">Nama Suplier</label>
                                    <input type="text" name="nama_suplier" id="nama_suplier" class="form-control" required value="<?= $distributor->nama_suplier ?>">
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" name="alamat" id="alamat" class="form-control" required value="<?= $distributor->alamat ?>">
                                </div>
                                <div class="form-group">
                                    <label for="telepon">Telepon</label>
                                    <input type="text" name="telepon" id="telepon" class="form-control" required value="<?= $distributor->telepon ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required value="<?= $distributor->email ?>">
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
                url: '<?= base_url('Perta2/fungsi_pengambilan_data'); ?>',
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

        // Jika data komoditas sudah ada (ketika mengedit), panggil perubahan untuk mengisi kolom kualitas, satuan, dan kode kualitas
        $('#id_komoditas').trigger('change');
    });
</script>