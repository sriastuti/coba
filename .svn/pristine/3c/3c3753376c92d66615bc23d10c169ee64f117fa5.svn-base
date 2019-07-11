<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class Diagnosa extends Secure_area {
	public function __construct() {
			parent::__construct();
            $this->load->model('Mdiagnosa','',TRUE);				
	}

    //////////////////////////////////////// Rawat Jalan ////////////////////////////////////////

    function autocomplete_irj()
    {    
        if (isset($_GET['term'])){
          $q = strtolower($_GET['term']);
          $this->Mdiagnosa->autocomplete_irj($q);
        }
    }

    public function insert_irj() 
    {
        date_default_timezone_set("Asia/Jakarta");
        $no_register = $this->input->post('noreg_diag');
        $cek_utama = $this->Mdiagnosa->count_utama_irj($no_register);
        $cek_limit = $this->Mdiagnosa->count_limit_irj($no_register);        
        if ($cek_limit < 30) {
            if ($cek_utama > 0) {
            $klasifikasi = 'tambahan';
            } else {
                $klasifikasi = 'utama';
            }       
            $diagnosa_text = $this->input->post('diagnosa_text');

            $login_data = $this->load->get_var("user_info");
            $user = $login_data->username;
            $id_diagnosa = '';
            $diagnosa = '';
            
            if ($this->input->post('id_diagnosa') != '') {      
                $postdiagnosa = explode("@", $this->input->post('diagnosa_separate'));
                $id_diagnosa = $postdiagnosa[0]; 
                $diagnosa = $postdiagnosa[1];  
                $exist = $this->db->from('diagnosa_pasien')->where('id_diagnosa',$id_diagnosa)->where('no_register',$no_register)->get();
                if( $exist->num_rows() > 0 ) {
                    $result_error = array(
                        'metadata' => array('code' => '422','message' => 'Diagnosa sudah ditambahkan.'),
                        'response' => null
                    );
                    echo json_encode($result_error);
                } else {
                    $data_insert = array(
                        'tgl_kunjungan' => $this->input->post('tgl_kunjungan'),
                        'no_register' => $no_register,
                        'id_poli' => $this->input->post('id_poli'),
                        'id_diagnosa' => $id_diagnosa,
                        'diagnosa' => $diagnosa,
                        'diagnosa_text' => $diagnosa_text,
                        'klasifikasi_diagnos' => $klasifikasi,
                        'xuser' => $user
                    );
                    $result = $this->Mdiagnosa->insert_irj($data_insert);

                    if ($result == true) {
                        $result_success = array(
                        'metadata' => array('code' => '200','message' => 'Diagnosa berhasil disimpan.'),
                        'response' => 'OK'
                        );
                        echo json_encode($result_success);       
                    } else {
                        $result_error = array(
                            'metadata' => array('code' => '500','message' => $result),
                            'response' => null
                        );
                        echo json_encode($result_error);
                    } 
                }     
                      
            }                    
        } else {
            $result_error = array(
                'metadata' => array('code' => '403','message' => 'Jumlah diagnosa sudah maksimal.'),
                'response' => null
            );
            echo json_encode($result_error);
        }
        
    }

    public function show_irj()
    {
        $data_diagnosa=$this->Mdiagnosa->get_diagnosa_irj();
        $data = array();
        $no = $_POST['start'];
        $diagnosa_pasien = '';        
        
        foreach ($data_diagnosa as $diagnosa) {
            $no++;
            $row = array();
            $row[] = $no;
            if ($diagnosa->id_diagnosa != '' && $diagnosa->diagnosa != '') {
                if ($diagnosa->klasifikasi_diagnos == 'utama') {
                    $row[] = '<strong>'.$diagnosa->id_diagnosa . ' - ' . $diagnosa->diagnosa.'</strong>';
                } else $row[] = $diagnosa->id_diagnosa . ' - ' . $diagnosa->diagnosa;               
            } else $row[] = '';
            
            if ($diagnosa->klasifikasi_diagnos == 'utama') {
                $row[] = '<strong>'.$diagnosa->diagnosa_text.'</strong>';            
                $row[] = '<center><strong>'.$diagnosa->klasifikasi_diagnos.'</strong></center>';
                $row[] = '<button type="button" onclick="delete_diagnosa(\''.$diagnosa->id_diagnosa_pasien.'\')" class="btn btn-danger btn-xs delete_diagnosa btn-block"><i class="fa fa-trash"></i> Hapus</button>';
            } else {
                $row[] = $diagnosa->diagnosa_text;            
                $row[] = '<center>'.$diagnosa->klasifikasi_diagnos.'</center>';
                $row[] = '<button type="button" onclick="set_utama_diagnosa(\''.$diagnosa->id_diagnosa_pasien.'\')" class="btn btn-warning btn-xs btn-block" style="margin-right:5px;"><i class="fa fa-check"></i> Set Utama</button><button type="button" onclick="delete_diagnosa(\''.$diagnosa->id_diagnosa_pasien.'\')" class="btn btn-danger btn-xs delete_diagnosa btn-block"><i class="fa fa-trash"></i> Hapus</button>';  
            }                        
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mdiagnosa->count_all_irj(),
            "recordsFiltered" => $this->Mdiagnosa->filtered_irj(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function delete_irj()
    {   
        $id_diagnosa_pasien = $this->input->post('id_diagnosa_pasien');
        $no_register = $this->input->post('no_register');
        $result = $this->Mdiagnosa->delete_irj($id_diagnosa_pasien);
        $cek_utama = $this->Mdiagnosa->count_utama_irj($no_register);
        if ($cek_utama == 0) {
            $this->Mdiagnosa->auto_utama_irj($no_register);
        }            
        echo json_encode($result);
    }

    public function set_utama_irj(){   
        $id_diagnosa_pasien = $this->input->post('id_diagnosa_pasien');
        $no_register = $this->input->post('no_register');
        $result = $this->Mdiagnosa->set_utama_irj($id_diagnosa_pasien,$no_register);
        echo json_encode($result);
    }

    //////////////////////////////////////// Rawat Inap ////////////////////////////////////////

    		
                  		
}
?>
