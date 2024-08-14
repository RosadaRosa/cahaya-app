<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
  <div class="container-fluid">
    <!-- Info boxes -->
    <div class="row">
      <div class="col-md-6 chart-container">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Grafik Penjualan dan Pembelian</h3>
          </div>
          <div class="card-body">
            <div id="barChart" style="height: 500px;"></div>
          </div>
        </div>
      </div>

      <div class="col-md-6 chart-container">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Grafik Barang Terjual</h5>
          </div>
          <div class="card-body">
            <div id="main" style="height: 500px;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</div>



<style>
  .content-wrapper {
    padding: 20px;
  }

  .card {
    margin-bottom: 20px;
  }

  .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e3e6f0;
    padding: 10px 15px;
  }

  .card-body {
    padding: 15px;
  }

  .chart-container {
    margin: 20px 0;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  #barChart, #main {
    width: 100%;
    height: 400px; /* Adjust height as needed */
  }

  .col-lg-6 {
    margin-bottom: 20px;
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/echarts@5.4.2/dist/echarts.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Data for the bar chart
    const penjualanData = <?php echo $jumlah_penjualan; ?>;
    const pembelianData = <?php echo $jumlah_pembelian; ?>;

    var barChartDom = document.getElementById('barChart');
    var barChart = echarts.init(barChartDom);

    var barOption = {
      title: {
        text: 'Perbandingan Jumlah Penjualan dan Pembelian',
        left: 'center'
      },
      tooltip: {
        trigger: 'axis',
        axisPointer: { type: 'shadow' }
      },
      grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
      },
      xAxis: {
        type: 'category',
        data: ['Penjualan', 'Pembelian'],
        axisTick: { alignWithLabel: true }
      },
      yAxis: {
        type: 'value',
        name: 'Jumlah',
        nameLocation: 'middle',
        nameGap: 50
      },
      series: [{
        name: 'Jumlah Transaksi',
        type: 'bar',
        barWidth: '60%',
        data: [penjualanData, pembelianData],
        itemStyle: {
          color: function(params) {
            // Color based on the item index
            return params.dataIndex === 0 ? '#5470C6' : '#91CC75';
          }
        }
      }]
    };

    barChart.setOption(barOption);

    // Make chart responsive
    window.addEventListener('resize', function() {
      barChart.resize();
    });
  });
</script>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>

    <script>
  document.addEventListener('DOMContentLoaded', function() {
    const terlarisData = <?php echo json_encode($terlaris); ?>;
    const labels = terlarisData.map(data => `${data.merk} - ${data.bahan} - ${data.ukuran}`);
    const dataValues = terlarisData.map(data => data.total_terjual);

    var mainChartDom = document.getElementById('main');
    var mainChart = echarts.init(mainChartDom);

    var mainOption = {
      title: {
        text: 'Grafik Barang',
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
          rotate: 45,
          interval: 0
        }
      },
      yAxis: {
        type: 'value',
        name: 'Jumlah Terjual'
      },
      series: [{
        name: 'Total Terjual',
        type: 'bar',
        data: dataValues,
        itemStyle: {
          color: function(params) {
            const colors = ['#6F9EC0', '#9FC5E8', '#B4D9D4', '#E3E0C9', '#F2B5D4'];
            return colors[params.dataIndex % colors.length];
          }
        }
      }]
    };

    mainChart.setOption(mainOption);

    // Make chart responsive
    window.addEventListener('resize', function() {
      mainChart.resize();
    });
  });
</script>

