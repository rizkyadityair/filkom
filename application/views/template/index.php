<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Dashboard</h1>
      <h5 style="padding-left:1px;">Selamat datang <?= ucfirst($this->session->userdata('name'));?></h5>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="panel">
            <div class="panel-header">
              <!-- <h1>Selamat Datang</h1> -->
            </div>
            <div class="panel-body">
              <p>Website ini merupakan suatu perangkat lunak dengan platform website yang berisi pengarsipan dan monitoring kerjasama pada Fakultas Ilmu Komputer Universitas Brawijaya.</p>
            </div>
          </div>
        </div>
      </div>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                  <div id="container"></div>
                </div>
                <div class="col-md-6">
                  <div id="containerperusahaan"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
  <?php
    $jumlah = array();
    foreach ($bidang as $valbidang) {
      $kerjasama = $this->mymodel->selectWhere('kerja_sama',['status'=>'ENABLE','ks_bidang_id'=>$valbidang['mbk_id']]);
      $jumlah[$valbidang['mbk_id']] = count($kerjasama);
    }
    $mitra = $this->mymodel->selectWhere('m_mitra',['status'=>'ENABLE']);
  ?>
  Highcharts.chart('container', {
      chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
      },
      title: {
          text: 'Bidang Kerjasama'
      },
      tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      accessibility: {
          point: {
              valueSuffix: '%'
          }
      },
      plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: true,
                  format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                  distance: -50,
                  filter: {
                      property: 'percentage',
                      operator: '>',
                      value: 4
                  }
              },
              showInLegend: true
          }
      },
      series: [{
          name: 'Total Data',
          colorByPoint: true,
          data: [
            <?php foreach ($bidang as $valbidang) {?>
              {
                name: "<?= $valbidang['mbk_name']?>",
                y: <?= $jumlah[$valbidang['mbk_id']]?>
              },
            <?php }?>
          ]
      }]
  });
  Highcharts.chart('containerperusahaan', {
      chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
      },
      title: {
          text: 'Bidang Kerjasama'
      },
      tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      accessibility: {
          point: {
              valueSuffix: '%'
          }
      },
      plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: true,
                  format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                  distance: -50,
                  filter: {
                      property: 'percentage',
                      operator: '>',
                      value: 4
                  }
              },
              showInLegend: true
          }
      },
      series: [{
          name: 'Total Data',
          colorByPoint: true,
          data: [
            <?php 
              foreach ($mitra as $valmitra) {
                $kerjsamamitra = $this->mymodel->selectWhere('kerja_sama',['ks_mitra_id'=>$valmitra['m_id']]);
            ?>
              {
                name: "<?= $valmitra['m_name']?>",
                y: <?= count($kerjsamamitra); ?>
              },
            <?php }?>
          ]
      }]
  });
  </script>