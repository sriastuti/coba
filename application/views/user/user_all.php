<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?> 
<script type='text/javascript'>
var intervalSetting = function () { 
location.reload(); 
}; 
setInterval(intervalSetting, 120000);

	$(function() {
		$('#date_picker1').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		}); 
		$('#date_picker2').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		}); 
	});
	
	$(document).ready(function() {
		$('#tabel_kwitansi').DataTable();
		$('#tabel_pa').DataTable();
		$('#tabel_cetak_pa').DataTable();
	} );

</script>
	
<?php
	echo $this->session->flashdata('message_cetak'); 
?>

<section class="content">
	<div class="form-group row">
					<div class="col-md-8">
						<?php echo form_open('user/cuser/all');?>
							<div class="form-group ">
								<input type="text" id="date_picker1" class="form-control" placeholder="Tanggal Awal" name="date0">
								<input type="text" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="date1">
								
								<button class="btn btn-primary" type="submit">Cari</button>								
							</div><!-- /input-group -->
						<?php echo form_close();?>
					</div><!-- /.col-lg-6 -->
						
				</div><!-- /inline -->
	<div class="row">
						
		<div class="card card-outline-warning" style="width:97%;margin:0 auto">
			<div class="card-header">
				<h3 class="card-title text-white">Daftar User Global</h3>			
			</div>
			<div class="card-block">
				
					<table id="tabel_kwitansi" class="table table-hover table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th>Total</th>
							  <th>User</th>							  
							</tr>
						</thead>
						<tbody>
						
							<?php
							// print_r($pasien_daftar);
							$i=1;
							foreach($user_all as $row){
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo $row->total; ?></td>
							  <td><?php echo $row->xuser;?></td>
							</tr>
						<?php
							}
						?>
						</tbody>
					</table>
					
					<?php
					//echo $this->session->flashdata('message_nodata');
					?>
				</div>
				<div class="form-inline " align="right" style="padding:30px;">
					<a href="<?php echo site_url("user/cuser/cetak/all/".$date_awal."/".$date_akhir);?>" class="btn btn-primary ">Cetak</a>								
				</div>					
			</div><!-- /panel body -->

			
        </div><!-- /.box-body -->	

			
</section>
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>
