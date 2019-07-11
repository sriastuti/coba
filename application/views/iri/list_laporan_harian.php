<?php 
  if ($role_id == 1) {
    $this->load->view("layout/header_left");
  } else {
    $this->load->view("layout/header_horizontal");
  }
?>
<script type='text/javascript'>
$(function() {
	 
	$('#date_picker1').datepicker({
				format: "yyyy-mm-dd",
				//endDate: "current",
				autoclose: true,
				todayHighlight: true,
		});
	// $('#date_picker2').datepicker({
	// 			format: "yyyy-mm-dd",
	// 			//endDate: "current",
	// 			autoclose: true,
	// 			todayHighlight: true,
	// 	});
	
	$('#date_picker_months').datepicker({
		format: "yyyy-mm",
		//endDate: "current",
		autoclose: true,
		todayHighlight: true,
		viewMode: "months", 
		minViewMode: "months",
	}); 
	$('#date_picker_years').datepicker({
		format: "yyyy",
		//endDate: "current",
		autoclose: true,
		todayHighlight: true,
		format: "yyyy",
		viewMode: "years", 
		minViewMode: "years",
	});
	$('#date_picker1').show();
	// $('#date_picker2').show();
	$('#date_picker_months').hide();
	$('#date_picker_years').hide();

	
});	
function cek_tgl_awal(tgl_awal){
		//var tgl_akhir=document.getElementById("date_picker2").value;
		var tgl_akhir=$('#date_picker2').val();
		if(tgl_akhir==''){
		//none :D just none
		}else if(tgl_akhir<tgl_awal){
			$('#date_picker2').val('');
			//document.getElementById("date_picker2").value = '';
		}
	}
	function cek_tgl_akhir(tgl_akhir){
		//var tgl_awal=document.getElementById("date_picker1").value;
		var tgl_awal=$('#date_picker1').val();
		if(tgl_akhir<tgl_awal){
			$('#date_picker1').val('');
			//document.getElementById("date_picker1").value = '';
		}
	}
	function cek_tampil_per(val_tampil_per){
		if(val_tampil_per=='TGL'){
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker1").required = true;
			// document.getElementById("date_picker2").required = true;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker1').show();
			// $('#date_picker2').show();
			$('#date_picker_months').hide();
			$('#date_picker_years').hide();
		}else if(val_tampil_per=='BLN'){
			document.getElementById("date_picker1").value = '';
			// document.getElementById("date_picker2").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker1").required = false;
			// document.getElementById("date_picker2").required = false;
			document.getElementById("date_picker_months").required = true;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker1').hide();
			// $('#date_picker2').hide();
			$('#date_picker_months').show();
			$('#date_picker_years').hide();
		}else{
			document.getElementById("date_picker1").value = '';
			// document.getElementById("date_picker2").value = '';
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker1").required = false;
			// document.getElementById("date_picker2").required = false;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = true;
			$('#date_picker1').hide();
			// $('#date_picker2').hide();
			$('#date_picker_months').hide();
			$('#date_picker_years').show();
		}
	}

</script>

<div >
	<div >
			
		<div class="container-fluid">

		<div class="row">
			<div class="col-lg-12 col-md-12">	
				<div style="background: #e4efe0">
					<div class="inner">
						<div class="container-fluid"><br>
							<form action="<?php echo base_url();?>iri/riclaporan/index" method="post" accept-charset="utf-8">
							<div class="col-lg-10">
								<div class="form-inline">
									<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
									<option value="TGL">Tanggal</option>
									<option value="BLN">Bulan</option>
									<!-- <option value="THN">Tahun</option> -->
									</select>
								<!-- <input type="text" id="date_picker1" class="form-control" placeholder="Tanggal Awal" name="tgl_awal" onchange="cek_tgl_awal(this.value)" required>
								<input type="text" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="tgl_akhir" onchange="cek_tgl_akhir(this.value)" required> -->
								<input type="text" id="date_picker1" class="form-control" placeholder="Pilih Tanggal" name="tgl_awal" required>
								<input type="text" id="date_picker_months" class="form-control" placeholder="yyyy-mm" name="bulan">
								<input type="text" id="date_picker_years" class="form-control" placeholder="yyyy" name="tahun">
								<button class="btn btn-primary" type="submit">Cari</button>
								
							</div>
						</div><!-- /inline -->
					
					</form>		
				</div>						
			</div>
		</div></div></div>
		<br>

		<section class="content">
				<div class="row">
						<div class="card " style="overflow:auto;">
							<div class="card-block">
								<br/>
						<div class="" >
						<table class="table table-hover table-striped table-bordered table-responsive" id="dataTables-example"  cellspacing="0" width="98%" style="display: block;overflow:auto;">
						  <thead>
							<tr>
								<th>Tanggal</th>
								<th>No Medrec</th>
								<th>No Register</th>
								<th>Nama</th>
								<th>Diagnosa Utama</th>
								<th>Jenis Kelamin</th>
								<th>Alamat</th>
								<th>Status</th>
								<th>Penjamin</th>
								<th>Ruangan</th>
								<th>Poli</th>
								<th>Kesatuan</th>
								<th>Petugas</th>
							</tr>
						  </thead>
						  	<tbody>
						  	<?php
						  	$tanggal = '';
						  	foreach ($list_keluar_masuk as $r) { 
						  		$tanggal = $r['tgl'];
						  	?>
						  	<tr>
						  		<td><?php echo $r['tgl']?></td>
						  		<td><?php echo $r['no_cm']?></td>
						  		<td><?php echo $r['no_ipd']?></td>
						  		<td><?php echo $r['nama']?></td>
						  		<td><?php echo $r['id_icd']." - ".$r['nm_diagnosa']?></td>
						  		<td><?php echo $r['sex']?></td>
						  		<td><?php echo $r['alamat']?></td>
						  		<td><?php echo $r['tipe_masuk']?></td>
						  		<td><?php echo $r['nmkontraktor']?></td>
						  		<td><?php echo $r['nmruang']?></td>
						  		<td><?php echo $r['id_poli']." | ".$r['nm_poli']?></td>
						  		<td><?php echo $r['kst_nama']?></td>
						  		<td><?php echo $r['xuser']?></td>

						  	</tr>
						  	<?php
						  	}
						  	?>
							</tbody>
						</table>
						<hr>
						<?php if ($list_keluar_masuk != NULL) { ?>
						<div class="form-inline" align="right">
							<div class="form-group">
								<a target="_blank" href="<?php echo site_url('iri/riclaporan/cetak_laporan_kunjungan_harian/');?><?php echo '/'.$tanggal ;?>"><input type="button" class="btn 
								btn-primary" value="PDF"></a>
								<a target="_blank" href="<?php echo site_url('iri/riclaporan/cetak_laporan_kunjungan_harian_excel/');?><?php echo '/'.$tanggal ;?>"><input type="button" class="btn 
								btn-warning" value="Excel"></a>
							</div>
						</div>
						<?php } ?>
						</div><!-- style overflow -->
					</div><!--- end panel body -->
				</div><!--- end panel -->
				</div><!--- end panel -->
		</section>
		<!-- /Main content -->
		
	</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable( {
			
		});
	});
	$('#calendar-tgl').datepicker();
</script>
<?php 
  if ($role_id == 1) {
    $this->load->view("layout/footer_left");
  } else {
    $this->load->view("layout/footer_horizontal");
  }
?>