<?php
session_start();
//Load all functions
require_once('load.php');

login_check();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Contact</title>
	
	<?php echo $Header->head();?>
</head>
 <body class="nav-md">
	<div class="container body">
		<div class="main_container">
		
		<?php echo $Header->header();?>
		
		<!-- page content -->
		<div class="right_col" role="main">
			<div class="">
				
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							For any enquires, please use the following contact information:<br />
							<h2>Email:</h2>
							rsc-tr.nccpm@nhs.net
							<h2>Telephone:</h2>
							01483 408310
							<h2>Fax:</h2>
							01483 406742
							<h2>Address:</h2>
							NCCPM<br />
							Medical Physics<br />
							Level B<br />
							St Luke's Wing<br />
							Royal Surrey County Hospital<br />
							Egerton Road<br />
							Guildford<br />
							GU2 7XX<br />
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
