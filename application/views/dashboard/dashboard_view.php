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
            <li class="breadcrumb-item active">Dashboard v1</li>
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

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Grafik Penjualan dan Pembelian</h3>
              </div>
              <div class="card-body">
                <div id="barChart" style="height: 400px; width:500px;"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- <div class="row mt-6">
          <div class="col-12 col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Penjualan Terlaris per Bulan</h3>
              </div>
              <div class="card-body">
                <div id="doughnutChart" style="height: 400px; width:500px;"></div>
              </div>
            </div>
          </div>
        </div> -->

      </div>
    </div>
  </section>
</div>


<style>
  .info-box {
    border-radius: 4px;
    box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
    display: flex;
    flex-direction: column;
    margin-bottom: 1rem;
    min-height: 100px;
    padding: 15px;
    position: relative;
  }

  .info-box-icon {
    align-items: center;
    display: flex;
    font-size: 2.5rem;
    justify-content: center;
    text-align: center;
    width: 70px;
  }

  .info-box-content {
    flex: 1;
    padding: 5px 10px;
  }

  .info-box-number {
    display: block;
    font-size: 2.5rem;
    font-weight: 700;
  }

  .info-box-text {
    display: block;
    font-size: 1rem;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .info-box-footer {
    background-color: rgba(0, 0, 0, .1);
    color: rgba(255, 255, 255, .8);
    display: block;
    padding: 3px 0;
    position: relative;
    text-align: center;
    text-decoration: none;
    z-index: 10;
  }

  .info-box-footer:hover {
    background-color: rgba(0, 0, 0, .15);
    color: #fff;
  }

  .bg-info {
    background-color: #17a2b8 !important;
  }

  .bg-success {
    background-color: #28a745 !important;
  }

  .bg-warning {
    background-color: #ffc107 !important;
  }

  .bg-danger {
    background-color: #dc3545 !important;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/echarts@5.4.2/dist/echarts.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var chartDom = document.getElementById('barChart');
    var myChart = echarts.init(chartDom);
    var option;

    option = {
      title: {
        text: 'Perbandingan Jumlah Penjualan dan Pembelian',
        left: 'center'
      },
      tooltip: {
        trigger: 'axis',
        axisPointer: {
          type: 'shadow'
        }
      },
      grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
      },
      xAxis: [{
        type: 'category',
        data: ['Penjualan', 'Pembelian'],
        axisTick: {
          alignWithLabel: true
        }
      }],
      yAxis: [{
        type: 'value',
        name: 'Jumlah',
        nameLocation: 'middle',
        nameGap: 50
      }],
      series: [{
        name: 'Jumlah Transaksi',
        type: 'bar',
        barWidth: '60%',
        data: [{
            value: <?php echo $jumlah_penjualan; ?>,
            itemStyle: {
              color: '#5470C6'
            }
          },
          {
            value: <?php echo $jumlah_pembelian; ?>,
            itemStyle: {
              color: '#91CC75'
            }
          }
        ]
      }]
    };

    option && myChart.setOption(option);

    // Make chart responsive
    window.addEventListener('resize', function() {
      myChart.resize();
    });
  });



  document.addEventListener('DOMContentLoaded', function() {
    // Existing bar chart code...

    // Doughnut chart
    var doughnutChartDom = document.getElementById('doughnutChart');
    var doughnutChart = echarts.init(doughnutChartDom);
    var doughnutOption = {
      tooltip: {
        trigger: 'item'
      },
      legend: {
        orient: 'vertical',
        left: 'left'
      },
      series: [{
        name: 'Penjualan Terlaris',
        type: 'pie',
        radius: ['40%', '70%'],
        avoidLabelOverlap: false,
        itemStyle: {
          borderRadius: 10,
          borderColor: '#fff',
          borderWidth: 2
        },
        label: {
          show: false,
          position: 'center'
        },
        emphasis: {
          label: {
            show: true,
            fontSize: '20',
            fontWeight: 'bold'
          }
        },
        labelLine: {
          show: false
        },
        data: <?php echo json_encode(array_map(function ($item) {
                return ['value' => $item['total_terjual'], 'name' => $item['month']];
              }, $monthly_data)); ?>
      }]
    };
    doughnutChart.setOption(doughnutOption);

    // Make charts responsive
    window.addEventListener('resize', function() {
      barChart.resize();
      doughnutChart.resize();
    });
  });
</script>