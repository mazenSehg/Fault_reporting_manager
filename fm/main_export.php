<?php
		
session_start();
//Load all functions
require_once('load.php');
require_once 'inc/PHPExcel.php';
ini_set('memory_limit', '-1');
set_time_limit(300);

error_reporting(1);

login_check();

if(isset($_POST['exportSubmitButton'])){ 
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	$inputFileType          = 'Excel2007';
	$inputFileName          = 'inc/fault_export_template.xlsx';
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
	$letters = range('A', 'Z');
	foreach(range('A', 'Z') as $outer) {
  		foreach(range('A', 'Z') as $inner) {
			$letters[] = $outer.$inner;
  		}
	}

	if($_SERVER['SERVER_ADDR'] == '10.161.146.74' || $_SERVER['SERVER_ADDR'] == '10.161.128.46') {
                $db = 'fault_management';
                $user = 'fault_user';
                $pass = 'fault_user';
                $host = '10.161.128.46';
                $host = '10.161.128.46';
                if($_SERVER['SERVER_ADDR'] == '10.161.146.74' ) {
                        $user = 'fault_user';
                        $pass = 'fault_user';
                        $host = '10.161.128.194';
                        $db = 'fault_management';
                }
        } else {
                $host = '10.161.128.194';
                $user = 'fault_user';
                $pass = 'fault_user';
                $db = 'fault_management';
        }
	$host = '10.161.128.194';
	$user = 'fault_user';
	$pass = 'fault_user';
	$db = 'fault_management';
        $link = mysqli_connect($host, $user, $pass, $db) or die("Can not connect." . mysqli_error());


        $queryfa = NULL;
        $queryeq = NULL;
        $queryce = NULL;
        if(isset($_POST['exportcentre']) && $_POST['exportcentre'] != '' && $_POST['exportcentre'] != 'undefined'){
                $queryfa .= ($queryfa != '') ? ' AND ' : ' WHERE ';
                $queryfa .= " f.centre = '".$_POST['exportcentre']."' ";
                $queryeq .= ($queryeq != '') ? ' AND ' : ' WHERE ';
                $queryeq .= " e.centre = '".$_POST['exportcentre']."' ";
                $queryce .= ($queryce != '') ? ' AND ' : ' WHERE ';
                $queryce .= " c.ID = '".$_POST['exportcentre']."' ";
        }
        if(isset($_POST['exportmanufacturer']) && $_POST['exportmanufacturer'] != '' &&  $_POST['exportmanufacturer'] != 'undefined'){
                $queryfa .= ($queryfa != '') ? ' AND ' : ' WHERE ';
                $queryfa .= " `manufacturer` = '".$_POST['exportmanufacturer']."' ";
                $queryeq .= ($queryeq != '') ? ' AND ' : ' WHERE ';
                $queryeq .= " e.manufacturer = '".$_POST['exportmanufacturer']."' ";
        }

        if(isset($_POST['exportequipment_type']) && $_POST['exportequipment_type'] != '' && $_POST['exportequipment_type'] != 'undefined'){
                $queryfa .= ($queryfa != '') ? ' AND ' : ' WHERE ';
                $queryfa .= " f.equipment_type = '".$_POST['exportequipment_type']."' ";
                $queryeq .= ($queryeq != '') ? ' AND ' : ' WHERE ';
                $queryeq .= " e.equipment_type = '".$_POST['exportequipment_type']."' ";
        }

        if(isset($_POST['exportmodel']) && $_POST['exportmodel'] != '' && $_POST['exportmodel'] != 'undefined'){
                $queryfa .= ($queryfa != '') ? ' AND ' : ' WHERE ';
                $queryfa .= " `model` = '".$_POST['exportmodel']."' ";
                $queryeq .= ($queryeq != '') ? ' AND ' : ' WHERE ';
                $queryeq .= " e.model = '".$_POST['exportmodel']."' ";
        }

        if(isset($_POST['exportdecommed']) && $_POST['exportdecommed'] != '' &&  $_POST['exportdecommed'] != 'undefined'){
                $queryeq .= ($queryeq != '') ? ' AND ' : ' WHERE ';
                $queryeq .= " e.decommed = '".$_POST['exportdecommed']."' ";
        }

        if(isset($_POST['exportapproved']) && $_POST['exportapproved'] != '' &&  $_POST['exportapproved'] != 'undefined'){
                $queryfa .= ($queryfa != '') ? ' AND ' : ' WHERE ';
                $queryfa .= " `approved` = '".$_POST['exportapproved']."' ";
        }

        if(isset($_POST['exportfault_type']) && $_POST['exportfault_type'] != '' && $_POST['exportfault_type'] != 'undefined'){
                $queryfa .= ($queryfa != '') ? ' AND ' : ' WHERE ';
                $queryfa .= " f.fault_type = '".$_POST['exportfault_type']."' ";
        }

        if(isset($_POST['exportfault_date_from']) && $_POST['exportfault_date_from'] != '' && $_POST['exportfault_date_from'] != 'undefined' && isset($_POST['exportfault_date_to']) && $_POST['exportfault_date_to'] != '' &&  $_POST['exportfault_date_to'] != 'undefined'){
                $queryfa .= ($queryfa != '') ? ' AND ' : ' WHERE ';
                $queryfa .= " ( `date_of_fault` >= '".date( 'Y-m-d', strtotime($_POST['exportfault_date_from']) )."' AND `date_of_fault` <= '".date( 'Y-m-d', strtotime($_POST['exportfault_date_to']) )."' ) ";
        }else if(isset($_POST['exportfault_date_from']) && $_POST['exportfault_date_from'] != '' &&  $_POST['exportfault_date_from'] != 'undefined' && ( !isset($_POST['exportfault_date_to']) || $_POST['exportfault_date_to'] == '' ||  $_POST['exportfault_date_to'] == 'undefined' ) ){
                $queryfa .= ($queryfa != '') ? ' AND ' : ' WHERE ';
                $queryfa .= "  `date_of_fault` >= '".date( 'Y-m-d', strtotime($_POST['exportfault_date_from']) )."' ";
        }else if( (!isset($_POST['exportfault_date_from']) || $_POST['exportfault_date_from'] == '' || $_POST['exportfault_date_from'] == 'undefined' ) && isset($_POST['exportfault_date_to']) && $_POST['exportfault_date_to'] != '' &&  $_POST['exportfault_date_to'] != 'undefined'){
                $queryfa .= ($queryfa != '') ? ' AND ' : ' WHERE ';
                $queryfa .= "  `date_of_fault` <= '".date( 'Y-m-d', strtotime($_POST['exportfault_date_to']) )."' ";
        }

	if(isset($_POST['exportcreate_date_from']) && $_POST['exportcreate_date_from'] != '' && $_POST['exportcreate_date_from'] != 'undefined' && isset($_POST['exportcreate_date_to']) && $_POST['exportcreate_date_to'] != '' &&  $_POST['exportcreate_date_to'] != 'undefined'){
		$queryfa .= ($queryfa != '') ? ' AND ' : ' WHERE ';
		$queryfa .= " ( f.created_on >= '".date( 'Y-m-d', strtotime($_POST['exportcreate_date_from']) )."' AND f.created_on <= '".date( 'Y-m-d', strtotime($_POST['exportcreate_date_to']) )."' ) ";
	}else if(isset($_POST['exportcreate_date_from']) && $_POST['exportcreate_date_from'] != '' &&  $_POST['exportcreate_date_from'] != 'undefined' && ( !isset($_POST['exportcreate_date_to']) || $_POST['exportcreate_date_to'] == '' ||  $_POST['exportcreate_date_to'] == 'undefined' ) ){
		$queryfa .= ($queryfa != '') ? ' AND ' : ' WHERE ';
		$queryfa .= "  f.created_on >= '".date( 'Y-m-d', strtotime($_POST['exportcreate_date_from']) )."' ";
	}else if( (!isset($_POST['exportcreate_date_from']) || $_POST['exportcreate_date_from'] == '' || $_POST['exportcreate_date_from'] == 'undefined' ) && isset($_POST['exportcreate_date_to']) && $_POST['exportcreate_date_to'] != '' &&  $_POST['exportcreate_date_to'] != 'undefined'){
		$queryfa .= ($queryfa != '') ? ' AND ' : ' WHERE ';
		$queryfa .= "  f.created_on <= '".date( 'Y-m-d', strtotime($_POST['exportcreate_date_to']) )."' ";
	}

        $i = null;
	$objPHPExcel->setActiveSheetIndex(0);
	$sql = "SELECT f.ID, user_id, f.equipment_code, null, null, f.current_servicing_agency, null, null, f.f_type_name, f.description_of_fault, action_taken, doh, fault_corrected_by_user, to_fix_at_next_service_visit, engineer_called_out, service_call_no, null,  equipment_downtime, screening_downtime, repeat_images, cancelled_women, technical_recalls, satisfied_servicing_organisation, satisfied_service_engineer, satisfied_equipment,  f.equipment_status, date_of_fault, null, f.created_on, supplier_enquiry, supplier_action, supplier_comments, adverse_incident_report  FROM tbl_fault f JOIN tbl_equipment e ON (f.equipment = e.ID) " . $queryfa;
	error_log($sql);

	$i = 32;
	$result = mysqli_query($link, $sql);
	$start_row = 2;
        while ($rowr = mysqli_fetch_row($result)) {
                for ($j=0;$j<$i;$j++) {
                         if($rowr[$j]!=null||$rowr[$j]!=""||strlen($rowr[$j])>0){
				$field = preg_replace('/[\n\r]+/', '', trim($rowr[$j]));
				$objPHPExcel->getActiveSheet()->setCellValue($letters[$j].$start_row, $field);
                        }
                }
		$start_row++;
        }

        $i = null;
	$objPHPExcel->setActiveSheetIndex(1);
        $i = 18;
        //$csv_output .= "Equipment Code\tCentre Code\tEquipment Type\tx-ray Subtype\tSupplier\tManfacturer\tModel\tLocation\tLocal ID\t ID Number\tYear Manufactured\tInstallation Year\tDecommisioned\tYear Decommisioned\tSpare\tComment\tServicing Agent ";
	$sql = "SELECT e.equipment_code, c.centre_code, et.name, e.x_ray, s.name, m.name, mo.name, e.location, e.location_id, e.serial_number, e.year_manufacturered, e.year_installed, e.decommed, e.year_decommisoned, e.spare, e.tomo, e.comment, null,  sa.name FROM tbl_equipment e LEFT OUTER JOIN tbl_centres c ON (e.centre = c.ID) LEFT OUTER JOIN tbl_equipment_type et ON (e.equipment_type = et.ID) LEFT OUTER JOIN tbl_supplier s ON (e.supplier = s.ID) LEFT OUTER JOIN tbl_manufacturer m ON (e.manufacturer = m.ID) LEFT OUTER JOIN tbl_model mo ON (e.model = mo.ID) LEFT OUTER JOIN tbl_service_agent sa ON (e.service_agent = sa.ID) " . $queryeq;
	error_log($sql);
	$result = mysqli_query($link, $sql);
	$start_row = 2;
	if($result) {
        while ($rowr = mysqli_fetch_row($result)) {
                for ($j=0;$j<$i;$j++) {
                         if($rowr[$j]!=null||$rowr[$j]!=""||strlen($rowr[$j])>0){
                                 $field = preg_replace('/[\n\r]+/', '', trim($rowr[$j]));
				 $code = null;
				/*
                                 if($j==1){
                                         $data = mysqli_query($link, "SELECT centre_code AS name FROM tbl_centres WHERE ID = ".$field.";");
                                         while ($da = mysqli_fetch_row($data)) {
                                        	$code =  $da[0];
                                         }
                                 }else if($j==4){
                                         $data = mysqli_query($link, "SELECT name AS name FROM tbl_supplier WHERE ID = ".$field.";");
                                         while ($da = mysqli_fetch_row($data)) {
						$code =  $da[0];
                                         }
                                 }else if($j==5){
                                         $data = mysqli_query($link, "SELECT name AS name FROM tbl_manufacturer WHERE ID = ".$field.";");
                                         while ($da = mysqli_fetch_row($data)) {
						$code =  $da[0];
                                         }
                                 }else if($j==6){
                                         $data = mysqli_query($link, "SELECT name AS name FROM tbl_model WHERE ID = ".$field.";");
                                         while ($da = mysqli_fetch_row($data)) {
						$code =  $da[0];
                                         }
                                 }else if($j==16){
                                         $data = mysqli_query($link, "SELECT name AS name FROM tbl_service_agent WHERE ID = ".$field.";");
                                         while ($da = mysqli_fetch_row($data)) {
						$code =  $da[0];
                                         }
                                 }
				*/
				if($code) {
					$objPHPExcel->getActiveSheet()->setCellValue($letters[$j].$start_row, $code);
				} else {
					$objPHPExcel->getActiveSheet()->setCellValue($letters[$j].$start_row, $field);
				}
                        }
                }
		$start_row++;
        }
        }


	$i = null;
        $objPHPExcel->setActiveSheetIndex(2);
        $sql = "SELECT centre_code, null, null, programme, c.name, null, null, r.name, null, ad1, ad2, ad3, ad4, postcode, phone, fax, support_Rad, support_Rad_email, programme_manag, programme_manage_e, c.approved, null, null, null, null, c.created_on  FROM tbl_centres c LEFT OUTER JOIN tbl_region r ON (c.region = r.ID) " . $queryce;
	error_log($sql);

        $i = 25;
        $result = mysqli_query($link, $sql);
        $start_row = 2;
	if($result) {
        while ($rowr = mysqli_fetch_row($result)) {
                for ($j=0;$j<$i;$j++) {
                         if($rowr[$j]!=null||$rowr[$j]!=""||strlen($rowr[$j])>0){
                                $field = preg_replace('/[\n\r]+/', '', trim($rowr[$j]));
                                $objPHPExcel->getActiveSheet()->setCellValue($letters[$j].$start_row, $field);
                        }
                }
                $start_row++;
        }
        }

        $filename = "fr_export_".date("Y-m-d_H-i",time());

	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
	header('Cache-Control: max-age=0');
	header('Cache-Control: max-age=1');
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	
}


?>
												
										
