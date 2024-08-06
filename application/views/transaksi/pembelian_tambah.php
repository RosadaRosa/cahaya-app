<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Pembelian</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('pembelian'); ?>">pembelian</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
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
                            <h5 class="card-title">Form Tambah pembelian</h5>
                            <div class="card-tools">
                                <a href="<?= base_url('pembelian'); ?>" class="btn btn-tool" data-toggle="tooltip" title="Kembali"><i class="fas fa-arrow-left"></i></a>
                            </div>
                        </div>
                        <form action="<?= base_url('pembelian/tambah'); ?>" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="id_suplier">Suplier</label>
                                    <select name="id_suplier" id="id_suplier" class="form-control" required="required">
                                        <option value="">Pilih Suplier</option>
                                        <?php foreach ($suplier as $o) : ?>
                                            <option value="<?php echo $o->id_suplier ?>"><?php echo $o->nama_suplier ?></option>
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
                                                <label for="harga_beli">Harga Beli</label>
                                                <input type="text" name="harga_beli[]" class="form-control harga_beli" readonly>
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
                                    <label for="total">Total</label>
                                    <input type="text" id="total" name="total" class="form-control" required readonly>
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {
    function hitungTotal() {
        var subtotal = 0;
        $(".barang-row").each(function() {
            var jumlah = parseInt($(this).find(".jumlah").val()) || 0;
            var harga = parseInt($(this).find(".harga_beli").val()) || 0;
            subtotal += jumlah * harga;
        });

        $("#subtotal").val(subtotal);


        var total = subtotal;
        $("#total").val(total.toFixed(0));
        
    }

    function fetchBarangData(id_barang, targetElement) {
        $.ajax({
            url: "<?= base_url('pembelian/fungsi_pengambilan_data'); ?>",
            type: "POST",
            data: { id_barang: id_barang },
            dataType: "json",
            success: function(data) {
                if (data) {
                    targetElement.find('.harga_beli').val(data.harga_beli);
                    hitungTotal();
                }
            }
        });
    }

    $(document).on("change", ".id_barang", function() {
        var id_barang = $(this).val();
        var targetElement = $(this).closest('.barang-row');
        fetchBarangData(id_barang, targetElement);
    });

    $(document).on("input", ".jumlah", function() {
        hitungTotal();
    });

    $(document).on("click", ".btn-add", function() {
        var newRow = $(".barang-row:first").clone();
        newRow.find("input").val("");
        newRow.find(".btn-add").removeClass("btn-add btn-success").addClass("btn-remove btn-danger").text("Hapus");
        $("#barang-container").append(newRow);
    });

    $(document).on("click", ".btn-remove", function() {
        $(this).closest(".barang-row").remove();
        hitungTotal();
    });
});
</script>
