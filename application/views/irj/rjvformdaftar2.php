<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
	
	//cek jenis kunjungan
	if ( date("Y-m-d") == substr($data_pasien->tgl_daftar,0,10) ) 
		$jns_kunjungan="BARU";
	else $jns_kunjungan="LAMA";
?>
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script> 
<style type="text/css">
	.table-wrapper-scroll-y {
		display: block;
		max-height: 350px;
		overflow-y: auto;
		-ms-overflow-style: -ms-autohiding-scrollbar;
	}
	input:focus::-webkit-input-placeholder { color:transparent; }
	input:focus:-moz-placeholder { color:transparent; } /* FF 4-18 */
	input:focus::-moz-placeholder { color:transparent; } /* FF 19+ */
	input:focus:-ms-input-placeholder { color:transparent; } /* IE 10+ */
	::-webkit-input-placeholder {
   		font-style: italic;
	}
	:-moz-placeholder {
	   font-style: italic;  
	}
	::-moz-placeholder {
	   font-style: italic;  
	}
	:-ms-input-placeholder {  
	   font-style: italic; 
	}
	.demo-radio-button label{
		min-width:120px;
	}
	.ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight {
	    border: 1px solid #dad55e;
	    background: #fffa90;
	    color: #777620;
	    font-weight: normal;
	}
	.ui-widget-content {    
	  	font-size: 15px;
	}
	.ui-widget-content .ui-state-active {    
	  	font-size: 15px;
	}
	.ui-autocomplete-loading {
		background: white url("<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>") right 10px center no-repeat;
	}	
	.ui-autocomplete { 
		max-height: 270px; overflow-y: scroll; overflow-x: scroll;
	}
</style>

<script type='text/javascript'>
var table_keluarga;
var site = "<?php echo site_url();?>";

$(document).ready(function() {
	<?php
		if($online==1){
	?>
		$.ajax({
		    url: '<?php echo base_url('irj/rjconline/get_data_online')?>/'+<?=$id_online;?>,
		    type: "GET",
		    dataType: "JSON",
		    success:function(data) {
				$('#id_poli').val(data.id_poli_temp).change();
				$('#cara_bayar').val(data.cara_bayar_temp).change();
				$('#no_rujukan').val(data.no_rujukan_temp).change();
				$('#tgl_kunjungan').val(data.tgl_berobat_temp).change();
		        
		    }
		});	
	<?php
		}
	?>
	
});

$(function() {
	// $('#div_table_keluarga').hide();
 //    $('#form_input_keluarga').hide();
	// alert($('#kesatuan').val());
	// $('#keluarga_tentara').hide();
		$(".select2").select2();
		$(".autocomplete_diagnosa").autocomplete({  
	      	minLength: 2,  
	      	source : function( request, response ) {
		        $.ajax({
		            url: '<?php echo site_url('irj/rjcpelayanan/autocomplete_diagnosa')?>',
		            dataType: "json",
		            data: {
		                term: request.term
		            },
		            success: function (data) {
		              if(!data.length){
		                var result = [{
		                 label: 'Data tidak ditemukan', 
		                 value: response.term
		                }];
		                response(result);
		              } else {
		                response(data);                  
		              }                  
		            }
		        });
	      },      
	      minLength: 1,     
	      select: function (event, ui) {          
	          $('#diagnosa').val(ui.item.id_icd+' - '+ui.item.nm_diagnosa);
			  $('#id_diagnosa').val(ui.item.id_icd);                   
	      }
	    }).on("focus", function () {
	        $(this).autocomplete("search", $(this).val());
	    }); 
	     
		$(document).on("click","#btn-bpjs-biodata",function() {
		var button = $(this);
		var no_bpjs = $("#no_kartu_bpjs").val();
		button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
		if (no_bpjs == '') {
	    	button.html('Data Peserta');
	    	swal("No. Kartu Kosong","Harap masukan nomor kartu BPJS.", "warning"); 
	    } else {       	
		    $.ajax({
		        type: "POST",
		        url: "<?php echo site_url('bpjs/peserta/no_kartu'); ?>",
		        dataType: "JSON",
		        data: {"no_bpjs" : no_bpjs},
		        success: function(result){ 
		        	console.log(result);
		        	if (result) {
		        		button.html('Data Peserta');
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
		        			swal("Gagal Data Peserta.",result.metaData.message, "error");
		        		}	              	
		        	} else {
		        		button.html('Data Peserta');
		              	swal("Error","Gagal Data Peserta.", "error");  
		        	}
		        },
		        error:function(event, textStatus, errorThrown) { 
		        	button.html('Data Peserta');
		            swal("Error",formatErrorMessage(event, errorThrown), "error");                 
		            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		        }
		    });
	    }
    });
	$(document).on('hidden.bs.modal', '#modal-search-kode', function () {
	    $('#table-dpjp > tbody').empty();
	    $('#spesialis').val("NONE").change();
	});
	$(document).on("click",".select-kode-dpjp",function() {
	    $("#dpjp_skdp_sep").val($(this).data('kodedpjp'));
	    $('#modal-search-kode').modal('hide');
	});	
	$(document).on("click","#btn-cari-dpjp",function() {
	    var button = $(this);
	    var jns_pelayanan = $("#jns_pelayanan").val();
	    var spesialis = $("#spesialis").val();
	    button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
	    if (jns_pelayanan === '' || spesialis === '') {
	        button.html('<i class="fa fa-search"></i> Cari');
	        swal("Lengkapi Data","Silahkan isi jenis pelayanan dan spesialis/sub spesialis.", "warning"); 
	    } else {        
	      $.ajax({
	          type: "POST",
	          url: "<?php echo site_url('bpjs/referensi/dokter_dpjp'); ?>"+"/"+jns_pelayanan+"/"+spesialis,
	          dataType: "JSON",
	          success: function(result) { 
	            $('#table-dpjp > tbody').empty();
	            button.html('<i class="fa fa-search"></i> Cari');
	            if (result != '' || result != null) {
	              if (result.metaData.code == '200') {
	                $.each(result.response.list, function(i, item) {
	                  $('#table-dpjp > tbody:last-child').append(
	                    '<tr>'
	                    +'<td class="text-center">'+item.kode+'</td>'
	                    +'<td class="text-center">'+item.nama+'</td>'
	                    +'<td class="text-center"><button class="btn btn-danger select-kode-dpjp" data-kodedpjp="'+item.kode+'"><i class="fa fa-check"></i> Pilih</button></td>'
	                    +'</tr>'
	                  );
	                });   
	              } else {
	                $('#table-dpjp > tbody:last-child').append(
	                  '<tr>'
	                  +'<td colspan="3" class="text-center">'+result.metaData.message+'</td>'
	                  +'</tr>'
	                );
	              }
	            } else {
	              swal("Error","Gagal load data dokter dpjp.", "error");  
	            }
	          },
	          error:function(event, textStatus, errorThrown) { 
	            button.html('<i class="fa fa-search"></i> Cari');
	            swal("Error",formatErrorMessage(event, errorThrown), "error");                   
	            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
	          }
	      });
	    }
	});
    $(document).on("click","#btn-bpjs-daful",function() {
		var button = $(this);
		var no_bpjs = $("#no_bpjs").val();
		button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
		if (no_bpjs == '') {
	    	button.html('Data Peserta');
	    	swal("No. Kartu Kosong","Harap masukan nomor kartu BPJS.", "warning"); 
	    } else {       	
		    $.ajax({
		        type: "POST",
		        url: "<?php echo site_url('bpjs/peserta/no_kartu'); ?>",
		        dataType: "JSON",
		        data: {"no_bpjs" : no_bpjs},
		        success: function(result){ 
		        	console.log(result);
		        	if (result) {
		        		button.html('Data Peserta');
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
		        			swal("Gagal Data Peserta.",result.metaData.message, "error");
		        		}	              	
		        	} else {
		        		button.html('Data Peserta');
		              	swal("Error","Gagal Data Peserta.", "error");  
		        	}
		        },
		        error:function(event, textStatus, errorThrown) { 
		        	button.html('Data Peserta');
		            swal("Error",formatErrorMessage(event, errorThrown), "error");                 
		            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		        }
		    });
	    }
    });
    $(document).on("click","#btn-rujukan-kartu",function() {
		var button = $(this);
		var no_bpjs = $("#no_bpjs").val();
		button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
		if (no_bpjs == '') {
	    	button.html('<i class="fa fa-eye"></i> Lihat Rujukan');
	    	swal("No. Kartu Kosong","Harap masukan nomor kartu.", "warning"); 
	    } else {       	
		    $.ajax({
		        type: "POST",
		        url: "<?php echo site_url('bpjs/rujukan/no_bpjs'); ?>"+"/"+no_bpjs,
		        dataType: "JSON",	  
		        data: {"jenis_faskes" : $('#cara_kunjungan').val()},    
		        success: function(result){ 
		        	console.log(result);
		        	button.html('<i class="fa fa-eye"></i> Lihat Rujukan');
		        	if (result != '') {
		        		if (result.metaData.code == '200') {	        				
		        			data = result.response.rujukan;	        				        		
		        			$('#rujukan_nomor').html(data.noKunjungan);
		        			$('#rujukan_tgl').html(data.tglKunjungan);
		        			$('#rujukan_faskes').html(data.provPerujuk.kode + ' - ' + data.provPerujuk.nama);
		        			$('#rujukan_poli').html(data.poliRujukan.nama+' (<span id="rujukan_kode_poli">'+data.poliRujukan.kode+'</span>)');
		        			$('#rujukan_nama').html(data.peserta.nama);
		        			$('#rujukan_noka').html(data.peserta.noKartu);
		        			$('#rujukan_diagnosa').html(data.diagnosa.kode + ' - ' + data.diagnosa.nama);
		        			if (data.peserta.sex === 'L') {
		        				$('#rujukan_gender').html('Laki-Laki');
		        			} else if (data.peserta.sex === 'P') {
		        				$('#rujukan_gender').html('Perempuan');
		        			} else {
		        				$('#rujukan_gender').html(data.peserta.sex);
		        			}
		        			$('#rujukan_jenis_rawat').html(data.pelayanan.nama);
		        			$('.modal_norujukan').modal('show');
		        		} else {
		        			swal("Lihat Rujukan",result.metaData.message, "warning");
		        		}	              	
		        	} else {
		              	swal("Gagal Lihat Rujukan","Terjadi Kesalahan, Silahkan Coba Kembali.", "error");  
		        	}
		        },
		        error:function(event, textStatus, errorThrown) { 
		        	button.html('<i class="fa fa-eye"></i> Lihat Rujukan');
		            swal("Error",formatErrorMessage(event, errorThrown), "error");                   
		            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		        }
		    });
	    }
    });
    $(document).on("click","#btn-rujukan",function() {
		var button = $(this);
		var no_rujukan = $("#no_rujukan").val();
	    var cara_kunjungan = $("#cara_kunjungan").val();
	    var service_url;
	    button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
	    if (cara_kunjungan === 'RUJUKAN RS') {
	    	service_url = "<?php echo site_url('bpjs/rujukan/rs'); ?>"+"/"+no_rujukan;
	    } else service_url = "<?php echo site_url('bpjs/rujukan/pcare'); ?>"+"/"+no_rujukan;
	    if (cara_kunjungan === '') {
	    	button.html('<i class="fa fa-eye"></i> Lihat Rujukan');
	    	swal("Gagal Lihat Rujukan","Silahkan pilih cara kunjungan terlebih dahulu.", "warning"); 
	    } else {    	
	    	if (no_rujukan == '') {
		    	button.html('<i class="fa fa-eye"></i> Lihat Rujukan');
		    	swal("No. Rujukan Kosong","Silahkan masukan nomor rujukan.", "warning"); 
		    } else {       	
			    $.ajax({
			        type: "POST",
			        url: service_url,
			        dataType: "JSON",		        
			        success: function(result){ 
			        	button.html('<i class="fa fa-eye"></i> Lihat Rujukan');	        	
			        	if (result != '') {
			        		if (result.metaData.code == '200') {		        				
			        			data = result.response.rujukan;	        				        		
			        			$('#rujukan_nomor').html(data.noKunjungan);
			        			$('#rujukan_tgl').html(data.tglKunjungan);
			        			$('#rujukan_faskes').html(data.provPerujuk.kode + ' - ' + data.provPerujuk.nama);
			        			$('#rujukan_poli').html(data.poliRujukan.nama+' (<span id="rujukan_kode_poli">'+data.poliRujukan.kode+'</span>)');
			        			$('#rujukan_nama').html(data.peserta.nama);
			        			$('#rujukan_noka').html(data.peserta.noKartu);
			        			$('#rujukan_diagnosa').html(data.diagnosa.kode + ' - ' + data.diagnosa.nama);
			        			if (data.peserta.sex === 'L') {
			        				$('#rujukan_gender').html('Laki-Laki');
			        			} else if (data.peserta.sex === 'P') {
			        				$('#rujukan_gender').html('Perempuan');
			        			} else {
			        				$('#rujukan_gender').html(data.peserta.sex);
			        			}
			        			$('#rujukan_jenis_rawat').html(data.pelayanan.nama);
			        			$('.modal_norujukan').modal('show');		        				        	
			        		} else {		        			
			        			swal("Gagal Lihat Rujukan",result.metaData.message, "error");
			        		}	              	
			        	} else {		        		
			              	swal("Error","Gagal Lihat Rujukan", "error");  
			        	}
			        },
			        error:function(event, textStatus, errorThrown) { 
			        	button.html('<i class="fa fa-eye"></i> Lihat Rujukan');
			            swal("Error",formatErrorMessage(event, errorThrown), "error");                   
			            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
			        }
			    });
		    }
	    } 
    });
		var jenis_identitas = $('#jenis_identitas').val();
		var val_cara_bayar = $('#cara_bayar').val();
		var alasan_berobat = $('#alasan_berobat').val();
		var cara_kunjungan = $('#cara_kunjungan').val();
		set_ident(jenis_identitas);
		pilih_cara_bayar(jenis_identitas);
		pilih_alber(alasan_berobat);
		pilih_kunjungan(cara_kunjungan);
		show_keluarga();
		table_keluarga = $('#table_keluarga').DataTable({ 
		  "language": {
	      	"emptyTable": "Tidak ada data keluarga/kerabat"
	      },
	      "processing": true,
	      "serverSide": true,
	      "order": [],
	      "lengthMenu": [
	        [ 10, 25, 50, -1 ],
	        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
	      ],
	      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	      "ajax": {
	        "url": "<?php echo site_url('irj/rjcregistrasi/data_keluarga/')?>",
	        "type": "POST",
	        "dataType": 'JSON',
	        "data": function (data) {
	          data.no_nrp = '<?php echo $data_pasien->no_nrp; ?>';
	          data.no_cm = '<?php echo $data_pasien->no_cm; ?>';
	        } 
	      }   
	    });
	    table_keluarga.on('draw', function () {
	        /* Now you can count rows */
	        var count = table_keluarga.data().count();
	        var nrp_sbg = '<?php echo $data_pasien->nrp_sbg; ?>';

	        if (count > 0) {
	        	$('#btn_modal').attr('data-target','#modal_keluarga_anggota');
	        } else {
	        	if (nrp_sbg == 'T') {
	        		$('#btn_modal').attr('data-target','#modal_keluarga_anggota');
	        	} else {
	        		$('#btn_modal').attr('data-target','#modal_keluarga');
	        	}	        	
	        }
		});
	$(".jns_kunj").attr('readonly', true);
	$('#hubungan').hide();
	$("#duplikat_id").hide();
	$("#duplikat_kartu").hide();
	$('#input_kontraktor').hide();
	$('#input_diagnosa').hide();
	$('#input_kecelakaan').hide();
	$('#ird').hide();
	$(".div_bpjs").hide();
	$('#div_rujukan').hide();
	$('#div_katarak').hide();
	$('.div_skdp').hide();
	

	// $('.auto_diagnosa_pasien').autocomplete({
	// 	serviceUrl: site+'iri/ricstatus/data_icd_1',
	// 	onSelect: function (suggestion) {
	// 		//$('#no_cm').val(''+suggestion.no_cm);
	// 		$('#diagnosa').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
	// 		$('#id_diagnosa').val(''+suggestion.id_icd);
	// 		// $('#nama').val(''+suggestion.nama);
	// 		// $('.tanggal_lahir').val(''+suggestion.tanggal_lahir);
	// 		// if(suggestion.jenis_kelamin=='L'){
	// 		// 	$('#laki_laki').attr('selected', 'selected');
	// 		// 	$('#perempuan').removeAttr('selected', 'selected');
	// 		// }else{
	// 		// 	$('#laki_laki').removeAttr('selected', 'selected');
	// 		// 	$('#perempuan').attr('selected', 'selected');
	// 		// }
	// 		// $('#telp').val(''+suggestion.telp);
	// 		// $('#hp').val(''+suggestion.hp);
	// 		// $('#id_poli').val(''+suggestion.id_poli);
	// 		// $('#poliasal').val(''+suggestion.poliasal);
	// 		// $('#id_dokter').val(''+suggestion.id_dokter);
	// 		// $('#dokter').val(''+suggestion.dokter);
	// 		// $('#diagnosa').val(''+suggestion.diagnosa);
	// 	}
	// });

	$('.auto_search_by_nocm').autocomplete({
		serviceUrl: site+'/irj/rjcautocomplete/data_pasien_by_nocm',
		onSelect: function (suggestion) {
			$('#cari_no_cm').val(''+suggestion.no_medrec);
		}
	});
	
	$('.auto_search_by_nokartu').autocomplete({
		serviceUrl: site+'/irj/rjcautocomplete/data_pasien_by_nokartu',
		onSelect: function (suggestion) {
			$('#cari_no_kartu').val(''+suggestion.no_kartu);
		}
	});
	$('.auto_search_by_noidentitas').autocomplete({
		serviceUrl: site+'/irj/rjcautocomplete/data_pasien_by_noidentitas',
		onSelect: function (suggestion) {
			$('#cari_no_identitas').val(''+suggestion.no_identitas);
		}
	});
	$('.auto_search_poli').autocomplete({
		serviceUrl: site+'/irj/rjcautocomplete/data_poli',
		onSelect: function (suggestion) {
			$('#id_poli').val(''+suggestion.id_poli);
			$('#kd_ruang').val(''+suggestion.kd_ruang);
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
	
	$('.date_picker').datepicker({
		format: "yyyy-mm-dd",
		//endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  
	
	var jns_kunj = '<?php echo $jns_kunjungan; ?>';
		/*var biayakarcis_baru = '<?php echo $biayakarcis->nilai_karcis_baru; ?>';
		var biayakarcis_lama = '<?php echo $biayakarcis->nilai_karcis_lama; ?>';*/
		
		if (jns_kunj=='BARU') {
			var id_poli_umum = '<?php echo $poliumum; ?>';
			$('#id_poli').val(id_poli_umum).change();
			ajaxdokter(id_poli_umum);			
		}
	if($('#chk1').prop('checked')==false){
	  	$('#input_tentara').hide();
	  	document.getElementById("no_nrp").required= false;
		document.getElementById("nrp_sbg").required= false;
	  }else{
	  	$('#input_tentara').show();
	  	document.getElementById("no_nrp").required= true;
		document.getElementById("nrp_sbg").required= true;
	  }

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
	// $('#chk_keluarga_tentara').change(function() {
	//   if($(this).prop('checked')==false){
	//   	$('#keluarga_tentara').hide();
	//   }else{
	//   	$('#keluarga_tentara').show();
	//   }
	// });

});
function pilih_cara_bayar(val_cara_bayar){

	var alasan_berobat = $('#alasan_berobat').val();
	if (val_cara_bayar === 'BPJS' && alasan_berobat === 'kecelakaan') {
		$('#input_penjamin_kkl').show();
	} else {
		$('#input_penjamin_kkl').hide();
	}

	if (val_cara_bayar == 'KERJASAMA'){
		$('#input_kontraktor').show();
		$('.div_bpjs').hide();
		$("#div_rujukan").hide();
		document.getElementById("button_cetak_karcis").disabled= false;
		document.getElementById("id_kontraktor").required = true;
		document.getElementById("no_rujukan").required = false;

		$.ajax({
            url: '<?php echo base_url('irj/rjcregistrasi/data_kontraktor')?>/'+val_cara_bayar,
            type: "GET",
            dataType: "JSON",
            success:function(data) {
                $('select[name="id_kontraktor"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="id_kontraktor"]').append('<option value="'+ value.id_kontraktor +'">'+ value.nmkontraktor +'</option>');
                });
            }
        });		

	} else if (val_cara_bayar == 'BPJS') {
		$('#input_diagnosa').show();
		$('.div_bpjs').show();
		$('#input_kontraktor').show();
		document.getElementById("id_kontraktor").required = false;
        $.ajax({
            url: '<?php echo base_url('irj/rjcregistrasi/data_kontraktor')?>/'+val_cara_bayar,
            type: "GET",
            dataType: "JSON",
            success:function(data) {
                $('select[name="id_kontraktor"]').empty();
                $.each(data, function(key, value) {
                    if (value.nmkontraktor === 'BPJS Kesehatan') {
                		$('select[name="id_kontraktor"]').append('<option value="'+ value.id_kontraktor +'" selected>'+ value.nmkontraktor +'</option>');
                	} else {
                		$('select[name="id_kontraktor"]').append('<option value="'+ value.id_kontraktor +'">'+ value.nmkontraktor +'</option>');
                	}
                });
            }
        });
		//cek no kartu
		// var noBpjs = "<?php echo $data_pasien->no_kartu; ?>";	
		// if(noBpjs!=''){
		// 	$('#no_bpjs').val(noBpjs);
			//$('#content_div_bpjs').val('No. Kartu : '+noBpjs);
		// }
		//$('#biayadaftar_').val(0);
		//$('#biayadaftar').val(0);
		//document.getElementById("no_rujukan").required = true;
		//document.getElementById("id_diagnosa").required = true;		
	} else {
		$('select[name="id_kontraktor"]').empty();
		document.getElementById("button_cetak_karcis").disabled= false;
		$('#input_diagnosa').hide();
		$('.div_bpjs').hide();
		$('#div_rujukan').hide();
		$('#input_kontraktor').hide();	
		document.getElementById("id_kontraktor").required = false;
		document.getElementById("no_rujukan").required = false;
	}
	var cara_kunjungan = $('#cara_kunjungan').val();
	pilih_kunjungan(cara_kunjungan);
}

function pilih_kunjungan(cara_kunjungan) {
	var cara_bayar = $('#cara_bayar').val();
	var cara_kunjungan = $('#cara_kunjungan').val();
	if (cara_bayar === 'BPJS' && (cara_kunjungan === 'RUJUKAN PUSKESMAS' || cara_kunjungan === 'RUJUKAN RS')) {
		$('#div_rujukan').show();
	} else {
		$('#div_rujukan').hide();
	}
	if(cara_kunjungan == 'RUJUKAN RS') {
		$('#jenis_faskes').val(2);	
	} else {
		$('#jenis_faskes').val(1);	
	}
}

var ajaxku;
function ajaxkota(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi/data_kotakab'); ?>";
    url=url+"/"+res[0];
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedKota;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	document.getElementById("id_provinsi").value = res[0];
	document.getElementById("provinsi").value = res[1];
}

// function set_rujukan(rujukan){
// 	if(rujukan=='1'){
// 		$('#rujukan_lainnya').show();
// 		document.getElementById("dll_rujukan").required = true;
// 	}else{
// 		$('#rujukan_lainnya').hide();
// 		document.getElementById("dll_rujukan").required = false;
// 	}
// }

function ajaxkec(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi/data_kecamatan'); ?>";
    url=url+"/"+res[0];
    url=url+"/"+Math.random();irj/rjcregistrasi/pasien
    ajaxku.onreadystatechange=stateChangedKec;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	document.getElementById("id_kotakabupaten").value = res[0];
	document.getElementById("kotakabupaten").value = res[1];
}

function ajaxkel(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi/data_kelurahan'); ?>";
    url=url+"/"+res[0];
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedKel;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	document.getElementById("id_kecamatan").value = res[0];
	document.getElementById("kecamatan").value = res[1];
}
function setkel(id){
	var res=id.split("-");//it Works :D
	document.getElementById("id_kelurahandesa").value = res[0];
	document.getElementById("kelurahandesa").value = res[1];
}

function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}
function stateChangedKota(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
		document.getElementById("kota").innerHTML = data;
		document.getElementById("kec").innerHTML = "<option selected value=\"\">Pilih Kecamatan</option>";
		document.getElementById("kel").innerHTML = "<option selected value=\"\">Pilih Kel/Desa</option>";
    }else{
    document.getElementById("kota").value = "<option selected value=\"\">Pilih Kota/Kab</option>";
    }
    }
}

function stateChangedKontraktor(){
    var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("id_kontraktor").innerHTML = data;
		}
    }
}

function stateChangedKec(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
    document.getElementById("kec").innerHTML = data
    }else{
    document.getElementById("kec").value = "<option selected value=\"\">Pilih Kecamatan</option>";
    }
    }
}

function stateChangedKel(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
    document.getElementById("kel").innerHTML = data
    }else{
    document.getElementById("kel").value = "<option selected value=\"\">Pilih Kelurahan/Desa</option>";
    }
    }
}

// function pilih_alber(val_alber){
// 		var res=val_alber.split("-");//it Works :D				
// 		if(res=='kecelakaan'){
// 			$('#input_kecelakaan').show();
// 			$('#input_penjamin').show();
// 			document.getElementById("jenis_kecelakaan").required= true;

// 		}else if(res=='sakit'){
// 			$('#input_kecelakaan').hide();
// 			$('#input_penjamin').hide();
// 			document.getElementById("jenis_kecelakaan").required= false;
// 		} else { }
// }

function pilih_alber(val_alber) {
	// var res = val_alber.split("-");	
	var cara_bayar = $('#cara_bayar').val();		
	if (val_alber === 'kecelakaan') {
		$('#input_kecelakaan').show();			
		document.getElementById("jenis_kecelakaan").required= true;
		if (cara_bayar === 'BPJS') {
			$('#input_penjamin_kkl').show();
		} else {
			$('#input_penjamin_kkl').hide();
		}

	} else {
		$('#input_kecelakaan').hide();	
		$('#input_penjamin_kkl').hide();		
		document.getElementById("jenis_kecelakaan").required= false;
	}
}

function ajaxdokter(id_poli){
	var val_cara_bayar = $('#cara_bayar').val();
	var cara_kunjungan = $('#cara_kunjungan').val();
	//var res=id.split("-");//it Works :D
	if (id_poli=='BA00') {
		if (cara_kunjungan == 'RUJUKAN PUSKESMAS' || cara_kunjungan == 'RUJUKAN RS' && val_cara_bayar == 'BPJS') {
			$('.div_bpjs').show();
			$('#div_rujukan').show();
		} else if (cara_kunjungan === 'DATANG SENDIRI' && val_cara_bayar == 'BPJS') {
			$('.div_bpjs').show();
			$('#no_rujukan').val('');
			$('#div_rujukan').hide();
		} else {
			$('#no_rujukan').val('');
			$('.div_bpjs').hide();
			$('#div_rujukan').hide();
		}
		$('#ird').show();
		$('#hubungan').show();
	} else {
		if (val_cara_bayar == 'BPJS') {
			if (id_poli == 'BH00') {
				$('#div_katarak').show();
			} else {
				$('#div_katarak').hide();
			}
		}
		$('#ird').hide();
		$('#hubungan').hide();
	}

    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi/data_dokter_poli'); ?>";
    url=url+"/"+id_poli;
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedDokter;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	//document.getElementById("id_provinsi").value = res[0];
	//document.getElementById("provinsi").value = res[1];  
	
}
function stateChangedDokter(){
    var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("id_dokter").innerHTML = data;
		}/*else{
		document.getElementById("id_dokter").value = "<option selected value=\"\">Pilih Kota/Kab</option>";
		}*/
    }
}

function terapkan_data_rujukan() {
	var diagnosa = $('#rujukan_diagnosa').text();	
	var no_rujukan = $('#rujukan_nomor').text();	
	var kode_poli = $('#rujukan_kode_poli').text();	

	var explode = diagnosa.split(" - ");
	var kode_diagnosa = explode[0];

	$('#no_rujukan').val(no_rujukan);
	$.ajax({
        type: "POST",
        url: "<?php echo site_url('bpjs/pasien/get_poli_bpjs'); ?>/"+kode_poli,
        dataType: "JSON",		        
        success: function(result){ 
        	console.log(result);		        	
        	if (result != '') {
        		$("#id_poli").val(result.id_poli).trigger('change');
        	}
        },
        error:function(event, textStatus, errorThrown) {        
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
	$('#diagnosa').val(diagnosa);	
	$('#id_diagnosa').val(kode_diagnosa);	
	$('.modal_norujukan').modal('hide');
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

// function cek_validasi(no_medrec){
//     ajaxku = buatajax();
//     var url="<?php echo site_url('irj/rjcwebservice/check_no_kartu'); ?>";
//     url=url+"/"+no_medrec;
//     ajaxku.onreadystatechange=stateChangedValidasi;
//     ajaxku.open("GET",url,true);
//     ajaxku.send(null);
// }	

// function cek_rujukan(){
// 	var no_rujukan = document.getElementById("no_rujukan").value;
// 	var e = document.getElementById("cara_kunjungan");
// 	var get_cara_kunjungan = e.options[e.selectedIndex].value;
// 	if (get_cara_kunjungan == 'RUJUKAN RS') {
// 		var cara_kunjungan = 'RS';
// 	}
// 	else {
// 		var cara_kunjungan = 'PCare';
// 	}	
// 	if (no_rujukan.length == 0) {		
// 	swal("Cek Nomor Rujukan", "Silahkan masukkan nomor rujukan", "error");
// 	}
// 	else {
//     ajaxku = buatajax();
//     var url="<?php echo site_url('irj/rjcwebservice/check_no_rujukan'); ?>";
//     url=url+"/"+no_rujukan+"/"+cara_kunjungan;
//     ajaxku.onreadystatechange=stateChangedValidasiRujukan;
//     ajaxku.open("GET",url,true);
//     ajaxku.send(null);
//     }
// }

// function stateChangedValidasi(){
// 	document.getElementById("btn_cek_kartu").innerHTML = '<i class="fa fa-spinner fa-spin" id="loading-rujukan"></i> Loading...';
// 	var data;
//     if (ajaxku.readyState==4){
// 		data=ajaxku.responseText;
// 		if (data.indexOf('Tidak Ditemukan')!= -1 || data.indexOf('Masukan')!= -1) {			

// 		}
// 		if(data.length>=0){
// 			document.getElementById("data_validasi").innerHTML = data;
// 			$('#modal_validasi').modal('show');
// 		}else{
// 			document.getElementById("data_validasi").innerHTML = "Data Tidak Ditemukan";
// 		}
// 		document.getElementById("btn_cek_kartu").innerHTML = "Cek Kartu";
//     }
// }

// function stateChangedValidasiRujukan(){
// 	var data;
//     if (ajaxku.readyState==4){
// 		data=ajaxku.responseText;
// 		if(data.length>=0){
// 			document.getElementById("data_validasi").innerHTML = data;
			
// 		}else{
// 			document.getElementById("data_validasi").innerHTML = "Data Tidak Ditemukan";
// 		}
// 		if (data.indexOf('Tidak Ditemukan')!= -1 || data.indexOf('Masukan')!= -1) {	
// 			// $('#modal_validasi').modal('show');		
// 			// document.getElementById("cara_bayar" ).disabled=false;
// 			// document.getElementById("cara_bayar").selectedIndex = "0";
// 			document.getElementById("diagnosa" ).disabled=false;
// 			document.getElementById("id_poli" ).disabled=false;
// 			document.getElementById('id_poli').value = '';
// 			document.getElementById('kode_provider').value='';
// 			document.getElementById('diagnosa').value='';
// 			document.getElementById('entri_catatan').value='';	
// 			swal("Cek Nomor Rujukan", "Silahkan masukkan nomor rujukan yang valid", "error");
// 		}
// 		else {
// 			// document.getElementById('cara_bayar').value = 'BPJS';
// 			// document.getElementById("cara_bayar" ).disabled=true;
// 			document.getElementById("diagnosa" ).disabled=false;
// 			document.getElementById("id_poli" ).disabled=false;
// 			var data1 = JSON.parse(data);
// 			document.getElementById('kode_provider').value=data1["response"].item.provKunjungan.kdProvider;
// 			document.getElementById('diagnosa').value=data1["response"].item.diagnosa.kdDiag;
// 			document.getElementById('entri_catatan').value=data1["response"].item.catatan;
// 			var update_kartu = document.getElementById("no_kartu_bpjs").value;
// 			if (update_kartu.length == 0) {
// 			swal({
//   			title: ""+data1["response"].item.peserta.nama+"",
//   			type: "success",
//   			text: "<p>Nomor Kartu : "+data1["response"].item.peserta.noKartu+"<p/><p>NIK : "+data1["response"].item.peserta.nik+"<p/><p>Status Peserta : "+data1["response"].item.peserta.statusPeserta+"</p>",
//   			html: true,
// 			showCancelButton: true,
//   			confirmButtonColor: "#DD6B55",
//   			confirmButtonText: "Simpan Nomor Kartu",
//   			closeOnConfirm: false
// 			},
// 			function(){
// 			update_nokartu(data1["response"].item.peserta.noKartu);
//   			swal("Sukses", "Nomor kartu berhasil disimpan.", "success");
// 			});		  							
// 			}
// 			if (update_kartu.length > 0) {
// 			swal({
//   			title: ""+data1["response"].item.peserta.nama+"",
//   			type: "success",
//   			text: "<p>Nomor Kartu : "+data1["response"].item.peserta.noKartu+"<p/><p>NIK : "+data1["response"].item.peserta.nik+"<p/><p>Status Peserta : "+data1["response"].item.peserta.statusPeserta+"</p>",
//   			html: true,
//   			showCancelButton: true,
//   			confirmButtonColor: "#DD6B55",
//   			confirmButtonText: "Update Nomor Kartu",
//   			closeOnConfirm: false
// 			},
// 			function(){
// 			update_nokartu(data1["response"].item.peserta.noKartu);
//   			swal("Sukses", "Nomor kartu berhasil diupdate.", "success");
// 			});				
// 			}			
// 			// swal(""+data1["response"].item.peserta.nama+"", "Nomor Kartu : "+data1["response"].item.peserta.noKartu+"", "success");	
// 		}
//     }
// }

function cek_eligible(no_medrec){
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcwebservice/check_no_kartu'); ?>";
    url=url+"/"+no_medrec;
    ajaxku.onreadystatechange=stateChangedSEP;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
}	
	
// function stateChangedSEP(){
//     var data;
//     if (ajaxku.readyState==4){
//     data=ajaxku.responseText;
// 		if(data.length>=0){
// 			document.getElementById("data_anggota").innerHTML = data;
// 			$('#data_webservice').modal('show');
// 		}else{
// 			document.getElementById("data_anggota").innerHTML = "Data Tidak Ditemukan";
// 		}
//     }
// }

	
function cek_search_per(val_search_per){
	//alert(val_search_per);
	if(val_search_per=='cm'){
		$("#cari_no_cm").css("display", ""); // To unhide
		$("#cari_no_kartu").css("display", "none");  // To hide
		$("#cari_no_identitas").css("display", "none");
	}
	else if(val_search_per=='kartu'){
		$("#cari_no_cm").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", ""); 
		$("#cari_no_identitas").css("display", "none");
	}else{
		$("#cari_no_cm").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", ""); 
		
	}
}

function cek_no_identitas(no_identitas, no_identitas_old){
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi/cek_available_noidentitas')?>/"+no_identitas+"/"+no_identitas_old,
		success: function(data){
			if (data>0) {
				document.getElementById("content_duplikat_id").innerHTML = "<i class=\"icon fa fa-ban\"></i> No Identitas \""+no_identitas+"\" Sudah Terdaftar ! <br>Silahkan masukkan no identitas lain...";
				$("#duplikat_id").show();
				document.getElementById("btn-submit").disabled= true;
				//$(window).scrollTop(0);
			} else {
				$("#duplikat_id").hide();
				document.getElementById("btn-submit").disabled= false;
			}
		},
		error: function (request, status, error) {
			alert(request.responseText);
		}
    });
}

function cek_no_kartu(no_kartu, no_kartu_old){
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi/cek_available_nokartu')?>/"+no_kartu+"/"+no_kartu_old,
		success: function(data){
			//alert(data);
			if (data>0) {
				//alert("No Kartu '"+no_kartu+"' Sudah Terdaftar ! <br> Silahkan masukkan no kartu lain...");
				document.getElementById("content_duplikat_kartu").innerHTML = "<i class=\"icon fa fa-ban\"></i> No Kartu \""+no_kartu+"\" Sudah Terdaftar ! Silahkan masukkan no kartu lain...";
				$("#duplikat_kartu").show();
				document.getElementById("btn-submit").disabled= true;
			} else {
				$("#duplikat_kartu").hide();
				document.getElementById("btn-submit").disabled= false;
			}
		},
		error: function (request, status, error) {
			alert(request.responseText);
		}
    });
}



function set_ident(ident){
	if (ident == '') {
		document.getElementById("no_identitas").required = true;		
		$("#btn_cek_nik").hide();    
		$("#label-identitas").html('Identitas');
	} else if (ident == 'KTP') {
		document.getElementById("no_identitas").required = false;		
		$("#btn_cek_nik").show(); 
		$("#label-identitas").html('No. NIK');
	} else {
		document.getElementById("no_identitas").required= false;		
		$("#btn_cek_nik").hide(); 
		$("#label-identitas").html('No. '+ident); 
	}
}

function update_nokartu(no_kartu) {
  var no_medrec = document.getElementById("no_medrec").value;
  if(no_medrec.length > 0 && no_kartu.length > 0){
  $.ajax({
        type: 'POST',
        url: '<?php echo base_url('irj/rjcwebservice/update_nokartu')?>',
        data: {
        no_kartu:no_kartu,
        no_medrec:no_medrec
        },
        success: function (response) {
		document.getElementById("no_kartu_bpjs").value = no_kartu;
		$('#no_bpjs').val(no_kartu);
        }
    });

return false;
}
}

function save_keluarga() {
    document.getElementById("btn-save-keluarga").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('irj/rjcregistrasi/save_keluarga'); ?>",
      dataType: "JSON",
      data: $('#form_input_keluarga').serialize(),
      success: function(result){      
        if (result == true) {
          document.getElementById("btn-save-keluarga").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan'; 
          show_keluarga();
          $('#modal_keluarga').modal('hide');
          swal("Sukses","Data berhasil disimpan.", "success"); 
        } else {
          swal("Error","Gagal menyimpan data.", "error");  
        }
      },
      error:function(event, textStatus, errorThrown) { 
        document.getElementById("btn-save-keluarga").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
        $('#modal-rl').modal('hide');
        swal("Error","Gagal menyimpan data.", "error");              
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }
    });     
}

function generate_rm(no_medrec) {	
    document.getElementById("btn-generate-rm").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('irj/rjcregistrasi/generate_rm'); ?>",
      dataType: "JSON",
      data: {"no_medrec" : no_medrec,"no_cm" : '<?php echo $data_pasien->no_cm; ?>'},
      success: function(result){      
        if (result == true) {
          document.getElementById("btn-generate-rm").innerHTML = 'Buat RM Baru';  
          swal("Sukses","No. RM Berhasil Diperbaharui.", "success"); 
          // get_rm();         
		  location.reload();
        } else {
          swal("Error","Gagal menyimpan data.", "error");  
        }
      },
      error:function(event, textStatus, errorThrown) { 
        document.getElementById("btn-generate-rm").innerHTML = 'Buat RM Baru';          
        swal("Error","Gagal Generate RM Baru.", "error");              
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }
    });     
}

function get_rm() {	    
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('irj/rjcregistrasi/get_rm'); ?>",
      dataType: "JSON",
      data: {"no_medrec" : '<?php echo $data_pasien->no_medrec; ?>'},
      success: function(result){       
        if (result != '') {
          $('#cm_baru').val(result.no_cm);
          $('#cm_lama').val(result.no_cm_lama);
        }
      },
      error:function(event, textStatus, errorThrown) {                     
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }
    });     
}

function show_keluarga() {
    $.ajax({
      type: "GET",
      url: "<?php echo site_url('irj/rjcregistrasi/show_keluarga/'.$data_pasien->no_cm); ?>",
      dataType: "JSON",      
      success: function(result){ 

        if (result !== null) {      	
        	  $('#keluarga_nik').val(result.nik);
	          $('#keluarga_nama').val(result.nama);
	          $('#keluarga_hubungan').val(result.hubungan);	          
	          $('#keluarga_nrp').val(result.no_nrp);
	          $('#keluarga_tgl_lahir').val(result.tgl_lahir);
	          $('#keluarga_alamat').val(result.alamat);
	          $('#keluarga_telp').val(result.no_telp);
	          $('#keluarga_agama').val(result.agama);	          
	          $("#keluarga_pendidikan").val(result.pendidikan).change();	          
	          $("#keluarga_pekerjaan").val(result.pekerjaan).change();
	          $('#keluarga_pangkat').val(result.pangkat);
	          $('#keluarga_alamat_kantor').val(result.alamat_kantor);
	          $('#keluarga_telp_kantor').val(result.telp_kantor);
	          $('#keluarga_jabatan').val(result.jabatan);
	          $('#keluarga_kesatuan').val(result.kesatuan);
	          $('#keluarga_alamat_kesatuan').val(result.alamat_kesatuan);
	          $('#keluarga_telp_kesatuan').val(result.telp_kesatuan);
        }
      },
      error:function(event, textStatus, errorThrown) { 
        swal("Error","Data tidak tersedia .", "error");                    
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }
    });       
}

function search_dpjp() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("search_dpjp");
  filter = input.value.toUpperCase();
  table = document.getElementById("table-dpjp");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

</script>

<?php echo $this->session->flashdata('notification');?>
<div class="card">
    <div class="card-block p-b-0">
        <ul class="nav nav-tabs customtab" role="tablist">
			<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#biodata" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">BIODATA</span></a> </li>
            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#daftar_ulang" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">DAFTAR ULANG PASIEN IRJ</span></a> </li>
		</ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
			<div id="biodata" class="tab-pane" role="tabpanel">					
					<div class="col-lg-10" style="margin: 0 auto;">	
								<br>
						<br>
							<?php
								$no_medrec=$data_pasien->no_medrec;
								if($data_pasien->foto!=''){
									$foto=$data_pasien->foto;
								}else $foto="unknown.png";
							?>
							<div class="row">
								<div class="col-sm-12 text-center">
									<img height="150px" class="img-rounded" src="<?php echo base_url("upload/photo/".$foto);?>">
								</div>
								<div class="col-sm-12 text-center">
									<?php echo form_open_multipart('irj/rjcregistrasi/cetak_kartu_pasien');?>
										<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec" id="no_medrec">
										<input type="hidden" class="form-control" value="<?php echo $data_pasien->no_cm;?>" name="cetak_kartu" id="cetak_kartu">
										<!-- <button type="submit" class="btn btn-primary" id="btn-submit"><i class="fa fa-id-card-o"></i> Cetak Kartu</button> -->
										<a href="<?php echo site_url('irj/rjcregistrasi/st_cetak_kartu_pasien/').'/'.$data_pasien->no_cm; ?>" target="_blank" class="btn waves-effect waves-light btn-primary"><i class="fa fa-print"></i> Cetak Kartu Pasien</a>	
										<a href="<?php echo site_url('irj/rjcregistrasi/cetak_identitas/').'/'.$data_pasien->no_cm; ?>" target="_blank" class="btn waves-effect waves-light btn-danger"><i class="fa fa-print"></i> Cetak Identitas</a>	
										<!-- <button type="button" class="btn btn-primary" alt="default" data-toggle="modal" data-target="<?php if($data_pasien->no_nrp == '') {echo '#modal_keluarga';} else echo '#modal_keluarga_anggota'; ?>"><i class="fa fa-users"></i> Data Keluarga</button>	 -->
										<button type="button" class="btn btn-primary" alt="default" data-toggle="modal" data-target="modal_keluarga" id="btn_modal"><i class="fa fa-users"></i> Data Keluarga</button>		
									<?php echo form_close();?>										
								</div>
							</div>
							<br>
							<br>
							<?php echo form_open_multipart('irj/rjcregistrasi/update_data_pasien');?>
								<input type="hidden" class="form-control" value="<?php echo $online;?>" name="online" readonly>
								<?php
									if($online==1){
								?>
									<input type="hidden" class="form-control" value="<?php echo $id_online;?>" name="id_online" readonly>
								<?php
									}
								?>
								<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_cm" readonly>
								<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="no_cm">No RM</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_cm;?>" name="cm_baru" id="cm_baru" readonly>
									</div>
									<div class="col-sm-4">
										<button class="btn btn-primary" type="button" id="btn-generate-rm" onclick="generate_rm('<?php echo $no_medrec;?>')">Buat RM Baru</button>
									</div>
								</div>
								<!--div class="form-group row">
									<p class="col-sm-3 form-control-label" id="no_cm_lama">No RM Lama</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_cm_lama;?>" name="cm_lama" id="cm_lama" readonly>
									</div>
								</div-->
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="tgl_daftar">Tanggal Daftar</p>
									<div class="col-sm-8">
										<div class="input-group">
											<input type="text" class="form-control" value="<?php echo $data_pasien->tgl_daftar;?>" name="tgl_daftar" readonly>
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="nama">Nama Lengkap *</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->nama;?>" name="nama" required>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="sex">Jenis Kelamin *</p>
									<div class="col-sm-8">										
										<div class="demo-radio-button">
											<input name="sex" type="radio" id="laki_laki" class="with-gap" value="L" <?php if($data_pasien->sex=='L') echo 'checked' ?>/>
				                            <label for="laki_laki">Laki-Laki</label>
				                            <input name="sex" type="radio" id="perempuan" class="with-gap" value="P" <?php if($data_pasien->sex=='P') echo 'checked' ?> />
				                            <label for="perempuan">Perempuan</label>           		
										</div>
									</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" >Pilih Identitas</p>
									<div class="col-sm-8">
										<div class="form-inline">
												<select class="form-control" style="width: 100%" name="jenis_identitas" id="jenis_identitas" onchange="set_ident(this.value)">
													<option value="">-- Pilih Identitas --</option>
													<option <?php if($data_pasien->jenis_identitas=='KTP') echo 'selected';?> value="KTP">KTP</option>
													<option <?php if($data_pasien->jenis_identitas=='SIM') echo 'selected';?> value="SIM">SIM</option>
													<option <?php if($data_pasien->jenis_identitas=='PASPOR') echo 'selected';?> value="PASPOR">Paspor</option>
													<option <?php if($data_pasien->jenis_identitas=='KTM') echo 'selected';?> value="KTM">KTM</option>
													<option <?php if($data_pasien->jenis_identitas=='NIK') echo 'selected';?> value="NIK">NIK</option>
													<option <?php if($data_pasien->jenis_identitas=='DLL') echo 'selected';?> value="DLL">Lainnya</option>
												</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" >No. Identitas</p>
									<div class="col-sm-5">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_identitas;?>" name="no_identitas"  id="no_identitas" onchange="cek_no_identitas(this.value)" onkeyup="cek_no_identitas(this.value)">
									</div>
									<div class="col-sm-3">
										<button class="btn btn-info btn-block" type="button" onclick="cekbpjs_nik()" id="btn_cek_nik">Cek Peserta BPJS</button>
									</div>
								</div>
								<div class="form-group row" id="duplikat_id">
									<p class="col-sm-3 form-control-label"></p>
									<div class="col-sm-8">
										<p class="form-control-label" id="content_duplikat_id" style="color: red;"></p>
									</div>
								</div>
								<!-- <div class="form-group row">
									<p class="col-sm-3 form-control-label">No. Kartu Keluarga</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_kk;?>" name="no_kk" id="no_kk">
									</div>
								</div>	 -->							
								<hr>
								<!--div class="form-group row">
									<p class="col-sm-3 form-control-label" id="jenis_kartu">Anggota TNI/PNS</p>
									<div class="col-sm-8">
										<div class="form-inline">
												<div class="demo-checkbox">	
													<input type="checkbox" class="filled-in" value="ya" name="chk1" id="chk1" <?php if($data_pasien->no_nrp!='' ) echo 'checked';?>/>
                                    				<label for="chk1">Ya</label>
												</div>
											
										</div>
									</div>
								</div-->
								
								<!--div id="input_tentara">
									<div class="form-group row" id="inputtentara">
										<p class="col-sm-3 form-control-label">Jenis Keanggotaan</p>
										<div class="col-sm-8">
											<select name="nrp_sbg" id="nrp_sbg" class="form-control select2" style="width: 100%" onchange="set_tentara(this.value)">
												<option value="">-- Pilih Jenis --</option>
														<?php 
												foreach($hubungan as $row){	
												echo '<option '; if($data_pasien->nrp_sbg==$row->hub_id) echo 'selected '; echo 'value="'.$row->hub_id.'">'.$row->hub_name.'</option>';
												}
												?>
														
											</select>
											
											
										</div>
									</div>
									<div class="form-group row" >
										<p class="col-sm-3 form-control-label"></p>
										<div class="col-sm-8">
											<input type="search" class="form-control" id="no_nrp" name="no_nrp" placeholder="Pencarian NRP/NIP Anggota" value="<?php echo $data_pasien->no_nrp; ?>">
											<!--<input type="text" class="form-control" value="<?php echo $data_pasien->no_nrp;?>" name="no_nrp" id="no_nrp" placeholder="Nomor NRP" onchange="cek_no_nrp(this.value,'<?php echo $data_pasien->no_nrp; ?>')">>
										</div>
									</div>
									<div class="form-group row" id="duplikat_nrp">
										<p class="col-sm-3 form-control-label"></p>
										<div class="col-sm-8">
											<p class="form-control-label" id="content_duplikat_nrp" style="color: red;"></p>
										</div>
									</div>	
									<div id="kstpktangakat">
									<!-- <div class="form-group row" >
										<p class="col-sm-3 form-control-label">Kesatuan</p>
										<div class="col-sm-8">
											<select name="kesatuan" id="kesatuan" class="form-control select2" style="width: 100%" >
												<option value="">-Pilih Kesatuan-</option>
												<?php 
												foreach($kesatuan as $row){												
												echo '<option '; if($data_pasien->kst_id==$row->kst_id) echo 'selected '; echo 'value="'.$row->kst_id.'">'.$row->kst_nama.'</option>';
												}
												?>
														
											</select>
											
											
										</div>
									</div> >

									<div class="form-group row" >
									<label class="col-sm-3 control-label col-form-label">Kesatuan</label>
									<div class="col-sm-8">
										<select name="kesatuan" id="kesatuan" class="form-control select2" style="width: 100%" >
											<option value="">-- Pilih Kesatuan --</option>
											<?php 
												// foreach($kesatuan as $row){
												// 	echo '<option value="'.$row->kst_id.'">'.$row->kst_nama.'</option>';
												// }
											$satker = $data_pasien->kst_id . '@' . $data_pasien->kst2_id . '@' . $data_pasien->kst3_id;

												foreach ($kesatuan as $item) {		
													if ($item->kst_id . '@' .$item->kst2_id . '@' .$item->kst3_id == $satker) {
														if ($item->kst2_id == '' && $item->kst3_id == '') {
															echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '@' .$item->kst3_id.'" selected>'.$item->kst_nama.'</option>';
														} else if ($item->kst3_id == '') {
															echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '" selected>'.$item->kst_nama . ' | ' .$item->kst2_nama . '</option>';
														} else {
															echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '@' .$item->kst3_id.'" selected>'.$item->kst_nama . ' | ' .$item->kst2_nama . ' | ' .$item->kst3_nama.'</option>';
														}
													} else {
														if ($item->kst2_id == '' && $item->kst3_id == '') {
															echo '<option value="'.$item->kst_id.'">'.$item->kst_nama.'</option>';
														} else if ($item->kst3_id == '') {
															echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '">'.$item->kst_nama . ' | ' .$item->kst2_nama . '</option>';
														} else {
															echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '@' .$item->kst3_id.'">'.$item->kst_nama . ' | ' .$item->kst2_nama . ' | ' .$item->kst3_nama.'</option>';
														}
													}
													
												}
											?>														
										</select>
									</div>
								<!-- 	<div class="col-sm-3">
										<select name="kesatuan2" id="kesatuan2" class="form-control select2" style="width: 100%" >												
										</select>
									</div>
									<div class="col-sm-3">
										<select name="kesatuan3" id="kesatuan3" class="form-control select2" style="width: 100%" >																		
										</select>					
									</div> >
								</div>		
									<div class="form-group row" >
										<p class="col-sm-3 form-control-label">Pangkat</p>
										<div class="col-sm-8">
											<select name="pangkat" id="pangkat" class="form-control select2" style="width: 100%" >
												<option value="">-- Pilih Pangkat --</option>
												<?php 
												foreach($pangkat as $row){												
												echo '<option '; if($data_pasien->pkt_id==$row->pangkat_id) echo 'selected '; echo 'value="'.$row->pangkat_id.'">'.$row->pangkat.'</option>';
												}
												?>
														
											</select>
											
											
										</div>
									</div>
									<div class="form-group row" >
										<p class="col-sm-3 form-control-label">Angkatan</p>
										<div class="col-sm-8">
											<select name="angkatan" id="angkatan" class="form-control select2" style="width: 100%" >
												<option value="">-- Pilih Angkatan --</option>
												<?php 
												foreach($angkatan as $row){
												echo '<option '; if($data_pasien->angkatan_id==$row->tni_id) echo 'selected '; echo 'value="'.$row->tni_id.'">'.$row->angkatan.'</option>';
												}
												?>
														
											</select>											
										</div>
									</div>
									<!-- <div class="form-group row">
										<p class="col-sm-3 form-control-label" id="tgl_nonaktif">Tanggal Non-aktif</p>
										<div class="col-sm-8">
											<input type="text" class="form-control date_picker" id="date_picker" placeholder="yyyy-mm-dd" name="tgl_nonaktif">
										</div>
										onchange="cek_no_kartu(this.value,'<?php echo $data_pasien->no_kartu; ?>')"
								
									</div>	 >	
									</div>						
								</div>
								<hr-->
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="no_kartu">No. Kartu BPJS</p>
									<div class="col-sm-5">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_kartu;?>" name="no_kartu" id="no_kartu_bpjs" onchange="cek_no_kartu(this.value,'<?php echo $data_pasien->no_kartu; ?>')">
									</div>
									<div class="col-sm-3">
										<button class="btn btn-info btn-block" type="button" id="btn-bpjs-biodata">Cek Peserta BPJS</button>
									</div>
								</div>
								<div class="form-group row" id="duplikat_kartu">
									<p class="col-sm-3 form-control-label"></p>
									<div class="col-sm-8">
										<p class="form-control-label" id="content_duplikat_kartu" style="color: red;"></p>
									</div>
								</div>
							
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="tmpt_lahir">Tempat Lahir</p>
									<div class="col-sm-8">
										<input type="text" class="form-control"  value="<?php echo $data_pasien->tmpt_lahir;?>" name="tmpt_lahir" >
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="tgl_lahir">Tanggal Lahir *</p>
									<div class="col-sm-8">
										<div class="input-group">
											<input type="text" class="form-control date_picker" value="<?php echo date('Y-m-d',strtotime($data_pasien->tgl_lahir));?>" name="tgl_lahir" required>
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="agama">Agama</p>
									<div class="col-sm-8">
										<div class="form-inline">
												<select class="form-control" style="width: 100%" name="agama">
													<option value="">-- Pilih Agama --</option>
													<option <?php if($data_pasien->agama=='ISLAM') echo 'selected';?> value="ISLAM">Islam</option>
													<option <?php if($data_pasien->agama=='KATOLIK') echo 'selected';?> value="KATOLIK">Katolik</option>
													<option <?php if($data_pasien->agama=='PROTESTAN') echo 'selected';?> value="PROTESTAN">Protestan</option>
													<option <?php if($data_pasien->agama=='BUDHA') echo 'selected';?> value="BUDHA">Budha</option>
													<option <?php if($data_pasien->agama=='HINDU') echo 'selected';?> value="HINDU">Hindu</option>
													<option <?php if($data_pasien->agama=='KONGHUCU') echo 'selected';?> value="KONGHUCU">Konghucu</option>
												</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="status">Status</p>
									<div class="col-sm-8">
										<div class="demo-radio-button">
											<input name="status" type="radio" id="belum_menikah" class="with-gap" value="B" <?php if($data_pasien->status=='B') echo 'checked' ?>/>
				                            <label for="belum_menikah">Belum Menikah</label>
				                            <input name="status" type="radio" id="menikah" class="with-gap" value="K" <?php if($data_pasien->status=='K') echo 'checked' ?> />
				                            <label for="menikah">Sudah Menikah</label>  
				                            <input name="status" type="radio" id="cerai" class="with-gap" value="C" <?php if($data_pasien->status=='C') echo 'checked' ?> />
				                            <label for="cerai">Cerai</label>           		
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="goldarah">Golongan Darah</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<select class="form-control" style="width: 100%" name="goldarah">
												<option value="">-- Pilih Golongan Darah --</option>
												<option <?php if($data_pasien->goldarah=='A+') echo 'selected';?> value="A+">A+</option>
												<option <?php if($data_pasien->goldarah=='A-') echo 'selected';?> value="A-">A-</option>
												<option <?php if($data_pasien->goldarah=='B+') echo 'selected';?> value="B+">B+</option>
												<option <?php if($data_pasien->goldarah=='B-') echo 'selected';?> value="B-">B-</option>
												<option <?php if($data_pasien->goldarah=='AB+') echo 'selected';?> value="AB+">AB+</option>
												<option <?php if($data_pasien->goldarah=='AB-') echo 'selected';?> value="AB-">AB-</option>
												<option <?php if($data_pasien->goldarah=='O+') echo 'selected';?> value="O+">O+</option>
												<option <?php if($data_pasien->goldarah=='O-') echo 'selected';?> value="O-">O-</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="wnegara">Kewarganegaraan</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<select class="form-control" style="width: 100%" name="wnegara">
												<?php if($data_pasien->wnegara=='WNA'){
													echo '<option value="WNI" >WNI</option><option value="WNA" selected>WNA</option>';
												}else{
													echo '<option value="WNI" selected>WNI</option><option value="WNA" >WNA</option>';
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label">Alamat *</p>
									<div class="col-sm-8">
										<textarea class="form-control" name="alamat" id="alamat" rows="5"><?php echo $data_pasien->alamat;?></textarea>
									</div>
								</div>
								<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="lbl_wilayah">Asal Wilayah</label>
								<div class="col-sm-8">
									<div class="form-inline">
											<select name="load_wilayah" class="form-control load_wilayah" style="width:500px">
												<?php if ($data_pasien->kelurahandesa != '') { ?>
												<option value="<?php echo $data_pasien->id_provinsi . '@' . $data_pasien->id_kotakabupaten . '@' . $data_pasien->id_kecamatan . '@' . $data_pasien->id_kelurahandesa; ?>" selected><?php echo $data_pasien->kelurahandesa . ', ' . $data_pasien->kecamatan . ', ' . $data_pasien->kotakabupaten . ', ' . $data_pasien->provinsi; ?></option>
												<?php } ?>
											</select>
										
									</div>
								</div>
							</div>	
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="kodepos">Kode Pos</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->kodepos;?>" name="kodepos">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="pendidikan">Pendidikan</p>
									<div class="col-sm-8">
										<div class="form-inline">
												<select class="form-control select2" style="width: 100%" name="pendidikan">
													<option value="">-- Pilih Pendidikan Terakhir --</option>
													<option <?php if($data_pasien->pendidikan=='S3') echo 'selected';?> value="S3">S3 / Subspesialis</option>
													<option <?php if($data_pasien->pendidikan=='S2') echo 'selected';?> value="S2">S2 / Spesialis</option>
													<option <?php if($data_pasien->pendidikan=='S1') echo 'selected';?> value="S1">S1</option>
													<option <?php if($data_pasien->pendidikan=='D4') echo 'selected';?> value="D4">D4</option>
													<option <?php if($data_pasien->pendidikan=='D3') echo 'selected';?> value="D3">D3</option>
													<option <?php if($data_pasien->pendidikan=='D2') echo 'selected';?> value="D2">D2</option>
													<option <?php if($data_pasien->pendidikan=='D1') echo 'selected';?> value="D1">D1</option>
													<option <?php if($data_pasien->pendidikan=='SMA') echo 'selected';?> value="SMA">SMA</option>
													<option <?php if($data_pasien->pendidikan=='SMP') echo 'selected';?> value="SMP">SMP</option>
													<option <?php if($data_pasien->pendidikan=='SD') echo 'selected';?> value="SD">SD</option>
													<option <?php if($data_pasien->pendidikan=='Di Bawah Umur') echo 'selected';?> value="Di Bawah Umur">Di Bawah Umur</option>
												</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="pekerjaan">Pekerjaan</p>
									<div class="col-sm-8">
										<select class="form-control select2" style="width: 100%" name="pekerjaan">
													<option value="">-- Pilih Pekerjaan --</option>
													<?php foreach($pekerjaan as $row) { ?>
															<option value="<?php echo $row->pekerjaan; ?>" <?php if($data_pasien->pekerjaan==$row->pekerjaan) echo 'selected';?>>
																<?php echo $row->pekerjaan; ?>			
															</option>;
													<?php } ?>
												</select>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label">Jabatan</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->jabatan;?>" name="jabatan">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="no_telp">No. Telp</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_telp;?>" maxlength="12" name="no_telp">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="no_hp">No. HP</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_hp;?>" name="no_hp">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="no_telp_kantor">No. Telp Kantor</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_telp_kantor;?>" maxlength="12" name="no_telp_kantor">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="email">Email</p>
									<div class="col-sm-8">
										<input type="email" class="form-control" value="<?php echo $data_pasien->email;?>" name="email">
									</div>
								</div>								
								<div class="form-group row">
									<div class="offset-sm-3 col-sm-8">									
										<button type="reset" class="btn btn-danger" id="btn-submit"><i class="fa fa-eraser"></i> Reset</button>
										<button type="submit" class="btn btn-primary" ><i class="fa fa-floppy-o"></i> Simpan</button>
									</div>
								</div>								
							<?php echo form_close();?>
						</div>			
			</div>
		

			<div id="daftar_ulang" class="tab-pane active" role="tabpanel">					
					<div class="col-lg-10" style="margin: 0 auto;">	
								<br>
						<br>
							<?php echo form_open('irj/rjcregistrasi/insert_daftar_ulang', array('class' => 'form-horizontal')); ?>
							<!-- <input type="hidden" value="<?php echo $data_pasien->no_kartu;?>" name="no_kartu"> -->
								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="jns_kunj">Jenis Kunjungan</label>
									<div class="col-sm-8">
										<div class="form-inline control-label pull-left">
												<input type="hidden" class="form-control" value="<?php echo $online;?>" name="online" readonly>
												<?php
													if($online==1){
												?>
													<input type="hidden" class="form-control" value="<?php echo $id_online;?>" name="id_online" readonly>
												<?php
													}
												?>
												<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
												<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">
												<?php echo ($jns_kunjungan == "LAMA" ? 
												
													'
													<input type="radio" name="jns_kunj" class="jns_kunj" value="LAMA" checked><label for="lbl_lama">Lama</label>&nbsp;
													&nbsp;&nbsp;&nbsp;
													<input type="radio" name="jns_kunj" class="jns_kunj" value="BARU"><label for="lbl_lama">Baru</label>&nbsp;
									
													<input type="hidden" name="jns_kunj" value="'.$jns_kunjungan.'">
													'
												:
												
													'
													<input type="radio" name="jns_kunj" class="jns_kunj" value="LAMA"><label for="lbl_lama">Lama</label>&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="radio" name="jns_kunj" class="jns_kunj" value="BARU" checked><label for="lbl_lama">Baru</label>&nbsp;
													
													<input type="hidden" name="jns_kunj" value="'.$jns_kunjungan.'">
													'
												);
												?>

										</div>
									</div>
								</div>
								<?php
									if($online==1){
								?>
								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label">Tgl. Kunjungan</label>
									<div class="col-sm-8">
										<div class="input-group">
											<input type="text" class="form-control date_picker" name="tgl_kunjungan" id="tgl_kunjungan" >
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>								
								<?php
									 } else {
								?>															
								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label">Tgl. Kunjungan</label>
									<div class="col-sm-8">
										<div class="input-group">
											<input type="text" class="form-control date_picker" name="tgl_kunjungan" value="<?php echo date('Y-m-d');?>">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
								<?php
									}
								?>

								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label">Cara Bayar *</label>
									<div class="col-sm-8">
										<div class="form-inline">
											<select id="cara_bayar" class="custom-select form-control" style="width: 100%" name="cara_bayar" onchange="pilih_cara_bayar(this.value)" required>
												<option value="">-- Pilih Cara Bayar --</option>
												<?php
												foreach($cara_bayar as $row){
													echo '<option value="'.$row->cara_bayar.'">'.$row->cara_bayar.'</option>';
												}
												?>
											</select>		
											
										</div>
									</div>
								</div>
					<!-- 			
                               <div class="form-group" id="input_kontraktor">
									<p class="col-sm-2 control-label" id="lbl_input_kontraktor">Dijamin Oleh</p>
									<div class="col-sm-5">
										<div class="form-inline">
												<select id="id_kontraktor" class="form-control select2" style="width: 100%" name="id_kontraktor">
													<option value="">-Pilih Penjamin-</option>
													
												</select>
										</div>
									</div>
								</div> -->

								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label">Cara Kunjungan *</label>
									<div class="col-sm-8">
												<select id="cara_kunjungan" class="custom-select form-control" style="width: 100%" name="cara_kunj" onchange="pilih_kunjungan(this.value)" required>
													<option value="">-- Pilih Cara Kunjungan --</option>
													<?php 
													foreach($cara_berkunjung as $row){
														echo '<option value="'.$row->cara_kunj.'">'.$row->cara_kunj.'</option>';
													}
													?>
												</select>
									</div>
								</div>
                               

								<input type="hidden" name="jenis_faskes" id="jenis_faskes">
								<div class="form-group row div_bpjs">
									<label class="col-sm-3 control-label col-form-label">No. Kartu BPJS</label>
									<div class="col-sm-8">
										<div class="input-group">
	                                        <input type="text" class="form-control" name="no_bpjs" id="no_bpjs" value="<?php echo $data_pasien->no_kartu; ?>" readonly>
	                                        <span class="input-group-btn">
	                          					<button class="btn btn-info" type="button" id="btn-bpjs-daful"><i class="fa fa-eye"></i> Data Peserta</button>
	                        				</span>
	                        				<span class="input-group-btn">
	                          					<button type="button" class="btn waves-effect waves-light btn-danger" id="btn-rujukan-kartu"><i class="fa fa-eye"></i> Data Rujukan</button>
	                        				</span>
	                                    </div>	
                                    </div>
								</div>
								<div class="form-group row" id="input_kontraktor">
									<label class="col-sm-3 control-label col-form-label" id="lbl_input_kontraktor">Dijamin Oleh</label>
									<div class="col-sm-8">
										<div class="form-inline">
												<select id="id_kontraktor" class="form-control select2" style="width: 100%" name="id_kontraktor">
													<option value="">-- Pilih Penjamin --</option>	
												</select>
										</div>
									</div>
								</div>
								<div id="div_rujukan">
									<hr>	
									<div class="form-group row">
										<label class="col-sm-3 control-label col-form-label">No. Rujukan</label>
										<div class="col-sm-8">
											<div class="input-group">
		                                        <input type="text" class="form-control" name="no_rujukan" id="no_rujukan">
		                                        <span class="input-group-btn">
		                          					<button class="btn waves-effect waves-light btn-danger" type="button" id="btn-rujukan"><i class="fa fa-eye"></i> Lihat Rujukan</button>
		                        				</span>
		                                    </div>	
	                                    </div>								
									</div>	
									<div class="form-group row">
										<label class="col-sm-3 control-label col-form-label">No.Surat Kontrol/SKDP * <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-animation="true" data-placement="right" title="Nomor Surat Kontrol, Surat Rujukan Internal atau Surat Rujukan Rawat Inap."></label>
	                                    <div class="col-sm-8">
		                                    <input type="text" class="form-control" name="nosurat_skdp_sep" id="nosurat_skdp_sep">
	                                    </div>								
									</div>	
									<div class="form-group row">
										<label class="col-sm-3 control-label col-form-label">DPJP Pemberi Surat SKDP *</label>
										<div class="col-sm-8">
											<div class="input-group">
					                            <input type="text" class="form-control" name="dpjp_skdp_sep" id="dpjp_skdp_sep">
					                            <span class="input-group-btn">
					                                <button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal-search-kode"><i class="fa fa-search"></i> Cari DPJP</button>
					                            </span>
					                        </div> 
	                                    </div>								
									</div>	
									<hr>	
								</div>							
								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="dirujuk_ke">Tujuan Poliklinik *</label>
									<div class="col-sm-8">
										<div class="form-inline">
												<select id="id_poli" class="form-control select2" style="width: 100%" name="id_poli"  onchange="ajaxdokter(this.value)" required>
													<option value="">-- Pilih Nama Poli --</option>
													<?php 
													foreach($poli as $row){
														echo '<option value="'.$row->id_poli.'">'.$row->nm_poli.'</option>';
													}
													?>
												</select>
										</div>
									</div>
								</div>
								<div class="form-group row" id="div_katarak">
									<div class="offset-sm-3 col-sm-8">
										<div class="demo-checkbox">
											<input type="checkbox" class="filled-in" name="katarak" value="1" id="katarak">
		                                    <label for="katarak">Katarak</label>
	                                	</div>									
	                                	<span class="help-block" style="font-size: 14px;">Centang Katarak <i class="fa fa-check"></i>, Jika Peserta Tersebut Mendapatkan Surat Perintah Operasi katarak</span>	
									</div>
								</div>	
								<div id="ird">
									<div class="form-group row">
										<label class="col-sm-3 control-label col-form-label" id="alber">Alasan Berobat</label>
											<div class="col-sm-8">
											<select class="form-control" name="alber" id="alasan_berobat" onchange="pilih_alber(this.value)" required>
												<option value="sakit">Sakit</option>
												<option value="kecelakaan">Kecelakaan</option>
												<option value="lahir">Melahirkan</option>
											</select></div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 control-label col-form-label" id="pasdatDg">Datang dengan</label>
										<div class="col-sm-8"><select class="form-control" name="pasdatDg" required>
											<option value="klg">Keluarga</option>
											<option value="ttg">Tetangga</option>
											<option value="lain">Lain-lain</option>
										</select></div>
									</div>								
									<div id="input_kecelakaan">
										<div class="form-group row">
											<label class="col-sm-3 control-label col-form-label" id="Kclkaan">Kecelakaan</label>
											<div class="col-sm-8">
												<select  class="form-control select2" name="jenis_kecelakaan" id="jenis_kecelakaan" style="width:100%;">
															<option value="">-- Pilih Jenis Kecelakaan --</option>
															<?php
															foreach($kecelakaan as $row){
																echo '<option value="'.$row->id.'">'.$row->nm_kecelakaan.'</option>';
															}
															?>
														</select>
												<input type="text" class="form-control m-t-10" placeholder="Lokasi Kecelakaan" name="lokasi_kecelakaan" >
											</div>
										</div>
										<div class="form-group row kll_bpjs">
											<label class="col-sm-3 control-label col-form-label">Penjamin KLL *</label>
											<div class="col-sm-9">
												<div class="demo-checkbox">
				                                    <input class="filled-in" type="checkbox" name="kll_penjamin[]" value="1" id="jasa_raharja">
													<label for="jasa_raharja">Jasa Raharja</label>

													<input class="filled-in" type="checkbox" name="kll_penjamin[]" value="2" id="bpjs_tk">
													<label for="jasa_raharja">BPJS Ketenagakerjaan</label>

													<input class="filled-in" type="checkbox" name="kll_penjamin[]" value="3" id="taspen">
													<label for="jasa_raharja">TASPEN</label>

													<input class="filled-in" type="checkbox" name="kll_penjamin[]" value="4" id="asabri">
													<label for="jasa_raharja">ASABRI PT</label>
				                                </div> 											
											</div>
										</div>
			                            <div class="form-group row kll_bpjs">
			                                <label class="col-sm-3 control-label col-form-label">Tgl. Kejadian</label>
			                                <div class="col-md-8">
			                                	<div class="input-group">
													<input type="text" class="form-control date_picker" name="kll_tgl_kejadian" id="kll_tgl_kejadian" value="<?php echo date('Y-m-d'); ?>" maxlength="10">
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												</div>
			                                </div>
			                            </div>
			                            <div class="form-group row kll_bpjs">
			                                <label class="col-sm-3 control-label col-form-label">Lokasi Kejadian</label>
			                                <div class="col-sm-8">
			                                    <select class="form-control" name="kll_provinsi" id="kll_provinsi" style="width: 100%"></select>
			                                </div>
			                            </div>
			                            <div class="form-group row kll_bpjs">
			                                <label class="col-sm-3 control-label col-form-label"></label>
			                                <div class="col-sm-8">
			                                    <select class="form-control" name="kll_kabupaten" id="kll_kabupaten"></select>
			                                </div>
			                            </div>
			                            <div class="form-group row kll_bpjs">
			                                <label class="col-sm-3 control-label col-form-label"></label>
			                                <div class="col-sm-8">
			                                    <select class="form-control" name="kll_kecamatan" id="kll_kecamatan"></select>
			                                </div>
			                            </div>
			                            <div class="form-group row kll_bpjs">
			                                <label class="col-sm-3 control-label col-form-label">Keterangan Kejadian</label>
			                                <div class="col-md-8">
			                                    <textarea class="form-control" name="kll_ketkejadian" id="kll_ketkejadian" cols="30" rows="5" style="resize:vertical" placeholder="ketik keterangan kejadian"></textarea>
			                                </div>
			                            </div>
		                            </div>	
								</div>

								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="dokter">Dokter</label>
									<div class="col-sm-8">
										<div class="form-inline">
												<select id="id_dokter" class="form-control select2" style="width: 100%" name="id_dokter">
													<option value="">-- Pilih Dokter --</option>
													<?php 
													foreach($dokter as $row){
														echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
													}
													?>
												</select>
										</div>
									</div>
								</div>
								
								<div class="form-group row" id="input_diagnosa">
									<label class="col-sm-3 control-label col-form-label" id="lbl_input_diagnosa">Diagnosa</label>
									<div class="col-sm-8">										
										<input type="text" class="form-control input-sm autocomplete_diagnosa"  name="diagnosa" id="diagnosa">
  										<input type="hidden" class="form-control" name="id_diagnosa" id="id_diagnosa">
									</div>
								</div>
								<div class="form-group row" id="hubungan">
									<label class="col-sm-3 control-label col-form-label">Hubungan</label>
									<div class="col-sm-8">
										<div class="form-inline">
												<select class="form-control" style="width: 100%" name="hubungan">
													<option value="">-- Pilih Hubungan --</option>
													<option value="Ybs.">Ybs.</option>
													<option value="Ortu">Orang Tua</option>
													<option value="Istri">Istri</option>
													<option value="Suami">Suami</option>
													<option value="Anak">Anak</option>
												</select>
										</div>
									</div>
								</div>
								<div class="form-group row">								
									<label class="col-sm-3 control-label col-form-label">Kelas Rawat</label>
									<div class="col-sm-2">
										<div class="form-inline">
												<select class="form-control" style="width: 100%" id="kelas_pasien" name="kelas_pasien" required>
													<!--<option value="">-Pilih Kelas-</option>-->
													<option value="III">III</option>
													<!--<?php 
													/*foreach($kelas as $row){
														$string = "";
														if($row->kelas == "III") $string = "SELECTED"; 

														echo '<option value="'.$row->kelas.'" '.$string.'>'.$row->kelas.'</option>';
													}*/
													?>-->
												</select>												
										</div>
									
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="catatan">Catatan</label>
									<div class="col-sm-8">
									<textarea class="form-control" name="entri_catatan" id="entri_catatan" cols="30" rows="5" style="resize:vertical"></textarea>
									</div>
								</div>									
								<div class="form-group row">
									<div class="offset-sm-3 col-sm-8">
										<div class="demo-checkbox">
		                                    <input type="checkbox" class="filled-in" value="1" name="cetak_kartu" id="check_cetak_kartu" <?php if($jns_kunjungan == "BARU") echo 'checked ';?>  />
		                                    <label for="check_cetak_kartu">Cetak Kartu</label>
	                                	</div>										
										<input type="hidden" class="form-control" value="<?php echo $data_pasien->no_cm;?>" name="cetak_kartu1" id="cetak_kartu1">
									</div>
								</div>	
								<div class="form-group row">
									<div class="offset-sm-3 col-sm-8">
									<div class="demo-checkbox">
						
                                    <input type="checkbox" class="filled-in" value="1" name="extra" id="cek_extra"  />
                                    <label for="cek_extra">Tanpa Biaya awal *)</label>
                                		</div>										
									</div>
								</div>
								<p>*) Hanya untuk pasien yang tidak terkena biaya seperti Buka Jahitan</p>
								<input type="hidden" value="" id="kode_provider" name="kode_provider">							
								<input type="hidden" class="form-control" value="<?php echo $data_pasien->no_nrp;?>" name="hidden_nrpdaful" id="hidden_nrpdaful" >
								<div class="form-group row">
									<div class="offset-sm-3 col-sm-8">
								<button type="reset" class="btn waves-effect waves-light btn-danger"><i class="fa fa-eraser"></i> Reset</button>
								<button type="submit" class="btn btn-primary" id="button_cetak_karcis"><i class="fa fa-floppy-o"></i> Simpan</button>
									</div>
								</div>
							<?php echo form_close();
							?>
							</div>
						</div>												
			</div><!--- end col -->
                        </div>

<!-- <div class="container-fluid" style="width:97%;margin:0 auto">	
	<div class="row">
		
				
		
		</div>
	</div> -->
<!--- Modal Web Service -->
<!-- <div class="modal fade" id="data_webservice" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Data</h4>
      </div>
      <div class="modal-body">
			<div id="data_anggota"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>	 -->
<!--- Modal -->
<!-- <div class="modal fade" id="modal_validasi" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Hasil Validasi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
			<div id="data_validasi"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>	 -->

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="title_modal" aria-hidden="true" id="modal_keluarga_anggota">
      	<div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="title_modal">Data Keluarga/Kerabat</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <div class="modal-body">
              		<div class="col-md-12">
                  	<div class="table-responsive" id="div_table_keluarga">
							<table id="table_keluarga" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
		                        <thead>
									<tr>
										<th>No</th>
										<th>No. RM</th>
										<th>Hubungan</th>
										<th>Nama</th>
										<th>Alamat</th>
										<th>Telepon</th>
										<th>Pekerjaan</th>
										<!-- <th class="text-center">Aksi</th> -->
									</tr>
		                        </thead>
								<tbody>							
								</tbody>
                    		</table>
					</div> <!-- table-responsive -->						
					</div>									                          
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
          </div>
          <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
  	</div> 
  	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="title_modal" aria-hidden="true" id="modal_keluarga">
      	<div class="modal-dialog modal-lg">
          <div class="modal-content">
          		<form id="form_input_keluarga">
              <div class="modal-header">
                  <h4 class="modal-title" id="title_modal">Data Keluarga/Kerabat</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <div class="modal-body">
              	<input type="hidden" name="no_cm_pasien" value="<?php echo $data_pasien->no_cm; ?>">
              		<div class="col-md-12">
              			<div class="form-group row">
						  <label class="col-sm-2 col-form-label">NIK</label>
						  <div class="col-sm-7">
						    <input class="form-control" type="text" name="keluarga_nik" id="keluarga_nik">
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Nama</label>
						  <div class="col-sm-7">
						    <input class="form-control" type="text" name="keluarga_nama" id="keluarga_nama">
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Hubungan</label>
						  <div class="col-sm-7">
						    <input class="form-control" type="text" name="keluarga_hubungan" id="keluarga_hubungan">
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">NRP / NIP</label>
						  <div class="col-sm-5">
						    <input class="form-control" type="text" name="keluarga_nrp" id="keluarga_nrp">
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Tgl Lahir</label>
						  <div class="col-sm-4">
						    <input class="form-control date_picker" type="text" name="keluarga_tgl_lahir" id="keluarga_tgl_lahir">
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Alamat</label>
						  <div class="col-sm-8">
						    <textarea class="form-control" rows="5" name="keluarga_alamat" id="keluarga_alamat"></textarea>
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">No. Telp</label>
						  <div class="col-sm-6">
						    <input class="form-control" type="text" name="keluarga_telp"  id="keluarga_telp">
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Agama</label>
						  <div class="col-sm-6">
						    <select class="form-control" style="width: 100%" name="keluarga_agama" id="keluarga_agama">
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
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Pendidikan</label>
						  <div class="col-sm-6">						    
							<select class="form-control select2" style="width: 100%" name="keluarga_pendidikan" id="keluarga_pendidikan">
								<option value="">-- Pilih Pendidikan Terakhir --</option>
								<option value="S3">S3 / Subspesialis</option>
								<option value="S2">S2 / Spesialis</option>
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
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Pekerjaan</label>
						  <div class="col-sm-6">
						    <select class="form-control select2" style="width: 100%" name="keluarga_pekerjaan" id="keluarga_pekerjaan">
								<option value="">-- Pilih Pekerjaan --</option>
								<?php foreach($pekerjaan as $row){
										echo '<option value="'.$row->pekerjaan.'">'.$row->pekerjaan.'</option>';
									}
								?>										
							</select>
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Pangkat / Golongan</label>
						  <div class="col-sm-6">
						    <input class="form-control" type="text" name="keluarga_pangkat" id="keluarga_pangkat">
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Alamat Kantor</label>
						  <div class="col-sm-8">
						    <textarea class="form-control" rows="5" name="keluarga_alamat_kantor" id="keluarga_alamat_kantor"></textarea>
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">No. Telp Kantor</label>
						  <div class="col-sm-6">
						    <input class="form-control" type="text" name="keluarga_telp_kantor" id="keluarga_telp_kantor">
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Jabatan</label>
						  <div class="col-sm-6">
						    <input class="form-control" type="text" name="keluarga_jabatan" id="keluarga_jabatan">
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Kesatuan</label>
						  <div class="col-sm-6">
						    <input class="form-control" type="text" name="keluarga_kesatuan" id="keluarga_kesatuan">
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Alamat Kesatuan</label>
						  <div class="col-sm-8">
						    <textarea class="form-control" rows="5" name="keluarga_alamat_kesatuan" id="keluarga_alamat_kesatuan"></textarea>
						  </div>
						</div>	
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">No. Telp Kesatuan</label>
						  <div class="col-sm-6">
						    <input class="form-control" type="text" name="keluarga_telp_kesatuan" id="keluarga_telp_kesatuan">
						  </div>
						</div>	
					</div>									                          
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save-keluarga" onclick="save_keluarga()"><i class="fa fa-floppy-o"></i> Simpan</button>
              </div>
              </form>  
          </div>
          <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
  	</div> 
  	<div class="modal fade modal_norujukan" tabindex="-1" role="dialog" aria-hidden="true">
	  	<div class="modal-dialog modal-lg">
	      	<div class="modal-content">
	          	<div class="modal-header text-center">
	              	<img class="pull-left" src="<?php echo site_url('assets/images/logos/logo_bpjs.png'); ?>" width="120"></img>
	              	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	          	</div>
	          	<div class="modal-body">
		  			<h4 class="text-center" style="font-weight: 600;">DATA RUJUKAN</h4>
		            <div class="table-responsive" style="clear: both;margin-top: 25px;">
						<table class="table-xs table-hover" width="100%">
						  <tbody>
						  	<tr>
								<td style="width: 25%;">No. Rujukan</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_nomor"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Tanggal Rujukan</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_tgl"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Faskes Perujuk</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_faskes"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Poli</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_poli"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Nama</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_nama"></td>
							</tr>
							<tr>
								<td style="width: 25%;">No. Kartu BPJS</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_noka"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Diagnosa</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_diagnosa"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Jenis Kelamin</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_gender"></td>
							</tr>						
							<tr>
								<td style="width: 25%;">Jenis Rawat</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_jenis_rawat"></td>
							</tr>								
						  </tbody>
						</table>					
					</div>
		        </div>
		      	<div class="modal-footer">
		      		<button type="button" class="btn btn-primary waves-effect text-left" data-dismiss="modal" onclick="terapkan_data_rujukan()"><i class="fa fa-check"></i> Gunakan Rujukan</button>
		          	<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
		      	</div>
	    	</div>    	
	  	</div>  	
	</div>	
	<div class="modal fade modal_nobpjs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
	              	<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
	          	</div>
	      	</div>
	      	<!-- /.modal-content -->
	  	</div>
	</div>	
	<div id="modal-search-kode" class="modal modal-search-kode fade" role="dialog" aria-labelledby="modal-search-kode" aria-hidden="true">
	  <div class="modal-dialog modal-lg modal-success">
	      <div class="modal-content">
	          <div class="modal-header">
	              <h4 class="modal-title" id="modal-search-kode">Cari Kode DPJP (BPJS)</h4>
	              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	          </div>
	          <div class="modal-body">
	              <div class="row">
	                <div class="col-sm-12">
	                  <div class="form-group row">
	                    <div class="col-sm-3">
	                      <select  class="form-control" style="width: 100%" name="jns_pelayanan" id="jns_pelayanan">
	                        <option value="2" selected="">R. Jalan</option>
	                        <option value="1">R. Inap</option>
	                      </select>
	                    </div>
	                    <div class="col-sm-6">
	                      <select  class="form-control" style="width: 100%" name="spesialis" id="spesialis" >
	                        <option value="NONE">-- Pilih Poli --</option>
	                        <?php                   
	                          foreach($poli as $row) {
	                            if ($row->poli_bpjs != '' || $row->poli_bpjs != null) {
	                              echo '<option value="'.$row->poli_bpjs.'">'.$row->nm_poli.'</option>';  
	                            }                                
	                          }
	                        ?>
	                      </select>
	                    </div>
	                    <div class="col-sm-3">
	                      <button class="btn btn-danger btn-block" type="button" id="btn-cari-dpjp"><i class="fa fa-search"></i> Cari</button>
	                    </div>
	                  </div>
	                </div>
	                <div class="col-sm-12">
	                  	<div class="form-group row">
		                    <div class="col-sm-12">
		                      	<div class="input-group">
		                      		<span class="input-group-btn">
		                                <button class="btn btn-info" type="button"><i class="fa fa-search"></i></button>
		                            </span>
		                            <input type="text" class="form-control" id="search_dpjp" onkeyup="search_dpjp()" placeholder="Ketikan Nama Dokter DPJP..">
		                        </div> 
		                    </div>
	                  	</div>
	                </div>
	                <div class="col-sm-12">
	                  	<div class="table-wrapper-scroll-y">
				            <table width="100%" class="table table-bordered table-condensed" id="table-dpjp">
				                <thead>
				                  <tr>
				                    <th class="text-center" width="22%"><b>Kode DPJP</b></th>
				                    <th class="text-center" width="63%"><b>Nama Dokter</b></th>
				                    <th class="text-center" width="15%"><b>Aksi</b></th>
				                  </tr>
				                </thead>
				                <tbody>
				                </tbody>
				            </table>
			            </div>
	                </div>
	              </div>
	          </div>
	          <div class="modal-footer">
	              <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
	          </div>
	      </div>
	      <!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 