<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Radcpengisianhasil extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('lab/labmdaftar','',TRUE);
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->model('irj/rjmpelayanan','',TRUE);
		$this->load->model('rad/radmdaftar','',TRUE);
		$this->load->model('rad/radmkwitansi','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index(){
		$data['title'] = 'Diagnostik Tanggal '.date('d-m-Y');

		$data['radiologi']=$this->radmdaftar->get_hasil_rad()->result();
		$this->load->view('rad/radvdaftarpengisian',$data);
	}

	public function by_date(){
		$date=$this->input->post('date');
		$data['title'] = 'Diagnostik Tanggal '.date('d-m-Y',strtotime($date));

		$data['radiologi']=$this->radmdaftar->get_hasil_rad_by_date($date)->result();
		$this->load->view('rad/radvdaftarpengisian',$data);
	}

	public function by_no(){
		$key=$this->input->post('key');
		$data['title'] = 'Diagnostik | '.$key;

		$data['radiologi']=$this->radmdaftar->get_hasil_rad_by_no($key)->result();
		$this->load->view('rad/radvdaftarpengisian',$data);
	}

	public function daftar_hasil($no_rad=''){
		$data['title'] = 'Diagnostik';
		$data['no_rad']=$no_rad;
		$no_register=$this->radmdaftar->get_no_register($no_rad)->row()->no_register;
		$data['no_register']=$no_register;
		if(substr($no_register, 0,2)=="PL"){
			$data['data_pasien_pemeriksaan']=$this->radmdaftar->get_data_hasil_pemeriksaan_pasien_luar($no_rad)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['alamat']=$row->alamat;
				$data['dokter_rujuk']=$row->dokter;
				$data['no_cm']='-';
				$data['no_medrec']='-';
				$data['kelas_pasien']='III';
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']='-';
				$data['bed']='-';
				$data['cara_bayar']=$row->cara_bayar;
				$data['nmkontraktor']='';
				// $data['waktu_masuk_rad']='';
			}
		}else{
			$data['data_pasien_pemeriksaan']=$this->radmdaftar->get_data_hasil_pemeriksaan($no_rad)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['no_cm']=$row->no_cm;
				$data['no_medrec']=$row->no_medrec;
				$data['kelas_pasien']=$row->kelas;
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']=$row->idrg;
				$data['bed']=$row->bed;
				$data['cara_bayar']=$row->cara_bayar;
				
				if($row->foto==NULL){
					$data['foto']='unknown.png';
				}else {
					$data['foto']=$row->foto;
				}
			}
			if(substr($no_register, 0,2)=="RJ"){
				$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				// $data['waktu_masuk_rad']=$data['data_pasien_daftar_ulang']->waktu_masuk_rad;
				if($data['cara_bayar']=='DIJAMIN'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else $data['nmkontraktor']='';
				$data['bed']='Rawat Jalan';
				$data['kelas_pasien']='II';
			}else if (substr($no_register, 0,2)=="RI"){
				// $data['waktu_masuk_rad']='';
				if($data['cara_bayar']=='DIJAMIN'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;	
				}else $data['nmkontraktor']='';			
			}
		}

		$data['daftarpengisian']=$this->radmdaftar->get_data_pengisian_hasil($no_rad)->result();

		$this->load->view('rad/radvdaftarhasil',$data);
	}

	public function isi_hasil($id_pemeriksaan_rad=''){
		$data['title'] = 'Radiologi';
		$data['id_pemeriksaan_rad'] = $id_pemeriksaan_rad;

		$nr=$this->radmdaftar->get_row_register($id_pemeriksaan_rad)->result();
		foreach($nr as $row){
			$no_register=$row->no_register;
		}

		if(substr($no_register, 0,2)=="PL"){
			$data['data_pasien_pemeriksaan']=$this->radmdaftar->get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_rad)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['alamat']=$row->alamat;
				$data['dokter_rujuk']=$row->dokter;
				$data['no_register']=$no_register;
				$data['no_cm']='-';
				$data['no_medrec']='-';
				$data['kelas_pasien']='III';
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']='-';
				$data['bed']='-';
				$data['cara_bayar']=$row->cara_bayar;
				$data['no_rad']=$row->no_rad;
				$data['id_tindakan']=$row->id_tindakan;
				$data['jenis_tindakan']=$row->jenis_tindakan;
				$data['nmkontraktor']='';
				// $data['waktu_masuk_rad']='';
			}
		}else{
			$data['data_pasien_pemeriksaan']=$this->radmdaftar->get_data_isi_hasil_pemeriksaan($id_pemeriksaan_rad)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['no_cm']=$row->no_cm;
				$data['no_medrec']=$row->no_medrec;
				$data['no_register']=$no_register;
				$data['id_tindakan']=$row->id_tindakan;
				$data['jenis_tindakan']=$row->jenis_tindakan;
				$data['kelas_pasien']=$row->kelas;
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']=$row->idrg;
				$data['bed']=$row->bed;
				$data['cara_bayar']=$row->cara_bayar;
				$data['no_rad']=$row->no_rad;
				if($row->foto==NULL){
					$data['foto']='unknown.png';
				}else {
					$data['foto']=$row->foto;
				}
				$data['nmkontraktor']='';
			}
			if(substr($no_register, 0,2)=="RJ"){
				$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				// $data['waktu_masuk_rad']=$data['data_pasien_daftar_ulang']->waktu_masuk_rad;
				if($data['cara_bayar']=='DIJAMIN'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else $data['nmkontraktor']='';
				$data['bed']='Rawat Jalan';
				$data['kelas_pasien']='II';
			}else if (substr($no_register, 0,2)=="RI"){
				// $data['waktu_masuk_rad']='';
				if($data['cara_bayar']=='DIJAMIN'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;	
				}else $data['nmkontraktor']='';			
			}
		}

		$data['jenis_tindakan']=$this->radmdaftar->get_data_tindakan_rad_id($id_pemeriksaan_rad)->row()->jenis_tindakan;
		$data['dokter_rad']=$this->radmdaftar->getdata_dokter()->result();
		
		$this->load->view('rad/radvisihasil',$data);
	}

	public function edit_hasil($id_pemeriksaan_rad=''){
		$data['title'] = 'Diagnostik';
		$data['id_pemeriksaan_rad'] = $id_pemeriksaan_rad;

		$no_register=$this->radmdaftar->get_row_register($id_pemeriksaan_rad)->row()->no_register;

		if(substr($no_register, 0,2)=="PL"){
			$data['data_pasien_pemeriksaan']=$this->radmdaftar->get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_rad)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['alamat']=$row->alamat;
				$data['dokter_rujuk']=$row->dokter;
				$data['no_register']=$no_register;
				$data['no_cm']='-';
				$data['no_medrec']='-';
				$data['kelas_pasien']='III';
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']='-';
				$data['bed']='-';
				$data['cara_bayar']=$row->cara_bayar;
				$data['no_rad']=$row->no_rad;
				$data['id_tindakan']=$row->id_tindakan;
				$data['jenis_tindakan']=$row->jenis_tindakan;
				$data['hasil_periksa']=$row->hasil_periksa;
				$data['hasil_dokter']=$row->hasil_dokter;
				$data['gambar_hasil']=$row->gambar_hasil;
				$data['nmkontraktor']='';
				// $data['waktu_masuk_rad']='';
			}
		}else{
			$data['data_pasien_pemeriksaan']=$this->radmdaftar->get_data_isi_hasil_pemeriksaan($id_pemeriksaan_rad)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['no_medrec']=$row->no_medrec;
				$data['no_cm']=$row->no_cm;
				$data['no_register']=$no_register;
				$data['id_tindakan']=$row->id_tindakan;
				$data['jenis_tindakan']=$row->jenis_tindakan;
				$data['kelas_pasien']=$row->kelas;
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']=$row->idrg;
				$data['bed']=$row->bed;
				$data['cara_bayar']=$row->cara_bayar;
				$data['no_rad']=$row->no_rad;
				$data['hasil_periksa']=$row->hasil_periksa;
				$data['hasil_dokter']=$row->hasil_dokter;
				$data['gambar_hasil']=$row->gambar_hasil;
				$data['id_hasil_rad']=$row->id_hasil_rad;
				$data['id_dokter_1']=$row->id_dokter_1;
				$data['hasil_1']=$row->hasil_1;
				$data['id_dokter_2']=$row->id_dokter_2;
				$data['hasil_2']=$row->hasil_2;
				$data['id_dokter_3']=$row->id_dokter_3;
				$data['hasil_3']=$row->hasil_3;
				$data['id_dokter_4']=$row->id_dokter_4;
				$data['hasil_4']=$row->hasil_4;
				$data['id_dokter_5']=$row->id_dokter_5;
				$data['hasil_5']=$row->hasil_5;
				$data['hasil_pengirim']=$row->hasil_pengirim;
				if($row->foto==NULL){
					$data['foto']='unknown.png';
				}else {
					$data['foto']=$row->foto;
				}
			}
			if(substr($no_register, 0,2)=="RJ"){
				$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
				// $data['waktu_masuk_rad']=$data['data_pasien_daftar_ulang']->waktu_masuk_rad;
				if($data['cara_bayar']=='DIJAMIN'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else $data['nmkontraktor']='';
				$data['bed']='Rawat Jalan';
				$data['kelas_pasien']='II';
			}else if (substr($no_register, 0,2)=="RI"){
				// $data['waktu_masuk_rad']='';
				if($data['cara_bayar']=='DIJAMIN'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;	
				}else $data['nmkontraktor']='';			
			}
		}

		$data['dokter_rad']=$this->radmdaftar->getdata_dokter()->result();
		//$data['get_data_edit_tindakan_rad']=$this->radmdaftar->get_data_edit_tindakan_rad($data['id_tindakan'],$data['no_rad'])->result();
		
		$this->load->view('rad/radvedithasil',$data);
	}

	public function simpan_hasil(){
		$id_pemeriksaan_rad=$this->input->post('id_pemeriksaan_rad');
		$no_rad=$this->input->post('no_rad');
		$no_register=$this->input->post('no_register');

		$data['id_pemeriksaan_rad']=$id_pemeriksaan_rad;
		$data['id_dokter_1']=$this->input->post('id_dokter_1');
		$data['hasil_1']=$this->input->post('hasil_1');
		$data['id_dokter_2']=$this->input->post('id_dokter_2');
		$data['hasil_2']=$this->input->post('hasil_2');
		$data['id_dokter_3']=$this->input->post('id_dokter_3');
		$data['hasil_3']=$this->input->post('hasil_3');
		$data['id_dokter_4']=$this->input->post('id_dokter_4');
		$data['hasil_4']=$this->input->post('hasil_4');
		$data['id_dokter_5']=$this->input->post('id_dokter_5');
		$data['hasil_5']=$this->input->post('hasil_5');
		$data['hasil_pengirim']=$this->input->post('hasil_pengirim');
		$this->radmdaftar->isi_hasil($data);

		//Upload
		$filesCount = count($_FILES['userFiles']['name']);
        for($i = 0; $i < $filesCount; $i++){
            // $data_rand = rand();
            $ext = end((explode("/", $_FILES['userFiles']['type'][$i]))); # extra () to prevent notice
            // echo $ext;
	        $date = new DateTime();

	        $timeStampData = microtime();
			list($msec, $sec) = explode(' ', $timeStampData);
			$msec = round($msec * 1000);

			$result = $sec . $msec;

            $fileName = str_replace(' ', '_', $no_register."-".$id_pemeriksaan_rad."~".$result.".".$ext);
            $_FILES['userFile']['name'] = $fileName;
            $_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
            $_FILES['userFile']['tmp_name'] = str_replace(' ', '_', $_FILES['userFiles']['tmp_name'][$i]);
            $_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
            $_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];

            $uploadPath = './upload/radgambarhasil/'; 
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if($this->upload->do_upload('userFile')){
                $fileData = $this->upload->data();
                $uploadData[$i]['name'] = $fileName;
	            // $uploadData[$i]['token'] = $data_rand;
                $uploadData[$i]['id_pemeriksaan_rad'] = $id_pemeriksaan_rad;
            }else{
             	$error = $this->upload->display_errors();
			 	echo $error;
            }
			// echo $fileName."<br>";
            // echo $i.'<br>';
        }
        
        if(!empty($uploadData)){
			// insert tahap_1_detail
			// printf('<br><br> uploadData: '.json_encode($uploadData));
            $insert = $this->radmdaftar->insert_file_hasil($uploadData);
            $statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
            $this->session->set_flashdata('statusMsg',$statusMsg);

            echo $statusMsg;
            echo json_encode($uploadData);
        }else{
        	echo "gagal";
            echo json_encode($uploadData);
        }
		

		// $data2['waktu_keluar_rad']=date('Y-m-d H:i:s');
		// $id=$this->rjmpelayanan->update_rujukan_penunjang($data2,$no_register);		
		redirect('rad/Radcpengisianhasil/daftar_hasil/'.$no_rad);
	}

	public function update_hasil(){
		$id_pemeriksaan_rad=$this->input->post('id_pemeriksaan_rad');
		$no_register=$this->input->post('no_register');
		$no_rad=$this->input->post('no_rad');

		//Upload data
		$filesCount = count($_FILES['userFiles']['name']);
        for($i = 0; $i < $filesCount; $i++){
            // $data_rand = rand();
            $ext = end((explode("/", $_FILES['userFiles']['type'][$i]))); # extra () to prevent notice
            // echo $ext;
	        $date = new DateTime();

	        $timeStampData = microtime();
			list($msec, $sec) = explode(' ', $timeStampData);
			$msec = round($msec * 1000);

			$result = $sec . $msec;

            $fileName = str_replace(' ', '_', $no_register."-".$id_pemeriksaan_rad."~".$result.".".$ext);
            $_FILES['userFile']['name'] = $fileName;
            $_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
            $_FILES['userFile']['tmp_name'] = str_replace(' ', '_', $_FILES['userFiles']['tmp_name'][$i]);
            $_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
            $_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];

            $uploadPath = './upload/radgambarhasil/'; 
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if($this->upload->do_upload('userFile')){
                $fileData = $this->upload->data();
                $uploadData[$i]['name'] = $fileName;
	            // $uploadData[$i]['token'] = $data_rand;
                $uploadData[$i]['id_pemeriksaan_rad'] = $id_pemeriksaan_rad;
            }else{
             	$error = $this->upload->display_errors();
			 	echo $error;
            }
			// echo $fileName."<br>";
            // echo $i.'<br>';
        }
        
        if(!empty($uploadData)){
			// insert tahap_1_detail
			// printf('<br><br> uploadData: '.json_encode($uploadData));
            $insert = $this->radmdaftar->insert_file_hasil($uploadData);
            $statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
            $this->session->set_flashdata('statusMsg',$statusMsg);

            echo $statusMsg;
            echo json_encode($uploadData);
        }else{
        	echo "gagal";
            echo json_encode($uploadData);
        }
        //Upload data
		
		//UPDATE DATA
		//
		$data['id_dokter_1']=$this->input->post('id_dokter_1');
		$data['hasil_1']=$this->input->post('hasil_1');
		$data['id_dokter_2']=$this->input->post('id_dokter_2');
		$data['hasil_2']=$this->input->post('hasil_2');
		$data['id_dokter_3']=$this->input->post('id_dokter_3');
		$data['hasil_3']=$this->input->post('hasil_3');
		$data['id_dokter_4']=$this->input->post('id_dokter_4');
		$data['hasil_4']=$this->input->post('hasil_4');
		$data['id_dokter_5']=$this->input->post('id_dokter_5');
		$data['hasil_5']=$this->input->post('hasil_5');
		$data['hasil_pengirim']=$this->input->post('hasil_pengirim');
		// $this->radmdaftar->isi_hasil($data);
		$this->radmdaftar->update_hasil($id_pemeriksaan_rad, $data);

		redirect('rad/Radcpengisianhasil/daftar_hasil/'.$no_rad);
	}

	public function edit_hasil_submit(){
		$no_register=$this->input->post('no_register');
		$no_rad=$this->input->post('no_rad');
		$itot=$this->input->post('itot');
		for($i=1;$i<=$itot;$i++){
			$id_hasil_pemeriksaan=$this->input->post('id_hasil_pemeriksaan_'.$i);
			$hasil_rad=$this->input->post('hasil_rad_'.$i);

			$this->radmdaftar->edit_hasil($id_hasil_pemeriksaan, $hasil_rad);
			
		}

		redirect('rad/radcpengisianhasil/daftar_hasil/'.$no_rad);
	}

	public function st_cetak_hasil_rad()
	{
		$no_rad=$this->input->post('no_rad');
		$data_pasien=$this->radmkwitansi->get_data_pasien($no_rad)->row();

		if($no_rad!=''){

			$this->radmdaftar->update_status_cetak_hasil($no_rad);
			echo '<script type="text/javascript">window.open("'.site_url("rad/radcpengisianhasil/cetak_hasil_rad/$no_rad").'", "_blank");window.focus()</script>';
			
			redirect('rad/radcpengisianhasil/','refresh');
		}else{
			redirect('rad/radcpengisianhasil/','refresh');
		}
	}

	public function st_cetak_hasil_rad_rawat()
	{
		$no_rad=$this->input->post('no_rad');
		$data_pasien=$this->radmkwitansi->get_data_pasien($no_rad)->row();

		if($no_rad!=''){

			$this->radmdaftar->update_status_cetak_hasil($no_rad);
			echo '<script type="text/javascript">window.open("'.site_url("rad/radcpengisianhasil/cetak_hasil_rad/$no_rad").'", "_blank");window.history.back()</script>';
			
			//redirect('rad/radcpengisianhasil/','refresh');
		}else{
			//redirect('rad/radcpengisianhasil/','refresh');
		}
	}

	public function cetak_hasil_rad($no_rad='')
	{
		if($no_rad!=''){
			$no_register=$this->radmdaftar->get_row_register_by_norad($no_rad)->row()->no_register;
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$email=$this->config->item('email');
			$header_pdf=$this->config->item('header_pdf');
			
			$data_hasil_rad=$this->radmdaftar->get_data_hasil_rad($no_rad)->result();
					
			$header="
					<font size=\"6\" align=\"right\">$tgl_jam</font><br>
					$header_pdf

					<hr/><br/><br>
					<p align=\"center\"><b>
					HASIL PEMERIKSAAN RADIOLOGI
					</b></p><br/>";

			$nohptelp = "";$almt = "";
			if(substr($no_register, 0,2)=="PL"){
				$data_pasien=$this->radmdaftar->get_data_pasien_luar_cetak($no_rad)->row();
				$header=$header.
					"<table border=\"0\">
						<tr>
							<td width=\"10%\">No. Diagnostik</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">$no_rad</td>
							<td width=\"10%\">No Reg</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">$data_pasien->no_register</td>
							<td width=\"5%\">No MR</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">-</td>
						</tr>
						<tr>
							<td>Dokter</td>
							<td> : </td>
							<td>$data_pasien->dokter</td>
							<td>Nama Pasien</td>
							<td> : </td>
							<td colspan=\"4\"><b>$data_pasien->nama</b></td>
						</tr>
						<tr>
							<td>Dr. PJ. Rad</td>
							<td> : </td>
							<td>$data_pasien->dokter</td>
							<td width=\"10%\">Kelamin</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">-</td>
							<td width=\"5%\">Usia</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">- Thn</td>
						</tr>
						<tr>
							<td width=\"10%\">Tanggal</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							<td>Status</td>
							<td> : </td>
							<td>UMUM</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td> : </td>
							<td>$data_pasien->alamat</td>
							<td>Asal / Lokasi</td>
							<td> : </td>
							<td colspan=\"4\" rowspan=\"2\">-</td>
						</tr>
					</table>
					<br/><hr>
					";
			} else {
				$data_pasien=$this->radmdaftar->get_data_pasien_cetak($no_rad)->row();
				if($data_pasien->sex=="L"){
					$kelamin = "Laki-laki";
				} else {
					$kelamin = "Perempuan";
				}

				$almt = $almt."$data_pasien->alamat ";
				if($data_pasien->rt!=""){
					$almt = $almt."RT. $data_pasien->rt ";
				}
				if($data_pasien->rw!=""){
					$almt = $almt."RW. $data_pasien->rw ";
				}
				if($data_pasien->kelurahandesa!=""){
					$almt = $almt."$data_pasien->kelurahandesa ";
				}
				if($data_pasien->kecamatan!=""){
					$almt = $almt."$data_pasien->kecamatan ";
				}
				if($data_pasien->kotakabupaten!=""){
					$almt = $almt."<br>$data_pasien->kotakabupaten ";
				}

				if(($data_pasien->no_telp!="") && ($data_pasien->no_hp!="")){
					$nohptelp = $nohptelp."$data_pasien->no_telp / $data_pasien->no_hp";
				} else if($data_pasien->no_telp!=""){
					$nohptelp = $nohptelp."$data_pasien->no_telp";
				} else if($data_pasien->no_hp!=""){
					$nohptelp = $nohptelp."$data_pasien->no_hp";
				} else {
					$nohptelp = $nohptelp."-";
				}

				$get_umur=$this->rjmregistrasi->get_umur($data_pasien->no_medrec)->result();
				$tahun=0;
				$bulan=0;
				$hari=0;
				foreach($get_umur as $row)
				{
					// echo $row->umurday;
					$tahun=floor($row->umurday/365);
					$bulan=floor(($row->umurday - ($tahun*365))/30);
					$hari=$row->umurday - ($bulan * 30) - ($tahun * 365);
				}
				// $nm_poli=$this->labmdaftar->getnama_poli($data_pasien->idrg)->row()->nm_poli;
				if($data_pasien->cara_bayar=='DIJAMIN'){
					$a=$this->labmdaftar->getcr_bayar_dijamin($data_pasien->no_register)->row();
					$cara_bayar= "$a->a - $a->b";
				} else {
					$cara_bayar=$data_pasien->cara_bayar;
				}
				if (substr($no_register,0,2)=="RJ") {
					$nama_dokter=$this->radmdaftar->getnm_dokter_rj($data_pasien->no_register)->row()->nm_dokter;
					$lokasi = $data_pasien->idrg;
				}else if(substr($no_register,0,2)=="RI") {
					$nama_dokter=$this->radmdaftar->getnm_dokter_ri($data_pasien->no_register)->row()->nm_dokter;
					$lokasi = 'Rawat Inap - '.$data_pasien->idrg;
					// $lokasi = $nm_poli;
				}else {
					$lokasi = 'Pasien Langsung';
				}

				$header=$header.
					"<table border=\"0\">
						<tr>
							<td width=\"15%\">No. Diag</td>
							<td width=\"2%\"> : </td>
							<td width=\"25%\">$no_rad</td>
							<td width=\"10%\">No Reg</td>
							<td width=\"2%\"> : </td>
							<td width=\"26%\">$data_pasien->no_register </td>
							<td width=\"5%\">No MR</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">$data_pasien->no_cm</td>
						</tr>
						<tr>
							<td>Dokter Pengirim</td>
							<td> : </td>
							<td>$nama_dokter</td>
							<td>Nama Pasien</td>
							<td> : </td>
							<td colspan=\"4\"><b>$data_pasien->nama</b></td>
						</tr>
						<tr>
							<td>Tgl Periksa</td>
							<td> : </td>
							<td>".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							<td width=\"10%\">Kelamin</td>
							<td width=\"2%\"> : </td>
							<td width=\"26%\">$kelamin</td>
							<td width=\"5%\">Usia</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">$tahun Thn</td>
						</tr>
						<tr>
							<td >Status</td>
							<td> : </td>
							<td >$cara_bayar</td>
							<td>Alamat</td>
							<td> : </td>
							<td colspan=\"4\" rowspan=\"2\">$almt</td>
						</tr>
						<tr>
							<td>Asal / Lokasi</td>
							<td> : </td>
							<td colspan=\"3\">$lokasi</td>
						</tr>
					</table>
					<br/><hr>
					";
			}
			
			$header=$header."
					<style type=\"text/css\">
					.table-isi{
						    padding:2px 5px;
						}
					.table-isi th{
						    border-bottom: 1px solid #ddd;
						}
					.table-isi td{
						    border-bottom: 1px solid #ddd;
						    font-size:9dp;
						}
					</style>
					<table class=\"table-isi\">
						";
			
					// foreach($data_hasil_rad as $row){
					// 	$body=$body."<tr>
					// 			  	<th>$row->jenis_tindakan</th>
					// 			  	<td>
					// 					<p align=\"left\">$row->hasil_periksa</p>
					// 			  	</td>
					// 			</tr>";
					// }
					
				$footer="
					";
			
			$file_name="Hasil_Rad_$no_rad.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setPrintHeader(false);
				$obj_pdf->setPrintFooter(false);
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins('5', '5', '5');
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);

				foreach($data_hasil_rad as $row){
					if($row->id_dokter_1 != ""){
						$dokter_1 = $this->radmdaftar->getnama_dokter($row->id_dokter_1)->row()->nm_dokter;	
					}else{
						$dokter_1 = "";
					}
					if($row->id_dokter_2 != ""){
						$dokter_2 = $this->radmdaftar->getnama_dokter($row->id_dokter_2)->row()->nm_dokter;	
					}else{
						$dokter_2 = "";	
					}
					if($row->id_dokter_3 != ""){
						$dokter_3 = $this->radmdaftar->getnama_dokter($row->id_dokter_3)->row()->nm_dokter;	
					}else{
						$dokter_3 = "";
					}
					if($row->id_dokter_4 != ""){
						$dokter_4 = $this->radmdaftar->getnama_dokter($row->id_dokter_4)->row()->nm_dokter;	
					}else{
						$dokter_4 = "";
					}
					if($row->id_dokter_5 != ""){
						$dokter_5 = $this->radmdaftar->getnama_dokter($row->id_dokter_5)->row()->nm_dokter;	
					}else{
						$dokter_5 = "";
					}
					// $dokter_1 = $this->radmdaftar->getnama_dokter($row->id_dokter_1)->row()->nm_dokter;
					// $dokter_2 = $this->radmdaftar->getnama_dokter($row->id_dokter_2)->row()->nm_dokter;
					// $dokter_3 = $this->radmdaftar->getnama_dokter($row->id_dokter_3)->row()->nm_dokter;
					// $dokter_4 = $this->radmdaftar->getnama_dokter($row->id_dokter_4)->row()->nm_dokter;
					// $dokter_5 = $this->radmdaftar->getnama_dokter($row->id_dokter_5)->row()->nm_dokter;
					// $dokter_pengirim = $this->radmdaftar->getnama_dokter($row->id_dokter_3)->row()->nm_dokter;
					$body="
						<tr>
							<th colspan=\"2\"><p align=\"left\"><b>Jenis Pemeriksaan : $row->jenis_tindakan</b></p></th>
						</tr>
						<tr>
						  	<td width=\"15%\" align=\"right\">Dokter 1 :<br>Hasil :</td>
						  	<td width=\"85%\">
								<p align=\"left\">$dokter_1<br>$row->hasil_1</p>
						  	</td>
						</tr>";
					if($dokter_2!=""){
						$body.="
						<tr>
						  	<td align=\"right\">Dokter 2 :<br>Hasil :</td>
						  	<td>
								<p align=\"left\">$dokter_2<br>$row->hasil_2</p>
						  	</td>
						</tr>";
					}
					if($dokter_3!=""){
						$body.="
						<tr>
						  	<td align=\"right\">Dokter 3 :<br>Hasil :</td>
						  	<td>
								<p align=\"left\">$dokter_3<br>$row->hasil_3</p>
						  	</td>
						</tr>";
					}
					if($dokter_4!=""){
						$body.="
						<tr>
						  	<td align=\"right\">Dokter 4 :<br>Hasil :</td>
						  	<td>
								<p align=\"left\">$dokter_4<br>$row->hasil_4</p>
						  	</td>
						</tr>";
					}
					if($dokter_5!=""){
						$body.="
						<tr>
						  	<td align=\"right\">Dokter 5 :<br>Hasil :</td>
						  	<td>
								<p align=\"left\">$dokter_5<br>$row->hasil_5</p>
						  	</td>
						</tr>";
					}
					$body.="
						<tr>
						  	<td align=\"right\">Dokter Pengirim :<br>Hasil :</td>
						  	<td>
								<p align=\"left\">$nama_dokter<br>$row->hasil_pengirim</p>
						  	</td>
						</tr>
					</table>
					<hr>
					<br/>
					<br/>
					<table style=\"width:100%;\" style=\"padding-bottom:5px;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
					<br/>
								$kota_kab, $tgl	
								<br>Dokter Pembaca							
								
								<br><br><br>$dokter_1
								</p>
							</td>
						</tr>	
					</table>";

					$obj_pdf->AddPage();
					ob_start();
						$content = $header.$body.$footer;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
				}
				
				// $obj_pdf->AddPage();
				// ob_start();
				// 	$content = $header.$body.$footer;
				// ob_end_clean();
				// $obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/rad/radpengisianhasil/'.$file_name, 'FI');
		}else{
			redirect('rad/radcpengisianhasil/','refresh');
		}
	}
	
	public function cetak_hasil_rad_pertindakan($id_pemeriksaan_rad='',$no_rad='')
	{
		if($id_pemeriksaan_rad!=''){
			$no_register=$this->radmdaftar->get_row_register_by_norad($no_rad)->row()->no_register;
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$email=$this->config->item('email');
			$header_pdf=$this->config->item('header_pdf');
			
			$data_hasil_rad=$this->radmdaftar->get_data_hasil_rad_pertindakan($id_pemeriksaan_rad)->result();
					
			$header="
					<font size=\"6\" align=\"right\">$tgl_jam</font><br>
					$header_pdf

					<hr/><br/><br>
					<p align=\"center\"><b>
					HASIL PEMERIKSAAN RADIOLOGI
					</b></p><br/>";

			$nohptelp = "";$almt = "";
			if(substr($no_register, 0,2)=="PL"){
				$data_pasien=$this->radmdaftar->get_data_pasien_luar_cetak($no_rad)->row();
				$header=$header.
					"<table border=\"0\">
						<tr>
							<td width=\"10%\">No. Diagnostik</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">$no_rad</td>
							<td width=\"10%\">No Reg</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">$data_pasien->no_register</td>
							<td width=\"5%\">No MR</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">-</td>
						</tr>
						<tr>
							<td>Dokter</td>
							<td> : </td>
							<td>$data_pasien->dokter</td>
							<td>Nama Pasien</td>
							<td> : </td>
							<td colspan=\"4\"><b>$data_pasien->nama</b></td>
						</tr>
						<tr>
							<td>Dr. PJ. Rad</td>
							<td> : </td>
							<td>$data_pasien->dokter</td>
							<td width=\"10%\">Kelamin</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">-</td>
							<td width=\"5%\">Usia</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">- Thn</td>
						</tr>
						<tr>
							<td width=\"10%\">Tanggal</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							<td>Status</td>
							<td> : </td>
							<td>UMUM</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td> : </td>
							<td>$data_pasien->alamat</td>
							<td>Asal / Lokasi</td>
							<td> : </td>
							<td colspan=\"4\" rowspan=\"2\">-</td>
						</tr>
					</table>
					<br/><hr>
					";
			} else {
				$data_pasien=$this->radmdaftar->get_data_pasien_cetak($no_rad)->row();
				if($data_pasien->sex=="L"){
					$kelamin = "Laki-laki";
				} else {
					$kelamin = "Perempuan";
				}

				$almt = $almt."$data_pasien->alamat ";
				if($data_pasien->rt!=""){
					$almt = $almt."RT. $data_pasien->rt ";
				}
				if($data_pasien->rw!=""){
					$almt = $almt."RW. $data_pasien->rw ";
				}
				if($data_pasien->kelurahandesa!=""){
					$almt = $almt."$data_pasien->kelurahandesa ";
				}
				if($data_pasien->kecamatan!=""){
					$almt = $almt."$data_pasien->kecamatan ";
				}
				if($data_pasien->kotakabupaten!=""){
					$almt = $almt."<br>$data_pasien->kotakabupaten ";
				}

				if(($data_pasien->no_telp!="") && ($data_pasien->no_hp!="")){
					$nohptelp = $nohptelp."$data_pasien->no_telp / $data_pasien->no_hp";
				} else if($data_pasien->no_telp!=""){
					$nohptelp = $nohptelp."$data_pasien->no_telp";
				} else if($data_pasien->no_hp!=""){
					$nohptelp = $nohptelp."$data_pasien->no_hp";
				} else {
					$nohptelp = $nohptelp."-";
				}

				$get_umur=$this->rjmregistrasi->get_umur($data_pasien->no_medrec)->result();
				$tahun=0;
				$bulan=0;
				$hari=0;
				foreach($get_umur as $row)
				{
					// echo $row->umurday;
					$tahun=floor($row->umurday/365);
					$bulan=floor(($row->umurday - ($tahun*365))/30);
					$hari=$row->umurday - ($bulan * 30) - ($tahun * 365);
				}
				// $nm_poli=$this->labmdaftar->getnama_poli($data_pasien->idrg)->row()->nm_poli;
				if($data_pasien->cara_bayar=='DIJAMIN'){
					$a=$this->labmdaftar->getcr_bayar_dijamin($data_pasien->no_register)->row();
					$cara_bayar= "$a->a - $a->b";
				} else {
					$cara_bayar=$data_pasien->cara_bayar;
				}
				if (substr($no_register,0,2)=='RJ') {
					$nama_dokter=$this->radmdaftar->getnm_dokter_rj($data_pasien->no_register)->row()->nm_dokter;
					$lokasi = $data_pasien->idrg;
				}else if(substr($no_register,0,2)=='RI') {
					$nama_dokter=$this->radmdaftar->getnm_dokter_ri($data_pasien->no_register)->row()->nm_dokter;
					$lokasi = 'Rawat Inap - '.$data_pasien->idrg;
					// $lokasi = $nm_poli;
				}else {
					$lokasi = 'Pasien Langsung';
				}

				$header=$header.
					"<table border=\"0\">
						<tr>
							<td width=\"15%\">No. Diag</td>
							<td width=\"2%\"> : </td>
							<td width=\"25%\">$no_rad</td>
							<td width=\"10%\">No Reg</td>
							<td width=\"2%\"> : </td>
							<td width=\"26%\">$data_pasien->no_register </td>
							<td width=\"5%\">No MR</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">$data_pasien->no_cm</td>
						</tr>
						<tr>
							<td>Dokter Pengirim</td>
							<td> : </td>
							<td>$nama_dokter</td>
							<td>Nama Pasien</td>
							<td> : </td>
							<td colspan=\"4\"><b>$data_pasien->nama</b></td>
						</tr>
						<tr>
							<td>Tgl Periksa</td>
							<td> : </td>
							<td>".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							<td width=\"10%\">Kelamin</td>
							<td width=\"2%\"> : </td>
							<td width=\"26%\">$kelamin</td>
							<td width=\"5%\">Usia</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">$tahun Thn</td>
						</tr>
						<tr>
							<td >Status</td>
							<td> : </td>
							<td >$cara_bayar</td>
							<td>Alamat</td>
							<td> : </td>
							<td colspan=\"4\" rowspan=\"2\">$almt</td>
						</tr>
						<tr>
							<td>Asal / Lokasi</td>
							<td> : </td>
							<td colspan=\"3\">$lokasi</td>
						</tr>
					</table>
					<br/><hr>
					";
			}
			
			$header=$header."
					<style type=\"text/css\">
					.table-isi{
						    padding:2px 5px;
						}
					.table-isi th{
						    border-bottom: 1px solid #ddd;
						}
					.table-isi td{
						    border-bottom: 1px solid #ddd;
						    font-size:9dp;
						}
					</style>
					<table class=\"table-isi\">
						";
			
					// foreach($data_hasil_rad as $row){
					// 	$body=$body."<tr>
					// 			  	<th>$row->jenis_tindakan</th>
					// 			  	<td>
					// 					<p align=\"left\">$row->hasil_periksa</p>
					// 			  	</td>
					// 			</tr>";
					// }
					
				$footer="
					";
			
			$file_name="Hasil_Rad_Tind_".$id_pemeriksaan_rad.".pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setPrintHeader(false);
				$obj_pdf->setPrintFooter(false);
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins('5', '5', '5');
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);

				foreach($data_hasil_rad as $row){
					if(!empty($row->id_dokter_1))
						$dokter_1 = $this->radmdaftar->getnama_dokter($row->id_dokter_1)->row()->nm_dokter;
					else
						$dokter_1 = "";
					if(!empty($row->id_dokter_2))
						$dokter_2 = $this->radmdaftar->getnama_dokter($row->id_dokter_2)->row()->nm_dokter;
					else
						$dokter_2 = "";
					if(!empty($row->id_dokter_3))
						$dokter_3 = $this->radmdaftar->getnama_dokter($row->id_dokter_3)->row()->nm_dokter;
					else
						$dokter_3 = "";
					if(!empty($row->id_dokter_4))
						$dokter_4 = $this->radmdaftar->getnama_dokter($row->id_dokter_4)->row()->nm_dokter;
					else
						$dokter_4 = "";
					if(!empty($row->id_dokter_5))
						$dokter_5 = $this->radmdaftar->getnama_dokter($row->id_dokter_5)->row()->nm_dokter;
					else
						$dokter_5 = "";
					// $dokter_pengirim = $this->radmdaftar->getnama_dokter($row->id_dokter_3)->row()->nm_dokter;
					$body="
						<tr>
							<th colspan=\"2\"><p align=\"left\"><b>Jenis Pemeriksaan : $row->jenis_tindakan</b></p></th>
						</tr>
						<tr>
						  	<td width=\"15%\" align=\"right\">Dokter 1 :<br>Hasil :</td>
						  	<td width=\"85%\">
								<p align=\"left\">$dokter_1<br>$row->hasil_1</p>
						  	</td>
						</tr>";
					if($dokter_2!=""){
						$body.="
						<tr>
						  	<td align=\"right\">Dokter 2 :<br>Hasil :</td>
						  	<td>
								<p align=\"left\">$dokter_2<br>$row->hasil_2</p>
						  	</td>
						</tr>";
					}
					if($dokter_3!=""){
						$body.="
						<tr>
						  	<td align=\"right\">Dokter 3 :<br>Hasil :</td>
						  	<td>
								<p align=\"left\">$dokter_3<br>$row->hasil_3</p>
						  	</td>
						</tr>";
					}
					if($dokter_4!=""){
						$body.="
						<tr>
						  	<td align=\"right\">Dokter 4 :<br>Hasil :</td>
						  	<td>
								<p align=\"left\">$dokter_4<br>$row->hasil_4</p>
						  	</td>
						</tr>";
					}
					if($dokter_5!=""){
						$body.="
						<tr>
						  	<td align=\"right\">Dokter 5 :<br>Hasil :</td>
						  	<td>
								<p align=\"left\">$dokter_5<br>$row->hasil_5</p>
						  	</td>
						</tr>";
					}
					$body.="
						<tr>
						  	<td align=\"right\">Dokter Pengirim :<br>Hasil :</td>
						  	<td>
								<p align=\"left\">$nama_dokter<br>$row->hasil_pengirim</p>
						  	</td>
						</tr>
					</table>
					<hr>
					<br/>
					<br/>
					<table style=\"width:100%;\" style=\"padding-bottom:5px;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
					<br/>
								$kota_kab, $tgl	
								<br>Dokter Pembaca							
								
								<br><br><br>$dokter_1
								</p>
							</td>
						</tr>	
					</table>";

					$obj_pdf->AddPage();
					ob_start();
						$content = $header.$body.$footer;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
				}
				
				// $obj_pdf->AddPage();
				// ob_start();
				// 	$content = $header.$body.$footer;
				// ob_end_clean();
				// $obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/rad/radpengisianhasil/'.$file_name, 'FI');
		}else{
			redirect('rad/radcpengisianhasil/','refresh');
		}
	}
	public function download($data) {
	   // $fileName = $data;
	    //$file_path = 'upload/radgambarhasil/' . $fileName;
	    //$this->_push_file($file_path, $fileName);
	    //$image_name = "mypic.jpg";
		$image_path = $this->config->item('base_url') . "upload/radgambarhasil/$data";
		header('Content-Type: application/octet-stream');
		header("Content-Disposition: attachment; filename=$data");
		ob_clean();
		flush();
		readfile($image_path);
 	}

 	function _push_file($path, $name) {
        $this->load->helper('download');
        // make sure it's a file before doing anything!
        if (is_file($path)) {
            // required for IE
            if (ini_get('zlib.output_compression')) {
                ini_set('zlib.output_compression', 'Off');
            }

            // get the file mime type using the file extension
            $this->load->helper('download');
            $mime = get_mime_by_extension($path);
            // Build the headers to push out the file properly.
            header('Pragma: public');     // required
            header('Expires: 0');         // no cache
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
            header('Cache-Control: private', false);
            header('Content-Type: jpeg|jpg');  // Add the mime type from Code igniter.
            header('Content-Disposition: attachment; filename="' . basename($name) . '"');  // Add the file name
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($path)); // provide file size
            header('Connection: close');
            readfile($path); // push it out
            exit();
        }else {
        	echo "<script language=\"javascript\">alert('Kosong');</script>";
        }
    }
}