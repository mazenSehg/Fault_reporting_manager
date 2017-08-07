<?php
		
session_start();
//Load all functions
require_once('load.php');

login_check();

	if(isset($_POST['SubmitButtonEquipment'])){ 

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

       
$table = 'tbl_equipment';
            
            
            
            
            
            
            
            
$file = 'export';
		
		$i = null;
		$csv_output = null;
 
$link = mysql_connect($host, $user, $pass) or die("Can not connect." . mysql_error());
mysql_select_db($db) or die("Can not connect.");
 

  $csv_output .= "Equipment Code\tCentre Code\tEquipment Type\tx-ray Subtype\tSupplier\tManfacturer\tModel\tLocation\tLocal ID\t ID Number\tYear Manufactured\tInstallation Year\tDecommisioned\tYear Decommisioned\tSpare\tComment\tServicing Agent ";
	 
	 
  $i = 17;
$csv_output .= "\n";

						$query = NULL;
if(isset($_POST['centre']) && $_POST['centre'] != '' && $_POST['centre'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " `centre` = '".$_POST['centre']."' ";
		}

		if(isset($_POST['manufacturer']) && $_POST['manufacturer'] != '' &&  $_POST['manufacturer'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " `manufacturer` = '".$_POST['manufacturer']."' ";
		}

		if(isset($_POST['equipment_type']) && $_POST['equipment_type'] != '' && $_POST['equipment_type'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " `equipment_type` = '".$_POST['equipment_type']."' ";
		}

		if(isset($_POST['model']) && $_POST['model'] != '' && $_POST['model'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " `model` = '".$_POST['model']."' ";
		}

		if(isset($_POST['approved']) && $_POST['approved'] != '' &&  $_POST['approved'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " `approved` = '".$_POST['approved']."' ";
		}
		
		if(isset($_POST['decommed']) && $_POST['decommed'] != '' &&  $_POST['decommed'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " `decommed` = '".$_POST['decommed']."' ";
		}

		if(isset($_POST['fault_date_from']) && $_POST['fault_date_from'] != '' && $_POST['fault_date_from'] != 'undefined' && isset($_POST['fault_date_to']) && $_POST['fault_date_to'] != '' &&  $_POST['fault_date_to'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " ( `date_of_fault` >= '".date( 'Y-m-d', strtotime($_POST['fault_date_from']) )."' AND `date_of_fault` <= '".date( 'Y-m-d', strtotime($_POST['fault_date_to']) )."' ) ";
		}else if(isset($_POST['fault_date_from']) && $_POST['fault_date_from'] != '' &&  $_POST['fault_date_from'] != 'undefined' && ( !isset($_POST['fault_date_to']) || $_POST['fault_date_to'] == '' ||  $_POST['fault_date_to'] == 'undefined' ) ){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= "  `date_of_fault` >= '".date( 'Y-m-d', strtotime($_POST['fault_date_from']) )."' ";
		}else if( (!isset($_POST['fault_date_from']) || $_POST['fault_date_from'] == '' || $_POST['fault_date_from'] == 'undefined' ) && isset($_POST['fault_date_to']) && $_POST['fault_date_to'] != '' &&  $_POST['fault_date_to'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= "  `date_of_fault` <= '".date( 'Y-m-d', strtotime($_POST['fault_date_to']) )."' ";
		}				

$values = mysql_query("SELECT equipment_code,centre,type_name,x_ray, supplier, manufacturer, model, location, location_id, serial_number, year_manufacturered, year_installed, decommed, year_decommisoned, spare, comment, service_agent FROM tbl_equipment " . $query."");
			
while ($rowr = mysql_fetch_row($values)) {
 for ($j=0;$j<$i;$j++) {
	 if($rowr[$j]!=null||$rowr[$j]!=""||strlen($rowr[$j])>0){
		 $field = preg_replace('/[\n\r]+/', '', trim($rowr[$j]));
		 if($j==1){
			 $data = mysql_query("SELECT centre_code AS name FROM tbl_centres WHERE ID = ".$field.";");
			 while ($da = mysql_fetch_row($data)) {
			$code =  $da[0];	 
			 }
			 $csv_output .= $code."\t";
		 }else if($j==4){
			 $data = mysql_query("SELECT name AS name FROM tbl_supplier WHERE ID = ".$field.";");
			 while ($da = mysql_fetch_row($data)) {
			$code =  $da[0];	 
			 }
			 $csv_output .= $code."\t";
		 }else if($j==5){
			 $data = mysql_query("SELECT name AS name FROM tbl_manufacturer WHERE ID = ".$field.";");
			 while ($da = mysql_fetch_row($data)) {
			$code =  $da[0];	 
			 }
			 $csv_output .= $code."\t";
		 }else if($j==6){
			 $data = mysql_query("SELECT name AS name FROM tbl_model WHERE ID = ".$field.";");
			 while ($da = mysql_fetch_row($data)) {
			$code =  $da[0];	 
			 }
			 $csv_output .= $code."\t";
		 }else if($j==16){
			 $data = mysql_query("SELECT name AS name FROM tbl_service_agent WHERE ID = ".$field.";");
			 while ($da = mysql_fetch_row($data)) {
			$code =  $da[0];	 
			 }
			 $csv_output .= $code."\t";
		 }else{
  		$csv_output .= $field."\t";  			 
		 }
}else{
	  $csv_output .=""."\t";
}
 }
 $csv_output .= "\n";
}
 
$filename = $file."_".date("Y-m-d_H-i",time());
header("Content-type: application/xls");
header("Content-disposition: csv" . date("Y-m-d") . ".xls");
header("Content-disposition: filename=".$filename.".xls");
print $csv_output;

		}

	
	
	
	
	
	
	
	
	
	
		if(isset($_POST['SubmitButton'])){ 
            
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

       
$table = 'tbl_fault';
            
            
            
            
            
            
            
            
$file = 'export';
		
		$i = null;
		$csv_output = null;
 
$link = mysql_connect($host, $user, $pass) or die("Can not connect." . mysql_error());
mysql_select_db($db) or die("Can not connect.");
 

  $csv_output .= "Fault ID\tReporter ID\tEquipment Code\tServiced By\tType of Fault\tFault Description\tAction Taken\tDOH Action\tUser corrected Fault\tCorrection at next service Visit\tEngineer called out\tEngineer Callout Number\tEquipment Downtime\tScreening Downtime\tRepeat Films\tCancelled Patients\tRecalled Patients\tAgency Satisfaction\tEngineer Satisfaction\tEquipment use Status\tDate of Fault\tDate of Form\tDate of Entry\tEnquiery to Supplier\tSupplier Act\tSupplier Comment\tMDA Notified";
	 
	 
  $i = 26;
$csv_output .= "\n";

						$query = NULL;
if(isset($_POST['centre']) && $_POST['centre'] != '' && $_POST['centre'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " `centre` = '".$_POST['centre']."' ";
		}

		if(isset($_POST['equipment']) && $_POST['equipment'] != '' &&  $_POST['equipment'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " `equipment` = '".$_POST['equipment']."' ";
		}

		if(isset($_POST['equipment_type']) && $_POST['equipment_type'] != '' && $_POST['equipment_type'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " `equipment_type` = '".$_POST['equipment_type']."' ";
		}

		if(isset($_POST['fault_type']) && $_POST['fault_type'] != '' && $_POST['fault_type'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " `fault_type` = '".$_POST['fault_type']."' ";
		}

		if(isset($_POST['approved']) && $_POST['approved'] != '' &&  $_POST['approved'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " `approved` = '".$_POST['approved']."' ";
		}
		
		if(isset($_POST['manufacturer']) && $_POST['manufacturer'] != '' &&  $_POST['manufacturer'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " `eq_manufac` = '".$_POST['manufacturer']."' ";
		}

		if(isset($_POST['fault_date_from']) && $_POST['fault_date_from'] != '' && $_POST['fault_date_from'] != 'undefined' && isset($_POST['fault_date_to']) && $_POST['fault_date_to'] != '' &&  $_POST['fault_date_to'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " ( `date_of_fault` >= '".date( 'Y-m-d', strtotime($_POST['fault_date_from']) )."' AND `date_of_fault` <= '".date( 'Y-m-d', strtotime($_POST['fault_date_to']) )."' ) ";
		}else if(isset($_POST['fault_date_from']) && $_POST['fault_date_from'] != '' &&  $_POST['fault_date_from'] != 'undefined' && ( !isset($_POST['fault_date_to']) || $_POST['fault_date_to'] == '' ||  $_POST['fault_date_to'] == 'undefined' ) ){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= "  `date_of_fault` >= '".date( 'Y-m-d', strtotime($_POST['fault_date_from']) )."' ";
		}else if( (!isset($_POST['fault_date_from']) || $_POST['fault_date_from'] == '' || $_POST['fault_date_from'] == 'undefined' ) && isset($_POST['fault_date_to']) && $_POST['fault_date_to'] != '' &&  $_POST['fault_date_to'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= "  `date_of_fault` <= '".date( 'Y-m-d', strtotime($_POST['fault_date_to']) )."' ";
		}				

$values = mysql_query("SELECT ID, user_id, equipment_code, current_servicing_agency, f_type_name, description_of_fault, action_taken, doh, fault_corrected_by_user, to_fix_at_next_service_visit, engineer_called_out, service_call_no, equipment_downtime, screening_downtime, repeat_images, cancelled_women, technical_recalls, satisfied_servicing_organisation, satisfied_service_engineer, equipment_status, date_of_fault, created_on,created_on, supplier_enquiry, supplier_action, supplier_comments, adverse_incident_report  FROM tbl_fault " . $query."");
			
while ($rowr = mysql_fetch_row($values)) {
 for ($j=0;$j<$i;$j++) {
	 if($rowr[$j]!=null||$rowr[$j]!=""||strlen($rowr[$j])>0){
		 $field = preg_replace('/[\n\r]+/', '', trim($rowr[$j]));
  $csv_output .= $field."\t";
}else{
	  $csv_output .=""."\t";
}
 }
 $csv_output .= "\n";
}
 
$filename = $file."_".date("Y-m-d_H-i",time());
header("Content-type: application/xls");
header("Content-disposition: csv" . date("Y-m-d") . ".xls");
header("Content-disposition: filename=".$filename.".xls");
print $csv_output;

		}


?>
												
										