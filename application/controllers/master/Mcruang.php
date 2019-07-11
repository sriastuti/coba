<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mcruang extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmruang','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Ruangan';

		$data['ruang']=$this->mmruang->get_all_ruang()->result();
		$data['bed']=$this->mmruang->get_all_bed()->result();
		$data['kelas']=$this->mmruang->get_all_kelas()->result();
		$this->load->view('master/mvruang',$data);
		//print_r($data);
	}

	public function insert_ruang(){

		$ruang['idrg']=$this->input->post('ruang_noruangan');
		$ruang['nmruang']=$this->input->post('ruang_nmruangan');
		$ruang['lokasi']=$this->input->post('ruang_lokasiruangan');
		$ruang['aktif']='Active';
		/*$ruang['VVIP']=$this->input->post('vvip');
		$ruang['VIP']=$this->input->post('vip');
		$ruang['UTAMA']=$this->input->post('utama');
		$ruang['I']=$this->input->post('i');
		$ruang['II']=$this->input->post('ii');
		$ruang['III']=$this->input->post('iii');*/
		$this->mmruang->insert_ruang($ruang);

		$tindakan['idtindakan']='1A'.$ruang['idrg'];
		$tindakan['nmtindakan']=$this->input->post('ruang_nmruangan');
		$tindakan['idpok1']='1';
		$tindakan['idpok2']='1A';
		$this->mmruang->insert_tindakan($tindakan);
		$tarif['id_tindakan']=$tindakan['idtindakan'];
		$tarif['idrg']=$this->input->post('ruang_noruangan');
		$tarif['kelas']='III';
		$this->mmruang->insert_tarif($tarif);
		
		redirect('master/Mcruang');
		// print_r($ruang);
	}

	public function get_data_edit_ruang(){
		$idrg=$this->input->post('idrg');
		$datajson=$this->mmruang->get_data_ruang($idrg)->result();
	    echo json_encode($datajson);
	}

	public function get_data_edit_bed(){
		$bed=$this->input->post('bed');
		$datajson=$this->mmruang->get_data_bed($bed)->result();
	    echo json_encode($datajson);
	}

	public function edit_ruang(){
		$idrg=$this->input->post('edit_idrg_hidden');
		$nmruang=$this->input->post('edit_nmruang');
		$lokasi=$this->input->post('edit_lokasiruang');

		// $data['idrg']=$idrg;
		$data['nmruang']=$nmruang;
		$data['lokasi']=$lokasi;
		/*$data['VVIP']=$this->input->post('edit_vvip');
		$data['VIP']=$this->input->post('edit_vip');
		$data['UTAMA']=$this->input->post('edit_utama');
		$data['I']=$this->input->post('edit_i');
		$data['II']=$this->input->post('edit_ii');
		$data['III']=$this->input->post('edit_iii');*/

		$this->mmruang->edit_ruang($idrg, $data);
		
		redirect('master/Mcruang');
		//print_r($data);
	}

	public function edit_bed(){
		$bed=$this->input->post('edit_bed_hidden');
		$no_bed=$this->input->post('edit_no_bed_hidden');
		$idrg=$this->input->post('edit_idrg_hidden');
		$kls=$this->input->post('edit_kelas');
		// if($kls=='VVIP'){
		// 	$kelas='VV';
		// } else if($kls=='VIP'){
		// 	$kelas='VP';
		// } else if($kls=='UTAMA'){
		// 	$kelas='UT';
		// } else if($kls=='I'){
		// 	$kelas='10';
		// } else if($kls=='II'){
		// 	$kelas='20';
		// } else if($kls=='III'){
		// 	$kelas='30';
		// }
		// } else if($kls=='III B'){
		// 	$kelas='3B';
		// } 
		// $data['bed']=$idrg.' '.$kelas.' '.$no_bed;
		// $data['kelas']=$this->input->post('edit_kelas');
		$data['isi']=$this->input->post('edit_isi');
		$data['status']=$this->input->post('edit_status');

		$this->mmruang->edit_bed($bed, $data);
		
		redirect('master/Mcruang');
		//print_r($data);
	}

	public function get_banyak_bed(){
		$idrg=$this->input->post('idrg');
		$kelas=$this->input->post('kelas');
		$datajson=$this->mmruang->get_banyak_bed($idrg, $kelas)->result();
	    echo json_encode($datajson);
	}

	public function insert_bed(){
		$data['idrg']=$this->input->post('idrg');
		$data['kelas']=$this->input->post('kelas');
		$no_bed=$this->input->post('no_bed_hidden');
		$no_bed++;
		if($no_bed<10){
			$no_bed='0'.$no_bed;
		}
		$kls=$this->input->post('kelas');
		if($kls=='VVIP'){
			$kelas='VV';
		} else if($kls=='VIP'){
			$kelas='VP';
		} else if($kls=='UTAMA'){
			$kelas='UT';
		} else if($kls=='I'){
			$kelas='10';
		} else if($kls=='II'){
			$kelas='20';
		} else if($kls=='III'){
			$kelas='30';
		}
		// } else if($data['kelas']=='III B'){
		// 	$kelas='3B';
		// } 
		$data['isi']='N';
		$data['status']=$this->input->post('status');
		$data['bed']=$data['idrg'].' '.$kelas.' '.$no_bed;
		$this->mmruang->insert_bed($data);
		
		redirect('master/Mcruang');
		//print_r($data);
	}

	public function hapus_bed(){
		$bed=$this->input->post('bed');
		$this->mmruang->delete_bed($bed);
		
		redirect('master/Mcruang');
		//print_r($this->mmruang->delete_bed($bed));
	}

}