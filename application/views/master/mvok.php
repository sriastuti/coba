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
    	$('#example').DataTable();
	$(".select2").select2();
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

 function edit_perawat(id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/Mcok/get_data_edit_perawat')?>",
      data: {
        id: id
      },
      success: function(data){
  //alert(data[0].id_dokter);
        $('#edit_id').val(data[0].id);
        $('#edit_id_hidden').val(data[0].id);
        $('#edit_nm_perawat').val(data[0].nm_perawat);
        $('#edit_klp_pelaksana').val(data[0].klp_pelaksana);
      },
      error: function(){
        alert("error");
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
  <div class="row" id="row">
    <div class="col-sm-12">
      <div class="card card-outline-primary">
        <div class="card-header">
          <h3 class="text-white">DAFTAR PERAWAT OK</h3>
        </div>
        <div class="card-block">

          <div class="col-sm-9">
          </div>

          <?php echo form_open('master/Mcok/insert_perawat');?>
          <div class="col-sm-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Perawat Baru</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <!-- Modal Insert Obat -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg"">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Perawat Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="col-sm-6">
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_nm_perawat">Nama Perawat</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="nm_perawat" id="nm_perawat" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_poli">Kelompok Pelaksana</p>
                      <div class="col-sm-8">
                        <select  class="form-control" style="width: 100%" name="klp_pelaksana" id="klp_pelaksana" required>
                          <option value="">-Pilih Kelompok-</option>            
                              <option value="PERAWAT OPERASI">PERAWAT OPERASI</option>
                                <option value="PERAWAT ANASTESI">PERAWAT ANASTESI</option>                      
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
              <div class="col-sm-1"></div>
              </div>
                </div>
		
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Insert Perawat</button>
                </div>
              </div>
            </div>
          </div>
          
          <?php echo form_close();?>
          <br/> 
          <br/> 

          <table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                
                <th>ID Perawat</th>
                <th>Nama Perawat</th>
                <th>Kelompok Pelaksana</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php  
                  foreach($perawat as $row){
              ?>
              <tr>
                <td><?php echo $row->id;?></td>
                <td><?php echo $row->nm_perawat;?></td>
                <td><?php echo $row->klp_pelaksana;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="edit_perawat('<?php echo $row->id;?>')"><i class="fa fa-edit"></i></button>
                  <a type="button" class="btn btn-danger btn-sm" href="<?php echo base_url('master/Mcok/delete_perawat/'.$row->id)?>" ><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php echo form_open('master/Mcok/edit_perawat');?>
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Perawat Ok</h4>
                </div>
                <div class="modal-body">
                  <div class="col-sm-6">
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Id Perawat</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="edit_id" id="edit_id" disabled="">
                        <input type="hidden" class="form-control" name="edit_id_hidden" id="edit_id_hidden">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Nama Perawat</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="edit_nm_perawat" id="edit_nm_perawat" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_biaya">Kelompok Pelaksana</p>
                      <div class="col-sm-8">
                        <select  class="form-control" style="width: 100%" name="edit_klp_pelaksana" id="edit_klp_pelaksana" required>
                          <option value="">-Pilih Kelompok Pelaksana-</option>
                              <option value="PERAWAT OPERASI">PERAWAT OPERASI</option>
                                <option value="PERAWAT ANASTESI">PERAWAT ANASTESI</option>
                        </select>
                      </div>
                    </div>
                  </div>
            		  <div class="form-group row">
            			<div class="col-sm-1"></div>
            		  </div>
                </div>
		
                <div class="modal-footer">
		             
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit Perawat</button>
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

<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>
