<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Merk</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item">Data Merk</li>
            <li class="breadcrumb-item active">Ubah Data Merk</li>
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
        <div class="col-lg-4">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Perbaharui Data Merk
                <a href="<?= base_url('merk'); ?>" class="btn btn-info btn-sm float-rigth"><i class="fa fa-arrow-left"></i> Kembali</a>
              </h5>
            </div>
            <div class="card-body">
              <form action="" method="post">
                <div class="form-group">
                  <label for="merk">Merk</label>
                  <input type="text" name="merk" value="<?= $merk->merk ?>" id="merk" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="bahan">Bahan</label>
                  <input type="text" name="bahan" id="bahan" value="<?= $merk->bahan ?>" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="ukuran">Ukuran</label>
                  <input type="text" name="ukuran" id="ukuran" value="<?= $merk->ukuran ?>" class="form-control" required>
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