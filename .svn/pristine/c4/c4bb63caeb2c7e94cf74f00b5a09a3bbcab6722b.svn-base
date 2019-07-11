<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_inacbg extends CI_Model {
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
    }

    function config_inacbg()
    {
        return $this->db->query("select * from inacbg_config limit 1");
    } 

    public function update_config($data){
        $this->db->update('inacbg_config', $data);
        $this->db->limit(1);
        return true;        
    }  

    function get_coder_nik($username) 
    {
        $this->db->FROM('hmis_users');
        $this->db->SELECT('coder_nik');   
        $this->db->where('username', $username);
        $query = $this->db->get();
        return $query->row();
    }                        

    function jatah_kelas($no_sep) 
    {
        $this->db->FROM('daftar_ulang_irj');
        $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');          
        $this->db->SELECT('data_pasien.kelas_bpjs');   
        $this->db->where('daftar_ulang_irj.no_sep', $no_sep);
        $query = $this->db->get();
        return $query->row();
    }                  

    function claim_status($no_register) 
    {
        $this->db->FROM('inacbg_klaim');           
        $this->db->where('no_register', $no_register);
        $query = $this->db->get();
        return $query->row();
    } 
    function check_klaim($no_sep) 
    {
        $this->db->FROM('inacbg_klaim');  
        $this->db->where('no_sep', $no_sep);
        $query = $this->db->get();
        return $query->row();
    }      

    function delete_klaim($no_sep)
    {
        $this->db->where('no_sep', $no_sep);
        $this->db->delete('inacbg_klaim');
        return true;
    }   

    function insert_inacbg($data_insert)
    {          
        $this->db->insert('inacbg_klaim', $data_insert);
        return true;
    }   
    
    function update_klaim($data_update,$no_sep)
    {
        $this->db->where('no_sep', $no_sep);
        $this->db->update('inacbg_klaim', $data_update);
        return true;
    }                                                                       
}

?>