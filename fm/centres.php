<?php
session_start();
//Load all functions
require_once('load.php');

login_check();
?>

<!DOCTYPE html>
<html>
<head>
	<title>All Centres &mdash; <?php echo get_site_name();?></title>
	
	<?php echo $Header->head();?>
</head>
 <body class="nav-md">
	<div class="container body">
		<div class="main_container">
		
		<?php echo $Header->header();?>
		
		<!-- page content -->
		<div class="right_col" role="main">
			<div class="">
				<?php echo $Header->page__header('All Centres'); ?>
				<?php
				
$sql1 = "SELECT * FROM tbl_centres WHERE region_name = NULL";
$res1 = $db->get_results($sql1);
foreach($res1 as $a):

$sql2 = "SELECT * FROM tbl_region WHERE ID = $a->region";
$res2 = $db->get_results($sql2);
foreach($res2 as $b):
$name = $b->name;
endforeach;

$sql3 = "UPDATE tbl_centres SET region_name='$name' WHERE ID = '$a->ID'";
$res3 = $db->query($sql3);

endforeach;
				?>
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
								<?php if( user_can('add_centre') ): ?>
								<a href="<?php echo site_url();?>/add-new-centre/" class="btn btn-dark btn-sm">Add New Centre</a>
								<?php endif; ?>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<?php echo $Centre->all__centres__page(); ?>
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