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
			
			
			
							$sq = "SELECT COUNT(*) AS resc FROM tbl_fault WHERE equipment_name IS NULL OR equipment_name='0' OR e_type_name IS NULL OR e_type_name='0' ";
				$req = $db->get_results($sq);
				
				$valll;
				foreach($req as $row):
				$valll =  $row->resc;								
				endforeach;
						
				if($valll!=0){
															$sql = "SELECT * FROM tbl_fault WHERE equipment_name IS NULL OR equipment_name='0' OR e_type_name IS NULL OR e_type_name='0'";
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
													
													$sql4 = "UPDATE tbl_fault SET equipment_name='$equip', e_type_name='$type', centre_name='$centre', f_type_name='$f_type' WHERE ID = '$res->ID'";
										$sq5 = $db->query($sql4);
													}
													
												}
			
			
			
			
			
			
			
			
			
			?>
			
			
		<!-- page content -->
		<div class="right_col" role="main">
			<div class="">
				<?php echo $Header->page__header('All Faults'); ?>
				
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
								
							
							
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