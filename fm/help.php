<?php
session_start();
//Load all functions
require_once('load.php');

login_check();
?>

<!DOCTYPE html>
<html>
<head>
	<title>General Help &mdash; <?php echo get_site_name();?></title>
	
	<?php echo $Header->head();?>
</head>
 <body class="nav-md">
	<div class="container body">
		<div class="main_container">
		
		<?php echo $Header->header();?>
		
		<!-- page content -->
		<div class="right_col" role="main">
			<div class="">
				<?php echo $Header->page__header('General Help'); ?>
				
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<?php if( user_can('add_user') ): ?>
							<div class="x_title">
								<div class="clearfix"></div>
							</div>
							<?php endif; ?>
							<div class="x_content">
								
				
								
								
								
								
								
							<div class="col-md-4 col-sm-4 col-xs-12">
								<div class="x_panel">
									<div class="x_title">
										<h1>User Management</h1>
										<ul class="nav navbar-right panel_toolbox">
											<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
										</ul>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										
											<div class="dashboard-widget-content">
												<ul class="list-unstyled timeline widget">
													
														<li>
															<div class="block">
																<div class="block_content">
																	<h2 class="title">
															<a>Adding a new user</a>
														</h2>
																	<div class="byline"> <span></span> </div>
																	<p class="excerpt">
																		
																	</p>
																</div>
															</div>
														</li>

												</ul>
												
												<ul class="list-unstyled timeline widget">
													
														<li>
															<div class="block">
																<div class="block_content">
																	<h2 class="title">
															<a>Assigning a user to a Centre</a>
														</h2>
																	<div class="byline"> <span></span> </div>
																	<p class="excerpt">
																		
																	</p>
																</div>
															</div>
														</li>

												</ul>
												
												<ul class="list-unstyled timeline widget">
													
														<li>
															<div class="block">
																<div class="block_content">
																	<h2 class="title">
															<a>Access rights for users</a>
														</h2>
																	<div class="byline"> <span></span> </div>
																	<p class="excerpt">
																		
																	</p>
																</div>
															</div>
														</li>

												</ul>
												
												
												<ul class="list-unstyled timeline widget">
													
														<li>
															<div class="block">
																<div class="block_content">
																	<h2 class="title">
															<a>Account recovery</a>
														</h2>
																	<div class="byline"> <span></span> </div>
																	<p class="excerpt">
																		
																	</p>
																</div>
															</div>
														</li>

												</ul>
											</div>
									</div>
								</div>
							</div>
							
								
								
							<div class="col-md-4 col-sm-4 col-xs-12">
								<div class="x_panel">
									<div class="x_title">
										<h1>Equipment Management</h1>
										<ul class="nav navbar-right panel_toolbox">
											<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
										</ul>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										
											<div class="dashboard-widget-content">
												<ul class="list-unstyled timeline widget">
													
														<li>
															<div class="block">
																<div class="block_content">
																	<h2 class="title">
															<a>Adding new Equipment</a>
														</h2>
																	<div class="byline"> <span></span> </div>
																	<p class="excerpt">
																		
																	</p>
																</div>
															</div>
														</li>

												</ul>
												
												<ul class="list-unstyled timeline widget">
													
														<li>
															<div class="block">
																<div class="block_content">
																	<h2 class="title">
															<a>Modifying existing equipment</a>
														</h2>
																	<div class="byline"> <span></span> </div>
																	<p class="excerpt">
																		
																	</p>
																</div>
															</div>
														</li>

												</ul>
												
												
												<ul class="list-unstyled timeline widget">
													
														<li>
															<div class="block">
																<div class="block_content">
																	<h2 class="title">
															<a></a>
														</h2>
																	<div class="byline"> <span></span> </div>
																	<p class="excerpt">
																		
																	</p>
																</div>
															</div>
														</li>

												</ul>
											</div>
									</div>
								</div>
							</div>
								
<div class="col-md-4 col-sm-4 col-xs-12">
								<div class="x_panel">
									<div class="x_title">
										<h1>Fault Management</h1>
										<ul class="nav navbar-right panel_toolbox">
											<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
										</ul>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										
											<div class="dashboard-widget-content">
												<ul class="list-unstyled timeline widget">
													
														<li>
															<div class="block">
																<div class="block_content">
																	<h2 class="title">
															<a></a>
														</h2>
																	<div class="byline"> <span></span> </div>
																	<p class="excerpt">
																		
																	</p>
																</div>
															</div>
														</li>

												</ul>
											</div>
									</div>
								</div>
							</div>								
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