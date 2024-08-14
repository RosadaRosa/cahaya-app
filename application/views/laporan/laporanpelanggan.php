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
                    <h1 class="m-0">Pelanggan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pelanggan</li>
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
                            <h5 class="card-title">Data Pelanggan</h5>
                            <button onclick="printPelangganReport()" class="btn btn-info btn-sm float-right mr-2"><i class="fa fa-print"></i> Cetak Laporan</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Alamat</th>
                                            <th>Telepon</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($pelanggan as $row) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row->nama_pelanggan; ?></td>
                                                <td><?= $row->alamat; ?></td>
                                                <td><?= $row->telepon; ?></td>
                                                <td><?= $row->email; ?></td>
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
</div>


<script>
    var table;

    $(document).ready(function() {
        // Inisialisasi DataTable
        table = $('#example').DataTable({
            scrollX: true,
            autoWidth: false,
            columnDefs: [{
                    width: '10%',
                    targets: 0
                },
                {
                    width: '20%',
                    targets: 1
                },
                {
                    width: '30%',
                    targets: 2
                },
                {
                    width: '15%',
                    targets: 3
                },
                {
                    width: '15%',
                    targets: 4
                },
                {
                    width: '10%',
                    targets: 5
                }
            ]
        });
    });

    function editPelanggan(id) {
        $.ajax({
            url: '<?= base_url('pelanggan/get_pelanggan/') ?>' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#edit_id_pelanggan').val(data.id_pelanggan);
                $('#edit_nama_pelanggan').val(data.nama_pelanggan);
                $('#edit_alamat').val(data.alamat);
                $('#edit_telepon').val(data.telepon);
                $('#edit_email').val(data.email);
                $('#editPelangganModal').modal('show');
            },
            error: function() {
                alert('Terjadi kesalahan saat mengambil data pelanggan');
            }
        });
    }

    function confirmDeletion(id) {
        $('#confirmDeleteBtn').attr('href', '<?= base_url('pelanggan/hapus/') ?>' + id);
        $('#deletionModal').modal('show');
    }

    function printPelangganReport() {
        var filterValue = $('#filter_pelanggan option:selected').text();
        var filteredData = table.rows({
            search: 'applied'
        }).data().toArray();

        var printContents = `
        <div style="text-align: center; font-family: Arial, sans-serif;">
            <img src="<?= base_url('assets/dist/img/cahayalogo.png') ?>" alt="Logo" style="width: 100px; height: auto;">
            <h2>LAPORAN DATA PELANGGAN</h2>
            <h3>TOKO CAHAYA - APP</h3>
            <p>Jl. Sasaran, Kerokan, Kec. Martapura, Kota Martapura, Kalimantan Selatan 70714</p>
            <p>Filter: ${filterValue}</p>
            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
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