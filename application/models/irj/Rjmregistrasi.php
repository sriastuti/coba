<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Rjmregistrasi extends CI_Model{
		var $keluarga_order = array(null,'no_cm',null,null,null,null,null);
        var $keluarga_search = array('no_cm','nrp_sbg','nama','tgl_lahir'); 
        var $default_order_keluarga = array('nrp_sbg' => 'desc','no_cm' => 'desc'); 
		function __construct(){
			parent::__construct();
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////registrasi biodata pasien
		/*function get_new_medrec(){
			return $this->db->query("select max(no_medrec) as counter from data_pasien");
		}
		*/
		function insert_pasien_irj($data){
			$this->db->set('no_cm', "(SELECT ifnull(MAX(a.no_cm)+1,000000) as last_cm 
						FROM (SELECT * FROM data_pasien) AS a)", FALSE);
			$this->db->insert('data_pasien', $data);
			return $this->db->insert_id();
		}		
		private function _get_datatables_query()  {
			$no_nrp = $this->input->post('no_nrp');
			$no_cm = $this->input->post('no_cm');
            $this->db->FROM('data_pasien');
            $this->db->JOIN('tni_hubungan', 'data_pasien.nrp_sbg = tni_hubungan.hub_id', 'inner');
            $this->db->where('no_nrp !=','');
            $this->db->where('no_nrp',$no_nrp);
            $this->db->where('data_pasien.no_cm !=',$no_cm);
        
            $i = 0;     
            foreach ($this->keluarga_search as $item)
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
     
                    if(count($this->keluarga_search) - 1 == $i)
                        $this->db->group_end();
                }
		            $i++;
		        }
		         
		        if(isset($_POST['order'])) // here order processing
		        {
		            $this->db->order_by($this->keluarga_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		        } 
		        else if(isset($this->default_order_keluarga))
		        {
		            $order = $this->default_order_keluarga;
		            $this->db->order_by(key($order), $order[key($order)]);
		        }
		 //   }
		}
		public function getdata_keluarga()
        {
            $this->_get_datatables_query();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
        public function keluarga_filtered()
        {
            $this->_get_datatables_query();
            $query = $this->db->get();
            return $query->num_rows();
        }
 
        public function keluarga_count_all()
        {
			$no_nrp = $this->input->post('no_nrp');
			$no_medrec = $this->input->post('no_medrec');
            $this->db->FROM('data_pasien');
            $this->db->JOIN('tni_hubungan', 'data_pasien.nrp_sbg = tni_hubungan.hub_id', 'inner');
            $this->db->where('no_nrp',$no_nrp); 
            $this->db->where('no_medrec !=',$no_medrec);
            return $this->db->count_all_results();
        }
		function insert_tnipns($data){			
			$this->db->insert('anggota_tni', $data);
			return $this->db->insert_id();
		}
		function update_pasien_irj($data,$no_medrec){
			$this->db->where('no_medrec', $no_medrec);
			$this->db->update('data_pasien', $data);
			return true;
		}
		function generate_rm($no_medrec,$data_update){
			$this->db->set('no_cm', "(SELECT ifnull(MAX(a.no_cm)+1,000000) as last_cm 
						FROM (SELECT * FROM data_pasien) AS a)", FALSE);
			$this->db->where('no_medrec', $no_medrec);
			$this->db->update('data_pasien', $data_update);
			return true;
		}
		function get_rm($no_medrec){
			return $this->db->query("SELECT no_cm,no_cm_lama FROM data_pasien where no_medrec=$no_medrec");
		}
		function get_daftar_sep($tgl0,$tgl1){
			return $this->db->query("SELECT *, A.nama, du.cetak_sep_ke,
				IF(du.hapusSEP='1','BATAL','OK') as status
			FROM daftar_ulang_irj du, data_pasien A
			where du.no_medrec=A.no_medrec AND du.no_sep!='' 
			AND LEFT(du.tgl_kunjungan,10)>='$tgl0'
			AND LEFT(du.tgl_kunjungan,10)<='$tgl1'
			ORDER BY du.tgl_kunjungan  DESC");
		}

		function get_daftar_kontrol($tgl0,$tgl1){
			return $this->db->query("SELECT *, A.nama, (select nm_poli from poliklinik where id_poli=du.id_poli) as nm_poli	
			FROM daftar_ulang_irj du, data_pasien A
			where du.no_medrec=A.no_medrec AND du.tgl_kontrol is not null 
			aND LEFT(du.tgl_kontrol,10)>='$tgl0'
			AND LEFT(du.tgl_kontrol,10)<='$tgl1'
			ORDER BY du.tgl_kontrol  DESC");
		}			
		function update_nokartu($no_kartu,$nmr_medrec,$data_update){
     	$this->db->where('no_medrec', $nmr_medrec);
     	$this->db->update('data_pasien', $data_update);
     	return true;
    	}			
		////////////////////////////////////////////////////////////////////////////////////////////////////////////cari data pasien by
		function select_pasien_irj_by_no_register_with_diag_utama($no_register){
		$data=$this->db->query("
			select *
			from daftar_ulang_irj as a inner join data_pasien as b on a.no_medrec = b.no_medrec
			left join data_dokter as c on c.id_dokter = a.id_dokter
			where a.no_register='$no_register'
			and left(a.tgl_kunjungan,10)<=left(now(),10) and left(a.tgl_kunjungan,10)>=left(now()- INTERVAL 3 DAY,10)
			");
		return $data->result_array();
		}

		function check_ktp($nik){			
				return $this->db->query("SELECT no_identitas 
							FROM data_pasien 
							WHERE no_identitas='$nik' AND jenis_identitas='KTP'");
		}

		function get_kontraktor_bpjs($tipe){			
				return $this->db->query("SELECT *, id_kontraktor as id 
							FROM kontraktor 
							WHERE bpjs='$tipe'
							ORDER BY nmkontraktor");
		}		

		public function get_all_tindakan($kelas,$keyword){

		$data=$this->db->query("
				select a.nmtindakan, a.idtindakan as id, b.total_tarif 
			from jenis_tindakan_inap as a inner join tarif_tindakan as b on a.idtindakan = b.id_tindakan
			left join jenis_tindakan as c on a.idtindakan = c.idtindakan
			where a.nmtindakan <> '' and b.kelas = '$kelas'
			and a.nmtindakan like '%".$keyword."%'
			order by a.nmtindakan asc
			limit 100
			");

		return $data;
	}
		function get_detail_daful($no_register){
			return $this->db->query("SELECT A.*, B.nama, B.tgl_daftar, B.no_kartu, (SELECT nm_ppk
		FROM data_ppk  AS pk
		WHERE pk.kd_ppk=A.asal_rujukan) AS nm_ppk, 
		(SELECT nm_dokter
		FROM data_dokter  AS dd
		WHERE dd.id_dokter=A.id_dokter ) AS nm_dokter
		FROM daftar_ulang_irj A , data_pasien B 
		where A.no_register='$no_register'
		and A.no_medrec=B.no_medrec");
		}
		function get_daftar_pasien(){
			return $this->db->query("SELECT *, A.nama
			FROM daftar_ulang_irj du, data_pasien A
			where du.no_medrec=A.no_medrec 
			and du.cara_bayar='BPJS'
			and du.no_sep is null
			-- and du.status='1'
			-- and left(du.tgl_kunjungan,10) <= curdate()
			and left(du.tgl_kunjungan,10) >= curdate()- interval 5 Day
			order by du.tgl_kunjungan  asc");
		}

		function get_pasien_last_daful($no_medrec){
			return $this->db->query("SELECT * FROM daftar_ulang_irj where no_medrec=$no_medrec order by no_register DESC LIMIT 1");
		}

		function get_daftar_pasien_belum_pulang(){
			return $this->db->query("SELECT *, (select nm_poli from poliklinik where id_poli=du.id_poli) as nm_poli
			FROM daftar_ulang_irj du, data_pasien A
			where du.no_medrec=A.no_medrec 
			and left(du.tgl_kunjungan,10) <= curdate()
			and left(du.tgl_kunjungan,10) >= curdate()- interval 6 Day
			and du.tgl_pulang is null
			order by du.tgl_kunjungan  asc");
		}
		function get_data_pasien_by_no_cm($no_cm){
			return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.no_cm='$no_cm'");
		}
		function get_data_pasien_by_no_cm_lama($no_cm_lama){
			return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.no_cm_lama='$no_cm_lama'");
		}
		function get_data_pasien_by_no_cm_baru($no_cm){
			return $this->db->query("SELECT * FROM data_pasien where no_medrec='$no_cm'");
		}
		function get_data_pasien_by_no_cm_online($no_cm){
			return $this->db->query("SELECT * FROM data_pasien where no_cm='$no_cm'");
		}
		function get_data_pasien_by_no_kartu($no_kartu){
			return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.no_kartu='$no_kartu'");
		}

		function get_data_pasien_by_no_nrp($no_nrp){
			return $this->db->query("SELECT * FROM anggota_tni where no_nrp='$no_nrp' and no_cm!=''");
		}

		function get_data_pasien_by_nrp($no_nrp){
			return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.no_nrp='$no_nrp' ");
		}

		function show_keluarga($no_cm_pasien){
			return $this->db->query("SELECT * FROM keluarga_pasien where no_cm_pasien='$no_cm_pasien'");
		}
		function insert_keluarga($data_save){
			$this->db->insert('keluarga_pasien', $data_save);
			return true;
		}
		function update_keluarga($no_cm_pasien,$data_save) {      
          $this->db->where('no_cm_pasien', $no_cm_pasien);
          $this->db->update('keluarga_pasien', $data_save);
          return true;
        }
		function get_data_pasien_by_no_identitas($no_identitas){
			return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.no_identitas='$no_identitas'");
		}
		function get_data_pasien_by_nama($nama){
			return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.nama LIKE '%$nama%'");
		}
		function get_data_pasien_by_alamat($alamat){
			return $this->db->query("SELECT * FROM data_pasien a LEFT JOIN tni_hubungan b on a.nrp_sbg=b.hub_id where a.alamat LIKE '%$alamat%'");
		}
		function get_data_pasien_by_tgl($tgl){
			return $this->db->query("SELECT * FROM data_pasien where tgl_lahir LIKE '%$tgl%'");
		}
		function cek_no_kartu($no_kartu,$no_kartu_old){
			return $this->db->query("SELECT * FROM data_pasien where no_kartu='$no_kartu' AND no_kartu != '$no_kartu_old'");
		}
		function cek_no_nrp($no_nrp,$no_nrp_old){
			return $this->db->query("SELECT * FROM data_pasien where no_nrp='$no_nrp' AND no_nrp != '$no_nrp_old' and nrp_sbg='T'");
		}
		function cek_no_nrp1($no_nrp,$hub){
			return $this->db->query("SELECT * FROM anggota_tni where nrp='$no_nrp' and hub_id='$hub'");
		}
		function cek_no_identitas($no_identitas,$no_identitas_old){
			return $this->db->query("SELECT * FROM data_pasien where no_identitas='$no_identitas' AND no_identitas != '$no_identitas_old'");
		}
		//SELECT count(no_medrec) from hmis_db.daftar_ulang_irj where no_medrec='0000000740'
		function cek_kunj_irj($no_medrec){
			return $this->db->query("SELECT count(no_medrec) as cek from daftar_ulang_irj where no_medrec='$no_medrec'");
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////registrasi pasien ke irj
		function cek_data_poli($no_medrec){
			$date = date("Y-m-d");
			return $this->db->query("SELECT b.nm_poli, a.tgl_kunjungan FROM daftar_ulang_irj AS a 
				LEFT JOIN poliklinik AS b ON a.id_poli = b.id_poli 
				WHERE no_medrec='$no_medrec' AND LEFT(a.tgl_kunjungan,10)=LEFT(now(),10) AND status='0'");
		}
		function cek_poli_ke($no_medrec){
			$date = date("Y-m-d");
			return $this->db->query("SELECT count(*) as count_poli FROM daftar_ulang_irj AS a 
				LEFT JOIN poliklinik AS b ON a.id_poli = b.id_poli 
				WHERE no_medrec='$no_medrec' AND LEFT(a.tgl_kunjungan,10)=LEFT(now(),10) ");
		}
		function get_umur($no_medrec){
			return $this->db->query("select datediff(now(),tgl_lahir) as umurday from data_pasien where no_medrec='$no_medrec'");
		}
		function get_new_register(){
			return $this->db->query("select max(right(no_register,6)) as counter, mid(now(),3,2) as year from daftar_ulang_irj where mid(no_register,3,2) = (select mid(now(),3,2))");
		}
		function get_biayakarcis(){
			return $this->db->query("SELECT nilai_karcis AS nilai_karcis_baru, 
									(SELECT nilai_karcis FROM karcis_sec 
									WHERE seri_karcis='LAMA') AS nilai_karcis_lama
									FROM karcis_sec WHERE seri_karcis='BARU'");
		}		
		// function get_idpoliumum(){
		// 	return $this->db->query("SELECT id_poli FROM poliklinik where nm_poli='POLI UMUM'");
		// }
		function insert_daftar_ulang($data){
			$this->db->trans_begin();
			$awalan='RJ'.date('y');
			$datenow=date('Y-m-d');
			$noreservasi=($this->select_antrian_bynoreg($datenow,$data['id_poli'])->row()->no)+1;
			//echo $noreservasi;		
			$value=	$datenow;
			$id_poli=$data['id_poli'];
			
			$this->db->set('no_register', "(SELECT IFNULL(CONCAT('".$awalan."', LPAD (max(right(no_register,6))+1 ,6,0) ),'".$awalan."000001') 
						FROM (SELECT * FROM daftar_ulang_irj WHERE LEFT(no_register,4)='".$awalan."') AS a)", FALSE);	
			$this->db->set('poli_ke', "(SELECT (count(*))+1 as count_poli FROM (SELECT * FROM daftar_ulang_irj) AS a 
				LEFT JOIN poliklinik AS b ON a.id_poli = b.id_poli 
				WHERE a.no_medrec='".$data["no_medrec"]."' AND LEFT(a.tgl_kunjungan,10)=LEFT(now(),10))", FALSE);
			$this->db->set('no_antrian', "(select IFNULL(MAX(no_antrian),0) as no from (SELECT * FROM daftar_ulang_irj) AS a where LEFT(tgl_kunjungan,10)='$value' and id_poli='$id_poli')+1" , FALSE);	
			$this->db->insert('daftar_ulang_irj', $data);
			$no_register = $this->db->query("select max(no_register) as no_register from daftar_ulang_irj where no_medrec='".$data["no_medrec"]."'")->row();
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
			} else {
			    $this->db->trans_commit();
			}
			return $no_register;

		}
		function update_daftar_ulang($no_register,$data){
			$this->db->where('no_register', $no_register);
			$this->db->update('daftar_ulang_irj', $data);
			return true;
		}
		/////////////////////////////////////////////////////////////////////////////////////karcis
		/*function get_new_nokarcis($no_register){
			return $this->db->query("select max(right(noseri_karcis,5)) as counter, mid(now(),3,2) as year from daftar_ulang_irj where mid(noseri_karcis,2,2) = (select mid(now(),3,2)) and no_register not like '$no_register'");
		}
		function update_nokarcis($noseri_karcis,$no_register){
			$this->db->query("update daftar_ulang_irj set noseri_karcis='$noseri_karcis', tglcetak_karcis=now() where no_register='$no_register'");
			return true;
		}
		function getdata_karcis($no_register){
			return $this->db->query("select *, date_format(tglcetak_karcis, '%d-%m-%Y %h:%m:%s') as tglcetak_karcis from daftar_ulang_irj, data_pasien, poliklinik where daftar_ulang_irj.no_medrec=data_pasien.no_medrec and daftar_ulang_irj.id_poli=poliklinik.id_poli and daftar_ulang_irj.no_register='$no_register'");
		}
		*/		
// 		function getdata_tracer($no_register){
// 			return $this->db->query("select du.*, dp.nama, dp.no_cm, dp.sex, dp.tgl_lahir, p.nm_poli, dd.nm_dokter, IF(
// (substring(du.xupdate, 12, 5)>='04:00' and substring(du.xupdate, 12, 5)<='13:59')
// ,'Pagi','Sore') as shift, (SELECT nmkontraktor from kontraktor where id_kontraktor=du.id_kontraktor) as nmkontraktor
// 										from daftar_ulang_irj AS du, data_pasien AS dp, poliklinik AS p, data_dokter AS dd
// 										where du.no_medrec=dp.no_medrec and du.id_poli=p.id_poli AND du.id_dokter=dd.id_dokter
// 										and du.no_register='$no_register'");
// 		}
		function getdata_tracer($no_register){
			return $this->db->query("select du.*, dp.nama, dp.no_cm, dp.no_cm_lama, dp.sex, dp.tgl_lahir, p.nm_poli, IF(
(substring(du.xupdate, 12, 5)>='04:00' and substring(du.xupdate, 12, 5)<='13:59')
,'Pagi','Sore') as shift, (SELECT nmkontraktor from kontraktor where id_kontraktor=du.id_kontraktor) as nmkontraktor
										from daftar_ulang_irj AS du, data_pasien AS dp, poliklinik AS p
										where du.no_medrec=dp.no_medrec and du.id_poli=p.id_poli AND du.no_register='$no_register'");
		}
		function getdata_before($no_medrec,$no_register){
			return $this->db->query("Select a.*, p.nm_poli from daftar_ulang_irj a, poliklinik p where a.no_medrec='$no_medrec' and a.no_register!='$no_register' and a.id_poli=p.id_poli
order by no_register desc limit 1");
		}
		function getdata_identitas($no_cm){
			return $this->db->query("select dp.*, (select pangkat from tni_pangkat where pangkat_id=dp.pkt_id) as pkt_name, (select angkatan from tni_angkatan where tni_id=dp.angkatan_id) as angkatan_name, (select kst_nama from tni_kesatuan where kst_id=dp.kst_id) as kst_name
				from data_pasien AS dp
				where dp.no_cm='$no_cm'");
		}
		function keluarga_anggota($no_nrp) {
			return $this->db->query("select dp.*, (select pangkat from tni_pangkat where pangkat_id=dp.pkt_id) as pkt_name, (select angkatan from tni_angkatan where tni_id=dp.angkatan_id) as angkatan_name, (select kst_nama from tni_kesatuan where kst_id=dp.kst_id) as kst_name
				from data_pasien AS dp
				where dp.no_nrp='$no_nrp' and dp.nrp_sbg='T'")->row();
		}
		function keluarga_bayi($no_cm) {
			$this->db->from('data_pasien');
			$this->db->where('no_cm', $no_cm);			
			$query = $this->db->get();
			return $query->row();
		}
		////////////////////////////////////////////////////////////////////////////////////SEP
		function update_sep($no_register,$data){
			$this->db->where('no_register', $no_register);
			$this->db->update('daftar_ulang_irj', $data);
			return true;
		}
		function get_entri($noreg) {
			$this->db->from('daftar_ulang_irj');
			$this->db->join('poliklinik', 'poliklinik.id_poli = daftar_ulang_irj.id_poli', 'left');
			$this->db->select('*');
			$this->db->where('daftar_ulang_irj.no_register', $noreg);
			$query = $this->db->get();
			return $query->row();
		}
		public function get_ppk($kd_ppk) {
			$this->db->where('kd_ppk', $kd_ppk);
			$query = $this->db->get('data_ppk');
			return $query->row();
		}

		function nm_provinsi($id) {
			$this->db->from('provinsi');
			$this->db->where('id', $id);
			$query = $this->db->get();
			return $query->row();
		}
		function nm_kota($id) {
			$this->db->from('kotakabupaten');
			$this->db->where('id', $id);
			$query = $this->db->get();
			return $query->row();
		}
		function nm_kecamatan($id) {
			$this->db->from('kecamatan');
			$this->db->where('id', $id);
			$query = $this->db->get();
			return $query->row();
		}
		function nm_kelurahan($id) {
			$this->db->from('kelurahandesa');
			$this->db->where('id', $id);
			$query = $this->db->get();
			return $query->row();
		}

		public function get_noreg_pasien($no_medrec){
			return $this->db->query("select max(no_register) as noreg from daftar_ulang_irj where no_medrec='$no_medrec'");
		}

		public function get_detail_tindakan($id_tindakan){
			return $this->db->query("select a.idtindakan, a.nmtindakan, b.total_tarif, b.tarif_alkes from jenis_tindakan a, tarif_tindakan b where a.idtindakan=b.id_tindakan and b.id_tindakan='$id_tindakan'
and b.kelas='III'");
		}

		public function get_detail_dokter($id_dokter){
			return $this->db->query("select * from data_dokter where id_dokter='$id_dokter'");
		}

		public function get_tarif_periksa_dokter($id_dokter){
			return $this->db->query("select id_dokter, (SELECT nm_dokter from data_dokter where a.id_dokter=id_dokter) as nm_dokter, id_poli, id_biaya_periksa, (SELECT nmtindakan from jenis_tindakan where a.id_biaya_periksa=idtindakan) as nmtindakan, id_poli, id_biaya_periksa,
(SELECT total_tarif from tarif_tindakan where a.id_biaya_periksa=id_tindakan and kelas='III') as total_tarif,
(SELECT tarif_alkes from tarif_tindakan where a.id_biaya_periksa=id_tindakan and kelas='III') as tarif_alkes
from dokter_poli a where a.id_dokter='$id_dokter'");
		}
		public function get_diagnosa($id_icd) {
			$this->db->where('id_icd', $id_icd);
			$query = $this->db->get('icd1');
			return $query->row();
		}
		public function select_antrian_bynoreg($value,$id_poli){
			$data=$this->db->query("select IFNULL(MAX(no_antrian),0) as no from daftar_ulang_irj where LEFT(tgl_kunjungan,10)='$value' and id_poli='$id_poli'");
			return $data;
		}

		public function getdata_pasien($no_medrec){
			return $this->db->query("SELECT * FROM data_pasien where no_cm='$no_medrec'");
		}
	}
?>
