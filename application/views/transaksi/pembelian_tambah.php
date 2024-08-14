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
                    <h1 class="m-0">Pembelian</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Pembelian</li>
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
                                <h5 class="card-title">Tambah Data Pembelian</h5>
                            </div>
                            <div class="card-body">
                                <form id="pembelianForm" method="POST" action="<?php echo base_url('pembelian/save'); ?>" enctype="multipart/form-data">
                                    <!-- Hidden inputs for action -->
                                    <input type="hidden" id="formAction" name="formAction" value="save">
                                    <div class="form-group">
                                        <label for="id_suplier">Suplier</label>
                                        <select name="id_suplier" id="id_suplier" class="form-control" required="required">
                                            <option value="">Pilih Suplier</option>
                                            <?php foreach ($suplier as $o) : ?>
                                                <option value="<?php echo $o->id_suplier ?>"><?php echo $o->nama_suplier ?></option>
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
                                                    <label for="hrg">Harga Beli</label>
                                                    <input type="text" name="harga_beli[]" class="form-control hrg" readonly>
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
                                                    <th>Harga Beli</th>
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
                                                <label for="total">Total</label>
                                                <input type="text" id="total" name="total" class="form-control" required readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="bukti">Bukti Dukung</label>
                                            <input type="file" name="bukti" id="bukti" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" id="simpanPembelian" class="btn btn-success btn-sm">
                                            <i class="fa fa-save"></i> Simpan Pembelian
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
   $(document).ready(function() {
    // Variables
    var keranjang = [];
    var selectedItems = new Set();

    // Initialization
    initBarangSearch();

    // Event Listeners
    $(document).on('input', '.jumlah', function() {
        calculateRowTotal($(this).closest('.barang-row'));
    });

    $(".btn-add").click(handleAddItem);

    $(document).on("click", ".btn-remove", handleRemoveItem);

    $(document).on("change", ".jumlah-update", handleQuantityUpdate);

    $("#simpanPembelian").click(saveTransaction);

    $("#batalTransaksi").click(handleCancelTransaction);

    // Functions
    function initBarangSearch() {
        var barangSearch = document.getElementById('barangSearch');
        var dropdownSearch = document.getElementById('dropdownSearch');
        var barangOptions = document.getElementById('barangOptions');
        var idBarangInput = document.querySelector('.id_barang');
        var hargaBeliInput = document.querySelector('.hrg');

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

                getHargaBeli(selectedValue);
            }
        });

        document.addEventListener('click', function(e) {
            if (!barangSearch.contains(e.target) && !barangSearch.nextElementSibling.contains(e.target)) {
                barangSearch.nextElementSibling.classList.remove('show');
            }
        });
    }

    function calculateRowTotal(row) {
        var jumlah = parseInt(row.find('.jumlah').val()) || 0;
        var harga_beli = parseInt(row.find('.hrg').val()) || 0;
        var total = jumlah * harga_beli;
        row.find('.total').val(total);
    }

    function getHargaBeli(idBarang) {
        if (idBarang) {
            $.ajax({
                url: '<?= base_url('pembelian/fungsi_pengambilan_data'); ?>',
                method: 'post',
                data: { id_barang: idBarang },
                dataType: 'json',
                success: function(data) {
                    if (data && data.hrg) {
                        $('.hrg').val(data.hrg);
                        calculateRowTotal($('.barang-row'));
                    } else {
                        alert("Data tidak ditemukan untuk barang tersebut");
                    }
                },
                error: function() {
                    alert("Gagal mengambil data harga beli");
                }
            });
        } else {
            $('.hrg').val('');
        }
    }

    function handleAddItem() {
        var row = $(this).closest('.barang-row');
        var id_barang = row.find(".id_barang").val();
        var jumlah = parseInt(row.find(".jumlah").val());
        var harga_beli = parseInt(row.find(".hrg").val());
        var nama_barang = row.find("#barangSearch").val();

        if (id_barang && jumlah && harga_beli && nama_barang) {
            var isItemInCart = keranjang.some(item => item.id_barang === id_barang);

            if (!isItemInCart) {
                var total = jumlah * harga_beli;
                keranjang.push({
                    id_barang: id_barang,
                    nama_barang: nama_barang,
                    jumlah: jumlah,
                    harga_beli: harga_beli,
                    total: total
                });

                updateKeranjangTable();
                hitungTotal();

                // Reset input fields only for this row
                row.find("#barangSearch").val('');
                row.find(".id_barang").val('');
                row.find(".jumlah").val('');
                row.find(".hrg").val('');
            } else {
                alert("Barang ini sudah ada dalam keranjang");
            }
        } else {
            alert("Mohon isi semua field");
        }
    }

    function updateKeranjangTable() {
        var html = '';
        keranjang.forEach(function(item, index) {
            html += '<tr>';
            html += '<td>' + (index + 1) + '</td>';
            html += '<td>' + (item.nama_barang || 'Barang Tidak Terdaftar') + '</td>';
            html += '<td><input type="number" class="form-control jumlah-update" value="' + (item.jumlah || 0) + '" data-index="' + index + '"></td>';
            html += '<td>' + (item.harga_beli || 0) + '</td>';
            html += '<td class="total">' + item.total + '</td>';
            html += '<td><button type="button" class="btn btn-danger btn-sm btn-remove" data-index="' + index + '">Hapus</button></td>';
            html += '</tr>';
        });
        $("#keranjangTable tbody").html(html);
    }

    function hitungTotal() {
        var subtotal = keranjang.reduce((sum, item) => sum + item.total, 0);
        $("#subtotal").val(subtotal);
        $("#total").val(subtotal.toFixed(0));
    }

    function saveTransaction() {
        var id_suplier = $("#id_suplier").val();
        var total = $("#total").val();
        var id_barang = [];
        var jumlah = [];
        var harga_beli = [];

        keranjang.forEach(function(item) {
            if (item.id_barang !== null) {
                id_barang.push(item.id_barang);
                jumlah.push(item.jumlah);
                harga_beli.push(item.harga_beli);
            }
        });

        if (id_suplier && total) {
            var formData = new FormData();
            formData.append('id_suplier', id_suplier);
            formData.append('total', total);
            formData.append('id_barang', JSON.stringify(id_barang));
            formData.append('jumlah', JSON.stringify(jumlah));
            formData.append('harga_beli', JSON.stringify(harga_beli));

            var fileInput = $('#bukti')[0].files[0];
            if (fileInput) {
                formData.append('bukti', fileInput);
            } else {
                alert('No file selected for upload');
                return;
            }

            $.ajax({
                url: '<?= base_url('pembelian/save'); ?>',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        alert(response.message);
                        keranjang = [];
                        updateKeranjangTable();
                        hitungTotal();
                        $("#pembelianForm")[0].reset();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    alert('Terjadi kesalahan saat menyimpan transaksi. Silakan coba lagi atau hubungi administrator.');
                }
            });
        } else {
            alert('Suplier dan total tidak boleh kosong');
        }
    }

    function handleRemoveItem() {
        var index = $(this).data('index');
        var removedItem = keranjang[index];
        keranjang.splice(index, 1);
        selectedItems.delete(removedItem.id_barang);
        updateBarangDropdown();
        updateKeranjangTable();
        hitungTotal();
    }

    function handleQuantityUpdate() {
        var index = $(this).data('index');
        var newJumlah = parseInt($(this).val()) || 0;
        keranjang[index].jumlah = newJumlah;
        keranjang[index].total = newJumlah * keranjang[index].harga_beli;
        updateKeranjangTable();
        hitungTotal();
    }

    function handleCancelTransaction() {
        if (confirm('Apakah Anda yakin ingin membatalkan transaksi?')) {
            keranjang = [];
            updateKeranjangTable();
            hitungTotal();
            $("#pembelianForm")[0].reset();
        }
    }

    function updateBarangDropdown() {
        // Implementation needed
    }
});
</script>