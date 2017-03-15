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
								<?php echo $Fault->all__faults__page__off(); ?>
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