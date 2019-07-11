<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mcviewtindakan extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmviewtindakan','',TRUE);
	}

	public function index(){
		$data['title'] = 'Tarif Tindakan';

		$data['viewtindakan']=$this->mmviewtindakan->get_all_viewtindakan()->result();
		$this->load->view('master/mvviewtindakan',$data);
		//print_r($data);
	}

	public function laboratorium(){
		$data['title'] = 'Tarif Tindakan';

		$data['viewtindakan']=$this->mmviewtindakan->get_all_viewtindakanby('H')->result();
		$this->load->view('master/mvviewtindakan',$data);
		//print_r($data);
	}

	public function radiologi(){
		$data['title'] = 'Tarif Tindakan';

		$data['viewtindakan']=$this->mmviewtindakan->get_all_viewtindakanby('L')->result();
		$this->load->view('master/mvviewtindakan',$data);
		//print_r($data);
	}

	public function get_data_edit_viewtindakan(){
		$idtindakan=$this->input->post('idtindakan');
		$datajson=$this->mmviewtindakan->get_data_viewtindakan($idtindakan)->result();
	    echo json_encode($datajson);
	}

}