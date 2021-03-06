<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//
include(dirname(dirname(__FILE__)).'/Tglindo.php');
require_once(APPPATH.'controllers/Secure_area.php');
class Frmclaporanjual extends Secure_area {
    public function __construct() {
        parent::__construct();
        $this->load->model('logistik_farmasi/Frmmlaporanjual','',TRUE);
        $this->load->helper('pdf_helper');
        $this->load->helper('url');
        //include(site_url('/application/controllers/Tglindo.php'));
        //echo site_url('/application/controllers/Tglindo.php');
    }

public function index($tampil_per='', $param1=''){
        $data['title'] = 'Laporan Penjualan Obat Per Gudang';

        $tgl_indo=new Tglindo();
        $data['date_title']='<b>'.date("d F Y").'</b>';
        $data['tgl']=date("Y-m-d");

        /*$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-primary alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Pembelian.
			</h4>							
			</div>
		</div>";*/
        $data['message_nodata'] = "Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Penjualan";

        $this->load->view('logistik_farmasi/Frmvlaporanpenjualan',$data);
    }

    public function download_penjualan($param1='', $param2='', $filter=''){
        ////EXCEL
        $this->load->library('Excel');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $namars=$this->config->item('namars');
        $objPHPExcel->getProperties()->setCreator($namars)
            ->setLastModifiedBy($namars)
            ->setTitle("Laporan Penggunaan Matkes")
            ->setSubject("Laporan Penggunaan Matkes")
            ->setDescription("Laporan Penggunaan Matkes, generated by HMIS.")
            ->setKeywords($namars)
            ->setCategory("Laporan Penggunaan Matkes");

        $objReader= PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);

        $data_keuangan=$this->Frmmlaporanjual->get_data_penjualan($param1, $param2, $filter)->result();

        $objPHPExcel=$objReader->load(APPPATH.'third_party/lap_penggunaan_matkes.xlsx');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Add some data
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        // $objPHPExcel->getActiveSheet()->getStyle('G9')->getFont()->setBold(true);
        // $objPHPExcel->getActiveSheet()->getStyle('G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setAutoFilter('A9:C9');

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', "RUMKITAL dr. Mintohardjo");
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->getActiveSheet()->SetCellValue('A2', "DEPARTEMEN FARMASI");
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->getActiveSheet()->SetCellValue('A4', "Laporan Penggunaan Matkes");
        $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A4:G4');
        $objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('A5', "NO: -/ -/ 2019/ DEP.FAR");
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A5:G5');
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('A8', "Berdasarkan Perintah Kadep Far RUMKITAL dr. Mintohardjo sbb :");
        $objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A8:F8');
        $objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $rowCount = 10;
        $i=1;
        $tqty = 0;
        foreach($data_keuangan as $row){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nama_obat);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->qty);
            // $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->minggu);
            $tqty += $row->qty;

            $i++;
            $rowCount++;
        }
        $filename = "Laporan_Penggunaan_Matkes_".date('d F Y', strtotime($param1))."-".date('d F Y', strtotime($param2));
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Total : ");
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $tqty);
       

        // Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('RS AL dr. Mintohardjo');

        // Redirect output to a client’s web browser (Excel2007)
        //clean the output buffer
        ob_end_clean();
        ob_start();
        //this is the header given from PHPExcel examples.
        //but the output seems somewhat corrupted in some cases.
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //so, we use this header instead.
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
}