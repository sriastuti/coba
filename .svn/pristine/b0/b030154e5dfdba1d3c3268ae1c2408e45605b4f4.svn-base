<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mcdokter extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmdokter','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
		$this->load->helper(array('html','url')); 
	}

	public function index(){
		$data['title'] = 'Master Dokter';

		$data['dokter']=$this->mmdokter->get_all_dokter()->result();
		$data['poli']=$this->rjmpencarian->get_poliklinik()->result();
		$data['biaya']=$this->mmdokter->get_all_biaya()->result();
		$this->load->view('master/mvdokter',$data);
		//print_r($data);
	}

	public function insert_dokter(){

		if (empty($_FILES["insert_scan_ttd"]["name"])) { 
			$data['scan_ttd']='';
		} else {
			$config['upload_path'] = './upload/ttd_dokter/'; 
	        $config['allowed_types'] = 'jpg|jpeg|png|gif';  
	        $this->load->library('upload', $config); 
	        $this->upload->initialize($config); 
	        if(!$this->upload->do_upload('insert_scan_ttd'))  
	        {  
	            echo $this->upload->display_errors(); 
	        }  
	        else  
	        {
	        	$data_upload = $this->upload->data();
	        	$data['scan_ttd']=$data_upload["file_name"];	        	
	        }
		}

		$data['nm_dokter']=$this->input->post('nm_dokter');
		$data['nipeg']=$this->input->post('nipeg');
		$data['klp_pelaksana']=$this->input->post('klp_pelaksana');
		$data['ket']=$this->input->post('ket');

		$result = $this->mmdokter->insert_dokter($data);
		
		$dokter=$this->mmdokter->get_dokter($data['nm_dokter'])->result();
		foreach($dokter as $row)
			{
				// echo $row->umurday;
				$data1['id_dokter']=$row->id_dokter;				
			}
		if($this->input->post('poli')!=''){
			$data1['id_poli']=$this->input->post('poli');
			$data1['id_biaya_periksa']=$this->input->post('biaya');
			$this->mmdokter->insert_dokter_poli($data1);
		}
		
		
		echo json_decode($result);
		//print_r($data);
	}

	public function get_data_edit_dokter(){
		$id_dokter=$this->input->post('id_dokter');
		$datajson=$this->mmdokter->get_data_dokter($id_dokter)->result();
	    echo json_encode($datajson);
	}

	public function edit_dokter(){
			
		if (!empty($_FILES["edit_scan_ttd"]["name"])) {
			$config['upload_path'] = './upload/ttd_dokter/'; 
	        $config['allowed_types'] = 'jpg|jpeg|png|gif';  
	        $this->load->library('upload', $config); 
	        $this->upload->initialize($config); 
	        if(!$this->upload->do_upload('edit_scan_ttd'))  
	        {  
	            echo $this->upload->display_errors(); 
	        }  
	        else  
	        {
	        	$data_upload = $this->upload->data();
	        	$data['scan_ttd']=$data_upload["file_name"];	        	
	        }
		}
		$id_dokter=$this->input->post('edit_id_dokter_hidden');
		$data['nm_dokter']=$this->input->post('edit_nm_dokter');
		$data['nipeg']=$this->input->post('edit_nipeg');
		$data['kode_dpjp_bpjs']=$this->input->post('kode_dpjp_bpjs');
		$data['klp_pelaksana']=$this->input->post('edit_klp_pelaksana');
		$data['ket']=$this->input->post('edit_ket');
		
		$result = $this->mmdokter->edit_dokter($id_dokter, $data);

		$data1['id_dokter']=$id_dokter;							
		
		if($this->input->post('edit_poli')!=''){
			$data1['id_poli']=$this->input->post('edit_poli');
			$data1['id_biaya_periksa']=$this->input->post('edit_biaya');
			$this->mmdokter->delete_dokter_poli($this->input->post('old_poli'),$data1['id_dokter']);
			$this->mmdokter->insert_dokter_poli($data1);
		}else
			$this->mmdokter->delete_dokter_poli($this->input->post('old_poli'),$data1['id_dokter']);

		
		
		echo json_encode($result);
		//print_r($data);
	}

	public function delete_dokter($iddokter=''){
		$data['deleted']='1';
		$datajson=$this->mmdokter->delete_dokter($iddokter,$data);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Dokter dengan ID "'.$iddokter.'" berhasil dihapus
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
	    redirect('master/mcdokter','refresh');
	}

}
