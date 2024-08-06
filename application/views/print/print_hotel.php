<?php
// Tambahkan kondisi untuk mengecek apakah $hotel1 dan $hotel2 tidak kosong
if (!empty($hotel1) && !empty($hotel2)) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Responden</title>
    <!-- Tambahkan gaya atau tag meta yang diperlukan untuk pencetakan -->
    <style>
        /* Tambahkan gaya pencetakan Anda di sini */
    </style>
</head>
<body>
<table class="table table-hover table-bordered col-lg-12">
            <form>    
            <tbody>
            <?php
    $no = 1;
    foreach ($hotel1 as $row) { ?>
    <tr>
      <th scope="row">Provinsi</th>
      <td><?= $row->provinsi; ?></td>
      <th scope="row">Nama Hotel</th>
      <td><?= $row->nama_hotel; ?></td>
    </tr>
    <tr>
      <th scope="row">Kabupaten</th>
      <td><?= $row->kabupaten; ?></td>
      <th scope="row">Alamat</th>
      <td><?= $row->alamat; ?></td>
    </tr>
    <tr>
      <th scope="row">Kecamatan</th>
      <td><?= $row->kecamatan; ?></td>
      <th scope="row">Jenis Akomodasi</th>
      <td><?= $row->jenis_akomodasi; ?></td>
    </tr>
    <tr>
      <th scope="row">Kelurahan/Desa</th>
      <td><?= $row->desa; ?></td>
      <th scope="row">Kelas Akomodasi</th>
      <td><?= $row->kelas_akomodasi; ?></td>
    </tr>
    <tr>
      <th scope="row">Id SBR</th>
      <td><?= $row->id_sbr; ?></td>
      <th scope="row">ID Wilkerstat</th>
      <td><?= $row->id_wilkerstat; ?></td>
    </tr>
    <tr>
      <th scope="row">Bulan</th>
      <td><?= $row->bulan; ?></td>
    </tr>
    <?php } ?>
  </tbody>
            </form>
       </table>

       
      </div>
     </div><!-- /.card -->

     <div class="card card-primary card-outline">
        <div class="card-header">
            <h5 class="card-title">Harga Tarif Kamar Per Hari</h5>  
        </div>
      <div class="card-body">
       <table class="table table-hover table-bordered col-lg-12">
            <form>    
            <tbody>
    <?php 
    $no = 1;
    foreach ($hotel1 as $row) { ?>
    <tr>
      <th scope="row" rowspan="4">Non Suite</th>
      <th scope="row" colspan="1"></th>
      <th scope="row" colspan="1">Hari Kerja</th>
      <th scope="row" colspan="1">Hari Libur</th>
      <th scope="row" rowspan="4">Suite</th>
      <th scope="row" colspan="1"></th>
      <th scope="row" colspan="1">Hari Kerja</th>
      <th scope="row" colspan="1">Hari Libur</th>
      
    </tr>
    <tr>
      <th scope="row">Standar</th>
      <td><?= $row->standar_hkerja; ?></td>
      <td><?= $row->standar_hlibur; ?></td>
      <th scope="row">Junior Suite</th>
      <td><?= $row->junsuite_hkerja; ?></td>
      <td><?= $row->junsuite_hlibur; ?></td>
    </tr>
    <tr>
      <th scope="row">Superior</th>
      <td><?= $row->superior_hkerja; ?></td>
      <td><?= $row->superior_hlibur; ?></td>
      <th scope="row">Suite</th>
      <td><?= $row->suite_hkerja; ?></td>
      <td><?= $row->suite_hlibur; ?></td>
    </tr>
    <tr>
      <th scope="row">Deluxe</th>
      <td><?= $row->deluxe_hkerja; ?></td>
      <td><?= $row->deluxe_hlibur; ?></td>
      <th scope="row">Presiden Suite</th>
      <td><?= $row->pres_hkerja; ?></td>
      <td><?= $row->pres_hlibur; ?></td>
    </tr>
    <?php } ?>
  </tbody>
            </form>
       </table>

       
      </div>
     </div><!-- /.card -->

     <div class="card card-primary card-outline">
        <div class="card-header">
            <h5 class="card-title">Jumlah Kamar, Tempat, Dan Tamu</h5>  
        </div>
      <div class="card-body">
       <table class="table table-hover table-bordered col-lg-12">
            <form>    
            <thead>
            <tr>
                <th rowspan="3">Tanggal</th>
                <th rowspan="3">Jumlah Kamar Tersedia</th>
                <th rowspan="3">Kapasitas Tempat Tidur Tersedia</th>
                <th colspan="3">Banyaknya KAmar</th>
                <th colspan="6">Banyaknya Tamu Menginap</th>
            </tr>
            <tr>
                <th rowspan="2">Digunakan Kemaren</th>
                <th rowspan="2">Check In</th>
                <th rowspan="2">Check Out</th>
                <th colspan="2">Kemaren</th>
                <th colspan="2">Masuk Hari Ini</th>
                <th colspan="2">Keluar Hari Ini</th>
            </tr>
            <tr>
                <th>Asing</th>
                <th>Indonesia</th>
                <th>Asing</th>
                <th>Indonesia</th>
                <th>Asing</th>
                <th>Indonesia</th>
            </tr>
        </thead>
        <tbody>
        <?php
    $no = 1;
    foreach ($hotel2 as $row) { ?>
            <tr>
                <td><?= $row->tanggal; ?></td>
        <td><?= $row->kamar_tersedia; ?></td>
        <td><?= $row->tempat_tidur; ?></td>
        <td><?= $row->digunakan_kemaren; ?></td>
        <td><?= $row->cekin; ?></td>
        <td><?= $row->cekout; ?></td>
        <td><?= $row->asing_k; ?></td>
        <td><?= $row->indonesia_k; ?></td>
        <td><?= $row->asing_m; ?></td>
        <td><?= $row->indonesia_m; ?></td>
        <td><?= $row->asing_kel; ?></td>
        <td><?= $row->indonesia_kel; ?></td>
                
            </tr>
            <!-- Add more rows as needed -->
            <?php } ?>
        </tbody>
            </form>
       </table>

       <script type="text/javascript">
    window.onload = function() {
        window.print();
        window.onafterprint = function(){
            window.close();
        };
    };
</script>
</body>
</html>
<?php
} 
