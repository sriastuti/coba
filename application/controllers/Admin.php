<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once ("Secure_area.php");
class Admin extends Secure_area {
	public function __construct() {
		parent::__construct();
		
		$this->load->model('admin/M_user','',TRUE);
		$this->load->model('admin/M_menu','',TRUE);
		$this->load->model('admin/M_role','',TRUE);
		$this->load->model('admin/Appconfig','',TRUE);
		$this->load->model('bpjs/Mbpjs','',TRUE);
	}
	
	public function index()
	{
	}
	/*=================================== USER ============================================*/
	public function user()
	{
		$data["title"] = "Data User";
		$this->load->view('admin/user', $data);
	}
	
	public function userExist(){			
		$username = $this->input->post('id');
		$exist = $this->M_user->exist($username);
		if ($exist > 0){
			echo json_encode(array('exist'=>true));
		}else{
			echo json_encode(array('exist'=>false));
		}
	}
	
	public function userInfo(){			
		$userid = $this->input->post('id');
		$data = $this->M_user->get_info($userid);
		echo json_encode($data);
	}
	
	public function userList() {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_user->get_all()->result();
		/*echo json_encode($hasil);*/
		
		foreach ($hasil as $value) {
			$row2['id'] = $value->userid;
			$row2['username'] = $value->username;
			$row2['name'] = $value->name;
			$row2['role'] = '<center><button type="button" class="btn btn-primary btn-xs" title="Set Roles" data-toggle="modal" data-target="#myModal" onclick="setUserRole('.$value->userid.',\''.$value->username.'\')" ><i class="fa fa-user-secret fa-fw"></i></button></center>';
			$row2['plus'] = '<center><button type="button" class="btn btn-primary btn-xs" title="Akses Gudang" data-toggle="modal" data-target="#myModalGdg" onclick="setUserGudang('.$value->userid.',\''.$value->username.'\')" ><i class="fa fa-building fa-fw"></i></button></center>';
			$row2['poli'] = '<center><button type="button" class="btn btn-primary btn-xs" title="Akses Poli" data-toggle="modal" data-target="#myModalPoli" onclick="setUserPoli('.$value->userid.',\''.$value->username.'\')" ><i class="fa fa-building fa-fw"></i></button></center>';
			$row2['ruang'] = '<center><button type="button" class="btn btn-primary btn-xs" title="Akses Ruang" data-toggle="modal" data-target="#myModalRuang" onclick="setUserRuang('.$value->userid.',\''.$value->username.'\')" ><i class="fa fa-building fa-fw"></i></button></center>';
			$row2['hakakses'] = '<center><button type="button" class="btn btn-primary btn-xs" title="Hak Akses Kasir" data-toggle="modal" data-target="#myModalAkses" onclick="setUserAkses('.$value->userid.',\''.$value->username.'\')" ><i class="fa fa-building fa-fw"></i></button></center>';
			$row2['aksi'] = '<center><button type="button" class="btn btn-success btn-xs" title="Reset Password" data-toggle="modal" data-target="#editModal" data-id="'.$value->userid.'" data-username="'.$value->username.'"><i class="fa fa-edit fa-fw"></i></button>&nbsp;<a href="'.base_url().'admin/dropUser/'.$value->userid.'" class="btn btn-danger btn-xs delete_user" title="Delete"><i class="fa fa-trash fa-fw"></i></a></center>';
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	
	public function userRoleList($id) {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_user->get_role_all($id)->result();
		/*echo json_encode($hasil);*/
		
		foreach ($hasil as $value) {
			$row2['id'] = $value->id;
			$row2['sts'] = $value->sts;
			$row2['role'] = $value->role;
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	
	public function userRoleSave(){
		$data = $this->input->post('vdata');
		$id = $data[0]['userid'];
		/**/
		if($this->M_user->userRoleSave($id,$data)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
		
	}
	public function userAksesSave(){
		$data = $this->input->post('vdata');
		$id = $data[0]['userid'];
		/**/
		if($this->M_user->userAksesSave($id,$data)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
		
	}
	public function userGdgList($id) {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_user->get_role_gudang($id)->result();
		/*echo json_encode($hasil);*/
		
		foreach ($hasil as $value) {
			$row2['id'] = $value->id_gudang;
			$row2['sts'] = $value->sts;
			$row2['nama'] = $value->nama_gudang;
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	public function userPoliList($id) {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_user->get_role_poli($id)->result();
		/*echo json_encode($hasil);*/
		
		foreach ($hasil as $value) {
			$row2['id'] = $value->id_poli;
			$row2['sts'] = $value->sts;
			$row2['nama'] = $value->nm_poli;
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	public function userRuangList($id) {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_user->get_role_ruang($id)->result();
		/*echo json_encode($hasil);*/
		
		foreach ($hasil as $value) {
			$row2['id'] = $value->id_ruang;
			$row2['sts'] = $value->sts;
			$row2['nama'] = $value->nm_ruang;
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}

	public function userAksesList($id) {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_user->get_role_akses($id)->result();
		/*echo json_encode($hasil);*/
		
		foreach ($hasil as $value) {
			$row2['id'] = $value->id;
			$row2['sts'] = $value->sts;
			$row2['kasir'] = $value->kasir;
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}

	public function userGdgDelete(){
		$id = $this->input->post('vdata');
		/**/
		$this->M_user->userGdgDelete($id);
		echo json_encode(array('success'=>true));
		
		
	}

	public function userGdgSave(){
		$data = $this->input->post('vdata');
		$id = $data[0]['userid'];
		/**/
		if($this->M_user->userGdgSave($id,$data)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
		
	}

	public function userPoliDelete(){
		$id = $this->input->post('vdata');
		/**/
		$this->M_user->userPoliDelete($id);
			echo json_encode(array('success'=>true));
		
		
	}

	public function userPoliSave(){
		$data = $this->input->post('vdata');
		$id = $data[0]['userid'];
		/**/
		if($this->M_user->userPoliSave($id,$data)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
		
	}

	public function userRuangDelete(){
		$id = $this->input->post('vdata');
		/**/
		$this->M_user->userRuangDelete($id);
			echo json_encode(array('success'=>true));
		
		
	}

	public function userRuangSave(){
		$data = $this->input->post('vdata');
		$id = $data[0]['userid'];
		/**/
		if($this->M_user->userRuangSave($id,$data)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
		
	}

	function user_insert()
	{
		$newfilename = $this->input->post('username');
		//upload logo
		$config['upload_path'] = './upload/user/';
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size'] = '2000000';
		$config['max_width'] = '2000';
		$config['max_height'] = '2000';
		$config['file_name'] = $newfilename;
		$this->upload->initialize($config);
		
		$userfile = $_FILES['userfile']['name'];
		$data = $this->input->post();
		
		if ($userfile){
			$ext = pathinfo($userfile, PATHINFO_EXTENSION);
			$file = $config['upload_path'].$config['file_name'].'.'.$ext;
			if(is_file($file))
				unlink($file);
				
			if(!$this->upload->do_upload()){
				//$data['foto']=$old_logo;
				$error = $this->upload->display_errors();
				echo $error;
			}else{
				$upload = $this->upload->data();
				$foto = $upload['file_name'];
				//echo "success";
				//$this->userSave($data, $foto);
				if($this->M_user->save($data,$foto)){
					echo json_encode(array('success'=>true));
				}else{
					echo json_encode(array('success'=>false));
				}				
			}	
		}else{
			$foto = "";
			//$this->userSave($data, $foto);
			if($this->M_user->save($data,$foto)){
				echo json_encode(array('success'=>true));
			}else{
				echo json_encode(array('success'=>false));
			}			
		}
			
	}	
	public function reset_password(){	
		if($this->M_user->update($this->input->post())){	
			echo json_encode(array('success'=>true));			
			//redirect(site_url("Admin/user"), 'refresh');
		}else{
			echo json_encode(array('success'=>false));			
			//redirect(site_url("Admin/user"), 'refresh');
		}
	}
	public function userSave($data,$foto){	
		if($this->M_user->save($data,$foto)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
	}
	
	public function dropUser($userid){				
		if($this->M_user->delete($userid)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
	}
	
	function update_photo()
	{
		$uid = $this->input->post('uid');
		//upload logo
		$config['upload_path'] = './upload/user/';
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size'] = '2000000';
		$config['max_width'] = '2000';
		$config['max_height'] = '2000';
		$config['file_name'] = $uid;
		$this->upload->initialize($config);
		
		$userfile = $_FILES['userfile']['name'];
		$data = $this->input->post();
		
		if ($userfile){
			$ext = pathinfo($userfile, PATHINFO_EXTENSION);
			$file = $config['upload_path'].$config['file_name'].'.'.$ext;
			if(is_file($file))
				unlink($file);
				
			if(!$this->upload->do_upload()){
				$error = $this->upload->display_errors();
				echo $error;
			}else{
				$upload = $this->upload->data();
				$foto = $upload['file_name'];
				
				if ($this->M_user->update_photo($uid, $foto)){
					echo json_encode(array('success'=>true,'photo'=>$foto));
				}else{
					echo json_encode(array('success'=>true,'photo'=>'unknown.png'));
				}
			}	
		}			
	}
	function update_name(){
		$name = $this->input->post('uname');
		if ($this->M_user->update_name($this->input->post())){
			echo json_encode(array('success'=>true,'name'=>$name));
		}
	}
	/*======================================== MENU =================================================*/
	public function menu()
	{
		$data["title"] = "Data Menu";
		$data['parents'] = $this->M_menu->get_all_menu();
		$data['sortMenu'] = sortMenu();
		$this->load->view('admin/menu', $data);
	
	}
	
	public function menuInfo(){			
		$page_id = $this->input->post('id');
		$data = $this->M_menu->get_info($page_id);
		echo json_encode($data);
	}
	
	public function hasChildMenu(){			
		$page_id = $this->input->post('id');
		$child = $this->M_menu->has_child($page_id);
		if ($child > 0){
			echo json_encode(array('hasChild'=>true));
		}else{
			echo json_encode(array('hasChild'=>false));
		}
	}
	
	public function menuSave(){	
		if ($this->input->post('id') == '') {
			$data = array(
				'title'=>$this->input->post('title'),
				'url'=>$this->input->post('url'),
				'parent_id'=>$this->input->post('parent_id')
			);			
		} else {
			$data = array(
				'page_id'=>$this->input->post('id'),
				'title'=>$this->input->post('title'),
				'url'=>$this->input->post('url'),
				'parent_id'=>$this->input->post('parent_id')
			);
		}					
		
		if($this->M_menu->save($data)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
	}
	
	public function dropMenu(){				
		$page_id = $this->input->post('id');
		if($this->M_menu->delete($page_id)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
	}
	
	public function updateOrderMenu(){						
		$arr = $this->input->post('data');
		echo $this->M_menu->updatePosition($arr);
	}
	/*================================== ROLE ========================================*/
	
	public function role()
	{
		$data["title"] = "Data Role";
		$this->load->view('admin/role', $data);
	}
	
	public function roleExist(){			
		$role = $this->input->post('id');
		$exist = $this->M_role->exist($role);
		if ($exist > 0){
			echo json_encode(array('exist'=>true));
		}else{
			echo json_encode(array('exist'=>false));
		}
	}
	
	public function roleList() {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_role->get_all()->result();
		/*echo json_encode($hasil);*/
		
		foreach ($hasil as $value) {
			$row2['id'] = $value->id;
			$row2['role'] = $value->role;
			$row2['deskripsi'] = $value->deskripsi;
			$row2['access'] = '<center><a href="#" title="Set Access Menu" data-toggle="modal" data-target="#myModal" onclick="setAccessRole('.$value->id.',\''.$value->role.'\')" ><i class="fa fa-user-secret fa-fw"></i></a></center>';
			$row2['edit'] = '<center><a href="#" title="Set Inactive"><i class="fa fa-edit fa-fw"></i></a></center>';
			$row2['drop'] = '<center><a href="#" title="Delete"><i class="fa fa-trash fa-fw"></i></a></center>';
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	
	public function roleSave(){	
		$data = array(
			'id'=>$this->input->post('id'),
			'role'=>$this->input->post('role'),
			'deskripsi'=>$this->input->post('deskripsi')
		);
		/*echo json_encode($data);*/
		
		if($this->M_role->save($data)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
		
	}
	
	public function roleMenuList($id) {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_role->get_menu_all($id)->result();
		/*echo json_encode($hasil);*/
		
		foreach ($hasil as $value) {
			$row2['id'] = $value->page_id;
			$row2['urutan'] = $value->urutan;
			$row2['sts'] = $value->sts;
			$row2['menu'] = $value->title;
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	
	public function roleMenuSave(){
		$data = $this->input->post('vdata');
		$id = $data[0]['role_id'];
		/**/
		if($this->M_role->roleMenuSave($id,$data)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
		
	}

	/*======================================== Konfigurasi BPJS =================================================*/	

	function konfigurasi_bpjs()
	{
		$data['title'] = 'Konfigurasi BPJS';
		$data['data']=$this->Mbpjs->get_data_bpjs();
		$this->load->view("admin/bpjs", $data);
	
	}	

	public function show_bpjs(){
		$result = $this->Mbpjs->get_data_bpjs();
        echo json_encode($result);
	}	
	
	public function show_hide_secid() {
		$user = $this->input->post('user');
		$password = $this->input->post('password');
		$result = $this->Mbpjs->show_hide_secid($user,$password);
        echo json_encode($result);
	}	

	public function update_bpjs() {
		$poli_eksekutif = 0;
		$cob_irj = 0;
		$cob_iri = 0;
		if ($this->input->post('poli_eksekutif') == 1) {
			$poli_eksekutif = 1;
		}
		if ($this->input->post('cob_irj') == 1) {
			$cob_irj = 1;
		}
		if ($this->input->post('cob_iri') == 1) {
			$cob_iri = 1;
		}
		$data_bpjs = array(
			'service_url' => $this->input->post('service_url'),
			'consid' => $this->input->post('consid'),
			'secid' => $this->input->post('secid'),
			'rsid' => $this->input->post('rsid'),
			'poli_eksekutif' => $poli_eksekutif,
			'cob_irj' => $cob_irj,
			'cob_iri' => $cob_iri
        );
		$update = $this->Mbpjs->update_bpjs($data_bpjs);
		echo json_encode($update);
	}	

	/*======================================== KASTEM =================================================*/
	function config()
	{
		$data["title"] = "Kastemisasi Aplikasi";
		$this->load->view('admin/config', $data);
	
	}

	function configSave()
	{
		$data=array(
			'web_title'=>$this->input->post('web_title'),
			'header_title'=>$this->input->post('header_title'),
			'logo_url'=>$this->input->post('userfile'),
			'background'=>$this->input->post('userfile1'),
			'skin'=>$this->input->post('skin'),
			'namars'=>$this->input->post('namars'),
			'namasingkat'=>$this->input->post('namasingkat'),
			'alamat'=>$this->input->post('alamat'),
			'telp'=>$this->input->post('telp'),
			'kota'=>$this->input->post('kota')
		);
		
		//upload logo
		$config['upload_path'] = './asset/images/logos';
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size'] = '2000000';
		$config['max_width'] = '2000';
		$config['max_height'] = '2000';
		$this->upload->initialize($config);
		
		$old_logo = $this->config->item('logo_url');
		
		if(!$this->upload->do_upload()){
			$data['logo_url']=$old_logo;
			//$error = $this->upload->display_errors();
			//echo $error;
		}else{
			$upload = $this->upload->data();
			$data['logo_url']=$upload['file_name'];
		}

		//upload background
		$config['upload_path'] = './asset/images';
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size'] = '4000000';
		$config['max_width'] = '5000';
		$config['max_height'] = '5000';
		$this->upload->initialize($config);
		
		$old_background = $this->config->item('background');
		
		if(!$this->upload->do_upload()){
			$data['background']=$old_background;
			//$error = $this->upload->display_errors();
			//echo $error;
		}else{
			$upload = $this->upload->data();
			$data['background']=$upload['file_name'];
		}
		
		if( $this->Appconfig->batch_save( $data ) )
		{
			//delete old logo
			if ($data['logo_url'] != $old_logo && $old_logo != "logo.png"){
				$file = './asset/images/logos/'.$old_logo;
				if(is_file($file))
					unlink($file);
			}
			if ($data['background'] != $old_background && $old_background != "background.png"){
				$file = './asset/images/'.$old_background;
				if(is_file($file))
					unlink($file);
			}
			redirect(site_url("admin/config"), 'refresh');
		}
		
	}
}

?>