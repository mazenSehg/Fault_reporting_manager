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
																	<ol>
																	<li>Click on the 'Users' tab and then select 'Add new user'</li>
																	<li>Fill in all neccecary information, make sure the email provided is valid.</li>
																	<li>An email should be sent to the email address provide in the form this contains a randomly generated password.</li>
																	</ol>
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
																	
																	<ol>
																	<li>Click on the 'Users' tab, find the user you wish to add to a centre and click on the 'Edit' button</li>
																	<li>Once the Page has loaded up, click on the 'Centre' field and select whichever centre you wish to assign to the user. you can add as many as you wish</li>
																		<li>Cick on the button 'Update User' to save changes</li>
																	</ol>
																	Alternatively, this process could have been done when creating a new user but adding centres o the 'Centre' field.
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
																	<ol>
																	<li>To modify access rights click on the 'Setting' tab and select 'Manage Roles' </li>
																	<li>Once the page loads there should be a list of capabilities as well as the different user types available for the Fault Reporting site. Pick and choose whatever capabilities you want for the different roles </li>
																		<li>Once you have made your selections, scroll down to the bottom of the page and select the button 'Update Capabilities'</li>
																	</ol>	
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
																		<ol>
																			<li>
																				If a user has forgot their password they can simply click on the option 'Forgot password' on the homescreen</li>
																			<li>they would then need to input their email address and press 'submit'</li>
																			<li>The user should receive an email with a temporary password, this will give them access to log into their account</li>
																	</ol>
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
																	Description on how to do this...	
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
																	Description on how to do this...	
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
															<a> Deleting equipment</a>
														</h2>
																	<div class="byline"> <span></span> </div>
																	<p class="excerpt">
																		Description on how to do this...
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
															<a>Ading new Fault</a>
														</h2>
																	<div class="byline"> <span></span> </div>
																	<p class="excerpt">
																		Description on how to do this...																		
																	</p>
																</div>
															</div>
															<div class="block">
																<div class="block_content">
																	<h2 class="title">
															<a>Modifying a fault</a>
														</h2>
																	<div class="byline"> <span></span> </div>
																	<p class="excerpt">
																		Description on how to do this...
																	</p>
																</div>
															</div>
															<div class="block">
																<div class="block_content">
																	<h2 class="title">
															<a>Deleting a Fault</a>
														</h2>
																	<div class="byline"> <span></span> </div>
																	<p class="excerpt">
																		Description on how to do this...
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