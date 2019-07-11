<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
class FrmCDistribusiLangsung extends Secure_area{

    public function __construct(){
        parent::__construct();
        $this->load->model('logistik_farmasi/Frmmdistribusi','',TRUE);
        $this->load->model('logistik_farmasi/Frmmamprah','',TRUE);
        $this->load->model('master/Mmobat','',TRUE);
        $this->load->helper('pdf_helper');
    }

    public function index(){
        $data['title'] = 'Distribusi Langsung';
        $data['select_gudang0'] = $this->Frmmamprah->get_gudang_asal()->result();
        $data['select_gudang1'] = $this->Frmmamprah->get_gudang_tujuan()->result();
        $data['data_obat']=$this->Mmobat->getAllObat_adaStok()->result();
        $this->load->view('logistik_farmasi/Frmvdistribusilangsung',$data);
    }

    function save(){
        $id_amprah = $this->Frmmamprah->insertDistribusiLangsung($this->input->post()) ;
        if ( $id_amprah != '' ){
            $msg = 	' <div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-check"></i>Data permintaan distribusi berhasil disimpan
					  </div>';
        }else{
            $msg = 	' <div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-ban"></i>Data permintaan distribusi gagal disimpan
					  </div>';
        }
        $this->session->set_flashdata('alert_msg', $msg);
        //$this->cetak_faktur_amprah($id_amprah);
        //$this->session->set_flashdata('cetak', 'cetak('.$id_amprah.');');
        redirect('logistik_farmasi/FrmCDistribusiLangsung');
    }
}