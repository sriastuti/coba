 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('Labcterbilang.php');
require_once(APPPATH.'controllers/Secure_area.php');

class Fisiockwitansi extends Secure_area{
	public function __construct() {
		parent::__construct();
		$this->load->model('fisio/fisiomdaftar','',TRUE);
		$this->load->model('fisio/fisiomkwitansi','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index()
	{
		redirect('fisio/fisiockwitansi/kwitansi','refresh');
	}
	
	public function kwitansi()
	{
		$data['title'] = 'Kwitansi Fisioterapi';
		$data['daftar_fisio']=$this->fisiomkwitansi->get_list_kwitansi()->result();
		if(sizeof($data['daftar_fisio'])==0){
			$this->session->set_flashdata('message_nodata','
					<div class="row">
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
		$this->load->view('fisio/fisiovkwitansi',$data);
	}

	public function kwitansi_by_no()
	{
		$data['title'] = 'Kwitansi Fisioterapi';
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$key=$this->input->post('key');
			$data['daftar_fisio']=$this->fisiomkwitansi->get_list_kwitansi_by_no($key)->result();
			
			if(sizeof($data['daftar_fisio'])==0){
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
			$this->load->view('fisio/fisiovkwitansi',$data);
		}else{
			redirect('fisio/fisiockwitansi/kwitansi');
		}
	}

	public function kwitansi_by_date()
	{
		$data['title'] = 'Kwitansi Fisioterapi';
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$date=$this->input->post('date');
			$data['daftar_fisio']=$this->fisiomkwitansi->get_list_kwitansi_by_date($date)->result();
			if(sizeof($data['daftar_fisio'])==0){
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
			$this->load->view('fisio/fisiovkwitansi',$data);
		}else{
			redirect('fisio/fisiockwitansi/kwitansi');
		}
	}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////read data pelayanan poli per pasien
	public function kwitansi_pasien($no_fisio='')
	{
		$data['title'] = 'Cetak Kwitansi Fisioterapi';
		if($no_fisio!=''){
			$data['no_fisio']=$no_fisio;
			$data['data_pasien']=$this->fisiomkwitansi->get_data_pasien($no_fisio)->row();
			$data['data_pemeriksaan']=$this->fisiomkwitansi->get_data_pemeriksaan($no_fisio)->result();
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
			
			$this->load->view('fisio/fisiovkwitansipasien',$data);
		}else{
			redirect('fisio/fisiockwitansi/kwitansi');
		}
	}
	
	public function st_cetak_kwitansi_kt()
	{
		$no_fisio=$this->input->post('no_fisio');
		$xuser=$this->input->post('xuser');
		if ($this->input->post('penyetor')=="") 
		{
			$data_pasien=$this->fisiomkwitansi->get_data_pasien($no_fisio)->row();
			$penyetor=$data_pasien->nama;
		} else {
			$penyetor=$this->input->post('penyetor');
		}
		$jumlah_vtot=$this->input->post('jumlah_vtot');
		$diskon=$this->input->post('diskon_hide');
		if($diskon==""){
			$diskon = 0;
		}
		if($no_fisio!=''){
			$no_register=$this->fisiomdaftar->get_row_register_by_nofisio($no_fisio)->row()->no_register;
			$this->fisiomkwitansi->update_status_cetak_kwitansi($no_fisio, $diskon, $no_register, $xuser);
			//print_r($no_fisio.' '.$diskon.' '.$no_register.' '.$xuser);
			echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'";document.cookie = "diskon='.$diskon.'";document.cookie = "jumlah_vtot='.$jumlah_vtot.'";window.open("'.site_url("fisio/fisiockwitansi/cetak_kwitansi_kt/$no_fisio").'", "_blank");window.focus()</script>';
			
			redirect('fisio/fisiockwitansi/kwitansi/','refresh');
		}else{
			redirect('fisio/fisiockwitansi/kwitansi/','refresh');
		}
	}

	public function st_selesai_kwitansi_kt($no_fisio='')
	{
		if($no_fisio!=''){
			redirect('fisio/fisiockwitansi/kwitansi/','refresh');
		}else{
			redirect('fisio/fisiockwitansi/kwitansi/','refresh');
		}
	}

	public function cetak_kwitansi_kt($no_fisio='')
	{
		$penyetor =  $_COOKIE['penyetor'];
		$jumlah_vtot =  $_COOKIE['jumlah_vtot'];
		$diskon =  $_COOKIE['diskon'];
		if($no_fisio!=''){
			$cterbilang=new fisiocterbilang();
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars=$this->config->item('namars');
			$alamatrs=$this->config->item('alamat');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('kota');
			$header_pdf=$this->config->item('header_pdf');
			$data_pasien=$this->fisiomkwitansi->get_data_pasien($no_fisio)->row();
			$data_pemeriksaan=$this->fisiomkwitansi->get_data_pemeriksaan($no_fisio)->result();
			
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
					BUKTI PEMBAYARAN - KWITANSI LUNAS BIAYA FISIOTERAPI<br/>
					No. FISIO_$no_fisio
					</b></p>
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
							<th colspan=\"2\"><p align=\"center\"><b> Fisioterapi  </b></p></th>
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
			
			$file_name="KW_$no_fisio.pdf";
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
				$obj_pdf->Output(FCPATH.'download/fisio/fisiokwitansi/'.$file_name, 'FI');
		}else{
			redirect('fisio/fisiockwitansi/kwitansi/','refresh');
		}
	}

}
?>