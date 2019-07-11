<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>
<script type='text/javascript'>
  var site = "<?php echo site_url();?>";
  //-----------------------------------------------Data Table
  $(document).ready(function() {
    $('#example').DataTable();
    $(".select2").select2();
    $('input[type="checkcard"].flat-red, input[type="radio"].flat-red').iCheck({
      checkcardClass: 'icheckcard_flat-green',
      radioClass: 'iradio_flat-green'
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

  function edit_tindakan(idtindakan) {
    $('#edit_idtindakan').val("");
    $('#edit_idtindakan_hide').val("");
    $('#edit_nmtindakan').val("");    
    $('#edit_kelas_vipa').val("");
    $('#edit_alkes_kelas_vipa').val("");
    $('#edit_kelas_vipb').val("");
    $('#edit_alkes_kelas_vipb').val("");
    $('#edit_kelas_1').val("");
    $('#edit_alkes_kelas_1').val("");
    $('#edit_kelas_2').val("");
    $('#edit_alkes_kelas_2').val("");
    $('#edit_kelas_3').val("");
    $('#edit_alkes_kelas_3').val("");
    $('#edit_kelas_3a').val("");
    $('#edit_alkes_kelas_3a').val("");
    // $('#edit_kelas_3b').val("");
    // $('#edit_alkes_kelas_3b').val("");
    $('#edit_paket').iCheck('uncheck');
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mctindakan/get_data_edit_tindakan')?>",
      data: {
        idtindakan: idtindakan
      },
      success: function(data){
        $('#edit_idtindakan').val(data[0].idtindakan);
        $('#edit_idtindakan_hide').val(data[0].idtindakan);
        $('#edit_nmtindakan').val(data[0].nmtindakan);
        //alert(data[0].idkel_tind);
        $('#edit_idkel_tind').val(data[0].idkel_tind).change();
        if(data[0].paket==1){
          $('#edit_paket').iCheck('check');
        }
        var i=0;
      	//alert(data[0].kelas=="VIP A");
      	if(data[i].kelas!=null){
      		for(i=0;i<7;i++){
      		  if(data[i].kelas=="VVIP"){
      		    $('#edit_kelas_vipa').val(data[i].total_tarif);
      		    $('#edit_alkes_kelas_vipa').val(data[i].tarif_alkes);
      		  }
      		  if(data[i].kelas=="VIP"){
      		    $('#edit_kelas_vipb').val(data[i].total_tarif);
      		    $('#edit_alkes_kelas_vipb').val(data[i].tarif_alkes);
      		  }
            if(data[i].kelas=="UTAMA"){
      		    $('#edit_kelas_3a').val(data[i].total_tarif);
      		    $('#edit_alkes_kelas_3a').val(data[i].tarif_alkes);
      		  }

            if(data[i].kelas=="I"){
      		    $('#edit_kelas_1').val(data[i].total_tarif);
      		    $('#edit_alkes_kelas_1').val(data[i].tarif_alkes);
      		  }
      		  if(data[i].kelas=="II"){
      		    $('#edit_kelas_2').val(data[i].total_tarif);
      		    $('#edit_alkes_kelas_2').val(data[i].tarif_alkes);
      		  }
      		  if(data[i].kelas=="III"){
      		    $('#edit_kelas_3').val(data[i].total_tarif);
      		    $('#edit_alkes_kelas_3').val(data[i].tarif_alkes);
      		  }
      		  // if(data[i].kelas=="III A"){
      		  //   $('#edit_kelas_3a').val(data[i].total_tarif);
      		  //   $('#edit_alkes_kelas_3a').val(data[i].tarif_alkes);
      		  // }
      		  // if(data[i].kelas=="III B"){
      		  //   $('#edit_kelas_3b').val(data[i].total_tarif);
      		  //   $('#edit_alkes_kelas_3b').val(data[i].tarif_alkes);
      		  // }
      		}
      	}
      },
      error: function(){
        alert("error");
      }
    });
  }

  function download_excel() {
    window.location.href = "<?php echo base_url('master/mctindakan/export_excel')?>";
  }

  function edit()
  {
    $('#btnEdit').text('saving...'); //change button text
    $('#btnEdit').attr('disabled',true); //set button disable 
    var url;

    url = "<?php echo site_url('master/mctindakan/edit_tindakan')?>";  

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#formedit').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            $('#editModal').modal('hide');

            $('#btnEdit').text('Edit Tindakan'); //change button text
            $('#btnEdit').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $('#editModal').modal('hide');
            // alert('Error adding / update data');
            $('#btnEdit').text('Edit Tindakan'); //change button text
            $('#btnEdit').attr('disabled',false); //set button enable 

        }
    });
  }

</script>
<section class="content-header">
  <?php
    echo $this->session->flashdata('success_msg');
  ?>
</section>

<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <div class="card card-outline-info">
        <div class="card-header">
          <h3 class="card-title text-white">DAFTAR TINDAKAN</h3>
        </div>
        <div class="card-block ">

          <?php echo form_open('master/mctindakan/insert_tindakan');?>
          <div class="form-group row">
          <div class="col-sm-9">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-primary" type="submit" onClick="download_excel()">Download Excel</button>
              </span>
            </div><!-- /input-group -->
          </div><!-- /col-lg-6 -->
          <div class="col-sm-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tindakan</button>
              </span>
            </div><!-- /input-group -->
          </div><!-- /col-lg-6 -->
        </div>

          <!-- Modal -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Tindakan</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">ID Tindakan</p>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="idtindakan" id="idtindakan"  maxlength="7" required>
                    </div>
                      <div class="col-sm-4">
                        <input type="checkbox" class="filled-in" value="1" name="edit_paket" id="edit_paket" />
                                    <label for="check_cetak_kartu">Tarif Paket</label>
                      </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">Nama Tindakan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nmtindakan" id="nmtindakan" required>
                    </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_biaya">Kelompok Tindakan</p>
                      <div class="col-sm-6">
                        <select  class="form-control select2" style="width: 100%" name="idkel_tind" id="idkel_tind" > 
                          <?php                   
                            foreach($kel_tindakan as $row1){           
                              echo '<option value="'.$row1->idkel_tind.'">'.$row1->nama_kel.'</option>';                      
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                  <hr>
                  <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas VVIP</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="kelas_vipa" id="kelas_vipa" step="100" min="0">
                    </div>
                    <div class="col-sm-1"></div>
                    <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="alkes_kelas_vipa" id="alkes_kelas_vipa" step="100" min="0">
                    </div>
                  </div>
                  <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lbl_alamat">Tarif Kelas VIP</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="kelas_vipb" id="kelas_vipb" step="100" min="0">
                    </div>
                    <div class="col-sm-1"></div>
                    <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="alkes_kelas_vipb" id="alkes_kelas_vipb" step="100" min="0">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas UTAMA</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="kelas_3a" id="kelas_3a" step="100" min="0">
                    </div>
                    <div class="col-sm-1"></div>
                    <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="alkes_kelas_3a" id="alkes_kelas_3a" step="100" min="0">
                    </div>
                  </div>
                  <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas I</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="kelas_1" id="kelas_1" step="100" min="0">
                    </div>
                    <div class="col-sm-1"></div>
                    <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="alkes_kelas_1" id="alkes_kelas_1" step="100" min="0">
                    </div>
                  </div>
                  <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lbl_alamat">Tarif Kelas II</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="kelas_2" id="kelas_2" step="100" min="0">
                    </div>
                    <div class="col-sm-1"></div>
                    <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="alkes_kelas_2" id="alkes_kelas_2" step="100" min="0">
                    </div>
                  </div>
                  <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas III</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="kelas_3" id="kelas_3" step="100" min="0">
                    </div>
                    <div class="col-sm-1"></div>
                    <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="alkes_kelas_3" id="alkes_kelas_3" step="100" min="0">
                    </div>
                  </div>
                  </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Insert Tindakan</button>
                </div>
              </div>
            </div>
          </div>

          <?php echo form_close();?>
          <hr>
          <table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>ID Tindakan</th>
                <th>Nama Tindakan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>ID Tindakan</th>
                <th>Nama Tindakan</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
                  $i=1;
                  foreach($tindakan as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->idtindakan;?></td>
                <td><?php echo $row->nmtindakan;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onClick="edit_tindakan('<?php echo $row->idtindakan;?>')"><i class="fa fa-edit"></i></button>
                  <a type="button" class="btn btn-default btn-sm" href="<?php echo base_url('master/mctindakan/delete_tindakan/'.$row->idtindakan)?>" ><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>


          <!-- eDIT Modal -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Tindakan</h4>
                </div>
                <div class="modal-body">
                  <form action="#" id="formedit" class="form-horizontal">
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_nama">ID Tindakan</p>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="edit_idtindakan" id="edit_idtindakan"  disabled="">
                        <input type="hidden" class="form-control" name="edit_idtindakan_hide" id="edit_idtindakan_hide">
                      </div>
                      <div class="col-sm-4">
                        <input type="checkbox" class="filled-in" value="1" name="edit_paket" id="edit_paket" />
                                    <label for="check_cetak_kartu">Tarif Paket</label>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_nama">Nama Tindakan</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_nmtindakan" id="edit_nmtindakan" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_biaya">Kelompok Tindakan</p>
                      <div class="col-sm-6">
                        <select  class="form-control select2" style="width: 100%" name="edit_idkel_tind" id="edit_idkel_tind" > 
                          <?php                   
                            foreach($kel_tindakan as $row1){           
                              echo '<option value="'.$row1->idkel_tind.'">'.$row1->nama_kel.'</option>';                      
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas VVIP</p>
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="edit_kelas_vipa" id="edit_kelas_vipa" step="100" min="0">
                      </div>
                      <div class="col-sm-1"></div>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p>
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="edit_alkes_kelas_vipa" id="edit_alkes_kelas_vipa" step="100" min="0">
                      </div>
                    </div>
                    <div class="form-group row">
                      <p class="col-sm-2 form-control-label" id="lbl_alamat">Tarif Kelas VIP</p>
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="edit_kelas_vipb" id="edit_kelas_vipb" step="100" min="0">
                      </div>
                      <div class="col-sm-1"></div>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p>
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="edit_alkes_kelas_vipb" id="edit_alkes_kelas_vipb" step="100" min="0">
                      </div>
                    </div>
                           
                    <div class="form-group row">
                      <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas UTAMA</p>
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="edit_kelas_3a" id="edit_kelas_3a" step="100" min="0">
                      </div>
                      <div class="col-sm-1"></div>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p>
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="edit_alkes_kelas_3a" id="edit_alkes_kelas_3a" step="100" min="0">
                      </div>
                    </div>
    
                    
                    <div class="form-group row">
                      <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas I</p>
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="edit_kelas_1" id="edit_kelas_1" step="100" min="0">
                      </div>
                      <div class="col-sm-1"></div>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p>
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="edit_alkes_kelas_1" id="edit_alkes_kelas_1" step="100" min="0">
                      </div>
                    </div>
                    <div class="form-group row">
                      <p class="col-sm-2 form-control-label" id="lbl_alamat">Tarif Kelas II</p>
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="edit_kelas_2" id="edit_kelas_2" step="100" min="0">
                      </div>
                      <div class="col-sm-1"></div>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p>
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="edit_alkes_kelas_2" id="edit_alkes_kelas_2" step="100" min="0">
                      </div>
                    </div>
                    <div class="form-group row">
                      <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas III</p>
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="edit_kelas_3" id="edit_kelas_3" step="100" min="0">
                      </div>
                      <div class="col-sm-1"></div>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p>
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="edit_alkes_kelas_3" id="edit_alkes_kelas_3" step="100" min="0">
                      </div>
                    </div> 
                  </div>
                </form>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" id="btnEdit" onclick="edit()" class="btn btn-primary">Edit Tindakan</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>

