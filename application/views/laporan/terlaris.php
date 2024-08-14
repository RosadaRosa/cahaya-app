<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Terlaris</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        .card-body {
            height: 300px;
        }
    </style>
</head>

<body>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Barang Terlaris</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Barang Terlaris</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="card-title">Data Barang Terlaris (Harga > Rp 100.000 min. 20 terjual, Harga <= Rp 100.000 min. 30 terjual)</h5>
                                        <button onclick="printTerlarisReport()" class="btn btn-info btn-sm float-right ml-2"><i class="fa fa-print"></i> Cetak Laporan</button>
                                        <form action="<?= base_url('terlaris'); ?>" method="get" class="float-right">
                                            <select name="month" class="form-control-sm">
                                                <option value="">Semua Bulan</option>
                                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                    <option value="<?= $i; ?>" <?= ($selected_month == $i) ? 'selected' : ''; ?>><?= date('F', mktime(0, 0, 0, $i, 1)); ?></option>
                                                <?php endfor; ?>
                                            </select>
                                            <select name="year" class="form-control-sm">
                                                <option value="">Semua Tahun</option>
                                                <?php
                                                $currentYear = date('Y');
                                                for ($i = $currentYear; $i >= $currentYear - 5; $i--) :
                                                ?>
                                                    <option value="<?= $i; ?>" <?= ($selected_year == $i) ? 'selected' : ''; ?>><?= $i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                                        </form>
                            </div>
                            <div class="card-body">
                                <table id="example" class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori</th>
                                            <th>Barang</th>
                                            <th>Total Terjual</th>
                                            <th>Harga Jual Rata-rata</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($terlaris as $row) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row->nama_kategori; ?></td>
                                                <td><?= $row->merk; ?> - <?= $row->bahan; ?> - <?= $row->ukuran; ?></td>
                                                <td><?= $row->total_terjual; ?></td>
                                                <td>Rp <?= number_format($row->harga_jual, 0, ',', '.'); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Penjualan Terlaris per Bulan</h5>
                            </div>
                            <div class="card-body">
                                <div class="col">
                                <canvas id="main" width="500" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>

    <script>
        function printTerlarisReport() {
            var printContents = `
    <div style="text-align: center; font-family: Arial, sans-serif;">
        <h2>LAPORAN BARANG TERLARIS</h2>
        <h3>TOKO CAHAYA - APP</h3>
        <p>Jl. Sasaran, Keraton, Kec. Martapura, Kota Martapura, Kalimantan Selatan 70714</p>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Barang</th>
                    <th>Total Terjual</th>
                    <th>Harga Jual Rata-rata</th>
                </tr>
            </thead>
            <tbody>
                ${Array.from(document.querySelectorAll('#example tbody tr')).map((row, index) => `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${row.cells[1].innerText}</td>
                        <td>${row.cells[2].innerText}</td>
                        <td>${row.cells[3].innerText}</td>
                        <td>${row.cells[4].innerText}</td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
        <p style="text-align: right; margin-top: 20px;">Martapura, ${new Date().toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})}</p>
        <p style="text-align: right; margin-top: 80px;">Kepala Toko Cahaya</p>
    </div>
    `;

    var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

    // Data for the bar chart
    const terlarisData = <?php echo json_encode($terlaris); ?>;
    const labels = terlarisData.map(data => `${data.merk} - ${data.bahan} - ${data.ukuran}`);
    const dataValues = terlarisData.map(data => data.total_terjual);

    // Generate a list of colors
    const colors = ['#6F9EC0', '#9FC5E8', '#B4D9D4', '#E3E0C9', '#F2B5D4', '#EAD1DC', '#D0E0F0', '#D9EAD3', '#CFE2F3', '#F6D3D3'];

    // Initialize ECharts
    var chart = echarts.init(document.getElementById('main'));

    // Option for the bar chart
    var option = {
        title: {
            text: 'Grafik Barang Terlaris',
            left: 'center'
        },
        tooltip: {
            trigger: 'axis',
            formatter: function(params) {
                const item = params[0];
                return `${item.name}<br>Jumlah Terjual: ${item.value}`;
            }
        },
        xAxis: {
            type: 'category',
            data: labels,
            axisLabel: {
                rotate: 45, // Rotate labels to fit longer text
                interval: 0 // Show all labels
            }
        },
        yAxis: {
            type: 'value',
            name: 'Jumlah Terjual'
        },
        series: [
            {
                name: 'Total Terjual',
                type: 'bar',
                data: dataValues,
                emphasis: {
                    focus: 'series'
                },
                itemStyle: {
                    color: function(params) {
                        // Use color from the list based on the index of the item
                        return colors[params.dataIndex % colors.length];
                    }
                }
            }
        ]
    };

    // Use the specified configuration and data to show the chart.
    chart.setOption(option);
    </script>

</body>

</html>
