<?php
session_start();
ini_set('display_errors', 0);
//Load all functions
require_once('load.php');

login_check();
?>

<!DOCTYPE html>
<html>
<head>
	<title>All Equipments &mdash; <?php echo get_site_name();?></title>
	
	<?php echo $Header->head();?>
</head>
 <body class="nav-md">
	<div class="container body">
		<div class="main_container">
		
		<?php echo $Header->header();?>
		
		<!-- page content -->
		<div class="right_col" role="main">
			<div class="">
				<?php echo $Header->page__header('All Equipments'); ?>
				
				
				
				
				
				<?php
				$sql = "SELECT COUNT(*) AS resc FROM tbl_equipment WHERE equipment_code IS NULL OR equipment_code=''";
				$res = $db->get_results($sql);
				
				$valll;
				foreach($res as $row):
				$valll =  $row->resc;								
				endforeach;
						
				if($valll!=0){
												?>
				
								<?php
				
				
				
				$sql = "SELECT * FROM tbl_equipment WHERE equipment_code IS NULL OR equipment_code=''";
				$res = $db->get_results($sql);
				foreach($res as $row):
				
				$IDD = $row->ID;
				$val1;
				$val2;
				
				$sql1 = "SELECT * FROM tbl_centres WHERE ID = $row->centre";
				$res1 = $db->get_results($sql1);
				foreach($res1 as $row1):
				$val1 = $row1->centre_code;				
				endforeach;
				
				$sql2 = "SELECT * FROM tbl_equipment_type WHERE ID = $row->equipment_type";
				$res2 = $db->get_results($sql2);
				foreach($res2 as $row2):
				$val2 = $row2->code;
				endforeach;
				$bmw = rand(0, 150);
				$resol = $val1 . $bmw . $val2;
				
				
				$ayy = $val1 . $bmw . $val2;

				$sql3 = "UPDATE tbl_equipment SET equipment_code ='$ayy' WHERE ID ='$IDD'";
				$res3 = $db->query($sql3);
				
				
				endforeach;
				
				
				
				?>
																<?php
				//PLA4L
								$check2 = "SELECT COUNT(*) as answ FROM tbl_equipment WHERE LENGTH(name) < 2";
				$chk = $db->get_results($check2);
				
				$chk;
												foreach($chk as $res):
												$chk = $res->answ;
												echo "<br>";
												endforeach;

												
				?>
				
				
				
				
				<?php
				}
				if($chk != 0){
				
												$aql1 = "SELECT * FROM tbl_equipment WHERE LENGTH(name) < 2";
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
								endforeach;

								$IDD = $bob->ID;

								$sql4 = "UPDATE tbl_equipment SET name='$sting' WHERE ID = '$IDD'";
								$sq5 = $db->query($sql4);

								$sql46 = "UPDATE tbl_equipment SET model='$bowe' WHERE ID = '$IDD'";
								$sq6 = $db->query($sql46);

								$sql47 = "UPDATE tbl_equipment SET service_agent='$qwey->ID' WHERE ID = '$IDD'";
								$sq7 = $db->query($sql47);


								endforeach;

				}
				
				
				?>
				
				
				
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<?php if( user_can('add_equipment') ): ?>
							<div class="x_title">
								<a href="<?php echo site_url();?>/add-new-equipment/" class="btn btn-dark btn-sm">Add Equipment</a>
								<div class="clearfix"></div>
							</div>
							<?php endif; ?>
							<div class="x_content">
								<?php echo $Equipment->all__equipments__page(); ?>
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