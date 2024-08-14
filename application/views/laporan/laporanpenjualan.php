<?php
// Ambil level pengguna dari sesi 
$level = $this->session->userdata('level');
$id_pengguna = $this->session->userdata('id_pengguna');
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Penjualan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Penjualan</li>
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
                            <h5 class="card-title">Data Penjualan</h5>
                            <button onclick="printPenjualanReport()" class="btn btn-info btn-sm float-right mr-2"><i class="fa fa-print"></i> Cetak Laporan</button>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="filter_barang">Pilih Barang:</label>
                                    <select id="filter_barang" class="form-control">
                                        <option value="">Semua Barang</option>
                                        <?php foreach ($barang as $item) : ?>
                                            <option value="<?= $item->merk . ' - ' . $item->bahan . ' - ' . $item->ukuran ?>">
                                                <?= $item->merk . ' - ' . $item->bahan . ' - ' . $item->ukuran ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="filter_bulan">Pilih Bulan:</label>
                                    <select id="filter_bulan" class="form-control">
                                        <option value="">Semua Bulan</option>
                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                            <option value="<?= sprintf('%02d', $i) ?>"><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="filter_tahun">Pilih Tahun:</label>
                                    <select id="filter_tahun" class="form-control">
                                        <option value="">Semua Tahun</option>
                                        <?php
                                        $currentYear = date('Y');
                                        for ($year = $currentYear; $year >= $currentYear - 5; $year--) :
                                        ?>
                                            <option value="<?= $year ?>"><?= $year ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button id="btn_filter" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="table table-hover table-bordered" width="auto">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Pelanggan </th>
                                            <th>Barang</th>
                                            <th>jumlah</th>
                                            <th>Harga Jual</th>
                                            <th>Diskon</th>
                                            <th>total</th>
                                            <th>Bayar</th>
                                            <th>Kembalian</th>
                                            <th>Status Penjualan</th>
                                            <th>tanggal input</th>
                                            <th>Penambah</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($penjualan as $row) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row->nama_pelanggan; ?></td>
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
                                                <td>
                                                    <?php
                                                    // Memisahkan nilai jumlah menjadi array
                                                    $jumlah_array = explode('"', $row->jumlah);

                                                    // Menampilkan jumlah untuk setiap nilai yang ditemukan
                                                    foreach ($jumlah_array as $jumlah) {
                                                        echo $jumlah . '<br>'; // Tampilkan jumlah
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    // Memisahkan nilai jumlah menjadi array
                                                    $harga_jual_array = explode('"', $row->harga_jual);

                                                    // Menampilkan harga_jual untuk setiap nilai yang ditemukan
                                                    foreach ($harga_jual_array as $harga_jual) {
                                                        echo $harga_jual . '<br>'; // Tampilkan jumlah
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= $row->diskon; ?></td>

                                                <td><?= $row->total; ?></td>
                                                <td><?= $row->bayar; ?></td>
                                                <td><?= $row->kembalian; ?></td>
                                                <td><?= $row->status; ?></td>
                                                <td><?= $row->tanggal_input; ?></td>
                                                <td><?= $row->nama_lengkap; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.card -->
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<script>
    function printReceipt(id_penjualan) {
        $.ajax({
            url: '<?= base_url('penjualan/get_sale_data/') ?>' + id_penjualan,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (!data || !data.items || !Array.isArray(data.items)) {
                    alert('Data penjualan tidak valid');
                    return;
                }

                var receiptHTML = `
            <div style="width: 500px; font-family: Arial, sans-serif;">
                <h2 style="text-align: center;">NOTA PENJUALAN</h2>
                <h3 style="text-align: center;">TOKO CAHAYA - APP</h3>
                <p style="text-align: center; font-size: 12px;">
                    Jl. Sasaran, Keraton, Kec. Martapura, Kota Martapura, Kalimantan Selatan 70714<br>
                    No. Hp/WA : 089530594535<br>
                    Jam Operasional : Senin - Sabtu : 09.00 - 16.00
                </p>
                <hr>
                <p>No. Faktur : ${data.id_penjualan}</p>
                <p>Pelanggan : ${data.nama_pelanggan}</p>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <th style="border: 1px solid black;">Barang</th>
                        <th style="border: 1px solid black;">jumlah</th>
                        <th style="border: 1px solid black;">Harga Jual</th>
                        <th style="border: 1px solid black;">Diskon</th>
                        <th style="border: 1px solid black;">total</th>
                        <th style="border: 1px solid black;">Bayar</th>
                        <th style="border: 1px solid black;">Kembalian</th>
                        <th style="border: 1px solid black;">Status</th>
                    </tr>
                    ${data.items.map(item => `
                        <tr>
                            <td style="border: 1px solid black;">
                               ${item.merk || 'N/A'} - ${item.bahan || 'N/A'} - ${item.ukuran || 'N/A'}
                            </td>
                            <td style="border: 1px solid black;">
                               ${item.jumlah.split('"').map(j => j.trim()).filter(j => j !== '').join('<br>')}
                            </td>
                            <td style="border: 1px solid black;">${item.harga_jual || '0'}</td>
                            <td style="border: 1px solid black;">${item.diskon || 'Tidak ada diskon'}</td>
                            <td style="border: 1px solid black;">${item.total || '0'}</td>
                        </tr>
                    `).join('')}
                </table>
                <p style="text-align: right;">Total Bayar: Rp ${data.total_bayar || '0'}</p>
                <p style="text-align: center;">----- TERIMA KASIH -----</p>
                <p style="text-align: center; font-size: 12px;">Barang yang sudah dibeli tidak dapat DITUKAR/DIKEMBALIKAN</p>
            </div>
            `;

                var printWindow = window.open('', '_blank');
                printWindow.document.write(receiptHTML);
                printWindow.document.close();
                printWindow.print();
                printWindow.onafterprint = function() {
                    printWindow.close();
                };
            },
            error: function() {
                alert('Gagal mengambil data penjualan');
            }
        });
    }
</script>


<script>
    $(document).ready(function() {
        // Hancurkan DataTable jika sudah ada
        if ($.fn.DataTable.isDataTable('#example')) {
            $('#example').DataTable().destroy();
        }

        var table = $('#example').DataTable({
            scrollX: true
        });

        // Fungsi untuk memfilter data
        function filterData() {
            var barang = $('#filter_barang').val();
            var bulanTahun = $('#filter_bulan_tahun').val();

            table.columns(2).search(barang); // Kolom Barang

            if (bulanTahun) {
                var [tahun, bulan] = bulanTahun.split('-');
                var regex = '^' + tahun + '-' + bulan;
                table.column(7).search(regex, true, false); // Kolom Tanggal Input
            } else {
                table.column(7).search('');
            }

            table.draw();
        }

        // Event listener untuk tombol filter
        $('#btn_filter').on('click', function() {
            filterData();
        });
    });

    function printPenjualanReport() {
        var table = $('#example').DataTable();
        var filteredData = table.rows({
            search: 'applied'
        }).data().toArray();

        var printContents = `
        <div style="text-align: center; font-family: Arial, sans-serif;">
        <img src="<?= base_url('assets/dist/img/cahayalogo.png') ?>" alt="Logo" style="width: 100px; height: auto;">
            <h2>LAPORAN DATA PENJUALAN</h2>
            <h3>TOKO CAHAYA - APP</h3>
            <p>Jl. Sasaran, Keraton, Kec. Martapura, Kota Martapura, Kalimantan Selatan 70714</p>
            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Harga Jual</th>
                        <th>Diskon</th>
                        <th>Total</th>
                        <th>Bayar</th>
                        <th>Kembalian</th>
                        <th>Status</th>
                        <th>Tanggal Input</th>
                        <th>Penambah</th>
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
                            <td>${row[5]}</td>
                            <td>${row[6]}</td>
                            <td>${row[7]}</td>
                            <td>${row[8]}</td>
                            <td>${row[9]}</td>
                            <td>${row[10]}</td>
                            <td>${row[11]}</td>
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

<style type="text/css" media="print">
    @page {
        size: landscape;
    }

    body {
        -webkit-print-color-adjust: exact;
    }
</style>
<script>
    $("#simpanTransaksi").click(function() {
        var id_pelanggan = $("#id_pelanggan").val();
        var diskon = $("#diskon").val();
        var total = $("#total").val();
        var id_barang = [];
        var jumlah = [];

        keranjang.forEach(function(item) {
            id_barang.push(item.id_barang);
            jumlah.push(item.jumlah);
        });

        $.ajax({
            url: '<?php echo base_url('transaksi/save'); ?>',
            method: 'POST',
            data: {
                id_pelanggan: id_pelanggan,
                diskon: diskon,
                total: total,
                id_barang: id_barang,
                jumlah: jumlah
            },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    alert(response.message);
                    // Clear the form and keranjang
                    keranjang = [];
                    updateKeranjangTable();
                    hitungTotal();
                    $("#penjualanForm")[0].reset();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat menyimpan transaksi');
            }
        });
    });
</script>
<script>
$(document).ready(function() {
    // Hancurkan DataTable jika sudah ada
    if ($.fn.DataTable.isDataTable('#example')) {
        $('#example').DataTable().destroy();
    }

    var table = $('#example').DataTable({
        scrollX: true
    });

    // Fungsi untuk memfilter data
    function filterData() {
        var barang = $('#filter_barang').val();
        var bulan = $('#filter_bulan').val();
        var tahun = $('#filter_tahun').val();

        table.columns(2).search(barang); // Kolom Barang

        if (bulan && tahun) {
            var regex = '^' + tahun + '-' + bulan;
            table.column(10).search(regex, true, false); // Kolom Tanggal Input
        } else if (tahun) {
            table.column(10).search(tahun);
        } else {
            table.column(10).search('');
        }

        table.draw();
    }

    // Event listener untuk tombol filter
    $('#btn_filter').on('click', function() {
        filterData();
    });

    // Event listener untuk perubahan pada dropdown
    $('#filter_barang, #filter_bulan, #filter_tahun').on('change', function() {
        filterData();
    });
});

// ... (existing printPenjualanReport function) ...
</script>