<?php
	if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?>

<link rel="stylesheet" href="<?php echo site_url('asset/plugins/iCheck/flat/green.css'); ?>">

<script src="<?php echo site_url('asset/plugins/iCheck/icheck.min.js'); ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
	  $(".js-example-basic-single").select2();
	});
</script>

<script type='text/javascript'>

	//-----------------------------------------------Data Table
	$(document).ready(function() {
		$("#biaya_rad").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$("#vtot").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$('input').iCheck({
	    	checkboxClass: 'icheckbox_flat-green'
	  	});
	} );
	//---------------------------------------------------------

	var site = "<?php echo site_url();?>";
			
	function pilih_tindakan(id_tindakan) {
		$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('rad/radcdaftar/get_biaya_tindakan')?>",
			data: {
				id_tindakan: id_tindakan,
				kelas : "<?php echo $kelas_pasien ?>"
			},
			success: function(data){
				$('#biaya_rad').val(data);
				$('#biaya_rad_hide').val(data);
				$('#qty').val('1');
				set_total();
			},
			error: function(){
				alert("error");
			}
	    });
	}

	$(function(){
		$('.auto_diagnosa_pasien').autocomplete({
			serviceUrl: site+'iri/ricstatus/data_icd_1',
			onSelect: function (suggestion) {
				$('#dis_diagmasuk').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
				$('#id_diagnosa').val(''+suggestion.id_icd);
			}
		});
	});

	function set_total() {
		var total = $("#biaya_rad").val() * $("#qty").val();	
		$('#vtot').val(total);
		$('#vtot_hide').val(total);
	}

	function hapus_data_pemeriksaan(id_pemeriksaan_rad)
	{
	  	swal({
		  	title: "Hapus Data",
		  	text: "Benar Akan Menghapus Data?",
		  	type: "info",
		  	showCancelButton: true,
		  	closeOnConfirm: false,
		  	showLoaderOnConfirm: true,
		},
		function(){
		   	$.ajax({
				type:'POST',
				dataType: 'json',
				url:"<?php echo base_url('rad/radcdaftar/hapus_data_pemeriksaan')?>/"+id_pemeriksaan_rad,
		        success: function(data)
		        {
	                $("#tabel_rad").load("<?php echo base_url('rad/radcdaftar/pemeriksaan_rad').'/'.$no_register;?> #tabel_rad");
	    			swal({
					  	title: "Data Pemeriksaan Berhasil Dihapus.",
					  	text: "Akan menghilang dalam 3 detik.",
					  	timer: 3000,
					  	showConfirmButton: false,
					  	showCancelButton: true
					});
		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		            alert('Error hapus / hapus data');
		        }
		    });
		});
	}
	
	function save(){
		swal({
		  	title: "Tambah Data",
		  	text: "Benar Akan Menyimpan Data?",
		  	type: "info",
		  	showCancelButton: true,
		  	closeOnConfirm: false,
		  	showLoaderOnConfirm: true,
		},
		function(){
	        $.ajax({
				url:"<?php echo base_url('rad/radcdaftar/insert_pemeriksaan')?>",
		        type: "POST",
		        data: $('#formInsertPemeriksaan').serialize(),
		        dataType: "JSON",
		        success: function(data)
		        {

			            if(data.status) //if success close modal and reload ajax table
			            {
			            	// $('#myCheckboxes').iCheck('uncheck');
			                // $('#pemeriksaanModal').modal('hide');
			                $("#tabel_rad").load("<?php echo base_url('rad/radcdaftar/pemeriksaan_rad').'/'.$no_register;?> #tabel_rad");
			    			swal({
							  	title: "Data Pemeriksaan Berhasil Disimpan.",
							  	text: "Akan menghilang dalam 3 detik.",
							  	timer: 3000,
							  	showConfirmButton: false,
							  	showCancelButton: true
							});
			                // window.location.reload();
			            }
		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		            alert(errorThrown);
	        	}
	    	});
		});
	}

	function save_banyak_data(){
		swal({
		  	title: "Tambah Data",
		  	text: "Benar Akan Menyimpan Data?",
		  	type: "info",
		  	showCancelButton: true,
		  	closeOnConfirm: false,
		  	showLoaderOnConfirm: true,
		},
		function(){
			$.ajax({
				url:"<?php echo base_url('rad/radcdaftar/save_pemeriksaan')?>",
		        type: "POST",
		        data: $('#formPemeriksaan').serialize(),
		        dataType: "JSON",
		        success: function(data)
		        {
		            if(data.status) //if success close modal and reload ajax table
		            {
		            	 $('#myCheckboxes').iCheck('uncheck');
		                $('#pemeriksaanModal').modal('hide');
		                $("#tabel_rad").load("<?php echo base_url('rad/radcdaftar/pemeriksaan_rad').'/'.$no_register;?> #tabel_rad");
		    			// swal("Data Pemeriksaan Berhasil Disimpan.");
		    			
		    			swal({
						  	title: "Data Pemeriksaan Berhasil Disimpan.",
						  	text: "Akan menghilang dalam 3 detik.",
						  	timer: 3000,
						  	showConfirmButton: false,
						  	showCancelButton: true
						});
		                // window.location.reload();
		            }


		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		         	window.location.reload();
	        	}
	    	});
		});
	}

	function edit_diag(){
		var id_diagnosa = document.getElementById("id_diagnosa").value;
		swal({
		  	title: "Edit Data",
		  	text: "Benar Akan Mengedit Data Diagnosa?",
		  	type: "info",
		  	showCancelButton: true,
		  	closeOnConfirm: false,
		  	showLoaderOnConfirm: true,
		},
		function(){
			$.ajax({
				url:"<?php echo base_url('rad/radcdaftar/edit_diag')?>",
		        type: "POST",
		        data: {
		        	no_register : "<?php echo $no_register;?>",
		        	id_diagnosa : id_diagnosa
		        },
		        dataType: "JSON",
		        success: function(data)
		        {
		            if(data.status) //if success close modal and reload ajax table
		            {
		    			swal("Data Diagnosa Berhasil Diedit.");
		    			
		    // 			swal({
						//   	title: "Data Pemeriksaan Berhasil Disimpan.",
						//   	text: "Akan menghilang dalam 3 detik.",
						//   	timer: 3000,
						//   	showConfirmButton: false,
						//   	showCancelButton: true
						// });
		                // window.location.reload();
		            }


		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		         	window.location.reload();
	        	}
	    	});
		});
	}

	function closepage() {
		window.open(' ', '_self', ' '); window.close();
	}

</script>

<?php include('radvdatapasien.php');?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Daftar Pemeriksaan <?php if($tgl_periksa!=''){echo ' | '.date('d-m-Y',strtotime($tgl_periksa)); }?></h4>
            </div>
            <div class="card-block">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12">
                        	<div class="card b-all shadow-none">
								<?php 
									$attributes = array('id' => 'formInsertPemeriksaan', 'class' => 'form-horizontal');
									echo form_open('rad/radcdaftar/insert_pemeriksaan', $attributes);
								?>
                                <div class="card-block">
                    				<button type="button" class="btn btn-primary box-title" data-toggle="modal" data-target="#pemeriksaanModal">Add Pemeriksaan</button>
                    				<button type="button" class="btn btn-primary" onclick="resep()"><i class="fa fa-plus"></i> Resep</button>
                                </div>
                                <div>
                                    <hr class="m-t-0">
                                </div>
                                <div class="card-block">
									<div class="form-group row">
										<label class="control-label text-right col-md-2" id="lbl_input_diagnosa">Diagnosa Awal</label>
										<div class="col-md-10">
											<div class="form-group">
												<input type="text" class="form-control auto_diagnosa_pasien col-lg-12"  name="diagnosa" id="diagnosa" style="width:300px;font-size:15px;" value="<?php echo $diagnosa?>">
												<input type="hidden" class="form-control " name="id_diagnosa" id="id_diagnosa" value="<?php echo $id_diagnosa?>">
												<button type="button" id="submit" onclick="edit_diag()" class="btn btn-success">Edit</button>
											</div>
										</div>
									</div>
									<div class="form-group row" style="display: none;">
										<label class="control-label text-right col-md-2" id="nmdokter">Dokter</label>
										<div class="col-sm-10">
											<div class="form-group">
												<select id="id_dokter" class="form-control js-example-basic-single col-lg-12" name="id_dokter"  required>
													<option value="" disabled selected="">-Pilih Dokter-</option>
													<?php 
														foreach($dokter as $row){
															if($row->nm_dokter=="SMF RADIOLOGI"){
																echo '<option value="'.$row->id_dokter.'" selected>'.$row->nm_dokter.'</option>';
															}else{
																echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
															}
														}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label text-right col-md-2" id="tindakan">Pemeriksaan</label>
										<div class="col-sm-10">
											<div class="form-group">
												<select id="idtindakan" class="form-control js-example-basic-single" name="idtindakan" onchange="pilih_tindakan(this.value)" required>
													<option value="" disabled selected="">-Pilih Pemeriksaan-</option>
													<?php 
														foreach($tindakan as $row){
															echo '<option value="'.$row->idtindakan.'">'.$row->nmtindakan.'</option>';
														}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label text-right col-md-2" id="lbl_biaya_periksa">Biaya Pemeriksaan</label>
										<div class="col-sm-3">
											<div class="input-group">
												<span class="input-group-addon">Rp</span>
												<input type="text" class="form-control" name="biaya_rad" id="biaya_rad" disabled>
												<input type="hidden" class="form-control" value="" name="biaya_rad_hide" id="biaya_rad_hide">
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label text-right col-md-2" id="lbl_qty">Qtyind</label>
										<div class="col-sm-3">
											<input type="number" class="form-control" name="qty" id="qty" min=1 onchange="set_total(this.value)">
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label text-right col-md-2" id="lbl_vtot">Total</label>
										<div class="col-sm-3">
											<div class="input-group">
												<span class="input-group-addon">Rp</span>
												<input type="text" class="form-control" name="vtot" id="vtot" disabled>
												<input type="hidden" class="form-control" value="" name="vtot_hide" id="vtot_hide">
											</div>
										</div>
									</div>
                                </div>
                                <div>
                                    <hr class="m-t-0">
                                </div>
								<div class="card-block col-md-12" align="right">
                                	<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kunj">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
									<input type="hidden" class="form-control" value="<?php echo $tgl_periksa;?>" name="tgl_periksa">
									<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
									<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
									
									<button type="reset" class="btn btn-invers">Reset</button>
				                	<button type="button" id="submit" onclick="save()" class="btn btn-success">Simpan</button>
                                </div>
								<?php
									echo form_close();
								?>
                            </div>
                        </div>
                    </div>
                    <h3 class="m-t-20 box-title">Tabel Pemeriksaan</h3>
                    <hr class="m-t-20 m-b-20">
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
			                    <table id="tabel_rad" class="table display table-bordered table-striped">
			                        <thead>
										<tr>
										  	<th>No</th>
										  	<th>Tanggal Pemeriksaan</th>
										  	<!-- <th>Dokter</th> -->
										  	<th>Jenis Pemeriksaan</th>
										  	<th>Biaya Pemeriksaan</th>
										  	<th>Qtyind</th>
										  	<th>Total</th>
										  	<th>Aksi</th>
										</tr>
			                        </thead>
									<tbody>
										<?php
											$i=1;
											foreach($data_pemeriksaan as $row){
										?>
											<tr>
												<td><?php echo $i++ ; ?></td>
												<td><?php echo $row->xupdate ; ?></td>
												<!-- <td><?php //echo $row->nm_dokter.' ('.$row->id_dokter.')' ; ?></td> -->
												<td><?php echo $row->jenis_tindakan.' ('.$row->id_tindakan.')' ; ?></td>
												<td><?php echo $row->biaya_rad ; ?></td>
												<td><?php echo $row->qty ; ?></td>
												<td><?php echo $row->vtot ; ?></td>
												<td>
													<a class="btn btn-danger" href="javascript:void()" title="Hapus" onclick="hapus_data_pemeriksaan(<?php echo $row->id_pemeriksaan_rad ; ?>)">Hapus</a>
												</td>
											</tr>
										<?php
											}
										?>
									</tbody>
			                    </table>
			                </div>
		                </div>
                    </div>
                </div>
                <hr>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12" align="right">
							<?php
								echo form_open('rad/radcdaftar/selesai_daftar_pemeriksaan');?>
								<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
								<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">

								<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
								<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">

								<div class="form-group">
								<?php if($roleid==11 or $roleid==1){
									echo '
										<button class="btn btn-primary">Selesai & Cetak</button>
				                	';
								} 
								if($roleid<>11 or $roleid==1){
									echo '
										<button type="button" onclick="closepage()" class="btn btn-primary">Selesai & Close</button>
				                	';
								}
								?>
													
							<?php
								echo form_close();
							?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pemeriksaanModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success modal-lg">
        <div class="modal-content">
            <form action="#" id="formPemeriksaan" class="formPemeriksaan">
		        <div class="modal-header">
		            <h3 class="modal-title">Input Pemeriksaan</h3>
		            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                <span aria-hidden="true">&times;</span>
		            </button>
		        </div>
		        <div class="modal-body">
		        	<div class="form-group row"  style="display: none;>
						<p class="col-sm-2 form-control-label text-right" id="nmdokter"><b>Dokter *</b></p>
						<div class="col-sm-10">
							<div class="form-inline">
								<div class="form-group">
									<select id="id_dokter" class="form-control js-example-basic-single" name="id_dokter" required="">
										<option value="" disabled selected="">-Pilih Dokter-</option>
										<?php 
											foreach($dokter as $row){
												if($row->nm_dokter=="SMF RADIOLOGI"){
													echo '<option value="'.$row->id_dokter.'" selected>'.$row->nm_dokter.'</option>';
												}else{
													echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
												}
											}
										?>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
		                <div class="col-md-12">
		                	<div class="card b-all shadow-none">
		                        <div class="card-block">
								<?php
								foreach($data_jenis_rad as $row1){
									echo '
										<div class="form-group row">
					                    	<p class="col-sm-12 form-control-label" id="nmdokter"><b>'.$row1->nama_jenis.'</b></p>
					                    ';
					                foreach($tindakan as $row2){
										//echo '<div class="col-xs-3" style="background:#000000;border-style: dashed;">';
										if($row1->kode_jenis==substr($row2->idtindakan,0,2)){
											echo "<div class='col-sm-3' style='margin: 10px 0px 10px 0px;'> 
											<input type='checkbox' name='myCheckboxes[]' id='myCheckboxes' value='".$row2->idtindakan."' /> ".$row2->nmtindakan."</div>";
										}
									}
									echo '</div>
						                <div>
						                    <hr class="m-t-0">
						                </div>';
								}
								?>
								</div>
							</div>
						</div>
					</div>
		        </div>
		        <div class="modal-footer">
		            <button type="button" id="submit" onclick="save_banyak_data()" class="btn btn-primary">Save</button>
		            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		        </div>
				<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kunj">
				<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
				<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
				<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
				<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
				<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
				<input type="hidden" class="form-control" value="<?php echo $tgl_periksa;?>" name="tgl_periksa">
				<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">	
				<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
            </form>
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