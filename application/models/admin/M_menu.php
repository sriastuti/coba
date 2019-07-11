<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_menu extends CI_Model{
	function __construct(){
		parent::__construct();
	}	
	
	function get_child($parent_id){
		$this->db->from('dyn_menu');
		$this->db->where('show_menu',1);			
		$this->db->where('parent_id',$parent_id);			
		$this->db->order_by("position", "asc");
		return $this->db->get();	
	}
	
	function get_allowed_menu($parent_id){
		$userid = $this->session->userdata('userid');
		return $this->db->query("select distinct m.*
			from dyn_role_user ru, dyn_role_menu rm, dyn_menu m
			where ru.userid = $userid	
			and ru.roleid = rm.role_id 
			and rm.menu_id = m.page_id
			and m.parent_id = $parent_id
			and m.show_menu = 1
			order by position asc");
	}
	
	function get_breadcrumb($url){
		return $this->db->query("select c.title, c.url, c.parent_id, p.title as ptitle
			from dyn_menu p, dyn_menu c
			where c.url = '$url'
			and p.page_id = c.parent_id");
	}
	/*
	function get_all_menu()
	{
		$this->db->select("id,
			CASE WHEN is_parent = 1 THEN CONCAT(id,'00')
									ELSE CONCAT(parent_id,position)
			END AS urutan,
			CASE WHEN (is_parent = 1 or parent_id = 0) THEN title
									ELSE CONCAT('&nbsp;&nbsp;&nbsp;',title)
			END AS title",FALSE);
		$this->db->where('parent_id','0');	
		$this->db->from('menu');
		$this->db->order_by("urutan", "asc");
		$query=$this->db->get();
		//return $query->result_array();	
		$data[0] = "-- Root --";
		foreach($query->result() as $row)
		{
			$data[$row->id] = $row->title;
		}
		return $data;	
	}
	*/
	function get_all_menu()
	{
		$this->db->select("page_id, title",FALSE);
		$this->db->where('parent_id','0');	
		$this->db->from('dyn_menu');
		$this->db->order_by("position", "asc");
		$query=$this->db->get();
		//return $query->result_array();	
		$data[0] = "-- Root --";
		foreach($query->result() as $row)
		{
			$data[$row->page_id] = $row->title;
		}
		return $data;	
	}
	
	function save($data)
	{	
		if (isset($data["page_id"])){
			$this->db->set('title', $data["title"]);
			$this->db->set('url', $data["url"]);
			$this->db->set('parent_id', $data["parent_id"]);
			$this->db->where('page_id',$data["page_id"]);	
			if ($this->db->update('dyn_menu')){
				$this->updateIsParent($data["parent_id"]);
				return true;
			}else{			
				return false;
			}						
		} else{			
			$position = $this->get_max_position($data["parent_id"]) + 1;
			$this->db->set('show_menu', '1');
			$this->db->set('is_parent', '0');
			$this->db->set('position', $position);
			if ($this->db->insert('dyn_menu',$data)){
				$this->updateIsParent($data["parent_id"]);
				return true;
			}else{			
				return false;
			}
		}
	}
	
	function delete($id)
	{
		$this->db->where('page_id',$id);	
		if ($this->db->delete('dyn_menu')){
			return true;
		}else{			
			return false;
		}
	}
	
	function updatePosition(&$data)
	{
		$true = 0;
		$false = 0;
		foreach ($data as $key => $value) {
			$position = $key + 1;
			$id = str_replace("id_","",$value);
			$this->db->set('position', $position);
			$this->db->where('page_id',$id);	
			if ($this->db->update('dyn_menu'))
				$true += 1;
			else
				$false += 1;
		}
		$out = "True:".$true." - False:".$false;
		return true;
	}
	
	function updateIsParent($id)
	{
		$this->db->set('is_parent', 1);
		$this->db->where('page_id',$id);	
		$this->db->update('dyn_menu');
		return true;
	}
	function get_max_position($parent_id){
		$this->db->select_max('position');
		$this->db->where('parent_id',$parent_id);	
		return $this->db->get('dyn_menu')->row()->position;
	}
	
	function get_info($id)
	{
		$query = $this->db->get_where('dyn_menu', array('page_id' => $id), 1);
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//create object with empty properties.
			$fields = $this->db->list_fields('dyn_menu');
			$obj = new stdClass;
			
			foreach ($fields as $field)
			{
				$obj->$field='';
			}
			
			return $obj;
		}
	}
	
	function has_child($parent_id){
		$this->db->from('dyn_menu');
		$this->db->where('parent_id',$parent_id);	
		return $this->db->count_all_results();	
	}
	
	function has_parent($id){
		$this->db->from('dyn_menu');
		$this->db->where('page_id',$id);	
		$this->db->where('parent_id','>0');	
		return $this->db->count_all_results();	
	}
}
?>