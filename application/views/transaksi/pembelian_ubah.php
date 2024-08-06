<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kapasitas Hotel</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Kapasitas Hotel</li>
                        <li class="breadcrumb-item active">Ubah Data Kapasitas Hotel</li>
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
                            <h5 class="card-title">Perbaharui Data Kapasitas Hotel </h5>
                            <a href="<?= base_url('hotel2'); ?>" class="btn btn-info btn-sm float-right">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('hotel2/ubah_data/' . $hotel2->id_hotel_hal2); ?>" method="post">
                                <div class="form-group">
                                    <label>Bulan-Nama Hotel</label>
                                    <select name="id_hotel_hal1" id="id_hotel_hal1" class="form-control" required="required">
                                        <option value="">Pilih Bulan dan Nama Hotel</option>
                                        <?php foreach ($hotel_hal1->result() as $o) : ?>
                                            <?php
                                            $hotel_data = $this->db->get_where('hotel', array('id_hotel' => $o->id_hotel))->row();
                                            $nama_hotel = ($hotel_data) ? $hotel_data->nama_hotel : 'Nama Hotel Tidak Ditemukan';
                                            $selected = ($o->id_hotel_hal1 == $hotel2->id_hotel_hal1) ? 'selected' : ''; // Tambahkan baris ini
                                            ?>
                                            <option value="<?php echo $o->id_hotel_hal1 ?>" <?php echo $selected ?>>
                                                <?php echo $o->bulan ?> - <?php echo $nama_hotel ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal" value="<?= $hotel2->tanggal ?>" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="kamar_tersedia">Jumlah Kamar Tersedia</label>
                                    <input type="text" name="kamar_tersedia" id="kamar_tersedia" value="<?= $hotel2->kamar_tersedia ?>" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="tempat_tidur">Kapasitas Tempat Tidur Tersedia</label>
                                    <input type="text" name="tempat_tidur" id="tempat_tidur" value="<?= $hotel2->tempat_tidur ?>" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="digunakan_kemaren">Digunakan Kemaren</label>
                                    <input type="text" name="digunakan_kemaren" id="digunakan_kemaren" value="<?= $hotel2->digunakan_kemaren ?>" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="cekin">Check In</label>
                                    <input type="text" name="cekin" id="cekin" value="<?= $hotel2->cekin ?>" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="cekout">Check Out</label>
                                    <input type="text" name="cekout" id="cekout" value="<?= $hotel2->cekout ?>" class="form-control" required>
                                </div>
                                <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="asing_k">Tamu Asing Menginap Kemaren</label>
                                    <input type="text" name="asing_k" id="asing_k" value="<?= $hotel2->asing_k ?>" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="indonesia_k">Tamu Indonesia Menginap Kemaren</label>
                                    <input type="text" name="indonesia_k" id="indonesia_k" value="<?= $hotel2->indonesia_k ?>" class="form-control" required>
                                </div>
                                </div>
                                <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="asing_m">Tamu Asing Masuk Hari Ini</label>
                                    <input type="text" name="asing_m" id="asing_m" value="<?= $hotel2->asing_m ?>" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="indonesia_m">Tamu Indonesia Masuk Hari Ini</label>
                                    <input type="text" name="indonesia_m" id="indonesia_m" value="<?= $hotel2->indonesia_m ?>" class="form-control" required>
                                </div>
                                </div>
                                <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="asing_kel">Tamu Asing Keluar Hari ini</label>
                                    <input type="text" name="asing_kel" id="asing_kel" value="<?= $hotel2->asing_kel ?>" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="indonesia_kel">Tamu Indonesia Keluar Kemaren</label>
                                    <input type="text" name="indonesia_kel" id="indonesia_kel" value="<?= $hotel2->indonesia_kel ?>" class="form-control" required>
                                </div>
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