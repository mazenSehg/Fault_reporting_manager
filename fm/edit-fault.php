<?php
session_start();
//Load all functions
require_once('load.php');

login_check();
$filters = $_GET['filters'];
$sortcol = $_GET['sortcol'];
$sortdir = $_GET['sortdir'];
$_SESSION['filters'] = json_decode($filters);
$_SESSION['sortcol'] = $sortcol;
$_SESSION['sortdir'] = $sortdir;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Fault &mdash; <?php echo get_site_name();?></title>
	
	<?php echo $Header->head();?>
</head>
 <body class="nav-md">
	<div class="container body">
		<div class="main_container">
		
		<?php echo $Header->header();?>
		
		<!-- page content -->
		<div class="right_col" role="main">
			<div class="">
				<?php echo $Header->page__header('Edit Fault'); ?>
				
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_content">
								<?php echo $Fault->edit__fault__page(); ?>
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
