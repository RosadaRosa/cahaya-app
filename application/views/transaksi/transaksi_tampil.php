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
                    <h1 class="m-0">Transaksi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Transaksi</li>
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
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="date">Tanggal</label>
                                        <input type="text" id="date" name="date" class="form-control" readonly>
                                    </div>
                                </div>
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
                                                    <div class="dropdown">
                                                        <input type="text" class="form-control dropdown-toggle" id="barangSearch" placeholder="Cari Barang" data-toggle="dropdown">
                                                        <div class="dropdown-menu" style="width: 100%; max-height: 200px; overflow-y: auto;">
                                                            <input type="text" class="form-control" id="dropdownSearch" placeholder="Ketik untuk mencari...">
                                                            <div id="barangOptions">
                                                                <?php foreach ($barang as $o) : ?>
                                                                    <a class="dropdown-item" href="#" data-value="<?php echo $o->id_barang ?>"><?php echo $o->merk ?> - <?php echo $o->bahan ?> - <?php echo $o->ukuran ?></a>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="id_barang[]" class="id_barang">
                                                    </div>
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
                                                    <button class="btn btn-primary" type="button" id="btnBayar">Bayar</button>

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

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    .dropdown-menu {
        display: none;
    }

    .dropdown-menu.show {
        display: block;
    }

    #dropdownSearch {
        position: sticky;
        top: 0;
        z-index: 1;
    }
</style>

<script>
    $(document).ready(function() {
        var keranjang = [];
        var selectedItems = new Set();

        function initBarangSearch() {
            var barangSearch = document.getElementById('barangSearch');
            var dropdownSearch = document.getElementById('dropdownSearch');
            var barangOptions = document.getElementById('barangOptions');
            var idBarangInput = document.querySelector('.id_barang');

            barangSearch.addEventListener('click', function() {
                this.nextElementSibling.classList.add('show');
            });

            dropdownSearch.addEventListener('input', function() {
                var filter = this.value.toLowerCase();
                var items = barangOptions.getElementsByTagName('a');
                for (var i = 0; i < items.length; i++) {
                    var txtValue = items[i].textContent || items[i].innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        items[i].style.display = "";
                    } else {
                        items[i].style.display = "none";
                    }
                }
            });

            barangOptions.addEventListener('click', function(e) {
                if (e.target && e.target.nodeName == 'A') {
                    var selectedText = e.target.textContent;
                    var selectedValue = e.target.getAttribute('data-value');

                    barangSearch.value = selectedText;
                    idBarangInput.value = selectedValue;

                    this.closest('.dropdown-menu').classList.remove('show');

                    // Call getHargaJual function when a product is selected
                    getHargaJual(idBarangInput);
                }
            });

            document.addEventListener('click', function(e) {
                if (!barangSearch.contains(e.target) && !barangSearch.nextElementSibling.contains(e.target)) {
                    barangSearch.nextElementSibling.classList.remove('show');
                }
            });
        }

        function updateBarangDropdown() {
            var items = document.querySelectorAll('#barangOptions a');
            items.forEach(function(item) {
                if (selectedItems.has(item.getAttribute('data-value'))) {
                    item.style.display = 'none';
                } else {
                    item.style.display = '';
                }
            });
        }

        function calculateRowTotal(row) {
            var jumlah = parseInt(row.find('.jumlah').val()) || 0;
            var harga_jual = parseInt(row.find('.setelah_diskon').val()) || 0;
            var total = jumlah * harga_jual;
            row.find('.total').val(total);
        }

        function getHargaJual(idBarangInput) {
            var idbarang = $(idBarangInput).val();
            var row = $(idBarangInput).closest('.barang-row');

            if (idbarang) {
                $.ajax({
                    url: '<?php echo base_url('Penjualan/fungsi_pengambilan'); ?>',
                    method: 'post',
                    data: {
                        id_barang: idbarang
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data && data.setelah_diskon) {
                            row.find('.setelah_diskon').val(data.setelah_diskon);
                            // Trigger perhitungan total
                            calculateRowTotal(row);
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

        function updateKeranjangTable() {
            var html = '';
            keranjang.forEach(function(item, index) {
                html += '<tr>';
                html += '<td>' + (index + 1) + '</td>';
                html += '<td>' + (item.nama_barang || 'Barang Tidak Terdaftar') + '</td>';
                html += '<td><input type="number" class="form-control jumlah-update" value="' + (item.jumlah || 0) + '" data-index="' + index + '"></td>';
                html += '<td>' + (item.harga_jual || 0) + '</td>';
                html += '<td class="total">' + item.total + '</td>';
                html += '<td><button type="button" class="btn btn-danger btn-sm btn-remove" data-index="' + index + '">Hapus</button></td>';
                html += '</tr>';
            });
            $("#keranjangTable tbody").html(html);
        }

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
            if (!id_penjualan) {
                alert("ID Penjualan tidak valid.");
                return;
            }

            var printWindow = window.open('<?= base_url('transaksi/get_struk?id_penjualan=') ?>' + id_penjualan, '_blank');

            printWindow.onload = function() {
                printWindow.print();
            };
        }

        function saveTransaction(status) {
            var id_pelanggan = $("#id_pelanggan").val();
            var diskon = $("#diskon").val();
            var total = $("#total").val();
            var id_barang = [];
            var jumlah = [];
            var harga_jual = [];
            var bayar = $("#bayar").val();
            var kembalian = $("#kembalian").val();

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
                        status: status,
                        bayar: bayar,
                        kembalian: kembalian
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            alert(response.message);
                            if (status === 'Selesai' && response.id_penjualan) {
                                printReceipt(response.id_penjualan);
                            }
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
                        console.log(xhr.responseText);
                        alert('Terjadi kesalahan saat menyimpan transaksi. Silakan coba lagi atau hubungi administrator.');
                    }
                });
            } else {
                alert('Pelanggan dan total tidak boleh kosong');
            }
        }

        initBarangSearch();

        $(document).on('change', '.id_barang', function() {
            getHargaJual(this);
        });

        $(".btn-add").click(function() {
            var row = $(this).closest('.barang-row');
            var id_barang = row.find(".id_barang").val();
            var jumlah = row.find(".jumlah").val();
            var harga_jual = row.find(".setelah_diskon").val();
            var nama_barang = row.find("#barangSearch").val();

            if (id_barang && jumlah && harga_jual) {
                var total = parseInt(jumlah || 0) * parseInt(harga_jual || 0);
                keranjang.push({
                    id_barang: id_barang || null,
                    nama_barang: nama_barang || 'Barang Tidak Terdaftar',
                    jumlah: jumlah || 0,
                    harga_jual: harga_jual || 0,
                    total: total
                });

                selectedItems.add(id_barang);
                updateBarangDropdown();
                updateKeranjangTable();
                hitungTotal();

                // Reset input fields
                row.find("#barangSearch").val('');
                row.find(".id_barang").val('');
                row.find(".jumlah").val('');
                row.find(".setelah_diskon").val('');
            } else {
                alert("Mohon isi semua field");
            }
        });

        $(document).on("click", ".btn-remove", function() {
            var index = $(this).data('index');
            var removedItem = keranjang[index];
            keranjang.splice(index, 1);
            selectedItems.delete(removedItem.id_barang);
            updateBarangDropdown();
            updateKeranjangTable();
            hitungTotal();
        });

        $(document).on("change", ".jumlah-update", function() {
            var index = $(this).data('index');
            var newJumlah = parseInt($(this).val()) || 0;
            keranjang[index].jumlah = newJumlah;
            keranjang[index].total = newJumlah * keranjang[index].harga_jual;
            updateKeranjangTable();
            hitungTotal();
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

            $("#simpanTransaksi").prop("disabled", false);
        });

        $("#batalTransaksi").click(function() {
            if (confirm('Apakah Anda yakin ingin membatalkan transaksi?')) {
                keranjang = [];
                updateKeranjangTable();
                hitungTotal();
                $("#penjualanForm")[0].reset();
            }
        });
    });
</script>


<script>
    function formatDateTime(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');
        
        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }

    function updateDateTime() {
        const now = new Date();
        const dateTimeString = formatDateTime(now);
        document.getElementById('date').value = dateTimeString;
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateDateTime(); // Initial update
        setInterval(updateDateTime, 1000); // Update every second
    });
</script>
