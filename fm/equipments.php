<?php
session_start();
//Load all functions
require_once('load.php');

login_check();
?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>All Equipment &mdash;
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
							<?php echo $Header->page__header('All Equipments'); ?>
								<?php


						//////////////////////////////////////////////////////////////////
						//**********TO UPDATE INCORRECT NAMES IN TBL_EQUIPMENTs*********//
						//////////////////////////////////////////////////////////////////


$sql1 = "SELECT * FROM tbl_equipment WHERE name is NULL OR name = '0'";
							$res1 = $db->get_results($sql1);
							foreach($res1 as $a):
							
							$manufac = NULL;
							
							if($a->manufacturer!=null||$a->manufacturer=0){
							$sql2 = "SELECT * FROM tbl_manufacturer WHERE ID = $a->manufacturer";
							$res2 = $db->get_results($sql2);
							foreach($res2 as $b):
								$manufac = $b->name;
							endforeach;
							}
							
							$model = NULL;
							
							if($a->model!=null){
							$sql3 = "SELECT * FROM tbl_model WHERE ID = $a->model";
							$res3 = $db->get_results($sql3);
							foreach($res3 as $c):
								$model = $c->name;
							endforeach;
							}
							
							
	
							
							$string = null;
							if(isset($manufac)&&!isset($model)){
								$string = $manufac . " | ";
							}
							if(!isset($manufac)&&isset($model)){
								$string = $manufac . " | ";
							}
							if(isset($manufac)&&isset($model)){
								$string = $manufac . " | " . $model;
							}
							
							
							
							
							if($a->serial_number!=null){
								$serial = $a->serial_number;							
								$string = $string . " | ". $serial;

							}
							if($a->year_installed!=null){
							$year_installed = $a->year_installed;
								$string = $string . " | ". $year_installed;
							}
							if($a->location_id!=null){
								$location_id = $a->location_id;
								$string = $string . " | ". $location_id;
							}
							if($a->location!=null){
								$location = $a->location;
								$string = $string . " | ". $location;
							}
							
						$string = mysql_real_escape_string(trim($string));
							
						$sql4 = "UPDATE tbl_equipment SET name='$string' WHERE ID = '$a->ID'";
						$sq5 = $db->query($sql4);
							
							endforeach;




						//////////////////////////////////////////////////////////////////
						//*************TO UPDATE MANUFACTURER IN TBL_EQUIPMENTs*********//
						//////////////////////////////////////////////////////////////////


//						$sql = "SELECT * FROM tbl_equipment WHERE manufacturer = '' OR manufacturer IS NULL";
//						$r = $db->get_results($sql);
//						foreach($r as $a):
//
//						$sql1 = "SELECT * FROM tbl_model WHERE ID = $a->model";
//						$rr = $db->get_results($sql1);
//						foreach($rr as $b):
//
//						$sql4 = "UPDATE tbl_equipment SET manufacturer='$b->manufacturer' WHERE manufacturer = '$a->manufacturer'";
//						$sq5 = $db->query($sql4);
//
//
//						endforeach;
//
//						endforeach;


							

						////////////////////////////////////////////////////////////////
						///************TO UPDATE EQUIPMENT CODE  TBL_EQUIPMENTs******///
						////////////////////////////////////////////////////////////////
							
							
						$sql = "SELECT COUNT(*) AS resc FROM tbl_equipment WHERE equipment_code is NULL OR equipment_code=''";
						$res = $db->get_results($sql);

						$valll;
						foreach($res as $row):
						$valll =  $row->resc;								
						endforeach;

						if($valll!=0){



							$sql = "SELECT * FROM tbl_equipment WHERE equipment_code IS NULL OR equipment_code='' LIMIT 100000";
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
							//$bmw = rand(0, 150);
							
$sql3 = "SELECT COUNT(*) AS bob FROM tbl_equipment WHERE equipment_code LIKE '%$val1%' AND equipment_code LIKE '%$val2%'";
$res3 = $db->get_results($sql3);
echo $row->equipment_code;

echo $res3[0]->bob;


$bmw = $res3[0]->bob;
							$bmw = $bmw +1;

							
							
							$resol = $val1 . $bmw . $val2;


							$ayy = $val1 . $bmw . $val2;

							$sql3 = "UPDATE tbl_equipment SET equipment_code ='$ayy' WHERE ID ='$IDD'";
							$res3 = $db->query($sql3);


							endforeach;
						}


						?>
									<div class="row">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<div class="x_panel">
												<?php if( user_can('add_equipment') ): ?>
													<div class="x_title"> <a href="<?php echo site_url();?>/add-new-equipment/" class="btn btn-dark btn-sm">Add Equipment</a>
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