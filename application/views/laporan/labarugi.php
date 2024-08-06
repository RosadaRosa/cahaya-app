<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laba Rugi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Laba Rugi</li>
                        <li class="breadcrumb-item active">Tampil Data</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <?php
    // Calculate total pemasukan (income) from penjualan (sales)
    $total_pemasukan = 0;
    foreach ($penjualan as $row) {
        $total_pemasukan += $row->total;
    }

    // Calculate total pengeluaran (expenses) from pembelian (purchases) and pengeluaran (expenses)
    $total_pengeluaran = 0;
    foreach ($pembelian as $row) {
        $total_pengeluaran += $row->total;
    }
    foreach ($pengeluaran as $row) {
        $total_pengeluaran += $row->harga;
    }

    // Calculate saldo akhir (final balance)
    $saldo_akhir = $total_pemasukan - $total_pengeluaran;

    // Update the HTML with the calculated totals
    ?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <label for="month" class="form-label">Pilih Bulan</label>
                            <select id="month" class="form-control">
                                <option value="" selected disabled>Pilih Bulan</option>
                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                    <option value="<?= $i ?>" <?= $i == $this->input->get('month', true) ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                                <?php endfor; ?>
                            </select>

                            <label for="year" class="form-label mt-2">Pilih Tahun</label>
                            <input type="number" id="year" class="form-control" value="<?= $this->input->get('year', true) ?: date('Y') ?>">

                            <button onclick="printLabarugiReport()" class="btn btn-info btn-sm float-right mr-2 mt-2"><i class="fa fa-print"></i> Cetak Laporan</button>

                            <h5 class="card-title mt-3">Data Penjualan</h5>
                        </div>

                        <div class="card-body">
                            <table id="example" class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jenis</th>
                                        <th>Keterangan</th>
                                        <th>Pemasukan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($penjualan as $row) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <?php
                                                $originalDate = $row->tanggal_input;
                                                $dateTime = new DateTime($originalDate);
                                                echo $dateTime->format('d F Y');
                                                ?>
                                            </td>
                                            <td>Penjualan</td>
                                            <td><?= $row->merk; ?>-<?= $row->bahan; ?>-<?= $row->ukuran; ?></td>
                                            <td><?= $row->total; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr style="background-color: #4B70F5; color: white;">
                                        <td colspan="4">Total Pemasukan</td>
                                        <td>Rp <?= number_format($total_pemasukan, 0, ',', '.'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Data Pembelian</h5>
                        </div>
                        <div class="card-body">
                            <table id="example" class="table table-hover table-bordered" width="auto">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jenis</th>
                                        <th>Keterangan</th>
                                        <th>Pengeluaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($pembelian as $row) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <?php
                                                $originalDate = $row->tanggal_input;
                                                $dateTime = new DateTime($originalDate);
                                                echo $dateTime->format('d F Y');
                                                ?>
                                            </td>
                                            <td>Pembelian</td>
                                            <td><?= $row->merk; ?>-<?= $row->bahan; ?>-<?= $row->ukuran; ?></td>
                                            <td><?= $row->total; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="card-header">
                            <h5 class="card-title">Data Pengeluaran</h5>
                        </div>
                        <div class="card-body">
                            <table id="example" class="table table-hover table-bordered" width="auto">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jenis</th>
                                        <th>Keterangan</th>
                                        <th>Pengeluaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($pengeluaran as $row) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <?php
                                                $originalDate = $row->tgl_input;
                                                $dateTime = new DateTime($originalDate);
                                                echo $dateTime->format('d F Y');
                                                ?>
                                            </td>
                                            <td>Pembelian</td>
                                            <td><?= $row->keterangan; ?></td>
                                            <td><?= $row->harga; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr style="background-color: #4B70F5; color: white;">
                                        <td colspan="4">Total Pengeluaran</td>
                                        <td>Rp <?= number_format($total_pengeluaran, 0, ',', '.'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="card-body">
                        <table id="example" class="table table-hover table-bordered">
                            <tbody>
                                <tr style="background-color: #4B70F5; color: white;">
                                    <td>Saldo Akhir</td>
                                    <td>Rp <?= number_format($saldo_akhir, 0, ',', '.'); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!-- /.card -->
                </div><!-- /.card -->
            </div>
        </div>
    </div>
</div>

<script>
    function filterTable() {
        var month = document.getElementById("month").value;
        var year = document.getElementById("year").value;

        var tables = document.querySelectorAll(".table");
        tables.forEach(function(table) {
            var rows = table.getElementsByTagName("tr");
            for (var i = 1; i < rows.length; i++) { // Start from 1 to skip the header row
                var dateCell = rows[i].getElementsByTagName("td")[1]; // Assuming the date is in the second column
                if (dateCell) {
                    var date = new Date(dateCell.textContent);
                    if ((date.getMonth() + 1 == month || month == "") && (date.getFullYear() == year || year == "")) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            }
        });
    }

    document.getElementById("month").addEventListener("change", filterTable);
    document.getElementById("year").addEventListener("change", filterTable);
</script>


<script>
    function printLabarugiReport() {
        var month = document.getElementById('month').value;
        var year = document.getElementById('year').value;

        // Collect filtered data from the displayed table rows
        var pemasukanRows = document.querySelectorAll(".card-primary.card-outline:nth-of-type(1) tbody tr");
        var pembelianRows = document.querySelectorAll(".card-primary.card-outline:nth-of-type(2) tbody tr");
        var pengeluaranRows = document.querySelectorAll(".card-primary.card-outline:nth-of-type(3) tbody tr");

        var totalPemasukan = 0;
        var totalPembelian = 0;
        var totalPengeluaran = 0;
        var pengeluaranDetails = [];

        pemasukanRows.forEach(function(row) {
            if (row.style.display !== 'none' && row.querySelector("td:nth-child(5)")) {
                totalPemasukan += parseInt(row.querySelector("td:nth-child(5)").textContent.replace(/\D/g, ''));
            }
        });

        pembelianRows.forEach(function(row) {
            if (row.style.display !== 'none' && row.querySelector("td:nth-child(5)")) {
                totalPembelian += parseInt(row.querySelector("td:nth-child(5)").textContent.replace(/\D/g, ''));
            }
        });

        pengeluaranRows.forEach(function(row) {
            if (row.style.display !== 'none' && row.querySelector("td:nth-child(5)")) {
                var harga = parseInt(row.querySelector("td:nth-child(5)").textContent.replace(/\D/g, ''));
                totalPengeluaran += harga;
                pengeluaranDetails.push({
                    keterangan: row.querySelector("td:nth-child(4)").textContent,
                    harga: harga
                });
            }
        });

        var totalBeban = totalPembelian + totalPengeluaran;
        var saldoAkhir = totalPemasukan - totalBeban;

        var pengeluaranHtml = pengeluaranDetails.map(item =>
            `<tr>
            <td style="padding: 5px 0;">${item.keterangan}</td>
            <td style="text-align: right;">Rp ${item.harga.toLocaleString('id-ID')}</td>
        </tr>`
        ).join('');

        var printContents = `
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Laporan Laba Rugi - Toko Cahaya</title>
        <style>
            body { font-family: Arial, sans-serif; padding: 20px; }
            table { width: 100%; border-collapse: collapse; }
            td { padding: 5px 0; }
            .right { text-align: right; }
            .bold { font-weight: bold; }
            @media print {
                @page { margin: 0; }
                body { margin: 1.6cm; }
            }
        </style>
    </head>
    <body>
        <div style="width: 100%;">
            <img src="<?= base_url('assets/dist/img/cahayalogo.png') ?>" alt="Logo" style="width: 100px; height: auto;">
            <div style="text-align: center; margin-bottom: 20px;">
                <h2 style="margin: 0;">LAPORAN LABA RUGI</h2>
                <h3 style="margin: 5px 0;">TOKO CAHAYA - APP</h3>
                <p style="margin: 0; font-size: 12px;">
                    Jl. Sasaran, Keraton, Kec. Martapura, Kota Martapura, Kalimantan Selatan 70714
                </p>
                <p style="margin: 5px 0;">Periode: ${new Date(year, month - 1).toLocaleString('id-ID', {month: 'long', year: 'numeric'})}</p>
            </div>
            <hr style="border: 1px solid black; margin-bottom: 20px;">
            <table>
                <tr class="bold">
                    <td>Pendapatan</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Total Pemasukan</td>
                    <td class="right">Rp ${totalPemasukan.toLocaleString('id-ID')}</td>
                </tr>
                <tr class="bold">
                    <td>Beban</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Total Pembelian</td>
                    <td class="right">Rp ${totalPembelian.toLocaleString('id-ID')}</td>
                </tr>
                <tr>
                    <td>Pengeluaran Lainnya:</td>
                    <td></td>
                </tr>
                ${pengeluaranHtml}
                <tr class="bold">
                    <td>Total Beban</td>
                    <td class="right">Rp ${totalBeban.toLocaleString('id-ID')}</td>
                </tr>
                <tr class="bold">
                    <td>Saldo Akhir</td>
                    <td class="right">Rp ${saldoAkhir.toLocaleString('id-ID')}</td>
                </tr>
            </table>
            <div style="margin-top: 40px; text-align: right;">
                <p>Martapura, ${new Date().toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})}</p>
                <br><br><br>
                <p>Kepala Toko Cahaya</p>
            </div>
        </div>
    </body>
    </html>
    `;

        var printWindow = window.open('', '_blank');
        printWindow.document.write(printContents);
        printWindow.document.close();

        // Wait for the content to load before printing
        printWindow.onload = function() {
            printWindow.print();
            printWindow.onafterprint = function() {
                printWindow.close();
            };
        };
    }
</script>