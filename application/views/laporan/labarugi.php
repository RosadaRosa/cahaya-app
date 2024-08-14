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
                            <h5 class="card-title mt-3">Data Penjualan</h5>
                        </div>

                        <div class="card-body">
                            <form action="<?php echo base_url('Labarugi/index'); ?>" method="post">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Dari tanggal</label>
                                            <input class="form-control" type="date" id="dari_tanggal" name="dari_tanggal" required="" value="<?php echo isset($_POST['dari_tanggal']) ? $_POST['dari_tanggal'] : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Sampai tanggal</label>
                                            <input class="form-control" type="date" id="sampai_tanggal" name="sampai_tanggal" required="" value="<?php echo isset($_POST['sampai_tanggal']) ? $_POST['sampai_tanggal'] : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label>&nbsp;</label>
                                        <button type="submit" name="filter" class="form-control" style="background-color: #778899; color: white;">Filter</button>
                                    </div>
                                </div>
                            </form>
                            <button onclick="printLabarugiReport()" class="btn btn-info btn-sm float-right mr-2 mt-2"><i class="fa fa-print"></i> Cetak Laporan</button>
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
                                            <td>
                                                <?php
                                                // Memisahkan nilai jumlah menjadi array
                                                $id_barang_array = explode('"', $row->id_barang);

                                                // Menampilkan id_barang untuk setiap nilai yang ditemukan
                                                foreach ($id_barang_array as $id_barang) {
                                                    foreach ($barang as $i) {
                                                        if ($i->id_barang == $id_barang) {
                                                            echo $i->merk . ' - ' . $i->bahan . ' - ' . $i->ukuran . '<br>'; // Tampilkan merk, bahan, dan ukuran
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
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
                            <table id="example2" class="table table-hover table-bordered" width="auto">
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
                                            <td>
                                                <?php
                                                // Memisahkan nilai jumlah menjadi array
                                                $id_barang_array = explode('"', $row->id_barang);

                                                // Menampilkan id_barang untuk setiap nilai yang ditemukan
                                                foreach ($id_barang_array as $id_barang) {
                                                    foreach ($barang as $i) {
                                                        if ($i->id_barang == $id_barang) {
                                                            echo $i->merk . ' - ' . $i->bahan . ' - ' . $i->ukuran . '<br>'; // Tampilkan merk, bahan, dan ukuran
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
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
                            <table id="example3" class="table table-hover table-bordered" width="auto">
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
                        <table id="example4" class="table table-hover table-bordered">
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
    function printLabarugiReport() {
  // Get the necessary data from the page
  const totalPemasukan = parseFloat('<?= str_replace(',', '', $total_pemasukan) ?>');
  const totalPembelian = parseFloat('<?= str_replace(',', '', $total_pengeluaran) ?>');
  const saldoAkhir = parseFloat('<?= str_replace(',', '', $saldo_akhir) ?>');
  
  // Generate the pengeluaran HTML
  let pengeluaranHtml = '';
  <?php foreach ($pengeluaran as $row) { ?>
    pengeluaranHtml += `
      <tr>
        <td>${'<?= $row->keterangan ?>'}</td>
        <td class="right">Rp <?= number_format($row->harga, 0, ',', '.') ?></td>
      </tr>
    `;
  <?php } ?>

  // Open the print window
  const printWindow = window.open('', 'PRINT', 'height=600,width=800');
  printWindow.document.write(`
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
            <img src="${'<?= base_url('assets/dist/img/cahayalogo.png') ?>'}" alt="Logo" style="width: 100px; height: auto;">
            <div style="text-align: center; margin-bottom: 20px;">
                <h2 style="margin: 0;">LAPORAN LABA RUGI</h2>
                <h3 style="margin: 5px 0;">TOKO CAHAYA - APP</h3>
                <p style="margin: 0; font-size: 12px;">
                    Jl. Sasaran, Keraton, Kec. Martapura, Kota Martapura, Kalimantan Selatan 70714
                </p>
                <p style="margin: 5px 0;">Periode: ${new Date(<?= date('Y') ?>, <?= date('n') - 1 ?>).toLocaleString('id-ID', {month: 'long', year: 'numeric'})}</p>
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
                    <td class="right">Rp ${(totalPembelian).toLocaleString('id-ID')}</td>
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
  `);

  printWindow.document.close();
  printWindow.focus();
  printWindow.print();
  printWindow.close();
}
</script>