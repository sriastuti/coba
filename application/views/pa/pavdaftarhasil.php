<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?> 

<script src="<?php echo site_url('assets/plugins/ckeditor/ckeditor.js'); ?>"></script>
<script type='text/javascript'>
//-----------------------------------------------Data Table
$(document).ready(function() {
    // $('#example').DataTable({
    // 	"aLengthMenu": [100]
    // });
    CKEDITOR.replace('makroskopik');
    CKEDITOR.replace('mikroskopik');
	<?php if($jenis_blanko==2){ ?>
    CKEDITOR.replace('saran');
	<?php } ?>
    CKEDITOR.replace('kesimpulan');
} );
//---------------------------------------------------------

		
function isi_value(isi_value, id) {
	document.getElementById(id).value = isi_value;
}	
var site = "<?php echo site_url();?>";
function simpan_hasil(id) {
	var x = document.getElementById(id).value;
	dataString = 'id='+id+'&val='+x;
	$.ajax({
        type: "GET",
        url:"<?php echo base_url('pa/pacpengisianhasil/simpan_hasil')?>",
		data: dataString,
        cache: false,
        success: function(html) {	
            location.reload();
        }
    });
}

function simpan(){
	swal({
	  	title: "Simpan Data",
	  	text: "Benar Akan Menyimpan Data?",
	  	type: "info",
	  	showCancelButton: true,
	  	closeOnConfirm: false,
	  	showLoaderOnConfirm: true,
	},

	function(){
		$.ajax({
			url:"<?php echo base_url('pa/pacpengisianhasil/simpan_hasil')?>",
	        type: "POST",
	        data: $('#formSave').serialize(),
	        dataType: "JSON",
	        success: function(data)
	        {

	            if(data.status) //if success close modal and reload ajax table
	            {
	    			swal({
					  	title: "Data Pemeriksaan Berhasil Disimpan.",
					  	text: "Akan menghilang dalam 3 detik.",
					  	timer: 3000,
					  	showConfirmButton: false,
					  	showCancelButton: true
					});
	                window.location.reload();
	            }


	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	         	window.location.reload();
        	}
    	});
	});
}

function edit(){
	swal({
	  	title: "Edit Data",
	  	text: "Benar Akan Menyimpan Data?",
	  	type: "info",
	  	showCancelButton: true,
	  	closeOnConfirm: false,
	  	showLoaderOnConfirm: true,
	},
	function(){
		$.ajax({
			url:"<?php echo base_url('pa/pacpengisianhasil/edit_hasil_submit')?>",
	        type: "POST",
	        data: $('#formEdit').serialize(),
	        dataType: "JSON",
	        success: function(data)
	        {

	            if(data.status) //if success close modal and reload ajax table
	            {
	            	// $('#myCheckboxes').iCheck('uncheck');
	                // $('#pemeriksaanModal').modal('hide');
	                // $("#form_table").load("<?php echo base_url('pa/pacpengisianhasil/daftar_hasil').'/'.$no_pa;?> #form_table");
	    			// swal("Data Pemeriksaan Berhasil Disimpan.");

	    			swal({
					  	title: "Data Pemeriksaan Berhasil Diedit.",
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

</script>
<?php include('pavdatapasien.php');
$itot=0;?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Pengisian Hasil Tes Patologi Anatomi : <?php echo $no_pa_tindakan; ?></h4>
            </div>
            <div class="card-block">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
								<?php 
								
									echo form_open('pa/pacpengisianhasil/simpan_hasil');
								?>
									<table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
											  <th>No</th>
											  <th>Nama Pemeriksaan</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$i=1;
												foreach($daftarpengisian as $row){
											?>
												<tr>
												  	<td><?php echo $i;?>
													</td>
												  	<td><?php echo $row->jenis_tindakan;?></td>
												</tr>
											<?php
													$i++;
												}
											?>
										</tbody>
									</table>	
									<div class="form-inline" align="right"><br>
										<input type="hidden" class="form-control" value="<?php echo $id_pemeriksaan_pa;?>" name="id_pemeriksaan_pa">
										<input type="hidden" class="form-control" value="<?php echo $no_pa;?>" name="no_pa">
										<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									</div>	
									<div>
					                    <hr class="m-t-20">
					                </div>
									<?php  
										if($jenis_blanko==1){ //1=histo 2=sito
											// $js = json_encode($hasil);
											// echo $js;
											// if($js != "null"){
											// 	echo json_decode($hasil);
											// }else{
											// 	;
											// }
									?>
									<div class="form-group row">
										<p class="col-sm-3 form-control-label" id="lbl_topologi">Topologi</p>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="topologi" id="topologi" value="<?php if($jenis=='tidak' && json_encode($hasil)!='null')echo $hasil->topologi; else echo ''?>">
										</div>
									</div>
									
									<div class="form-group row">
										<p class="col-sm-3 form-control-label" id="lbl_morfologi">Morfologi</p>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="morfologi" id="morfologi" value="<?php if($jenis=='tidak' && json_encode($hasil)!='null')echo $hasil->morfologi; else echo ''?>">
										</div>
									</div>

									<div class="form-group row">
										<p class="col-sm-3 form-control-label" id="lbl_diagnosa">Diagnosa</p>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="diagnosa" id="diagnosa" value="<?php if($jenis=='tidak' && json_encode($hasil)!='null')echo $hasil->diagnosa; else echo ''?>">
										</div>
									</div>
									<?php  
										}
									?>
									
									<div class="form-group row">
										<p class="col-sm-3 form-control-label" id="lbl_makroskopik">Makroskopik</p>
										<div class="col-sm-8">
											<textarea class="form-control" rows="10" cols="80" name="makroskopik" id="makroskopik" ><?php if($jenis=='tidak' && json_encode($hasil)!='null')echo $hasil->makroskopik; else echo ''?></textarea>
										</div>
									</div>
									
									<div class="form-group row">
										<p class="col-sm-3 form-control-label" id="lbl_mikroskopik">Mikroskopik</p>
										<div class="col-sm-8">
											<textarea class="form-control" rows="10" cols="80" name="mikroskopik" id="mikroskopik" ><?php if($jenis=='tidak' && json_encode($hasil)!='null')echo $hasil->mikroskopik; else echo '' ?></textarea>
										</div>
									</div>
									
									<div class="form-group row">
										<p class="col-sm-3 form-control-label" id="lbl_kesimpulan">Kesimpulan</p>
										<div class="col-sm-8">
											<textarea class="form-control" rows="10" cols="80" name="kesimpulan" id="kesimpulan" ><?php if($jenis=='tidak' && json_encode($hasil)!='null')echo $hasil->kesimpulan; else echo ''?></textarea>
		                                    <input name="ganas" type="radio" id="ganas_1" value="0" <?php if($jenis=='tidak' && json_encode($hasil)!='null')if($hasil->ganas==0)echo 'checked'; ?> />
		                                    <label for="ganas_1">Tidak Ganas</label>
		                                    <input name="ganas" type="radio" id="ganas_2" value="1" <?php if($jenis=='tidak' && json_encode($hasil)!='null')if($hasil->ganas==1)echo 'checked'; ?> />
		                                    <label for="ganas_2">Ganas</label>

										</div>
									</div>
									
									<?php  
										if($jenis_blanko==2){
									?>
									<div class="form-group row">
										<p class="col-sm-3 form-control-label" id="lbl_saran">Saran</p>
										<div class="col-sm-8">
											<textarea class="form-control" rows="10" cols="80" name="saran" id="saran" ><?php if($jenis=='tidak' && json_encode($hasil)!='null')echo $hasil->saran; else echo ''?></textarea>
										</div>
									</div>
									<?php  
										}
									?>

									<div class="col-md-12" align="right">
				                		<button type="submit" id="submit" class="btn btn-info"><?php if($jenis=='isi')echo 'Simpan';else echo 'Edit';?></button>
					                </div>

								<?php 
									echo form_close();
								?>
							</div>
                        </div>
            		</div>
					<?php  if($jenis != 'isi'){

						echo form_open('pa/pacpengisianhasil/st_cetak_hasil_pa');
					?>
							<div>
			                    <hr class="m-t-20">
			                </div>
							<select hidden id="id_pemeriksaan_pa" class="form-control" name="id_pemeriksaan_pa"  required>
								<?php 
									echo "<option value='$id_pemeriksaan_pa' selected>$id_pemeriksaan_pa</option>";
								?>
							</select>
							<!--<a href="<?php //echo site_url('irj/rjckwitansi/st_cetak_kwitansi_kt/'.$no_pa);?>"><input type="button" class="btn btn-primary btn-sm" id="btn_simpan" value="Cetak"></a>-->

							<div class="col-md-12">
								<button type="submit" class="btn btn-danger btn-block">Cetak Hasil</button>
			                </div>
					<?php 
						echo form_close();
					}
					?>
            	</div>
            </div>
        </div>
    </div>
</div>


<?php
	$this->load->view('layout/footer_left.php');
?>