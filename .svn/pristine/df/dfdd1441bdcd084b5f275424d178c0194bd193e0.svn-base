<?php
  $this->load->view("layout/header_horizontal");
?>
<style type="text/css">
  	th { font-size: 14px; }  	
    .page-titles {
      display: none;
    }
</style>
<script type="text/javascript">
  var table_sep;  
  $(document).ready(function() {   
    $("#form_kirim").submit(function(event) {
        document.getElementById("btn-submit").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'ina_cbg/klaim/send_claim'; ?>",
            dataType: "JSON",
            data: $('#form_kirim').serialize(),
            success: function(data){                 
              if (data.metadata.code) {
                if (data.metadata.code == '200') {
                  document.getElementById("btn-submit").innerHTML = '<i class="fa fa-paper-plane-o"></i> Kirim Klaim (Online)';
                  $("#jenis_rawat").val("").change();
                  $("#date_type").val("").change();                
                  $('#form_kirim')[0].reset();                
                  swal("Sukses", "Kirim Klaim Online Berhasil.", "success");
                } else swal("Gagal Kirim Klaim Online.", data.metadata.message, "error");
              } else {
                document.getElementById("btn-submit").innerHTML = '<i class="fa fa-paper-plane-o"></i> Kirim Klaim (Online)';
                else swal("Error", "Gagal Kirim Klaim Online. Silahkan coba lagi.", "error"); 
                console.log(data);
              }
            },
            error:function(event, textStatus, errorThrown) { 
              document.getElementById("btn-submit").innerHTML = '<i class="fa fa-paper-plane-o"></i> Kirim Klaim (Online)'; 
              swal(errorThrown, textStatus, "error");      
              console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
        });
      event.preventDefault();
    });
    $('#divider_klaim').hide();
    $('#tanggal_cari').daterangepicker({      
      locale: {
          format: 'YYYY/MM/DD'
      },
      buttonClasses: ['btn', 'btn-sm'],
      applyClass: 'btn-danger',
      cancelClass: 'btn-inverse'
    });
    $('#tanggal_cari').on('apply.daterangepicker', function(ev, picker) {
      table_sep.ajax.reload(); 
      var bulan = ['','Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']; 
      var from_month = parseInt(picker.startDate.format('MM'));
      var to_month = parseInt(picker.endDate.format('MM'));                            
      $('#from_date').html(picker.startDate.format('DD')+' '+bulan[from_month]+ ' '+picker.startDate.format('YYYY')); 
      $('#to_date').html(picker.endDate.format('DD')+' '+bulan[to_month]+ ' '+picker.endDate.format('YYYY'));      
    });
    table_sep = $('#table-sep').DataTable({ 
      "processing": true,
      "serverSide": true,
      "order": [],
      "language": {
        "searchPlaceholder": " No. SEP, Nama"
      },
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('irj/kelola_sep/get_sep')?>",
        "type": "POST",
        "dataType": "JSON",
        "data": function (data) {
          data.tanggal_cari = $('#tanggal_cari').val();
        }   
      },
      "columnDefs": [{ 
        "orderable": false,
        "targets": [0,6]
      }],   
    });      
  });

function hapus_sep(no_sep) {
	swal({
    title: "Hapus SEP",
    text: "Yakin akan menghapus Nomor SEP tersebut?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Hapus",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
    }, function() {
     	$.ajax({
        type: "POST",
        url: "<?php echo base_url().'bpjs/sep/delete'; ?>",
        dataType: "JSON",
        data: {'no_sep' : no_sep,'jnsPelayanan' : '2'},
        success: function(result){  
          	if (result.metaData.code == '200') {
          		table_sep.ajax.reload();
              swal("Sukses", "SEP berhasil dihapus.", "success");
          	} else {
              	swal("Gagal menghapus SEP", result.metaData.message, "error");
          	}
        },
        error:function(event, textStatus, errorThrown) {    
            swal(errorThrown,textStatus, "error");     
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
		  });
  });
}

function update_sep(no_sep) {
	$('#modal_update').modal('show');
}

function cetak_sep(no_register) {   
  $.ajax({
    type: "POST",
    url: "<?php echo base_url().'bpjs/sep/show_irj/'; ?>"+no_register,
    dataType: "JSON",    
    success: function(result){  
        if (result.metaData.code == '200') {          
          window.open('<?php echo base_url().'bpjs/sep/irj/'; ?>'+no_register, '_blank');
        } else if (result.metaData.code == 'No.SEP Harus Diisi 19 digit') {    
          swal("SEP Tidak Ditemukan","No. SEP Harus 19 digit.", "warning");  
        } else {
          swal("Gagal mencetak SEP", result.metaData.message, "error");           
        }
    },
    error:function(event, textStatus, errorThrown) {    
        swal(errorThrown,textStatus, "error");    
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
    }
  });
}

function penjaminan_sep(no_register) {     
  swal({
      title: "Pengajuan Penjaminan SEP",
      text: "Isi keterangan pengajuan :",
      type: "input",
      showCancelButton: true,
      closeOnConfirm: false,
      confirmButtonText: "Submit",
      animation: "slide-from-top",
      inputPlaceholder: "Isi keterangan",
      showLoaderOnConfirm: true
  }, function(keterangan){
      if (keterangan === false) return false;
      if (keterangan === "") {
        swal.showInputError("Keterangan tidak boleh kosong!");
        return false
      } 
      $.ajax({
        type: "POST",
        url: "<?php echo base_url().'bpjs/sep/pengajuan_penjaminan_irj/'; ?>"+no_register,
        dataType: "JSON",    
        data: {'keterangan' : keterangan},
        success: function(result) {   
            if (result.metaData.code == '200') {          
              window.open('<?php echo base_url().'bpjs/sep/create_irj/'; ?>'+no_register, '_blank');
            } else {
              swal("Penjaminan SEP Gagal",result.metaData.message, "error");            
            }
        },
        error:function(event, textStatus, errorThrown) {    
            swal(errorThrown,textStatus, "error");     
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
      });     
  });  
}

</script>
<br>
<?php echo $this->session->flashdata('notification');?>
<div class="row">
  <div class="col-lg-12 col-md-12">    
    <div class="card card-outline-info">
      <div class="card-header">             
        <h4 class="m-b-0 text-white text-center">Laporan Klaim</h4> 
      </div>
      <div class="card-block">  
        <?php $attributes = array('class' => 'form-horizontal','id' => 'form_kirim');
        echo form_open('ina_cbg/klaim/send_claim',$attributes);?>
          <div class="form-group row m-b-0">
            <label for="example-text-input" class="col-sm-2 control-label col-form-label" style="max-width: 150px">Jenis Rawat : </label>
            <div class="col-sm-2">
              <select class="form-control" name="jenis_rawat" id="jenis_rawat">
                <option value="2" selected>Rawat Jalan</option>
                <option value="1">Rawat Inap</option>
                <option value="3">Rawat Inap &amp; Jalan</option>
              </select>
            </div>
            <label for="example-text-input" class="col-sm-2 control-label col-form-label" style="max-width: 130px">Tanggal : </label>
            <div class="col-sm-3">
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control" name="tanggal_cari" id="tanggal_cari" value="<?php echo date('Y/m/d'); ?> - <?php echo date('Y/m/d'); ?>">
              </div>
            </div>
            <div class="col-sm-3">
              <button type="submit" class="btn btn-danger" id="btn-submit"><i class="fa fa-download"></i> Unduh Laporan</button> 
            </div>
          </div>    
        <?php echo form_close();?> 
        <hr id="divider_klaim">
        <!-- <div class="table-responsive m-t-0">      
          <table id="table-sep" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th>No. SEP</th>
                <th>No.RM</th>
                <th>Nama</th>
                <th>No.Kartu</th>
                <th>Tgl Kunjungan</th>                
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div> -->
      </div>
    </div>        
  </div>
</div>


	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="title_modal" aria-hidden="true" id="modal_update">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="modal-title" id="title_modal">Update SEP</h4>
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	            </div>
	            <div class="modal-body">
                   	<ul class="nav nav-tabs customtab" role="tablist">
                       	<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#data" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Catatan</span></a> </li>
                       	<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tglpulang" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Tanggal Pulang</span></a> </li>
                   	</ul>
                    <div class="tab-content">
                        <div class="tab-pane active p-20" id="data" role="tabpanel">
                        	<form class="form-horizontal" id="form_catatan">
                        		<div class="form-group row">
								  <label for="example-number-input" class="col-sm-2 col-form-label">Catatan</label>
								  <div class="col-sm-9">
								    <textarea class="form-control" rows="5" name="catatan" id="catatan"></textarea>
								  </div>
								</div>
								<div class="form-group row">
								  <div class="offset-sm-2 col-sm-9">	
								    <button type="submit" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
								  </div>
								</div>
                        	</form>
                        </div>
                        <div class="tab-pane  p-20" id="tglpulang" role="tabpanel">
                        	<form class="form-horizontal" id="form_tglpulang">
                        		<div class="form-group row">
								  <label for="example-number-input" class="col-sm-3 col-form-label">Tanggal Pulang</label>
								  <div class="col-sm-6">
								   	<input type="text" class="form-control" name="tgl_pulang" id="tgl_pulang">
								  </div>
								</div>
								<div class="form-group row">
								  <div class="offset-sm-3 col-sm-9">	
								    <button type="submit" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
								  </div>
								</div>
                        	</form>
                        </div>
                    </div>                                 
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
	            </div>
	        </div>
	        <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
	</div>
	<!-- /.modal Update SEP -->

<?php
  $this->load->view("layout/footer_horizontal");
?>