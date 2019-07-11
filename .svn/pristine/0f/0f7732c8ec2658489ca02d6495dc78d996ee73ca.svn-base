<?php
	if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?>

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
	setInterval(intervalSetting, 120000);

	function tindak(waktu_masuk,no_register){
		if(waktu_masuk==''){
			swal({
	         title: "Tindak Pasien",
	         text: "Apakah Pasien sudah masuk Ke Ruangan Radiologi ?",
	         type: "info",
	         showCancelButton: true,
	         closeOnConfirm: false,
	         showLoaderOnConfirm: true,
	      },
	      function(){
	         location.href = '<?php echo site_url('rad/radcdaftar/pemeriksaan_rad');?>/'+no_register;         
	      });
		}else{
	      	location.href = '<?php echo site_url('rad/radcdaftar/pemeriksaan_rad');?>/'+no_register;
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
					<div class="col-md-6">
					<?php echo form_open('rad/radcdaftar/by_date');?>
					<div class="form_group">
						<div class="input-group">
							<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div><!-- /input-group -->
					</div><!-- /col-lg-6 -->
					<?php echo form_close();?>
					</div>
					<div class="col-md-6">
					<?php echo form_open('rad/radcdaftar/by_no');?>
					<div class="form_group">
						<div class="input-group">
							<input type="text" class="form-control" name="key" placeholder="Nama / No. Register" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div>
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
                <div class="table-responsive m-t-40">
					<table id="example" class="table display table-bordered table-striped">
						<thead>
							<tr>
								<th>Aksi</th>
							  	<th>Tanggal Kunjungan</th>
							  	<th>No Medrec</th>
							  	<th>No Registrasi</th>
							  	<th>Nama</th>
							  	<th>Kelas</th>
							  	<th>Ruangan</th>
							  	<th>Bed</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=1;
									foreach($radiologi as $row){
									$no_register=$row->no_register;
							?>
							<tr>
								<td>
							  		<!-- <button onclick="tindak('<?php echo $row->waktu_masuk_rad; ?>','<?php echo $no_register; ?>')" class="btn btn-primary">Tindak <i class="ti-pencil"></i></button> -->
							  		<?php if ($row->idrg=="Urikkes") { ?>
										<a href="<?php echo base_url();?>urikes/Curikes/isi_hasil_poli/<?php echo $row->no_medrec; ?>" class="btn btn-primary btn-xs" style="margin-right:3px;">Tindak</a>
									<?php } else {?>
										<a href="javascript:;" class="btn btn-primary" onClick="return openUrl('<?php echo site_url('rad/radcdaftar/pemeriksaan_rad/'.$no_register); ?>');">Tindak <i class="ti-pencil"></i></a>
							  		<?php } ?>
							  	</td>
								<!-- <td><?php //echo $i++;?></td> -->
								<td><?php echo date('d-m-Y | H:i',strtotime($row->tgl_kunjungan));?></td>
								<td><?php echo $row->no_medrec;?></td>
								<td><?php echo $row->no_register;?></td>
								<td><?php echo $row->nama;?></td>
								<td><?php echo $row->kelas;?></td>
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