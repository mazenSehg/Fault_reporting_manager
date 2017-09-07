<?php
session_start();
//Load all functions
require_once('load.php');

login_check();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Import data &mdash; <?php echo get_site_name();?></title>
	
	<?php echo $Header->head();?>
</head>
 <body class="nav-md">
	<div class="container body">
		<div class="main_container">
		
		<?php echo $Header->header();?>
		
		<!-- page content -->
		<div class="right_col" role="main">
			<div class="">
				
				<?php echo $Header->page__header('Import data'); ?>
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_content">
								<?php  

                                



                                $sql1 = "SELECT * FROM faults";
                                $res1 = $db->get_results($sql1);
                                foreach($res1 as $a):
                                
                                    $sql2 = "SELECT * FROM tbl_fault WHERE ID = $a->id";
                                    $res2 = $db->get_results($sql2);

                                    foreach($res2 as $b):
//removes all faults which already existed in database
                                $sql3 = "DELETE FROM faults WHERE id=$b->ID";
                                echo "REMOVING DUPLICATE OF FAULT ID: ".$b->ID."<br>";
                                $res4 = $db->query($sql3);
                                    endforeach;
                                
                                
//finding the equipment ID by: Finding equipment Code, matching code to ID
                                $sql4 = "SELECT * FROM equipment WHERE id = $a->equipment_id";
                                $res4 = $db->get_results($sql4);
                                foreach($res4 as $c):
                                $centre = $c->centre_id;
                                $sql5 = "SELECT * FROM tbl_equipment WHERE equipment_code LIKE '$c->equipment_code'";
                                $res5 = $db->get_results($sql5);
                                foreach($res5 as $d):
                                $eq_id = $d->ID;
//equipment type ID
                                $sql8 = "SELECT * FROM tbl_equipment_type WHERE ID = $d->equipment_type";
                                $res8 = $db->get_results($sql8);
                                foreach($res8 as $g):
                                $eq_tp = $g->ID;
                                endforeach;
                                endforeach;

                                
//finding the Fault type ID: 
                                $sql6 = "SELECT * FROM fault_types WHERE id = $a->faulttype_id";
                                $res6 = $db->get_results($sql6);
                                foreach($res6 as $e):
                                
                                $sql7 = "SELECT * FROM tbl_fault_type WHERE name LIKE '$e->name'";
                                $res7 = $db->get_results($sql7);
                                foreach($res7 as $f):
                                $ft_id = $f->ID; 
                                endforeach;
                                
                                endforeach;
                                endforeach;
                              //  echo "INSERTING NEW FAULT: ID-".$a->id." Equipment ID-".$eq_id." Fault Type ID-".$ft_id." Centre ID-".$centre;
                                echo "<br>";
                                
                                $sql10 = "INSERT INTO tbl_fault (`ID`, `created_on`, `centre`, `name`, `user_id`, `equipment_type`, `equipment`, `fault_type`, `date_of_fault`, `current_servicing_agency`, `time_of_fault`, `description_of_fault`, `service_call_no`, `action_taken`, `fault_corrected_by_user`, `to_fix_at_next_service_visit`, `engineer_called_out`, `adverse_incident_report`, `equipment_status`, `equipment_downtime`, `screening_downtime`, `repeat_images`, `cancelled_women`, `technical_recalls`, `satisfied_servicing_organisation`, `satisfied_service_engineer`, `satisfied_equipment`, `doh`, `supplier_enquiry`, `supplier_action`, `supplier_comments`, `approved`, `equipment_name`, `e_type_name`, `centre_name`, `f_type_name`, `equipment_code`) VALUES ('$a->id',DEFAULT,'$centre','$a->created_by',NULL,'$eq_tp','$eq_id','$ft_id','$a->fault_date','$a->serviced_by', '$a->serviced_by','$a->description','$a->service_call_number','$a->action_description', '$a->fault_corrected_by_user','$a->fix_at_next_service', '$a->engineer_called_out','$a->incident_report_submitted','$a->eq_use_code','$a->equipment_down_time', '$a->screening_down_time', '$a->number_repeat_films', '$a->number_cancelled_women', '$a->number_recalls', '$a->satisfied_so', '$a->satisfied_se', '$a->satisfied_eq',DEFAULT,'$a->reason_for_enquiry','$a->response_requested', '$a->supplier_comment', '$a->approved',NULL,NULL,NULL,NULL,NULL);";
                                
                                echo $sql10;
                                
                                $res10 = $db->query($sql10);
                                
                                echo "<br>";echo "<br>";
                                endforeach;
                                ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /page content -->

		<!-- footer content -->
		<?php echo $Footer->footer();?>
		<!-- /footer content -->
		</div>
	</div>
</body>
</html>