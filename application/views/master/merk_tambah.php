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
            <li class="breadcrumb-item active">Tampil Data</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <?php $this->load->view('template/notifikasi'); ?>
      <div class="row">
        <!-- <//?php if ($level != "admin") : ?> -->
          <div class="col-lg-4">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Tambah Data Merk</h5>
              </div>
              <div class="card-body">
                <form action="<?= base_url('merk/tambah') ?>" method="post">
                  <div class="form-group">
                    <label for="merk">Merk</label>
                    <input type="text" name="merk" id="merk" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="bahan">Bahan</label>
                    <input type="text" name="bahan" id="bahan" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="ukuran">Ukuran</label>
                    <input type="text" name="ukuran" id="ukuran" class="form-control" required>
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
          <!-- <//?php endif; ?> -->
          </div>
          <div class="col-lg-8">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-title">Tampil Data Merk</h5>
              </div>
              <div class="card-body">
                <table id="example" class="table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Merk</th>
                      <th>Bahan</th>
                      <th>Ukuran</th>                   
                      <!-- <//?php if ($peran != "admin") : ?> -->
                        <th>Aksi</th>
                      <!-- <//?php endif; ?> -->
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    foreach ($merk as $row) { ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row->merk; ?></td>
                        <td><?= $row->bahan; ?></td>
                        <td><?= $row->ukuran; ?></td>
                        <!-- <//?php if ($peran != "admin") : ?> -->
                          <td>
                            <div class="btn btn-group">
                              <a href="<?= base_url('merk/ubah/' . $row->id_merk) ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                              <a href="<?= base_url('merk/hapus/' . $row->id_merk) ?>" onclick="return confirm('Hapus Data Ini?'); " class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                            </div>
                          </td>
                        <!-- <//?php endif; ?> -->
                      </tr>
                    <?php }
                    ?>
                  </tbody>
                </table>
              </div>
            </div><!-- /.card -->
          </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
  <!-- /.content -->
</div>

<script>
  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>