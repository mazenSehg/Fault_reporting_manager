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
								$kkkkk = 0;
								$answ = "SELECT * FROM tbl_fault WHERE manufacture = $kkkkk";
								$rr = $db->get_results($answ);
								foreach($rr as $cat):
								

										$sql = "SELECT * FROM tbl_fault WHERE ID = $cat->ID";
												$re = $db->get_results($sql);
												foreach($re as $res):
												
												echo $res->equipment;
												echo "<br>";
												$sql1 = "SELECT * FROM tbl_equipment WHERE ID = $res->equipment";
												$re1 = $db->get_results($sql1);

												$rrr;
												foreach($re1 as $res1):
												
												$rrr = $res1->manufacturer;
												echo $rrr;
												echo "<br>";
												endforeach;
												
												$sql2 = "UPDATE tbl_fault SET manufacture = $rrr";
												$re1 = $db->query($sql2);
												endforeach;
												
								endforeach;
												
								
								
								?>
								<form method="POST">
											<div class="row">
													<div class="form-group col-sm-2 col-xs-12">
						<label for="">fault status</label>
						<br/>
						<select name="equipment_status" class="form-control select_single require" tabindex="-1" data-placeholder="Choose status">
							<?php
							$option_data = get_approv();
							echo get_options_list($option_data);
							?>
						</select>
					</div>
								</div>
											<div class="row">

				<div class="form-group col-sm-3 col-xs-20">
					<label for="centre">
						Centre
						<span class="required">
							*
						</span>
					</label>
					<select name="centre" class="form-control select_single require" tabindex="-1" data-placeholder="Choose centre">
						<?php
						$query = '';
						if(!is_admin()):
						$centres = maybe_unserialize($this->current__user->centre);
						if(!empty($centres))
						{
							$centres = implode(',',$centres);
							$query = "WHERE `ID` IN (".$centres.")";
						}
						endif;
						$query .= ($query != '') ? ' AND ' : ' WHERE ';
						$query .= " `approved` = '1' ORDER BY `name` ASC";
						$data = get_tabledata(TBL_CENTRES,false,array(),$query);
						$option_data = get_option_data($data,array('ID','name'));
						echo get_options_list($option_data);
						?>
					</select>
				</div>
				
				<div class="form-group col-sm-3 col-xs-20">
					<label for="equipment-type">
						Equipment Type
						<span class="required">
							*
						</span>
					</label>
					<select name="equipment_type" class="form-control select_single require select-equipment-type fetch-equipment-type-data" tabindex="-1" data-placeholder="Choose Fault status">
						<?php
						$data = get_tabledata(TBL_EQUIPMENT_TYPES,false,array('approved'=> '1'), 'ORDER BY `name` ASC');
						$option_data = get_option_data($data,array('ID','name'));
						echo get_options_list($option_data);
						?>
					</select>
				</div>
				

												
												<div class="form-group col-sm-3 col-xs-20">
				<label for="manufacturer">
					Manufacturer
					<span class="required">
						*
					</span>
				</label>
				<select name="manufacturer" class="form-control select_single require" tabindex="-1" data-placeholder="Choose manufacturer">
					<?php
					$data = get_tabledata(TBL_MANUFACTURERS,false,array('approved'=> '1'));
					$option_data = get_option_data($data,array('ID','name'));
					echo get_options_list($option_data);
					?>
				</select>
			</div>
												
												

												
												

												<div class="form-group col-sm-4 col-xs-20">
												<input type="submit" name="SubmitButton" value="Search"/>
												</div>
			</div>
									
								</form>

								
								<?php 
								
								if(isset($_POST['SubmitButton'])){
									
$status = $_POST['equipment_status'];
$centre = $_POST['centre'];
$equip_type = $_POST['equipment_type'];
$manuf = $_POST['manufacturer'];
$model = $_POST['model'];
									
								
										
									
									
									session_start();
									$_SESSION['status'] = $status;
									$_SESSION['centre'] = $centre;
									$_SESSION['equip_type'] = $equip_type;
									$_SESSION['manuf'] = $manuf;
									
									
									
									
									
									echo $status;
									echo "<br>";
									echo $centre;
									echo "<br>";
									echo $equip_type;
									echo "<br>";
									echo $manuf;
									echo "<br>";
									echo $Fault->all__faults__page3(); 
									
								}else{
								echo $Fault->all__faults__page();} ?>
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