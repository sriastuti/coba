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

 
    $('#date_picker_awal').datepicker("setDate", "0");
    $('#date_picker_akhir').datepicker("setDate", "0");

  });

     function pilih_poli() {
       var date2=document.getElementById("date_picker_akhir").value;
        var date1=document.getElementById("date_picker_awal").value;
        $.ajax({
            type: "POST",
            url: '<?php echo site_url("dashboard/pulang_ranap_date"); ?>',
            data: {date1:date1, date2:date2 },
            success: function(msg) {

                $('#search_results').html(msg);

            }
        });
    }

   // function pilih_poli() {
   //  var date2=document.getElementById("date_picker_akhir").value;
   //  var date1=document.getElementById("date_picker_awal").value;
   //      objTable = $('#example').DataTable( {
   //          ajax: "<?php echo site_url('dashboard/pulang_ranap_date'); ?>/"+date1+"/"+date2,
   //          columns: [
   //              { data: "no" },
   //              { data: "tglmasukrg" },
   //              { data: "tgl_keluar" },
   //              { data: "nama" },
   //              { data: "no_cm" },
   //              { data: "kelas" },
   //              { data: "nmruang" },
   //              { data: "status" },
   //              { data: "pangkat" },
   //              { data: "nm_diagnosa" }
   //          ],
   //          columnDefs: [
   //              { targets: [ 0 ], visible: true }
   //          ] ,
   //          searching: true,
   //          paging: true,
   //          bDestroy : true,
   //          bSort : false,
   //          "lengthMenu": [[50, 75, 100, -1], [50, 75, 100, "All"]]
   //      } );
   //  }

</script>

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
                  <h4 class="card-title"><br><a href="<?php echo site_url('dashboard/pulang_ranap'); ?>"><b style="color:black"><?=$title?></b></a></h4>
                  <!-- <h6 class="card-subtitle">Total Pasien Hari ini </h6> -->              
                  <div class="ml-auto">
                    <!-- <h4 class="dashboard-heading">Total Pasien : <b id="total_pasien"></b></h4> -->
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
                        <tr style="border: 2px solid black;">
                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>No</b></center></td>
<!--                             <td style="border: 2px solid black; vertical-align: middle;"><center><b>No Register</b></center></td>-->
                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>Tgl Masuk</b></center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>Tgl Keluar</b></center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>Nama</b></center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>No RM</b></center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>Kelas</b></center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>Ruang (Bed)</b></center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>Status</b></center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>Pangkat</b></center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>Diagnosa</b></center></td>
                            <!-- <td style="border: 2px solid black; vertical-align: middle;"><center>Jenis Pasien</center></td> -->
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $i=1;
                        foreach ($pasien as $row) {
                          echo "<tr>
                            <td>".$i++."</td>
                            <td>".$row->tglmasukrg."</td>
                            <td>".$row->tgl_keluar."</td>
                            <td>".$row->nama."</td>
                            <td>".$row->no_cm."</td>
                            <td>".$row->kelas."</td>
                            <td>".$row->nmruang." ( ".substr($row->bed, -3)." )</td>
                            <td>";
                              if($row->tni_al_m=='1')
                                echo "MILITER TNI AL";
                              else if($row->tni_al_s=='1')
                                echo "ASN TNI AL";
                              else if($row->tni_al_k=='1')
                                echo "KELUARGA TNI AL";
                              else if($row->askes_al=='1')
                                echo "PURNAWIRAWAN TNI AL";
                              else if($row->tni_n_al_m=='1')
                                echo "MILITER TNI NON AL";
                              else if($row->tni_n_al_s=='1')
                                echo "ASN TNI NON AL";
                              else if($row->tni_n_al_k=='1')
                                echo "KELUARGA TNI NON AL";
                              else if($row->askes_n_al=='1')
                                echo "PURNAWIRAWAN TNI NON AL";
                              else if($row->pbi=='1' || $row->bpjs_kes=='1' || $row->pol=='1' || $row->pol_k=='1' || $row->kjs=='1')
                                echo "BPJS KESEHATAN NON MILITER";
                              else if($row->bpjs_ket=='1')
                                echo "BPJS KETENAGAKERJAAN";
                              else if($row->kerjasama=='1')
                                echo "KERJASAMA";
                              else if($row->umum=='1' || $row->jam_per=='1' || $row->phl=='1')
                                echo "UMUM";
                              else 
                                echo "UMUM";
                            echo "</td>
                             <td>".$row->pangkat." - ".$row->no_nrp."</td>
                             <td>".$row->diagmasuk." - ".$row->nm_diagnosa."</td>
                          </tr>";
                        }


                      ?>                    
                    </tbody>
                </table>              
              </div>
            </div>
          </div>
      </div>
    </div>

  </div>
  <!-- /.row -->
</section><!-- /.content -->


<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>