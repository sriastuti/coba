<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?> 
<link rel="stylesheet" href="<?php echo site_url('asset/plugins/iCheck/flat/green.css'); ?>">
<script src="<?php echo site_url('asset/plugins/iCheck/icheck.min.js'); ?>"></script>
    <link href="<?php echo site_url(); ?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <script src="<?php echo site_url(); ?>assets/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
<script type='text/javascript'>

	//-----------------------------------------------Data Table
	$(document).ready(function() {
		$("#biaya_pa").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$("#vtot").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$('input').iCheck({
	    	checkboxClass: 'icheckbox_flat-green'
	  	});
	});
	//---------------------------------------------------------

	var site = "<?php echo site_url();?>";
			
	function pilih_tindakan_h(id_tindakan) {
		$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('pa/pacdaftar/get_biaya_tindakan')?>",
			data: {
				id_tindakan: id_tindakan,
				kelas : "<?php echo $kelas_pasien ?>"
			},
			success: function(data){
				$('#biaya_pa_h').val(data);
				$('#biaya_pa_hide_h').val(data);
				$('#qty_h').val('1');
				set_total_h();
			},
			error: function(){
				alert("gagal ambil harga");
			}
	    });
	}
			
	function pilih_tindakan_s(id_tindakan) {
		$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('pa/pacdaftar/get_biaya_tindakan')?>",
			data: {
				id_tindakan: id_tindakan,
				kelas : "<?php echo $kelas_pasien ?>"
			},
			success: function(data){
				$('#biaya_pa_s').val(data);
				$('#biaya_pa_hide_s').val(data);
				$('#qty_s').val('1');
				set_total_s();
			},
			error: function(){
				alert("gagal ambil harga");
			}
	    });
	}

	function set_total_s() {
		var total = $("#biaya_pa_s").val() * $("#qty_s").val();	
		$('#vtot_s').val(total);
		$('#vtot_hide_s').val(total);
	}

	function set_total_h() {
		var total = $("#biaya_pa_h").val() * $("#qty_h").val();	
		$('#vtot_h').val(total);
		$('#vtot_hide_h').val(total);
	}

	function hapus_data_pemeriksaan(id_pemeriksaan_pa)
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
				url:"<?php echo base_url('pa/pacdaftar/hapus_data_pemeriksaan')?>/"+id_pemeriksaan_pa,
		        success: function(data)
		        {
		           	if(data.status) //if success close modal and reload ajax table
		            {
		            	// $('#myCheckboxes').iCheck('uncheck');
		                // $('#pemeriksaanModal').modal('hide');
		                $("#tabel_pa").load("<?php echo base_url('pa/pacdaftar/pemeriksaan_pa').'/'.$no_register;?> #tabel_pa");
		    			// swal("Data Pemeriksaan Berhasil Dihapus.");

		    			swal({
						  	title: "Data Pemeriksaan Berhasil Dihapus.",
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
		            alert('Error hapus / hapus data');
		        }
		    });
		});
	}

	function save(jenis){
		swal({
		  	title: "Tambah Data",
		  	text: "Benar Akan Menyimpan Data?",
		  	type: "info",
		  	showCancelButton: true,
		  	closeOnConfirm: false,
		  	showLoaderOnConfirm: true,
		},
		function(){
			if(jenis=='1'){
				$.ajax({
					url:"<?php echo base_url('pa/pacdaftar/insert_pemeriksaan')?>",
			        type: "POST",
			        data: $('#formInsertPemeriksaanHisto').serialize(),
			        dataType: "JSON",
			        success: function(data)
			        {

			            if(data.status) //if success close modal and reload ajax table
			            {
			            	// $('#myCheckboxes').iCheck('uncheck');
			                // $('#pemeriksaanModal').modal('hide');
			                $("#tabel_pa").load("<?php echo base_url('pa/pacdaftar/pemeriksaan_pa').'/'.$no_register;?> #tabel_pa");
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
			        	alert(textStatus);
			         	// window.location.reload();
		        	}
		    	});
			}else{
				$.ajax({
					url:"<?php echo base_url('pa/pacdaftar/insert_pemeriksaan')?>",
			        type: "POST",
			        data: $('#formInsertPemeriksaanSito').serialize(),
			        dataType: "JSON",
			        success: function(data)
			        {

			            if(data.status) //if success close modal and reload ajax table
			            {
			            	// $('#myCheckboxes').iCheck('uncheck');
			                // $('#pemeriksaanModal').modal('hide');
			                $("#tabel_pa").load("<?php echo base_url('pa/pacdaftar/pemeriksaan_pa').'/'.$no_register;?> #tabel_pa");
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
			        	alert(textStatus);
			         	// window.location.reload();
		        	}
		    	});
			}
			
		});
	}

	function cetak_blanko(id_pemeriksaan_pa) {
		window.open("<?php echo base_url('pa/pacdaftar/cetak_blanko')?>/"+id_pemeriksaan_pa, "_blank")
	}

	function closepage() {
		window.open(' ', '_self', ' '); window.close();
	}


</script>	
<?php include('pavdatapasien.php');?>

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
                        	<div class="card">
	                            <div class="card-block p-b-0">
	                                <h4 class="card-title">Blanko Patologi Anatomi</h4>
	                                <h6 class="card-subtitle">Pilih sesuai jenis pemeriksaan <code>PA</code></h6>
	                                <!-- Nav tabs -->
	                                <ul class="nav nav-tabs customtab2" role="tablist">
	                                    <li class="nav-item"> 
	                                    	<a class="nav-link active" data-toggle="tab" href="#histopatologi" role="tab" aria-expanded="true">
	                                    		<span class="hidden-sm-up">
	                                    			<i class="ti-home"></i>
	                                    		</span> 
	                                    		<span class="hidden-xs-down">Histopatologi</span>
	                                    	</a> 
	                                    </li>
	                                    <li class="nav-item"> 
	                                    	<a class="nav-link" data-toggle="tab" href="#sitologi" role="tab" aria-expanded="false">
	                                    		<span class="hidden-sm-up">
	                                    			<i class="ti-user"></i>
	                                    		</span> 
	                                    		<span class="hidden-xs-down">Sitologi</span>
	                                    	</a> 
	                                    </li>
	                                </ul>
	                                <!-- Tab panes -->
	                                <div class="tab-content">
	                                    <div class="tab-pane active" id="histopatologi" role="tabpanel" aria-expanded="true">
										<?php 
											$attributes = array('id' => 'formInsertPemeriksaanHisto', 'class' => 'form-horizontal');
											echo form_open('pa/pacdaftar/insert_pemeriksaan', $attributes); 
										?>
                                			<div class="card-block">
	                                        	<div class="form-group row">
													<label class="control-label text-right col-md-3">Jenis Sediaan</label>
													<div class="col-md-9">
														<select id="jenis_sediaan" class="selectpicker" name="jenis_sediaan">
															<option value="" disabled selected="">-Pilih Jenis Sediaan-</option>
															<option value="Eksisi percobaan">Eksisi percobaan</option>
															<option value="kerokan">kerokan</option>
															<option value="operasi">operasi</option>
															<option value="Biopsi jarum">Biopsi jarum</option>
															<option value="dll">dll</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="control-label text-right col-md-3">Lokasi Jaringan</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="lokasi_jaringan" id="lokasi_jaringan">
													</div>
												</div>
	                                        	<div class="form-group row">
													<label class="control-label text-right col-md-3">Cairan Fiksasi</label>
													<div class="col-md-9">
														<select id="cairan_fiksasi" class="selectpicker" name="cairan_fiksasi">
															<option value="" disabled selected="">-Pilih Cairan Fiksasi-</option>
															<option value="Formalin 10%">Formalin 10%</option>
															<option value="formaldehyde 4%">formaldehyde 4%</option>
															<option value="Alcohol 70%">Alcohol 70%</option>
															<option value="dll">dll</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="control-label text-right col-md-3">Diagnosa Klinik</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="diagnosa_klinik" id="diagnosa_klinik">
													</div>
												</div>
												<div class="form-group row">
													<label class="control-label text-right col-md-3">Keterangan Klinik</label>
													<div class="col-md-9">
														<div class="controls">
                                            				<textarea name="keterangan_klinik" id="keterangan_klinik" class="form-control" required="" placeholder="(Jelas dan lengkap, jika kerokan endometrium agar disebutkan tanggal haid terakhir)" aria-invalid="false" rows="5"></textarea>
                                        					<!-- <div class="help-block"></div> -->
                                        				</div>
													</div>
												</div>

						                        <div class="col-md-12">
						                        	<div class="card b-all shadow-none">
						                                <!-- <div class="card-block">
						                    				<button type="button" class="btn btn-primary box-title" data-toggle="modal" data-target="#pemeriksaanModal">Add Pemeriksaan</button>
						                                </div> -->
						                                <div>
						                                    <hr class="m-t-0">
						                                </div>
						                                <div class="card-block">
															<div class="form-group row">
																<label class="control-label text-right col-md-2" id="nmdokter">Dokter</label>
																	<div class="col-sm-10">
																		<div class="form-group">
																			<select id="id_dokter_h" class="form-control js-example-basic-single" name="id_dokter_h" style="width: 100%" required>
																				<option value="" disabled selected="">-Pilih Dokter-</option>
																				<?php 
																					foreach($dokter as $row){
																						if($row->nm_dokter=="SMF PATOLOGI ANATOMI"){
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
																		<!-- <div class="form-inline"> -->
																			<!--
																			<input type="search" style="width:100%" class="auto_search_tindakan form-control" placeholder="" id="nmtindakan" name="nmtindakan" required>
																			<input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan"  name="idtindakan">
																			-->
																			<div class="form-group">
																				<select id="idtindakan_h" class="form-control js-example-basic-single" name="idtindakan_h" onchange="pilih_tindakan_h(this.value)" style="width: 100%" required="">
																					<option value="" disabled selected="">-Pilih Pemeriksaan-</option>
																					<?php 
																						foreach($tindakan_histo as $row){
																							echo '<option value="'.$row->idtindakan.'">'.$row->nmtindakan.'</option>';
																						}
																					?>
																				</select>
																			</div>
																		<!-- </div> -->
																	</div>
															</div>
															<div class="form-group row">
																<label class="control-label text-right col-md-2" id="lbl_biaya_periksa">Biaya Pemeriksaan</label>
																<div class="col-sm-3">
																	<div class="input-group">
																		<span class="input-group-addon">Rp</span>
																		<input type="text" class="form-control" value="<?php //echo $biaya_pa; ?>" name="biaya_pa_h" id="biaya_pa_h" disabled>
																		<input type="hidden" class="form-control" value="" name="biaya_pa_hide_h" id="biaya_pa_hide_h">
																	</div>
																</div>
															</div>
															<div class="form-group row">
																<label class="control-label text-right col-md-2" id="lbl_qty">Qtyind</label>
																<div class="col-sm-3">
																	<input type="number" class="form-control" name="qty_h" id="qty_h" min=1 onchange="set_total_h(this.value)">
																</div>
															</div>
															<div class="form-group row">
																<label class="control-label text-right col-md-2" id="lbl_vtot">Total</label>
																<div class="col-sm-3">
																	<div class="input-group">
																		<span class="input-group-addon">Rp</span>
																		<input type="text" class="form-control" name="vtot_h" id="vtot_h" disabled>
																		<input type="hidden" class="form-control" value="" name="vtot_hide_h" id="vtot_hide_h">
																	</div>
																</div>
															</div>
						                                </div>
						                                <div>
						                                    <hr class="m-t-0">
						                                </div>
						                                <div class="card-block">
						                                	<input type="hidden" class="form-control" value="1" name="jenis_blanko">
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
										                	<button type="button" id="submit" onclick="save(1)" class="btn btn-success">Simpan</button>
						                                </div>
						                            </div>
						                        </div>
											</div>
										<?php
											echo form_close();
										?>
	                                    </div>
	                                    <div class="tab-pane" id="sitologi" role="tabpanel" aria-expanded="false">
										<?php 
											$attributes = array('id' => 'formInsertPemeriksaanSito', 'class' => 'form-horizontal');
											echo form_open('pa/pacdaftar/insert_pemeriksaan', $attributes); 
										?>
                                			<div class="card-block">
	                                        	<div class="form-group row">
													<label class="control-label text-right col-md-3">Bahan Sediaan</label>
													<div class="col-md-9">
														<select id="bahan_sediaan" class="selectpicker" name="bahan_sediaan">
															<option value="" disabled selected="">-Pilih Bahan Sediaan-</option>
															<option value="Vagina">Vagina</option>
															<option value="Ektoserviks">Ektoserviks</option>
															<option value="Endoserviks">Endoserviks</option>
															<option value="Kavum Uteri">Kavum Uteri</option>
															<option value="Ascites">Ascites</option>
															<option value="Sputum">Sputum</option>
															<option value="Bilasan Bron-chus">Bilasan Bron-chus</option>
															<option value="Cairan Pleura">Cairan Pleura</option>
															<option value="Urine">Urine</option>
															<option value="dll">dll</option>
														</select>
													</div>
												</div>
	                                        	<div class="form-group row">
													<label class="control-label text-right col-md-3">Cara Pengambilan</label>
													<div class="col-md-9">
														<select id="cara_pengambilan" class="selectpicker" name="cara_pengambilan">
															<option value="" disabled selected="">-Pilih Cara Pengambilan-</option>
															<option value="Apusan">Apusan</option>
															<option value="Sikatan">Sikatan</option>
															<option value="Pungsi">Pungsi</option>
															<option value="Aspirasi">Aspirasi</option>
															<option value="dll">dll</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="control-label text-right col-md-3">Tanggal Pengambilan</label>
													<div class="col-md-9">
														<input type="date" class="form-control" name="tanggal_pengambilan" id="tanggal_pengambilan">
													</div>
												</div>
	                                        	<div class="form-group row">
													<label class="control-label text-right col-md-3">Cairan Fiksasi</label>
													<div class="col-md-9">
														<select id="cairan_fiksasi" class="selectpicker" name="cairan_fiksasi">
															<option value="" disabled selected="">-Pilih Cairan Fiksasi-</option>
															<option value="Alcohol 70%">Alcohol 95%</option>
															<option value="dll">dll</option>
														</select>
													</div>
												</div>
												<hr>
												<div class="form-group row">
													<label class="control-label text-right col-md-3">Diagnosa Klinik</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="diagnosa_klinik" id="diagnosa_klinik">
													</div>
												</div>
												<hr>
												<div class="form-group row">
													<label class="control-label text-right col-md-3">Keterangan Klinik</label>
													<div class="col-md-9">
														<div class="controls">
                                            				<textarea name="keterangan_klinik" id="keterangan_klinik" class="form-control" required="" aria-invalid="false" rows="5"></textarea>
                                        					<div class="help-block"></div>
                                        				</div>
													</div>
												</div>
	                                        	<div class="form-group row">
													<label class="control-label text-right col-md-3">Genekologik</label>
													<div class="col-md-9">
														<select id="genekologik" class="selectpicker" name="genekologik">
															<option value="Tidak ada kelainan Non - Genekologik">Tidak ada kelainan Non - Genekologik</option>
															<option value="Flour Albus">Flour Albus</option>
															<option value="Erosi">Erosi</option>
															<option value="Bercak Putih">Bercak Putih</option>
															<option value="Perdarahan persetubuhan">Perdarahan persetubuhan</option>
															<option value="Perdarahan Menopause">Perdarahan Menopause</option>
															<option value="Kelainan Mencurigakan">Kelainan Mencurigakan</option>
															<option value="dll">dll</option>
														</select>
													</div>
												</div>
												<hr>
	                                        	<div class="form-group row">
													<label class="control-label text-right col-md-3">Status Perkawinan</label>
													<div class="col-md-3">
														<select id="status_perkawinan" class="selectpicker" name="status_perkawinan">
															<option value="" disabled selected="">-Pilih Status Perkawinan-</option>
															<option value="Ya">Ya</option>
															<option value="Tidak">Tidak</option>
															<option value="Pernah">Pernah</option>
														</select>
													</div>
													<label class="control-label text-right col-md-3">Hari -1 haid terakhir</label>
													<div class="col-md-3">
														<input type="date" class="form-control" name="haidminsatu" id="haidminsatu">
													</div>
												</div>
												<div class="form-group row">
													<label class="control-label text-right col-md-3">Lama Kawin</label>
													<div class="col-md-3">
														<input type="text" class="form-control" name="lama_kawin" id="lama_kawin" placeholder="tahun">
													</div>
													<label class="control-label text-right col-md-3">Siklus Haid</label>
													<div class="col-md-3">
														<input type="text" class="form-control" name="siklus_haid" id="siklus_haid" placeholder="hari">
													</div>
												</div>
												<div class="form-group row">
													<label class="control-label text-right col-md-3">Perkawinan</label>
													<div class="col-md-3">
														<input type="text" class="form-control" name="perkawinan" id="perkawinan" placeholder="kali">
													</div>
													<label class="control-label text-right col-md-3">Paritas</label>
													<div class="col-md-3">
														<input type="text" class="form-control" name="paritas" id="paritas" placeholder="">
													</div>
												</div>
	                                        	<div class="form-group row">
													<label class="control-label text-right col-md-3">Kontrasepsi</label>
													<div class="col-md-3">
														<select id="kontrasepsi" class="selectpicker" name="kontrasepsi">
															<option value="" disabled selected="">-Pilih Kontrasepsi-</option>
															<option value="Pil">Pil</option>
															<option value="Suntik">Suntik</option>
															<option value="AKDR">AKDR</option>
															<option value="dll">dll</option>
														</select>
													</div>
													<label class="control-label text-right col-md-3">Menopause</label>
													<div class="col-md-3">
														<select id="menopause" class="selectpicker" name="menopause">
															<option value="" disabled selected="">-Pilih Kontrasepsi-</option>
															<option value="Ya">Ya</option>
															<option value="Tidak">Tidak</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="control-label text-right col-md-3">Terapi</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="terapi" id="terapi" placeholder="Operasi ......../ Hormonal ......../ Radiasi ......../">
													</div>
												</div>
												<hr>
												<div class="form-group row">
													<label class="control-label text-right col-md-3">Sifat pertanyaan</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="sifat_pertanyaan" id="sifat_pertanyaan" placeholder="KEGANASAN HORMONAL / ..........">
													</div>
												</div>

						                        <div class="col-md-12">
						                        	<div class="card b-all shadow-none">
						                                <!-- <div class="card-block">
						                    				<button type="button" class="btn btn-primary box-title" data-toggle="modal" data-target="#pemeriksaanModal">Add Pemeriksaan</button>
						                                </div> -->
						                                <div>
						                                    <hr class="m-t-0">
						                                </div>
						                                <div class="card-block">
															<div class="form-group row">
																<label class="control-label text-right col-md-2" id="nmdokter">Dokter</label>
																<div class="col-sm-10">
																	<select id="id_dokter_s" class="js-example-basic-single" name="id_dokter_s" style="width: 100%" required>
																		<option value="" disabled selected="">-Pilih Dokter-</option>
																		<?php 
																			foreach($dokter as $row){
																				if($row->nm_dokter=="SMF PATOLOGI ANATOMI"){
																					echo '<option value="'.$row->id_dokter.'" selected>'.$row->nm_dokter.'</option>';
																				}else{
																					echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
																				}
																			}
																		?>
																	</select>
																</div>
															</div>
															<div class="form-group row">
																<label class="control-label text-right col-md-2" id="tindakan">Pemeriksaan</label>
																<div class="col-sm-10">
																	<select id="idtindakan_s" class="js-example-basic-single" name="idtindakan_s" onchange="pilih_tindakan_s(this.value)" style="width: 100%" required="">
																		<option value="" disabled selected="">-Pilih Pemeriksaan-</option>
																		<?php 
																			foreach($tindakan_sito as $row){
																				echo '<option value="'.$row->idtindakan.'">'.$row->nmtindakan.'</option>';
																			}
																		?>
																	</select>
																</div>
															</div>
															<div class="form-group row">
																<label class="control-label text-right col-md-2" id="lbl_biaya_periksa">Biaya Pemeriksaan</label>
																<div class="col-sm-3">
																	<div class="input-group">
																		<span class="input-group-addon">Rp</span>
																		<input type="text" class="form-control" value="<?php //echo $biaya_pa; ?>" name="biaya_pa_s" id="biaya_pa_s" disabled>
																		<input type="hidden" class="form-control" value="" name="biaya_pa_hide_s" id="biaya_pa_hide_s">
																	</div>
																</div>
															</div>
															<div class="form-group row">
																<label class="control-label text-right col-md-2" id="lbl_qty">Qtyind</label>
																<div class="col-sm-3">
																	<input type="number" class="form-control" name="qty_s" id="qty_s" min=1 onchange="set_total_s(this.value)">
																</div>
															</div>
															<div class="form-group row">
																<label class="control-label text-right col-md-2" id="lbl_vtot">Total</label>
																<div class="col-sm-3">
																	<div class="input-group">
																		<span class="input-group-addon">Rp</span>
																		<input type="text" class="form-control" name="vtot_s" id="vtot_s" disabled>
																		<input type="hidden" class="form-control" value="" name="vtot_hide_s" id="vtot_hide_s">
																	</div>
																</div>
															</div>
						                                </div>
						                                <div>
						                                    <hr class="m-t-0">
						                                </div>
						                                <div class="card-block">
						                                	<input type="hidden" class="form-control" value="2" name="jenis_blanko">
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
										                	<button type="button" id="submit" onclick="save(2)" class="btn btn-success">Simpan</button>
						                                </div>
						                            </div>
						                        </div>
											</div>
	                                    </div>
										<?php
											echo form_close();
										?>
	                                </div>
	                            </div>
	                        </div>
                        </div>
                    </div>
                    <h3 class="m-t-20 box-title">Tabel Pemeriksaan</h3>
                    <hr class="m-t-20 m-b-20">
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
			                    <table id="tabel_pa" class="table display table-bordered table-striped">
			                        <thead>
										<tr>
										  	<th>No</th>
										  	<th>No PA</th>
										  	<th>Tanggal Pemeriksaan</th>
										  	<th>Dokter</th>
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
												<td><?php echo $row->no_pa_tindakan ; ?></td>
												<td><?php echo $row->xupdate ; ?></td>
												<td><?php echo $row->nm_dokter.' ('.$row->id_dokter.')' ; ?></td>
												<td><?php echo $row->jenis_tindakan.' ('.$row->id_tindakan.')' ; ?></td>
												<td><?php echo $row->biaya_pa ; ?></td>
												<td><?php echo $row->qty ; ?></td>
												<td><?php echo $row->vtot ; ?></td>
												<td>
													<a class="btn btn-danger btn-sm" href="javascript:void()" title="Hapus" onclick="hapus_data_pemeriksaan(<?php echo $row->id_pemeriksaan_pa ; ?>)">Hapus</a><br> &nbsp;
													<a class="btn btn-success btn-sm" href="javascript:void()" title="Cetak" onclick="cetak_blanko(<?php echo $row->id_pemeriksaan_pa ; ?>)">Cetak Blanko</a>
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
							echo form_open('pa/pacdaftar/selesai_daftar_pemeriksaan');?>
								<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
								<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">

								<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
								<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">

								<div class="form-group">
								<?php if($roleid==21 or $roleid==1){
									echo '
										<button class="btn btn-primary">Selesai & Cetak</button>
				                	';
								} 
								if($roleid<>21 or $roleid==1){
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

<script type="text/javascript">
	$(document).ready(function() {
	  $(".js-example-basic-single").select2();
	});
</script>

<?php
	$this->load->view('layout/footer_left.php');
?>