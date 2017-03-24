<?php
session_start();
//Load all functions
require_once('load.php');

login_check();
?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>Edit Region &mdash;
			<?php echo get_site_name();?>
		</title>
		<?php echo $Header->head();?>
	</head>

	<body class="nav-md">
		<div class="container body">
			<div class="main_container">
				<?php echo $Header->header();?>
					<!-- page content -->
					<div class="right_col" role="main">
						<div class="">
							<?php echo $Header->page__header('Edit Region'); ?>
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<div class="x_panel">
											<div class="x_content">
												<?php
												
												
										
										
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
				$sql = "SELECT COUNT(*) AS resc FROM tbl_equipment WHERE equipment_code IS NULL OR equipment_code=''";
				$res = $db->get_results($sql);
				
				$valll;
				foreach($res as $row):
				$valll =  $row->resc;								
				endforeach;
						
				if($valll>0){
				echo $valll;	
				}
				
				**/
				
												
												

												
												
												
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