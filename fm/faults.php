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
	<title>All Faults &mdash; <?php echo get_site_name();?></title>
	
	<?php echo $Header->head();?>
</head>
 <body class="nav-md">
	<div class="container body">
		<div class="main_container">
		
		<?php echo $Header->header();?>
		
			
			
			
			<?php
			
            
$sql = "SELECT * FROM `tbl_fault` WHERE `equipment_name` IS NULL ORDER BY `equipment_code` ASC";
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
														
													}
            $sql5 = "SELECT * FROM tbl_equipment WHERE ID = $q->equipment";
            $re5 = $db->get_results($sql5);
            $equipment_code;
            foreach($re5 as $res5){
                $equipment_code = $res5->equipment_code;
            }
            
            $sql4 = "UPDATE tbl_fault SET equipment_code='$equipment_code', equipment_name='$equip', e_type_name='$type', centre_name='$centre', f_type_name='$f_type' WHERE ID = '$q->ID'";
										$sq5 = $db->query($sql4);
            
            endforeach;
			

			
			
			
			
			
			
			
			?>
			
			
		<!-- page content -->
		<div class="right_col" role="main">
			<div class="">							
			
				
				

				
				
				
				
				
				
								<?php if( user_can('add_fault') ): ?>
								<a href="<?php echo site_url();?>/add-new-fault/" class="btn btn-dark btn-sm">Add New Fault</a>
								<?php endif; ?>
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