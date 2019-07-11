<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Muri_kwitansi extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//////////////////////////////////////////////////////urikes
		function get_pasien_kwitansi($date){
			return $this->db->query("select a.*, b.nmtindakan as jenis from urikkes_pasien a left join jenis_tindakan b on a.jenis_pemeriksaan=b.idtindakan where tgl_daftar='$date' and cetak_kwitansi is null");
		}
		function getdata_pasien($no_kode){
			return $this->db->query("select a.*, b.nmtindakan as jenis, c.total_tarif from urikkes_pasien a 
				left join jenis_tindakan b on a.jenis_pemeriksaan=b.idtindakan 
				left join tarif_tindakan c on a.jenis_pemeriksaan=c.id_tindakan
				where idurikes='$no_kode'");
		}
		function getdata_unpaid_tindakan_pasien($no_kode){			
			return $this->db->query("SELECT a.*, b.nmtindakan as jenis, d.*, c.total_tarif from urikkes_pasien a 
				left join jenis_tindakan b on a.jenis_pemeriksaan=b.idtindakan 
				left join tarif_tindakan c on a.jenis_pemeriksaan=c.id_tindakan
				left join nomor_kwitansi d on a.nomor_kode=d.no_register
				 where a.idurikes='$no_kode' 
				 GROUP BY a.idurikes");
		}
		function update_status_kwitansi_detail_kt($no_kode,$data){

			$this->db->where('idurikes', $no_kode);
			$this->db->update('urikkes_pasien', $data);
			return true;
		}	

		function insert_nokwitansi($data){
			return $this->db->insert('nomor_kwitansi', $data);
		}
		function get_no_kwitansi($no_register){
			return $this->db->query("SELECT no_kwitansi FROM no_kwitansi WHERE no_registrasi='$no_register'");
		}

		function get_no_kwitansi_loket($idloket){
			return $this->db->query("SELECT IFNULL(MAX(no_kwitansi),00000000) as no_kwitansi from nomor_kwitansi
			WHERE id_loket='$idloket'");
		}

		function update_pembayaran_nokwitansi($no_kwitansi,$data){
			$this->db->where('no_kwitansi', $no_kwitansi);
			return $this->db->update('nomor_kwitansi', $data);
		}

		function update_counter_kwitansi($no_register){
			return $this->db->query("UPDATE daftar_ulang_irj
										SET counter_kwitansi=counter_kwitansi+1
										WHERE no_register='$no_register'");
		}
		function getdata_nomor_kwitansi($nomor_kwitansi,$idloket){
			return $this->db->query("select * from nomor_kwitansi where no_kwitansi=$nomor_kwitansi and id_loket='$idloket'");
		}

		function get_detail_daful($no_register){
			return $this->db->query("SELECT *,(SELECT nm_poli from poliklinik where id_poli=daftar_ulang_irj.id_poli) as nm_poli,(SELECT nm_dokter from data_dokter where id_dokter=daftar_ulang_irj.id_dokter) as nm_dokter, IF((substring(xupdate, 12, 5)>='07:00' and substring(xupdate, 12, 5)<='13:59'),'Pagi','Sore') as shift FROM daftar_ulang_irj where no_register='$no_register' order by xupdate desc");
		}
		/////////////////////////////////////////////////////end-urikes


		function get_pasien_kwitansi1($date){
			return $this->db->query("SELECT * FROM daftar_ulang_irj, data_pasien, poliklinik where cetak_kwitansi='0' and daftar_ulang_irj.status='1' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and poliklinik.id_poli=daftar_ulang_irj.id_poli and LEFT(daftar_ulang_irj.tgl_kunjungan,10)='$date' order by daftar_ulang_irj.cara_bayar desc");
		}
		function get_pasien_kwitansi_by_nocm($no_medrec){
			return $this->db->query("SELECT * FROM daftar_ulang_irj, data_pasien, poliklinik where cetak_kwitansi='0' and daftar_ulang_irj.status='1' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and poliklinik.id_poli=daftar_ulang_irj.id_poli and data_pasien.no_medrec='$no_medrec' order by daftar_ulang_irj.cara_bayar desc");
		}
		function get_pasien_kwitansi_by_noregister($no_register){
			return $this->db->query("SELECT * FROM daftar_ulang_irj, data_pasien, poliklinik where cetak_kwitansi='0' and daftar_ulang_irj.status='1' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and poliklinik.id_poli=daftar_ulang_irj.id_poli and daftar_ulang_irj.no_register='$no_register' order by daftar_ulang_irj.cara_bayar desc");
		}
		function get_pasien_kwitansi_by_date($date){
			return $this->db->query("SELECT * FROM daftar_ulang_irj, data_pasien, poliklinik where cetak_kwitansi='0' and daftar_ulang_irj.status='1' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and poliklinik.id_poli=daftar_ulang_irj.id_poli and left(daftar_ulang_irj.tgl_kunjungan,10)='$date' order by daftar_ulang_irj.cara_bayar desc");
		}
		/////////////////////////////////////////////////////////////////////////////////////kwitansi semua
		function getdata_pasien1($no_register){
			return $this->db->query("SELECT *, (select nm_dokter from data_dokter where id_dokter=a.id_dokter) as nm_dokter FROM daftar_ulang_irj as a, data_pasien, poliklinik 
				where data_pasien.no_medrec=a.no_medrec 
				and poliklinik.id_poli=a.id_poli 
				and a.no_register='$no_register' 
				group by a.no_register");
		}

		function getdata_pasien_nokwitansi1($id_kwitansi){
			return $this->db->query("SELECT
				*, a.xuser as user_cetak from nomor_kwitansi a 
				JOIN daftar_ulang_irj b ON a.no_register=b.no_register
				LEFT JOIN poliklinik c ON c.id_poli=b.id_poli
				JOIN data_pasien d ON d.no_medrec=b.no_medrec
				LEFT JOIN data_dokter e ON e.id_dokter=b.id_dokter
				where a.idno_kwitansi=$id_kwitansi");
		}

		function getdata_tindakan_pasien($no_register){
			return $this->db->query("SELECT * FROM pelayanan_poli where no_register='$no_register' order by xupdate desc");
		}

		function getdata_tindakan_pasienumum($no_register){
			return $this->db->query("SELECT * FROM pelayanan_poli where no_register='$no_register' and idtindakan NOT LIKE '1B01%' order by xupdate desc");
		}

		function getdata_tindakan_pasienumumretur($no_register){
			return $this->db->query("SELECT * FROM pelayanan_poli where no_register='$no_register' and bayar=1 order by xupdate desc");
		}
		
		function getdata_unpaid_finish_tindakan_pasien($no_register){			
			return $this->db->query("SELECT *, 
			(select COUNT(bpjs) from pelayanan_poli where bpjs=0 and no_register='$no_register') as noncover 
			FROM pelayanan_poli 
			where no_register='$no_register' 
			and bayar=0 and idtindakan NOT LIKE '1B01%'
			order by xupdate desc
			");
			//SELECT * FROM pelayanan_poli where no_register='$no_register' and bayar=0 and idtindakan NOT LIKE '1B01%' order by xupdate desc
		}

		function getdata_unpaid_tindakan_pasien1($no_kode){			
			return $this->db->query("SELECT * FROM urikkes_pasien where nomor_kode='$no_kode' and cetak_kwitansi is null ");
		}

		
		

		function getdata_perusahaan($no_register){
			return $this->db->query("SELECT A.id_kontraktor, B.nmkontraktor FROM daftar_ulang_irj A, kontraktor B  where no_register='$no_register' and A.id_kontraktor=B.id_kontraktor");
		}
		function get_vtot($no_register){
			return $this->db->query("SELECT vtot, vtot_ok, vtot_lab, vtot_rad, vtot_obat, vtot_pa FROM daftar_ulang_irj WHERE no_register='$no_register'");
		}
		/////////////////////////////////////////////////////////////////////////////////
		function get_new_kwkt($no_register){
			return $this->db->query("select max(right(nokwitansi_kt,6)) as counter, mid(now(),3,2) as year from daftar_ulang_irj where mid(nokwitansi_kt,3,2) = (select mid(now(),3,2)) and no_register not like '$no_register'");
		}
		function update_kwkt($nokwitansi_kt,$no_register){
			$this->db->query("update daftar_ulang_irj set nokwitansi_kt='$nokwitansi_kt', tglcetak_kwitansi=now() where no_register='$no_register'");
			return true;
		}
		function getdata_tgl_kw($no_register){
			return $this->db->query("select date_format(tglcetak_kwitansi, '%d-%m-%Y %h:%m:%s') as tglcetak_kwitansi, date_format(tglcetak_kwitansi, '%d-%m-%Y') as tgl_kwitansi  from daftar_ulang_irj where no_register='$no_register'");
		}
		function update_kw_penunjang($no_register, $data, $table){
			$this->db->where('no_register', $no_register);
			$this->db->update($table, $data);
			return true;
		}
		function get_pasien_pertind_kwitansi($date){
			return $this->db->query("SELECT b.tgl_kunjungan, b.cara_bayar, b.id_poli, (SELECT nm_poli from poliklinik where id_poli=b.id_poli) as nm_poli, a.no_register, (SELECT nama from data_pasien where no_medrec=b.no_medrec) as nama, a.bayar, a.xcetak, (SELECT no_cm from data_pasien where no_medrec=b.no_medrec) as no_cm , count(a.no_register) as banyak				
FROM pelayanan_poli a, daftar_ulang_irj b 
where a.bayar=0 and a.bpjs=0 and a.xcetak is null and LEFT(b.tgl_kunjungan,10)='$date' and a.no_register=b.no_register and b.xcetak is null group by a.no_register ORDER BY b.cara_bayar desc");
		}


		/////////////////////////////////////////////////////////////////////////////////////kwitansi tindakan
		function get_new_kwkk($id_pelayanan_poli){
			return $this->db->query("select max(right(nokwitansi_kk,6)) as counter, mid(now(),3,2) as year from pelayanan_poli where mid(nokwitansi_kk,3,2) = (select mid(now(),3,2)) and id_pelayanan_poli not like '$id_pelayanan_poli'");
		}
		function update_kwkk($nokwitansi_kk,$id_pelayanan_poli){
			$this->db->query("update pelayanan_poli set nokwitansi_kk='$nokwitansi_kk', tglcetak_kwitansi=now() where id_pelayanan_poli=$id_pelayanan_poli");
			return true;
		}
		function getdata_tgl_kk($id_pelayanan_poli){
			return $this->db->query("select date_format(tglcetak_kwitansi, '%d-%m-%Y %h:%m:%s') as tglcetak_kwitansi, date_format(tglcetak_kwitansi, '%d-%m-%Y') as tgl_kwitansi from pelayanan_poli where id_pelayanan_poli='$id_pelayanan_poli'");
		}
		function getdata_kwitansikk($id_pelayanan_poli){
			return $this->db->query("select * from daftar_ulang_irj, pelayanan_poli, operator, data_pasien, poliklinik where pelayanan_poli.id_pelayanan_poli=$id_pelayanan_poli and  daftar_ulang_irj.no_medrec=data_pasien.no_medrec and daftar_ulang_irj.no_register=pelayanan_poli.no_register and operator.id_dokter=pelayanan_poli.id_dokter and poliklinik.id_poli=daftar_ulang_irj.id_poli");
		}
		/////////////////////////////////////////////////////////////////////////////////////
		function getdata_rs($koders){
			return $this->db->query("select * from data_rs where koders='$koders'");
		}
		/////////////////////////////////////////////////////////////////////////////////////status kwitansi
		function update_pembayaran($no_register,$data){
			$this->db->where('no_register', $no_register);
			return $this->db->update('daftar_ulang_irj', $data);;
		}


		function update_pembayaran_idkwitansi($idno_kwitansi,$data){
			$this->db->where('idno_kwitansi', $idno_kwitansi);
			return $this->db->update('nomor_kwitansi', $data);
		}

		

		function getdata_detail_kwitansi($noreg){
			return $this->db->query("select * from nomor_kwitansi where no_register='$noreg'");
		}

		function update_pembayaran_detail($no_register,$data){
			$this->db->where('no_register', $no_register);					
			/*$query="update daftar_ulang_irj  
set tunai=(IFNULL((SELECT a.tunai from (select * from daftar_ulang_irj) as a 
where a.no_register='$no_register'),0)+".$data['tunai']."),  diskon=(IFNULL((SELECT a.diskon from (select * from daftar_ulang_irj) as a 
where a.no_register='$no_register'),0)+".$data['diskon']."), no_kkkd=".$data['no_kkkd'].", nilai_kkkd=(IFNULL((SELECT a.nilai_kkkd from (select * from daftar_ulang_irj) as a where a.no_register='$no_register'),0)+".$data['nilai_kkkd'].") where no_register='$no_register'";
			echo $query;
			$this->db->query();*/
			return $this->db->update('daftar_ulang_irj', $data);
		}

		

		function update_pelayanan($no_register,$data){
			$this->db->where('no_register', $no_register);
			return $this->db->update('id_pelayanan_poli', $data);
		}

		function update_status_kwitansi_kt($no_register,$data){
			$this->db->where('no_register', $no_register);
			$this->db->update('daftar_ulang_irj', $data);
			return true;
		}
		//update_status_kwitansi_detail_kt
			
		function update_diskon($diskon,$no_register){
			$this->db->query("update daftar_ulang_irj set diskon='$diskon' where no_register='$no_register'");
			return true;
		}
		function update_status_kwitansi_kk($id_pelayanan_poli){
			$this->db->query("update pelayanan_poli set cetak_kwitansi='1' where id_pelayanan_poli='$id_pelayanan_poli'");
			return true;
		}

		//nomor kwitansi loket
		

		//unpaid
		function getdata_unpaid_lab_pasien($no_register){
			return $this->db->query("SELECT A.no_lab, A.no_register, B.id_tindakan, 
B.biaya_lab, B.jenis_tindakan, B.qty, B.vtot 
FROM lab_header A, pemeriksaan_laboratorium B
where A.no_register='$no_register' 
and A.no_lab=B.no_lab");
		}
		function getdata_unpaid_rad_pasien($no_register){
			return $this->db->query("SELECT A.no_rad, A.no_register, B.id_tindakan, 
B.biaya_rad, B.jenis_tindakan, B.qty, B.vtot 
FROM rad_header A, pemeriksaan_radiologi B
where A.no_register='$no_register'
and A.no_rad=B.no_rad");
		}
		function getdata_unpaid_resep_pasien($no_register){
			return $this->db->query("SELECT A.no_resep, A.no_resgister, B.item_obat, 
B.biaya_obat, B.nama_obat, B.qty, B.vtot 
FROM resep_header A, resep_pasien B
where A.no_resgister='$no_register'
and A.no_resep=B.no_resep");
		}
		// Pasien SJP JAMSOSKES
		
		function get_pasien_sjp(){
			return $this->db->query("SELECT a.tgl_kunjungan, a.no_register, b.no_cm, b.nama, a.cara_bayar, d.nmkontraktor, d.id_kontraktor, c.nm_poli, c.id_poli 
				FROM daftar_ulang_irj as a
				LEFT JOIN data_pasien as b ON a.no_medrec=b.no_medrec
				LEFT JOIN poliklinik as c ON a.id_poli=c.id_poli 
				LEFT JOIN kontraktor as d ON a.id_kontraktor=d.id_kontraktor 
				where (cara_bayar='DIJAMIN' or cara_bayar='BPJS') and a.status='0' 
				order by a.xupdate desc");
		}
		
		function getdata_pasien_sjp($no_register){
			return $this->db->query("SELECT a.*, b.no_cm, 
				b.nama, b.alamat, b.tgl_lahir, b.sex, 
				c.nm_poli,
				d.nmkontraktor,
				e.nm_ppk
				FROM daftar_ulang_irj as a 
				LEFT JOIN data_pasien as b ON a.no_medrec=b.no_medrec 
				LEFT JOIN poliklinik as c ON a.id_poli=c.id_poli 
				LEFT JOIN kontraktor as d ON a.id_kontraktor=d.id_kontraktor 
				LEFT JOIN data_ppk as e ON a.asal_rujukan=e.kd_ppk 
				WHERE no_register='$no_register'");
		}

		//lunas
		function get_pasien_kwitansi_lunas($date0,$date1){
			return $this->db->query("SELECT
				d.*, a.id_poli, b.no_cm, b.nama, a.tgl_kunjungan, a.cara_bayar, c.nm_poli
			FROM nomor_kwitansi d
			JOIN daftar_ulang_irj a ON a.no_register=d.no_register
			JOIN data_pasien b ON a.no_medrec=b.no_medrec
			LEFT JOIN poliklinik c ON a.id_poli=c.id_poli
			WHERE
				a.cara_bayar = 'UMUM' 
				AND LEFT ( d.xcreate, 10 ) >= '$date0'
				AND LEFT ( d.xcreate, 10 ) <= '$date1'
				");
		}
	}
?>
