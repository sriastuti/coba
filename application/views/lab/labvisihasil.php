<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?> 
<html>
<script type='text/javascript'>
//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#example').DataTable();
} );
//---------------------------------------------------------

		
function isi_value(isi_value, id) {
	document.getElementById(id).value = isi_value;
}	
var site = "<?php echo site_url();?>";

</script>
	<?php include('labvdatapasien.php');
	$itot=0;?>
	<section class="content">
		<div class="row">
			<?php echo form_open('lab/labcpengisianhasil/simpan_hasil'); ?>
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title"><legend>Pengisian Hasil Tes <?php echo $jenis_tindakan;?></legend></h3>
					</div>
					<div class="box-body">
						<table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
								  	<th>No</th>
								  	<th>Jenis Hasil</th>
								  	<th>Isi Hasil</th>
								  	<th>Kadar Normal</th>
								  	<th>Satuan</th>
								</tr>
							</thead>
							<tbody>
								<?php
									// print_r($pasien_daftar);
									$i=1;
										foreach($get_data_tindakan_lab as $row){
								?>
								<tr>
								  	<td><?php echo $i;?>
									</td>
								  	<td><?php echo $row->jenis_hasil;?>
								  	<input type="hidden" class="form-control" value="<?php echo $row->jenis_hasil;?>" name="jenis_hasil_<?php echo $i;?>">
								  	</td>
									<td>
								  	<input type="text" class="form-control" name="hasil_lab_<?php echo $i;?>">
								  	</td>
									<td><?php echo $row->kadar_normal;?>
								  	<input type="hidden" class="form-control" value="<?php echo $row->kadar_normal;?>" name="kadar_normal_<?php echo $i;?>">
								  	</td>
									<td><?php echo $row->satuan;?>
								  	<input type="hidden" class="form-control" value="<?php echo $row->satuan;?>" name="satuan_<?php echo $i;?>">
								  	</td>
								<?php 
									$i++;
									$itot++;} ?>
							</tbody>
						</table>
						<div class="form-inline" align="right"><br>
							<input type="hidden" class="form-control" value="<?php echo $id_pemeriksaan_lab;?>" name="id_pemeriksaan_lab">
							<input type="hidden" class="form-control" value="<?php echo $id_tindakan;?>" name="id_tindakan">
							<input type="hidden" class="form-control" value="<?php echo $no_lab;?>" name="no_lab">
							<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
							<input type="hidden" class="form-control" value="<?php echo $itot;?>" name="itot">
							<button type="save" class="btn btn-primary">Simpan</button>
						</div>							
					</div>
				</div>	
			</div>
			<?php echo form_close();?>
		</div>
	</section>


<?php
	$this->load->view('layout/footer.php');
?>