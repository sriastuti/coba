<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class Klaim extends Secure_area {
	public $xuser;
	public function __construct() {
			parent::__construct();
			$this->load->model('inacbg/M_pasien','',TRUE);
			$this->load->model('inacbg/M_inacbg','',TRUE);				
			$this->load->library('inacbg');  	 
			$this->xuser = $this->load->get_var("user_info"); 	
	}

	// public function service_inacbg()
 //    {
 //    	return $this->M_pasien->service_inacbg()->row();
 //    }

  //   public function show_pasien($no_register='')
  //   {
  //   	$data['title'] = 'List Klaim Pasien';
  //   	$data['no_register'] = $no_register;
  //   	$data['data_pasien'] = $this->M_pasien->show_pelayanan_irj($no_register);
		// $this->load->view('ina-cbg/list_klaim',$data);
  //   }

    public function show_klaim(){
		$data_klaim=$this->M_inacbg->get_all_pelayanan();
        $data = array();
        $no = $_POST['start'];
        foreach ($data_klaim as $klaim) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $klaim->no_register;            
            if ($klaim->tgl_kunjungan == NULL || $klaim->tgl_kunjungan == '0000-00-00') {
            	$row[] = '';
            } else $row[] = date_indo(date('Y-m-d',strtotime($klaim->tgl_kunjungan))); 
            if ($klaim->tgl_pulang == NULL || $klaim->tgl_pulang == '0000-00-00') {
            	$row[] = '';
            } else $row[] = date_indo(date('Y-m-d',strtotime($klaim->tgl_pulang)));           
            $row[] = $klaim->no_sep; 
            if (isset($klaim->jaminan)) {
            	$row[] = '<center>'.$klaim->jaminan.'<center>';  
            } else $row[] = '<center>-</center>'; 
            switch (substr($klaim->no_register, 0,2)) {
            	case 'RJ':
            		$row[] = '<center>RJ<center>';  
            		break;
            	case 'RI':
            		$row[] = '<center>RI<center>';  
            		break;
            	default:
            		$row[] = '<center>-<center>'; 
            		break;
            }
            if (isset($klaim->cbg_code)) {
            	$row[] = '<center>'.$klaim->cbg_code.'<center>';  
            } else $row[] = '<center>-</center>'; 
            if (isset($klaim->status_kirim)) {
            	if ($klaim->status_kirim == 1) {
            		$row[] = '<center>Terkirim<center>';  
            	} else $row[] = '<center>Belum Terkirim<center>';     	
            } else $row[] = '<center>-</center>';                                        	
            $data[] = $row;
        }
 
        $output = array(
	        "draw" => $_POST['draw'],
	        "recordsTotal" => $this->M_inacbg->count_all_pelayanan(),
	        "recordsFiltered" => $this->M_inacbg->filtered_all_pelayanan(),
	        "data" => $data
        );
        echo json_encode($output);
	}
	
	public function get_claim_data($nomor_sep='')
    {
		$data = array(
			'metadata'=>array(
				'method' => 'get_claim_data'
			),		   			
			'data'=>array(	
			 	'nomor_sep' => $nomor_sep		 			   			
			)
		);
	 	$data_klaim=json_encode($data);
	 	$response = $this->inacbg->web_service($data_klaim);		
		echo $response;	    		           
    }	

	public function delete_claim()
    {
		$data = array(
			'metadata'=>array(
			 	'method' => 'delete_claim'
			),		   			
			'data'=>array(	
			 	'nomor_sep' => $this->input->post('nomor_sep'),
			 	'coder_nik' => $this->xuser->coder_nik
			)
		);
	 	$data_klaim=json_encode($data);
		$response = $this->inacbg->web_service($data_klaim);		
		$response_array = json_decode($response);
		if ($response_array->metadata->code == '200') {
			$this->M_inacbg->delete_klaim($this->input->post('nomor_sep'));
		}

		echo $response;	  
		   		           
    }	    

	public function cetak_klaim($nomor_sep='')
    {    	
		$data = array(
			'metadata'=>array(
			 	'method' => 'claim_print'
			),		   			
			'data'=>array(	
			 	'nomor_sep' => $nomor_sep		 			   			
			)
		);
	 	$data_klaim=json_encode($data);
		$response = $this->inacbg->web_service($data_klaim);
		$response_array = json_decode($response);

		if ($response_array->metadata->code == '200') {
		 	$base64 = $response_array->data;
		 	$result = base64_decode($base64);
			$file_name = 'KLAIM_'.$nomor_sep.'.pdf';
			header('Content-Type: application/pdf');
			header('Content-disposition: inline; filename="' . $file_name . '"');
			header('Cache-Control: public, must-revalidate, max-age=0');
			header('Pragma: public');
			header('Expires: 0');	
			echo $result;
		} else {
			echo $response_array->metadata->message;
		}		    		           
    }

    public function kirim_online() {        
        $data['title'] = 'Kirim Klaim Online';
        $this->load->view('inacbg/kirim_online',$data);        
    }

    public function send_claim()
    {
    	$tanggal_cari = $this->input->post('tanggal_cari');
        $from_date = substr($tanggal_cari,0,10);
        $to_date = substr($tanggal_cari,13,23);          
		$data = array(
			'metadata'=>array(
			 	'method' => 'send_claim'
			),		   			
			'data'=>array(	
			 	'start_dt' => date('Y-m-d',strtotime($from_date)),
			 	'stop_dt' => date('Y-m-d',strtotime($to_date)),
			 	'jenis_rawat' => $this->input->post('jenis_rawat'),
           		'date_type' => $this->input->post('date_type') 			   			
			)
		);
	 	$data_klaim=json_encode($data);	 	
		$result = $this->inacbg->web_service($data_klaim);
		echo $result;

		// $test = array(
		// 	'metadata' =>array(
		// 	 	'code' => '200',
		// 	 	'message' => 'OK'
		// 	),		   			
		// 	'response' => array(	
		// 		'data' => array(	
		// 			array(	
		// 			 	'nomor_sep' => "0901R0040818V007495",
		// 			 	'tgl_pulang' => "2018-08-21 10:43:14",
		// 			 	'kemkes_dc_status' => "sent",
		//            		'bpjs_dc_status' => "unsent"
		// 			),
		// 			array(	
		// 			 	'nomor_sep' => "0901R0040818V117494",
		// 			 	'tgl_pulang' => "2018-08-21 10:43:14",
		// 			 	'kemkes_dc_status' => "sent",
		//            		'bpjs_dc_status' => "unsent"
		// 			),
		// 			array(	
		// 			 	'nomor_sep' => "0901R0040818V007495",
		// 			 	'tgl_pulang' => "2018-08-21 10:43:14",
		// 			 	'kemkes_dc_status' => "unsent",
		//            		'bpjs_dc_status' => "unsent"
		// 			)			   			
		// 		)	   			
		// 	)
		// );
		// $result = json_encode($test);
		// echo $result;
		// $response = json_decode($test_json);
		// $data = json_encode($response->response->data);
		// $data_decode = json_decode($data);
		// $result = array_count_values(array_column($response->response->data,'kemkes_dc_status'));
		// echo $test_json;die();
		// if ($response->metadata->code == '200') {
		// 	$total = count((array)$result->response->data->kemkes_dc_status['2009-08-21 11:05']);
		// 	echo $total;
		// } else echo json_encode($test);
		
	}

	public function laporan() {        
        $data['title'] = 'Laporan';
        $this->load->view('ina-cbg/laporan',$data);        
    }

	// Untuk mengirim klaim individual ke data center

	public function send_claim_individual()
    {
    	$no_sep = $this->input->post('no_sep');	
		$data = array(
			'metadata'=>array(
			 	'method' => 'send_claim_individual'
			),		   			
			'data'=>array(	
			 	'nomor_sep' => $no_sep 			   			
			)
		);		

	 	$data_klaim=json_encode($data);
		$response = $this->inacbg->web_service($data_klaim);
		$result = json_decode($response);
		if ($result->metadata->code == '200' && $result->response->data[0]->kemkes_dc_status == 'sent') {
			$data_update = array('status_kirim' => '1');
			$this->M_inacbg->update_klaim($data_update,$no_sep);
		}
		echo $response;
	}	

	public function search_diagnosis()
	{
		$data = array(
			'metadata'=>array(
			 	'method' => 'search_diagnosis'
			),		   			
			'data'=>array(	
			 	'keyword' => "B" 			   			
			)
		);

	 	$data_klaim=json_encode($data);
		$response = $this->inacbg->web_service($data_klaim);
		$decode = json_decode($response);
		$diagnosa=json_encode($decode->response->data);
		// $result = $this->M_irj->save_diagnosis($diagnosa);
		$array=[];		
		foreach ($decode->response->data as $diag) {			
			array_push($array,[$diag[1],$diag[0],NULL, NULL, NULL, '', NULL, NULL, NULL]);
		}
		$result = json_encode($array);
		echo $response;
	}

	public function claim_final()
    {
    	$nomor_sep = $this->input->post('nomor_sep');	
		$data = array(
			'metadata'=>array(
			 	'method' => 'claim_final'
			),		   			
			'data'=>array(	
			 	'nomor_sep' => $this->input->post('nomor_sep'),
			 	'coder_nik' => $coder_nik		 			   			
			)
		);

	 	$data_klaim=json_encode($data);
		$response = $this->inacbg->web_service($data_klaim);
		$response_array = json_decode($response);
		if ($response_array->metadata->code == '200') {
		 	$data_update = array('status_klaim' => 3);
			$this->M_inacbg->update_klaim($data_update,$nomor_sep);
		}

		echo $response;
	}		

	// Untuk menarik data klaim dari E-Klaim

	public function pull_claim()
    {
		$data = array(
			'metadata'=>array(
			 	'method' => 'pull_claim'
			),		   			
			'data'=>array(	
			 	'start_dt' => $this->input->post('start_dt'),
			 	'stop_dt' => $this->input->post('stop_dt'),
			 	'jenis_rawat' => $this->input->post('jenis_rawat')		 			   			
			)
		);

	 	$data_klaim=json_encode($data);
		$response = $this->inacbg->web_service($data_klaim);
		$response_array = json_decode($response);

		if ($response_array->metadata->code == '200') {
		 	
		}
	}	

	// Untuk mengisi/update data klaim	
	public function set_claim_data()
    {
		$set_claim_data = array(
			'metadata'=>array(
				'method' => 'set_claim_data',
				'nomor_sep' => $this->input->post('no_sep'),
			),		   			
			'data'=>array(
				'nomor_sep' => $this->input->post('no_sep'),
				'nomor_kartu' => $this->input->post('no_kartu'),
				'tgl_masuk' => $this->input->post('tgl_masuk'),
				'tgl_pulang' => $this->input->post('tgl_pulang'),
				'jenis_rawat' => $this->input->post('jenis_rawat'),
				'kelas_rawat' => $this->input->post('kelas_rawat'),
				'adl_sub_acute' => $this->input->post('adl_sub_acute'),
				'adl_chronic' => $this->input->post('adl_chronic'),
				'icu_indikator' => $this->input->post('icu_indikator'),
				'icu_los' => $this->input->post('icu_los'),
				'ventilator_hour' => $this->input->post('ventilator_hour'),
				'upgrade_class_ind' => $this->input->post('upgrade_class_ind'),
				'upgrade_class_class' => $this->input->post('upgrade_class_class'),
				'upgrade_class_los' => $this->input->post('upgrade_class_los'),
				'add_payment_pct' => $this->input->post('add_payment_pct'),
				'birth_weight' => $this->input->post('birth_weight'),
				'discharge_status' => $this->input->post('discharge_status'),
				'diagnosa' => $this->input->post('diagnosa'),
				'procedure' => $this->input->post('procedure'),
				'tarif_rs' => array(
					'prosedur_non_bedah' => $this->input->post('prosedur_non_bedah'), 
					'prosedur_bedah' => $this->input->post('prosedur_bedah'), 
					'konsultasi' => $this->input->post('konsultasi'), 
					'tenaga_ahli' => $this->input->post('tenaga_ahli'), 
					'keperawatan' => $this->input->post('keperawatan'), 
					'penunjang' => $this->input->post('penunjang'), 
					'radiologi' => $this->input->post('radiologi'), 
					'laboratorium' => $this->input->post('laboratorium'), 
					'pelayanan_darah' => $this->input->post('pelayanan_darah'), 
					'rehabilitasi' => $this->input->post('rehabilitasi'), 
					'kamar' => $this->input->post('kamar'), 
					'rawat_intensif' => $this->input->post('rawat_intensif'), 
					'obat' => $this->input->post('obat'), 
					'alkes' => $this->input->post('alkes'), 
					'bmhp' => $this->input->post('bmhp'), 
					'sewa_alat' => $this->input->post('sewa_alat')
				),
				'tarif_poli_eks' => $this->input->post('tarif_poli_eks'),
				'nama_dokter' => $this->input->post('nama_dokter'),	
				'kode_tarif' => $this->input->post('kode_tarif'),		
				'payor_id' => $this->input->post('payor_id'),		
				'payor_cd' => $this->input->post('payor_cd'),		
				'cob_cd' => $this->input->post('cob_cd'),		
				'coder_nik' => $coder_nik			 			   			
			)
		);    	
		$data_setklaim=json_encode($set_claim_data);
		$response = $this->inacbg->web_service($data_setklaim);

		echo $response;
    } 

    // Membuat klaim baru (dan registrasi pasien jika belum ada)

 	public function new_claim($no_register='')
    {
    	
    	$data_pasien = $this->M_pasien->show_pelayanan_irj($no_register);     	

    	$new_claim_data = array(
			'metadata'=>array(
				'method' => 'new_claim'
			),		   			
			'data'=>array(
				'nomor_kartu' => $data_pasien->no_kartu,
				'nomor_sep' => $data_pasien->no_sep,
				'nomor_rm' => $data_pasien->no_cm,
				'nama_pasien' => $data_pasien->nama,
				'tgl_lahir' => $data_pasien->tgl_lahir,
				'gender' => $data_pasien->gender
		    )
		);	

	 	$data_klaim=json_encode($new_claim_data);	 	
		$response = $this->inacbg->web_service($data_klaim);
		$response_array = json_decode($response);			

		if ($response_array->metadata->code == '200') { 
			$data_insert = array(
		        		'no_register' => $no_register,
					 	'no_sep' => $data_pasien->no_sep,		
					 	'coder_nik' => $this->xuser->coder_nik,
					 	'status_klaim' => 1	
		    );			
			$this->M_inacbg->insert_inacbg($data_insert);						     
		}
		return $response;	
    }  	

    public function set_claim()
    {
    	$check_klaim = $this->M_inacbg->check_klaim($this->input->post('no_sep'));
    	// print_r($check_klaim);die();
    	if (count($check_klaim)) {

			$status = $this->M_inacbg->claim_status($this->input->post('no_register'));
			switch ($status->status_klaim) {
				case ($status->status_klaim == 1 || $status->status_klaim == 2):
					$set_claim_data = array(
						'metadata'=>array(
							'method' => 'set_claim_data',
							'nomor_sep' => $this->input->post('no_sep'),
						),		   			
						'data'=>array(
							'nomor_sep' => $this->input->post('no_sep'),
							'nomor_kartu' => $this->input->post('no_kartu'),
							'tgl_masuk' => $this->input->post('tgl_masuk'),
							'tgl_pulang' => $this->input->post('tgl_pulang'),
							'jenis_rawat' => $this->input->post('jenis_rawat'),
							'kelas_rawat' => $this->input->post('kelas_rawat'),
							'adl_sub_acute' => $this->input->post('adl_sub_acute'),
							'adl_chronic' => $this->input->post('adl_chronic'),
							'icu_indikator' => $this->input->post('icu_indikator'),
							'icu_los' => $this->input->post('icu_los'),
							'ventilator_hour' => $this->input->post('ventilator_hour'),
							'upgrade_class_ind' => $this->input->post('upgrade_class_ind'),
							'upgrade_class_class' => $this->input->post('upgrade_class_class'),
							'upgrade_class_los' => $this->input->post('upgrade_class_los'),
							'add_payment_pct' => $this->input->post('add_payment_pct'),
							'birth_weight' => $this->input->post('birth_weight'),
							'discharge_status' => $this->input->post('discharge_status'),
							'diagnosa' => $this->input->post('diagnosa'),
							'procedure' => $this->input->post('procedure'),
							'tarif_rs' => array(
								'prosedur_non_bedah' => $this->input->post('prosedur_non_bedah'), 
								'prosedur_bedah' => $this->input->post('prosedur_bedah'), 
								'konsultasi' => $this->input->post('konsultasi'), 
								'tenaga_ahli' => $this->input->post('tenaga_ahli'), 
								'keperawatan' => $this->input->post('keperawatan'), 
								'penunjang' => $this->input->post('penunjang'), 
								'radiologi' => $this->input->post('radiologi'), 
								'laboratorium' => $this->input->post('laboratorium'), 
								'pelayanan_darah' => $this->input->post('pelayanan_darah'), 
								'rehabilitasi' => $this->input->post('rehabilitasi'), 
								'kamar' => $this->input->post('kamar'), 
								'rawat_intensif' => $this->input->post('rawat_intensif'), 
								'obat' => $this->input->post('obat'), 
								'alkes' => $this->input->post('alkes'), 
								'bmhp' => $this->input->post('bmhp'), 
								'sewa_alat' => $this->input->post('sewa_alat')
							),
							'tarif_poli_eks' => $this->input->post('tarif_poli_eks'),
							'nama_dokter' => $this->input->post('nama_dokter'),	
							'kode_tarif' => $this->input->post('kode_tarif'),		
							'payor_id' => $this->input->post('payor_id'),		
							'payor_cd' => $this->input->post('payor_cd'),		
							'cob_cd' => $this->input->post('cob_cd'),		
							'coder_nik' => $this->xuser->coder_nik			 			   			
						)
					);
					// set claim correct
					
					$data_setklaim=json_encode($set_claim_data);
					$result_setklaim = $this->inacbg->web_service($data_setklaim);

					$response_setklaim = json_decode($result_setklaim);
					
					if ($response_setklaim->metadata->code && $response_setklaim->metadata->code == '200') {
						$data_update = array(					 						
					 		'adl_sub_acute' => $this->input->post('adl_sub_acute'),
							'adl_chronic' => $this->input->post('adl_chronic'),
							'icu_indikator' => $this->input->post('icu_indikator'),
							'icu_los' => $this->input->post('icu_los'),
							'ventilator_hour' => $this->input->post('ventilator_hour'),
							'upgrade_class_ind' => $this->input->post('upgrade_class_ind'),
							'upgrade_class_class' => $this->input->post('upgrade_class_class'),
							'upgrade_class_los' => $this->input->post('upgrade_class_los'),
							'add_payment_pct' => $this->input->post('add_payment_pct'),
							'birth_weight' => $this->input->post('birth_weight'),
							'discharge_status' => $this->input->post('discharge_status'),
							'diagnosa' => $this->input->post('diagnosa'),
							'procedure' => $this->input->post('procedure'),
							'tarif_rs' => $this->input->post('tarif_rs'),
							'tarif_poli_eks' => $this->input->post('tarif_poli_eks'),
							// 'nama_dokter' => $this->input->post('nama_dokter'),	
							'kode_tarif' => $this->input->post('kode_tarif'),		
							'payor_id' => $this->input->post('payor_id'),		
							'payor_cd' => $this->input->post('payor_cd'),		
							'cob_cd' => $this->input->post('cob_cd'),		
							'coder_nik' => $this->xuser->coder_nik,
							'status_klaim' => 0
						);
						$this->M_inacbg->update_klaim($data_update,$this->input->post('no_sep'));							
						$result_grouper = $this->grouper_stage1($this->input->post('no_sep'));						
						// echo $result_grouper;die();
						$response_grouper = json_decode($result_grouper);

						if ($response_grouper->metadata->code == '200') {
							$data_update = array('status_klaim' => 2,'cbg_code' => $response_grouper->response->cbg->code,'grouper_at' => date('Y-m-d H:i'));
							$this->M_inacbg->update_klaim($data_update,$this->input->post('no_sep'));
							if (isset($response_grouper->response->cbg->tariff)) {
								$update_tarif = array('tarif_grouper1' => $response_grouper->response->cbg->tariff);
								$this->M_inacbg->update_klaim($update_tarif,$this->input->post('no_sep')); 
							}
							

							if (isset($response_grouper->special_cmg_option)) {
								foreach ($response_grouper->special_cmg_option as $cmg_option) {
							   		$push_cmg[] = $cmg_option->code;
								}
								$special_cmg = implode('#', $push_cmg);		
								$result_grouper2 = $this->grouper_stage2($this->input->post('no_sep'),$special_cmg);
								$response_grouper2 = json_decode($result_grouper2);
								if ($response_grouper2->metadata->code == '200') {
									$kelas_bpjs = $this->M_inacbg->jatah_kelas($nomor_sep);
									$jatah_kelas = 'kelas_' . $kelas_bpjs;
									foreach ($response_grouper2->tarif_alt as $grouper2) {
										if ($grouper2->kelas == $jatah_kelas) {
											$tarif = $grouper2->tarif_inacbg;
										}
									}
						            $data_update = array('tarif_grouper2' => $tarif,'cbg_code' => $response_grouper->response->cbg->code,'grouper_at' => date('Y-m-d H:i'));
									$this->M_inacbg->update_klaim($data_update,$nomor_sep); 
									$this->finalisasi($this->input->post('no_sep'));
								} else {
									echo $result_grouper2;  
								}								
							} else {							    
							    $this->finalisasi($this->input->post('no_sep'));
							}  // isset cmg_option  

						} else {
							echo $result_grouper; 			
						} 											

					} else {
						echo $result_setklaim;
					}
					break;
				case 3:
				    	$login_data = $this->load->get_var("user_info");  
						$coder_nik = $this->xuser->coder_nik;	
						$data = array(
							'metadata'=>array(
							 	'method' => 'claim_final'
							 ),		   			
							'data'=>array(	
							 	'nomor_sep' => $this->input->post('no_sep'),
							 	'coder_nik' => $this->xuser->coder_nik		 			   			
							)
						);

					 	$data_klaim=json_encode($data);
						$response = $this->inacbg->web_service($data_klaim);
						$response_array = json_decode($response);

						if ($response_array->metadata->code == '200') {
							$data_update = array('status_klaim' => 3);
							$this->M_inacbg->update_klaim($data_update,$this->input->post('no_sep'));
						} 
					    echo $response;					
				    break;							
			}
    	} else {    	
	    	$result_newclaim = $this->new_claim($this->input->post('no_register'));
	    	
	    	$response_newclaim = json_decode($result_newclaim);
			if ($response_newclaim->metadata->code && $response_newclaim->metadata->code == '200') {    	
				   	
				$set_claim_data = array(
					'metadata'=>array(
						'method' => 'set_claim_data',
						'nomor_sep' => $this->input->post('no_sep'),
					),		   			
					'data'=>array(
						'nomor_sep' => $this->input->post('no_sep'),
						'nomor_kartu' => $this->input->post('no_kartu'),
						'tgl_masuk' => $this->input->post('tgl_masuk'),
						'tgl_pulang' => $this->input->post('tgl_pulang'),
						'jenis_rawat' => $this->input->post('jenis_rawat'),
						'kelas_rawat' => $this->input->post('kelas_rawat'),
						'adl_sub_acute' => $this->input->post('adl_sub_acute'),
						'adl_chronic' => $this->input->post('adl_chronic'),
						'icu_indikator' => $this->input->post('icu_indikator'),
						'icu_los' => $this->input->post('icu_los'),
						'ventilator_hour' => $this->input->post('ventilator_hour'),
						'upgrade_class_ind' => $this->input->post('upgrade_class_ind'),
						'upgrade_class_class' => $this->input->post('upgrade_class_class'),
						'upgrade_class_los' => $this->input->post('upgrade_class_los'),
						'add_payment_pct' => $this->input->post('add_payment_pct'),
						'birth_weight' => $this->input->post('birth_weight'),
						'discharge_status' => $this->input->post('discharge_status'),
						'diagnosa' => $this->input->post('diagnosa'),
						'procedure' => $this->input->post('procedure'),
						'tarif_rs' => array(
							'prosedur_non_bedah' => $this->input->post('prosedur_non_bedah'), 
							'prosedur_bedah' => $this->input->post('prosedur_bedah'), 
							'konsultasi' => $this->input->post('konsultasi'), 
							'tenaga_ahli' => $this->input->post('tenaga_ahli'), 
							'keperawatan' => $this->input->post('keperawatan'), 
							'penunjang' => $this->input->post('penunjang'), 
							'radiologi' => $this->input->post('radiologi'), 
							'laboratorium' => $this->input->post('laboratorium'), 
							'pelayanan_darah' => $this->input->post('pelayanan_darah'), 
							'rehabilitasi' => $this->input->post('rehabilitasi'), 
							'kamar' => $this->input->post('kamar'), 
							'rawat_intensif' => $this->input->post('rawat_intensif'), 
							'obat' => $this->input->post('obat'), 
							'alkes' => $this->input->post('alkes'), 
							'bmhp' => $this->input->post('bmhp'), 
							'sewa_alat' => $this->input->post('sewa_alat')
						),
						'tarif_poli_eks' => $this->input->post('tarif_poli_eks'),
						'nama_dokter' => $this->input->post('nama_dokter'),	
						'kode_tarif' => $this->input->post('kode_tarif'),		
						'payor_id' => $this->input->post('payor_id'),		
						'payor_cd' => $this->input->post('payor_cd'),		
						'cob_cd' => $this->input->post('cob_cd'),		
						'coder_nik' => $this->xuser->coder_nik			 			   			
					)
				);

				$data_setklaim=json_encode($set_claim_data);
				$response = $this->inacbg->web_service($data_setklaim);
				$response_setklaim = json_decode($response);

				if ($response_setklaim->metadata->code && $response_setklaim->metadata->code == '200') {	
					$data_update = array(					 						
				 		'adl_sub_acute' => $this->input->post('adl_sub_acute'),
						'adl_chronic' => $this->input->post('adl_chronic'),
						'icu_indikator' => $this->input->post('icu_indikator'),
						'icu_los' => $this->input->post('icu_los'),
						'ventilator_hour' => $this->input->post('ventilator_hour'),
						'upgrade_class_ind' => $this->input->post('upgrade_class_ind'),
						'upgrade_class_class' => $this->input->post('upgrade_class_class'),
						'upgrade_class_los' => $this->input->post('upgrade_class_los'),
						'add_payment_pct' => $this->input->post('add_payment_pct'),
						'birth_weight' => $this->input->post('birth_weight'),
						'discharge_status' => $this->input->post('discharge_status'),
						'diagnosa' => $this->input->post('diagnosa'),
						'procedure' => $this->input->post('procedure'),
						'tarif_rs' => $this->input->post('tarif_rs'),
						'tarif_poli_eks' => $this->input->post('tarif_poli_eks'),							
						'kode_tarif' => $this->input->post('kode_tarif'),		
						'payor_id' => $this->input->post('payor_id'),		
						'payor_cd' => $this->input->post('payor_cd'),		
						'cob_cd' => $this->input->post('cob_cd'),		
						'coder_nik' => $this->xuser->coder_nik,
						'status_klaim' => 2
					);

					$this->M_inacbg->update_klaim($data_update,$this->input->post('no_sep'));					
					$result_grouper = $this->grouper_stage1($this->input->post('no_sep'));
					$response_grouper = json_decode($result_grouper);

					if ($response_grouper->metadata->code && $response_grouper->metadata->code == '200') {
						$data_update = array('status_klaim' => 2,'cbg_code' => $response_grouper->response->cbg->code,'grouper_at' => date('Y-m-d H:i'));
						$this->M_inacbg->update_klaim($data_update,$this->input->post('no_sep'));
						if (isset($response_grouper->response->cbg->tariff)) {
							$update_tarif = array('tarif_grouper1' => $response_grouper->response->cbg->tariff);
							$this->M_inacbg->update_klaim($update_tarif,$this->input->post('no_sep')); 
						}
						
						if (isset($response_grouper->special_cmg_option)) {
							foreach ($response_grouper->special_cmg_option as $cmg_option) {
						   		$push_cmg[] = $cmg_option->code;
							}
							$special_cmg = implode('#', $push_cmg);		
							$result_grouper2 = $this->grouper_stage2($this->input->post('no_sep'),$special_cmg);
							$response_grouper2 = json_decode($result_grouper2);
							if ($response_grouper2->metadata->code == '200') {
								$kelas_bpjs = $this->M_inacbg->jatah_kelas($nomor_sep);
								$jatah_kelas = 'kelas_' . $kelas_bpjs;
								foreach ($response_grouper2->tarif_alt as $grouper2) {
									if ($grouper2->kelas == $jatah_kelas) {
										$tarif = $grouper2->tarif_inacbg;
									}
								}
					            $data_update = array('tarif_grouper2' => $tarif,'cbg_code' => $response_grouper->response->cbg->code,'grouper_at' => date('Y-m-d H:i'));
								$this->M_inacbg->update_klaim($data_update,$nomor_sep); 
								$this->finalisasi($this->input->post('no_sep'));
							} else {
								echo $result_grouper2;  
							}								
						} else {
						    $this->finalisasi($this->input->post('no_sep'));
						}  // isset cmg_option  

					} else {
						echo $result_grouper; 			
					} 					
				} else {
					echo $result_setklaim;
				}						
			} else echo $result_newclaim;// respone newclaim	
		}	   
    } 



    // Grouping Stage 1

	public function grouper_stage1($no_sep) {   
		$grouper_data = array(
			'metadata'=>array(
				'method' => 'grouper',
				'stage' => '1'
			),		   			
			'data'=>array(	
				'nomor_sep' => $no_sep			 			   			
			)
		);	
    	$data_klaim=json_encode($grouper_data);
		$response = $this->inacbg->web_service($data_klaim);
		return $response;		   			
    }  

    // Grouping Stage 2

	public function grouper_stage2($nomor_sep='',$cmg_option='') {    	
		$data = array(
			'metadata'=>array(
				'method' => 'grouper',
			 	'stage' => '2'
			),		   			
			'data'=>array(	
			 	'nomor_sep' => $nomor_sep,
			 	'special_cmg' => $cmg_option			 			   			
			)
		);

	 	$data_klaim=json_encode($data);
		$response = $this->inacbg->web_service($data_klaim);
		curl_close($ch);

		return $response; 		
    }  


	// Untuk mengedit ulang klaim

	public function reedit_claim() {
    	$nomor_sep = $this->input->post('nomor_sep');
		$data = array(
			'metadata'=>array(
			 	'method' => 'reedit_claim'
			),		   			
			'data'=>array(	
			 	'nomor_sep' => $nomor_sep			 			   			
			)
		);

	 	$data_klaim=json_encode($data);
		$response = $this->inacbg->web_service($data_klaim);
		$response_array = json_decode($response);

		if ($response_array->metadata->code == '200') {
			$data_update = array('status_klaim' => 2,'status_kirim' => 0,'cbg_code' => '','tarif_grouper1' => '','tarif_grouper2' => '');	
			$this->M_inacbg->update_klaim($data_update,$nomor_sep);		
		}
		echo $response; 
    }     
	
	public function finalisasi($nomor_sep) {
    	$login_data = $this->load->get_var("user_info");  
		$coder_nik = $this->xuser->coder_nik;	
		$data = array(
			'metadata'=>array(
			 	'method' => 'claim_final'
			),		   			
			'data'=>array(	
			 	'nomor_sep' => $nomor_sep,
			 	'coder_nik' => $this->xuser->coder_nik		 			   			
			)
		);

	 	$data_klaim=json_encode($data);
		$response = $this->inacbg->web_service($data_klaim);
		$response_array = json_decode($response);

		if ($response_array->metadata->code == '200') {
			$data_update = array('status_klaim' => 3);
			$this->M_inacbg->update_klaim($data_update,$nomor_sep);
		} 
	    echo $response;
    }   	

	public function get_diagnosa($no_sep='') {
        $select_diag = $this->M_pasien->diagnosa_irj($no_sep);          
        $diagnosa_utama = '';
        $diagnosa_tambahan = array();      
        foreach ($select_diag as $diagnosa) {
        	if ($diagnosa->klasifikasi_diagnos == 'utama') {
        		$diagnosa_utama = $diagnosa->id_diagnosa;
        	}
			if ($diagnosa->klasifikasi_diagnos == 'tambahan') {
        		$diagnosa_tambahan[] = $diagnosa->id_diagnosa;
        	}
        }     

		$result = array(
			 	'diagnosa_utama' => $diagnosa_utama,
			 	'diagnosa_tambahan' => $diagnosa_tambahan
		);         
        echo json_encode($result);        
    }

	public function get_diagnosa_iri($no_sep='') {
        $select_diag = $this->M_inacbg->diagnosa_iri($no_sep);          
        $diag_utama = $this->M_inacbg->diagnosa_utama($no_sep); 
        if ($diag_utama) {
        	$diagnosa_utama = $diag_utama->diagnosa1;
        } else {
        	$diagnosa_utama = '';
        }
        $diagnosa_tambahan = array();      
        foreach ($select_diag as $diagnosa) {
			if ($diagnosa->klasifikasi_diagnos == 'tambahan') {
        		$diagnosa_tambahan[] = $diagnosa->id_diagnosa;
        	}
        }     

		$result = array(
			'diagnosa_utama' => $diagnosa_utama,
			'diagnosa_tambahan' => $diagnosa_tambahan
		);         
        echo json_encode($result);        
    }    

    public function claim_status_ajax($no_register='') {
    	$result = $this->M_inacbg->claim_status($no_register);
    	echo json_encode($result);
    }    

	public function get_procedure($no_sep='') {
        $select_procedure = $this->M_pasien->procedure_irj($no_sep);         
        $procedure_utama = '';
        $procedure_tambahan = array();     
        foreach ($select_procedure as $procedure) {
        	if ($procedure->klasifikasi_procedure == 'utama') {
        		$procedure_utama = $procedure->id_procedure;
        	}
			if ($procedure->klasifikasi_procedure == 'tambahan') {
        		$procedure_tambahan[] = $procedure->id_procedure;
        	}
        }       

		$result = array(
			'procedure_utama' => $procedure_utama,
			'procedure_tambahan' => $procedure_tambahan
		);         
        echo json_encode($result);        
    }    		

	/*
	|--------------------------------------------------------------------------
	| Pasien Rawat Jalan
	|--------------------------------------------------------------------------
	*/

	public function irj($no_register='') {
		if ($no_register == '') {
			$data['title'] = 'Pasien Rawat Jalan';
			$this->load->view('ina-cbg/klaim_irj',$data);
		} else {
	    	$login_data = $this->load->get_var("user_info");  
			$coder_nik = $this->M_inacbg->get_coder_nik($login_data->username);	
			$data['coder_nik'] = $this->xuser->coder_nik;	    	
			$data['title'] = 'Pasien Rawat Jalan';
			$data['no_register'] = $no_register;
			$data['data_pasien'] = $this->M_pasien->show_pelayanan_irj($no_register);	 			   			
			// $data['tarif_rs'] = $this->M_pasien->get_tarif_rs($no_register);

			if ($data['data_pasien']) {
		        if ($data['data_pasien']->id_dokter == '') {
		        	$data['nm_dokter'] = '';
		        } else {
		        	$get_dokter = $this->M_pasien->get_dokter($data['data_pasien']->id_dokter);
		        	if (count($get_dokter)) {
		        		$data['nm_dokter'] = $get_dokter->nm_dokter;
		        	} else {
		        		$data['nm_dokter'] = '';
		        	}        	
		        }
		    }		
			$this->load->view('ina-cbg/klaim_irj',$data); 
		}		

	}

    /*
	|--------------------------------------------------------------------------
	| Pasien Rawat Inap
	|--------------------------------------------------------------------------
	*/

	public function iri($no_ipd='') {
		if ($no_ipd == '') {
			$data['title'] = 'Pasien Rawat Inap';
			$this->load->view('ina-cbg/iri',$data);
		} else {
	    	$login_data = $this->load->get_var("user_info");  
			$coder_nik = $this->M_inacbg->get_coder_nik($login_data->username);	
			$data['coder_nik'] = $this->xuser->coder_nik;	    	
			$data['title'] = 'Pasien Rawat Inap';
			$data['no_register'] = $no_ipd;
			$data['data_pasien'] = $this->M_pasien->show_pelayanan_iri($no_ipd);
			if ($data['data_pasien']) {
		        if ($data['data_pasien']->id_dokter == '') {
		        	$data['nm_dokter'] = '';
		        } else {
		        	$get_dokter = $this->M_pasien->get_dokter($data['data_pasien']->id_dokter);
		        	if (count($get_dokter)) {
		        		$data['nm_dokter'] = $get_dokter->nm_dokter;
		        	} else {
		        		$data['nm_dokter'] = '';
		        	}        	
		        }
		    }		 			   			
			$data['tarif_rs'] = $this->M_pasien->get_tarif_rs($no_ipd);	
			$this->load->view('ina-cbg/klaim_iri',$data); 
		}
	}	

	public function list_diagnosa_iri() {
        $data_diagnosa = $this->M_inacbg->list_diagnosa();
        $data = array();
        $no = $_POST['start'];
        foreach ($data_diagnosa as $diagnosa) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $diagnosa->diagnosa_text;
            $row[] = $diagnosa->klasifikasi_diagnos;
            $row[] = $diagnosa->id_diagnosa . ' - ' . $diagnosa->diagnosa;            
            $row[] = '<center><button type="button" class="btn btn-primary btn-xs" onclick="show_diagnosa('.$diagnosa->id_diagnosa_pasien.')"><i class="fa fa-pencil-square-o"></i></button></center>';          
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_inacbg->diagnosa_count_all(),
            "recordsFiltered" => $this->M_inacbg->diagnosa_filtered(),
            "data" => $data
        );
        echo json_encode($output);
    }      

	public function procedure_pasien_iri(){
		$data_procedure=$this->M_inacbg->getdata_procedure_pasien();
        $data = array();
        $no = $_POST['start'];
        foreach ($data_procedure as $procedure) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $procedure->procedure_text;
            $row[] = $procedure->klasifikasi_procedure;
            $row[] = $procedure->id_procedure . ' - ' . $procedure->procedure;            
            $row[] = '<center><button type="button" class="btn btn-primary btn-xs" onclick="show_procedure('.$procedure->id.')"><i class="fa fa-pencil-square-o"></i></button></center>';           
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_inacbg->procedure_count_all(),
            "recordsFiltered" => $this->M_inacbg->procedure_filtered(),
            "data" => $data
        );
        echo json_encode($output);
	}

    public function update_procedure_iri() {
    	$id_icd9cm = $this->input->post('id_icd9cm');
		$postprocedure = explode("@", $this->input->post('procedure'));    	
    	if ($this->input->post('id_procedure') == '') {
    		$id_procedure = ''; 
    		$nm_procedure = ''; 
    	} else {
			$id_procedure = $postprocedure[0]; 
			$nm_procedure = $postprocedure[1];     		
    	}
		$data_update = array(
			'id_procedure' => $id_procedure,
			'procedure' => $nm_procedure		   			
		);
		$result = $this->M_inacbg->update_procedure($id_icd9cm,$data_update);
	    echo json_encode($result);
    }	  

    public function save_diagnosa_iri() {
    	$id_diagnosa_pasien = $this->input->post('id_diagnosa_pasien');
    	$postdiagnosa = explode("@", $this->input->post('diagnosa'));
    	if ($this->input->post('id_diagnosa') == '') {
    		$id_diagnosa = ''; 
    		$diagnosa = ''; 
    	} else {
			$id_diagnosa = $postdiagnosa[0]; 
			$diagnosa = $postdiagnosa[1];      		
    	} 	
		$data_update = array(
			'id_diagnosa' => $id_diagnosa,
			'diagnosa' => $diagnosa		   			
		);
		$result = $this->rjmpelayanan->update_diagnosa($id_diagnosa_pasien,$data_update);
		if ($this->input->post('klasifikasi_diagnosa') == 'utama') {
			$diagnosa_baru = array(
				'diag_baru' => $id_diagnosa,
				'diag_lama' => $this->input->post('diag_lama')	   			
			);			
			$this->rjmpelayanan->diagnosa_baru($this->input->post('no_register'),$diagnosa_baru);
		}
	    echo json_encode($result);
    } 

  //   public function update_klasifikasi_iri() {
  //   	$id_icd9cm = $this->input->post('id_icd9cm');
		// $data_update = array(
		// 	'klasifikasi_procedure' => 'utama'	   			
		// );
		// $result = $this->M_inacbg->update_klasifikasi($id_icd9cm,$data_update);
		// echo json_encode($result);
  //   }    	

    // public function show_diagnosa_iri($id_diagnosa_pasien='') {
    //     $result = $this->M_inacbg->show_diagnosa($id_diagnosa_pasien);
    //     echo json_encode($result);
    // } 

    // 

}
?>
