<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Rjmmedrec extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		
		function get_medrec($int_tgl){
			return $this->db->query("SELECT du.umurrj as usia, dpa.sex, du.no_register, 
			du.tgl_kunjungan, dpa.nama, du.no_medrec, dpa.no_cm,
			(SELECT nm_poli from poliklinik where id_poli=du.id_poli) as nm_poli,
			(SELECT CONCAT_WS(' - ',id_diagnosa,diagnosa) 
			FROM diagnosa_pasien AS dp 
			WHERE dp.klasifikasi_diagnos='utama' AND dp.no_register=du.no_register AND dp.diagnosa!='' LIMIT 1) AS diag_utama					
			FROM daftar_ulang_irj AS du 
			LEFT JOIN data_pasien AS dpa ON du.no_medrec=dpa.no_medrec
			WHERE du.status='1' AND du.tgl_kunjungan >= '$int_tgl' and du.ket_pulang!='BATAL_PELAYANAN_POLI' ORDER BY du.tgl_kunjungan DESC");
		}
		
		function get_medrec_by_search($tgl_kunj,$ceklist_diag){
		
			$select_tgl="";
			if ($tgl_kunj!='') {
				$select_tgl=" AND LEFT(du.tgl_kunjungan,10)='$tgl_kunj'";
			}
			
			if ($ceklist_diag!='') {
				$query="SELECT a.* FROM (
							SELECT du.umurrj as usia, dpa.sex, du.no_register, du.tgl_kunjungan, dpa.nama, du.no_medrec, dpa.no_cm,
							(SELECT nm_poli from poliklinik where id_poli=du.id_poli) as nm_poli,
							(SELECT CONCAT_WS(' - ',id_diagnosa,diagnosa)
							FROM diagnosa_pasien AS dp 
							WHERE dp.klasifikasi_diagnos='utama' AND dp.no_register=du.no_register LIMIT 1) AS diag_utama
						FROM daftar_ulang_irj AS du 
						LEFT JOIN data_pasien AS dpa ON du.no_medrec=dpa.no_medrec 
						WHERE du.status='1' $select_tgl
						ORDER BY tgl_kunjungan DESC
						) AS a WHERE diag_utama is NULL";
			} else {
				$query="SELECT du.umurrj as usia, dpa.sex, du.no_register, du.tgl_kunjungan, dpa.nama, du.no_medrec, dpa.no_cm,(SELECT nm_poli from poliklinik where id_poli=du.id_poli) as nm_poli,
							(SELECT CONCAT_WS(' - ',id_diagnosa,diagnosa) 
							FROM diagnosa_pasien AS dp 
							WHERE dp.klasifikasi_diagnos='utama' AND dp.no_register=du.no_register LIMIT 1) AS diag_utama	
						FROM daftar_ulang_irj AS du 
						LEFT JOIN data_pasien AS dpa ON du.no_medrec=dpa.no_medrec
						WHERE du.status='1' $select_tgl ORDER BY tgl_kunjungan DESC";
			}
									
			return $this->db->query($query);
		}
		
		function getdata_diagnosa_pasien($no_register){
			return $this->db->query("SELECT a.* FROM diagnosa_pasien as a LEFT JOIN daftar_ulang_irj as b ON a.no_register = b.no_register WHERE b.no_register = '".$no_register."'");
		}
		function getdata_diagnosa_pulang_pasien($no_medrec){
			return $this->db->query("select 
(select jns_kunj from (select * from daftar_ulang_irj) as D where no_register=Max(B.no_register)) as jns_kunj, Max(B.no_register) as no_register, A.no_cm, A.no_medrec, 
(select  I.nm_diagnosa  from (select * from daftar_ulang_irj) as D, icd1 as I
where D.no_register=Max(B.no_register)
and I.id_icd=D.diag_baru) as diag_baru, 
(select  I.nm_diagnosa  from (select * from daftar_ulang_irj) as D, icd1 as I
where D.no_register=Max(B.no_register)
and I.id_icd=D.diag_lama) as diag_lama, 
(select D.nm_poli from (select * from poliklinik) as D 
where D.id_poli=(select id_poli from (select * from daftar_ulang_irj) as F  where F.no_register=Max(B.no_register))) as poli, 
(SELECT GROUP_CONCAT(' ',id_diagnosa) FROM diagnosa_pasien AS dp WHERE dp.no_register=Max(B.no_register)) as icd,
A.nama, A.sex, B.umurrj as usia, B.cara_bayar, (SELECT nmkontraktor from kontraktor where id_kontraktor=B.id_kontraktor) as nmkontraktor,
(select pangkat from tni_pangkat where pangkat_id=A.pkt_id) as pangkat, (select angkatan from tni_angkatan where tni_id=A.angkatan_id) as angkatan, (select kst_nama from tni_kesatuan where kst_id=A.kst_id) as kesatuan
FROM daftar_ulang_irj B inner join data_pasien A
on A.no_medrec=B.no_medrec
where LEFT(B.tgl_kunjungan,10)=LEFT(now(),10)
Group by A.no_medrec
");
		}

// 		function getdata_diagnosa_pulang_pasien_date($tgl_awal,$tgl_akhir,$id_poli){
			

// 			if($id_poli!='SEMUA'){
// 				$txtpoli="AND B.id_poli = '$id_poli'";
// 			}else $txtpoli="";
			
// 			return $this->db->query("select 
// 					(select jns_kunj from (select * from daftar_ulang_irj) as D where no_register=Max(B.no_register)) as jns_kunj, Max(B.no_register) as no_register, A.no_cm, A.no_medrec, 
// 					(select  I.nm_diagnosa  from (select * from daftar_ulang_irj) as D, icd1 as I
// 					where D.no_register=Max(B.no_register)
// 					and I.id_icd=D.diag_baru) as diag_baru, 
// 					(select  I.nm_diagnosa  from (select * from daftar_ulang_irj) as D, icd1 as I
// 					where D.no_register=Max(B.no_register)
// 					and I.id_icd=D.diag_lama) as diag_lama, 
// 					(select D.nm_poli from (select * from poliklinik) as D 
// 					where D.id_poli=(select id_poli from (select * from daftar_ulang_irj) as F  where F.no_register=Max(B.no_register))) as poli, 	
// 					(SELECT GROUP_CONCAT(' ',id_diagnosa) FROM diagnosa_pasien AS dp WHERE dp.no_register=Max(B.no_register)) as icd,
// 					A.nama, A.sex, B.umurrj as usia, B.cara_bayar, (SELECT nmkontraktor from kontraktor where id_kontraktor=B.id_kontraktor) as nmkontraktor,
// 						A.no_nrp,
// 					(Select hub_name from tni_hubungan where hub_id=A.nrp_sbg) as hub_name,
// 					(select pangkat from tni_pangkat where pangkat_id=A.pkt_id) as pangkat, (select angkatan from tni_angkatan where tni_id=A.angkatan_id) as angkatan, (select kst_nama from tni_kesatuan where kst_id=A.kst_id) as kesatuan
// 					FROM daftar_ulang_irj B inner join data_pasien A
// 					on A.no_medrec=B.no_medrec
// 					where LEFT(B.tgl_kunjungan,10)>='$tgl_awal' and LEFT(B.tgl_kunjungan,10)<='$tgl_akhir'
// 					$txtpoli
// 					and B.status=1 and B.ket_pulang!='BATAL_PELAYANAN_POLI'
// 					Group by A.no_medrec
// ");
// 		}
		function getdata_diagnosa_pulang_pasien_date($tgl_awal,$tgl_akhir,$id_poli){ 
			if($id_poli!='SEMUA'){
				$txtpoli="AND B.id_poli = '$id_poli'";
			}else $txtpoli="";

			return $this->db->query("
				SELECT a.jns_kunj, a.no_register, a.no_medrec, b.no_cm, a.diag_baru, a.diag_lama,j.nm_poli as poli, a.diagnosa as icd, b.nama, b.sex, a.umurrj as usia, a.cara_bayar, d.nmkontraktor, b.no_nrp, e.hub_name, k.pangkat, f.angkatan, g.kst_nama as kesatuan,h.kst2_nama,i.kst3_nama FROM
					daftar_ulang_irj a join data_pasien b on a.no_medrec=b.no_medrec 
					left join tni_pangkat c on b.pkt_id=c.pangkat_id 
					LEFT JOIN kontraktor d on a.id_kontraktor=d.id_kontraktor
					left join tni_hubungan e on b.nrp_sbg=e.hub_id
					LEFT JOIN tni_angkatan f on b.angkatan_id=f.tni_id 
					LEFT JOIN tni_kesatuan g on b.kst_id=g.kst_id
					LEFT JOIN tni_kesatuan2 h on b.kst2_id=h.kst2_id
					LEFT JOIN tni_kesatuan3 i on b.kst3_id=i.kst3_id
					LEFT JOIN poliklinik j on a.id_poli=j.id_poli
					LEFT JOIN tni_pangkat k on b.pkt_id=k.pangkat_id
					WHERE LEFT(a.tgl_kunjungan,10)>='$tgl_awal' and LEFT(a.tgl_kunjungan,10)<='$tgl_akhir'
					$txtpoli
									and a.status='1' and a.ket_pulang!='BATAL_PELAYANAN_POLI'
									Group by a.no_medrec
				");
		}

		function getdata_diagnosa_pulang_pasien_ird($no_medrec){
			return $this->db->query("select B.tgl_kunjungan, Max(B.no_register) as no_register, A.no_cm, A.no_medrec, B.diag_baru, B.diag_lama, B.jns_kunj, A.nama, A.sex, B.umurrj as usia, B.cara_bayar
FROM daftar_ulang_irj B inner join data_pasien A
on A.no_medrec=B.no_medrec
Group by A.no_medrec");
		}

		function getdata_kunj_poli_pasien($dateawal,$dateakhir){
			return $this->db->query("select (SELECT 
            COUNT(*)
        FROM
            daftar_ulang_irj
        WHERE
            jns_kunj = 'BARU'
                AND LEFT(tgl_kunjungan, 10) >= '$dateawal'
                AND LEFT(tgl_kunjungan, 10) <= '$dateakhir'
                AND id_poli=a.id_poli
                AND status=1) AS baru,
    (SELECT 
            COUNT(*)
        FROM
            daftar_ulang_irj
        WHERE
            jns_kunj = 'LAMA'
                AND LEFT(tgl_kunjungan, 10) >= '$dateawal'
                AND LEFT(tgl_kunjungan, 10) <= '$dateakhir'
                AND id_poli=a.id_poli
                AND status=1) AS lama,
                a.nm_poli, sum(a.MIL) as MIL, sum(a.PNS) as PNS, 
 sum(a.NONAL) as NONAL, sum(a.BPJSUMUM) as BPJSUMUM,  
 sum(a.UMUM) as UMUM, SUM(a.KEL) as KEL 
from (SELECT * FROM lap_kunj_poli) as a 
where LEFT(a.tgl_kunjungan,10)>='$dateawal' and LEFT(a.tgl_kunjungan,10)<='$dateakhir'
group by a.nm_poli");
		}
	}
?>
