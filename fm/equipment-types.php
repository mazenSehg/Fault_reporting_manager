<?php
session_start();
//Load all functions
require_once('load.php');

login_check();
?>

<!DOCTYPE html>
<html>
<head>
	<title>All Equipment Types &mdash; <?php echo get_site_name();?></title>
	
	<?php echo $Header->head();?>
</head>
 <body class="nav-md">
	<div class="container body">
		<div class="main_container">
		
		<?php echo $Header->header();?>
		
		<!-- page content -->
		<div class="right_col" role="main">
			<div class="">
				<?php echo $Header->page__header('All Equipment Types'); ?>
				
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<?php if( user_can('add_equipment_type') ): ?>
							<div class="x_title">
								<a href="<?php echo site_url();?>/add-new-equipment-type/" class="btn btn-dark btn-sm">Add Equipment Type</a>
								<div class="clearfix"></div>
							</div>
							<?php endif; ?>
							<div class="x_content">
								<?php echo $Equipment->all__equipment__types__page(); ?>
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