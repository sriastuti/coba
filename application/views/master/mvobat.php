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
    $('#example').DataTable({
      "iDisplayLength": 100
    });
    
  });

  
  function edit_obat(id_obat) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcobat/get_data_edit_obat')?>",
      data: {
        id_obat: id_obat
      },
      success: function(data){
        $('#edit_id_obat').val(data[0].id_obat);
        $('#edit_id_obat_hidden').val(data[0].id_obat);
        $('#edit_nm_obat').val(data[0].nm_obat);
        $('#edit_satuank').val(data[0].satuank);
        $('#edit_satuanb').val(data[0].satuanb);
        $('#edit_faktorsatuan').val(data[0].faktorsatuan);
        // $('#edit_hargabeli').val(data[0].hargabeli);
        $('#edit_hargajual').val(data[0].hargajual);
        $('#edit_kel').val(data[0].kel);
        $('#edit_jenis_obat').val(data[0].jenis_obat);
        $('#edit_tgl_kadaluarsa').val(data[0].tgl_kadaluarsa);
        $('#edit_minstok').val(data[0].min_stock);
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
          <h3 class="text-white">DAFTAR OBAT</h3>
        </div>
        <div class="card-block">
          <div class="col-sm-3">
            <div class="input-group">
              <span class="input-group-btn">
                <a href="<?php echo site_url('master/mcobat/kebijakan'); ?>" class="btn btn-primary btn-md">Tabel Kebijakan Obat</a>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <div class="col-sm-6">
          </div><!-- /col-lg-3 -->

          <?php echo form_open('master/mcobat/insert_obat');?>
          <div class="col-sm-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Obat Baru</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <!-- Modal Insert Obat -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Obat Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">Nama Obat</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nm_obat" id="nm_obat">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">Satuan Kecil</p>
                    <div class="col-sm-6">
                      <select id="satuank" class="form-control" name="satuank" required>
                        <option value="" disabled selected="">-Pilih Satuan Kecil-</option>
                        <?php 
                          foreach($satuan as $row){
                            echo '<option value="'.$row->nm_satuan.'">'.$row->nm_satuan.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">Satuan Besar</p>
                    <div class="col-sm-6">
                      <select id="satuanb" class="form-control" name="satuanb" required>
                        <option value="" disabled selected="">-Pilih Satuan Besar-</option>
                        <?php 
                          foreach($satuan as $row){
                            echo '<option value="'.$row->nm_satuan.'">'.$row->nm_satuan.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_alamat">Faktor Satuan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="faktorsatuan" id="faktorsatuan">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_alamat">Harga Jual</p>
                    <div class="col-sm-6">
                      <input type="number" class="form-control" name="hargajual" id="hargajual" min="0">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_alamat">Kelompok</p>
                    <div class="col-sm-6">
                      <select id="kel" class="form-control" name="kel" required>
                        <option value="" disabled selected="">-Pilih Kelompok-</option>
                        <?php 
                          foreach($kelompok as $row){
                            echo '<option value="'.$row->nm_satuan.'">'.$row->nm_satuan.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Jenis</p>
                    <div class="col-sm-6">
                      <select id="jenis_obat" class="form-control" name="jenis_obat" required>
                        <option value="" disabled selected="">-Pilih Jenis-</option>
                        <?php 
                          foreach($jenis as $row){
                            echo '<option value="'.$row->nm_jenis.'">'.$row->nm_jenis.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Minimum Stock</p>
                    <div class="col-sm-6">
                      <input type="number" class="form-control" name="minstok" id="minstok" min="0">
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Insert Obat</button>
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
                <th>No</th>
                <th>Nama</th>
                <th>Harga Jual</th>
                <th>Satuan Kecil</th>
                <th>Satuan Besar</th>
                <th>Jenis Obat</th>
                <th>Kelompok Obat</th>
                <th>Min Stock</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Harga Jual</th>
                <th>Satuan Kecil</th>
                <th>Satuan Besar</th>
                <th>Jenis Obat</th>
                <th>Kelompok Obat</th>
                <th>Min Stock</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody id="bodyt">
              <?php
                  $i=1;
                  foreach($obat as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->nm_obat;?></td>
                <td><div align="right">
                <?php echo number_format($row->hargajual, '0', ',', '.');?></div></td>
                <td><?php echo $row->satuank;?></td>
                <td><?php echo $row->satuanb;?></td>
                <td><?php echo $row->jenis_obat;?></td>
                <td><?php echo $row->kel;?></td>
                <td><div align="right">
                <?php echo number_format($row->min_stock, '0', ',', '.');?></div></td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="edit_obat('<?php echo $row->id_obat;?>')"><i class="fa fa-trash"></i></button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php echo form_open('master/mcobat/edit_obat');?>
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Obat</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id Obat</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_id_obat" id="edit_id_obat" disabled="">
                      <input type="hidden" class="form-control" name="edit_id_obat_hidden" id="edit_id_obat_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama Obat</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nm_obat" id="edit_nm_obat">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Satuan Kecil</p>
                    <div class="col-sm-6">
                      <select id="edit_satuank" class="form-control" name="edit_satuank" required>
                        <option value="" disabled selected="">-Pilih Satuan Kecil-</option>
                        <?php 
                          foreach($satuan as $row){
                            echo '<option value="'.$row->nm_satuan.'">'.$row->nm_satuan.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Satuan Besar</p>
                    <div class="col-sm-6">
                      <select id="edit_satuanb" class="form-control" name="edit_satuanb" required>
                        <option value="" disabled selected="">-Pilih Satuan Besar-</option>
                        <?php 
                          foreach($satuan as $row){
                            echo '<option value="'.$row->nm_satuan.'">'.$row->nm_satuan.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Faktor Satuan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_faktorsatuan" id="edit_faktorsatuan">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Harga Jual</p>
                    <div class="col-sm-6">
                      <input type="number" class="form-control" name="edit_hargajual" id="edit_hargajual" min="0">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Kelompok</p>
                    <div class="col-sm-6">
                      <select id="edit_kel" class="form-control" name="edit_kel" required>
                        <option value="" disabled selected="">-Pilih Kelompok-</option>
                        <?php 
                          foreach($kelompok as $row){
                            echo '<option value="'.$row->nm_satuan.'">'.$row->nm_satuan.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Jenis</p>
                    <div class="col-sm-6">
                      <select id="edit_jenis_obat" class="form-control" name="edit_jenis_obat" required>
                        <option value="" disabled selected="">-Pilih Jenis-</option>
                        <?php 
                          foreach($jenis as $row){
                            echo '<option value="'.$row->nm_jenis.'">'.$row->nm_jenis.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Minimum Stock</p>
                    <div class="col-sm-6">
                      <input type="number" class="form-control" name="edit_minstok" id="edit_minstok" min="0">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit Obat</button>
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