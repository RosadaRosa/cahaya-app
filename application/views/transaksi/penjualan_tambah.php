<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Penjualan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('penjualan'); ?>">Penjualan</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
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
                            <h5 class="card-title">Form Tambah Penjualan</h5>
                            <div class="card-tools">
                                <a href="<?= base_url('penjualan'); ?>" class="btn btn-tool" data-toggle="tooltip" title="Kembali"><i class="fas fa-arrow-left"></i></a>
                            </div>
                        </div>
                        <form action="<?= base_url('penjualan/tambah'); ?>" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="id_pelanggan">Pelanggan</label>
                                    <select name="id_pelanggan" id="id_pelanggan" class="form-control" required="required">
                                        <option value="">Pilih Pelanggan</option>
                                        <?php foreach ($pelanggan as $o) : ?>
                                            <option value="<?php echo $o->id_pelanggan ?>"><?php echo $o->nama_pelanggan ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div id="barang-container">
                                    <div class="row barang-row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="id_barang">Barang</label>
                                                <select name="id_barang[]" class="form-control id_barang" required="required">
                                                    <option value="">Pilih Barang</option>
                                                    <?php foreach ($barang as $o) : ?>
                                                        <option value="<?php echo $o->id_barang ?>"><?php echo $o->merk ?> - <?php echo $o->bahan ?> - <?php echo $o->ukuran ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="jumlah">Jumlah</label>
                                                <input type="number" name="jumlah[]" class="form-control jumlah" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="setelah_diskon">Harga Jual</label>
                                                <input type="text" name="harga_jual[]" class="form-control setelah_diskon" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-success btn-add" style="margin-top: 32px;">Tambah</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="subtotal">Subtotal</label>
                                        <input type="text" id="subtotal" name="subtotal" class="form-control" readonly>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="diskon">Diskon</label>
                                    <input type="text" id="diskon" name="diskon" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="text" id="total" name="total" class="form-control" required readonly>
                                </div>
                            </div>


                    </div>
                    <div class="form-group">
                        <button type="submit" name="simpan" class="btn btn-success btn-sm">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <button type="reset" class="btn btn-danger btn-sm">
                            <i class="fa fa-ban"></i> Batal
                        </button>
                    </div>
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


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {
    // ... (kode sebelumnya tetap sama)

    // Fungsi untuk menghitung subtotal, diskon, dan total
    function hitungTotal() {
        var subtotal = 0;
        $(".barang-row").each(function() {
            var jumlah = parseInt($(this).find(".jumlah").val()) || 0;
            var harga = parseInt($(this).find(".setelah_diskon").val()) || 0;
            subtotal += jumlah * harga;
        });

        $("#subtotal").val(subtotal);

        var diskon = 0;
        var diskonText = "";
        if (subtotal > 500000) {
            diskon = subtotal * 0.05; // 5% diskon
            diskonText = "Diskon 5% = " + diskon.toFixed(0);
        } else {
            diskonText = "Tidak ada diskon";
        }

        var total = subtotal - diskon;

        $("#diskon").val(diskonText);
        $("#total").val(total.toFixed(0));
    }

    // Ganti fungsi hitungSubtotal dengan hitungTotal
    function getHargaJual(select) {
        var idbarang = $(select).val();
        var row = $(select).closest('.barang-row');

        $.ajax({
            url: '<?php echo base_url('Penjualan/fungsi_pengambilan_data'); ?>',
            method: 'post',
            data: {
                id_barang: idbarang
            },
            dataType: 'json',
            success: function(data) {
                row.find('.setelah_diskon').val(data.setelah_diskon);
                hitungTotal();
            }
        });
    }

    // Event listener untuk perubahan pada select barang
    $(document).on('change', '.id_barang', function() {
        getHargaJual(this);
    });

    // Fungsi untuk menambah baris baru
    $(document).on("click", ".btn-add", function() {
        var newRow = $(".barang-row:first").clone();
        newRow.find('input').val('');
        newRow.find('select').val('');
        newRow.find('.btn-add').removeClass('btn-add btn-success').addClass('btn-remove btn-danger').text('Hapus');
        $("#barang-container").append(newRow);
    });

    // Fungsi untuk menghapus baris
    $(document).on("click", ".btn-remove", function() {
        $(this).closest(".barang-row").remove();
        hitungTotal();
    });

    // Event listener untuk perubahan jumlah
    $(document).on("change", ".jumlah", function() {
        hitungTotal();
    });
});
</script>

