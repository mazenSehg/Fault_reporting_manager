<?php
session_start();
//Load all functions
require_once('load.php');

login_check();
?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>
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
						<!-- top tiles -->
						<div class="row top_tiles">
							<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
								<div class="tile-stats">
									<div class="icon"> <i class="fa fa-users"></i> </div>
									<div class="count">
										<?php echo count( get_tabledata(TBL_USERS,false));?>
									</div>
									<h3> Total Users </h3>
									<p> </p>
								</div>
							</div>
							<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
								<div class="tile-stats">
									<div class="icon"> <i class="fa fa-exclamation-circle"> </i> </div>
									<div class="count">
										<?php echo TBL_FAULTS;//echo count( get_tabledata(TBL_FAULTS,false));?>
									</div>
									<h3> Total Faults</h3>
									<p> </p>
								</div>
							</div>
							<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
								<div class="tile-stats">
									<div class="icon"><i class="fa fa-certificate"></i></div>
									<div class="count">
										<?php echo count( get_tabledata(TBL_EQUIPMENTS,false));?>
									</div>
									<h3> Total Equipments</h3>
									<p> </p>
								</div>
							</div>
							<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
								<div class="tile-stats">
									<div class="icon"><i class="fa fa-cubes"></i></div>
									<div class="count">
										<?php echo count( get_tabledata(TBL_CENTRES,false));?>
									</div>
									<h3> Total Centres</h3>
									<p> </p>
								</div>
							</div>
						</div>
						<!-- /top tiles -->
						<div class="row">
							<div class="col-md-4 col-sm-4 col-xs-12">
								<div class="x_panel">
									<div class="x_title">
										<h2>Recent Activities</h2>
										<ul class="nav navbar-right panel_toolbox">
											<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
										</ul>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										<?php
									$notifications__query = " ORDER BY `ID` DESC LIMIT 0, 5";
									$notifications__args = array('user_id' => get_current_user_id(), 'hide' => 0 , 'read' => 0);
									$notifications__result = get_tabledata(TBL_NOTIFICATIONS,false,$notifications__args,$notifications__query);
									?>
											<div class="dashboard-widget-content">
												<ul class="list-unstyled timeline widget">
													<?php if($notifications__result): foreach($notifications__result as $notifications): ?>
														<li>
															<div class="block">
																<div class="block_content">
																	<h2 class="title">
															<a><?php _e($notifications->title);?></a>
														</h2>
																	<div class="byline"> <span><?php echo date('M d, Y h:i a',strtotime($notifications->date));?></span> </div>
																	<p class="excerpt">
																		<?php echo strip_tags(stripslashes(htmlspecialchars_decode($notifications->notification)));?>
																	</p>
																</div>
															</div>
														</li>
														<?php endforeach;endif; ?>
												</ul>
											</div>
									</div>
								</div>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<div class="x_panel tile fixed_height_320">
									<div class="x_title">
										<h2>Quick Links</h2>
										<ul class="nav navbar-right panel_toolbox">
											<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
										</ul>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										<div class="dashboard-widget-content">
											<ul class="quick-list">
												<?php
												if(is_admin()): 
												?>
												<li> <i class="fa fa-calendar-o"></i> <a href="<?php echo site_url();?>/general-setting/">Settings</a> </li>
												<?php
												endif;
												if(user_can('add_user')):
												?>
												<li> <i class="fa fa-users"></i> <a href="<?php echo site_url();?>/add-new-user/">Add  User</a> </li>
												<?php
												endif;
												if(user_can('add_centre')):
												?>
												<li> <i class="fa fa-bar-chart"></i> <a href="<?php echo site_url();?>/add-new-centre/">Add  Centre</a> </li>
												<?php
												endif;
												if(user_can('add_region')):
												?>
												<li> <i class="fa fa-line-chart"></i> <a href="<?php echo site_url();?>/add-new-region/">Add  Region</a> </li>
												<?php
												endif;
												if(user_can('add_equipment')):
												?>
												<li> <i class="fa fa-bar-chart"></i> <a href="<?php echo site_url();?>/add-new-equipment/">Add  Equipment</a> </li>
												<?php
												endif;
												if(user_can('add_equipment_type')):
												?>
												<li> <i class="fa fa-line-chart"></i> <a href="<?php echo site_url();?>/add-new-equipment-type/">Add  Equipment Type</a> </li>
												<?php
												endif;
												if(user_can('add_service_agent')):
												?>
												<li> <i class="fa fa-area-chart"></i> <a href="<?php echo site_url();?>/add-new-service-agent/">Add  Service Agent</a> </li>
												<?php
												endif;
												?>
											</ul>
											<ul class="quick-list">
											<?php
											if(user_can('add_manufacturer')):
											?>
												<li> <i class="fa fa-calendar-o"></i> <a href="<?php echo site_url();?>/add-new-manufacturer/">Add  Manufacturer</a> </li>
												<?php
												endif;
											if(user_can('add_model')):
												?>
												<li> <i class="fa fa-bars"></i> <a href="<?php echo site_url();?>/add-new-model/">Add  Model</a> </li>
												<?php
												endif;
											if(user_can('add_supplier')):
												?>
												<li> <i class="fa fa-bar-chart"></i> <a href="<?php echo site_url();?>/add-new-supplier/">Add  Supplier</a> </li>
												<?php
												endif;
											if(user_can('add_fault')):
												?>
												<li> <i class="fa fa-line-chart"></i> <a href="<?php echo site_url();?>/add-new-fault/">Add  Fault</a> </li>
											<?php
												endif;
											if(user_can('add_fault_type')):
											?>
												<li> <i class="fa fa-bar-chart"></i> <a href="<?php echo site_url();?>/add-new-fault-type/">Add  Fault Type</a> </li>
											<?php
											endif;
											?>
												<li> <i class="fa fa-sign-out"></i> <a href="<?php echo site_url();?>/logout/" class="link-logout">Log Out</a> </li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<div class="x_panel tile fixed_height_320">
									<div class="x_title">
										<h2>Todo list</h2>
										<ul class="nav navbar-right panel_toolbox">
											<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
										</ul>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										<div class="dashboard-widget-content">
											<ul class="quick-list">
												<li> <i class="fa fa-exclamation"></i> <a href="<?php echo site_url();?>/faults2/">Number of Faults <strong>not</strong> approved</a>
													<?php
												$sql = "SELECT COUNT(*) as re FROM tbl_fault WHERE approved = 0";
												$res = $db->get_results($sql);
												echo "<br>";
												?>
													<div align="center">
													<?php
													print_r($res[0]->re);
												?>
														</div>
												</li>
											</ul>
											<ul class="quick-list">
												<li> <i class="fa fa-exclamation"></i> <a href="<?php echo site_url();?>/equipments2/">Number of Equipments <strong>not</strong> approved</a>
													<?php
												$ap = 1;
												$sql = "SELECT COUNT(*) as re2 FROM tbl_equipment WHERE approved = 0";
												$res = $db->get_results($sql);
												echo "<br>";
?>
													<div align="center">
													<?php
													print_r($res[0]->re2);
												?>
														</div>
												</li>
											</ul>
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
