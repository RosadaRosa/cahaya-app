<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Stok Kurang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Stok Kurang</li>
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
                            <h5 class="card-title">Data Stok Kurang</h5>
                            <button onclick="printStockReport()" class="btn btn-info btn-sm float-right mr-2"><i class="fa fa-print"></i> Cetak Laporan</button>
                        </div>
                        <div class="card-body">
                        <div class="form-group">
                                <label for="filter_kategori">Filter Kategori</label>
                                <select id="filter_kategori" class="form-control">
                                    <option value="">Semua Kategori</option>
                                    <?php foreach ($kategori as $kat) : ?>
                                        <option value="<?= $kat->id_kategori; ?>"><?= $kat->nama_kategori; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <table id="example" class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kategori</th>
                                        <th>Barang</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($barang as $row) : ?>
                                        <tr data-kategori="<?= $row->id_kategori; ?>">
                                            <td><?= $no++ ?></td>
                                            <td><?= $row->nama_kategori; ?></td>
                                            <td><?= $row->merk; ?> - <?= $row->bahan; ?> - <?= $row->ukuran; ?></td>
                                            <td><?= $row->stok; ?></td>
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
</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable();

        // Fungsi filter berdasarkan kategori
        $('#filter_kategori').on('change', function() {
            var filterValue = $(this).val();
            console.log("Filter value: ", filterValue); // Debugging
            table.rows().nodes().to$().each(function() {
                var rowKategori = $(this).data('kategori');
                console.log("Row kategori: ", rowKategori); // Debugging
                if (filterValue === "" || rowKategori == filterValue) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Fungsi print laporan
        window.printStockReport = function() {
            var filterValue = $('#filter_kategori').val();
            console.log("Filter value for print: ", filterValue); // Debugging
            var visibleRows = table.rows().nodes().to$().filter(function() {
                return $(this).is(':visible');
            });
            var tableHTML = '';

            visibleRows.each(function(index) {
                var cells = $(this).find('td');
                tableHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${cells[1].innerText}</td>
                        <td>${cells[2].innerText}</td>
                        <td>${cells[3].innerText}</td>
                        <td>${cells[4].innerText}</td>
                        <td>${cells[5].innerText}</td>
                    </tr>
                `;
            });

            var printContents = `
                <div style="width: 100%; font-family: Arial, sans-serif;">
                <img src="<?= base_url('assets/dist/img/cahayalogo.png') ?>" alt="Logo" style="width: 100px; height: auto;">
                    <h2 style="text-align: center;">LAPORAN STOK BARANG</h2>
                    <h3 style="text-align: center;">TOKO CAHAYA - APP</h3>
                    <p style="text-align: center; font-size: 12px;">
                        Jl. Sasaran, Keraton, Kec. Martapura, Kota Martapura, Kalimantan Selatan 70714<br>
                        No. Hp/WA : 089530594535<br>
                        Jam Operasional : Senin - Sabtu : 09.00 - 16.00
                    </p>
                    <hr>
                    <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Merk</th>
                                <th>Bahan</th>
                                <th>Ukuran</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${tableHTML}
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
        };
    });
</script>

