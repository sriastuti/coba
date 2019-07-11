<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Radmlaporan extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		/////////laporan pemeriksaan
		function get_lap_pemeriksaan($date0,$date1){
			return $this->db->query("SELECT d.idtindakan, d.nmtindakan, c.jenis_tindakan, COUNT(c.id_tindakan) as banyak, LEFT(c.tgl_kunjungan,10) as tgl_kunjungan
			FROM jenis_tindakan_rad d
			LEFT JOIN pemeriksaan_radiologi c ON c.id_tindakan IN (d.idtindakan) 
			and LEFT(c.tgl_kunjungan,10)>='$date0'
			and LEFT(c.tgl_kunjungan,10)<='$date1'
			and c.no_register IN ((select no_register from daftar_ulang_irj))
			GROUP BY d.idtindakan;");
		}

		function get_dates_detail($date0,$date1){
			return $this->db->query("SELECT LEFT(c.tgl_kunjungan,10) as tgl_kunjungan,
			SUM(if(e.cara_bayar='BPJS', 1, 0)) as BPJS,
			SUM(if(e.cara_bayar='UMUM', 1, 0)) as UMUM,
			SUM(if(e.cara_bayar='DIJAMIN', 1, 0)) as DIJAMIN,
			SUM(if(f.sex='P', 1, 0)) as P,
			SUM(if(f.sex='L', 1, 0)) as L
			from pemeriksaan_radiologi c
			INNER JOIN jenis_tindakan_rad d ON c.id_tindakan IN (d.idtindakan)
			INNER JOIN daftar_ulang_irj e ON e.no_register=c.no_register
			INNER JOIN data_pasien f ON f.no_medrec=e.no_medrec
			where LEFT(c.tgl_kunjungan,10)>='$date0'
			and LEFT(c.tgl_kunjungan,10)<='$date1'
			GROUP BY c.tgl_kunjungan");
		}

		function get_master_pemeriksaan_rad(){
			return $this->db->query("SELECT d.idtindakan, d.nmtindakan
			FROM jenis_tindakan_rad d");
		}

		function get_lap_pemeriksaan_detail($date0,$date1){
			return $this->db->query("SELECT d.idtindakan, d.nmtindakan, c.jenis_tindakan, COUNT(c.id_tindakan) as banyak, LEFT(c.tgl_kunjungan,10) as tgl_kunjungan
			FROM jenis_tindakan_rad d
			LEFT JOIN pemeriksaan_radiologi c ON c.id_tindakan IN (d.idtindakan) 
			and LEFT(c.tgl_kunjungan,10)>='$date0'
			and LEFT(c.tgl_kunjungan,10)<='$date1'
			INNER JOIN daftar_ulang_irj e ON e.no_register=c.no_register
			GROUP BY d.idtindakan, c.tgl_kunjungan;");
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////kunjungan
		function get_data_kunj_today(){
			return $this->db->query("SELECT b.no_cm, a.no_medrec, a.no_register, nama, a.tgl_kunjungan as tgl, count(1) as banyak, IF(a.bed='Rawat Jalan',(SELECT waktu_masuk_rad from daftar_ulang_irj where no_register=a.no_register),null) as waktu_masuk_rad,
IF(a.bed='Rawat Jalan',(SELECT waktu_keluar_rad from daftar_ulang_irj where no_register=a.no_register),null) as waktu_keluar_rad  
				FROM pemeriksaan_radiologi a, data_pasien b 
				WHERE a.no_medrec=b.no_medrec 
				AND left(a.tgl_kunjungan,10)  = left(now(),10) 
				GROUP BY a.no_register 
			UNION
					SELECT 'Pasien Luar' as no_cm, c.no_medrec, c.no_register, nama, c.tgl_kunjungan as tgl, count(1) as banyak, null as waktu_masuk_rad, null as waktu_keluar_rad
				FROM pemeriksaan_radiologi c, pasien_luar d 
				WHERE c.no_register=d.no_register 
				AND left(c.tgl_kunjungan,10)  = left(now(),10) 
				GROUP BY c.no_register ");
		}

		function get_data_kunj_by_date($tgl){
			return $this->db->query("SELECT b.no_cm, a.no_medrec, a.no_register, nama, count(1) as banyak, IF(a.bed='Rawat Jalan',(SELECT waktu_masuk_rad from daftar_ulang_irj where no_register=a.no_register),null) as waktu_masuk_rad,
				IF(a.bed='Rawat Jalan',(SELECT waktu_keluar_rad from daftar_ulang_irj where no_register=a.no_register),null) as waktu_keluar_rad 
				FROM pemeriksaan_radiologi a, data_pasien b 
				WHERE a.no_medrec=b.no_medrec 
				AND left(a.tgl_kunjungan,10)  = '$tgl' 
				GROUP BY a.no_register 
			UNION
					SELECT 'Pasien Luar' as no_cm, c.no_medrec, c.no_register, nama, count(1) as banyak, null as waktu_masuk_rad, null as waktu_keluar_rad 
				FROM pemeriksaan_radiologi c, pasien_luar d 
				WHERE c.no_register=d.no_register 
				AND left(c.tgl_kunjungan,10)  = '$tgl' 
				GROUP BY c.no_register ");
		}
		
		function get_data_kunj_bln($bln){
			return $this->db->query("SELECT DATE_FORMAT(LEFT(tgl_kunjungan,10),'%d %M %Y') AS hari, count(*) AS jum_kunj, LEFT(tgl_kunjungan,10) as tgl 
										FROM pemeriksaan_radiologi
										WHERE LEFT(tgl_kunjungan,7)='$bln'
										GROUP BY LEFT(tgl_kunjungan,10)");
		}

		function get_data_kunj_thn($thn){
			return $this->db->query("SELECT MONTHNAME(LEFT(tgl_kunjungan,10)) AS bulan, count(*) AS jum_kunj 
				FROM pemeriksaan_radiologi
				WHERE LEFT(tgl_kunjungan,4)='$thn'
				GROUP BY bulan");
		}

		function get_total_kunj($tgl){
			return $this->db->query("SELECT COUNT(*) FROM pemeriksaan_radiologi WHERE left(tgl_kunjungan,10)='$tgl' GROUP BY no_register");
		}

		function get_data_tindakan(){
			return $this->db->query("SELECT a.id_tindakan, b.nmtindakan
				FROM pemeriksaan_radiologi a, jenis_tindakan b
				WHERE a.id_tindakan=b.idtindakan 
				AND left(a.tgl_kunjungan,10)  = left(now(),10)
				GROUP BY a.id_tindakan");
		}

		function get_data_pemeriksaan(){
			return $this->db->query("SELECT b.no_cm, a.id_tindakan, a.no_medrec, a.no_register, b.nama
				FROM pemeriksaan_radiologi a, data_pasien b
				WHERE a.no_medrec=b.no_medrec 
				AND left(a.tgl_kunjungan,10)  = left(now(),10)
			UNION
					SELECT 'Pasien Luar' as no_cm, c.id_tindakan, c.no_medrec, c.no_register, d.nama
				FROM pemeriksaan_radiologi c, pasien_luar d
				WHERE c.no_register=d.no_register 
				AND left(c.tgl_kunjungan,10)  = left(now(),10)
				ORDER BY id_tindakan");
		}

		function get_data_tindakan_tgl($tgl){
			return $this->db->query("SELECT a.id_tindakan, b.nmtindakan
				FROM pemeriksaan_radiologi a, jenis_tindakan b
				WHERE a.id_tindakan=b.idtindakan 
				AND left(a.tgl_kunjungan,10)  = '$tgl'
				GROUP BY a.id_tindakan");
		}

		function get_data_pemeriksaan_tgl($tgl){
			return $this->db->query("SELECT b.no_cm, a.id_tindakan, a.no_medrec, a.no_register, b.nama
				FROM pemeriksaan_radiologi a, data_pasien b
				WHERE a.no_medrec=b.no_medrec 
				AND left(a.tgl_kunjungan,10)  = '$tgl'
			UNION
					SELECT 'Pasien Luar' as no_cm, c.id_tindakan, c.no_medrec, c.no_register, d.nama
				FROM pemeriksaan_radiologi c, pasien_luar d
				WHERE c.no_register=d.no_register 
				AND left(c.tgl_kunjungan,10)  = '$tgl'
				ORDER BY id_tindakan");
		}

		function get_data_tindakan_bln($bln){
			return $this->db->query("SELECT a.id_tindakan, b.nmtindakan
				FROM pemeriksaan_radiologi a, jenis_tindakan b
				WHERE a.id_tindakan=b.idtindakan 
				AND left(a.tgl_kunjungan,7)  = '$bln'
				GROUP BY a.id_tindakan");
		}

		function get_data_pemeriksaan_bln($bln){
			return $this->db->query("SELECT b.no_cm, a.id_tindakan, a.no_medrec, a.no_register, left(a.tgl_kunjungan,10) as tgl, b.nama
				FROM pemeriksaan_radiologi a, data_pasien b
				WHERE a.no_medrec=b.no_medrec 
				AND left(a.tgl_kunjungan,7)  = '$bln'
			UNION
					SELECT 'Pasien Luar' as no_cm, c.id_tindakan, c.no_medrec, c.no_register, left(c.tgl_kunjungan,10) as tgl, d.nama
				FROM pemeriksaan_radiologi c, pasien_luar d
				WHERE c.no_register=d.no_register 
				AND left(c.tgl_kunjungan,7)  = '$bln'
				ORDER BY id_tindakan");
		}

		function get_data_tindakan_thn($thn){
			return $this->db->query("SELECT a.id_tindakan, b.nmtindakan
				FROM pemeriksaan_radiologi a, jenis_tindakan b
				WHERE a.id_tindakan=b.idtindakan 
				AND left(a.tgl_kunjungan,4)  = '$thn'
				GROUP BY a.id_tindakan");
		}

		function get_data_pemeriksaan_thn($thn){
			return $this->db->query("SELECT b.no_cm, a.id_tindakan, a.no_medrec, a.no_register, left(a.tgl_kunjungan,10) as tgl, b.nama
				FROM pemeriksaan_radiologi a, data_pasien b
				WHERE a.no_medrec=b.no_medrec 
				AND left(a.tgl_kunjungan,4)  = '$thn'
			UNION
					SELECT 'Pasien Luar' as no_cm, c.id_tindakan, c.no_medrec, c.no_register, left(c.tgl_kunjungan,10) as tgl, d.nama
				FROM pemeriksaan_radiologi c, pasien_luar d
				WHERE c.no_register=d.no_register 
				AND left(c.tgl_kunjungan,4)  = '$thn'
				ORDER BY id_tindakan");
		}

		//////////////////////////////////////////////////////////////////////


		function get_data_keu_tind($awal, $akhir){
			return $this->db->query("SELECT a.*, b.nama as nama FROM pendapatan_rad as a
					LEFT JOIN data_pasien as b
					ON a.no_medrec=b.no_cm
					WHERE LEFT(tgl_kunjungan , 10) >= '$awal'
					AND LEFT(tgl_kunjungan , 10) <= '$akhir'
					AND no_rad IS NOT NULL
					ORDER BY tgl_kunjungan, no_rad");
		}

		function get_data_keu_tindakan_today(){
			return $this->db->query("SELECT B.no_cm, A.no_medrec, A.no_register, B.nama, count(A.id_tindakan) as jum_pem, SUM(A.vtot) as total
				FROM pemeriksaan_radiologi A, data_pasien B
				WHERE  A.no_medrec=B.no_medrec 
				AND left(A.tgl_kunjungan,10)=left(now(),10)
				AND A.cetak_kwitansi='1'
				GROUP BY A.no_register
			UNION
					SELECT 'Pasien Luar' as no_cm, C.no_medrec, C.no_register, D.nama, count(C.id_tindakan) as jum_pem, SUM(C.vtot) as total
				FROM pemeriksaan_radiologi C, pasien_luar D
				WHERE  C.no_register=D.no_register 
				AND left(C.tgl_kunjungan,10)=left(now(),10)
				AND D.cetak_kwitansi='1'
				GROUP BY no_register");
		}

		function get_data_keuangan_today(){
			return $this->db->query("SELECT no_register, id_tindakan, jenis_tindakan, vtot
				FROM pemeriksaan_radiologi
				WHERE left(tgl_kunjungan,10) =left(now(),10)
				AND cetak_kwitansi='1'
				ORDER BY id_tindakan");
		}

		function get_data_keu_tind_tgl($tgl){
			return $this->db->query("SELECT B.no_cm, A.no_medrec, A.no_register, B.nama, count(A.id_tindakan) as jum_pem, SUM(A.vtot) as total
				FROM pemeriksaan_radiologi A, data_pasien B
				WHERE  A.no_medrec=B.no_medrec 
				AND left(A.tgl_kunjungan,10)='$tgl'
				AND A.cetak_kwitansi='1'
				GROUP BY A.no_register
			UNION
					SELECT 'Pasien Luar' as no_cm, C.no_medrec, C.no_register, D.nama, count(C.id_tindakan) as jum_pem, SUM(C.vtot) as total
				FROM pemeriksaan_radiologi C, pasien_luar D
				WHERE  C.no_register=D.no_register 
				AND left(C.tgl_kunjungan,10)='$tgl'
				AND D.cetak_kwitansi='1'
				GROUP BY no_register");
		}

		function get_data_keu_tind_bln($bln){
			return $this->db->query("SELECT DATE_FORMAT(LEFT(tgl_kunjungan,10),'%d %M %Y') AS hari, count(id_tindakan) AS jum_kunj, LEFT(tgl_kunjungan,10) as tgl, SUM(vtot) as total 
										FROM pemeriksaan_radiologi
										WHERE LEFT(tgl_kunjungan,7)='$bln'
				AND cetak_kwitansi='1'
										GROUP BY hari");
		}

		function get_data_keu_tind_thn($thn){
			return $this->db->query("SELECT MONTHNAME(LEFT(tgl_kunjungan,10)) AS bulan, count(*) AS jum_kunj,  SUM(vtot) as total  
				FROM pemeriksaan_radiologi
				WHERE LEFT(tgl_kunjungan,4)='$thn'
				AND cetak_kwitansi='1'
				GROUP BY bulan");
		}

		function get_data_keuangan_tgl($tgl){
			return $this->db->query("SELECT no_register, id_tindakan, jenis_tindakan, vtot
				FROM pemeriksaan_radiologi
				WHERE left(tgl_kunjungan,10) = '$tgl'
				AND cetak_kwitansi='1'
				ORDER BY id_tindakan");
		}

		function get_data_periode_bln($bln){
			return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, count(1) as jum_pem
				FROM pemeriksaan_radiologi
				WHERE left(tgl_kunjungan,7)  = '$bln'
				AND cetak_kwitansi='1'
				GROUP BY tgl");
		}

		function get_data_keuangan_bln($bln){
			return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, id_tindakan, jenis_tindakan, biaya_rad, count(id_tindakan) as jumlah_pasien, sum(qty) as jumlah_pemeriksaan, sum(vtot) as total
				FROM pemeriksaan_radiologi
				WHERE left(tgl_kunjungan,7) = '$bln'
				AND cetak_kwitansi='1'
				GROUP BY tgl, id_tindakan
				ORDER BY id_tindakan");
		}

		function get_data_periode_bln_bycarabayar($bln, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, count(1) as jum_pem
				FROM pemeriksaan_radiologi
				WHERE left(tgl_kunjungan,7)  = '$bln' and cara_bayar='$cara_bayar'
				AND cetak_kwitansi='1'
				GROUP BY tgl");
		}

		function get_data_keuangan_bln_bycarabayar($bln, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, id_tindakan, jenis_tindakan, biaya_rad, count(id_tindakan) as jumlah_pasien, sum(qty) as jumlah_pemeriksaan, sum(vtot) as total
				FROM pemeriksaan_radiologi
				WHERE left(tgl_kunjungan,7) = '$bln' and cara_bayar='$cara_bayar'
				AND cetak_kwitansi='1'
				GROUP BY id_tindakan, tgl
				ORDER BY tgl, id_tindakan");
		}

		function get_data_periode_thn($thn){
			return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, count(1) as jum_pem
				FROM pemeriksaan_radiologi
				WHERE left(tgl_kunjungan,4)  = '$thn'
				AND cetak_kwitansi='1'
				GROUP BY bln");
		}

		function get_data_keuangan_thn($thn){
			return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, id_tindakan, jenis_tindakan, biaya_rad, count(id_tindakan) as jumlah_pasien, sum(qty) as jumlah_pemeriksaan, sum(vtot) as total
				FROM pemeriksaan_radiologi
				WHERE left(tgl_kunjungan,4) = '$thn'
				AND cetak_kwitansi='1'
				GROUP BY bln, id_tindakan
				ORDER BY bln, id_tindakan");
		}

		function get_data_periode_thn_bycarabayar($thn, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, count(1) as jum_pem
				FROM pemeriksaan_radiologi
				WHERE left(tgl_kunjungan,4)  = '$thn' and cara_bayar='$cara_bayar'
				AND cetak_kwitansi='1'
				GROUP BY bln");
		}

		function get_data_keuangan_thn_bycarabayar($thn, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, id_tindakan, jenis_tindakan, biaya_rad, count(id_tindakan) as jumlah_pasien, sum(qty) as jumlah_pemeriksaan, sum(vtot) as total
				FROM pemeriksaan_radiologi
				WHERE left(tgl_kunjungan,4) = '$thn' and cara_bayar='$cara_bayar'
				AND cetak_kwitansi='1'
				GROUP BY id_tindakan, bln
				ORDER BY bln, id_tindakan");
		}

		function row_table_pertgl($tgl){
			return $this->db->query("SELECT Count(*)
				FROM pemeriksaan_radiologi
				WHERE  left(tgl_kunjungan,10)  = '$tgl'
				AND cetak_kwitansi='1'
				GROUP BY id_tindakan");
		}
		
		function row_table_pertgl_bycarabayar($tgl, $cara_bayar){
			return $this->db->query("SELECT Count(*)
				FROM pemeriksaan_radiologi
				WHERE  left(tgl_kunjungan,10)  = '$tgl'
				AND cetak_kwitansi='1'
				AND cara_bayar='$cara_bayar'
				GROUP BY id_tindakan");
		}

		function row_table_perbln($bln){
			return $this->db->query("SELECT Count(*)
				FROM pemeriksaan_radiologi
				WHERE  left(tgl_kunjungan,7)  = '$bln'
				AND cetak_kwitansi='1'
				GROUP BY id_tindakan");
		}
		
		function row_table_perbln_bycarabayar($bln, $cara_bayar){
			return $this->db->query("SELECT Count(*)
				FROM pemeriksaan_radiologi
				WHERE  left(tgl_kunjungan,7)  = '$bln'
				AND cetak_kwitansi='1'
				AND cara_bayar='$cara_bayar'
				GROUP BY id_tindakan");
		}
		
	}
?>