<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ubah Barang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Barang</li>
                        <li class="breadcrumb-item active">Ubah Data</li>
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
                            <h5 class="card-title">Ubah Data Barang</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('barang/ubah/' . $barang->id_barang); ?>" method="post">
                                <div class="form-group">
                                    <label for="id_kategori">Kategori</label>
                                    <select name="id_kategori" id="id_kategori" class="form-control" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php foreach ($kategori->result() as $k) : ?>
                                            <?php $selected = ($k->id_kategori == $barang->id_kategori) ? 'selected' : ''; ?>
                                            <option value="<?= $k->id_kategori ?>" <?= $selected ?>><?= $k->nama_kategori ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="id_merk">Merk</label>
                                    <select name="id_merk" id="id_merk" class="form-control" required>
                                        <option value="">Pilih Merk</option>
                                        <?php foreach ($merk->result() as $m) : ?>
                                            <?php $selected = ($m->id_merk == $barang->id_merk) ? 'selected' : ''; ?>
                                            <option value="<?= $m->id_merk ?>" <?= $selected ?>><?= $m->merk ?> - <?= $m->bahan ?> - <?= $m->ukuran ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="id_suplier">Suplier</label>
                                    <select name="id_suplier" id="id_suplier" class="form-control" required>
                                        <option value="">Pilih Suplier</option>
                                        <?php foreach ($suplier->result() as $s) : ?>
                                            <?php $selected = ($s->id_suplier == $barang->id_suplier) ? 'selected' : ''; ?>
                                            <option value="<?= $s->id_suplier ?>" <?= $selected ?>><?= $s->nama_suplier ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="harga_beli">Harga Beli</label>
                                    <input type="number" name="harga_beli" class="form-control" value="<?= $barang->harga_beli; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="harga_jual">Harga Jual</label>
                                    <input type="number" name="harga_jual" class="form-control" value="<?= $barang->harga_jual; ?>" required>
                                </div>
                                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
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
        function updateDetailMerk(idmerk) {
            $.ajax({
                url: '<?php echo base_url('Barang/fungsi_pengambilan_data'); ?>',
                method: 'post',
                data: {
                    id_merk: idmerk
                },
                dataType: 'json',
                success: function(data) {
                    $('#bahan').val(data.bahan);
                    $('#ukuran').val(data.ukuran);
                }
            });
        }

        $('#id_merk').change(function() {
            var idmerk = $(this).val();
            updateDetailMerk(idmerk);
        });

        // Update detail merk saat halaman dimuat
        var merkAwal = $('#id_merk').val();
        if (merkAwal) {
            updateDetailMerk(merkAwal);
        }
    });
</script>