<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Prospek</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Prospek</li>
                        <li class="breadcrumb-item active">Tampil Data</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <?php $this->load->view('template/notifikasi'); ?>
            <div class="row">
                <div class="col-lg-12">
                    <div id="profitChart" style="width: 100%; height: 400px;"></div>
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Prospek</h5>
                            <button id="printButton" class="btn btn-info btn-sm float-right mr-2"><i class="fa fa-print"></i> Cetak Laporan</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-hover table-bordered" style="width:99%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bulan</th>
                                            <th>Modal</th>
                                            <th>Penjualan</th>
                                            <th>Keuntungan Bersih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($prospek as $bulan => $data) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= date('F Y', strtotime($bulan)) ?></td>
                                                <td>Rp <?= number_format($data['modal'], 0, ',', '.') ?></td>
                                                <td>Rp <?= number_format($data['penjualan'], 0, ',', '.') ?></td>
                                                <td>Rp <?= number_format($data['penjualan'] - $data['modal'], 0, ',', '.') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/echarts@5.4.2/dist/echarts.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

<script>
    // Inisialisasi data untuk grafik
    var months = [];
    var profits = [];

    <?php foreach ($prospek as $bulan => $data) : ?>
        months.push('<?= date('M Y', strtotime($bulan)) ?>');
        profits.push(<?= $data['penjualan'] - $data['modal'] ?>);
    <?php endforeach; ?>

    // Mengatur warna berbeda untuk setiap bar
    function getColor(index) {
        var colors = ['#3c8dbc', '#f39c12', '#e74c3c', '#9b59b6', '#1abc9c', '#3498db', '#2ecc71', '#e67e22', '#d35400', '#c0392b'];
        return colors[index % colors.length];
    }

    // Inisialisasi grafik
    var chartDom = document.getElementById('profitChart');
    var myChart = echarts.init(chartDom);
    var option;

    option = {
        title: {
            text: 'Keuntungan Bersih per Bulan'
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            },
            formatter: function(params) {
                return params[0].name + '<br/>' +
                    'Keuntungan: Rp ' + params[0].value.toLocaleString('id-ID');
            }
        },
        xAxis: {
            type: 'category',
            data: months.reverse(),
            axisLabel: {
                rotate: 45,
                interval: 0
            }
        },
        yAxis: {
            type: 'value',
            axisLabel: {
                formatter: function(value) {
                    return 'Rp ' + value.toLocaleString('id-ID');
                }
            }
        },
        series: [{
            name: 'Keuntungan',
            type: 'bar',
            data: profits.reverse(),
            itemStyle: {
                color: function(params) {
                    return getColor(params.dataIndex);
                }
            }
        }]
    };

    option && myChart.setOption(option);

    // Membuat grafik responsif
    window.addEventListener('resize', function() {
        myChart.resize();
    });

    $(document).ready(function() {
        var table = $('#example').DataTable({
            "ordering": false
        });

        function cetakLaporanProspek() {
            // Mengonversi grafik menjadi gambar
            function convertChartToImage() {
                return new Promise((resolve) => {
                    var imgData = myChart.getDataURL({
                        pixelRatio: 2,
                        backgroundColor: '#fff'
                    });
                    resolve(imgData);
                });
            }

            // Fungsi untuk mencetak laporan
            function printReport(chartImage) {
                var filteredData = table.rows().data().toArray();
                var printContents = `
                <div style="text-align: center; font-family: Arial, sans-serif;">
                    <img src="<?= base_url('assets/dist/img/cahayalogo.png') ?>" alt="Logo" style="width: 100px; height: auto;">
                    <h2>LAPORAN PROSPEK PENJUALAN</h2>
                    <h3>TOKO CAHAYA - APP</h3>
                    <p>Jl. Sasaran, Keraton, Kec. Martapura, Kota Martapura, Kalimantan Selatan 70714</p>
                    <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Bulan</th>
                                <th>Modal</th>
                                <th>Penjualan</th>
                                <th>Keuntungan Bersih</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${filteredData.map((row, index) => `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${row[1]}</td>
                                    <td>${row[2]}</td>
                                    <td>${row[3]}</td>
                                    <td>${row[4]}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                    <h3 style="margin-top: 20px;">Grafik Keuntungan Bersih per Bulan</h3>
                    <img src="${chartImage}" alt="Grafik Keuntungan" style="max-width: 100%; height: auto;">
                    <p style="text-align: right; margin-top: 20px;">Martapura, ${new Date().toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})}</p>
                    <p style="text-align: right; margin-top: 80px;">Kepala Toko Cahaya</p>
                </div>
                `;

                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;

                // Reinisialisasi grafik setelah mencetak
                var chartDom = document.getElementById('profitChart');
                var myChart = echarts.init(chartDom);
                myChart.setOption(option);
            }

            // Proses cetak
            convertChartToImage().then(printReport);
        }

        // Event listener untuk tombol cetak
        $('#printButton').on('click', function(e) {
            e.preventDefault();
            cetakLaporanProspek();
        });
    });
</script>
