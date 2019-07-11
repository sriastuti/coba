<?php 
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_horizontal");
}?>

<script type='text/javascript'>
$(function() {
	$('#calendar-tgl').datepicker();
	$(".select2").select2();
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

</script>

<div >
	<div >
		
		<div class="container-fluid"><br/><br/>
			<div class="inline">
				<div class="row">
					<div class="form-inline">
						<form action="<?php echo base_url();?>irj/rjclaporan/rekap_harian_kasirLoket" method="post" accept-charset="utf-8">
						<div class="col-lg-10">
							<div class="form-inline">
								<select name="tampil_per" id="tampil_per" class="form-control">
									<option value="TGL">Tanggal</option>
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
								<!--<select name="user_biling" id="user_biling" class="form-control select2" >
									<?php
									//foreach ($list_user as $r) { ?>
									<option value="<?php //echo $r['username'];?>"><?php //echo $r['username'];?></option>
									<?php
									//}
									?>
								</select>-->								
								<button class="btn btn-primary" type="submit">Cari</button>
								
							</div>
						</div><!-- /inline -->
					</div>
					</form>		</div>						
			</div>
		</div>
			
		<div class="container-fluid"><br/>

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
							<div class="card-header text-white" align="center" >Rekapan Kasir Harian sesuai loket user<br> 
							Tanggal <?php echo $tgl_awal_show; ?> s/d <?php echo $tgl_akhir_show; ?>
							</div>
							<div class="card-block">
								<br/>
						<div style="display:block;overflow:auto;">
						<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example">
						  <thead>
							<tr>
								<th>No</th>
								<th>No Kwitansi</th>
								<th>Nama Pasien</th>
								<th>Nama Poli</th>
								<th>Bagian</th>
								<th>Jenis</th>
								<th>Ket</th>
								<th>Jumlah Bayar</th>
								<th>Potongan/Diskon</th>
							</tr>
						  </thead>
						  	<tbody>
						  	<?php
						  	//pasien rawat inap
						  	$total = 0; $jumlahtunai=0;$jumlahcc=0;$jumlahdisc=0;
						  	$i=0;						  	
						  	//pasien irj
						  	foreach ($list_irj as $r) { 
						  		$i++;	
						  		//$total+=$r['vtot'];
						  		$jumlahtunai+=$r['tunai'];	
						  		$jumlahcc+=$r['nilai_kkd'];
						  		$jumlahdisc+=$r['diskon'];	
						  	?>
						  	<tr>
						  		<td><?php echo $i++;?></td>
						  		<td><?php echo '<b>'.$r['kasir'].'</b>'.$r['no_kwitansi'];?></td>
						  		<td><?php echo $r['nama'];?></td>
						  		<td><?php echo $r['nm_poli'];?></td>
						  		<td><?php echo $r['nama_kel'];?></td>
						  		<td><?php if((int)$r['nilai_kkd']==0 or $r['nilai_kkd']==''){ echo 'Tunai';} else { echo 'CC/Debit';}?></td>
						  		<td><?php if((int)$r['batal']==1){ echo 'BATAL '.$r['editnote'];} if((int)$r['retur']==1){ echo 'RETUR '.$r['editnote'];} ?></td>
						  		<td align="right">Rp. <?php echo number_format((int)$r['tunai']+(int)$r['nilai_kkd'],0);?></td>						  		
						  		<td align="right">Rp. <?php echo number_format($r['diskon'],0);?></td>	
						  	</tr>
						  	<?php
						  	}
						  	?>
						  	<tr>
								<td colspan="7" align="right">Total</td>					
								<td align="right">Rp. <?php echo number_format($jumlahtunai+$jumlahcc,0) ;?></td>			
								<td align="right">Rp. <?php echo number_format($jumlahdisc,0) ;?></td>
							</tr>
							</tbody>
						</table>
						<br>
						
						<div class="form-inline" align="right">
							<div class="form-group">
								<!--<a target="_blank" href="<?php //echo site_url('iri/riclaporan/cetak_laporan_harian/');?><?php //echo '/'.$tgl_awal ;?>"><input type="button" class="btn 
								btn-primary" value="Cetak Laporan PDF"></a>-->
								<a target="_blank" href="<?php echo site_url('irj/rjclaporan/cetak_laporan_harian_kasirLoket_excel/');?><?php echo '/'.$tgl_awal.'/'.$tgl_akhir;?>"><input type="button" class="btn 
								btn-warning" value="Excel"></a>
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
