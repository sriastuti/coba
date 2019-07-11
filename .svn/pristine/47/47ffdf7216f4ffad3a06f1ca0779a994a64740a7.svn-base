<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?> 
<html>
<script type='text/javascript'>
	$(function() {
		$('#example').DataTable();
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true,
		});  
	});

	var intervalSetting = function () {
		location.reload();
	};
	setInterval(intervalSetting, 60000);

	function tindak(waktu_masuk,no_register){
		if(waktu_masuk==''){
			swal({
	         title: "Tindak Pasien",
	         text: "Apakah Pasien sudah masuk Ke Ruangan Laboratorium ?",
	         type: "info",
	         showCancelButton: true,
	         closeOnConfirm: false,
	         showLoaderOnConfirm: true,
	      },
	      function(){
	         location.href = '<?php echo site_url('lab/labcdaftar/pemeriksaan_lab');?>/'+no_register;         
	      });
		}else{
	      	location.href = '<?php echo site_url('lab/labcdaftar/pemeriksaan_lab');?>/'+no_register;
	   	}
	}
</script>

<?php
	echo $this->session->flashdata('success_msg');
?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-outline-info">
            <div class="card-block">
                <div class="row p-t-0">

                    <?php echo form_open('lab/labcdaftar/daftar_pasien_luar');?>
					<div class="col-md-4">
						<div class="input-group" align="right">
							<span class="input-group-btn">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Registrasi Pasien Luar</button>
							</span>
						</div><!-- /input-group -->	
					</div><!-- /col-lg-6 -->

					<!-- Modal -->
					<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
						<div class="modal-dialog modal-success modal-lg">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Registrasi Pasien Luar</h4>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_nama">NO RM</p>
										<div class="col-sm-7">
											<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
											<input type="text" class="form-control" name="no_cm" id="no_cm" placeholder="Isi Jika Ada">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_nama">Nama</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="nama" id="nama">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_alamat">Usia</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="usia" id="usia">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_alamat">Jenis Kelamin</p>
										<div class="col-sm-7">
											<select name="jk" id="jk" class="form-control">
												<option value="L">Laki-laki</option>
												<option value="P">Perempuan</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_alamat">Alamat</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="alamat" id="alamat">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_dokter">Dokter Perujuk</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="dokter" id="dokter" placeholder="Isi Jika Ada">
										</div>
									</div>

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button class="btn btn-primary" type="submit">Simpan</button>
								</div>
							</div>

						</div>
					</div>
					<?php echo form_close();?>

                    <div class="col-md-4">
					<?php echo form_open('lab/labcdaftar');?>
                        <div class="input-group">
							<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div>
					<?php echo form_close();?>
                    </div>
                    <div class="col-md-4">
					<?php echo form_open('lab/labcdaftar');?>
                        <div class="input-group">
							<input type="text" class="form-control" name="key" placeholder="Nama / No. Register" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div>
					<?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
            	<h3><?=$title?></h3>
                <div class="table-responsive m-t-0">
                    <table id="example" class="display nowrap table table-hover table-striped table-bordered">
                        <thead>
							<tr>
							  	<th>Aksi</th>
							  	<th>Tanggal Kunjungan</th>
							  	<th>No Medrec</th>
							  	<th>No Registrasi</th>
							  	<th>Nama</th>
							  	<!-- <th>Kelas</th> -->
							  	<th>Ruangan</th>
							  	<th>Bed</th>
							</tr>
                        </thead>
						<tbody>
							<?php
								$i=1;
									foreach($laboratorium as $row){
									$no_register=$row->no_register;
							?>
							<tr>
							  	<td>
							  		<!-- <button onclick="tindak('<?php echo $row->waktu_masuk_lab; ?>','<?php echo $no_register; ?>')" class="btn btn-primary">Tindak <i class="ti-pencil"></i></button> -->
									<?php if ($row->idrg!='Urikkes') { ?>
										<a href="javascript:;" class="btn btn-primary" onClick="return openUrl('<?php echo site_url('lab/labcdaftar/pemeriksaan_lab/'.$no_register); ?>');">Tindak <i class="ti-pencil"></i></a>
									<?php } else { ?>
										<a href="<?php echo base_url();?>urikes/Curikes/isi_hasil_poli/<?php echo $row->no_register; ?>" class="btn btn-primary btn-xs" style="margin-right:3px;">Tindak</a>
									<?php }?>
									
							  	</td>
								<td><?php echo date('Y-m-d',strtotime($row->tgl_kunjungan));?></td>
								<td><?php echo $row->no_medrec;?></td>
								<td><?php echo $row->no_register;?></td>
								<td><?php echo $row->nama;?></td>
								<!-- <td><?php echo $row->kelas;?></td> -->
								<td><?php echo $row->idrg;?></td>
								<td><?php echo $row->bed;?></td>
							</tr>
							<?php } ?>
						</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 