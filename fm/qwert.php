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
 

  $csv_output .= "";
	 
	 
  $i = 21;
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

$values = mysql_query("SELECT * FROM tbl_equipment " . $query."");
			
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
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".xls");
header("Content-disposition: filename=".$filename.".xls");
print $csv_output;

		}

	
	
	
	
	
	
	
	
	
	
		if(isset($_POST['SubmitButton'])){ 
			$cent = $_POST['centre'];
			$eqp = $_POST['equipment'];
			$eqptp = $_POST['equipment_type'];
			$appr = $_POST['approved'];
			



            
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
 

  $csv_output .= "Approved\tFault ID\t Submitted by\t Equipment code\t Serviced by\t Fault Type\t Description of fault\t Action Taken\t DoH \t User corrected?\t next service station correction?\t Engineer called out?\t Engineer callout ref.\t Equipment status\t Equipment downtime\t Screening down time\t Repeat films\t Cancelled patients\t Recalled patients\tSatisfied serviceing Organiation\tAgency satisfaction Engineer satisfaction\tEquipment satisfaction\t Enquiry to supplier\t Supplier action\t Supplier comment\t MDA notified\t Date of Fault\t Created On";
	 
	 
  $i = 28;
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

$values = mysql_query("SELECT * FROM tbl_fault " . $query."");
			
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
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".xls");
header("Content-disposition: filename=".$filename.".xls");
print $csv_output;

		}


?>
												
										