<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mctindakan extends Secure_area {
	public function __construct(){
		parent::__construct();

		$this->load->model('master/mmtindakan','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Tindakan';

		$data['tindakan']=$this->mmtindakan->get_all_tindakan()->result();
		$data['kel_tindakan']=$this->mmtindakan->get_all_kel_tindakan()->result();
		$this->load->view('master/mvtindakan',$data);
		//print_r($data);
	}

	public function insert_tindakan(){
		//insert to jenis_tindakan
		$jt['idtindakan']=$this->input->post('idtindakan');
		$jt['nmtindakan']=$this->input->post('nmtindakan');
		$jt['idpok1']=substr($jt['idtindakan'], 0,1);
		$jt['idpok2']=substr($jt['idtindakan'], 0,2);
		$jt['idkel_tind']=$this->input->post('idkel_tind');
		if($this->input->post('paket')=="on"){
			$jt['paket']="1";
		}else{
			$jt['paket']="0";
		}
		//$jt['xupdate']=$this->input->post('xupdate');

		$id=$this->mmtindakan->insert_jenis_tindakan($jt);		

		//insert to tarif_tindakan
		$data['id_tindakan']=$this->input->post('idtindakan');
		if($jt['idpok2']=="1A"){
			$data['idrg']=substr($jt['idtindakan'], 2,4);
		}
		  //Kelas VIP A
		if($this->input->post('kelas_vipa')!=0){
			$data['total_tarif']=$this->input->post('kelas_vipa');
			if($data['total_tarif']==''){
				$data['total_tarif']=='0';
			}
			$data['kelas']="VVIP";
			$data['tarif_alkes']=$this->input->post('alkes_kelas_vipa');
			if($data['tarif_alkes']==''){
				$data['tarif_alkes']=='0';
			}
			$this->mmtindakan->insert_tarif_tindakan($data);
			$data['tarif_alkes']="";
		}
		  //Kelas VIP B
		if($this->input->post('kelas_vipb')!=0){
			$data['total_tarif']=$this->input->post('kelas_vipb');
			if($data['total_tarif']==''){
				$data['total_tarif']=='0';
			}
			$data['kelas']="VIP";
			$data['tarif_alkes']=$this->input->post('alkes_kelas_vipb');
			if($data['tarif_alkes']==''){
				$data['tarif_alkes']=='0';
			}
			$this->mmtindakan->insert_tarif_tindakan($data);
			$data['tarif_alkes']="";
		}

		//KELAS uTAMA
		  if($this->input->post('kelas_3a')!=0){
			$data['total_tarif']=$this->input->post('kelas_3a');
			if($data['total_tarif']==''){
				$data['total_tarif']=='0';
			}
			$data['kelas']="UTAMA";
			$data['tarif_alkes']=$this->input->post('alkes_kelas_3a');
			if($data['tarif_alkes']==''){
				$data['tarif_alkes']=='0';
			}
			$this->mmtindakan->insert_tarif_tindakan($data);
			$data['tarif_alkes']="";
		}

		  //Kelas I
		if($this->input->post('kelas_1')!=0){
			$data['total_tarif']=$this->input->post('kelas_1');
			if($data['total_tarif']==''){
				$data['total_tarif']=='0';
			}
			$data['kelas']="I";
			$data['tarif_alkes']=$this->input->post('alkes_kelas_1');
			if($data['tarif_alkes']==''){
				$data['tarif_alkes']=='0';
			}
			$this->mmtindakan->insert_tarif_tindakan($data);
			$data['tarif_alkes']="";
		}
		  //Kelas II
		if($this->input->post('kelas_2')!=0){
			$data['total_tarif']=$this->input->post('kelas_2');
			if($data['total_tarif']==''){
				$data['total_tarif']=='0';
			}
			$data['kelas']="II";
			$data['tarif_alkes']=$this->input->post('alkes_kelas_2');
			if($data['tarif_alkes']==''){
				$data['tarif_alkes']=='0';
			}
			$this->mmtindakan->insert_tarif_tindakan($data);
			$data['tarif_alkes']="";
		}
		  //Kelas III
		if($this->input->post('kelas_3')!=0){
			$data['total_tarif']=$this->input->post('kelas_3');
			if($data['total_tarif']==''){
				$data['total_tarif']=='0';
			}
			$data['kelas']="III";
			$data['tarif_alkes']=$this->input->post('alkes_kelas_3');
			if($data['tarif_alkes']==''){
				$data['tarif_alkes']=='0';
			}
			$id=$this->mmtindakan->insert_tarif_tindakan($data);
			$data['tarif_alkes']="";			
		}
		//Kelas III A
		// if($this->input->post('kelas_3a')!=0){
		// 	$data['total_tarif']=$this->input->post('kelas_3a');
		// 	$data['kelas']="III A";
		// 	$data['tarif_alkes']=$this->input->post('alkes_kelas_3a');
		// 	$this->mmtindakan->insert_tarif_tindakan($data);
		// 	$data['tarif_alkes']="";
		// }
		//   //Kelas III B
		// if($this->input->post('kelas_3b')!=0){
		// 	$data['total_tarif']=$this->input->post('kelas_3b');
		// 	$data['kelas']="III B";
		// 	$data['tarif_alkes']=$this->input->post('alkes_kelas_3b');
		// 	$this->mmtindakan->insert_tarif_tindakan($data);
		// 	$data['tarif_alkes']="";
		// }

		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Tindakan dengan ID "'.$jt['idtindakan'].'" berhasil ditambahkan
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
		redirect('master/mctindakan','refresh');
		//print_r($jt);
	}

	public function get_data_edit_tindakan(){
		$idtindakan=$this->input->post('idtindakan');
		$datajson=$this->mmtindakan->get_data_tindakan($idtindakan)->result();
	    echo json_encode($datajson);
	}

	public function delete_tindakan($idtindakan=''){
		$datajson=$this->mmtindakan->delete_tindakan($idtindakan);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Tindakan dengan ID "'.$idtindakan.'" berhasil dihapus
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
	    redirect('master/mctindakan','refresh');
	}

	public function edit_tindakan(){
		//edit to jenis_tindakan
		$idtindakan=$this->input->post('edit_idtindakan_hide');
		$jt['nmtindakan']=$this->input->post('edit_nmtindakan');
		$jt['idkel_tind']=$this->input->post('edit_idkel_tind');
		if($this->input->post('edit_paket')=="on"){
			$jt['paket']="1";
		}else{
			$jt['paket']="0";
		}

		$this->mmtindakan->edit_jenis_tindakan($idtindakan, $jt);

		//edit to tarif_tindakan
		$data['id_tindakan']=$this->input->post('edit_idtindakan_hide');
		if(substr($idtindakan, 0,2)=="1A"){
			$data['idrg']=substr($idtindakan, 2,4);
		}
		  //Kelas VIP A
		if($this->input->post('kelas_vipa')!=0 || $this->input->post('edit_kelas_vipa')!=""){
			$data['kelas']="VVIP";
			$data['total_tarif']=$this->input->post('edit_kelas_vipa');
			$data['tarif_alkes']=$this->input->post('edit_alkes_kelas_vipa');

			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'VVIP')->num_rows();
			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'VVIP')->row()->id_tarif_tindakan;
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
				//print_r($data);
			} else {
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
				//print_r($data);
			}
		}
		print_r($data);
		  //Kelas VIP B
		if($this->input->post('kelas_vipb')!=0 || $this->input->post('edit_kelas_vipb')!=""){
			$data['kelas']="VIP";
			$data['total_tarif']=$this->input->post('edit_kelas_vipb');
			$data['tarif_alkes']=$this->input->post('edit_alkes_kelas_vipb');

			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'VIP')->num_rows();
			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'VIP')->row()->id_tarif_tindakan;
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
			} else {
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
			}
		}
		print_r($data);

		  //Kelas UTAMA
		if($this->input->post('edit_kelas_3a')!=0 || $this->input->post('edit_kelas_3a')!=""){
			$data['total_tarif']=$this->input->post('edit_kelas_3a');
			$data['kelas']="UTAMA";
			$data['tarif_alkes']=$this->input->post('edit_alkes_kelas_3a');

			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'UTAMA')->num_rows();
			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'UTAMA')->row()->id_tarif_tindakan;
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
			} else {
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
			}
		}
		print_r($data);

		  //Kelas I
		if($this->input->post('edit_kelas_1')!=0 || $this->input->post('edit_kelas_1')!=""){
			$data['total_tarif']=$this->input->post('edit_kelas_1');
			$data['kelas']="I";
			$data['tarif_alkes']=$this->input->post('edit_alkes_kelas_1');



			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'I')->num_rows();
			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'I')->row()->id_tarif_tindakan;
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
			} else {
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
			}
		}
		print_r($data);
		  //Kelas II
		if($this->input->post('edit_kelas_2')!=0 || $this->input->post('edit_kelas_2')!=""){
			$data['total_tarif']=$this->input->post('edit_kelas_2');
			$data['kelas']="II";
			$data['tarif_alkes']=$this->input->post('edit_alkes_kelas_2');

			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'II')->num_rows();
			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'II')->row()->id_tarif_tindakan;
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
			} else {
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
			}
		}
		print_r($data);
		  //Kelas III
		if($this->input->post('edit_kelas_3')!=0 || $this->input->post('edit_kelas_3')!=""){
			$data['total_tarif']=$this->input->post('edit_kelas_3');
			$data['kelas']="III";
			$data['tarif_alkes']=$this->input->post('edit_alkes_kelas_3');

			$return_data=$this->mmtindakan->return_tarif($idtindakan, 'III')->num_rows();
			if($return_data!=0){
				$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'III')->row()->id_tarif_tindakan;
				$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
			} else {
				if($data['tarif_alkes']==''){
					$data['tarif_alkes']=='0';
				}
				$this->mmtindakan->insert_tarif_tindakan($data);
			}

		}
		//   //Kelas III A
		// if($this->input->post('edit_kelas_3a')!=0 || $this->input->post('edit_kelas_3a')!=""){
		// 	$data['total_tarif']=$this->input->post('edit_kelas_3a');
		// 	$data['kelas']="III A";
		// 	$data['tarif_alkes']=$this->input->post('edit_alkes_kelas_3a');
		//
		// 	$return_data=$this->mmtindakan->return_tarif($idtindakan, 'III A')->num_rows();
		// 	if($return_data!=0){
		// 		$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'III A')->row()->id_tarif_tindakan;
		// 		$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
		// 	} else {
		// 		$this->mmtindakan->insert_tarif_tindakan($data);
		// 	}
		//
		// 	$data['tarif_alkes']="";
		// }
		  //Kelas III B
		// if($this->input->post('edit_kelas_3b')!=0 || $this->input->post('edit_kelas_3b')!=""){
		// 	$data['total_tarif']=$this->input->post('edit_kelas_3b');
		// 	$data['kelas']="III B";
		// 	$data['tarif_alkes']=$this->input->post('edit_alkes_kelas_3b');
		//
		// 	$return_data=$this->mmtindakan->return_tarif($idtindakan, 'III B')->num_rows();
		// 	if($return_data!=0){
		// 		$id_tarif_tindakan=$this->mmtindakan->return_tarif($idtindakan, 'III B')->row()->id_tarif_tindakan;
		// 		$this->mmtindakan->edit_tarif_tindakan($id_tarif_tindakan, $data);
		// 	} else {
		// 		$this->mmtindakan->insert_tarif_tindakan($data);
		// 	}
		//
		// 	$data['tarif_alkes']="";
		// }
		echo json_encode(array("status" => TRUE));
		// redirect('master/mctindakan');
		//print_r($data);
	}

	//EXPORT
	public function export_excel(){
		$data['title'] = 'Tarif Tindakan';

		////EXCEL
		$this->load->library('Excel');

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		$namars=$this->config->item('namars');
		// Set document properties
		$objPHPExcel->getProperties()->setCreator($namars)
		        ->setLastModifiedBy($namars)
		        ->setTitle("Tarif Tindakan ".$namars)
		        ->setSubject("Tarif Tindakan ".$namars." Document")
		        ->setDescription("Tarif Tindakan ".$namars." for Office 2007 XLSX, generated by HMIS.")
		        ->setKeywords($namars)
		        ->setCategory("Tarif Tindakan");

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		//$objPHPExcel = $objReader->load("project.xlsx");
		$tindakan=$this->mmtindakan->get_all_tindakan()->result();

		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);

		$objPHPExcel=$objReader->load(APPPATH.'third_party/10_diagnosa.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Add some data
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
		$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'No');
		$objPHPExcel->getActiveSheet()->SetCellValue('B3', 'ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Nama');
		$objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Kelas VIP A');
		$objPHPExcel->getActiveSheet()->SetCellValue('E3', 'Alkes');
		$objPHPExcel->getActiveSheet()->SetCellValue('F3', 'Kelas VIP B');
		$objPHPExcel->getActiveSheet()->SetCellValue('G3', 'Alkes');
		$objPHPExcel->getActiveSheet()->SetCellValue('H3', 'Kelas I');
		$objPHPExcel->getActiveSheet()->SetCellValue('I3', 'Alkes');
		$objPHPExcel->getActiveSheet()->SetCellValue('J3', 'Kelas II');
		$objPHPExcel->getActiveSheet()->SetCellValue('K3', 'Alkes');
		$objPHPExcel->getActiveSheet()->SetCellValue('L3', 'Kelas III');
		$objPHPExcel->getActiveSheet()->SetCellValue('M3', 'Alkes');
		$objPHPExcel->getActiveSheet()->SetCellValue('N3', 'Kelas III A');
		$objPHPExcel->getActiveSheet()->SetCellValue('O3', 'Alkes');
		$objPHPExcel->getActiveSheet()->SetCellValue('P3', 'Kelas III B');
		$objPHPExcel->getActiveSheet()->SetCellValue('Q3', 'Alkes');
		$rowCount=4;
		$i=1;
		foreach($tindakan as $row){
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->idtindakan);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->nmtindakan);

			$tindakanbyid=$this->mmtindakan->get_tindakan_byid($row->idtindakan)->result();
			foreach($tindakanbyid as $row2){
				if($row2->kelas=='VIP A'){
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->total_tarif);
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->tarif_alkes);
				} else if($row2->kelas=='VIP B'){
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total_tarif);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row2->tarif_alkes);
				} else if($row2->kelas=='I'){
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row2->total_tarif);
					$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row2->tarif_alkes);
				} else if($row2->kelas=='II'){
					$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row2->total_tarif);
					$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row2->tarif_alkes);
				} else if($row2->kelas=='III'){
					$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row2->total_tarif);
					$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row2->tarif_alkes);
				} else if($row2->kelas=='III A'){
					$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row2->total_tarif);
					$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row2->tarif_alkes);
				} else if($row2->kelas=='III B'){
					$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $row2->total_tarif);
					$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row2->tarif_alkes);
				}
			}

		 	$i++;
		 	$rowCount++;
		}
		header('Content-Disposition: attachment;filename="Tarif Tindakan.xlsx"');

		// Rename worksheet (worksheet, not filename)
		$objPHPExcel->getActiveSheet()->setTitle($namars);



		// Redirect output to a client’s web browser (Excel2007)
		//clean the output buffer
		ob_end_clean();

		//this is the header given from PHPExcel examples.
		//but the output seems somewhat corrupted in some cases.
		//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		//so, we use this header instead.
		header('Content-type: application/vnd.ms-excel');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
	}
}

