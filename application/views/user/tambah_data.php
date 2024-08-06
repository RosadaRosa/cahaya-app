<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">User</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item">User</li>
            <li class="breadcrumb-item active">Tambah Data</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">
                Tambah Data User </h5>
              <a href="<?= base_url('user'); ?>" class="btn btn-info btn-sm float-right"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="card-body">
              <form action="" method="post">
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="text" name="password" id="password" id="password" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="level">Status</label>
                  <select name="level" id="level" id="level" class="form-control" required>
                    <option value=""> Pilih Status</option>
                    <option value="1"> Admin</option>
                    <option value="2"> Pegawai</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="nama_lengkap">Nama Lengkap</label>
                  <input type="text" name="nama_lengkap" id="nama_lengkap" id="nama_lengkap" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="alamat">Alamat</label>
                  <input type="text" name="alamat" id="alamat" id="alamat" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="telepon">No Telepon</label>
                  <input type="text" name="telepon" id="telepon" id="telepon" class="form-control" required>
                </div>
                <div class="form-group">
                  <button type="submit" name="simpan" class="btn btn-success btn-sm">
                    <i class="fa fa-save"></i>Simpan </button>
                  <button type="reset" class="btn btn-danger btn-sm">
                    <i class="fa fa-ban"></i>Batal </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
  <!-- /.content -->
</div>