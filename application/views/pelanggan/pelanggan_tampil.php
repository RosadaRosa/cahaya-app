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
                            <?php if ($level != "admin" && $level != "pengawas") : ?>
                                <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#tambahPelangganModal"><i class="fa fa-plus"></i> Tambah Data</button>
                            <?php endif; ?>
                            <button onclick="printPelangganReport()" class="btn btn-info btn-sm float-right mr-2"><i class="fa fa-print"></i> Cetak Laporan</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Alamat</th>
                                            <th>Telepon</th>
                                            <th>Email</th>
                                            <th>Aksi</th>
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
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-warning btn-sm" onclick="editPelanggan(<?= $row->id_pelanggan; ?>)"><i class="fa fa-edit"></i></button>
                                                        <button class="btn btn-danger btn-sm" onclick="confirmDeletion('<?= $row->id_pelanggan; ?>')"><i class="fa fa-trash"></i></button>
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
    </div>
</div>

<!-- Modal Tambah Pelanggan -->
<div class="modal fade" id="tambahPelangganModal" tabindex="-1" role="dialog" aria-labelledby="tambahPelangganModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPelangganModalLabel">Tambah Data Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('pelanggan/tambah') ?>" method="post">
                    <div class="form-group">
                        <label for="nama_pelanggan">Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="telepon">Telepon</label>
                        <input type="text" name="telepon" id="telepon" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="simpan" class="btn btn-success btn-sm">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                            <i class="fa fa-ban"></i> Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Pelanggan -->
<div class="modal fade" id="editPelangganModal" tabindex="-1" role="dialog" aria-labelledby="editPelangganModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPelangganModalLabel">Edit Data Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPelangganForm" action="<?= base_url('pelanggan/ubah') ?>" method="post">
                    <input type="hidden" name="id_pelanggan" id="edit_id_pelanggan">
                    <div class="form-group">
                        <label for="edit_nama_pelanggan">Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan" id="edit_nama_pelanggan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_alamat">Alamat</label>
                        <input type="text" name="alamat" id="edit_alamat" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_telepon">Telepon</label>
                        <input type="text" name="telepon" id="edit_telepon" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="simpan" class="btn btn-success btn-sm">
                            <i class="fa fa-save"></i> Simpan Perubahan
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                            <i class="fa fa-ban"></i> Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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