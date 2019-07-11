 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('Radcterbilang.php');
require_once(APPPATH.'controllers/Secure_area.php');

class radckwitansi extends Secure_area{
	public function __construct() {
		parent::__construct();
		$this->load->model('rad/radmdaftar','',TRUE);
		$this->load->model('rad/radmkwitansi','',TRUE);
		$this->load->helper('pdf_helper');
	}
	public function index()
	{
		redirect('rad/radckwitansi/kwitansi','refresh');
	}
	
	public function kwitansi()
	{
		$data['title'] = 'Kwitansi Diagnostik';
		$data['daftar_rad']=$this->radmkwitansi->get_list_kwitansi()->result();
		if(sizeof($data['daftar_rad'])==0){
			$this->session->set_flashdata('message_nodata','<div class="row">
						<div class="col-md-12">
						  <div class="box box-default box-solid">
							<div class="box-header with-border">
							  <center>Tidak ada lagi data</center>
							</div>
						  </div>
						</div>
					</div>');
		}else{
			$this->session->set_flashdata('message_nodata','');
		}
		$this->load->view('rad/radvkwitansi',$data);
	}

	public function kwitansi_by_no()
	{
		$data['title'] = 'Kwitansi Diagnostik';
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$key=$this->input->post('key');
			$data['daftar_rad']=$this->radmkwitansi->get_list_kwitansi_by_no($key)->result();
			
			if(sizeof($data['daftar_rad'])==0){
				$this->session->set_flashdata('message_nodata','<div class="row">
							<div class="col-md-12">
							  <div class="box box-default box-solid">
								<div class="box-header with-border">
								  <center>Tidak ada lagi data</center>
								</div>
							  </div>
							</div>
						</div>');
			}else{
				$this->session->set_flashdata('message_nodata','');
			}
			$this->load->view('rad/radvkwitansi',$data);
		}else{
			redirect('rad/radckwitansi/kwitansi');
		}
	}

	public function kwitansi_by_date()
	{
		$data['title'] = 'Kwitansi Diagnostik';
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$date=$this->input->post('date');
			$data['daftar_rad']=$this->radmkwitansi->get_list_kwitansi_by_date($date)->result();
			if(sizeof($data['daftar_rad'])==0){
				$this->session->set_flashdata('message_nodata','<div class="row">
							<div class="col-md-12">
							  <div class="box box-default box-solid">
								<div class="box-header with-border">
								  <center>Tidak ada lagi data</center>
								</div>
							  </div>
							</div>
						</div>');
			}else{
				$this->session->set_flashdata('message_nodata','');
			}
			$this->load->view('rad/radvkwitansi',$data);
		}else{
			redirect('rad/radckwitansi/kwitansi');
		}
	}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////read data pelayanan poli per pasien
	public function kwitansi_pasien($no_rad='')
	{
		$data['title'] = 'Cetak Kwitansi Diagnostik';
		if($no_rad!=''){
			$data['no_rad']=$no_rad;
			$data['data_pasien']=$this->radmkwitansi->get_data_pasien($no_rad)->row();
			$data['data_pemeriksaan']=$this->radmkwitansi->get_data_pemeriksaan($no_rad)->result();
			if(sizeof($data['data_pemeriksaan'])==0){
				$this->session->set_flashdata('message_no_tindakan','<div class="row">
							<div class="col-md-12">
							  <div class="box box-default box-solid">
								<div class="box-header with-border">
								  <center>Tidak Ada Tindakan</center>
								</div>
							  </div>
							</div>
						</div>');
			}else{
				$this->session->set_flashdata('message_no_tindakan','');
			}
			
			$this->load->view('rad/radvkwitansipasien',$data);
		}else{
			redirect('rad/radckwitansi/kwitansi');
		}
	}
	
	public function st_cetak_kwitansi_kt()
	{
		$no_rad=$this->input->post('no_rad');
		$xuser=$this->input->post('xuser');
		if ($this->input->post('penyetor')=="") 
		{
			$data_pasien=$this->radmkwitansi->get_data_pasien($no_rad)->row();
			$penyetor=$data_pasien->nama;
		} else {
			$penyetor=$this->input->post('penyetor');
		}
		$jumlah_vtot=$this->input->post('jumlah_vtot');
		$diskon=$this->input->post('diskon_hide');

		if($no_rad!=''){
			$no_register=$this->radmdaftar->get_row_register_by_norad($no_rad)->row()->no_register;
			$this->radmkwitansi->update_status_cetak_kwitansi($no_rad, $diskon, $no_register, $xuser);
			echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'";document.cookie = "diskon='.$diskon.'";document.cookie = "jumlah_vtot='.$jumlah_vtot.'";window.open("'.site_url("rad/radckwitansi/cetak_kwitansi_kt/$no_rad").'", "_blank");window.focus()</script>';
			
			redirect('rad/radckwitansi/kwitansi/','refresh');
		}else{
			redirect('rad/radckwitansi/kwitansi/','refresh');
		}
	}

	public function st_selesai_kwitansi_kt($no_rad='')
	{
		if($no_rad!=''){
			redirect('rad/radckwitansi/kwitansi/','refresh');
		}else{
			redirect('rad/radckwitansi/kwitansi/','refresh');
		}
	}

	public function cetak_kwitansi_kt($no_rad='')
	{
		$penyetor =  $_COOKIE['penyetor'];
		$jumlah_vtot =  $_COOKIE['jumlah_vtot'];
		$diskon =  $_COOKIE['diskon'];
		if($no_rad!=''){
			$cterbilang=new radcterbilang();
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars=$this->config->item('namars');
			$alamat=$this->config->item('alamat');
			$kota_kab=$this->config->item('kota');
			$header_pdf=$this->config->item('header_pdf');
			$data_pasien=$this->radmkwitansi->get_data_pasien($no_rad)->row();
			$data_pemeriksaan=$this->radmkwitansi->get_data_pemeriksaan($no_rad)->result();
			
			$konten="<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					.table-font-size1{
						font-size:12px;
					    }
					.table-font-size2{
						font-size:9px;
						margin : 5px 1px 1px 1px;
						padding : 5px 1px 1px 1px;
					    }
					</style>
					
					<font size=\"6\" align=\"right\">$tgl_jam</font><br>
					$header_pdf
					<hr>
					<p align=\"center\"><b>
					BUKTI PEMBAYARAN - KWITANSI LUNAS BIAYA DIAGNOSTIK<br/>
					No. DIA_$no_rad
					</b></p><br/>
					<table>
						<tr>
							<td width=\"15%\"><b>Sudah Terima Dari</b></td>
							<td width=\"2%\"> : </td>
							<td width=\"38%\">".strtoupper($penyetor)."</td>
							<td width=\"15%\"><b>Tanggal Periksa</b></td>
							<td width=\"2%\"> : </td>
							<td width=\"28%\">$tgl</td>
						</tr>
						<tr>
							<td><b>Nama Pasien</b></td>
							<td> : </td>
							<td>$data_pasien->nama</td>
							<td><b>Golongan Pasien</b></td>
							<td> : </td>
							<td>$data_pasien->cara_bayar</td>
						</tr>
						<tr>
							<td><b>Alamat</b></td>
							<td> : </td>
							<td colspan=\"4\">$data_pasien->alamat</td>
						</tr>
					</table>
					<br/><br/>
					<table border=\"1\" style=\"padding:2px\">
						<tr>
							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
							<th width=\"65%\"><p align=\"center\"><b>Nama Pemeriksaan</b></p></th>
							<th width=\"10%\"><p align=\"center\"><b>Banyak</b></p></th>
							<th width=\"20%\"><p align=\"center\"><b>Total</b></p></th>
						</tr>
					";
					$i=0;
					$jumlah_vtot=0;
					foreach($data_pemeriksaan as $row){
						$jumlah_vtot=$jumlah_vtot+$row->vtot;
						$vtot = number_format( $row->vtot, 2 , ',' , '.' );
						$i++;

					}
				$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"center\"><b> Diagnostik  </b></p></th>
							<th><p align=\"right\"><b>".$i."   </b></p></th>
							<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
						</tr>";
				if($diskon!=0){
					$konten=$konten."
						<tr>
							<th colspan=\"3\"><p align=\"right\"><b>Diskon   </b></p></th>
							<th><p align=\"right\">".number_format( $diskon, 2 , ',' , '.' )."</p></th>
						</tr>";
					$jumlah_vtot=$jumlah_vtot-$diskon;
					$konten=$konten."
						<tr>
							<th colspan=\"3\"><p align=\"right\"><b>Total Bayar</b></p></th>
							<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
						</tr>";
				}
				$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
					
				$konten=$konten."
					</table>
					<br><br>
					<b width=\"50%\">
						<font size=\"9\">Terbilang<br>
							<i>".strtoupper($vtot_terbilang)."
						</font>
					</b><br>
					<table>
						<tr>
							<td></td>
							<td></td>
							<td>$kota_kab, $tgl</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>an.Kepala Rumah Sakit</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>K a s i r</td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>----------------------------------------</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>ADMIN</td>
						</tr>
					</table>
					";
			
			$file_name="KW_$no_rad.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setPrintHeader(false);
				$obj_pdf->setPrintFooter(false);
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins('5', '5', '5');
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/rad/radkwitansi/'.$file_name, 'FI');
		}else{
			redirect('rad/radckwitansi/kwitansi/','refresh');
		}
	}
	
}
?>