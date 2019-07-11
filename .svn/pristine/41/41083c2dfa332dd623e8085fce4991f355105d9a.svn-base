<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mcjadwal extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/Mmjadwal','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Jadwal';
		$data['dokter']=$this->Mmjadwal->get_all_dokter()->result();
		$data['jadwal']=$this->Mmjadwal->get_all_jadwal()->result();
		$data['poli']=$this->rjmpencarian->get_poliklinik()->result();
		$this->load->view('master/mvjadwal',$data);
		//print_r($data);
	}

	public function insert_jadwal(){
			$data['id_dokter']=$this->input->post('dokter');
				$data['id_poli']=$this->input->post('poli');
					$data['hari']=$this->input->post('hari');
						$data['awal']=$this->input->post('awal');
							$data['akhir']=$this->input->post('akhir');
							$this->Mmjadwal->insert_jadwal_dokter($data);
		
		
		redirect('master/Mcjadwal');
		//print_r($data);
	}

	public function get_data_edit_jadwal(){
		$id=$this->input->post('id');
		$datajson=$this->Mmjadwal->get_data_jadwal($id)->result();
	    echo json_encode($datajson);
	}

	public function edit_jadwal(){
		$id=$this->input->post('edit_id_hidden');
		$data['hari']=$this->input->post('edit_hari');
		$data['awal']=$this->input->post('edit_awal');
		$data['akhir']=$this->input->post('edit_akhir');
		$this->Mmjadwal->edit_jadwal($id, $data);
		redirect('master/Mcjadwal');
		//print_r($data);
	}
	public function delete_jadwal_dokter($id=''){
		$data['deleted']='1';
		$datajson=$this->Mmjadwal->delete_jadwal_dokter($id,$data);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Jadwal Dokter dengan ID "'.$id.'" berhasil dihapus
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
	    redirect('master/Mcjadwal','refresh');
	}
}