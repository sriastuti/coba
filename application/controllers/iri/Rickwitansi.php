<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('memory_limit', '-1');
include(dirname(dirname(__FILE__)).'/Tglindo.php');

require_once(APPPATH.'controllers/Secure_area.php');
class Rickwitansi extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/rimpasien');
		$this->load->model('iri/rimkelas');
		$this->load->model('lab/labmdaftar');
		$this->load->model('iri/rimdokter');
		$this->load->model('iri/rimtindakan');
		$this->load->model('iri/rimpendaftaran');
		$this->load->model('iri/rimcara_bayar');
	}

	//keperluan tanggal
	public function obj_tanggal(){
		 $tgl_indo = new Tglindo();
		 return $tgl_indo;
	}

	public function index(){
		$data['title'] = 'Daftar Kwitansi Rawat Inap';
		$data['reservasi']='';
		$data['daftar']='';
		$data['pasien']='active';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		//bikin object buat penanggalan
		$data['controller']=$this;
		$date=$this->input->post('date');
		
		//$data['list_pasien'] = $this->rimpasien->select_pasien_iri_all();
		$data['list_pasien'] = $this->rimpasien->select_pasien_iri_pulang_belum_cetak_kwitansi($date);

		//$this->load->view('iri/rivlink');
		$this->load->view('iri/list_pasien_keluar',$data);
	}

	public function edit_tindakan_kasir($no_ipd=''){

		$login_data = $this->load->get_var("user_info");
		$datarole = $this->labmdaftar->get_roleid($login_data->userid)->result();
		//print_r($datarole);
		foreach ($datarole as $f) {
			if($f->roleid=='1' || $f->roleid=='15' || $f->roleid=='16' || $f->roleid=='26'){
				$access=1;
				break;
			}else{
				$access=0;
			}
		}

		if($access==1){
			$data['title'] = 'Edit Data Tindakan IRI | Kasir | <a href="'.site_url('iri/rickwitansi/detail_kwitansi/'.$no_ipd).'">Kembali</a>';
			$data['reservasi']='';
			$data['daftar']='';
			$data['pasien']='active';
			$data['mutasi']='';
			$data['status']='';
			$data['resume']='';
			$data['kontrol']='';
			$data['linkheader']='rictindakan';
			
			$data['list_tindakan_pasien_real'] = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
			$data['list_tindakan_pasien'] = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd_temp($no_ipd);
			$data['rujukan_penunjang']=$this->rimtindakan->get_rujukan_penunjang($no_ipd)->result();

			$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
			$data['data_pasien'] = $pasien;

			$ruang = $this->rimtindakan->get_ruang_by_no_ipd($no_ipd);

			if($ruang[0]['lokasi']=='Ruang Bersalin'){
				$data['list_tindakan'] = $this->rimtindakan->get_all_tindakan_vk($ruang[0]['kelas']);
			} else if($ruang[0]['lokasi']=='Ruang ICU'){
				$data['list_tindakan'] = $this->rimtindakan->get_all_tindakan_icu($ruang[0]['kelas']);
			}
			else
				$data['list_tindakan'] = $this->rimtindakan->get_all_tindakan($ruang[0]['kelas']);

			$data['list_dokter'] = $this->rimdokter->select_all_data_dokter();
			$login_data = $this->load->get_var("user_info");
			$datarole = $this->labmdaftar->get_roleid($login_data->userid)->result();
			//print_r($datarole);
			foreach ($datarole as $f) {
				if($f->roleid=='1' || $f->roleid=='15' || $f->roleid=='16' || $f->roleid=='26'){
					$data['access']=1;
					break;
				}else{
					$data['access']=0;
				}
			}
			$this->load->view('iri/form_edit_tindakan', $data);
		}else{
			$this->load->view('No_access', $data);
		}
		
	}
	public function all_kwitansi_lunas(){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='';
		$data['pasien']='active';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		//bikin object buat penanggalan
		$data['controller']=$this;
		
		//$data['list_pasien'] = $this->rimpasien->select_pasien_iri_all();
		$data['list_pasien'] = $this->rimpasien->select_pasien_iri_pulang_sudah_cetak_kwitansi();

		$this->load->view('iri/rivlink');
		$this->load->view('iri/list_sudah_cetak_kw',$data);
	}

	public function ubah_cara_bayar(){

		$no_ipd = $this->input->post('no_ipd');
		$pasien_iri['carabayar'] = $this->input->post('carabayar');
		
		$this->rimpendaftaran->update_pendaftaran_mutasi($pasien_iri, $no_ipd);

		echo "1";
	}

	public function detail_kwitansi($no_ipd=''){
		$data['title']='Kwitansi Rawat Inap Pasien | '.$no_ipd;
		$data['reservasi']='';
		$data['daftar']='';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='active';
		$data['resume']='';
		$data['kontrol']='';

		//bikin object buat penanggalan
		$data['controller']=$this; 

		//data pasien
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$pasienold = $this->rimtindakan->get_old_pasien($pasien[0]['noregasal']);
		
		$data['data_pasien'] = $pasien;
		
		//list tidakan, mutasi, dll
		$data['list_tindakan_pasien'] = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		$data['list_mutasi_pasien'] = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		//kalo misalnya dia ada paket, langusn flag paketnya
		$data['status_paket'] = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if(($data_paket)){
			$data['status_paket'] = 1;
		}

		//mutasi ruangan pasien
		$biaya_kamar=0;$jasaperawat=0;
		if ($data['list_mutasi_pasien']) {
			$result = $this->string_table_mutasi_ruangan($data['list_mutasi_pasien'],$pasien,$data['status_paket']);
			$biaya_kamar = $biaya_kamar + $result['subtotal'];
			$jasaperawat = $jasaperawat + $result['jasaperawat'];
			$lamarawat = $result['selisihhari'];
		}

		if($pasien[0]['carabayar']=='UMUM'){
			$data['list_ok_pasien'] = $this->rimpasien->get_list_all_ok_pasien($no_ipd);//get_list_ok_pasien($no_ipd,$pasien[0]['noregasal']);
			$data['list_lab_pasien'] = $this->rimpasien->get_list_lab_pasien_umum($no_ipd);
			$data['list_radiologi'] = $this->rimpasien->get_list_radiologi_pasien_umum($no_ipd);//belum ada no_register
			$data['list_resep'] = $this->rimpasien->get_list_resep_pasien_umum($no_ipd);
			//$data['list_tindakan_ird'] = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
			//$data['poli_irj'] = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);
		}else {
			$data['list_ok_pasien'] = $this->rimpasien->get_list_ok_pasien($no_ipd,$pasien[0]['noregasal']);
			$data['list_pa_pasien'] = $this->rimpasien->get_list_pa_pasien($no_ipd,$pasien[0]['noregasal']);
			$data['list_lab_pasien'] = $this->rimpasien->get_list_lab_pasien($no_ipd,$pasien[0]['noregasal']);
			$data['list_radiologi'] = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$pasien[0]['noregasal']);//belum ada no_register
			$data['list_resep'] = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);
			$data['list_tindakan_ird'] = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
			$data['poli_irj'] = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);
		}
		

		$data['total'] = $this->get_grandtotal_all($no_ipd);
		$data['grand_total'] = $this->get_grandtotal_all($no_ipd);
		//echo $data['grand_total'];
		//buat pembulatan ke atas 500
		$uang = $data['grand_total'];
		$ratusan = substr($uang, -3);
		 if($ratusan % 500 != 0){
		 	$mod = $ratusan % 500;
			$uang = $uang - $mod;
			$uang = $uang + 500;
		 }

		 $data['grand_total_pembulatan'] = $uang;
		 
		 // biaya administrasi 10% dari (biaya total - obat) dgn minimal 50.000
		 //$biaya_administrasi= (double) $data['grand_total'] * 0.1;
		 $biaya_administrasi= 40000*$lamarawat;		
		if($biaya_administrasi<=40000){
			$fix_adm=40000;
		// }else if($biaya_administrasi>=750000 && $pasien[0]['carabayar']=='UMUM'){
		// 	$fix_adm=750000;
		}else{
			$fix_adm=$biaya_administrasi;
		}
		 $data['biaya_administrasi'] = (double) $fix_adm;

		$detailjasa=$this->rimpasien->get_detail_kelas($pasien[0]['kelas'])->row();	
		/*if($pasien[0]['nmruang']!='ICU'){
			$jasa_perawat=(double) $biaya_kamar * ((double)$detailjasa->persen_jasa/100);
		}else $jasa_perawat=(double) $biaya_kamar * ((double)20/100);*/

		$jasa_perawat=$jasaperawat;

		//1B0103
		$detailtind=$this->rimpasien->get_detail_tindakan('1B0101',$pasien[0]['kelas'])->row();		
		//print_r($detailtind);
			//$data['dijamin']=$this->input->post('dijamin');
			// $biaya_daftar=(int) $detailtind->total_tarif+(int)$detailtind->tarif_alkes;

		 // if($data['status_paket'] != 1){
		 // 	$data['biaya_administrasi'] = $data['grand_total'] * 5 / 100;
		 // 	//buat pembulatan ke atas 500
			// // $uang = $data['biaya_administrasi'];
			// // $ratusan = substr($uang, -3);
			// //  if($ratusan % 500 != 0){
			// //  	$mod = $ratusan % 500;
			// // 	$uang = $uang - $mod;
			// // 	$uang = $uang + 500;
			// //  }
			// //  $data['biaya_administrasi'] = $uang;
			//  //kalo kurang dari 75 rebu masukin 75 rebu 
		 // 	 if($data['biaya_administrasi'] < 75000){
		 // 	 	$data['biaya_administrasi'] = 75000;
		 // 	 }
		 // } 

		$data['jasa_perawat'] = $jasa_perawat;
		// $data['biaya_daftar'] = $biaya_daftar;
		 $data['grand_total_pembulatan'] = $data['grand_total_pembulatan'] + $data['biaya_administrasi'] + $jasa_perawat;
		 $data['grand_total'] = $data['grand_total'] + $data['biaya_administrasi'] + $jasa_perawat ;
		 //echo $data['grand_total'];
		//tambah cara bayar
		$data['cara_bayar']=$this->rimcara_bayar->get_all_cara_bayar();



		//$this->load->view('iri/rivlink');
		$this->load->view('iri/list_status_pasien_keluar',$data);
	}

	public function log_detail_kwitansi($no_ipd=''){
		$data['title']='';
		$data['reservasi']='';
		$data['daftar']='';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='active';
		$data['resume']='';
		$data['kontrol']='';

		//bikin object buat penanggalan
		$data['controller']=$this; 

		//data pasien
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data['data_pasien'] = $pasien;
		
		//list tidakan, mutasi, dll
		$data['list_tindakan_pasien'] = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		$data['list_mutasi_pasien'] = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		//kalo misalnya dia ada paket, langusn flag paketnya
		$data['status_paket'] = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if(($data_paket)){
			$data['status_paket'] = 1;
		}

		$data['list_lab_pasien'] = $this->rimpasien->get_list_lab_pasien($no_ipd,$pasien[0]['noregasal']);
		$data['list_radiologi'] = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$pasien[0]['noregasal']);//belum ada no_register
		$data['list_resep'] = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);
		$data['list_tindakan_ird'] = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
		$data['poli_irj'] = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);

		$data['grand_total'] = $this->get_grandtotal_all($no_ipd);
		//buat pembulatan ke atas 500
		$uang = $data['grand_total'];
		$ratusan = substr($uang, -3);
		 if($ratusan % 500 != 0){
		 	$mod = $ratusan % 500;
			$uang = $uang - $mod;
			$uang = $uang + 500;
		 }

		 $data['grand_total_pembulatan'] = $uang;
		 
		 //kalo ga ada paket, biaya administrasi plus 5 persen. dari grandtotal pembulatan.
		 $data['biaya_administrasi'] = 0;

		 if($data['status_paket'] != 1){
		 	$data['biaya_administrasi'] = $data['grand_total'] * 5 / 100;
		 	//buat pembulatan ke atas 500
			// $uang = $data['biaya_administrasi'];
			// $ratusan = substr($uang, -3);
			//  if($ratusan % 500 != 0){
			//  	$mod = $ratusan % 500;
			// 	$uang = $uang - $mod;
			// 	$uang = $uang + 500;
			//  }
			//  $data['biaya_administrasi'] = $uang;
			 //kalo kurang dari 75 rebu masukin 75 rebu 
		 	 if($data['biaya_administrasi'] < 75000){
		 	 	$data['biaya_administrasi'] = 75000;
		 	 }
		 }

		 $data['grand_total_pembulatan'] = $data['grand_total_pembulatan'] + $data['biaya_administrasi'];
		 $data['grand_total'] = $data['grand_total'] + $data['biaya_administrasi'];

		//tambah cara bayar
		$data['cara_bayar']=$this->rimcara_bayar->get_all_cara_bayar();

		//$this->load->view('iri/rivlink');
		$this->load->view('iri/log_list_status_pasien_keluar',$data);
	}

	public function detail_kwitansi_selesai($no_ipd=''){
		$data['title']='';
		$data['reservasi']='';
		$data['daftar']='';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='active';
		$data['resume']='';
		$data['kontrol']='';

		//bikin object buat penanggalan
		$data['controller']=$this; 

		//data pasien
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$pasienold = $this->rimtindakan->get_old_pasien($pasien[0]['noregasal']);
		$data['data_pasien'] = $pasien;
		
		//list tidakan, mutasi, dll
		$data['list_tindakan_pasien'] = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		$data['list_mutasi_pasien'] = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		//kalo misalnya dia ada paket, langusn flag paketnya
		$data['status_paket'] = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if(($data_paket)){
			$data['status_paket'] = 1;
		}

		if($pasienold[0]['cetak_kwitansi']=='1' || $pasienold[0]['tgl_cetak_kw']!=''){
			$data['list_lab_pasien'] = $this->rimpasien->get_list_lab_pasien_umum($no_ipd);
			$data['list_radiologi'] = $this->rimpasien->get_list_radiologi_pasien_umum($no_ipd);//belum ada no_register
			$data['list_resep'] = $this->rimpasien->get_list_resep_pasien_umum($no_ipd);
			$data['list_tindakan_ird'] = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
			$data['poli_irj'] = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);
		}else{
			$data['list_lab_pasien'] = $this->rimpasien->get_list_lab_pasien($no_ipd,$pasien[0]['noregasal']);
			$data['list_radiologi'] = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$pasien[0]['noregasal']);//belum ada no_register
			$data['list_resep'] = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);
			$data['list_tindakan_ird'] = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
			$data['poli_irj'] = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);			
		}
		

		$data['grand_total'] = $this->get_grandtotal_all($no_ipd);
		//buat pembulatan ke atas 500
		$uang = $data['grand_total'];
		$ratusan = substr($uang, -3);
		 if($ratusan % 500 != 0){
		 	$mod = $ratusan % 500;
			$uang = $uang - $mod;
			$uang = $uang + 500;
		 }

		 $data['grand_total_pembulatan'] = $uang;
		 
		 //kalo ga ada paket, biaya administrasi plus 5 persen. dari grandtotal pembulatan.
		 $data['biaya_administrasi'] = 0;

		 if($data['status_paket'] != 1){
		 	$data['biaya_administrasi'] = $data['grand_total_pembulatan'] * 5 / 100;
		 	//buat pembulatan ke atas 500
			$uang = $data['biaya_administrasi'];
			$ratusan = substr($uang, -3);
			 if($ratusan % 500 != 0){
			 	$mod = $ratusan % 500;
				$uang = $uang - $mod;
				$uang = $uang + 500;
			 }
			 $data['biaya_administrasi'] = $uang;
			 //kalo kurang dari 75 rebu masukin 75 rebu 
		 	 if($data['biaya_administrasi'] < 75000){
		 	 	$data['biaya_administrasi'] = 75000;
		 	 }
		 }

		 $data['grand_total_pembulatan'] = $data['grand_total_pembulatan'] + $data['biaya_administrasi'];
		 $data['grand_total'] = $data['grand_total'] + $data['biaya_administrasi'];

		//tambah cara bayar
		$data['cara_bayar']=$this->rimcara_bayar->get_all_cara_bayar();



		//$this->load->view('iri/rivlink');
		$this->load->view('iri/list_status_pasien_keluar_selesai',$data);
	}

		//include modul dari ric status
	public function get_grandtotal_all2($no_ipd){


		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$pasienold = $this->rimtindakan->get_old_pasien($pasien[0]['noregasal']);
		
		//list tidakan, mutasi, dll
		$list_tindakan_dokter_pasien = $this->rimtindakan->get_list_tindakan_dokter_pasien_by_no_ipd($no_ipd);
		$list_tindakan_perawat_pasien = $this->rimtindakan->get_list_tindakan_perawat_pasien_by_no_ipd($no_ipd);
		$list_tindakan_matkes_pasien = $this->rimtindakan->get_list_tindakan_matkes_pasien_by_no_ipd($no_ipd);
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		$list_tind_ok_pasien = $this->rimpasien->get_list_tind_ok_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd,$pasien[0]['noregasal']);
		//mutasi ruangan pasien
		$status_paket = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if(($data_paket)){
			$status_paket = 1;
		}
		//print_r($list_mutasi_pasien);exit;		

		$grand_total = 0;
		$subsidi_total = 0;

		if(($list_mutasi_pasien)){
			$result = $this->string_table_mutasi_ruangan_simple($list_mutasi_pasien,$pasien,$status_paket);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
		}

		//tindakan
		if(($list_tindakan_dokter_pasien)){
			$result = $this->string_table_tindakan_simple($list_tindakan_dokter_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
		}

		if(($list_tindakan_perawat_pasien)){
			$result = $this->string_table_tindakan_simple($list_tindakan_perawat_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
		}

		if(($list_tindakan_matkes_pasien)){
			$result = $this->string_table_tindakan_simple($list_tindakan_matkes_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
		}

			//ok
			if(($list_tind_ok_pasien)){
				$result = $this->string_table_ok_simple($list_tind_ok_pasien);
				$grand_total = $grand_total + $result['subtotal'];
			}

			if(($list_matkes_ok_pasien)){
				$result = $this->string_table_ok_simple($list_matkes_ok_pasien);
				$grand_total = $grand_total + $result['subtotal'];
			}

		if($pasienold[0]['cetak_kwitansi']=='1' || $pasienold[0]['tgl_cetak_kw']!=''){			
			$list_lab_pasien = $this->rimpasien->get_list_lab_pasien_umum($no_ipd);
			$list_radiologi = $this->rimpasien->get_list_radiologi_pasien_umum($no_ipd);//belum ada no_register
			$list_resep = $this->rimpasien->get_list_resep_pasien_umum($no_ipd);
			$list_pa = $this->rimpasien->get_list_pa_pasien_umum($no_ipd);
			//radiologi
			if(($list_radiologi)){
				$result = $this->string_table_radiologi_simple($list_radiologi);
				$grand_total = $grand_total + $result['subtotal'];
				
			}

			//lab
			if(($list_lab_pasien)){
				$result = $this->string_table_lab_simple($list_lab_pasien);
				$grand_total = $grand_total + $result['subtotal'];
			}

			//pa
			if(($list_pa)){
				$result = $this->string_table_pa_simple($list_pa);
				$grand_total = $grand_total + $result['subtotal'];
			}

			//resep
			if(($list_resep)){
				$result = $this->string_table_resep_simple($list_resep);
				$grand_total = $grand_total + $result['subtotal'];
			}

			$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);

			if($pasien[0]['carabayar']=='BPJS'){
				//irj
				if(($poli_irj)){
				$result = $this->string_table_irj_simple($poli_irj);
				$grand_total = $grand_total + $result['subtotal'];
				
				}
			}
		}else{
			//radiologi			
			$list_pa_pasien = $this->rimpasien->get_list_pa_pasien($no_ipd,$pasien[0]['noregasal']);
			$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd,$pasien[0]['noregasal']);
			$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$pasien[0]['noregasal']);//belum ada no_register
			$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);
			$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
			$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);

			if(($list_radiologi)){
				$result = $this->string_table_radiologi_simple($list_radiologi);
				$grand_total = $grand_total + $result['subtotal'];
				
			}

			//lab
			if(($list_lab_pasien)){
				$result = $this->string_table_lab_simple($list_lab_pasien);
				$grand_total = $grand_total + $result['subtotal'];
			}

			

			//pa
			if(($list_pa_pasien)){
				$result = $this->string_table_pa_simple($list_pa_pasien);
				$grand_total = $grand_total + $result['subtotal'];
			}

			//resep
			if(($list_resep)){
				$result = $this->string_table_resep_simple($list_resep);
				$grand_total = $grand_total + $result['subtotal'];
			}			

			if($pasien[0]['carabayar']=='BPJS'){
				//irj
				if(($poli_irj)){
				$result = $this->string_table_irj_simple($poli_irj);
				$grand_total = $grand_total + $result['subtotal'];
				
				}
			}
			
		}
		

		return $grand_total;
	}
	public function get_grandtotal_all($no_ipd){


		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$pasienold = $this->rimtindakan->get_old_pasien($pasien[0]['noregasal']);		

		//list tidakan, mutasi, dll
		$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		$status_paket = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if(($data_paket)){
			$status_paket = 1;
		}
		//print_r($list_mutasi_pasien);exit;				

		$grand_total = 0;
		$subsidi_total = 0;
		//mutasi ruangan pasien
		if(($list_mutasi_pasien)){
			$result = $this->string_table_mutasi_ruangan_simple($list_mutasi_pasien,$pasien,$status_paket);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
		}
		//tindakan
		if(($list_tindakan_pasien)){
			$result = $this->string_table_tindakan_simple($list_tindakan_pasien);
			$grand_total = $grand_total + $result['subtotal_tot'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;	
			//echo $result['subtotal_tot'];
		}

		// if($pasienold[0]['cetak_kwitansi']=='1' || $pasienold[0]['tgl_cetak_kw']!=''){			
		// 	$list_lab_pasien = $this->rimpasien->get_list_lab_pasien_umum($no_ipd);
		// 	$list_radiologi = $this->rimpasien->get_list_radiologi_pasien_umum($no_ipd);//belum ada no_register
		// 	$list_resep = $this->rimpasien->get_list_resep_pasien_umum($no_ipd);
		// 	$list_pa = $this->rimpasien->get_list_pa_pasien_umum($no_ipd);
		// 	//radiologi
		// 	if(($list_radiologi)){ 
		// 		$result = $this->string_table_radiologi_simple($list_radiologi);
		// 		$grand_total = $grand_total + $result['subtotal'];
				
		// 	}

		// 	//lab
		// 	if(($list_lab_pasien)){
		// 		$result = $this->string_table_lab_simple($list_lab_pasien);
		// 		$grand_total = $grand_total + $result['subtotal'];
		// 	}

		// 	//pa
		// 	if(($list_pa)){
		// 		$result = $this->string_table_pa_simple($list_pa);
		// 		$grand_total = $grand_total + $result['subtotal'];
		// 	}

		// 	//resep
		// 	if(($list_resep)){
		// 		$result = $this->string_table_resep_simple($list_resep);
		// 		$grand_total = $grand_total + $result['subtotal'];
		// 	}
		// }else{
			
			//radiologi
			//irj
			if($pasien[0]['carabayar']=='BPJS'){
				$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd,$pasien[0]['noregasal']);
				$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$pasien[0]['noregasal']);
				$list_pa = $this->rimpasien->get_list_pa_pasien($no_ipd,$pasien[0]['noregasal']);
				$list_ok = $this->rimpasien->get_list_ok_pasien($no_ipd,$pasien[0]['noregasal']);
				$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);
				$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
				$poli_irj = $this->rimpasien->get_list_poli_rj_pasien_iri($pasien[0]['noregasal']);
				//ird
			if(($list_tindakan_ird)){
				$result = $this->string_table_ird_simple($list_tindakan_ird);
				$grand_total = $grand_total + $result['subtotal'];
				
			}

				if(($poli_irj)){
					$result = $this->string_table_irj_simple($poli_irj);
					$grand_total = $grand_total + $result['subtotal'];
					
				}
			}else{
				$list_lab_pasien = $this->rimpasien->get_list_all_lab_pasien($no_ipd);
				$list_radiologi = $this->rimpasien->get_list_all_radiologi_pasien($no_ipd);
				$list_pa = $this->rimpasien->get_list_all_pa_pasien($no_ipd);
				$list_ok = $this->rimpasien->get_list_all_ok_pasien($no_ipd);
				$list_resep = $this->rimpasien->get_list_all_resep_pasien($no_ipd);
				
			}

			if(($list_radiologi)){
				$result = $this->string_table_radiologi_simple($list_radiologi);
				$grand_total = $grand_total + $result['subtotal'];
				
			}

			//lab
			if(($list_lab_pasien)){
				$result = $this->string_table_lab_simple($list_lab_pasien);
				$grand_total = $grand_total + $result['subtotal'];
			}

			//pa
			if(($list_pa)){
				$result = $this->string_table_pa_simple($list_pa);
				$grand_total = $grand_total + $result['subtotal'];
			}

			//ok
			if(($list_ok)){
				$result = $this->string_table_ok_simple($list_ok);
				$grand_total = $grand_total + $result['subtotal'];
			}

			//resep
			if(($list_resep)){
				$result = $this->string_table_resep_simple($list_resep);
				$grand_total = $grand_total + $result['subtotal'];
			}

			

			
		// }

		return $grand_total;
	}

//modul cetak laporan simple

		//modul cetak laporan simple

	// private function string_table_mutasi_ruangan_simple($list_mutasi_pasien,$pasien){
	// 	$konten = "";
	// 	$konten= $konten.'
	// 		<tr>
	// 		  <td align="center" >Ruang</td>
	// 		  <td align="center">Kelas</td>
	// 		  <td align="center">Bed</td>
	// 		  <td align="center">Tgl Masuk</td>
	// 		  <td align="center">Tgl Keluar</td>
	// 		  <td align="center">Lama Inap</td>
	// 		  <td align="center">Subsidi</td>
	// 		  <td align="center">Total Biaya</td>
	// 		</tr>
	// 	';
	// 	$subtotal = 0;
	// 	$diff = 1;
	// 	$lama_inap = 0;
	// 	$total_subsidi = 0;
	// 	foreach ($list_mutasi_pasien as $r) {

	// 		$tgl_masuk_rg = date("j F Y", strtotime($r['tglmasukrg']));
	// 		if($r['tglkeluarrg'] != null){
	// 			$tgl_keluar_rg =  date("j F Y", strtotime($r['tglkeluarrg'])) ;
	// 		}else{
	// 			if($pasien[0]['tgl_keluar'] != null){
	// 				$tgl_keluar_rg = date("j F Y", strtotime($pasien[0]['tgl_keluar'])) ;
	// 			}else{
	// 				$tgl_keluar_rg = "-" ;
	// 			}	
	// 		}

	// 		if($r['tglkeluarrg'] != null){
	// 			$start = new DateTime($r['tglmasukrg']);//start
	// 			$end = new DateTime($r['tglkeluarrg']);//end

	// 			$diff = $end->diff($start)->format("%a");
	// 			if($diff == 0){
	// 				$diff = 1;
	// 			}
	// 			$selisih_hari =  $diff." Hari"; 
	// 		}else{
	// 			if($pasien[0]['tgl_keluar'] != NULL){
	// 				$start = new DateTime($r['tglmasukrg']);//start
	// 				$end = new DateTime($pasien[0]['tgl_keluar']);//end

	// 				$diff = $end->diff($start)->format("%a");
	// 				if($diff == 0){
	// 					$diff = 1;
	// 				}
	// 				$selisih_hari =  $diff." Hari";
	// 			}else{
	// 				$start = new DateTime($r['tglmasukrg']);//start
	// 				$end = new DateTime(date("Y-m-d"));//end

	// 				$diff = $end->diff($start)->format("%a");
	// 				if($diff == 0){
	// 					$diff = 1;
	// 				}

	// 				$selisih_hari =  "- Hari";
	// 			}
	// 		}

	// 		//untuk perhitungan subsidi, berdasarkan lama inap
	// 		$lama_inap = $lama_inap + $diff;

	// 		//ambil harga jatah kelas
	// 		// $kelas = $this->rimkelas->get_tarif_ruangan($pasien[0]['jatahklsiri'],$r['idrg']);
	// 		// if(!($kelas)){
	// 		// 	$total_tarif = 0;
	// 		// }else{
	// 		// 	$total_tarif = $kelas[0]['total_tarif'] ;
	// 		// }\
	// 		$total_tarif = $r['harga_jatah_kelas'] ;

	// 		$subsidi_inap_kelas = $diff * $total_tarif ;//harga permalemnya berapa kalo ada jatah kelas
	// 		$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

	// 		$total_per_kamar = $r['vtot'] * $diff;
	// 		$subtotal = $subtotal + $total_per_kamar;
	// 		$konten = $konten. "
	// 		<tr>
	// 			<td align=\"center\">".$r['nmruang']."</td>
	// 			<td align=\"center\">".$r['kelas']."</td>
	// 			<td align=\"center\">".$r['bed']."</td>
	// 			<td align=\"center\">".$tgl_masuk_rg."</td>
	// 			<td align=\"center\">".$tgl_keluar_rg."</td>
	// 			<td align=\"center\">".$selisih_hari."</td>
	// 			<td align=\"center\">Rp. ".number_format($subsidi_inap_kelas,0)."</td>
	// 			<td align=\"right\">Rp. ".number_format($total_per_kamar-$subsidi_inap_kelas,0)."</td>
	// 		</tr>
	// 		";
	// 	}

	// 	$result = array('konten' => $konten,
	// 				'subtotal' => $subtotal,
	// 				'subsidi' => $total_subsidi);
	// 	return $result;
	// }

	private function string_table_mutasi_ruangan_simple($list_mutasi_pasien,$pasien,$status_paket){
		$konten = "";
		$konten= $konten.'
			<tr>
			  <td align="center" >Ruang</td>
			  <td align="center">Kelas</td>
			  <td align="center">Bed</td>
			  <td align="center">Tgl Masuk</td>
			  <td align="center">Tgl Keluar</td>
			  <td align="center">Lama Inap</td>
			  <td align="center">Total Biaya</td>
			</tr>
		';
		$subtotal = 0;
		$diff = 1;
		$lama_inap = 0;
		$total_subsidi = 0;
		$tgl_indo = new Tglindo();

		foreach ($list_mutasi_pasien as $r) {

			$bulan_show = $tgl_indo->bulan(substr($r['tglmasukrg'],6,2));
			$tahun_show = substr($r['tglmasukrg'],0,4);
			$tanggal_show = substr($r['tglmasukrg'],8,2);
			$tgl_masuk_rg = $tanggal_show." ".$bulan_show." ".$tahun_show;

			//$tgl_masuk_rg = date("j F Y", strtotime($r['tglmasukrg']));
			if($r['tglkeluarrg'] != null){
				//$tgl_keluar_rg =  date("j F Y", strtotime($r['tglkeluarrg'])) ;

				$bulan_show = $tgl_indo->bulan(substr($r['tglkeluarrg'],6,2));
				$tahun_show = substr($r['tglkeluarrg'],0,4);
				$tanggal_show = substr($r['tglkeluarrg'],8,2);
				$tgl_keluar_rg = $tanggal_show." ".$bulan_show." ".$tahun_show;

			}else{
				if($pasien[0]['tgl_keluar'] != null){
					//$tgl_keluar_rg = date("j F Y", strtotime($pasien[0]['tgl_keluar'])) ;

					$bulan_show = $tgl_indo->bulan(substr($pasien[0]['tgl_keluar'],6,2));
					$tahun_show = substr($pasien[0]['tgl_keluar'],0,4);
					$tanggal_show = substr($pasien[0]['tgl_keluar'],8,2);
					$tgl_keluar_rg = $tanggal_show." ".$bulan_show." ".$tahun_show;

				}else{
					$tgl_keluar_rg = "-" ;
				}	
			}

			if($r['tglkeluarrg'] != null){
				$start = new DateTime($r['tglmasukrg']);//start
				$end = new DateTime($r['tglkeluarrg']);//end

				$diff = $end->diff($start)->format("%a");
				if($diff == 0){
					$diff = 1;
				}
				$selisih_hari =  $diff." Hari"; 
			}else{
				if($pasien[0]['tgl_keluar'] != NULL){
					$start = new DateTime($r['tglmasukrg']);//start
					$end = new DateTime($pasien[0]['tgl_keluar']);//end

					$diff = $end->diff($start)->format("%a");
					if($diff == 0){
						$diff = 1;
					}
					$selisih_hari =  $diff." Hari";
				}else{
					$start = new DateTime($r['tglmasukrg']);//start
					$end = new DateTime(date("Y-m-d"));//end

					$diff = $end->diff($start)->format("%a");
					if($diff == 0){
						$diff = 1;
					}

					$selisih_hari =  "- Hari";
				}
			}

			//untuk perhitungan subsidi, berdasarkan lama inap
			$lama_inap = $lama_inap + $diff;

			//ambil harga jatah kelas
			// $kelas = $this->rimkelas->get_tarif_ruangan($pasien[0]['jatahklsiri'],$r['idrg']);
			// if(!($kelas)){
			// 	$total_tarif = 0;
			// }else{
			// 	$total_tarif = $kelas[0]['total_tarif'] ;
			// }\
			$total_tarif = $r['harga_jatah_kelas'] ;

			$subsidi_inap_kelas = $diff * $total_tarif ;//harga permalemnya berapa kalo ada jatah kelas
			$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

			//kalo paket 2 hari inep free
			/*if($status_paket == 1){
				$temp_diff = $diff - 2;//kalo ada paket free 2 hari
				if($temp_diff < 0){
					$temp_diff = 0;
				}
				$total_per_kamar = $r['vtot'] * $temp_diff;
			}else{*/
				$total_per_kamar = $r['vtot'] * $diff;
			//}

			$subtotal = $subtotal + $total_per_kamar;
			$konten = $konten. "
			<tr>
				<td align=\"center\">".$r['nmruang']."</td>
				<td align=\"center\">".$r['kelas']."</td>
				<td align=\"center\">".$r['bed']."</td>
				<td align=\"center\">".$tgl_masuk_rg."</td>
				<td align=\"center\">".$tgl_keluar_rg."</td>
				<td align=\"center\">".$selisih_hari."</td>
				<td align=\"right\">Rp. ".number_format($total_per_kamar,0)."</td>
			</tr>
			";
		}

		$result = array('konten' => $konten,
					'subtotal' => $subtotal,
					'subsidi' => $total_subsidi);
		return $result;
	}

	private function string_table_tindakan_simple($list_tindakan_pasien){
		$konten = "";
		
		$subtotal = 0;
		$subtotal_tot = 0;
		$subtotal_alkes=0;
		$subtotal_jth_kelas = 0;
		foreach ($list_tindakan_pasien as $r) {
			$subtotal_tot = $subtotal_tot+(($r['tumuminap'] + $r['tarifalkes'])*$r['qtyyanri']);
			$subtotal = $subtotal + $r['vtot'];
			$subtotal_alkes = $subtotal_alkes + $r['tarifalkes'];
			$tumuminap = number_format($r['tumuminap'],0);
			$vtot = number_format($r['vtot'],0);

			$subtotal_jth_kelas = $subtotal_jth_kelas + $r['vtot_jatah_kelas'];
			$harga_satuan_jatah_kelas = number_format($r['harga_satuan_jatah_kelas'],0);
			$vtot_jatah_kelas = number_format($r['vtot_jatah_kelas'],0);
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" >Subtotal Tindakan Rawat Inap</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		$result = array('konten' => $konten,
					'subtotal_tot' => $subtotal_tot,
					'subtotal' => $subtotal,
					'subtotal_alkes' => $subtotal_alkes,
					'subsidi' => $subtotal_jth_kelas);
		return $result;
	}

	private function string_table_radiologi_simple($list_radiologi){
		$konten = "";
		$subtotal = 0;
		foreach ($list_radiologi as $r) {
			$subtotal = $subtotal + $r['vtot'];
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="left">Subtotal Radiologi</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table> <br><br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_lab_simple($list_lab_pasien){
		$konten = "";
		$subtotal = 0;
		// print_r($list_lab_pasien);
		foreach ($list_lab_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_lab = number_format($r['biaya_lab'],0);
			$vtot = number_format($r['vtot'],0);
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="left">Subtotal Laboratorium</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
	
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_pa_simple($list_pa_pasien){
		$konten = "";
		$subtotal = 0;
		foreach ($list_pa_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_pa = number_format($r['biaya_pa'],0);
			$vtot = number_format($r['vtot'],0);
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="left">Subtotal Patologi Anatomi</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
	
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_ok_simple($list_ok_pasien){
		$konten = "";
		$subtotal = 0;
		foreach ($list_ok_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_ok = number_format($r['biaya_ok'],0);
			$vtot = number_format($r['vtot'],0);
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="left">Subtotal Operasi</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
	
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_resep_simple($list_resep){
		$konten = "";
		
		$subtotal = 0;
		foreach ($list_resep as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$vtot = number_format($r['vtot'],0) ;
			
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="left">Subtotal Obat</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_ird_simple($list_tindakan_ird){
		$konten = "";
		
		$subtotal = 0;
		foreach ($list_tindakan_ird as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_ird = number_format($r['biaya_ird'],0);
			$vtot = number_format($r['vtot'],0);
			
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="left">Subtotal Rawat Darurat</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_irj_simple($poli_irj){
		$konten = "";
		
		$subtotal = 0;
		foreach ($poli_irj as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_tindakan = number_format($r['biaya_tindakan'],0);
			$vtot = number_format($r['vtot'],0);
			
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" >Subtotal Rawat Jalan</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';

		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}
	//end modul cetak laporan simple

	public function cetak_list_pembayaran_pasien($no_ipd=''){
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		
		
		//list tidakan, mutasi, dll
		$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$pasien[0]['noregasal']);//belum ada no_register
		$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
		$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);

		$nama_pasien = str_replace(" ","_",$pasien[0]['nama']);
		$file_name = "pembayaran_".$pasien[0]['no_ipd']."_".$nama_pasien.".pdf";
		$konten = "<table style=\"padding:4px;\" border=\"0\">
						<tr>
							<td>
								<p align=\"center\">
									<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\" >
								</p>
							</td>
						</tr>
					</table>
					<hr><br/><br/>";


		$konten = $konten.$this->string_data_pasien($pasien,0,'');

		$grand_total = 0;
		//mutasi ruangan pasien
		if(($list_mutasi_pasien)){
			$result = $this->string_table_mutasi_ruangan($list_mutasi_pasien,$pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten.$result['konten'];
		}


		//tindakan
		if(($list_tindakan_pasien)){
			$result = $this->string_table_tindakan($list_tindakan_pasien);
			$grand_total = $grand_total + $result['subtotal'];

			$konten = $konten.$result['konten'];
			//print_r($konten);exit;
		}

		//radiologi
		if(($list_radiologi)){
			$result = $this->string_table_radiologi($list_radiologi);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten.$result['konten'];
		}

		//lab
		if(($list_lab_pasien)){
			$result = $this->string_table_lab($list_lab_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten.$result['konten'];
		}

		//resep
		if(($list_resep)){
			$result = $this->string_table_resep($list_resep);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten.$result['konten'];
		}

		//ird
		if(($list_tindakan_ird)){
			$result = $this->string_table_ird($list_tindakan_ird);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten.$result['konten'];
		}

		//irj
		if(($poli_irj)){
			$result = $this->string_table_irj($poli_irj);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten.$result['konten'];
		}

		$grand_total_string = '
		<table border="1">
			<tr>
				<td colspan="6" align="center">Grand Total</td>
				<td align="right">Rp. '.number_format($grand_total,0).'</td>
			</tr>
		</table>
		';

		$konten = $konten.$grand_total_string;

		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "Rekap Biaya Rawat Inap - ".$no_ipd." - ".$pasien[0]['nama'];
		$tgl_cetak = date("j F Y");
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, 'Tanggal Cetak - '.$tgl_cetak);
		$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '20', PDF_MARGIN_RIGHT);
		$obj_pdf->SetAutoPageBreak(TRUE, '15');
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
			$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'/download/inap/laporan/pembayaran/'.$file_name, 'FI');
	}

	//modul cetak laporan detail
	//end modul cetak laporan simple

	public function log_kwitansi(){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='';
		$data['pasien']='active';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		//bikin object buat penanggalan
		$data['controller']=$this;
		
		//$data['list_pasien'] = $this->rimpasien->select_pasien_iri_all();
		$data['list_pasien'] = $this->rimpasien->select_pasien_iri_pulang_sudah_cetak_kwitansi();

		$this->load->view('iri/rivlink');
		$this->load->view('iri/log_list_pasien_keluar',$data);
	}

	private function string_table_mutasi_ruangan($list_mutasi_pasien,$pasien,$status_paket){
		$konten = "";
		$konten= $konten.'
		<table border="1">
			<tr>
			  <td align="center" >Ruang</td>
			  <td align="center">Kelas</td>
			  <td align="center">Bed</td>
			  <td align="center">Tgl Masuk</td>
			  <td align="center">Tgl Keluar</td>
			  <td align="center">Lama Inap</td>
			  <td align="center">Total Biaya</td>
			</tr>
		';
		$subtotal = 0;
		$diff = 1;
		$total_subsidi = 0;
		$jasaperawat=0;$ceknull=0;
		foreach ($list_mutasi_pasien as $r) {
			$tgl_masuk_rg = date("j F Y", strtotime($r['tglmasukrg']));
			if($r['tglkeluarrg'] != null){
				$tgl_keluar_rg =  date("j F Y", strtotime($r['tglkeluarrg'])) ;
			}else{
				if($pasien[0]['tgl_keluar'] != null){
					$tgl_keluar_rg = date("j F Y", strtotime($pasien[0]['tgl_keluar'])) ;
				}else{
					$tgl_keluar_rg = "-" ;
				}	
			}
			if($r['tglkeluarrg'] != null){
				$start = new DateTime($r['tglmasukrg']);//start
				$end = new DateTime($r['tglkeluarrg']);//end

				$diff = $end->diff($start)->format("%a");
				if($diff == 0){
					$diff = 1;
				}
				$selisih_hari =  $diff." Hari"; 
			}else{
				if($pasien[0]['tgl_keluar'] != NULL){
					$start = new DateTime($r['tglmasukrg']);//start
					$end = new DateTime($pasien[0]['tgl_keluar']);//end

					$diff = $end->diff($start)->format("%a");
					if($diff == 0){
						$diff = 1;
					}
					$selisih_hari =  $diff." Hari";
				}else{
					$start = new DateTime($r['tglmasukrg']);//start
					$end = new DateTime();//end

					$diff = $end->diff($start)->format("%a");
					if($diff == 0){
						$diff = 1;
					}
					$selisih_hari =  $diff." Hari";
					//$selisih_hari =  "- Hari";
				}
			}

			if(strpos($r['nmruang'],'Bersalin')==false){
				$jasaperawat=$jasaperawat+$r['jasa_perawat'];
			}
			if($r['tglkeluarrg']==null || $r['tglkeluarrg']==''){
				$ceknull=1;
			}			

			$total_tarif = $r['harga_jatah_kelas'] ;
			$subsidi_inap_kelas = $diff * $total_tarif ;//harga permalemnya berapa kalo ada jatah kelas
			$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

			//$total_per_kamar = $r['vtot'] * $diff;

			/*if($status_paket == 1){
				$temp_diff = $diff - 2;//kalo ada paket free 2 hari
				if($temp_diff < 0){
					$temp_diff = 0;
				}
				$total_per_kamar = $r['vtot'] * $temp_diff;
			}else{*/
				$total_per_kamar = $r['vtot'] * $diff;
			//}

			$subtotal = $subtotal + $total_per_kamar;

			$konten = $konten. "
			<tr>
				<td align=\"center\">".$r['nmruang']."</td>
				<td align=\"center\">".$r['kelas']."</td>
				<td align=\"center\">".$r['bed']."</td>
				<td align=\"center\">".$tgl_masuk_rg."</td>
				<td align=\"center\">".$tgl_keluar_rg."</td>
				<td align=\"center\">".$selisih_hari."</td>
				<td align=\"right\">Rp. ".number_format($total_per_kamar,0)."</td>
			</tr>
			";
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" align="center">Subtotal</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table> <br><br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal,
					'jasaperawat' => $jasaperawat,
					'ceknull' => $ceknull,
					'selisihhari' => $diff	);
		return $result;
	}

	public function balikan_keruangan($no_ipd){
		$this->rimpasien->balikkan_keruangan($no_ipd);
		redirect('iri/rickwitansi', 'refresh');
	}
}
