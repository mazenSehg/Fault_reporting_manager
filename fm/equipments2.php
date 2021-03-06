<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
//Load all functions
require_once('load.php');

login_check();
?>

<!DOCTYPE html>
<html>
<head>
	<title>All Equipment &mdash; <?php echo get_site_name();?></title>
	
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
								<?php echo $Equipment->all__equipments__page__off(); ?>
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