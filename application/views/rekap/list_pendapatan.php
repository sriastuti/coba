<?php 
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_horizontal");
}?>

<script type='text/javascript'>
$(function() {
	$('#calendar-tgl').datepicker();
	$('#date_picker1').datepicker({
				format: "yyyy-mm-dd",
				//endDate: "current",
				autoclose: true,
				todayHighlight: true,
		});
	$('#date_picker2').datepicker({
				format: "yyyy-mm-dd",
				//endDate: "current",
				autoclose: true,
				todayHighlight: true,
		});
	
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
	$('#date_picker2').show();
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
			document.getElementById("date_picker2").required = true;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker1').show();
			$('#date_picker_months').hide();
			$('#date_picker2').show();
			$('#date_picker_years').hide();
		}else if(val_tampil_per=='BLN'){
			document.getElementById("date_picker1").value = '';
			document.getElementById("date_picker2").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker1").required = false;
			document.getElementById("date_picker2").required = false;
			document.getElementById("date_picker_months").required = true;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker1').hide();
			//$('#date_picker2').hide();
			$('#date_picker_months').show();
			$('#date_picker_years').hide();
		}else{
			document.getElementById("date_picker1").value = '';
			document.getElementById("date_picker2").value = '';
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker1").required = false;
			document.getElementById("date_picker2").required = false;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = true;
			$('#date_picker1').hide();
			$('#date_picker2').hide();
			$('#date_picker_months').hide();
			$('#date_picker_years').show();
		}
	}

</script>

<div >
	<div >
		
		<div class="container-fluid"><br/><br/>
			<div class="inline">
				<div class="row">
					<div class="card card-block">
						<form action="<?php echo base_url();?>rekap/Rcrekap/pendapatan" method="post" accept-charset="utf-8">
						<div class="col-lg-10">
							<div class="form-inline">
								<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
									<option value="TGL">Tanggal</option>
									<!-- <option value="BLN">Bulan</option> -->
								</select>
								<input type="text" id="date_picker1" class="form-control" placeholder="Pilih Tanggal" name="tgl_awal" onchange="cek_tgl_awal(this.value)" required>
								<select name="jam_awal" id="jam_awal" class="form-control">
									<?php
									for ($i=0; $i <= 23 ; $i++) { 
										if(strlen($i < 10)){ ?>
										<option value="0<?php echo $i;?>:00">0<?php echo $i;?>:00</option>
										<?php
										}else{ ?>
										<option value="<?php echo $i;?>:00"><?php echo $i;?>:00</option>
										<?php
										}
									?>
									<?php
									}
									?>
									<option value="23:59">23:59</option>
								</select>
								<input type="text" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="tgl_akhir" onchange="cek_tgl_akhir(this.value)" required>
								<select name="jam_akhir" id="jam_akhir" class="form-control">
									<?php
									for ($i=0; $i <= 23 ; $i++) { 
										if(strlen($i < 10)){ ?>
										<option value="0<?php echo $i;?>:00">0<?php echo $i;?>:00</option>
										<?php
										}else{ ?>
										<option value="<?php echo $i;?>:00" ><?php echo $i;?>:00</option>
										<?php
										}
									?>
									<?php
									}
									?>
									<option value="23:59" selected="true">23:59</option>
								</select>
								<select name="user_biling" id="user_biling" class="form-control">
									<?php
									foreach ($list_user as $r) { ?>
									<option value="<?php echo $r['username'];?>"><?php echo $r['username'];?></option>
									<?php
									}
									?>
								</select>
								<input type="text" id="date_picker_months" class="form-control" placeholder="yyyy-mm" name="bulan">
								<input type="text" id="date_picker_years" class="form-control" placeholder="yyyy" name="tahun">
								<button class="btn btn-primary" type="submit">Cari</button>
								
							</div>
						</div><!-- /inline -->
					</div>
					</form>		</div>						
			</div>
		</div>
			
		<div class="container-fluid">

		<!-- Keterangan page -->
		<!-- <section class="content-header">
			<h1>Laporan Pendapatan Rawat Inap</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-home"></i> Home</a></li>
				<li><a href="#">Laporan Pendapatan Rawat Inap</a></li>
			</ol>
		</section> -->
		<!-- /Keterangan page -->

		<section class="content">
				<div class="row">
						<div class="card card-outline-info">
							<div class="card-header text-white" align="center" >Rekap Pendapatan Poli<?php echo $user_show; ?><br> 
							Tanggal <?php echo $tgl_awal_show; ?> - <?php echo $tgl_akhir_show; ?>
							</div>
							<div class="panel-body">
								<br/>
						<div style="display:block;overflow:auto;">
						<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example">
						  <thead>
							<tr>
								<th>Tanggal</th>
								<th>Nama Poli</th>
								<th>Jumlah Kunjungan</th>
								<th>Jumlah Pendapatan</th>
							</tr>
						  </thead>
						  	<tbody>
						  	
						  	<tr>
						  		<td><?php echo date('d F Y',strtotime($r['tgl_cetak_kw']));?></td>
						  		<td><?php echo $r['nm_poli']?></td>
						  		<td><?php echo $r['total']?></td>
						  		<td><?php echo $r['total_penerimaan']?></td>
						  		
						  	</tr>
						  	
						  	<?php
						  	//pasien irj
						  	if($list_pendapatan_poli!=null){
						  	foreach ($list_pendapatan_poli as $r) { 
						  		$total = $total + $r['vtot'] + $r['vtot_rad'] + $r['vtot_lab'] + $r['vtot_obat'] ;
						  		$total_bayar_tunai = $total_bayar_tunai + $r['tunai'];
						  		$total_dibayar_kartu_kredit = $total_dibayar_kartu_kredit + $r['nilai_kkkd'];
						  		$total_charge_kartu_kredit = $total_charge_kartu_kredit + ($r['nilai_kkkd'] * $r['persen_kk'] / 100);
						  	?>
						  	<tr>
						  		<td><?php 						  		
						  		echo date('d F Y',strtotime($r['tgl_cetak_kw']));
						  		?></td>
						  		<td><?php echo $r['no_register']?></td>
						  		<td><?php echo strtoupper($r['nama'])?></td>
						  		<td><?php
						  		if($r['pasien_bayar'] == 1){
						  			echo "TUNAI";
						  		}else{
						  			echo "KREDIT";
						  		}
						  		?></td>
						  		<?php
						  		$diskon = $r['diskon'];
						  		if($diskon == '' || $diskon == NULL){
						  			$diskon = 0;
						  		}
						  		$total_diskon = $total_diskon + $diskon;
						  		?>
						  		<td align="right">Rp. <?php echo number_format($r['vtot'] + $r['vtot_rad'] + $r['vtot_lab'] + $r['vtot_obat'],0);?></td>
						  		<td align="right">Rp. <?php echo number_format($diskon,0);?></td>
						  		<td align="right">Rp. <?php echo number_format($r['vtot'] + $r['vtot_rad'] + $r['vtot_lab'] + $r['vtot_obat'] - $diskon,0);?></td>
						  		<td align="right">Rp. <?php echo number_format($r['tunai'],0);?></td>
						  		<td align="right">Rp. <?php echo number_format($r['nilai_kkkd'],0);?></td>
						  		<td align="right">Rp. <?php echo number_format($r['nilai_kkkd'] * $r['persen_kk'] / 100,0);?></td>
						  	</tr>
						  	<?php
						  	}
						  	?>
						  	<tr>
								<td colspan="4" align="right">Total</td>
								<td align="right">Rp. <?php echo number_format($total,0) ;?></td>
								<td align="right">Rp. <?php echo number_format($total_diskon,0) ;?></td>
								<td align="right">Rp. <?php echo number_format($total - $total_diskon,0) ;?></td>
								<td align="right">Rp. <?php echo number_format($total_bayar_tunai,0) ;?></td>
								<td align="right">Rp. <?php echo number_format($total_dibayar_kartu_kredit,0) ;?></td>
								<td align="right">Rp. <?php echo number_format($total_charge_kartu_kredit,0) ;?></td>
							</tr>
							<?php
						  	}
						  	?>
							</tbody>
						</table>
						<br>
						<div class="form-inline" align="right">
							<div class="form-group">
								<!--<a target="_blank" href="<?php //echo site_url('iri/riclaporan/cetak_laporan_harian/');?><?php //echo '/'.$tgl_awal ;?>"><input type="button" class="btn 
								btn-primary" value="Cetak Laporan PDF"></a>-->
								<a target="_blank" href="<?php echo site_url('rekap/Rcrekap/cetak_laporan_harian_excel/');?><?php echo '/'.$tgl_awal.'/'.$user ;?>"><input type="button" class="btn 
								btn-primary" value="Cetak Laporan Excel"></a>
							</div>
						</div>
						</div><!-- style overflow -->
					</div><!--- end panel body -->
				</div><!--- end panel -->
				</div><!--- end panel -->
		</section>
		<!-- /Main content -->
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