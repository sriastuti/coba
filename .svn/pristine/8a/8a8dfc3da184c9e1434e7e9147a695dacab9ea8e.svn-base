<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mprocedure extends CI_Model{
	var $procedure_order = array(null,'procedure_text','klasifikasi_procedure','id_procedure');
    var $procedure_search = array('icd9cm_irj.id_procedure','icd9cm_irj.procedure_text','icd9cm_irj.klasifikasi_procedure','icd9cm_irj.nm_procedure'); 
    var $default_order_procedure = array('icd9cm_irj.klasifikasi_procedure' => 'desc','icd9cm_irj.id' => 'desc'); 

	function __construct(){
		parent::__construct();
	}

	//////////////////////////////////////// Rawat Jalan //////////////////////////////////////// 

    function autocomplete_irj($q)
    {   
        $query=$this->db->query("
    		SELECT * FROM icd9cm WHERE id_tind LIKE '%$q%' 
    		UNION 
    		SELECT * FROM icd9cm WHERE nm_tindakan LIKE '%$q%' GROUP BY id_tind LIMIT 50"
        );
        if($query->num_rows() > 0){
			foreach ($query->result_array() as $row){
				$new_row['label']=htmlentities(stripslashes($row['id_tind'].' - '.$row['nm_tindakan']));
				$new_row['value']=htmlentities(stripslashes($row['id_tind'].' - '.$row['nm_tindakan']));
				$new_row['id_tind']=htmlentities(stripslashes($row['id_tind']));
				$new_row['nm_tindakan']=htmlentities(stripslashes($row['nm_tindakan']));	            
				$row_set[] = $new_row; 
			}
          	echo json_encode($row_set);
        } else {        
            echo json_encode([]);
        }
    }

    function insert_irj($data_insert)
    {          
        $this->db->insert('icd9cm_irj', $data_insert);
        return true;
    }  

    function show_irj($id_icd9cm) {
        $this->db->FROM('icd9cm_irj'); 
        $this->db->where('id', $id_icd9cm);
        $query = $this->db->get();
        return $query->row();
    } 
  	
	function update_irj($id_icd9cm,$data_update)
	{
		$this->db->where('id', $id_icd9cm);
		$this->db->update('icd9cm_irj', $data_update);
		return true;
	}

	function delete_irj($id_procedure_pasien)
	{
		$this->db->query("DELETE FROM icd9cm_irj WHERE id='$id_procedure_pasien'");
		return true;
	}

    function set_utama_irj($id,$no_register)
    {          
        $this->db->trans_begin();		
		$this->db->query("UPDATE icd9cm_irj SET klasifikasi_procedure='tambahan' WHERE klasifikasi_procedure = 'utama' AND no_register = '$no_register'");
		$this->db->query("UPDATE icd9cm_irj SET klasifikasi_procedure='utama' WHERE id = '$id' ");
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
		$get_procedure = $this->db->query("SELECT id FROM icd9cm_irj WHERE no_register = '$no_register' ORDER BY id ASC LIMIT 1")->row();
		if ($get_procedure && $get_procedure != NULL) {
			$this->db->query("UPDATE icd9cm_irj SET klasifikasi_procedure='utama' WHERE no_register = '$no_register' AND id='$get_procedure->id' ");
		}		
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
		    $this->db->trans_commit();
		} 
        return true;
    } 

    function count_utama_irj($no_register)
    {        					
		$this->db->from('icd9cm_irj');
		$this->db->where('klasifikasi_procedure','utama');
		$this->db->where('no_register',$no_register);
		return $this->db->count_all_results();       			
	}

    function count_limit_irj($no_register)
    {                           
        $this->db->from('icd9cm_irj');            
        $this->db->where('no_register',$no_register);
        return $this->db->count_all_results();                  
    }

	private function show_irj_query()  
	{
		$no_register = $this->input->post('no_register');
        $this->db->FROM('icd9cm_irj');
        $this->db->JOIN('daftar_ulang_irj', 'daftar_ulang_irj.no_register = icd9cm_irj.no_register', 'left');
        $this->db->where('icd9cm_irj.no_register',$no_register);
    
        $i = 0;     
        foreach ($this->procedure_search as $item)
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
 
                if(count($this->procedure_search) - 1 == $i)
                    $this->db->group_end();
            }
	            $i++;
	        }
	         
	        if(isset($_POST['order'])) // here order processing
	        {
	            $this->db->order_by($this->procedure_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
	        } 
	        else if(isset($this->default_order_procedure))
	        {
	            $order = $this->default_order_procedure;
	            $this->db->order_by(key($order), $order[key($order)]);
	        }
	 //   }
	}    

    public function get_procedure_irj()
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
        $this->db->FROM('icd9cm_irj');
        $this->db->JOIN('daftar_ulang_irj', 'daftar_ulang_irj.no_register = icd9cm_irj.no_register', 'left');
        $this->db->where('icd9cm_irj.no_register',$no_register); 
        return $this->db->count_all_results();
    }	        	

}
?>
