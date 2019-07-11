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
              <!-- <div class="d-flex flex-wrap">                 -->
                  <h4 class="card-title">
                    <br>
                    <a href="<?php echo site_url('dashboard/poliklinik'); ?>"><b style="color:black"><?=$title?></b></a></h4>
                  <h5>Tanggal <?=$tanggal?></h5>
                  <!-- <h6 class="card-subtitle">Total Pasien Hari ini </h6> -->              
                  <!-- <div class="ml-auto"> -->
                    <!-- <h4 class="dashboard-heading">Total Pasien : <b id="total_pasien"></b></h4> -->
                  <!-- </div> -->
              <!-- </div> -->
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="display nowrap table table-hover table-bordered dataTable" id="example" style="font-size: 14px; border: 2px solid black;" >
                    <thead style="border: 2px solid black; font-weight: bold;">
                        <tr style="border: 2px solid black;">
                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>No</b></center></td>
<!--                             <td style="border: 2px solid black; vertical-align: middle;"><center><b>No Register</b></center></td>
 -->                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>Tgl Daftar</b></center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>Nama</b></center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>No RM</b></center></td>
                           <!--  <td style="border: 2px solid black; vertical-align: middle;"><center><b>Umur</b></center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>Sex</b></center></td> -->
                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>Status</b></center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>Pangkat</b></center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>Ket Pulang</b></center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>Diagnosa Utama</b></center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center><b>Aksi</b></center></td>
                            <!-- <td style="border: 2px solid black; vertical-align: middle;"><center>Jenis Pasien</center></td> -->
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $i=1;
                        foreach ($pasien as $row) {
                          echo "<tr>
                            <td>".$i++."</td>
                            <td>".date('d/m/y',strtotime($row->tgl_kunjungan))."</td>
                            <td>".$row->nama." , ".$row->age.", ";
                            if($row->L=='1')
                              echo "L";
                            else
                              echo "P";
                            echo "</td>
                            <td>".$row->no_cm."</td>
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
                            <td>".$row->pangkat."/".$row->no_nrp."</td>
                            <td>".$row->ket_pulang."</td>
                            <td>".$row->diagnosa."</td>
                            <td>
                            <a href='".site_url("dashboard/data_medrec_pasien/".$row->no_medrec)."'class='btn btn-danger btn-xs' style='width:50px;' target='_blank'>Cek<br>Rekam<br>Medis</a>
                            </td>
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
</section><!-- /.content 

                             <td>".($row->tni_al_m=='1' || $row->tni_al_k=='1' ?
                              $row->pangkat."/".$row->no_nrp:" ")." </td>
-->

<script>
  $(document).ready(function() {
    var dataTable = $('#example').DataTable( {
      "ordering": false,
      "bInfo": false,
      "bPaginate": false
    });
  });
</script>

<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>