<?php
session_start();
//Load all functions
require_once('load.php');

if(is_user_logged_in()):
	$uri = site_url();
	header("location:".$uri);
	die();
endif;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login &mdash; <?php echo get_site_name();?></title>
	
	<?php echo $Header->head();?>
</head>
<body class="home-page main">
	<section class="">
		<div class="canvas-block">
			<canvas id="myCanvas1"></canvas>
		</div>
	</section>
	<?php echo $Header->home__page__header();?>
	<section class="big-box">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php echo $User->login__page(); ?>
				</div>
			</div>
		</div>
	</section>
	<?php echo $Footer->home__page__footer('fixed');?>
	<?php echo $Footer->scripts(); ?>
	<script>
		/*var canvas1;

		$(document).ready(function() {
			canvas1 = $("#myCanvas1").canvaDots({
				sizeDependConnections: !1,		
				speed: 1
			});
		});*/
	</script>
</body>
</html>