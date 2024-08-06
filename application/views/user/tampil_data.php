<?php
$level = $this->session->userdata('level');
$id_user = $this->session->userdata('id_user');
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <?php
                        // Teks berdasarkan level
                        if ($level == '1') {
                            echo 'Data User';
                        }
                        ?>
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">
                            <?php
                            $level = $this->session->userdata('level');

                            if ($level == '1') {
                                echo 'Data User';
                            } else {
                                // Handle other roles or provide a default message
                                echo 'Unknown Role';
                            }
                            ?>
                        </li>
                        <li class="breadcrumb-item active">Tampil Data</li>
                    </ol>
                </div><!-- /.col -->
                <?php if ($level != "1") : ?>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <button type="button" onclick="generatePdf()" class="form-control" style="background-color: #3CB371; color: white;">Export PDF</button>
                    </div>
                <?php endif; ?>
                <!-- <//?php if ($level != "pengawas" && $level != "admin") : ?>
                <div class="col-md-2">
                    <label>&nbsp;</label>
                    <button type="button" onclick="cetakkartu()" class="form-control" style="background-color: #3CB371; color: white;">Cetak Kartu</button>
                </div>
                <//?php endif; ?> -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php $this->load->view('template/notifikasi'); ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">
                                <?php
                                // Teks berdasarkan level
                                if ($level == '1') {
                                    echo 'Data User';
                                }
                                ?>
                            </h5>
                            <?php if ($level != "1") : ?>
                                <a href="<?= base_url('user/tambah') ?>" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i> Tambah Data</a>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center; vertical-align: middle;">No</th>
                                            <th style="text-align:center; vertical-align: middle;">Username</th>
                                            <th style="text-align:center; vertical-align: middle;">Password</th>
                                            <th style="text-align:center; vertical-align: middle;">Status</th>
                                            <th style="text-align:center; vertical-align: middle;">Nama Lengkap</th>
                                            <th style="text-align:center; vertical-align: middle;">Alamat</th>
                                            <th style="text-align:center; vertical-align: middle;">Telepon</th>
                                            <th style="text-align:center; vertical-align: middle;">Login Terakhir</th>
                                            <th style="text-align:center; vertical-align: middle;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($User as $row) {
                                            // Tambahkan kondisi untuk memeriksa level pengawas
                                        ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row->username; ?></td>
                                                <td><?= $row->password; ?></td>
                                                <td>
                                                    <?php
                                                    if ($row->level == '1') {
                                                        echo 'Admin';
                                                    } else {
                                                        echo $row->level;
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= $row->nama_lengkap; ?></td>
                                                <td><?= $row->alamat; ?></td>
                                                <td><?= $row->telepon; ?></td>
                                                <td><?= $row->login_terakhir; ?></td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="<?= base_url('user/ubah') ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                                            <a href="<?= base_url('user/hapus/')?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </td>
                                                
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- /.card -->
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    <!-- /.content -->
</div>
