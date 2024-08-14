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
                    <h1 class="m-0">suplier</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">suplier</li>
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
                            <h5 class="card-title">Data suplier</h5>
                            <button onclick="printSuplierReport()" class="btn btn-info btn-sm float-right mr-2"><i class="fa fa-print"></i> Cetak Laporan</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Suplier</th>
                                            <th>Alamat</th>
                                            <th>Telepon</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($suplier as $row) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row->nama_suplier; ?></td>
                                                <td><?= $row->alamat; ?></td>
                                                <td><?= $row->telepon; ?></td>
                                                <td><?= $row->email; ?></td>
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
    var table;

    $(document).ready(function() {
        // Jika DataTable sudah ada, hancurkan sebelum membuat yang baru
        if ($.fn.DataTable.isDataTable('#example')) {
            $('#example').DataTable().destroy();
        }

        // Inisialisasi DataTable
        table = $('#example').DataTable({
            scrollX: true,
            autoWidth: false,
            columnDefs: [
                { width: '10%', targets: 0 },
                { width: '20%', targets: 1 },
                { width: '30%', targets: 2 },
                { width: '15%', targets: 3 },
                { width: '15%', targets: 4 },
                { width: '10%', targets: 5 }
            ]
        });

        // Fungsi filter
        $('#filter_suplier').on('change', function() {
            var filterValue = $(this).val();
            table.column(1).search(filterValue).draw();
        });
    });

    function printSuplierReport() {
        var filterValue = $('#filter_suplier option:selected').text();
        var filteredData = table.rows({
            search: 'applied'
        }).data().toArray();

        var printContents = `
        <div style="text-align: center; font-family: Arial, sans-serif;">
        <img src="<?= base_url('assets/dist/img/cahayalogo.png') ?>" alt="Logo" style="width: 100px; height: auto;">
            <h2>LAPORAN DATA SUPLIER</h2>
            <h3>TOKO CAHAYA - APP</h3>
            <p>Jl. Soekarno, Keraton, Kec. Martapura, Kota Martapura, Kalimantan Selatan 70714</p>
            <p>Filter: ${filterValue}</p>
            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Suplier</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Email</th>
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
