<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_pasien extends CI_Model {   
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_pelayanan() 
    {        
        $no_cm = $this->input->post('no_cm');      
        $query = $this->db->query("
            SELECT a.no_cm,a.nama,b.no_register,b.no_sep,b.tgl_kunjungan,b.tgl_pulang,c.payor_cd AS jaminan,c.cbg_code,c.status_kirim FROM data_pasien AS a INNER JOIN daftar_ulang_irj AS b ON a.no_medrec = b.no_medrec LEFT JOIN inacbg_klaim AS c ON b.no_register = c.no_register WHERE a.no_cm = '$no_cm' AND b.cara_bayar = 'BPJS' AND b.no_sep != '' AND b.tgl_pulang != ''
            UNION ALL
            SELECT a.no_cm,a.nama,b.no_ipd AS no_register,b.no_sep,b.tgl_masuk AS tgl_kunjungan,b.tgl_keluar AS tgl_pulang,c.payor_cd AS jaminan,c.cbg_code,c.status_kirim FROM data_pasien AS a INNER JOIN pasien_iri AS b ON a.no_medrec = b.no_cm LEFT JOIN inacbg_klaim AS c ON b.no_ipd = c.no_register WHERE a.no_cm = '$no_cm' AND b.carabayar = 'BPJS' AND b.no_sep != '' AND b.tgl_keluar != ''
            ORDER BY tgl_kunjungan DESC
        ");     
        return $query->result();
    } 

    public function filtered_pelayanan()
    {        
        $no_cm = $this->input->post('no_cm');      
        $query = $this->db->query("
            SELECT a.no_cm,a.nama,b.no_register,b.no_sep,b.tgl_kunjungan,b.tgl_pulang,c.payor_cd AS jaminan,c.cbg_code,c.status_kirim FROM data_pasien AS a INNER JOIN daftar_ulang_irj AS b ON a.no_medrec = b.no_medrec LEFT JOIN inacbg_klaim AS c ON b.no_register = c.no_register WHERE a.no_cm = '$no_cm' AND b.cara_bayar = 'BPJS' AND b.no_sep != '' AND b.tgl_pulang != ''
            UNION ALL
            SELECT a.no_cm,a.nama,b.no_ipd AS no_register,b.no_sep,b.tgl_masuk AS tgl_kunjungan,b.tgl_keluar AS tgl_pulang,c.payor_cd AS jaminan,c.cbg_code,c.status_kirim FROM data_pasien AS a INNER JOIN pasien_iri AS b ON a.no_medrec = b.no_cm LEFT JOIN inacbg_klaim AS c ON b.no_ipd = c.no_register WHERE a.no_cm = '$no_cm' AND b.carabayar = 'BPJS' AND b.no_sep != '' AND b.tgl_keluar != ''
        ");      
        return $query->num_rows();
    }

    public function count_pelayanan()
    {
        $no_cm = $this->input->post('no_cm');      
        $query = $this->db->query("
            SELECT a.no_cm,a.nama,b.no_register,b.no_sep,b.tgl_kunjungan,b.tgl_pulang,c.payor_cd AS jaminan,c.cbg_code,c.status_kirim FROM data_pasien AS a INNER JOIN daftar_ulang_irj AS b ON a.no_medrec = b.no_medrec LEFT JOIN inacbg_klaim AS c ON b.no_register = c.no_register WHERE a.no_cm = '$no_cm' AND b.cara_bayar = 'BPJS' AND b.no_sep != '' AND b.tgl_pulang != ''
            UNION ALL
            SELECT a.no_cm,a.nama,b.no_ipd AS no_register,b.no_sep,b.tgl_masuk AS tgl_kunjungan,b.tgl_keluar AS tgl_pulang,c.payor_cd AS jaminan,c.cbg_code,c.status_kirim FROM data_pasien AS a INNER JOIN pasien_iri AS b ON a.no_medrec = b.no_cm LEFT JOIN inacbg_klaim AS c ON b.no_ipd = c.no_register WHERE a.no_cm = '$no_cm' AND b.carabayar = 'BPJS' AND b.no_sep != '' AND b.tgl_keluar != ''
        ");   
        return $this->db->count_all_results();
    } 

    function get_autocomplete($q)
    {   
        $query=$this->db->query("
            SELECT data_pasien.no_cm,data_pasien.nama,data_pasien.sex,data_pasien.tgl_lahir,data_pasien.no_kartu FROM data_pasien JOIN daftar_ulang_irj ON data_pasien.no_medrec=daftar_ulang_irj.no_medrec WHERE daftar_ulang_irj.no_sep LIKE '%$q%' GROUP BY data_pasien.no_medrec
            UNION
            SELECT data_pasien.no_cm,data_pasien.nama,data_pasien.sex,data_pasien.tgl_lahir,data_pasien.no_kartu FROM data_pasien JOIN pasien_iri ON data_pasien.no_medrec=pasien_iri.no_cm WHERE pasien_iri.no_sep LIKE '%$q%' GROUP BY data_pasien.no_medrec
            UNION
            SELECT data_pasien.no_cm,data_pasien.nama,data_pasien.sex,data_pasien.tgl_lahir,data_pasien.no_kartu FROM data_pasien JOIN daftar_ulang_irj ON data_pasien.no_medrec=daftar_ulang_irj.no_medrec WHERE no_cm LIKE '%$q%' GROUP BY data_pasien.no_medrec
            UNION
            SELECT data_pasien.no_cm,data_pasien.nama,data_pasien.sex,data_pasien.tgl_lahir,data_pasien.no_kartu FROM data_pasien JOIN daftar_ulang_irj ON data_pasien.no_medrec=daftar_ulang_irj.no_medrec WHERE nama LIKE '%$q%' GROUP BY data_pasien.no_medrec
            UNION
            SELECT data_pasien.no_cm,data_pasien.nama,data_pasien.sex,data_pasien.tgl_lahir,data_pasien.no_kartu FROM data_pasien JOIN daftar_ulang_irj ON data_pasien.no_medrec=daftar_ulang_irj.no_medrec WHERE no_identitas LIKE '%$q%' AND jenis_identitas='KTP' GROUP BY data_pasien.no_medrec limit 100"
        );
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                $new_row['label'] = htmlentities(stripslashes($row['no_cm'].' - '.$row['nama']));
                $new_row['value'] = htmlentities(stripslashes($q));
                $new_row['no_cm'] = htmlentities(stripslashes($row['no_cm']));
                $new_row['nama'] = htmlentities(stripslashes($row['nama']));
                $new_row['gender'] = htmlentities(stripslashes($row['sex']));
                $new_row['tgl_lahir'] = htmlentities(stripslashes(date("d-m-Y", strtotime($row['tgl_lahir']))));
                $new_row['no_kartu'] = htmlentities(stripslashes($row['no_kartu']));
                $row_set[] = $new_row;
            }
            echo json_encode($row_set);
        } else {        
            echo json_encode([]);
        }
    }

    function get_tarif_rs($no_register) 
    {
        $this->db->FROM('inacbg_tarif_rs');
        if (substr($no_register, 0,2) == 'RJ') {
            $this->db->JOIN('daftar_ulang_irj', 'inacbg_tarif_rs.no_register = daftar_ulang_irj.no_register', 'inner');
        }
        if (substr($no_register, 0,2) == 'RI') {
            $this->db->JOIN('pasien_iri', 'inacbg_tarif_rs.no_register = pasien_iri.no_ipd', 'inner');
        }                           
        $this->db->where('inacbg_tarif_rs.no_register', $no_register);
        $query = $this->db->get();
        return $query->row();
    }  

    function update_tarif_rs($no_register,$data_update) 
    {
        $this->db->where('no_register', $no_register);
        $q = $this->db->get('inacbg_tarif_rs');
        $this->db->reset_query();

        if ( $q->num_rows() > 0 ) 
        {
            $this->db->where('no_register', $no_register);
            $this->db->update('inacbg_tarif_rs', $data_update);
        } else {            
            $this->db->set('no_register', $no_register);
            $this->db->insert('inacbg_tarif_rs', $data_update);    
        }        
        return true;
    }   

    function get_dokter($id_dokter) 
    {
        $this->db->FROM('data_dokter');
        $this->db->SELECT('nm_dokter');   
        $this->db->where('id_dokter', $id_dokter);
        $query = $this->db->get();
        return $query->row();
    }   

    /////////////////////////////////// Rawat Jalan ///////////////////////////////////

    function show_pelayanan_irj($no_register) {
        $this->db->FROM('daftar_ulang_irj');
        $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');          
        $this->db->SELECT('daftar_ulang_irj.no_sep,daftar_ulang_irj.vtot_rad,daftar_ulang_irj.vtot_obat,daftar_ulang_irj.vtot_lab,daftar_ulang_irj.biaya_alkes,data_pasien.no_kartu,daftar_ulang_irj.tgl_kunjungan,daftar_ulang_irj.tgl_pulang,daftar_ulang_irj.id_dokter,data_pasien.no_cm,data_pasien.nama,data_pasien.tgl_lahir,data_pasien.sex as gender,daftar_ulang_irj.no_medrec,daftar_ulang_irj.id_poli,daftar_ulang_irj.ket_pulang,data_pasien.kelas_bpjs');   
        $this->db->where('no_register', $no_register);
        $query = $this->db->get();
        return $query->row();
    }  

    function diagnosa_irj($no_sep) 
    {
        $this->db->FROM('daftar_ulang_irj');
        $this->db->JOIN('diagnosa_pasien', 'daftar_ulang_irj.no_register = diagnosa_pasien.no_register', 'inner');
        $this->db->SELECT('diagnosa_pasien.no_register,diagnosa_pasien.nm_dokter,diagnosa_pasien.id_diagnosa,diagnosa_pasien.klasifikasi_diagnos,diagnosa_pasien.diagnosa');   
        $this->db->where('no_sep', $no_sep);
        $query = $this->db->get();
        return $query->result();
    }    

    function procedure_irj($no_sep) 
    {
        $this->db->FROM('daftar_ulang_irj');
        $this->db->JOIN('icd9cm_irj', 'daftar_ulang_irj.no_register = icd9cm_irj.no_register', 'inner');
        $this->db->SELECT('icd9cm_irj.no_register,icd9cm_irj.id_procedure,icd9cm_irj.nm_procedure,icd9cm_irj.klasifikasi_procedure');   
        $this->db->where('no_sep', $no_sep);
        $query = $this->db->get();
        return $query->result();
    }      

    /////////////////////////////////// Rawat Inap /////////////////////////////////// 

    function show_pelayanan_iri($no_register) {
        $this->db->FROM('pasien_iri as a');
        $this->db->JOIN('data_pasien as b', 'a.no_cm = b.no_medrec', 'inner');          
        $this->db->SELECT('a.no_sep,a.vtot_rad,a.vtot_obat,a.vtot_lab,a.biaya_alkes,b.no_kartu,a.tgl_masuk,a.tgl_keluar,a.id_dokter,b.no_cm,b.nama,b.tgl_lahir,b.sex as gender,a.no_cm,a.keadaanpulang,b.kelas_bpjs');   
        $this->db->where('no_ipd', $no_register);
        $query = $this->db->get();
        return $query->row();
    }  

    function diagnosa_iri($no_sep) 
    {
        $this->db->FROM('daftar_ulang_irj');
        $this->db->JOIN('diagnosa_pasien', 'daftar_ulang_irj.no_register = diagnosa_pasien.no_register', 'inner');
        $this->db->SELECT('diagnosa_pasien.no_register,diagnosa_pasien.nm_dokter,diagnosa_pasien.id_diagnosa,diagnosa_pasien.klasifikasi_diagnos,diagnosa_pasien.diagnosa');   
        $this->db->where('no_sep', $no_sep);
        $query = $this->db->get();
        return $query->result();
    }    

    function procedure_iri($no_sep) 
    {
        $this->db->FROM('daftar_ulang_irj');
        $this->db->JOIN('icd9cm_irj', 'daftar_ulang_irj.no_register = icd9cm_irj.no_register', 'inner');
        $this->db->SELECT('icd9cm_irj.no_register,icd9cm_irj.id_procedure,icd9cm_irj.nm_procedure,icd9cm_irj.klasifikasi_procedure');   
        $this->db->where('no_sep', $no_sep);
        $query = $this->db->get();
        return $query->result();
    }   
                                                                     
}
?>