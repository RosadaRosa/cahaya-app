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
                    <h1 class="m-0">Data User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Data User</li>
                        <li class="breadcrumb-item active">Tampil Data</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <?php $this->load->view('template/notifikasi'); ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title"> Data User</h5>
                            <?php if ($level != "2" ) : ?>
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
                                            <th style="text-align:center; vertical-align: middle;">Status</th>
                                            <th style="text-align:center; vertical-align: middle;">Nama Lengkap</th>
                                            <th style="text-align:center; vertical-align: middle;">Alamat</th>
                                            <th style="text-align:center; vertical-align: middle;">No Telp</th>
                                            <th style="text-align:center; vertical-align: middle;">Login Terakhir</th>
                                            <?php if ($level == "1") : ?>
                                            <th style="text-align:center; vertical-align: middle;">Aksi</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($User as $row) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row->username; ?></td>
                                                <td>
                                                    <?php
                                                    if ($row->level == '1') {
                                                        echo 'Admin';
                                                    }elseif ($row->level == '2') {
                                                        echo 'Karyawan';
                                                    }
                                                     else {
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
                                                    <a href="<?= base_url('user/ubah/' . $row->id_user) ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                                        <button class="btn btn-danger btn-sm" onclick="confirmDeletion('<?= $row->id_user; ?>')"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </td>
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
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    <!-- /.content -->
</div>