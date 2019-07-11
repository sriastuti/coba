<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(document).ready(function() {
    $('#example').DataTable();

   
		$('#date_picker_days').datepicker({
				format: "yyyy-mm-dd",
				endDate: "current",
				autoclose: true,
				todayHighlight: true,
		}); 
		
		var size = "<?php echo $size;?>";
		//alert(size+" awdad");
		if(size==''){		
			$('#btnCetak').addClass('disabled');
		}

		var tampil = "<?php echo $tampil_per;?>";
		if(tampil!=''){
		$('select[name="tampil_per"]').val(tampil).change();
		}
});

	function cek_tampil_per(val_tampil_per){
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker_days").required = true;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker_days').datepicker("setDate", "0");
			$('#date_input').show();
			$('#month_input').hide();
			$('#year_input').hide();
	}

</script>
