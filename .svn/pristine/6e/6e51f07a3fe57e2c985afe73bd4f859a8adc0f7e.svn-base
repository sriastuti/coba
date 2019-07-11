<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class Procedure extends Secure_area {
	public function __construct() {
			parent::__construct();
			$this->load->model('Mprocedure','',TRUE);			
	}

    //////////////////////////////////////// Rawat Jalan ////////////////////////////////////////

    function autocomplete_irj()
    {    
        if (isset($_GET['term'])){
          $q = strtolower($_GET['term']);
          $this->Mprocedure->autocomplete_irj($q);
        }
    }

    public function set_utama_irj(){  
        $id = $this->input->post('id');
        $no_register = $this->input->post('no_register');
        $result = $this->Mprocedure->set_utama_irj($id,$no_register);
        echo json_encode($result);
    }

    public function insert_irj()
    {   
        date_default_timezone_set("Asia/Jakarta");
        $no_register = $this->input->post('noreg_procedure');
        $procedure_text = $this->input->post('procedure_text');
        $cek_utama = $this->Mprocedure->count_utama_irj($no_register);
        $cek_limit = $this->Mprocedure->count_limit_irj($no_register);        
        if ($cek_limit < 30) {
            if ($cek_utama > 0) {
                $klasifikasi = 'tambahan';
            } else {
                $klasifikasi = 'utama';
            }

            $login_data = $this->load->get_var("user_info");
            $user = $login_data->username;
            $id_procedure = '';
            $procedure = '';
            
            if ($this->input->post('id_procedure') != '') {     
                $postprocedure = explode("@", $this->input->post('procedure_separate'));
                $id_procedure = $postprocedure[0]; 
                $nm_procedure = $postprocedure[1];    
                $exist = $this->db->from('icd9cm_irj')->where('id_procedure',$id_procedure)->where('no_register',$no_register)->get();
                if( $exist->num_rows() > 0 ) {
                    $result_error = array(
                        'metadata' => array('code' => '422','message' => 'Procedure sudah ditambahkan.'),
                        'response' => null
                    );
                    echo json_encode($result_error);
                } else {
                    $data_insert = array(
                        'tgl_kunjungan' => $this->input->post('tgl_kunjungan'),
                        'no_register' => $no_register,
                        'id_poli' => $this->input->post('id_poli'),
                        'id_procedure' => $id_procedure,
                        'nm_procedure' => $nm_procedure,
                        'procedure_text' => $procedure_text,
                        'klasifikasi_procedure' => $klasifikasi,
                        'xuser' => $user
                    );
                    $result = $this->Mprocedure->insert_irj($data_insert);      
                    if ($result == true) {
                        $result_success = array(
                        'metadata' => array('code' => '200','message' => 'Procedure berhasil disimpan.'),
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
                'metadata' => array('code' => '403','message' => 'Jumlah procedure sudah maksimal.'),
                'response' => null
            );
            echo json_encode($result_error);
        }
    }

    public function show_irj(){
        $data_procedure=$this->Mprocedure->get_procedure_irj();
        $data = array();
        $no = $_POST['start'];
        foreach ($data_procedure as $procedure) {
            $no++;
            $row = array();
            $row[] = $no;
            if ($procedure->id_procedure != '' && $procedure->nm_procedure != '') {
                if ($procedure->klasifikasi_procedure == 'utama') {
                    $row[] = '<strong>'.$procedure->id_procedure . ' - ' . $procedure->nm_procedure.'</strong>';
                } else $row[] = $procedure->id_procedure . ' - ' . $procedure->nm_procedure;                
            } else $row[] = '';
            
            if ($procedure->klasifikasi_procedure == 'utama') {
                $row[] = '<strong>'.$procedure->procedure_text.'</strong>';            
                $row[] = '<center><strong>'.$procedure->klasifikasi_procedure.'</strong></center>';
                $row[] = '<button type="button" onclick="delete_procedure(\''.$procedure->id.'\')" class="btn btn-danger btn-xs delete_procedure btn-block"><i class="fa fa-trash"></i> Hapus</button>';
            } else {
                $row[] = $procedure->procedure_text;
                $row[] = '<center>'.$procedure->klasifikasi_procedure.'</center>';
                $row[] = '<button type="button" onclick="set_utama_procedure(\''.$procedure->id.'\')" class="btn btn-warning btn-xs btn-block" style="margin-right:5px;"><i class="fa fa-check"></i> Set Utama</button><button type="button" onclick="delete_procedure(\''.$procedure->id.'\')" class="btn btn-danger btn-xs delete_procedure btn-block"><i class="fa fa-trash"></i> Hapus</button>'; 
            } 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mprocedure->count_all_irj(),
            "recordsFiltered" => $this->Mprocedure->filtered_irj(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function delete_irj()
    {   
        $id = $this->input->post('id');
        $no_register = $this->input->post('no_register');
        $result=$this->Mprocedure->delete_irj($id);
        $cek_utama = $this->Mprocedure->count_utama_irj($no_register);
        if ($cek_utama == 0) {
            $this->Mprocedure->auto_utama_irj($no_register);
        }  
        echo json_encode($result);
    }

    //////////////////////////////////////// Rawat Inap ////////////////////////////////////////		
                  		
}
?>
