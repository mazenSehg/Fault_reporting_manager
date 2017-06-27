<?php
session_start();
error_reporting(0);
//Load all functions
require_once('load.php');

login_check();
?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>All Faults &mdash;
			<?php echo get_site_name();?>
		</title>
		<?php echo $Header->head();?>
	</head>

	<body class="nav-md">
		<div class="container body">
			<div class="main_container">
				<?php echo $Header->header();?>
					<?php            

														$sql = "SELECT COUNT(*) as re FROM `tbl_fault` WHERE `equipment_name` IS NULL ORDER BY `equipment_name`  DESC";
												$res = $db->get_results($sql);
										
													$cint = $res[0]->re;
				
				

$sql  = 'SELECT *  FROM `tbl_fault` WHERE `equipment_name` IS NULL OR `equipment_code` IS NULL LIMIT 100000';
            $res = $db->get_results($sql);			
foreach($res as $q):
            $sql1 = "SELECT * FROM tbl_equipment WHERE ID = $q->equipment";
													$re1 = $db->get_results($sql1);
													$equip;
													foreach($re1 as $res1){
														$equip = $res1->name;
														$code = $res1->equipment_code;
														
														$sql2 = "SELECT * FROM tbl_equipment_type WHERE ID = $q->equipment_type";
														$re2 = $db->get_results($sql2);
														$type;
														foreach ($re2 as $res2){
														$type = $res2->name;
															
															$sql3 = "SELECT * FROM tbl_centres WHERE ID = $q->centre";
															$re3 = $db->get_results($sql3);
															$centre;
															foreach ($re3 as $res3){
																$centre = $res3->name;
															
																$sql4 = "SELECT * FROM tbl_fault_type WHERE ID = $q->fault_type";
																$re4 = $db->get_results($sql4);
																$f_type;
																foreach($re4 as $res4){
																	$f_type = $res4->name;
																	
																}
																
															}
															
														}
														
														

                $equipment_code = $res1->equipment_code;     
            
$bob = mysql_real_escape_string(trim($centre));
$bob2 = mysql_real_escape_string(trim($equip));
$bob3 = mysql_real_escape_string(trim($equipment_code));
$bob4 = mysql_real_escape_string(trim($type));
$bob5 = mysql_real_escape_string(trim($f_type));

														
            $sql4 = "UPDATE tbl_fault SET equipment_code='$bob3', equipment_name='$bob2', e_type_name='$bob4', centre_name='$bob', f_type_name='$bob5' WHERE ID = '$q->ID'";
										$sq5 = $db->query($sql4);
            

														
													}
			
            endforeach;
			

			
			
			
			
			
			?>
						<!-- page content -->
						<div class="right_col" role="main">
							<div class="">
								<?php if( user_can('add_fault') ): ?> <a href="<?php echo site_url();?>/add-new-fault/" class="btn btn-dark btn-sm">Add New Fault</a>
									<?php endif; 

								?>
										<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<?php 
								echo $Fault->all__faults__page(); ?>
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
	<?php



?>