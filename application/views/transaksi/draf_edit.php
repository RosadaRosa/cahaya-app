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
                    <h1 class="m-0">Edit Draf</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Draf</li>
                        <li class="breadcrumb-item active">Tampil Data</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <?php $this->load->view('template/notifikasi'); ?>
            <?php if ($level != "admin" && $level != "pengawas") : ?>
                <!-- Form Tambah Data dan Keranjang -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">

                                <h5 class="card-title">Edit Data Draf</h5>
                            </div>
                            <div class="card-body">
                                <form id="penjualanForm" method="POST" action="<?php echo base_url('transaksi/edit'); ?>">
                                    <div class="form-group">
                                        <label for="id_pelanggan">Pelanggan</label>
                                        <input type="hidden" name="id_pelanggan" value="<?php echo $penjualan->id_pelanggan; ?>">
                                        <input type="text" class="form-control" value="<?php echo $selected_pelanggan->nama_pelanggan; ?>" readonly>
                                    </div>
                                    <div id="barang-container">
                                        <div class="row barang-row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="id_barang">Barang</label>
                                                    <select name="id_barang[]" class="form-control id_barang">
                                                        <option value="">Pilih Barang</option>
                                                        <?php foreach ($barang as $o) : ?>
                                                            <option value="<?php echo $o->id_barang ?>" data-merk="<?php echo $o->merk ?>" data-bahan="<?php echo $o->bahan ?>" data-ukuran="<?php echo $o->ukuran ?>">
                                                                <?php echo $o->merk ?> - <?php echo $o->bahan ?> - <?php echo $o->ukuran ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="jumlah">Jumlah</label>
                                                    <input type="number" name="jumlah[]" class="form-control jumlah">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="setelah_diskon">Harga Jual</label>
                                                    <input type="text" name="harga_jual[]" class="form-control setelah_diskon" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button" class="btn btn-success btn-add" style="margin-top: 32px;">Tambah</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Keranjang Table -->
                                    <div class="table-responsive mt-4">
                                        <table id="keranjangTable" class="table table-hover table-bordered" width="auto">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Barang</th>
                                                    <th>Jumlah</th>
                                                    <th>Harga Jual</th>
                                                    <th>Total</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Keranjang Tabel -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="subtotal">Subtotal</label>
                                                <input type="text" id="subtotal" name="subtotal" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="diskon">Diskon</label>
                                                <input type="text" id="diskon" name="diskon" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="total">Total</label>
                                                <input type="text" id="total" name="total" class="form-control" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" id="updateTransaksi" class="btn btn-success btn-sm">
                                            <i class="fa fa-save"></i> Update Transaksi
                                        </button>
                                        <button type="button" id="batalTransaksi" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        var keranjang = [];

        // Inisialisasi keranjang dengan data dari penjualan_items jika ada
        <?php if (isset($penjualan_items) && is_array($penjualan_items)) : ?>
            updateKeranjangTable();
            hitungTotal();
        <?php endif; ?>

        // Fungsi untuk mendapatkan harga jual berdasarkan id_barang
        function getHargaJual(select) {
            var idbarang = $(select).val();
            var row = $(select).closest('.barang-row');

            if (idbarang) {
                $.ajax({
                    url: '<?php echo base_url('Penjualan/fungsi_pengambilan_data'); ?>',
                    method: 'post',
                    data: {
                        id_barang: idbarang
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data && data.setelah_diskon) {
                            row.find('.setelah_diskon').val(data.setelah_diskon);
                        } else {
                            alert("Data tidak ditemukan untuk barang tersebut");
                        }
                    },
                    error: function() {
                        alert("Gagal mengambil data harga jual");
                    }
                });
            } else {
                row.find('.setelah_diskon').val('');
            }
        }

        // Event listener untuk perubahan pada select id_barang
        $(document).on('change', '.id_barang', function() {
            getHargaJual(this);
        });

        // Fungsi untuk menambahkan item ke keranjang
        $(".btn-add").click(function() {
            var row = $(this).closest('.barang-row');
            var id_barang = row.find(".id_barang").val();
            var jumlah = row.find(".jumlah").val();
            var harga = row.find(".setelah_diskon").val();

            var selectedOption = row.find(".id_barang option:selected");
            var merk = selectedOption.data('merk');
            var bahan = selectedOption.data('bahan');
            var ukuran = selectedOption.data('ukuran');

            if (id_barang && jumlah && harga) {
                var total = parseInt(jumlah) * parseInt(harga);
                keranjang.push({
                    id_barang: id_barang,
                    merk: merk,
                    bahan: bahan,
                    ukuran: ukuran,
                    jumlah: parseInt(jumlah),
                    harga_jual: parseInt(harga),
                    total: total
                });

                updateKeranjangTable();
                hitungTotal();

                // Bersihkan form setelah ditambahkan ke keranjang
                row.find(".id_barang").val('');
                row.find(".jumlah").val('');
                row.find(".setelah_diskon").val('');
            } else {
                alert("Mohon isi semua field");
            }
        });

        // Memasukkan data penjualan yang sudah ada ke dalam keranjang
        <?php
        for ($i = 0; $i < count($penjualan->id_barang_array); $i++) {
            if (!empty($penjualan->id_barang_array[$i])) {
                echo "keranjang.push({
                id_barang: '" . $penjualan->id_barang_array[$i] . "',
                merk: '" . $barang[$i]->merk . "',
                bahan: '" . $barang[$i]->bahan . "',
                ukuran: '" . $barang[$i]->ukuran . "',
                jumlah: " . $penjualan->jumlah_array[$i] . ",
                harga_jual: " . $penjualan->harga_jual_array[$i] . ",
                total: " . ($penjualan->jumlah_array[$i] * $penjualan->harga_jual_array[$i]) . "
            });\n";
            }
        }
        ?>

        // Fungsi untuk mengupdate tampilan tabel keranjang
        function updateKeranjangTable() {
            var html = '';
            keranjang.forEach(function(item, index) {
                html += `<tr>
                <td>${index + 1}</td>
                <td data-id-barang="${item.id_barang}">${item.merk} - ${item.bahan} - ${item.ukuran}</td>
                <td>${item.jumlah}</td>
                <td>${item.harga_jual}</td>
                <td>${item.jumlah * item.harga_jual}</td>
                <td><button type="button" class="btn btn-danger btn-sm btn-remove" data-index="${index}">Hapus</button></td>
            </tr>`;
            });
            $("#keranjangTable tbody").html(html);
            hitungTotal(); // Hitung total setelah mengupdate tampilan tabel
        }

        // Fungsi untuk menghitung subtotal, diskon, dan total
        function hitungTotal() {
            var subtotal = keranjang.reduce((sum, item) => sum + (parseFloat(item.total) || 0), 0);

            $("#subtotal").val(subtotal.toFixed(2));

            var diskon = subtotal > 500000 ? subtotal * 0.05 : 0;
            var diskonText = diskon > 0 ? "Diskon 5% = " + diskon.toFixed(2) : "Tidak ada diskon";

            $("#diskon").val(diskonText);

            var total = subtotal - diskon;
            $("#total").val(total.toFixed(2));
        }

        // Event listener untuk menghapus item dari keranjang
        $(document).on("click", ".btn-remove", function() {
            var index = $(this).data('index');
            keranjang.splice(index, 1);
            updateKeranjangTable();
            hitungTotal();
        });

        // Event listener untuk menyimpan transaksi
        $("#updateTransaksi").click(function() {
            var id_penjualan = <?php echo $penjualan->id_penjualan; ?>;
            var id_pelanggan = $("input[name='id_pelanggan']").val();
            var diskon = $("#diskon").val().replace("Diskon 5% = ", "");
            var total = $("#total").val();
            var subtotal = $("#subtotal").val();

            var id_barang_array = keranjang.map(item => item.id_barang);
            var jumlah_array = keranjang.map(item => item.jumlah);
            var harga_jual_array = keranjang.map(item => item.harga_jual);

            $.ajax({
                url: '<?php echo base_url('transaksi/edit/'); ?>' + id_penjualan,
                method: 'POST',
                data: {
                    id_penjualan: id_penjualan,
                    id_pelanggan: id_pelanggan,
                    diskon: diskon,
                    total: total,
                    subtotal: subtotal,
                    id_barang: id_barang_array.join('"'),
                    jumlah: jumlah_array.join('"'),
                    harga_jual: harga_jual_array.join('"'),
                    status: 'Selesai'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        alert(response.message);
                        window.location.href = '<?php echo base_url('transaksi/draf'); ?>';
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    alert('Terjadi kesalahan saat menyimpan transaksi: ' + error);
                }
            });
        });

        // Event listener untuk membatalkan transaksi
        $("#batalTransaksi").click(function() {
            if (confirm('Apakah Anda yakin ingin membatalkan transaksi?')) {
                keranjang = [];
                updateKeranjangTable();
                hitungTotal();
                $("#penjualanForm")[0].reset();
            }
        });

        // Panggil updateKeranjangTable dan hitungTotal setelah halaman selesai dimuat
        updateKeranjangTable();
        hitungTotal();
    });
</script>