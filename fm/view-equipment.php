<?php
session_start();
//Load all functions
require_once('load.php');

login_check();
$filters = $_GET['filters'];
$_SESSION['filters'] = json_decode($filters);
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Equipment &mdash; <?php echo get_site_name();?></title>
	
	<?php echo $Header->head();?>
</head>
 <body class="nav-md">
	<div class="container body">
		<div class="main_container">
		
		<?php echo $Header->header();?>
		
		<!-- page content -->
		<div class="right_col" role="main">
			
			
			<div class="">
				<?php echo $Header->page__header('View Equipment'); ?>
				
				<div class="row">
					
					<button class="btn btn-warning btn-md" onclick="goBack()">Previous page</button>					

<script>
function goBack() {
    window.history.go(-1);
}
</script>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_content">
								<?php echo $Equipment->view__equipment__page(); ?>
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
