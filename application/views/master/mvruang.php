<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
  $(document).ready(function() {
    $('#table-ruangan').DataTable({
      "columnDefs": [
        { "orderable": false, "targets": 5 }
      ]
    });
    $('#table-bed').DataTable({
      "columnDefs": [
        { "orderable": false, "targets": 7 }
      ]
    });
  } );
  //---------------------------------------------------------

  $(function() {
    $('#date_picker').datepicker({
      format: "yyyy-mm-dd",
      endDate: '0',
      autoclose: true,
      todayHighlight: true,
    });  
  }); 

  function edit_ruang(idrg) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcruang/get_data_edit_ruang')?>",
      data: {
        idrg: idrg
      },
      success: function(data){
        $('#edit_idrg').val(data[0].idrg);
        $('#edit_idrg_hidden').val(data[0].idrg);
        $('#edit_lokasiruang').val(data[0].lokasi);
        $('#edit_nmruang').val(data[0].nmruang);
        $('#edit_aktif').val(data[0].aktif);
        $('#edit_vvip').val(data[0].VVIP);
        $('#edit_vip').val(data[0].VIP);
        $('#edit_utama').val(data[0].UTAMA);
        $('#edit_i').val(data[0].I);
        $('#edit_ii').val(data[0].II);
        $('#edit_iii').val(data[0].III);
      },
      error: function(){
        alert("error");
      }
    });
  }

  function edit_bed(bed) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcruang/get_data_edit_bed')?>",
      data: {
        bed: bed
      },
      success: function(data){        
        $('#edit_bed_hidden').val(data[0].bed);
        $('#edit_idrg_bed').val(data[0].idrg);
        $('#edit_idrg_hidden_bed').val(data[0].idrg);
        $('#edit_no_bed').val(data[0].no_bed);
        $('#edit_no_bed_hidden').val(data[0].no_bed);
        $('#edit_nmruang_bed').val(data[0].nmruang);
        $('#edit_kelas').val(data[0].kelas);
        $('#edit_isi').val(data[0].isi);
        $('#edit_status').val(data[0].status);
        if(parseInt(data[0].aktif)>0){
          document.getElementById("btn-editbed").disabled=true;
        }else{
          document.getElementById("btn-editbed").disabled=false;
        }
      },
      error: function(){
        alert("error");
      }
    });
  }

  function get_banyak_bed(kelas) {
    var idrg=document.getElementById("idrg").value;
    if(idrg==''){
      alert('Mohon Pilih Ruangan');
    } else {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/mcruang/get_banyak_bed')?>",
        data: {
          idrg: idrg,
          kelas:  kelas
        },
        success: function(data){
          if(data==''){
            $('#no_bed').val('0');
            $('#no_bed_hidden').val('0');
          } else {
            $('#no_bed').val(data[0].banyak);
            $('#no_bed_hidden').val(data[0].banyak);
          }
         
        },
        error: function(){
          alert("error");
        }
      });
    }
  }

  function hapus_bed(bed){
    if (confirm('Yakin Menghapus Bed?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/mcruang/hapus_bed')?>",
        data: {
          bed: bed
        },
        success: function(data){
          location.reload();
        },
        error: function(){
          location.reload();
        }
      });
    } 
  }


</script>
<section class="content-header">
  <?php
    echo $this->session->flashdata('success_msg');
  ?>
</section>

<section class="content">
  <div class="row" id="row">
    <div class="col-sm-12">
      <div class="card card-outline-primary">
        <div class="card-header">
          <h4 class="text-white">DAFTAR RUANGAN</h4>
        </div>
        <div class="card-block">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myRuang" title="Tambah Ruangan"><i class="fa fa-plus"></i> Ruangan Baru</button>       
          <div class="p-20">
            <table id="table-ruangan" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th>ID Ruang</th>
                  <th>Nama Ruang</th>
                  <th>Lokasi</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    $i=1;
                    foreach($ruang as $row){
                ?>
                <tr>
                  <td class="text-center"><?php echo $i++;?></td>
                  <td><?php echo $row->idrg;?></td>
                  <td><?php echo $row->nmruang;?></td>
                  <td><?php echo $row->lokasi;?></td>
                  <td class="text-center"><?php echo $row->aktif;?></td>
                  <td class="text-center">                             
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" title="Edit Ruangan" data-target="#editModalRuang" onclick="edit_ruang('<?php echo $row->idrg;?>')"><i class="fa fa-edit"></i> Edit</button>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <br/> 
          
      </div>
    </div>

    <div class="col-sm-12">
      <div class="card card-outline-success">
        <div class="card-header">
          <h4 class="text-white">DAFTAR BED</h4>
        </div>
        <div class="card-block">
          <div class="col-sm-3" align="left">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myBed" title="Tambah Bed"><i class="fa fa-plus"></i> Bed Baru</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->
          <br/>           
          <table id="table-bed" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>ID Ruang</th>
                <th>Nama Ruang</th>
                <th>Kelas</th>
                <th>No Bed</th>
                <th>Status</th>
                <th class="text-center">Ruangan</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $i=1;
                  foreach($bed as $row){
              ?>
              <tr>
                <td class="text-center"><?php echo $i++;?></td>
                <td><?php echo $row->idrg;?></td>
                <td><?php echo $row->nmruang;?></td>
                <td><?php echo $row->kelas;?></td>
                <td><?php echo $row->no_bed;?></td>
                <td>
                <?php 
                if($row->isi=='Y'){
                    echo "
                          <button type='button' class='btn-danger btn-sm text' disabled>
                          <h6 class='text-white'><i class='icon fa fa-ban'></i> Bed Terisi</h6>
                          </button>
                        ";
                  } else{
                    echo "
                          <button type='button' class='btn-success btn-sm' disabled>
                          <h6 style='color: #ededed;'><i class='icon fa fa-check'></i> Bed Kosong</h6>
                          </button>
                        ";
                  }
                ?>
                </td>
                <td class="text-center">
                <?php 
                if($row->status=='1'){
                    echo "
                          <h6>Utama</h6>
                        ";
                  } else{
                    echo "
                          <h6>Cadangan</h6>
                        ";
                  }
                ?>
                </td>
                <td class="text-center">                  
                  <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#editModal" title="Edit Bed"  onclick="edit_bed('<?php echo $row->bed;?>')"><i class="fa fa-edit"></i> Edit</button>
                  <button type="button" class="btn btn-danger btn-sm btn-block" title="Hapus Bed"  onclick="hapus_bed('<?php echo $row->bed;?>')"><i class="fa fa-trash"></i> Hapus</button>                  
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php echo form_open('master/mcruang/edit_ruang');?>
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModalRuang" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Ruang</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id Ruang</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_idrg" id="edit_idrg" disabled="">
                      <input type="hidden" class="form-control" name="edit_idrg_hidden" id="edit_idrg_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama Ruang</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nmruang" id="edit_nmruang">
                    </div>
                  </div>
                  <div class="col-sm-1"></div>
                  <p>* Nama Ruangan tidak diperkenankan menggunakan tanda ' - '</p>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Lokasi</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_lokasiruang" id="edit_lokasiruang">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Status</p>
                    <div class="col-sm-6">
                      <select class="form-control" name="edit_aktif" id="edit_aktif" disabled="">
                        <option value="Active">Active</option>
                        <option value="Tidak Active">Tidak Active</option>
                      </select>
                    </div>
                  </div>
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit Ruang</button>
                </div>
              </div>
            </div>
          </div>
          <?php echo form_close();?>

          <?php echo form_open('master/mcruang/edit_bed');?>
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Bed</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id Ruang</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_idrg_bed" id="edit_idrg_bed" disabled="">
                      <input type="hidden" class="form-control" name="edit_idrg_hidden_bed" id="edit_idrg_hidden_bed">
                      <input type="hidden" class="form-control" name="edit_bed_hidden" id="edit_bed_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">No Bed</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_no_bed" id="edit_no_bed" disabled="">
                      <input type="hidden" class="form-control" name="edit_no_bed_hidden" id="edit_no_bed_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama Ruang</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nmruang_bed" id="edit_nmruang_bed" disabled="">
                    </div>
                  </div>                 
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Kelas</p>
                    <div class="col-sm-6">
                      <select class="form-control" name="edit_kelas" id="edit_kelas" disabled="">
                        <?php 
                        foreach($kelas as $row){
                            echo '<option value="'.$row->kelas.'">'.$row->kelas.'</option>';
                          }?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Status</p>
                    <div class="col-sm-6">
                      <select class="form-control" name="edit_isi" id="edit_isi" required>
                        <option value="Y">ISI</option>
                        <option value="N">KOSONG</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Keterangan</p>
                    <div class="col-sm-6">
                      <select class="form-control" name="edit_status" id="edit_status" required>
                        <option value="1">UTAMA</option>
                        <option value="2">CADANGAN</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-editbed">Edit Bed</button>
                </div>
              </div>
            </div>
          </div>
          <?php echo form_close();?>

        </div>
      </div>
    </div>
  </div>
</section>
    <?php echo form_open('master/mcruang/insert_bed');?>    
      <div class="modal fade" id="myBed" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-success">
          <!-- Modal content-->
          <div class="modal-content">
           <div class="modal-header">
                  <h4 class="modal-title" id="title_modal">Tambah Bed Baru</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
            <div class="modal-body">
              <div class="form-group row">
                <div class="col-sm-1"></div>
                <p class="col-sm-3 form-control-label" id="lbl_nmruang">Ruangan</p>
                <div class="col-sm-6">
                  <select id="idrg" class="form-control" name="idrg" required>
                    <option value="" disabled selected="">-Pilih Ruangan-</option>
                    <?php 
                      foreach($ruang as $row){
                        echo '<option value="'.$row->idrg.'">'.$row->nmruang.'</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-1"></div>
                <p class="col-sm-3 form-control-label" id="lbl_kelas">Kelas</p>
                <div class="col-sm-6">
                  <select class="form-control" name="kelas" id="kelas" onclick="get_banyak_bed(this.value)" required>
                    <option value="" disabled selected="">-Pilih Kelas-</option>
                    <?php 
                    foreach($kelas as $row){
                        echo '<option value="'.$row->kelas.'">'.$row->kelas.'</option>';
                      }?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-1"></div>
                <p class="col-sm-3 form-control-label" id="lbl_kelas">Ruangan</p>
                <div class="col-sm-6">
                  <select class="form-control" name="status" id="status">
                    <option value="1">UTAMA</option>
                    <option value="2">CADANGAN</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-1"></div>
                <p class="col-sm-3 form-control-label" id="lbl_nmbed">Banyak Bed Sekarang</p>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="no_bed" id="no_bed" disabled="">
                  <input type="hidden" class="form-control" name="no_bed_hidden" id="no_bed_hidden">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button class="btn btn-primary" type="submit">Insert Bed</button>
            </div>
          </div>
        </div>
      </div>
    <?php echo form_close();?>

    <?php echo form_open('master/mcruang/insert_ruang');?>        
      <div class="modal fade" id="myRuang" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-success">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
                  <h4 class="modal-title" id="title_modal">Tambah Ruangan Baru</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
            <div class="modal-body">
              <div class="form-group row">
                <div class="col-sm-1"></div>
                <p class="col-sm-3 form-control-label" id="lbl_nmruang">Nama Ruangan</p>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="ruang_nmruangan" id="ruang_nmruangan">                    
                </div>
              </div>
              <div class="col-sm-1"></div>
              <p>* Nama Ruangan tidak diperkenankan menggunakan tanda ' - '</p>
              <div class="form-group row">
                <div class="col-sm-1"></div>
                <p class="col-sm-3 form-control-label" id="lbl_nmruang">Nomor Ruangan</p>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="ruang_noruangan" id="ruang_noruangan">                    
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-1"></div>
                <p class="col-sm-3 form-control-label" id="lbl_nmruang">Lokasi Ruangan</p>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="ruang_lokasiruangan" id="ruang_lokasiruangan">
                </div>
              </div>
              </div>
              <div class="modal-footer">
                <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Insert Ruangan</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php echo form_close();?>
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>