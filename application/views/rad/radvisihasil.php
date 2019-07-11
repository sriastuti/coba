<?php
	if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?>


<script type="text/javascript">
	$(document).ready(function() {
	  $(".js-example-basic-single").select2();
	});
</script>
<script src="<?php echo site_url('asset/plugins/ckeditor/ckeditor.js'); ?>"></script>
<script type='text/javascript'>
//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#example').DataTable();
    CKEDITOR.replace('hasil_1');
    CKEDITOR.replace('hasil_2');
    CKEDITOR.replace('hasil_3');
    CKEDITOR.replace('hasil_4');
    CKEDITOR.replace('hasil_5');
    CKEDITOR.replace('hasil_pengirim');
} );
//---------------------------------------------------------

function isi_value(isi_value, id) {
	document.getElementById(id).value = isi_value;
}	
var site = "<?php echo site_url();?>";

function downloadFile(datafoto) {
    window.location.href = "<?php echo base_url('rad/Radcpengisianhasil/download')?>/"+ datafoto ;
    //alert('download');
}
</script>

<?php include('radvdatapasien.php');
$itot=0;?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Tindakan : <?php echo $jenis_tindakan?></h4>
            </div>
            <div class="card-block">

				<?php 
				    //$attributes = array('id' => 'idformupload');
				    //echo form_open_multipart('rad/radcpengisianhasil/simpan_hasil', $attributes);
				?>
				<?php echo form_open_multipart('rad/radcpengisianhasil/simpan_hasil'); ?>
                <div class="col-md-12">
					<!-- <div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_gambar_hasil">Foto Hasil Radiologi</p>
						<div class="col-sm-12 col-lg-8">
						<?php 
						$this->load->helper('directory'); //load directory helper
						$dir = "upload/radgambarhasil/"; // Your Path to folder
						$map = directory_map($dir); /* This function reads the directory path specified in the first parameter and builds an array representation of it and all its contained files. */
						$kosong = 0;
						foreach ($map as $k){
							if(stripos($k, $no_register."-".$id_pemeriksaan_rad) !== FALSE){
								$kosong++;
							?>
							<div class="col-sm-4" style='margin-bottom: 20px;'>
						     <center>
						     	<img src="<?php echo base_url($dir)."/".$k?>" alt="" height='150px'  style='margin-bottom: 10px;'>
						     	<br>
						     	<input type="button" value="Download" onClick="downloadFile('<?php echo $k; ?>')">
						     </center>
							</div>
						   
						<?php 
							}
						}
						if($kosong==0){
							echo "Foto Tidak Ditemukan";
						}
						          
						?> 
						</div>
					</div> -->


			        <div class="form-group row">
			          	<label for="inputFile_hasil" class="col-sm-12 col-lg-3 form-control-label">Upload Hasil</label>
			          	<div class="col-sm-12 col-lg-8">
                			<input type="file" class="form-control" id="userFiles" name="userFiles[]" multiple accept="image/*" />
			          	</div>
			        </div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_dokter_1">Dokter 1</p>
						<div class="col-sm-12 col-lg-8">
							<div class="form-group">
								<select id="id_dokter_1" class="form-control js-example-basic-single" name="id_dokter_1">
									<option value="" selected="">-Pilih Dokter-</option>
									<?php 
										foreach($dokter_rad as $row){
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
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_hasil_1">Hasil Kesan</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="hasil_1" id="hasil_1" ></textarea>
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_dokter_2">Dokter 2</p>
						<div class="col-sm-12 col-lg-8">
							<div class="form-group">
								<select id="id_dokter_2" class="form-control js-example-basic-single col-lg-12" name="id_dokter_2">
									<option value="" selected="">-Pilih Dokter-</option>
									<?php 
										foreach($dokter_rad as $row){
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
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_hasil_2">Hasil Kesan</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="hasil_2" id="hasil_2" ></textarea>
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_dokter_3">Dokter 3</p>
						<div class="col-sm-12 col-lg-8">
							<div class="form-group">
								<select id="id_dokter_3" class="form-control js-example-basic-single col-lg-12" name="id_dokter_3">
									<option value="" selected="">-Pilih Dokter-</option>
									<?php 
										foreach($dokter_rad as $row){
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
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_hasil_3">Hasil Kesan</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="hasil_3" id="hasil_3" ></textarea>
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_dokter_4">Dokter 4</p>
						<div class="col-sm-12 col-lg-8">
							<div class="form-group">
								<select id="id_dokter_4" class="form-control js-example-basic-single col-lg-12" name="id_dokter_4">
									<option value="" selected="">-Pilih Dokter-</option>
									<?php 
										foreach($dokter_rad as $row){
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
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_hasil_4">Hasil Kesan</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="hasil_4" id="hasil_4" ></textarea>
						</div>
					</div>

					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_dokter_3">Dokter 5</p>
						<div class="col-sm-12 col-lg-8">
							<div class="form-group">
								<select id="id_dokter_5" class="form-control js-example-basic-single col-lg-12" name="id_dokter_5">
									<option value="" selected="">-Pilih Dokter-</option>
									<?php 
										foreach($dokter_rad as $row){
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
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_hasil_5">Hasil Kesan</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="hasil_5" id="hasil_5" ></textarea>
						</div>
					</div>

					<hr>
					
					<div class="form-group row">
						<p class="col-sm-12 col-lg-3 form-control-label" id="lbl_hasil_pengirim">Hasil Dokter <br>*di isi dokter Poliklinik/Rawat Inap</p>
						<div class="col-sm-12 col-lg-8">
							<textarea rows="10" cols="80" name="hasil_pengirim" id="hasil_pengirim" ></textarea>
						</div>
					</div>
					
					<div>
	                    <hr class="m-t-20">
	                </div>
					<div class="col-md-12" align="right">
						<input type="hidden" class="form-control" value="<?php echo $id_pemeriksaan_rad;?>" name="id_pemeriksaan_rad">
						<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
						<input type="hidden" class="form-control" value="<?php echo $no_rad;?>" name="no_rad">
						
						<a href="javascript:;" class="btn btn-danger" onClick="return openUrl('<?php echo site_url('rad/radcpengisianhasil/daftar_hasil/'.$no_rad); ?>');">Back</a>
						<button type="submit" class="btn btn-info">Simpan</button>
	                </div>
				</div>
				<?php echo form_close();?>
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