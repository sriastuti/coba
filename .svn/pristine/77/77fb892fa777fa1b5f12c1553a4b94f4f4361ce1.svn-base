<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mcobat extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmobat','',TRUE);
		$this->load->model('farmasi/Frmmdaftar','',TRUE);
		$this->load->model('logistik_farmasi/Frmmpo','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Obat';

		$data['obat']=$this->mmobat->get_all_obat()->result();
		$data['satuan']=$this->mmobat->get_data_satuan()->result();
		$data['kelompok']=$this->mmobat->get_data_kelompok()->result();
		$data['jenis']=$this->mmobat->get_data_jenis()->result();
		$this->load->view('master/mvobat',$data);
		//print_r($data);
	}

	public function insert_obat(){

		$data['nm_obat']=$this->input->post('nm_obat');
		$data['satuank']=$this->input->post('satuank');
		$data['satuanb']=$this->input->post('satuanb');
		$data['faktorsatuan']=$this->input->post('faktorsatuan');
		// $data['hargabeli']=$this->input->post('hargabeli');
		$data['hargajual']=$this->input->post('hargajual');
		$data['kel']=$this->input->post('kel');
		$data['jenis_obat']=$this->input->post('jenis_obat');
		$data['min_stock'] = $this->input->post('minstok');
		//$data['xupdate']=$this->input->post('xupdate');

		$this->mmobat->insert_obat($data);
		
		redirect('master/Mcobat');
		//print_r($data);
	}

	public function get_data_edit_obat(){
		$id_obat=$this->input->post('id_obat');
		$datajson=$this->mmobat->get_data_obat($id_obat)->result();
	    echo json_encode($datajson);
	}

	public function edit_obat(){
		$id_obat=$this->input->post('edit_id_obat_hidden');
		$data['nm_obat']=$this->input->post('edit_nm_obat');
		$data['satuank']=$this->input->post('edit_satuank');
		$data['satuanb']=$this->input->post('edit_satuanb');
		$data['faktorsatuan']=$this->input->post('edit_faktorsatuan');
		// $data['hargabeli']=$this->input->post('edit_hargabeli');
		$data['hargajual']=$this->input->post('edit_hargajual');
		$data['kel']=$this->input->post('edit_kel');
		$data['jenis_obat']=$this->input->post('edit_jenis_obat');
		$data['min_stock'] = $this->input->post('edit_minstok');

		$this->mmobat->edit_obat($id_obat, $data);
		
		redirect('master/Mcobat');
		//print_r($data);
	}

	//kebijakan obat
	public function kebijakan(){
		$data['title'] = 'Kebijakan Obat';

		$data['kebijakan']=$this->mmobat->get_all_kebijakan()->result();
		$this->load->view('master/mvobatkebijakan',$data);
		//print_r($data);
	}

	public function insert_kebijakan(){
		$data['id_kebijakan']=$this->input->post('id_kebijakan');
		$data['keterangan']=$this->input->post('keterangan');
		$data['nilai']=$this->input->post('nilai');
		//$data['xupdate']=$this->input->post('xupdate');

		$this->mmobat->insert_kebijakan($data);
		
		redirect('master/Mcobat/kebijakan');
		//print_r($data);
	}

	public function edit_kebijakan(){
		$id_kebijakan=$this->input->post('edit_id_kebijakan_hidden');
		$data['keterangan']=$this->input->post('edit_keterangan');
		$data['nilai']=$this->input->post('edit_nilai');

		$this->mmobat->edit_kebijakan($id_kebijakan, $data);
		
		redirect('master/Mcobat/kebijakan');
		//print_r($data);
	}

	public function get_data_edit_kebijakan(){
		$id_kebijakan=$this->input->post('id_kebijakan');
		$datajson=$this->mmobat->get_data_kebijakan($id_kebijakan)->result();
	    echo json_encode($datajson);
	}

	function paket_obat(){
	    $data = array(
	        'title' => 'Master Paket Obat',
            'obat' => $this->mmobat->get_paket_obat()->result()
        );

        $this->load->view('master/mvpaketobat', $data);
    }

    public function pengaturan_paket($id_paket){
        $master = $this->mmobat->get_paket_obat_by_id($id_paket)->row();

	    $data = array(
	        'title' => 'Pengaturan Paket Obat - '.$master->nama_paket,
            'id_paket' => $id_paket,
            'obat' => $this->mmobat->get_paket_obat_detail($id_paket)->result()
        );

	    $this->load->view('master/mvpaketobat_detail', $data);
    }

    function save_paket(){
	    $data = array(
	        'nama_paket' => $this->input->post('nama_paket'),
	        'id_dokter' => 1
        );
        $this->mmobat->insert_table('paket_obat', $data);

        $msg = '<div class="alert alert-success alert-dismissible"> <i class="ti-user"></i> Data Berhasil Disimpan!
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    </div>';
        $this->session->set_flashdata('success_msg', $msg);
	    redirect('master/mcobat/paket_obat');
    }

    function hapus_paket(){
        $where = array(
            'id_paket' => $this->input->post('id_paket')
        );

        $save = $this->mmobat->delete_table('paket_obat', $where);

        if($save >= 1){
            $data = array('status' => 'success');
        }else{
            $data = array('status' => 'failed');
        }

        echo json_encode($data);
    }

    function save_paket_obat(){
        $id_paket = $this->input->post('id_paket');
        $data = array(
            'id_paket' => $id_paket,
            'id_obat' => $this->input->post('id_obat'),
            'qty' => $this->input->post('qty')
        );

        $this->mmobat->insert_table('paket_obat_detail', $data);

        $msg = '<div class="alert alert-success alert-dismissible"> <i class="ti-user"></i> Data Berhasil Disimpan!
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    </div>';
        $this->session->set_flashdata('success_msg', $msg);
        redirect('master/mcobat/pengaturan_paket/'.$id_paket);
    }

    function hapus_paket_obat(){
        $where = array(
            'id' => $this->input->post('id')
        );

        $save = $this->mmobat->delete_table('paket_obat_detail', $where);

        if($save >= 1){
            $data = array('status' => 'success');
        }else{
            $data = array('status' => 'failed');
        }

        echo json_encode($data);
    }

    function get_data_paket(){
        $id_obat = $this->input->post('id_paket');
        $datajson = $this->mmobat->get_data_paket($id_obat)->result();
        echo json_encode($datajson);
    }


    function edit_paket(){
        $where = array( 'id_paket' => $this->input->post('edit_id_paket') );
        $data = array( 'nama_paket' => $this->input->post('edit_nama_paket') );
        $this->mmobat->update_table('paket_obat', $data, $where);

        $msg = '<div class="alert alert-success alert-dismissible"> <i class="ti-user"></i> Data Berhasil Diubah!
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    </div>';
        $this->session->set_flashdata('success_msg', $msg);
        redirect('master/mcobat/paket_obat');
    }

    function cari_data_obat(){
	    $login_data = $this->load->get_var("user_info");
	    $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

	    $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
	    $i=1;
	    if(!empty($id_gudang)){
		    foreach ($id_gudang as $row) {
		    	$no_gudang[]=$row->id_gudang;
		    }
		}else{
			$no_gudang[]=2;
		}

	    $userid = $this->session->userid;
	    $group = $this->Frmmpo->getIdGudang($userid);
	    if(!empty($group)){
		    if($group->id_gudang == "8" || $group->id_gudang == "7"){
		    	$ids = "1";
		    }else{
				$ids = join("','",$no_gudang); 
		    }
		}else{
				$ids = join("','",$no_gudang); 
		    }

		$keyword = $this->uri->segment(4);
		$data = $this->db->select('o.`id_obat`, g.`id_inventory`, o.`nm_obat`, o.`hargabeli`, o.`hargajual`, g.`batch_no`, g.`expire_date`, g.`qty`, o.`jenis_obat`, o.`satuank')
				->from('gudang_inventory g')
				->join('master_obat o', 'o.id_obat = g.id_obat', 'inner')
				->where('g.id_gudang', $ids)
				->like('nm_obat',$keyword)->limit(20, 0)->get()->result();
		$arr='';
	    if(!empty($data)){
			foreach($data as $row)
			{

                /** Hitung Selisih Expire Date dengan Tanggal Sekarang, pake DateTime ga Jalan */
                $now = date("Y-m-d");
                $pecah1 = explode("-", $now);
                $date1 = $pecah1[2];
                $month1 = $pecah1[1];
                $year1 = $pecah1[0];

                $pecah2 = explode("-", $row->expire_date);
                $date2 = $pecah2[2];
                $month2 = $pecah2[1];
                $year2 =  $pecah2[0];

                $jd1 = GregorianToJD($month1, $date1, $year1);
                $jd2 = GregorianToJD($month2, $date2, $year2);
                $selisih = $jd2 - $jd1;
                /** --------------------------------------------------------------------------- */
                if($selisih <= 90){ $bg = "Menuju Expired"; }elseif($selisih <= 30){ $bg = "Expired"; }else{ $bg = "$row->expire_date"; }

				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					// 'value'	=> $row->nm_obat." (BATCH-".$row->batch_no.", ED-".$bg.", QTY-".$row->qty.")",
					'value'	=> $row->nm_obat,
					'idobat' => $row->id_obat,
					'idinventory' => $row->id_inventory,
					'nama'	=>$row->nm_obat,
					'harga' => $row->hargajual,
					'hargabeli' => $row->hargabeli,
					'batch_no' => $row->batch_no,
					'expire_date' => $row->expire_date,
					'qty' => $row->qty,
					'jenis_obat' => $row->jenis_obat,
					'satuan' => $row->satuank
				);
			}
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}
}