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
                    <h1 class="m-0">Penjualan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Penjualan</li>
                        <li class="breadcrumb-item active">Tampil Data</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- ... (previous code remains the same) ... -->


    <div class="content">
        <div class="container-fluid">
            <?php $this->load->view('template/notifikasi'); ?>

            <?php if ($level != "admin" && $level != "pengawas") : ?>
                <!-- Form Tambah Data dan Keranjang -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <a href="<?= base_url('transaksi/draf') ?>" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i> Draf Data</a>
                                <h5 class="card-title">Tambah Data Penjualan</h5>
                            </div>
                            <div class="card-body">
                                <form id="penjualanForm" method="POST" action="<?php echo base_url('transaksi/save'); ?>">
                                    <!-- Hidden inputs for action -->
                                    <input type="hidden" id="formAction" name="formAction" value="save">
                                    <div class="form-group">
                                        <label for="id_pelanggan">Pelanggan</label>
                                        <select name="id_pelanggan" id="id_pelanggan" class="form-control" required="required">
                                            <option value="">Pilih Pelanggan</option>
                                            <?php foreach ($pelanggan as $o) : ?>
                                                <option value="<?php echo $o->id_pelanggan ?>"><?php echo $o->nama_pelanggan ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div id="barang-container">
                                        <div class="row barang-row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="id_barang">Barang</label>
                                                    <select name="id_barang[]" class="form-control id_barang">
                                                        <option value="">Pilih Barang</option>
                                                        <?php foreach ($barang as $o) : ?>
                                                            <option value="<?php echo $o->id_barang ?>"><?php echo $o->merk ?> - <?php echo $o->bahan ?> - <?php echo $o->ukuran ?></option>
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
                                                <!-- Keranjang items will be added here dynamically -->
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
                                    <div class="row mt-3">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="bayar">Bayar</label>
                                                <div class="input-group">
                                                    <input type="number" id="bayar" name="bayar" class="form-control" min="0">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="button" id="btnBayar">Bayar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="kembalian">Kembalian</label>
                                                <input type="text" id="kembalian" name="kembalian" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" id="simpanTransaksi" class="btn btn-success btn-sm">
                                            <i class="fa fa-save"></i> Simpan Transaksi
                                        </button>
                                        <button type="button" id="draf" class="btn btn-warning btn-sm">
                                            <i class="fa fa-save"></i> Draf
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
    var keranjang = [];

    $(document).ready(function() {
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

        $(document).on('change', '.id_barang', function() {
            getHargaJual(this);
        });

        $(".btn-add").click(function() {
            var row = $(this).closest('.barang-row');
            var id_barang = row.find(".id_barang").val();
            var jumlah = row.find(".jumlah").val();
            var harga_jual = row.find(".setelah_diskon").val();
            var nama_barang = row.find(".id_barang option:selected").text();

            if (id_barang || jumlah || harga_jual) {
                var total = parseInt(jumlah || 0) * parseInt(harga_jual || 0);
                keranjang.push({
                    id_barang: id_barang || null,
                    nama_barang: nama_barang || 'Barang Tidak Terdaftar',
                    jumlah: jumlah || 0,
                    harga_jual: harga_jual || 0,
                    total: total
                });

                updateKeranjangTable();
                hitungTotal();

                row.find(".id_barang").val('');
                row.find(".jumlah").val('');
                row.find(".setelah_diskon").val('');
            } else {
                alert("Mohon isi minimal satu field");
            }
        });

        function updateKeranjangTable() {
            var html = '';
            keranjang.forEach(function(item, index) {
                html += '<tr>';
                html += '<td>' + (index + 1) + '</td>';
                html += '<td>' + (item.nama_barang || 'Barang Tidak Terdaftar') + '</td>';
                html += '<td>' + (item.jumlah || 0) + '</td>';
                html += '<td>' + (item.harga_jual || 0) + '</td>';
                html += '<td>' + item.total + '</td>';
                html += '<td><button type="button" class="btn btn-danger btn-sm btn-remove" data-index="' + index + '">Hapus</button></td>';
                html += '</tr>';
            });
            $("#keranjangTable tbody").html(html);
        }

        $(document).on("click", ".btn-remove", function() {
            var index = $(this).data('index');
            keranjang.splice(index, 1);
            updateKeranjangTable();
            hitungTotal();
        });

        function hitungTotal() {
            var subtotal = keranjang.reduce((sum, item) => sum + item.total, 0);
            $("#subtotal").val(subtotal);

            var diskon = 0;
            var diskonText = "";
            if (subtotal > 500000) {
                diskon = subtotal * 0.05;
                diskonText = "Diskon 5% = " + diskon.toFixed(0);
            } else {
                diskonText = "Tidak ada diskon";
            }

            var total = subtotal - diskon;

            $("#diskon").val(diskonText);
            $("#total").val(total.toFixed(0));
        }

        function printReceipt(id_penjualan) {
            $.ajax({
                url: '<?= base_url('penjualan/get_sale_data/') ?>' + id_penjualan,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (!data || !data.items || !Array.isArray(data.items)) {
                        alert('Data penjualan tidak valid');
                        return;
                    }

                    var receiptHTML = `
            <div style="width: 500px; font-family: Arial, sans-serif;">
                <h2 style="text-align: center;">NOTA PENJUALAN</h2>
                <h3 style="text-align: center;">TOKO CAHAYA - APP</h3>
                <p style="text-align: center; font-size: 12px;">
                    Jl. Sasaran, Keraton, Kec. Martapura, Kota Martapura, Kalimantan Selatan 70714<br>
                    No. Hp/WA : 089530594535<br>
                    Jam Operasional : Senin - Sabtu : 09.00 - 16.00
                </p>
                <hr>
                <p>No. Faktur : ${data.id_penjualan}</p>
                <p>Pelanggan : ${data.nama_pelanggan}</p>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <th style="border: 1px solid black;">Barang</th>
                        <th style="border: 1px solid black;">jumlah</th>
                        <th style="border: 1px solid black;">Harga Jual</th>
                        <th style="border: 1px solid black;">Diskon</th>
                        <th style="border: 1px solid black;">total</th>
                    </tr>
                    ${data.items.map(item => `
                        <tr>
                            <td style="border: 1px solid black;">
                               ${item.merk || 'N/A'} - ${item.bahan || 'N/A'} - ${item.ukuran || 'N/A'}
                            </td>
                            <td style="border: 1px solid black;">
                               ${item.jumlah.split('"').map(j => j.trim()).filter(j => j !== '').join('<br>')}
                            </td>
                            <td style="border: 1px solid black;">${item.harga_jual || '0'}</td>
                            <td style="border: 1px solid black;">${item.diskon || 'Tidak ada diskon'}</td>
                            <td style="border: 1px solid black;">${item.total || '0'}</td>
                        </tr>
                    `).join('')}
                </table>
                <p style="text-align: right;">Total Bayar: Rp ${data.total_bayar || '0'}</p>
                <p style="text-align: center;">----- TERIMA KASIH -----</p>
                <p style="text-align: center; font-size: 12px;">Barang yang sudah dibeli tidak dapat DITUKAR/DIKEMBALIKAN</p>
            </div>
            `;

                    var printWindow = window.open('', '_blank');
                    printWindow.document.write(receiptHTML);
                    printWindow.document.close();
                    printWindow.print();
                    printWindow.onafterprint = function() {
                        printWindow.close();
                    };
                },
                error: function() {
                    alert('Gagal mengambil data penjualan');
                }
            });
        }

        $("#simpanTransaksi").click(function() {
            saveTransaction('Selesai');
        });

        $("#simpanTransaksi").click(function() {
            saveTransaction('Selesai');
        });

        $("#draf").click(function() {
            saveTransaction('Pending');
        });


        $("#btnBayar").click(function() {
            var total = parseInt($("#total").val()) || 0;
            var bayar = parseInt($("#bayar").val()) || 0;

            if (bayar < total) {
                alert("Jumlah pembayaran kurang dari total belanja!");
                return;
            }

            var kembalian = bayar - total;
            $("#kembalian").val(kembalian);

            // Enable the "Simpan Transaksi" button after successful payment
            $("#simpanTransaksi").prop("disabled", false);
        });

        function saveTransaction(status) {
            var id_pelanggan = $("#id_pelanggan").val();
            var diskon = $("#diskon").val();
            var total = $("#total").val();
            var id_barang = [];
            var jumlah = [];
            var harga_jual = [];

            keranjang.forEach(function(item) {
                if (item.id_barang !== null) {
                    id_barang.push(item.id_barang);
                    jumlah.push(item.jumlah);
                    harga_jual.push(item.harga_jual);
                }
            });

            if (id_pelanggan && total) {
                $.ajax({
                    url: '<?php echo base_url('transaksi/save'); ?>',
                    method: 'POST',
                    data: {
                        id_pelanggan: id_pelanggan,
                        diskon: diskon,
                        total: total,
                        id_barang: id_barang,
                        jumlah: jumlah,
                        harga_jual: harga_jual,
                        status: status
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            alert(response.message);
                            if (status === 'Selesai') {
                                // Cetak struk pembayaran
                                printStruk(response.id_penjualan);
                            }
                            // Reset form and cart
                            keranjang = [];
                            updateKeranjangTable();
                            hitungTotal();
                            $("#penjualanForm")[0].reset();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        alert('Terjadi kesalahan saat menyimpan transaksi: ' + error);
                    }
                });
            } else {
                alert('Pelanggan dan total tidak boleh kosong');
            }
        }
    });

    function printStruk(id_penjualan) {
        // Buka jendela baru untuk struk
        var printWindow = window.open('', '_blank');

        // Ambil data struk dari server
        $.ajax({
            url: '<?php echo base_url('transaksi/get_struk'); ?>',
            method: 'GET',
            data: {
                id_penjualan: id_penjualan
            },
            dataType: 'html',
            success: function(response) {
                // Tulis konten struk ke jendela baru
                printWindow.document.write(response);
                printWindow.document.close();

                // Tunggu gambar dan stylesheet dimuat
                printWindow.onload = function() {
                    // Cetak halaman
                    printWindow.print();
                    // Tutup jendela setelah mencetak
                    printWindow.onafterprint = function() {
                        printWindow.close();
                    };
                };
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('Terjadi kesalahan saat mengambil data struk: ' + error);
                printWindow.close();
            }
        });
    }

    $("#batalTransaksi").click(function() {
        if (confirm('Apakah Anda yakin ingin membatalkan transaksi?')) {
            keranjang = [];
            updateKeranjangTable();
            hitungTotal();
            $("#penjualanForm")[0].reset();
        }
    });
</script>