<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>
<style type="text/css">
.demo-radio-button label{min-width:120px;}
</style>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(function() {
	var jenis_identitas = $('#jenis_identitas').val();
	set_ident(jenis_identitas);	
	$(".select2").select2();
	$("#duplikat_id").hide();
	$("#duplikat_kartu").hide();

	$('.date_picker').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  

	$('.auto_search_by_nonrp').autocomplete({
		serviceUrl: site+'/irj/rjcautocomplete/data_pasien_by_nonrp',
		onSelect: function (suggestion) {
			$('#no_nrp').val(''+suggestion.no_nrp);
			$('#hidden_no_nrp').val(''+suggestion.no_nrp);
		}
	});

	 $('.load_wilayah').select2({
        placeholder: '-- Cari Kota/Kabupaten, Kecamatan atau Kelurahan --',
        ajax: {
          url: '<?php echo site_url('irj/rjcregistrasi/get_wilayah'); ?>',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            var results = [];

                $.each(data, function(index, item){
                    results.push({
                        id: item.id_provinsi + '@' + item.id_kota + '@' + item.id_kecamatan + '@' + item.id_kelurahan,
                        text: item.nm_kelurahan + ', ' + item.nm_kecamatan + ', ' + item.nm_kota + ', ' + item.nm_provinsi
                    });
                });
                return { results: results };
          },
          cache: true
        }
      });

	// $('.load_wilayah').autocomplete({
	// 	serviceUrl: site+'/irj/rjcautocomplete/data_pasien_by_nonrp',
	// 	onSelect: function (suggestion) {
	// 		$('#no_nrp').val(''+suggestion.no_nrp);
	// 		$('#hidden_no_nrp').val(''+suggestion.no_nrp);
	// 	}
	// });

	$('#input_tentara').hide();
	$('#keluarga_tentara').hide();

	$('#chk1').change(function() {
	 // alert($(this).prop('checked'))
	  if($(this).prop('checked')==false){
	  	$('#input_tentara').hide();
	  	document.getElementById("no_nrp").required= false;
		document.getElementById("nrp_sbg").required= false;
	  }else{
	  	$('#input_tentara').show();
	  	document.getElementById("no_nrp").required= true;
		document.getElementById("nrp_sbg").required= true;
	  }
	});
	$('#chk_keluarga_tentara').change(function() {
	  if($(this).prop('checked')==false){
	  	$('#keluarga_tentara').hide();
	  }else{
	  	$('#keluarga_tentara').show();
	  }
	});
});	

// var ajaxku;
// function buatajax(){
//     if (window.XMLHttpRequest){
//     return new XMLHttpRequest();
//     }
//     if (window.ActiveXObject){
//     return new ActiveXObject("Microsoft.XMLHTTP");
//     }
//     return null;
// }

function cek_no_identitas(no_identitas){
	if(no_identitas!=''){
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi/cek_available_noidentitas')?>/"+no_identitas+"/",
		success: function(data){
			if (data>0) {
				document.getElementById("content_duplikat_id").innerHTML = "<i class=\"icon fa fa-ban\"></i> No Identitas \""+no_identitas+"\" Sudah Terdaftar ! <br>Silahkan masukkan no identitas lain...";
				$("#duplikat_id").show();
				document.getElementById("btn-submit").disabled= true;				
			} else {
				$("#duplikat_id").hide();
				document.getElementById("btn-submit").disabled= false;
			}
		},
		error: function (request, status, error) {
			alert(request.responseText);
		}
    });}
}

// function set_ident(ident){
// 	if (ident == '') {
// 		$("#not_ktp").show();
//         $("#select_ktp").hide();
// 		document.getElementById("not_ktp").disabled= false;
//         document.getElementById("select_ktp").disabled= true; 
// 		$("#label-identitas").html('Identitas');
// 	} else if (ident == 'KTP') {
// 		$("#not_ktp").hide();
//         $("#select_ktp").show();
//         document.getElementById("not_ktp").disabled= true;
//         document.getElementById("select_ktp").disabled= false;   
// 		$("#label-identitas").html('No. NIK');
// 	} else {
// 		$("#not_ktp").show();
//         $("#select_ktp").hide();
// 		document.getElementById("not_ktp").disabled= false;
//         document.getElementById("select_ktp").disabled= true;   
//         $("#label-identitas").html('No. '+ident); 
// 	}	
// }

function set_ident(ident) {
		$("#no_identitas").val("");
	if (ident == "") {
		document.getElementById("no_identitas").required = false;		
		$("#btn_cek_nik").hide();    
		$("#label-identitas").html("No. Identitas");
		$("#div-no-identitas").hide();
	} else if (ident == "KTP") {
		document.getElementById("no_identitas").required = true;		
		$("#btn_cek_nik").show(); 
		$("#label-identitas").html("No. NIK");
		$("#div-no-identitas").show();
	} else {
		document.getElementById("no_identitas").required= true;		
		$("#btn_cek_nik").hide(); 
		$("#label-identitas").html("No. "+ident); 
		$("#div-no-identitas").show();
	}
}

function terapkan_data_bpjs() {
	var tgl_lahir = $('#bpjs_tgl_lahir').text();	
	var nama = $('#bpjs_nama').text();	
	var no_nik = $('#bpjs_nik').text();	
	var no_bpjs = $('#bpjs_noka').text();	
	var gender = $('#bpjs_gender').text();	

	$('#tgl_lahir').val(tgl_lahir);	        			
	$('#nama').val(nama);
	if (data.nik != '') {
		$('#jenis_identitas').val('KTP');
		$('#jenis_identitas').trigger('change');
		$('#no_identitas').val(no_nik);
		$('#no_bpjs').val(no_bpjs);
	}
	if (gender == 'L') {
		$('#laki_laki').prop('checked', true);
	}
	if (gender == 'P') {
		$('#perempuan').prop('checked', true);
	}
	$('.modal_nobpjs').modal('hide');
}

function cek_nobpjs(){
	document.getElementById("btn_cek_kartu").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Loading...';
    no_bpjs = $("#no_bpjs").val();
    if (no_bpjs == '') {
    	document.getElementById("btn_cek_kartu").innerHTML = 'Cek Peserta BPJS';
    	swal("No. Kartu Kosong","Masukan terlebih dulu nomor kartu BPJS.", "warning"); 
    } else {       	
	    $.ajax({
	        type: "POST",
	        url: "<?php echo site_url('bpjs/peserta/no_kartu'); ?>",
	        dataType: "JSON",
	        data: {"no_bpjs" : no_bpjs},
	        success: function(result){ 
	        	console.log(result);
	        	if (result != '') {
	        		if (result.metaData.code == '200') {
	        			document.getElementById("btn_cek_kartu").innerHTML = 'Cek Peserta BPJS'; 	
	        			data = result.response.peserta;	        				        		
	        			$('.modal_nobpjs').modal('show');
	        			document.getElementById("bpjs_noka").innerHTML = data.noKartu;
	        			document.getElementById("bpjs_nik").innerHTML = data.nik;
	        			document.getElementById("bpjs_nama").innerHTML = data.nama;	        			
	        			document.getElementById("bpjs_gender").innerHTML = data.sex;
	        			document.getElementById("bpjs_tgl_lahir").innerHTML = data.tglLahir;
	        			document.getElementById("bpjs_no_telepon").innerHTML = data.mr.noTelepon;	        			
	        			document.getElementById("bpjs_kdprovider").innerHTML = data.provUmum.kdProvider;
	        			document.getElementById("bpjs_nmprovider").innerHTML = data.provUmum.nmProvider;	        			
	        			document.getElementById("bpjs_jnspeserta").innerHTML = data.jenisPeserta.keterangan;	        		
	        			document.getElementById("bpjs_nmkelas").innerHTML = data.hakKelas.keterangan;	        			
	        			document.getElementById("bpjs_status_keterangan").innerHTML = data.statusPeserta.keterangan;  
	        			document.getElementById("bpjs_cob_nama").innerHTML = data.cob.nmAsuransi;
	        			document.getElementById("bpjs_cob_nomor").innerHTML = data.cob.noAsuransi;	        			
	        			document.getElementById("bpjs_cob_tat").innerHTML = data.cob.tglTAT;	        		
	        			document.getElementById("bpjs_cob_tmt").innerHTML = data.cob.tglTMT; 
	        			document.getElementById("bpjs_informasi_dinsos").innerHTML = data.informasi.dinsos;	        			
	        			document.getElementById("bpjs_informasi_sktm").innerHTML = data.informasi.noSKTM;	
	        			document.getElementById("bpjs_informasi_prb").innerHTML = data.informasi.prolanisPRB;		        	
	        		} else {
	        			document.getElementById("btn_cek_kartu").innerHTML = 'Cek Peserta BPJS'; 	
	        			swal("Gagal Cek Peserta BPJS.",result.metaData.message, "error");
	        		}	              	
	        	} else {
	        		document.getElementById("btn_cek_kartu").innerHTML = 'Cek Peserta BPJS';
	              	swal("Error","Gagal Cek Peserta BPJS.", "error");  
	        	}
	        },
	        error:function(event, textStatus, errorThrown) { 
	        	document.getElementById("btn_cek_kartu").innerHTML = 'Cek Peserta BPJS';
	            swal("Error","Gagal Cek Peserta BPJS.", "error");                   
	            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
	        }
	    });
    }
}
function cekbpjs_nik(){
	document.getElementById("btn_cek_nik").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Loading...';
    no_nik = $("#no_identitas").val();
    if (no_nik == '') {
    	swal("NIK Kosong","Mohon masukkan NIK yang valid.", "warning"); 
    	document.getElementById("btn_cek_nik").innerHTML = 'Cek Peserta BPJS';
    } else {    	
	    $.ajax({
	        type: "POST",
	        url: "<?php echo site_url('bpjs/peserta/nik'); ?>",
	        dataType: "JSON",
	        data: {"no_nik" : no_nik},
	        success: function(result){ 
	        	if (result) {
	        		document.getElementById("btn_cek_nik").innerHTML = 'Cek Peserta BPJS';
	        		if (result.metaData.code == '200') {
	        			data = result.response.peserta;	        				        		
	        			$('.modal_nobpjs').modal('show');
	        			document.getElementById("bpjs_noka").innerHTML = data.noKartu;
	        			document.getElementById("bpjs_nik").innerHTML = data.nik;
	        			document.getElementById("bpjs_nama").innerHTML = data.nama;	        			
	        			document.getElementById("bpjs_gender").innerHTML = data.sex;
	        			document.getElementById("bpjs_tgl_lahir").innerHTML = data.tglLahir;
	        			document.getElementById("bpjs_no_telepon").innerHTML = data.mr.noTelepon;	        			
	        			document.getElementById("bpjs_kdprovider").innerHTML = data.provUmum.kdProvider;
	        			document.getElementById("bpjs_nmprovider").innerHTML = data.provUmum.nmProvider;	        			
	        			document.getElementById("bpjs_jnspeserta").innerHTML = data.jenisPeserta.keterangan;	        		
	        			document.getElementById("bpjs_nmkelas").innerHTML = data.hakKelas.keterangan;	        			
	        			document.getElementById("bpjs_status_keterangan").innerHTML = data.statusPeserta.keterangan;  
	        			document.getElementById("bpjs_cob_nama").innerHTML = data.cob.nmAsuransi;
	        			document.getElementById("bpjs_cob_nomor").innerHTML = data.cob.noAsuransi;	        			
	        			document.getElementById("bpjs_cob_tat").innerHTML = data.cob.tglTAT;	        		
	        			document.getElementById("bpjs_cob_tmt").innerHTML = data.cob.tglTMT; 
	        			document.getElementById("bpjs_informasi_dinsos").innerHTML = data.informasi.dinsos;	        			
	        			document.getElementById("bpjs_informasi_sktm").innerHTML = data.informasi.noSKTM;	
	        			document.getElementById("bpjs_informasi_prb").innerHTML = data.informasi.prolanisPRB;	      	
	        		} else {
	        			swal("Gagal Cek Peserta BPJS",result.metaData.message, "error");
	        		}	              	
	        	} else {
	        		document.getElementById("btn_cek_nik").innerHTML = 'Cek Peserta BPJS';
	              	swal("Error","Gagal Cek Peserta BPJS.", "error");  
	        	}
	        },
	        error:function(event, textStatus, errorThrown) { 
	        	document.getElementById("btn_cek_nik").innerHTML = 'Cek Peserta BPJS';
	            swal("Gagal Cek Peserta BPJS.",textStatus, "error");                   
	            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
	        }
	    });
    }
}

// function cek_no_kartu(no_kartu){
// 	if(no_kartu!=''){
// 	$.ajax({
// 		type:'POST',
// 		dataType: 'json',
// 		url:"<?php echo base_url('irj/rjcregistrasi/cek_available_nokartu')?>/"+no_kartu+"/",
// 		success: function(data){
// 			//alert(data);
// 			if (data>0) {
// 				//alert("No Kartu '"+no_kartu+"' Sudah Terdaftar ! <br> Silahkan masukkan no kartu lain...");
// 				document.getElementById("content_duplikat_kartu").innerHTML = "<i class=\"icon fa fa-ban\"></i> No Kartu \""+no_kartu+"\" Sudah Terdaftar ! Silahkan masukkan no kartu lain...";
// 				$("#duplikat_kartu").show();
// 				document.getElementById("btn-submit").disabled= true;
// 			} else {
// 				$("#duplikat_kartu").hide();
// 				document.getElementById("btn-submit").disabled= false;
// 			}
// 		},
// 		error: function (request, status, error) {
// 			alert(request.responseText);
// 		}
//    	 });
//  	}
// }

// function cek_no_nrp(){
// 	no_nrp = $("#no_nrp").val();	
// 	if(no_nrp!='' && $("#nrp_sbg").val()=='T'){
// 	$.ajax({
// 		type:'POST',
// 		dataType: 'json',
// 		url:"<?php echo base_url('irj/rjcregistrasi/cek_available_nonrp')?>/"+no_nrp.replace(/\//g , "_")+"/",
// 		success: function(data){			
// 			if (data!='') {
// 				//alert("No Kartu '"+no_kartu+"' Sudah Terdaftar ! <br> Silahkan masukkan no kartu lain...");
// 				document.getElementById("content_duplikat_nrp").innerHTML = "<i class=\"icon fa fa-ban\"></i> No NRP \""+no_nrp+"\" Sudah Terdaftar ! Silahkan Cari Data Pasien di Form Cari";
// 				$("#duplikat_kartu").show();
// 				document.getElementById("btn-submit").disabled= true;
// 			} else {
// 				$("#duplikat_kartu").hide();
// 				document.getElementById("content_duplikat_nrp").innerHTML = "<i class=\"icon fa fa-plus\"></i> No NRP \""+no_nrp+"\" Belum Terdaftar ! Silahkan melanjutkan pengisian data";
// 				document.getElementById("btn-submit").disabled= false;
// 			}
// 		},
// 		error: function (request, status, error) {
// 			alert(request.responseText);
// 		}
//    	 });
//  	}else{
//  		alert("Input No NRP dan Jenis Tentara");
//  	}
// }

// function cek_validasi(no_medrec){
//     ajaxku = buatajax();
//     var url="<?php echo site_url('irj/rjcwebservice/check_no_kartu'); ?>";
//     url=url+"/"+no_medrec;
//     ajaxku.onreadystatechange=stateChangedValidasi;
//     ajaxku.open("GET",url,true);
//     ajaxku.send(null);
// }	

// function select_kesatuan(){
// 	 $('select[name="kesatuan"]').on('change', function() {
//             var id_kesatuan1 = $(this).val();
//             if(id_kesatuan1) {
//                 $.ajax({
//                     url: '<?php echo base_url('irj/rjctni/load_kesatuan2')?>/'+id_kesatuan1,
//                     type: "GET",
//                     dataType: "JSON",
//                     success:function(data) {
//                         $('select[name="kesatuan2"]').empty();
//                         $('select[name="kesatuan3"]').empty();
//                         $.each(data, function(key, value) {
//                             $('select[name="kesatuan2"]').append('<option value="'+ value.kst2_id +'">'+ value.kst2_nama +'</option>');
//                         });
//                     }
//                 });
//             } else{
//                 $('select[name="kesatuan2"]').empty();
//                 $('select[name="kesatuan3"]').empty();
//             }
//         });
// }	

function set_tentara(tni){
//	alert(ident);
	if(tni!='T'){
		//$("#medrecnrp").hide();
		//$("#nonrp").hide();
		//document.getElementById("no_nrp").required= false;
		document.getElementById("angkatan").required= false;
		//document.getElementById("medrecnrp").required= false;
	}
	/*else if(tni!='0'){
		$("#medrecnrp").show();
		$("#nonrp").hide();
		document.getElementById("nonrp").required= false;
		document.getElementById("medrecnrp").required= true;
 	}*/else{
 		//$("#medrecnrp").hide();
		//$("#nonrp").show();
		//document.getElementById("no_nrp").required= true;
		document.getElementById("angkatan").required= true;
		//document.getElementById("medrecnrp").required= false;
 	}
}

	function validate(form){
		// if(form.no_identitas.value==""){
		// 	return false;
		// }
		document.getElementById("btn-submit").disabled = true;
		document.getElementById("btn-submit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Loading...';
		return true;
	}
</script>
	
<?php echo $this->session->flashdata('success_msg'); ?>

<br>
<div class="card card-outline-info">
	<div class="card-header">
        <h4 class="m-b-0 text-white text-center">PENDAFTARAN PASIEN BARU</h4>
    </div>
    <div class="card-block p-b-15">
    <!-- <?php echo form_open_multipart('irj/rjcregistrasi/insert_data_pasien');?>	 -->
    				<form method="POST" onsubmit="return validate(this)" action="<?php echo base_url('irj/rjcregistrasi/insert_data_pasien')?>">
						<br>
						<br>
					
						<div class="col-lg-10" style="margin: 0 auto;">	
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">No. RM</label>
								<div class="col-sm-8">
									<span class="badge badge-danger font-20"><?php echo $last_mr;?></span>	
								</div>
							</div>
							<!--div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">No. RM Lama</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="mr_lama" id="mr_lama">	
								</div>
							</div -->
						<!-- 	<div class="form-group row">
								<div class="offset-sm-3 col-sm-8">
									<div class="demo-checkbox">
										<input type="checkbox" class="filled-in" value="ya" name="chk1" id="chk1"/>
                                    	<label for="chk1">Anggota TNI/PNS</label>
                                	</div>
								</div>
							</div>	 -->
							<!--div class="form-group row">
									<label class="col-sm-3 control-label p" id="jenis_kartu">Anggota TNI/PNS</label>
									<div class="col-sm-8">
										<div class="form-inline">
												<div class="demo-checkbox">	
													<input type="checkbox" class="filled-in" value="ya" name="chk1" id="chk1"/>
                                    				<label for="chk1">Ya</label>
												</div>
											
										</div>
									</div>
							</div -->
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Nama Lengkap *</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="nama" id="nama" required>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="sex">Jenis Kelamin *</label>
								<div class="col-sm-6">							
										<div class="demo-radio-button">
											<input name="sex" type="radio" id="laki_laki" class="with-gap" value="L" />
				                            <label for="laki_laki">Laki-Laki</label>
				                            <input name="sex" type="radio" id="perempuan" class="with-gap" value="P" />
				                            <label for="perempuan">Perempuan</label>           		
										</div>								
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Pilih Identitas</label>
								<div class="col-sm-4">
									<div class="form-inline">
											<select  class="form-control" style="width: 100%" name="jenis_identitas" id="jenis_identitas" onchange="set_ident(this.value)" >
												<option value="">-- Pilih Identitas --</option>
												<option value="KTP">KTP</option>
												<option value="SIM">SIM</option>
												<option value="PASPOR">Paspor</option>
												<option value="KTM">KTM</option>
												<option value="DLL">Lainnya</option>
											</select>
									</div>
								</div>
							</div>
							<div class="form-group row" id="div-no-identitas">
								<label class="col-sm-3 control-label col-form-label" ><span id="label-identitas">No. Identitas</span></label>
								<div class="col-sm-5">																		
                                    <input type="text" class="form-control input-block" name="no_identitas" id="no_identitas" onchange="cek_no_identitas(this.value)" onkeyup="cek_no_identitas(this.value)">
								</div>
								<div class="col-sm-3">
									<button class="btn btn-info btn-block" type="button" onclick="cekbpjs_nik()" id="btn_cek_nik">Cek Peserta BPJS</button>
								</div>
							</div>
							<div class="form-group row" id="duplikat_id">
								<label class="col-sm-3 control-label col-form-label"></label>
								<div class="col-sm-8">
									<label class="control-label col-form-label" id="content_duplikat_id" style="color: red;"></label>
								</div>
							</div>
							<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="no_kartu">No. Kartu Keluarga</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="no_kk" id="no_kk">
								</div>
							</div> -->
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">No. Kartu BPJS</label>
								<div class="col-sm-8">
									<div class="input-group">
                                        <input type="text" class="form-control" name="no_kartu" id="no_bpjs">
                                        <span class="input-group-btn">
                          					<button class="btn btn-info" type="button" onclick="cek_nobpjs()" id="btn_cek_kartu">Cek Kartu BPJS</button>
                        				</span>
                                    </div>	
								</div>
							</div>							
							<div id="input_tentara">
								<div class="form-group row" id="inputtentara">
									<label class="col-sm-3 control-label col-form-label">Jenis Keanggotaan</label>
									<div class="col-sm-8">
										<select name="nrp_sbg" id="nrp_sbg" class="select2" style="width: 100%" onchange="set_tentara(this.value)">
											<option value="">-- Pilih Jenis --</option>
											<?php foreach($hubungan as $row){
													echo '<option value="'.$row->hub_id.'">'.$row->hub_name.'</option>';
												}
											?>
										</select>	
									</div>
								</div>
								<div class="form-group row" id="nonrp">
									<label class="col-sm-3 control-label col-form-label"></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="no_nrp" id="no_nrp"  placeholder="Nomor NRP/NIP">
										<input type="hidden" class="form-control "   name="hidden_no_nrp" id="hidden_no_nrp">
									</div>
								</div>									
								<div class="form-group row" id="duplikat_nrp">
									<label class="col-sm-3 control-label col-form-label"></label>
									<div class="col-sm-8">
										<label class="control-label col-form-label" id="content_duplikat_nrp" style="color: red;"></label>
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-3 control-label col-form-label">Kesatuan</label>
									<div class="col-sm-8">
										<select name="kesatuan" id="kesatuan" class="form-control select2" style="width: 100%" >
											<option value="">- Pilih Kesatuan -</option>
											<?php 										
												foreach ($kesatuan as $item) {		
													if ($item->kst2_id == '' && $item->kst3_id == '') {
														echo '<option value="'.$item->kst_id . '">'.$item->kst_nama.'</option>';
													} else if ($item->kst3_id == '') {
														echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '">'.$item->kst_nama . ' | ' .$item->kst2_nama . '</option>';
													} else {
														echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '@' .$item->kst3_id.'">'.$item->kst_nama . ' | ' .$item->kst2_nama . ' | ' .$item->kst3_nama.'</option>';
													}													
												}
											?>														
										</select>
									</div>

								</div>									
								<div class="form-group row" >
									<label class="col-sm-3 control-label col-form-label">Angkatan</label>
									<div class="col-sm-8">
										<select name="angkatan" id="angkatan" class="form-control select2" style="width: 100%" >
											<option value="">-- Pilih Angkatan --</option>
											<?php foreach($angkatan as $row){
													echo '<option value="'.$row->tni_id.'">'.$row->angkatan.'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-3 control-label col-form-label">Pangkat</label>
									<div class="col-sm-8">
										<select name="pangkat" id="pangkat" class="form-control select2" style="width: 100%" >
											<option value="">-- Pilih Pangkat --</option>
											<?php foreach($pangkat as $row){
													echo '<option value="'.$row->pangkat_id.'">'.$row->pangkat.'</option>';
												}
											?>
										</select>
									</div>
								</div>
							</div>						
							
							<div class="form-group row" id="duplikat_kartu">
								<label class="col-sm-3 control-label col-form-label"></label>
								<div class="col-sm-8">
									<label class="control-label col-form-label" id="content_duplikat_kartu" style="color: red;"></label>
								</div>
							</div>							
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="tmpt_lahir">Tempat Lahir *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="tmpt_lahir" id="tmpt_lahir" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Tanggal Lahir *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="tgl_lahir" maxDate="0" placeholder="dd-mm-yyyy" name="tgl_lahir" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="agama">Agama</label>
								<div class="col-sm-8">
									<div class="form-inline">
											<select class="form-control" style="width: 100%" name="agama">
												<option value="">-- Pilih Agama --</option>
												<option value="ISLAM">Islam</option>
												<option value="KATOLIK">Katolik</option>
												<option value="PROTESTAN">Protestan</option>
												<option value="BUDHA">Budha</option>
												<option value="HINDU">Hindu</option>
												<option value="KONGHUCU">Konghucu</option>
											</select>
										
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="status">Status Perkawinan</label>
								<div class="col-sm-8">
									<div class="demo-radio-button">
											<input name="status" type="radio" id="belum_kawin" class="with-gap" value="B" />
				                            <label for="belum_kawin">Belum Kawin</label>
				                            <input name="status" type="radio" id="sudah_kawin" class="with-gap" value="K" />
				                            <label for="sudah_kawin">Sudah Kawin</label> 
				                            <input name="status" type="radio" id="cerai" class="with-gap" value="C" />
				                            <label for="cerai">Cerai</label>           		
									</div>	
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="goldarah">Golongan Darah</label>
								<div class="col-sm-8">
									<div class="form-inline">
										<select class="form-control" style="width: 100%" name="goldarah">
											<option value="">-- Pilih Golongan Darah --</option>
											<option value="A+">A+</option>
											<option value="A-">A-</option>
											<option value="B+">B+</option>
											<option value="B-">B-</option>
											<option value="AB+">AB+</option>
											<option value="AB-">AB-</option>
											<option value="O+">O+</option>
											<option value="O-">O-</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="wnegara">Kewarganegaraan</label>
								<div class="col-sm-8">
									<div class="form-inline">
										<select class="form-control" style="width: 100%" name="wnegara">
											<option value="WNI">WNI</option>
											<option value="WNA">WNA</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="alamat">Alamat</label>
								<div class="col-sm-8">
									<textarea class="form-control" name="alamat" rows="5"></textarea>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="lbl_wilayah">Asal Wilayah</label>
								<div class="col-sm-8">
									<div class="form-inline">
											<select name="load_wilayah" class="form-control load_wilayah" style="width:500px"></select>
										
									</div>
								</div>
							</div>							
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="kodepos">Kode Pos</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" name="kodepos">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="pendidikan">Pendidikan</label>
								<div class="col-sm-5">
									<div class="form-inline">
											<select class="form-control select2" style="width: 100%" name="pendidikan">
												<option value="">-- Pilih Pendidikan Terakhir --</option>
												<option value="S3">S3</option>
												<option value="S2">S2</option>
												<option value="S1">S1</option>
												<option value="D4">D4</option>
												<option value="D3">D3</option>
												<option value="D2">D2</option>
												<option value="D1">D1</option>
												<option value="SMA">SMA</option>
												<option value="SMP">SMP</option>
												<option value="SD">SD</option>
												<option value="Di Bawah Umur">Di Bawah Umur</option>
											</select>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="pekerjaan">Pekerjaan</label>
								<div class="col-sm-5">
									<select class="form-control select2" style="width: 100%" name="pekerjaan">
										<option value="">-- Pilih Pekerjaan --</option>
										<?php foreach($pekerjaan as $row){
												echo '<option value="'.$row->pekerjaan.'">'.$row->pekerjaan.'</option>';
											}
										?>										
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Jabatan</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="jabatan">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="no_telp_kantor">No. Telp Kantor</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" maxlength="13" name="no_telp_kantor">
								</div>
							</div>							
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="no_telp">No. Telp</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" maxlength="13" name="no_telp">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="no_hp" maxlength="13" minlength="10">No. HP</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="no_hp">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="email">Email</label>
								<div class="col-sm-4">
									<input type="email" class="form-control" name="email">
								</div>
							</div>
<!-- 							<div class="form-group row">
                                    <label class="col-sm-3 control-label col-form-label" id="foto">Foto Pasien</label>
                                    <div class="col-sm-8">
                                    <input type="file" class="form-control" id="exampleInputFile" name="userfile" aria-describedby="fileHelp" accept="image/jpeg, image/png">
                                    </div>
                            </div>	 -->											
						</div><!-- end div col-lg-10-->
				
			<!-- </div>  --><!-- biodata_pasien -->
			<!-- <div id="detail_kerabat" class="tab-pane" role="tabpanel">
						<br>
						<br>
					
						<div class="col-lg-10" style="margin: 0 auto;">							
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Hubungan Keluarga</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="kel_hubungan" id="kel_hubungan">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Nama Lengkap *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="kel_nama" id="kel_nama">
								</div>
							</div>												
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Tanggal Lahir *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="kel_tgllahir" maxDate="0" name="kel_tgllahir">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Agama</label>
								<div class="col-sm-8">
									<div class="form-inline">
											<select class="form-control" style="width: 100%" name="kel_agama">
												<option value="">-Pilih Agama-</option>
												<option value="ISLAM">Islam</option>
												<option value="KATOLIK">Katolik</option>
												<option value="PROTESTAN">Protestan</option>
												<option value="BUDHA">Budha</option>
												<option value="HINDU">Hindu</option>
												<option value="KONGHUCU">Konghucu</option>
											</select>
										
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Alamat</label>
								<div class="col-sm-8">
									<textarea class="form-control" name="kel_alamat" rows="5"></textarea>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Kecamatan</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="kel_kecamatan">
								</div>
							</div>	
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Kabupaten / Kota</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="kel_kota">
								</div>
							</div>	
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="no_telp">Kode Pos</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="kel_kodepos">
								</div>
							</div>	
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Telp.</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="kel_telp">
								</div>
							</div>														
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Pekerjaan</label>
								<div class="col-sm-8">
									<select class="form-control" style="width: 100%" name="kel_pekerjaan">
													<option value="">-Pilih Pekerjaan Terakhir-</option>
													<option value="ASKES AL">ASKES AL</option>
													<option value="ASKES KEMENTERIAN">ASKES KEMENTERIAN</option>
													<option value="ASKES VETERAN">ASKES VETERAN</option>
													<option value="BURUH">BURUH</option>
													<option value="DEPHAN">DEPHAN</option>
													<option  value="DI BAWAH UMUR">DI BAWAH UMUR</option>
													<option value="DOKTER">DOKTER</option>
													<option value="DOSEN">DOSEN</option>
													<option value="HONORER">HONORER</option>
													<option value="IBU RUMAH TANGGA">IBU RUMAH TANGGA</option>
													<option value="KARYAWAN JAMSOSTEK">KARYAWAN JAMSOSTEK</option>
													<option value="KARYAWAN SWASTA">KARYAWAN SWASTA</option>
													<option value="KELUARGA MILITER">KELUARGA MILITER</option>
													<option value="KELUARGA PNS">KELUARGA PNS</option>
													<option value="LAIN LAIN">LAIN LAIN</option>
													<option value="MAHASISWA">MAHASISWA</option>
													<option value="NELAYAN">NELAYAN</option>
													<option value="PELAJAR">PELAJAR</option>
													<option value="PETANI">PETANI</option>
													<option value="PNS AD">PNS AD</option>
													<option value="PNS AL">PNS AL</option>
													<option value="PNS AU">PNS AU</option>
													<option value="PNS BUMN">PNS BUMN</option>
													<option value="PNS DEPARTEMENT">PNS DEPARTEMENT</option>
													<option value="PNS DKI">PNS DKI</option>
													<option value="PNS MABES TNI">PNS MABES TNI</option>
													<option value="PNS KEMENTERIAN">PNS KEMENTERIAN</option>
													<option value="POLISI">POLISI</option>
													<option value="TIDAK BEKERJA">TIDAK BEKERJA</option>
													<option value="TNI AD">TNI AD</option>
													<option value="TNI AL">TNI AL</option>
													<option value="TNI AU">TNI AU</option>
													<option value="WIRASWASTA">WIRASWASTA</option>
												</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Tingkat Pendidikan</label>
								<div class="col-sm-8">
									<div class="form-inline">
											<select class="form-control" style="width: 100%" name="kel_pendidikan">
												<option value="">-Pilih Pendidikan Terakhir-</option>
												<option value="SD">SD</option>
												<option value="SMP">SMP</option>
												<option value="SMA">SMA</option>
												<option value="D1">D1</option>
												<option value="D2">D2</option>
												<option value="D3">D3</option>
												<option value="D4">D4</option>
												<option value="S1">S1</option>
												<option value="S2">S2</option>
												<option value="S3">S3</option>
											</select>
									</div>
								</div>
							</div>
							<div class="form-group row">
									<div class="offset-sm-3 col-sm-8">
										<div class="demo-checkbox">						
                                    <input type="checkbox" class="filled-in" value="ya" name="chk_keluarga_tentara" id="chk_keluarga_tentara"/>
                                    <label for="chk_keluarga_tentara">Anggota Tentara/PNS</label>
                                		</div>
									</div>
							</div>
							<div id="keluarga_tentara">							
									<div class="form-group row" >
										<label class="col-sm-3 control-label col-form-label">Pangkat</label>
										<div class="col-sm-8">
											<select name="kel_pangkat" id="pangkat" class="form-control select2" style="width: 100%" >
												<option value="">-Pilih Pangkat-</option>
												<?php 
												foreach($pangkat as $row){
												echo '<option value="'.$row->pangkat_id.'">'.$row->pangkat.'</option>';
												}
												?>
														
											</select>
											
											
										</div>
									</div>
									<div class="form-group row" >
										<label class="col-sm-3 control-label col-form-label">Angkatan</label>
										<div class="col-sm-8">
											<select name="kel_angkatan" id="kel_angkatan" class="form-control select2" style="width: 100%" >
												<option value="">-Pilih Angkatan-</option>
												<?php 
												foreach($angkatan as $row){
												echo '<option value="'.$row->angkatan.'">'.$row->angkatan.'</option>';
												}
												?>
														
											</select>
											
											
										</div>
									</div>
									<div class="form-group row" >
										<label class="col-sm-3 control-label col-form-label">Kesatuan</label>
										<div class="col-sm-8">
											<select name="kel_kesatuan" id="kel_kesatuan" class="form-control select2" style="width: 100%" >
												<option value="">-Pilih Kesatuan-</option>
												<?php 
												foreach($kesatuan as $row){
												echo '<option value="'.$row->kst_id.'">'.$row->kst_nama.'</option>';
												}
												?>
														
											</select>
											
											
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 control-label col-form-label">Alamat Kesatuan</label>
										<div class="col-sm-8">
											<textarea class="form-control" name="kel_alamatkesatuan" rows="5"></textarea>
										</div>
									</div>	
									<div class="form-group row">
										<label class="col-sm-3 control-label col-form-label">No. Telp. Kesatuan</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="kel_telpkesatuan">
										</div>
									</div>	
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Jabatan</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="kel_jabatan">
								</div>
							</div>	
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Alamat Kantor</label>
								<div class="col-sm-8">
									<textarea class="form-control" name="kel_alamatkantor" rows="5"></textarea>
								</div>
							</div>	
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">No. Telp. Kantor</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="kel_telpkantor">
								</div>
							</div>		
						</div>
			</div>  -->
			<!-- detail_kerabat -->
			<hr>
			<div class="form-actions">
                <div class="row">
                    <div class="col-md-12">
                         <div class="row">
                             <div class="col-md-12 text-center">
                                <button type="reset" class="btn waves-effect waves-light btn-danger">Reset</button>
								<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">
								<button type="submit" class="btn waves-effect waves-light btn-primary" id="btn-submit">Simpan</button>
                             </div>
                         </div>
                     </div>
                </div>
            </div>
	<!-- 	</div>  -->
		<!-- end tab content -->
		<!-- <?php echo form_close();?> -->
	</form>
	</div><!-- Card Box -->
</div><!-- Card -->		
	<!-- sample modal content -->
      	<div class="modal fade modal_nobpjs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
          	<div class="modal-dialog modal-lg">
              	<div class="modal-content">
                  	<div class="modal-header text-center">
                      	<img class="pull-left" src="<?php echo site_url('assets/images/logos/logo_bpjs.png'); ?>" width="120"></img>                    	
                      	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  	</div>
                  	<div class="modal-body">
                  		<h4 class="text-center text-bold">DATA PESERTA BPJS</h4>
	                    <div class="table-responsive m-t-30" style="clear: both;">
						<table class="table-xs table-hover" width="100%">
					  <tbody>
					  	<tr>
							<td style="width: 25%;">No. Kartu BPJS</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_noka"></td>
						</tr>
						<tr>
							<td style="width: 25%;">NIK</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_nik"></td>
						</tr>						
						<tr>
							<td style="width: 25%;">Nama</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_nama"></td>
						</tr>						
						<tr>
							<td style="width: 25%;">Jenis Kelamin</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_gender"></td>
						</tr>
						<tr>
							<td style="width: 25%;">Tanggal Lahir</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_tgl_lahir"></td>
						</tr>
						<tr>
							<td style="width: 25%;">No. Telepon</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_no_telepon"></td>
						</tr>													
					  </tbody>
					</table>
					<hr>
					<h5 class="text-bold" style="font-size: 15px;color: ededed;font-weight: 600;">Provider Umum</h5>
					<table class="table-xs table-hover" width="100%">
					  <tbody>						  					  
						<tr>
							<td style="width: 25%;">Kode Provider</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_kdprovider"></td>
						</tr>		
						<tr>
							<td style="width: 25%;">Nama Provider</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_nmprovider"></td>
						</tr>					
					  </tbody>
					</table>
					<hr>
					<h5 class="text-bold" style="font-size: 15px;color: ededed;font-weight: 600;">Jenis Peserta</h5>
					<table class="table-xs table-hover" width="100%">
					  <tbody>						  						
						<tr>
							<td style="width: 25%;">Jenis Peserta</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_jnspeserta"></td>
						</tr>	
					  </tbody>
					</table>
					<hr>
					<h5 class="text-bold" style="font-size: 15px;color: ededed;font-weight: 600;">Hak Kelas</h5>
					<table class="table-xs table-hover" width="100%">
					  <tbody>						  						
						<tr>
							<td style="width: 25%;">Nama Kelas</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_nmkelas"></td>
						</tr>						
					  </tbody>
					</table>
					<hr>
					<h5 class="text-bold" style="font-size: 15px;color: ededed;font-weight: 600;">Status Peserta</h5>
					<table class="table-xs table-hover" width="100%">
					  <tbody>						  												
						<tr>
							<td style="width: 25%;">Keterangan</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_status_keterangan"></td>
						</tr>
					  </tbody>
					</table>					
					<hr>
					<h5 class="text-bold" style="font-size: 15px;color: ededed;font-weight: 600;">COB</h5>
					<table class="table-xs table-hover" width="100%">
					  <tbody>
					  	<tr>
							<td style="width: 25%;">Nama Asuransi</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_cob_nama"></td>
						</tr>						
						<tr>
							<td style="width: 25%;">No. Asuransi</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_cob_nomor"></td>
						</tr>	
						<tr>
							<td style="width: 25%;">Tanggal TAT</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_cob_tat"></td>
						</tr>	
						<tr>
							<td style="width: 25%;">Tanggal TMT</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_cob_tmt"></td>
						</tr>								
					  </tbody>
					</table>					
					<hr>
					<h5 class="text-bold" style="font-size: 15px;color: ededed;font-weight: 600;">Informasi</h5>
					<table class="table-xs table-hover" width="100%">
					  <tbody>
					  	<tr>
							<td style="width: 25%;">Dinsos</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_informasi_dinsos"></td>
						</tr>						
						<tr>
							<td style="width: 25%;">No. SKTM</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_informasi_sktm"></td>
						</tr>
						<tr>
							<td style="width: 25%;">Prolanis PRB</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_informasi_prb"></td>
						</tr>															
					  </tbody>
					</table>	
						</div>
                  	</div>
                  	<div class="modal-footer">
                  		<button type="button" class="btn btn-primary waves-effect text-left" onclick="terapkan_data_bpjs()">Terapkan Data</button>
                      	<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                  	</div>
              	</div>
              	<!-- /.modal-content -->
          	</div>
          	<!-- /.modal-dialog -->
      	</div>
      	<!-- /.modal -->		
	
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 