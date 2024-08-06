<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Barang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Barang</li>
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
                    <div class="form-group">
                        <label for="kategori_filter">Filter Kategori:</label>
                        <select id="kategori_filter" class="form-control" style="width: 200px;">
                            <option value="">Semua Kategori</option>
                            <?php foreach ($kategori_list as $kat) : ?>
                                <option value="<?= $kat->nama_kategori ?>"><?= $kat->nama_kategori ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Data Barang</h5>
                            <a href="<?= base_url('barang/tambah') ?>" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i> Tambah Data</a>
                            <button onclick="printBarangReport()" class="btn btn-info btn-sm float-right mr-2"><i class="fa fa-print"></i> Cetak Laporan</button>
                        </div>

                        <div class="card-body">
                            <table id="example" class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kategori</th>
                                        <th>Barang</th>
                                        <th>Nama Suplier</th>
                                        <th>Stok</th>
                                        <th>Harga Beli</th>
                                        <th>Harga Jual</th>
                                        <th>Setelah Diskon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($barang as $row) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row->nama_kategori; ?></td>
                                            <td><?= $row->merk; ?> - <?= $row->bahan; ?> - <?= $row->ukuran; ?></td>
                                            <td><?= $row->nama_suplier; ?></td>
                                            <td><?= $row->stok; ?></td>
                                            <td><?= $row->harga_beli; ?></td>
                                            <td><?= $row->harga_jual; ?></td>
                                            <td><?= $row->setelah_diskon; ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="<?= base_url('barang/ubah/' . $row->id_barang) ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                                    <a href="<?= base_url('barang/hapus/' . $row->id_barang) ?>" onclick="return confirm('Hapus Data Ini?'); " class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                    <a href="#" class="btn btn-success btn-sm btn-diskon" data-id="<?= $row->id_barang ?>" data-harga="<?= $row->harga_jual ?>"><i class="">Diskon</i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Diskon -->
    <div class="modal fade" id="diskonModal" tabindex="-1" role="dialog" aria-labelledby="diskonModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="diskonModalLabel">Terapkan Diskon</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formDiskon">
                        <input type="hidden" id="id_barang" name="id_barang">
                        <div class="form-group">
                            <label for="harga_jual">Harga Jual</label>
                            <input type="text" class="form-control" id="harga_jual" readonly>
                        </div>
                        <div class="form-group">
                            <label for="diskon">Diskon (%)</label>
                            <input type="number" class="form-control" id="diskon" name="diskon" min="0" max="100" required>
                        </div>
                        <div class="form-group">
                            <label for="harga_setelah_diskon">Harga Setelah Diskon</label>
                            <input type="text" class="form-control" id="harga_setelah_diskon" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="terapkanDiskon">Terapkan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var table;

    $(document).ready(function() {
        table = $('#example').DataTable();

        // Fungsi filter
        $('#kategori_filter').on('change', function() {
            var kategori = $(this).val();
            table.column(1).search(kategori).draw();
        });
    });

    function printBarangReport() {
        var kategori = $('#kategori_filter option:selected').text();
        var filteredData = table.rows({
            search: 'applied'
        }).data().toArray();

        var printContents = `
        <div style="text-align: center; font-family: Arial, sans-serif;">
        <img src="<?= base_url('assets/dist/img/cahayalogo.png') ?>" alt="Logo" style="width: 100px; height: auto;">
            <h2>LAPORAN DATA BARANG</h2>
            <h3>TOKO CAHAYA - APP</h3>
            <p>Jl. Sasaran, Keraton, Kec. Martapura, Kota Martapura, Kalimantan Selatan 70714</p>
            <p>Kategori: ${kategori}</p>
            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Merek</th>
                        <th>Bahan</th>
                        <th>Ukuran</th>
                        <th>Stok</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
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
                            <td>${row[6]}</td>
                            <td>${row[7]}</td>
                            <td>${row[8]}</td>
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
        window.location.reload(); // Reload the page to reset the contents
    }
</script>
<script>
    $(document).ready(function() {
        // ... (kode DataTable dan filter yang sudah ada)

        // Fungsi untuk membuka modal diskon
        $('.btn-diskon').on('click', function(e) {
            e.preventDefault();
            var id_barang = $(this).data('id');
            var harga_jual = $(this).data('harga');
            $('#id_barang').val(id_barang);
            $('#harga_jual').val(harga_jual);
            $('#diskon').val('');
            $('#harga_setelah_diskon').val('');
            $('#diskonModal').modal('show');
        });

        // Hitung harga setelah diskon saat input diskon berubah
        $('#diskon').on('input', function() {
            var harga_jual = parseFloat($('#harga_jual').val());
            var diskon = parseFloat($(this).val());
            if (!isNaN(diskon)) {
                var harga_setelah_diskon = harga_jual - (harga_jual * diskon / 100);
                $('#harga_setelah_diskon').val(harga_setelah_diskon.toFixed(0));
            } else {
                $('#harga_setelah_diskon').val('');
            }
        });

        // Fungsi untuk menerapkan diskon
        $('#terapkanDiskon').on('click', function() {
            var id_barang = $('#id_barang').val();
            var diskon = $('#diskon').val();
            var harga_setelah_diskon = $('#harga_setelah_diskon').val();

            $.ajax({
                url: '<?= base_url('barang/terapkan_diskon') ?>',
                method: 'POST',
                data: {
                    id_barang: id_barang,
                    diskon: diskon,
                    harga_setelah_diskon: harga_setelah_diskon
                },
                success: function(response) {
                    $('#diskonModal').modal('hide');
                    location.reload();
                },
                error: function() {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });
    });
</script>