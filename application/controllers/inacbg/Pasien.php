<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class Pasien extends Secure_area {
  public $xuser;
	public function __construct() {
			parent::__construct();
      $this->load->model('inacbg/M_pasien','',TRUE);	
      $this->load->model('inacbg/M_inacbg','',TRUE); 
      $this->xuser = $this->load->get_var("user_info");  			
	}

  public function index() {        
      $data['title'] = 'Cari Pasien';
      $this->load->view('inacbg/pasien',$data);        
  }

  public function get_pelayanan(){
    $data_klaim=$this->M_pasien->get_pelayanan();
    $data = array();
    $no = $_POST['start'];
    foreach ($data_klaim as $klaim) {
        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $klaim->no_register;            
        if ($klaim->tgl_kunjungan == NULL || $klaim->tgl_kunjungan == '0000-00-00') {
          $row[] = '';
        } else $row[] = date('d-m-Y',strtotime($klaim->tgl_kunjungan)); 
        if ($klaim->tgl_pulang == NULL || $klaim->tgl_pulang == '0000-00-00') {
          $row[] = '';
        } else $row[] = date('d-m-Y',strtotime($klaim->tgl_pulang));           
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
      "recordsTotal" => $this->M_pasien->count_pelayanan(),
      "recordsFiltered" => $this->M_pasien->filtered_pelayanan(),
      "data" => $data
    );
    echo json_encode($output);
  }

  public function pelayanan($no_register='') {
    if ($no_register == '') {
      redirect('inacbg/pasien');
    } else {
      if (substr($no_register, 0,2) == 'RJ') {
        $data['coder_nik'] = $this->xuser->coder_nik;       
        $data['no_register'] = $no_register;
        $data['data_pasien'] = $this->M_pasien->show_pelayanan_irj($no_register);               
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
        $this->load->view('inacbg/klaim_irj',$data); 
      } else if (substr($no_register, 0,2) == 'RI') {

      } else {
        $notification = '<div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                              <h3 class="text-danger"><i class="fa fa-ban"></i> Data tidak ditemukan.</h3> Data Pasien dengan No. Registrasi '.$no_register.' Tidak Ditemukan.
                          </div>';
        $this->session->set_flashdata('notification', $notification);     
        redirect('inacbg/pasien');  
      }
    }   
  }

  function get_autocomplete(){    
      if (isset($_GET['term'])){
        $q = strtolower($_GET['term']);
        $this->M_pasien->get_autocomplete($q);
      }
  }

  public function tarif_rs($no_register='')
  {                                         
      $result = $this->M_pasien->get_tarif_rs($no_register);
      echo json_encode($result);
  }	

  public function save_tarif_rs()
  { 
      $no_register = $this->input->post('no_register');
      $data_update = array(               
        'tarif_prosedur_non_bedah' => $this->input->post('prosedur_non_bedah'), 
        'tarif_prosedur_bedah' => $this->input->post('prosedur_bedah'), 
        'tarif_konsultasi' => $this->input->post('konsultasi'), 
        'tarif_tenaga_ahli' => $this->input->post('tenaga_ahli'), 
        'tarif_keperawatan' => $this->input->post('keperawatan'), 
        'tarif_penunjang' => $this->input->post('penunjang'), 
        'tarif_radiologi' => $this->input->post('radiologi'), 
        'tarif_laboratorium' => $this->input->post('laboratorium'), 
        'tarif_pelayanan_darah' => $this->input->post('pelayanan_darah'), 
        'tarif_rehabilitasi' => $this->input->post('rehabilitasi'), 
        'tarif_kamar' => $this->input->post('kamar'), 
        'tarif_rawat_intensif' => $this->input->post('rawat_intensif'), 
        'tarif_obat' => $this->input->post('obat'), 
        'tarif_alkes' => $this->input->post('alkes'), 
        'tarif_bmhp' => $this->input->post('bmhp'), 
        'tarif_sewa_alat' => $this->input->post('sewa_alat')
      );
      $result = $this->M_pasien->update_tarif_rs($no_register,$data_update);
      echo json_encode($result);
  }      		
}
?>
