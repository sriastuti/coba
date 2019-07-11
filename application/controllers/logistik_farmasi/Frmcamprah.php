<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
//include('Frmcterbilang.php');
class Frmcamprah extends Secure_area
{
  public function __construct(){
	parent::__construct();
	$this->load->model('logistik_farmasi/Frmmamprah','',TRUE);
	$this->load->model('master/Mmobat','',TRUE);
	$this->load->helper('pdf_helper');
	}

	function index()
	{
		$data['title'] = 'Monitoring Permintaan Distribusi Obat';
		$data['select_gudang0'] = $this->Frmmamprah->get_gudang_asal()->result();
		$data['select_gudang1'] = $this->Frmmamprah->get_gudang_tujuan()->result();	
		$this->load->view('logistik_farmasi/Frmvdaftaramprah',$data);
	}
	
	function form($param='')
	{
		if($param!=''){
			$data['title'] = 'Form Permintaan Distribusi Barang Habis Pakai (BHP)';
			$data['select_gudang0'] = $this->Frmmamprah->get_gudang_asal()->result();
			$data['select_gudang1'] = $this->Frmmamprah->get_gudang_tujuan()->result();		
	        $data['data_obat']=$this->Mmobat->get_all_bhp()->result();        
			$this->load->view('logistik_farmasi/Frmvaddamprah_bhp',$data);
		}else{
			$data['title'] = 'Form Permintaan Distribusi Obat (Amprah)';
			$data['select_gudang0'] = $this->Frmmamprah->get_gudang_asal()->result();
			$data['select_gudang1'] = $this->Frmmamprah->get_gudang_tujuan()->result();		
	        $data['data_obat']=$this->Mmobat->get_all_obat()->result();        
			$this->load->view('logistik_farmasi/Frmvaddamprah',$data);
		}
		
	}
	
    function save(){	
		$id_amprah = $this->Frmmamprah->insert($this->input->post()) ;
		if ( $id_amprah != '' ){
			$msg = 	' <div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-check"></i>Data permintaan distribusi berhasil disimpan
					  </div>';
		}else{				
			$msg = 	' <div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-ban"></i>Data permintaan distribusi gagal disimpan
					  </div>';
		}
		$this->session->set_flashdata('alert_msg', $msg);
		$this->cetak_faktur_amprah($id_amprah);
		$this->session->set_flashdata('cetak', 'cetak('.$id_amprah.');');
		redirect('logistik_farmasi/Frmcamprah/form');
		
  }
  
	public function get_satuan_obat(){
		$data = $this->Frmmamprah->get($this->input->post('id'));
		echo $data->satuank;
	}
	
	public function auto_id_amprah(){
		$keyword = $this->uri->segment(4);
		$data = $this->db->from('amprah')->like('id_amprah',$keyword)->limit(12, 0)->get()->result();	

		foreach($data as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$row->id_amprah
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}
	
    function get_info(){
		$id = $this->input->post('id');
		echo json_encode($this->Frmmamprah->get_info($id));
    }
    function get_amprah_list(){		
		//echo sizeof($_POST);
		$line  = array();
		$line2 = array();
		$row2  = array();
		if(sizeof($_POST)==0) {
			$line['data'] = $line2;
		}else{		
			$hasil = $this->Frmmamprah->getdata_amprah_by_role($this->input->post());
			/*$line['data'] = $hasil;*/			
			foreach ($hasil as $value) {
				$row2['id_amprah'] = $value->id_amprah;
				$row2['tgl_amprah'] = $value->tgl_amprah;
				$row2['gd_dituju'] = $value->nama_gudang;
				$row2['gd_asal'] = $value->nama_gudang_dituju;
				//$row2['sumber_dana'] = $value->sumber_dana;
				$row2['user'] = $value->user;
				//$row2['no_faktur'] = $value->no_faktur;
				if ($value->status != 1)
					$row2['status'] = '<font color="red">Open</font>';

				else
					$row2['status'] = '<font color="green">Closed</font>';
				if ($value->status != 1)
					$row2['aksi'] = '<center>
					<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal" data-id="'.$value->id_amprah.'">Detail</button> 
								</center>';
				else
					$row2['aksi'] ="";
					// $row2['aksi'] ='<center>
					// <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal2" data-id="'.$value->id_amprah.'">Cetak</button> 
					// 			</center>';
								
					$line2[] = $row2;
			}
			$line['data'] = $line2;
			
		}
		echo json_encode($line);
    }

    function get_amprahbhp_list(){		
		//echo sizeof($_POST);
		$line  = array();
		$line2 = array();
		$row2  = array();
		if(sizeof($_POST)==0) {
			$line['data'] = $line2;
		}else{		
			$hasil = $this->Frmmamprah->getdata_amprahbhp_by_role($this->input->post());
			/*$line['data'] = $hasil;*/			
			foreach ($hasil as $value) {
				$row2['id_amprah'] = $value->id_amprah;
				$row2['tgl_amprah'] = $value->tgl_amprah;
				$row2['gd_dituju'] = $value->nama_gudang;
				$row2['gd_asal'] = $value->nama_gudang_dituju;
				//$row2['sumber_dana'] = $value->sumber_dana;
				$row2['user'] = $value->user;
				//$row2['no_faktur'] = $value->no_faktur;
				if ($value->status != 1)
					$row2['status'] = '<font color="red">Open</font>';
				else
					$row2['status'] = '<font color="green">Closed</font>';
				if ($value->status != 1)
					$row2['aksi'] = '<center>
					<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal" data-id="'.$value->id_amprah.'">Detail</button> 
								</center>';
				else
					$row2['aksi'] ="";
					// $row2['aksi'] ='<center>
					// <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal2" data-id="'.$value->id_amprah.'">Cetak</button> 
					// 			</center>';
							
				$line2[] = $row2;
			}
			$line['data'] = $line2;
			
		}
		echo json_encode($line);
    }

    function get_amprah_detail_list(){		
		$line  = array();
		$line2 = array();
		$row2  = array();
		$hasil = $this->Frmmamprah->get_amprah_detail_list($this->input->post('id'));
		
		foreach ($hasil as $value) {
			$row2['id_obat'] = $value->id_obat;
			$row2['nm_obat'] = $value->nm_obat;
			$row2['satuank'] = $value->satuank;
			$row2['qty_req'] = $value->qty_req;
			$row2['qty_acc'] = $value->qty_acc;
			$row2['batch_no'] = $value->batch_no;
			$row2['keterangan'] = $value->keterangan;	
			$row2['expire_date'] = $value->expire_date;
			$row2['hargabeli'] = $value->hargabeli;
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }
	public function cetak_faktur_amprah($id_amprah){
		//$id_amprah = 23;
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$tgl = date("d-m-Y");

		  $namars=$this->config->item('namars');
		  $kota_kab=$this->config->item('kota_kab');
		  $alamatrs=$this->config->item('alamat');
		  $telp=$this->config->item('kota');
	   
		//$data_detail_amprah=$this->Frmmamprah->get_receivings($no_faktur_amp)->result();
		$data1=$this->Frmmamprah->get_info($id_amprah);
		$data = json_decode(json_encode($data1), true);
		/*
		 $data['select_gudang']=$this->Frmmamprah->cari_gudang()->result();
		*/  

		$konten=
				  "<table style=\"padding:0px;\" border=\"0\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/logo_mintohardjo.png\" alt=\"img\" height=\"40\" style=\"padding-right:5px;\">
								</p>
							</td>
								<td  width=\"70%\" style=\" font-size:9px;\"><b><font style=\"font-size:12px\">$namars</font></b><br>$alamatrs $kota_kab $telp
							</td>
							<td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam</font></td>						
						</tr>
						<hr>
					</table>
				  <br>
				  <p align=\"center\"><b>
				  PERMINTAAN BARANG<br/>
				  No. AMP.".$id_amprah."
				  </b></p><br/>
				  <br><br>
				  <table>
					<tr>
					  <td width=\"15%\"><b>Gudang Asal</b></td>
					  <td width=\"3%\"> : </td>
					  <td width=\"25%\">".$data['nm_gd_asal']."</td>
					</tr>
					<tr>
					  <td width=\"15%\"><b>Gudang Tujuan</b></td>
					  <td width=\"3%\"> : </td>
					  <td width=\"25%\">".$data['nm_gd_dituju']."</td>
					</tr>
				  </table>
				  <br/><br/>
				  <table style=\"font-size: 8px;\" border=\"0.5\">
					<tr>
					  <th width=\"5%\"><b>No</b></th>
					   <th width=\"10%\"><b>Kode</b></th>
					  <th width=\"50%\"><b>Nama Item</b></th>
					  <th width=\"10%\"><b>Qty</b></th>
					  <th width=\"25%\"><b>Satuan</b></th>
					</tr>";
		
		$data_detail_amprah=$this->Frmmamprah->get_amprah_detail_list($id_amprah);
		foreach($data_detail_amprah as $key=>$row){
			$konten = $konten . "
					<tr>
						<td>".($key+1)."</td>
						<td>".$row->id_obat."</td>
						<td>".$row->nm_obat."</td>
						<td>".$row->qty_req."</td>
						<td> ".$row->satuank."</td>
					</tr>";
		}
		$konten = $konten ."
					<br>
		  </table>
		  <table>
		  <tr>
					  <td></td>
					</tr>
		  			<tr>
		  			  <td width=\"58%\"></td>
					  <td width=\"40%\">Jakarta, ______ ________________ 20____</td>
					</tr>
					<br><br><br>
					<center>
					<tr>
					  <td width=\"4%\"></td>
					  <td width=\"30%\"></td>
					  <td width=\"30%\"></td>
					  <td width=\"30%\" align=\"center\">Mengetahui,</td>
					</tr>
					<tr>
					  <td width=\"4%\"></td>
					  <td width=\"34%\" align=\"center\">&nbsp;&nbsp;&nbsp;Yang Menerima</td>
					  <td width=\"26%\" align=\"center\">Yang Mengeluarkan</td>
					  <td width=\"30%\" align=\"center\">Kepala Gudang</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<br><br><br>
					<tr>
					  <td width=\"10%\"></td>
					  <td width=\"25%\"><b><hr></b></td>
					  <td  width=\"3%\"></td>
					  <td width=\"25%\"><b><hr></b></td>
					  <td  width=\"3%\"></td>
					  <td width=\"25%\"><b><hr></b></td>
					</tr>
					</center>
		  </table>
		  ";

					  
		$file_name="FA_$id_amprah.pdf";

		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetPrintHeader(false);
		$obj_pdf->SetPrintFooter(false);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins('10', '10', '10');
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		  $content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'download/logistik_farmasi/'.$file_name, 'F');
		
	  } 


    
}
?>
