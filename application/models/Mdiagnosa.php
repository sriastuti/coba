<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdiagnosa extends CI_Model{
	var $diagnosa_order = array(null,'diagnosa_text','klasifikasi_diagnos','id_diagnosa');
    var $diagnosa_search = array('diagnosa_pasien.diagnosa_text','diagnosa_pasien.klasifikasi_diagnos','diagnosa_pasien.id_diagnosa','diagnosa_pasien.diagnosa'); 
    var $default_order_diagnosa = array('diagnosa_pasien.klasifikasi_diagnos' => 'desc','diagnosa_pasien.id' => 'desc'); 

	function __construct(){
		parent::__construct();
	}

	//////////////////////////////////////// Rawat Jalan //////////////////////////////////////// 

	function autocomplete_irj($q)
	{   
        $query=$this->db->query("
            SELECT * FROM icd1 WHERE id_icd LIKE '%$q%'
			UNION
			SELECT * FROM icd1 WHERE nm_diagnosa LIKE '%$q%' GROUP BY id_icd limit 50"
        );
        if($query->num_rows() > 0){
			foreach ($query->result_array() as $row) {
				$new_row['label']=htmlentities(stripslashes($row['id_icd'].' - '.$row['nm_diagnosa']));
				$new_row['value']=htmlentities(stripslashes($row['id_icd'].' - '.$row['nm_diagnosa']));
				$new_row['id_icd']=htmlentities(stripslashes($row['id_icd']));
				$new_row['nm_diagnosa']=htmlentities(stripslashes($row['nm_diagnosa']));	            
				$row_set[] = $new_row;
			}
        	echo json_encode($row_set);
        } else {        
            echo json_encode([]);
        }
    }

    function insert_irj($data_insert)
    {          
        $this->db->insert('diagnosa_pasien', $data_insert);
        return true;
    } 	

    function show_irj($id_diagnosa_pasien) {
        $this->db->FROM('diagnosa_pasien'); 
        $this->db->where('id_diagnosa_pasien', $id_diagnosa_pasien);
        $query = $this->db->get();
        return $query->row();
    }           

	function delete_irj($id_diagnosa_pasien)
	{			
		$this->db->query("DELETE FROM diagnosa_pasien WHERE id_diagnosa_pasien='$id_diagnosa_pasien'");
		return true;
	}
	
    function set_utama_irj($id_diagnosa_pasien,$no_register)
    {          
        $this->db->trans_begin();       
        $this->db->query("UPDATE diagnosa_pasien SET klasifikasi_diagnos='tambahan' WHERE klasifikasi_diagnos='utama' AND no_register = '$no_register'");
        $this->db->query("UPDATE diagnosa_pasien SET klasifikasi_diagnos='utama' WHERE id_diagnosa_pasien = '$id_diagnosa_pasien' ");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        } 
        return true;
    }

    function auto_utama_irj($no_register)
    {          
        $this->db->trans_begin();		
		$get_diagnosa = $this->db->query("SELECT id_diagnosa_pasien FROM diagnosa_pasien WHERE no_register = '$no_register' ORDER BY id_diagnosa_pasien ASC LIMIT 1")->row();
		if ($get_diagnosa && $get_diagnosa != NULL) {
			$this->db->query("UPDATE diagnosa_pasien SET klasifikasi_diagnos='utama' WHERE no_register = '$no_register' AND id_diagnosa_pasien='$get_diagnosa->id_diagnosa_pasien' ");
		}		
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
		    $this->db->trans_commit();
		} 
        return true;
    } 

    public function count_utama_irj($no_register)
    {        					
		$this->db->from('diagnosa_pasien');
		$this->db->where('klasifikasi_diagnos','utama');
		$this->db->where('no_register',$no_register);
		return $this->db->count_all_results();       			
	}

    public function count_limit_irj($no_register)
    {                           
        $this->db->from('diagnosa_pasien');        
        $this->db->where('no_register',$no_register);
        return $this->db->count_all_results();                  
    }

	private function show_irj_query()  
	{
		$no_register = $this->input->post('no_register');
        $this->db->FROM('diagnosa_pasien');
        $this->db->JOIN('daftar_ulang_irj', 'daftar_ulang_irj.no_register = diagnosa_pasien.no_register', 'left');
        $this->db->where('diagnosa_pasien.no_register',$no_register);
        $this->db->select('diagnosa_pasien.diagnosa_text,diagnosa_pasien.klasifikasi_diagnos,diagnosa_pasien.id_diagnosa_pasien,diagnosa_pasien.id_diagnosa,diagnosa_pasien.diagnosa,daftar_ulang_irj.tgl_kunjungan');
    
        $i = 0;     
        foreach ($this->diagnosa_search as $item)
        {
            if($_POST['search']['value'])
            {
                 
                if($i===0)
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->diagnosa_search) - 1 == $i)
                    $this->db->group_end();
            }
	            $i++;
	        }
	         
	        if(isset($_POST['order'])) // here order processing
	        {
	            $this->db->order_by($this->diagnosa_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
	        } 
	        else if(isset($this->default_order_diagnosa))
	        {
	            $order = $this->default_order_diagnosa;
	            $this->db->order_by(key($order), $order[key($order)]);
	        }		  
	} 

	public function get_diagnosa_irj()
    {
        $this->show_irj_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }  

    public function filtered_irj()
    {
        $this->show_irj_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_irj()
    {
		$no_register = $this->input->post('no_register');
        $this->db->FROM('diagnosa_pasien');
        $this->db->JOIN('daftar_ulang_irj', 'daftar_ulang_irj.no_register = diagnosa_pasien.no_register', 'left');
        $this->db->where('diagnosa_pasien.no_register',$no_register);   
        return $this->db->count_all_results();
    } 

    //////////////////////////////////////// Rawat Inap ////////////////////////////////////////

    

}
?>
