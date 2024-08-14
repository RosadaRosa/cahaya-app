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
                    <h1 class="m-0">Pengeluaran</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Pengeluaran</li>
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
                            <h5 class="card-title">Data Pengeluaran</h5>
                            <div class="form-group">
                            </div>
                            <button onclick="cetakLaporanPengeluaran()" class="btn btn-info btn-sm float-right mr-2"><i class="fa fa-print"></i> Cetak Laporan</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Keterangan</th>
                                            <th>Harga</th>
                                            <th>Tanggal Input</th>
                                            <th>Penambah</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($pengeluaran as $row) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row->keterangan; ?></td>
                                                <td><?= $row->harga; ?></td>
                                                <td><?= $row->tgl_input; ?></td>
                                                <td><?= $row->penambah; ?></td>

                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
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

<!-- Modal for deletion confirmation -->
<div class="modal fade" id="deletionModal" tabindex="-1" role="dialog" aria-labelledby="deletionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletionModalLabel">Konfirmasi Hapus Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
    function cetakLaporanPengeluaran() {
        // Fetch the expenditure data
        $.ajax({
            url: '<?= base_url('pengeluaran/get_pengeluaran_data') ?>',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // Generate the report HTML
                var reportHTML = `
            <div style="width: 100%; font-family: Arial, sans-serif;">
                <h2 style="text-align: center;">Laporan Pengeluaran</h2>
                <h3 style="text-align: center;">TOKO CAHAYA - APP</h3>
                <p style="text-align: center; font-size: 12px;">
                    Jl. Sasaran, Keraton, Kec. Martapura, Kota Martapura, Kalimantan Selatan 70714
                </p>
                <hr>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <th style="border: 1px solid black; padding: 5px;">No</th>
                        <th style="border: 1px solid black; padding: 5px;">Keterangan</th>
                        <th style="border: 1px solid black; padding: 5px;">Harga</th>
                        <th style="border: 1px solid black; padding: 5px;">Tanggal Input</th>
                        <th style="border: 1px solid black; padding: 5px;">Penambah</th>
                    </tr>
                    ${data.map((item, index) => `
                        <tr>
                            <td style="border: 1px solid black; padding: 5px;">${index + 1}</td>
                            <td style="border: 1px solid black; padding: 5px;">${item.keterangan}</td>
                            <td style="border: 1px solid black; padding: 5px;">${item.harga}</td>
                            <td style="border: 1px solid black; padding: 5px;">${item.tgl_input}</td>
                            <td style="border: 1px solid black; padding: 5px;">${item.penambah}</td>
                        </tr>
                    `).join('')}
                </table>
                <p style="text-align: right; margin-top: 20px;">Martapura, ${new Date().toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})}</p>
                <p style="text-align: right; margin-top: 80px;">Kepala Toko Cahaya</p>
            </div>
            `;

                // Open a new window and write the report HTML to it
                var printWindow = window.open('', '_blank');
                printWindow.document.write('<html><head><title>Laporan Pengeluaran</title></head><body>');
                printWindow.document.write(reportHTML);
                printWindow.document.write('</body></html>');
                printWindow.document.close();

                // Trigger the print dialog
                printWindow.print();
            },
            error: function() {
                alert('Gagal mengambil data pengeluaran');
            }
        });
    }
</script>