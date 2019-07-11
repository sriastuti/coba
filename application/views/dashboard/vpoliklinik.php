<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else if ($role_id == 37){
            $this->load->view("layout/header_dashboard");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?> 

<script src="<?php echo site_url(); ?>assets/plugins/highcharts/highcharts.js"></script>
<script src="<?php echo site_url(); ?>assets/plugins/highcharts/modules/exporting.js"></script>
<style type="text/css">
  tbody > tr > td {  
  border: 2px solid #000;  
}
.table-bordered td, .table-bordered th {
    border: 1px solid #000;  
}
</style>
<!-- Main content -->
<section class="content">
  <!-- <header class="floating-header"> 
    <div class="floating-menu-btn">
      <div class="floating-menu-toggle-wrap">
        <div class="floating-menu-toggle">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </div>
      </div>
    </div>
    <div class="main-navigation-wrap">
      <nav class="main-navigation" data-back-btn-text="Back">
        <ul class="menu">       
          <li class="delay-1"><a href="<?php echo site_url('dashboard'); ?>">Menu Utama</a></li>
          <li class="delay-1"><a href="<?php echo site_url('Change_password'); ?>">Ganti Password</a></li>
          <li class="delay-2"><a href="<?php echo site_url('logout'); ?>">Logout</a></li>      
        </ul>
      </nav>
    </div>
  </header> -->
  <!-- Main row -->
  <div class="row">
    <div class="col-12">
      <div class="card">
          <div class="card-body">
            <div class="col-md-12">
              <div class="d-flex flex-wrap">                
                  <h4 class="card-title"><br><b>Poliklinik</b></h4>
                  <!-- <h6 class="card-subtitle">Total Pasien Hari ini </h6> -->              
                  <div class="ml-auto">
                    <br>
                    <h4 class="dashboard-heading"><b>Total Pasien : </b><b id="total_pasien"></b></h4>
                  </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-inline">
                <div class="form-group">
                  <input style="width: 100px;" type="text" id="date_picker_awal" class="form-control form-control-sm date_picker_awal" placeholder="Tanggal awal" name="date_picker_awal" onchange="cek_tgl_awal(this.value)" required>&nbsp;
                  <input style="width: 100px;" type="text" id="date_picker_akhir" class="form-control form-control-sm date_picker_akhir" placeholder="Tanggal akhir" name="date_picker_akhir" onchange="cek_tgl_akhir(this.value)" required>&nbsp;
                  <button class="btn btn-primary btn-xs" type="submit" onclick="pilih_poli()"><i class="fa fa-search"></i> Cari</button><br><br>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="display nowrap table table-hover table-bordered dataTable" id="example" style="font-size: 14px; border: 2px solid black;" >
                    <thead style="border: 2px solid black; font-weight: bold;">
                        <!-- <tr>
                            <td rowspan="3">#</td>
                            <td rowspan="3">POLIKLINIK</td>
                            <td rowspan="3">TOTAL</td>
                            <td colspan="13">JAMINAN BPJS KESEHATAN</td>
                            <td rowspan="3">NAKER</td>
                            <td rowspan="3">JAMINAN PRSHN</td>
                            <td rowspan="3">KERJASAMA</td>
                            <td rowspan="3">UMUM</td>
                        </tr>
                        <tr>
                            <td colspan="3">TNI AL</td>
                            <td colspan="3">TNI NON AL</td>
                            <td colspan="2">ASKES</td>
                            <td colspan="2">POLRI</td>
                            <td rowspan="2">KJS</td>
                            <td rowspan="2">PBI</td>
                            <td rowspan="2">MANDIRI</td>
                        </tr>
                        <tr>
                            <td>M</td>
                            <td>S</td>
                            <td>K</td>
                            <td>M</td>
                            <td>S</td>
                            <td>K</td>
                            <td>AL</td>
                            <td>NON AL</td>
                            <td>TK</td>
                            <td>K</td>
                        </tr> -->
                        <tr style="border: 2px solid black;">
                            <td rowspan="3" style="border: 2px solid black; vertical-align: middle;"><center>#</center></td>
                            <td rowspan="3" style="border: 2px solid black; vertical-align: middle;"><center>POLIKLINIK</center></td>
                            <td colspan="9" style="border: 2px solid black; vertical-align: middle;"><center>BPJS KESEHATAN</td</center></td>
                            <td rowspan="3" style="border: 2px solid black; vertical-align: middle;"><center>BPJS KT</center></td>
                            <td rowspan="2" colspan="2" style="border: 2px solid black; vertical-align: middle;"><center>PC</center></td>
                            <td rowspan="3" style="border: 2px solid black; vertical-align: middle;"><center>TOTAL</center></td>

                        </tr>
                        <tr style="border: 2px solid black;">
                            <td colspan="4" style="border: 2px solid black; vertical-align: middle;"><center>TNI AL</center></td>
                            <td colspan="4" style="border: 2px solid black; vertical-align: middle;"><center>TNI NON AL</center></td>
                            <td rowspan="2" style="border: 2px solid black; vertical-align: middle;"><center>NON MILITER</center></td>
                        </tr>
                        <tr style="border: 2px solid black;">
                            <td style="border: 2px solid black; vertical-align: middle;"><center>MIL</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>ASN</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>KEL</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>PURN</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>MIL</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>ASN</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>KEL</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>PURN</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>KERJASAMA</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>UMUM</center></td>
                        </tr>
                    </thead>
                </table>              
              </div>
            </div>
          </div>
      </div>
    </div>


    <div class="col-md-12">
      <!-- AREA CHART -->
      <div class="card card-outline-primary">
        <!-- <div class="card-header">
        </div> -->
        <div class="card-body chart-responsive">
          <!-- <p class="col-sm-2"><b>Pencarian Data</b></p> -->
          <!-- <div class='chart' id='kun-poli' style='height: 450px;width: 100%;'></div> -->
          <div class="chart" id="container" style="height: 450px;width: 100%;"></div>
          <div class="overlay" id="overlay">
            <i class="fa fa-refresh fa-spin"></i>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
  <!-- /.row -->
</section><!-- /.content -->

<script type='text/javascript'>
  var site = "<?php echo site_url();?>";
  $(document).ready(function() {

    $('#date_picker_awal').datepicker({
        format: "yyyy-mm-dd",
        endDate: "current",
        autoclose: true,
        todayHighlight: true,
    }); 
    $('#date_picker_akhir').datepicker({
        format: "yyyy-mm-dd",
        endDate: "current",
        autoclose: true,
        todayHighlight: true,
    }); 

    document.getElementById("date_picker_awal").required = true;
    document.getElementById("date_picker_akhir").required = true;
    //date
    var d = new Date();
    var currDate = d.getDate();
    var currMonth = d.getMonth()+1;
    var currYear = d.getFullYear();

    // var firstMonth = currYear + "-" + currMonth + "-" + 01;

    // $('#date_picker_awal').datepicker("setDate", firstMonth);
    $('#date_picker_awal').datepicker("setDate", "0");
    $('#date_picker_akhir').datepicker("setDate", "0");

    $('#overlay').hide();
    $('#kun-poli').hide();
      // Radialize the colors
      Highcharts.setOptions({
          colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
              return {
                  radialGradient: {
                      cx: 0.5,
                      cy: 0.3,
                      r: 0.7
                  },
                  stops: [
                      [0, color],
                      [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                  ]
              };
          })
      });
    pilih_poli();
  });

  $(function() {
    
  });
  var intervalSetting = function () {
    var tgl_akhir=document.getElementById("date_picker_akhir").value;
    var tgl_awal=document.getElementById("date_picker_awal").value;
    // if (tgl_akhir!='' && tgl_awal!=''){
    //   pilih_poli();
    // }
    objTable.ajax.reload();
    get_total();
  };
  // setInterval(intervalSetting, 3000);

  function cek_tgl_awal(tgl_awal){
    var tgl_akhir=document.getElementById("date_picker_akhir").value;
    if(tgl_akhir==''){
    //none :D just none
    }else if(tgl_akhir<tgl_awal){
      document.getElementById("date_picker_akhir").value = '';
    }
  }
  function cek_tgl_akhir(tgl_akhir){
    var tgl_awal=document.getElementById("date_picker_awal").value;
    if(tgl_akhir<tgl_awal){
      document.getElementById("date_picker_awal").value = '';
    }
  }
      
  function pilih_poli() {
    var tgl_akhir=document.getElementById("date_picker_akhir").value;
    var tgl_awal=document.getElementById("date_picker_awal").value;
    if(tgl_awal!="" && tgl_akhir!=""){
      $('#kun-poli').html("");
      $('#kun-poli').show();
      $('#overlay').show();
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('Dashboard/get_data_kunjungan')?>",
        data: {
          tgl_akhir : tgl_akhir,
          tgl_awal : tgl_awal
        },
        success: function(data){
          if(data ==""){
            alert("Data Kosong");
            $('#overlay').hide();
            $('#kun-poli').hide();
          } else {

            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Total Pasien'
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> Orang<br/>'
                },

                series: [{
                    name: 'Poliklinik',
                    colorByPoint: true,
                    data: data
                }]
            });


            $('#overlay').hide();
          }
        },
        error: function(){
          alert("error");
        }
      });

      objTable = $('#example').DataTable( {
        ajax: "<?php echo site_url('dashboard/kunj_poli'); ?>/"+tgl_awal+"/"+tgl_akhir,
        columns: [
          { data: "rank" },
          { data: "nm_poli" },
          { data: "tni_al_m" },
          { data: "tni_al_s" },
          { data: "tni_al_k" },
          { data: "askes_al" },
          { data: "tni_n_al_m" },
          { data: "tni_n_al_s" },
          { data: "tni_n_al_k" },
          { data: "askes_n_al" },
          { data: "bpjs_n_mil" },
          { data: "bpjs_ket" },
          { data: "kerjasama" },
          { data: "umum" },
          { data: "total" }
          // { data: "askes" },
          // { data: "pol" },
          // { data: "pol_k" },
          // { data: "bpjs_kes" },
          // { data: "kjs" },
          // { data: "pbi" },
          // { data: "bpjs_ket" },
        ],
        columnDefs: [
          { targets: [ 0 ], visible: true }
        ] ,
        searching: false, 
        paging: false,
        bDestroy : true,
        bSort : false
      } );

      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('Dashboard/get_total_kunjungan_poli_range')?>/"+tgl_awal+"/"+tgl_akhir,
        success: function(data){
            document.getElementById("total_pasien").innerHTML = data.total_pasien;
        },
        error: function(){
          alert("error");
        }
      });
    }else{
      alert("Pilih Tanggal Dulu");
    }
    
  }
      
  function get_total() {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('Dashboard/get_total_kunjungan_poli')?>",
      success: function(data){
          document.getElementById("total_pasien").innerHTML = data.total_pasien;
      },
      error: function(){
        alert("error");
      }
    });
  }
</script>

<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>