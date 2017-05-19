<?php
session_start();
//Load all functions
require_once('load.php');

login_check();
?>










<?php






//TO UPDATE MANUFACTURER IN TBL_EQUIPMENTs
////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////
//
//
//	$sql = "SELECT * FROM tbl_equipment WHERE manufacturer = ''";
//	$r = $db->get_results($sql);
//foreach($r as $a):
//
//	$sql1 = "SELECT * FROM tbl_model WHERE ID = $a->model";
//	$rr = $db->get_results($sql1);
//	foreach($rr as $b):
//
//		$sql4 = "UPDATE tbl_equipment SET manufacturer='$b->manufacturer' WHERE manufacturer = '$a->manufacturer'";
//		$sq5 = $db->query($sql4);
//
//
//	endforeach;
//
//endforeach;




/**
												CODE TO UPDATE NAMES, MODEL< SERVICE AGENT FOR FAULTS TABLE
										
										
								$aql1 = "SELECT * FROM tbl_equipment";
								$aq = $db->get_results($aql1);


								foreach($aq as $bob):
									$sql1 = "SELECT * FROM tbl_manufacturer WHERE ID = $bob->manufacturer";
									$aq1 = $db->get_results($sql1);

									foreach ($aq1 as $bob1):

									$sql2 = "SELECT * FROM tbl_model WHERE manufacturer = $bob->manufacturer";
									$aq2 = $db->get_results($sql2);

									foreach ($aq2 as $bob2):

									$bowe = $bob2->ID;

								$sting = $bob1->name;
								if($bob2->name!= null){
									$sting = $sting . " | ".$bob2->name;
								}
								if($bob->serial_number !=null){
								$sting = $sting . " | " . $bob->serial_number;
								}
								if($bob->year_installed!=null){
								$sting = $sting . " | " . $bob->year_installed;
								}
								if($bob->location_id!=null){
								$sting = $sting . " | " . $bob->location_id;
								}
								if($bob->location!=null){
								$sting = $sting	. " | ". $bob->location;		
								}


									endforeach;


									endforeach;
								$sql8 = "SELECT * FROM tbl_service_agent WHERE equipment_type LIKE '%$bob->equipment_type%'";
								$sql88 = $db->get_results($sql8);
								foreach($sql88 as $qwey):
								echo $bob->name."--".$qwey->ID;
								echo "<br>";
								endforeach;

								$IDD = $bob->ID;
								$hi="HI";
																	//echo $sting;


								$sql4 = "UPDATE tbl_equipment SET name='$sting' WHERE ID = '$IDD'";
								$sq5 = $db->query($sql4);

								$sql46 = "UPDATE tbl_equipment SET model='$bowe' WHERE ID = '$IDD'";
								$sq6 = $db->query($sql46);

								$sql47 = "UPDATE tbl_equipment SET service_agent='$bowe' WHERE ID = '$IDD'";
								$sq7 = $db->query($sql47);


								endforeach;

								




**/


/**


								CODE TO UPDATE EQUIPMENT TYPE AND CENTRE IN FAULT
								
										$sql1 = "SELECT * FROM tbl_fault";
										$sq = $db->get_results($sql1);
										foreach($sq as $res):
												$IDD = $res->ID;
										$val1 = 0;
										$val2 = 0;
										$sql2 = "SELECT * FROM tbl_equipment WHERE ID = $res->equipment";
										$sq1 = $db->get_results($sql2);
										foreach($sq1 as $res1):
												
										$val1 = $res1->equipment_type;
										$val2 = $res1->centre;
	
												
										endforeach;
												
										echo $res->ID;
										echo "---";
										echo $val1;
										echo "---";
										echo $val2;
										echo "<br>";	
										$sql4 = "UPDATE tbl_fault SET equipment_type='$val1', centre='$val2' WHERE ID = '$IDD'";
										$sq5 = $db->query($sql4);

										endforeach;
										
										
										PLA4L
										Fuji | Amulet | 8041107 | 2004 | RLI
										
										DCB9L
										Kodak | Dryview 8300 | K311-7355 | 2001 | St Barts
										
										**/
												
												
												

										?>
												
												
<?php
												/**

												$sql = "SELECT * FROM tbl_fault";
												$re = $db->get_results($sql);
												foreach($re as $res){
													
													$sql1 = "SELECT * FROM tbl_equipment WHERE ID = $res->equipment";
													$re1 = $db->get_results($sql1);
													$equip;
													foreach($re1 as $res1){
														$equip = $res1->name;
														
														$sql2 = "SELECT * FROM tbl_equipment_type WHERE ID = $res->equipment_type";
														$re2 = $db->get_results($sql2);
														$type;
														foreach ($re2 as $res2){
														$type = $res2->name;
															
															$sql3 = "SELECT * FROM tbl_centres WHERE ID = $res->centre";
															$re3 = $db->get_results($sql3);
															$centre;
															foreach ($re3 as $res3){
																$centre = $res3->name;
															
																$sql4 = "SELECT * FROM tbl_fault_type WHERE ID = $res->fault_type";
																$re4 = $db->get_results($sql4);
																$f_type;
																foreach($re4 as $res4){
																	$f_type = $res4->name;
																	
																}
																
															}
															
														}
														
													}
													
													echo $res->ID . " - " . $equip . " - " . $type . " - " . $centre . " - " . $f_type;
													echo "<br>";
													$sql4 = "UPDATE tbl_fault SET equipment_name='$equip', e_type_name='$type', centre_name='$centre', f_type_name='$f_type' WHERE ID = '$res->ID'";
										$sq5 = $db->query($sql4);
													
													
												}
												**/

//$sql = "SELECT * FROM tbl_fault";
//$res = $db->get_results($sql);
//foreach($res as $val):
//echo "EQUIPMENT ID: ". $val->equipment;
//		$sql1 = "SELECT * FROM tbl_equipment WHERE ID = $val->equipment";
//		$res1 = $db->get_results($sql1);
//
//
//
//foreach($res1 as $val1):
//echo "EQUIPMENT CODE: ". $val1->equipment_code;
//$ams = $val1->equipment_code;
//echo "<br>";
//
//
//
//
//			endforeach;
//	$sql2 = "UPDATE tbl_fault SET equipment_code='$ams' WHERE equipment = '$val->equipment'";
//$res4 = $db->query($sql2);
//
//endforeach;
//



//$sql1 = "SELECT * FROM tbl_fault";
//$res = $db->get_results($sql1);
//foreach($res as $vac):
//
//$sql1 = "SELECT * FROM tbl_"
//
//endforeach;






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
		
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'fault-management';
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
 
if($cent!=""&&$appr!=""&&$eqptp!=""&&$eqp!=""){
				
								$values = mysql_query("SELECT approved, ID,  user_id, equipment_code,  current_servicing_agency,  f_type_name,  description_of_fault,  action_taken, doh, fault_corrected_by_user,  to_fix_at_next_service_visit,  engineer_called_out,  service_call_no,  equipment_status,  equipment_downtime,  screening_downtime,  repeat_images,  cancelled_women,  technical_recalls,  satisfied_servicing_organisation,  satisfied_service_engineer,  satisfied_equipment,  supplier_enquiry,  supplier_action,  supplier_comments,  adverse_incident_report,  date_of_fault, created_on FROM ".$table." WHERE centre=".$cent." AND approved = ".$appr." AND equipment_type = ".$eqptp." AND equipment=".$eqp."");
				
			}elseif($cent!=""&&$appr!=""&&$eqptp!=""){
									$values = mysql_query("SELECT approved, ID,  user_id, equipment_code,  current_servicing_agency,  f_type_name,  description_of_fault,  action_taken, doh, fault_corrected_by_user,  to_fix_at_next_service_visit,  engineer_called_out,  service_call_no,  equipment_status,  equipment_downtime,  screening_downtime,  repeat_images,  cancelled_women,  technical_recalls,  satisfied_servicing_organisation,  satisfied_service_engineer,  satisfied_equipment,  supplier_enquiry,  supplier_action,  supplier_comments,  adverse_incident_report,  date_of_fault, created_on FROM ".$table." WHERE centre=".$cent." AND approved = ".$appr." AND equipment_type = ".$eqptp."");
	
}elseif($cent!=""&&$appr!=""){
										$values = mysql_query("SELECT approved, ID,  user_id, equipment_code,  current_servicing_agency,  f_type_name,  description_of_fault,  action_taken, doh, fault_corrected_by_user,  to_fix_at_next_service_visit,  engineer_called_out,  service_call_no,  equipment_status,  equipment_downtime,  screening_downtime,  repeat_images,  cancelled_women,  technical_recalls,  satisfied_servicing_organisation,  satisfied_service_engineer,  satisfied_equipment,  supplier_enquiry,  supplier_action,  supplier_comments,  adverse_incident_report,  date_of_fault, created_on FROM ".$table." WHERE centre=".$cent." AND approved = ".$appr."");
}elseif($cent!=""&&$eqptp!=""){
										$values = mysql_query("SELECT approved, ID,  user_id, equipment_code,  current_servicing_agency,  f_type_name,  description_of_fault,  action_taken, doh, fault_corrected_by_user,  to_fix_at_next_service_visit,  engineer_called_out,  service_call_no,  equipment_status,  equipment_downtime,  screening_downtime,  repeat_images,  cancelled_women,  technical_recalls,  satisfied_servicing_organisation,  satisfied_service_engineer,  satisfied_equipment,  supplier_enquiry,  supplier_action,  supplier_comments,  adverse_incident_report,  date_of_fault, created_on FROM ".$table." WHERE centre=".$cent." AND equipment_type = ".$eqptp."");
}
			elseif($cent!=""){
											$values = mysql_query("SELECT approved, ID,  user_id, equipment_code,  current_servicing_agency,  f_type_name,  description_of_fault,  action_taken, doh, fault_corrected_by_user,  to_fix_at_next_service_visit,  engineer_called_out,  service_call_no,  equipment_status,  equipment_downtime,  screening_downtime,  repeat_images,  cancelled_women,  technical_recalls,  satisfied_servicing_organisation,  satisfied_service_engineer,  satisfied_equipment,  supplier_enquiry,  supplier_action,  supplier_comments,  adverse_incident_report,  date_of_fault, created_on FROM ".$table." WHERE centre=".$cent."");
	
}
			
						elseif($eqptp!=""){
											$values = mysql_query("SELECT approved, ID,  user_id, equipment_code,  current_servicing_agency,  f_type_name,  description_of_fault,  action_taken, doh, fault_corrected_by_user,  to_fix_at_next_service_visit,  engineer_called_out,  service_call_no,  equipment_status,  equipment_downtime,  screening_downtime,  repeat_images,  cancelled_women,  technical_recalls,  satisfied_servicing_organisation,  satisfied_service_engineer,  satisfied_equipment,  supplier_enquiry,  supplier_action,  supplier_comments,  adverse_incident_report,  date_of_fault, created_on FROM ".$table." WHERE equipment_type = ".$eqptp."");
	
}
			
									elseif($eqp!=""){
											$values = mysql_query("SELECT approved, ID,  user_id, equipment_code,  current_servicing_agency,  f_type_name,  description_of_fault,  action_taken, doh, fault_corrected_by_user,  to_fix_at_next_service_visit,  engineer_called_out,  service_call_no,  equipment_status,  equipment_downtime,  screening_downtime,  repeat_images,  cancelled_women,  technical_recalls,  satisfied_servicing_organisation,  satisfied_service_engineer,  satisfied_equipment,  supplier_enquiry,  supplier_action,  supplier_comments,  adverse_incident_report,  date_of_fault, created_on FROM ".$table." WHERE equipment=".$eqp."");
	
}
												elseif($appr!=""){
											$values = mysql_query("SELECT approved, ID,  user_id, equipment_code,  current_servicing_agency,  f_type_name,  description_of_fault,  action_taken, doh, fault_corrected_by_user,  to_fix_at_next_service_visit,  engineer_called_out,  service_call_no,  equipment_status,  equipment_downtime,  screening_downtime,  repeat_images,  cancelled_women,  technical_recalls,  satisfied_servicing_organisation,  satisfied_service_engineer,  satisfied_equipment,  supplier_enquiry,  supplier_action,  supplier_comments,  adverse_incident_report,  date_of_fault, created_on FROM ".$table." WHERE approved = ".$appr."");
	
}
			
			
			
			elseif($cent==""&&$appr==""&&$eqptp==""&&$eqp==""){

	$values = mysql_query("SELECT approved, ID,  user_id, equipment_code,  current_servicing_agency,  f_type_name,  description_of_fault,  action_taken, doh, fault_corrected_by_user,  to_fix_at_next_service_visit,  engineer_called_out,  service_call_no,  equipment_status,  equipment_downtime,  screening_downtime,  repeat_images,  cancelled_women,  technical_recalls,  satisfied_servicing_organisation,  satisfied_service_engineer,  satisfied_equipment,  supplier_enquiry,  supplier_action,  supplier_comments,  adverse_incident_report,  date_of_fault, created_on FROM ".$table."");
			}
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
exit;

		}
?>
												
										