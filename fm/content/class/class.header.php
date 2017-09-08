<?php
// if accessed directly than exit
if(!defined('ABSPATH')) exit;

if( !class_exists('Header') ):
class Header{
	private $database;
	private $profile;
	function __construct(){
		global $db,$Profile;
		$this->database = $db;
		$this->profile = $Profile;
	}

	public function head(){
		ob_start();
		?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<!-- Bootstrap -->
		<link href='https://fonts.googleapis.com/css?family=Quattrocento+Sans:400,700' rel='stylesheet' type='text/css' />
		<link href='https://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'/>
		<link href="<?php echo CSS_URL;?>bootstrap.min.css" rel="stylesheet"/>
		<!-- jQuery ui-->
		<link href="<?php echo CSS_URL;?>jquery-ui.css" rel="stylesheet"/>
		<!-- Font Awesome -->
		<link href="<?php echo CSS_URL;?>font-awesome.min.css" rel="stylesheet"/>
		<!-- iCheck -->
		<link href="<?php echo CSS_URL;?>green.css" rel="stylesheet"/>
		<!-- bootstrap-progressbar -->
		<link href="<?php echo CSS_URL;?>bootstrap-progressbar-3.3.4.min.css" rel="stylesheet"/>
		<!-- jVectorMap -->
		<link href="<?php echo CSS_URL;?>jquery-jvectormap-2.0.3.css" rel="stylesheet"/>
		<link href="<?php echo CSS_URL;?>dataTables.bootstrap.min.css" rel="stylesheet"/>
		<link href="<?php echo CSS_URL;?>buttons.bootstrap.min.css" rel="stylesheet"/>
		<link href="<?php echo CSS_URL;?>fixedHeader.bootstrap.min.css" rel="stylesheet"/>
		<link href="<?php echo CSS_URL;?>responsive.bootstrap.min.css" rel="stylesheet"/>
		<link href="<?php echo CSS_URL;?>scroller.bootstrap.min.css" rel="stylesheet"/>
		<link href="<?php echo CSS_URL;?>prettify.min.css" rel="stylesheet"/>
		<!-- Select2 -->
		<link href="<?php echo CSS_URL;?>select2.min.css" rel="stylesheet"/>
		<!-- Switchery -->
		<link href="<?php echo CSS_URL;?>switchery.min.css" rel="stylesheet"/>
		<!-- starrr -->
		<link href="<?php echo CSS_URL;?>starrr.css" rel="stylesheet"/>
		<!-- P Notify -->
		<link href="<?php echo CSS_URL;?>pnotify.css" rel="stylesheet"/>
		<link href="<?php echo CSS_URL;?>pnotify.buttons.css" rel="stylesheet"/>
		<link href="<?php echo CSS_URL;?>pnotify.nonblock.css" rel="stylesheet"/>
		<!--Full Calendar-->
		<link href="<?php echo CSS_URL;?>fullcalendar.min.css" rel="stylesheet"/>
		<link href="<?php echo CSS_URL;?>fullcalendar.print.css" rel="stylesheet" media="print"/>
		<!-- Custom Theme Style -->
		<link href="<?php echo CSS_URL;?>custom.css" rel="stylesheet"/>
		<link href="<?php echo CSS_URL;?>styles.css" rel="stylesheet"/>

		<script>
			var site_url = '<?php echo site_url();?>';
			var ajax_url = '<?php echo PROCESS_URL;?>';
			var table_ajax_url = '<?php echo TABLE_PROCESS_URL;?>';
		</script>
		<?php echo $this->scripts(); ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function scripts(){
		ob_start();
		?>
		<!-- jQuery -->
		<script src="<?php echo JS_URL;?>jquery.min.js"></script>
		<!-- jQuery -->
		<script src="<?php echo JS_URL;?>jquery-ui.js"></script>
		<!-- canvas dot -->
		<script src="<?php echo JS_URL;?>canvasdots.js"></script>
		<!-- Bootstrap -->
		<script src="<?php echo JS_URL;?>bootstrap.min.js"></script>
		<!-- FastClick -->
		<script src="<?php echo JS_URL;?>fastclick.js"></script>
		<!-- NProgress -->
		<script src="<?php echo JS_URL;?>nprogress.js"></script>
		<!-- morris.js -->
		<script src="<?php echo JS_URL;?>raphael.min.js"></script>
		<script src="<?php echo JS_URL;?>morris.min.js"></script>
		<!-- Chart.js -->
		<script src="<?php echo JS_URL;?>Chart.min.js"></script>
		<!-- gauge.js -->
		<script src="<?php echo JS_URL;?>gauge.min.js"></script>
		<!-- bootstrap-progressbar -->
		<script src="<?php echo JS_URL;?>bootstrap-progressbar.min.js"></script>
		<!-- iCheck -->
		<script src="<?php echo JS_URL;?>icheck.min.js"></script>
		<!-- Skycons -->
		<script src="<?php echo JS_URL;?>skycons.js"></script>
		<!-- Flot -->
		<script src="<?php echo JS_URL;?>jquery.flot.js"></script>
		<script src="<?php echo JS_URL;?>jquery.flot.pie.js"></script>
		<script src="<?php echo JS_URL;?>jquery.flot.time.js"></script>
		<script src="<?php echo JS_URL;?>jquery.flot.stack.js"></script>
		<script src="<?php echo JS_URL;?>jquery.flot.resize.js"></script>
		<!-- Flot plugins -->
		<script src="<?php echo JS_URL;?>jquery.flot.orderBars.js"></script>
		<script src="<?php echo JS_URL;?>date.js"></script>
		<script src="<?php echo JS_URL;?>jquery.flot.spline.js"></script>
		<script src="<?php echo JS_URL;?>curvedLines.js"></script>
		<!-- jVectorMap -->
		<script src="<?php echo JS_URL;?>jquery-jvectormap-2.0.3.min.js"></script>
		<!-- bootstrap-daterangepicker -->
		<script src="<?php echo JS_URL;?>moment.min.js"></script>
		<script src="<?php echo JS_URL;?>fullcalendar.min.js"></script>
		<script src="<?php echo JS_URL;?>daterangepicker.js"></script>
		<!-- datatables -->
		<script src="<?php echo JS_URL;?>jquery.dataTables.min.js"></script>
		<script src="<?php echo JS_URL;?>dataTables.bootstrap.min.js"></script>
		<script src="<?php echo JS_URL;?>dataTables.buttons.min.js"></script>
		<script src="<?php echo JS_URL;?>buttons.bootstrap.min.js"></script>
		<script src="<?php echo JS_URL;?>buttons.flash.min.js"></script>
		<script src="<?php echo JS_URL;?>buttons.html5.min.js"></script>
		<script src="<?php echo JS_URL;?>buttons.print.min.js"></script>
		<script src="<?php echo JS_URL;?>dataTables.fixedHeader.min.js"></script>
		<script src="<?php echo JS_URL;?>dataTables.keyTable.min.js"></script>
		<script src="<?php echo JS_URL;?>dataTables.responsive.min.js"></script>
		<script src="<?php echo JS_URL;?>responsive.bootstrap.js"></script>
		<script src="<?php echo JS_URL;?>datatables.scroller.min.js"></script>
		<script src="<?php echo JS_URL;?>jszip.min.js"></script>
		<script src="<?php echo JS_URL;?>pdfmake.min.js"></script>
		<script src="<?php echo JS_URL;?>vfs_fonts.js"></script>
		<script src="<?php echo JS_URL;?>bootstrap-wysiwyg.min.js"></script>
		<script src="<?php echo JS_URL;?>jquery.hotkeys.js"></script>
		<script src="<?php echo JS_URL;?>prettify.js"></script>
		<!-- jQuery Tags Input -->
		<script src="<?php echo JS_URL;?>jquery.tagsinput.js"></script>
		<!-- Switchery -->
		<script src="<?php echo JS_URL;?>switchery.min.js"></script>
		<!-- Select2 -->
		<script src="<?php echo JS_URL;?>select2.full.min.js"></script>
		<!-- Parsley -->
		<script src="<?php echo JS_URL;?>parsley.min.js"></script>
		<!-- Autosize -->
		<script src="<?php echo JS_URL;?>autosize.min.js"></script>
		<!-- jQuery autocomplete -->
		<script src="<?php echo JS_URL;?>jquery.autocomplete.min.js"></script>
		<!-- starrr -->
		<script src="<?php echo JS_URL;?>starrr.js"></script>
		<!-- p notify -->
		<script src="<?php echo JS_URL;?>pnotify.js">
		</script>
		<script src="<?php echo JS_URL;?>pnotify.buttons.js"></script>
		<script src="<?php echo JS_URL;?>pnotify.nonblock.js"></script>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function header(){
		ob_start();
		echo $this->sidebar();
		echo $this->top_bar();
		$content = ob_get_clean();
		return $content;
	}

	public function sidebar(){
		ob_start();
		?>
		<!--Sidebar start-->
		<div class="col-md-3 left_col">
			<div class="left_col scroll-view">
				<div class="navbar nav_title" style="border: 0;">
					<a href="<?php echo site_url().'/dashboard/';?>" class="site_title">
						<i class="fa fa-ravelry"></i>
						<span><?php echo get_site_name();?></span>
					</a>
				</div>

				<div class="clearfix"></div>

				<!-- menu profile quick info -->
				<div class="profile">
					<div class="profile_pic">
						<img src="<?php echo get_current_user_profile_image();?>" alt="..." class="img-circle profile_img">
					</div>
					<div class="profile_info">
						<span>Welcome,</span>
						<h2><?php echo get_current_user_name();?></h2>
					</div>
				</div>
				<!-- /menu profile quick info -->

				<div class="clearfix"></div>
				<!-- sidebar menu -->
				<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
					<div class="menu_section">
						<!--<h3>General</h3>-->
						<ul class="nav side-menu">
							<li>
								<a>
									<i class="fa fa-home"></i>Home <span class="fa fa-chevron-down"></span>
								</a>
								<ul class="nav child_menu">
									<li>
										<a href="<?php echo site_url().'/dashboard/';?>">
											Dashboard
										</a>
									</li>
									<li>
										<a href="<?php echo site_url();?>/notifications/">
											Notification
											<?php $notifications_count = get_unread_notification_count();
											if($notifications_count > 0): ?>
											<span class="label label-success">
												New
											</span>
											<?php endif; ?>
										</a>
									</li>
								</ul>
							</li>

							<li>
								<a>
									<i class="fa fa-trello">
									</i>My Profile
									<span class="fa fa-chevron-down">
									</span>
								</a>
								<ul class="nav child_menu">
									<li>
										<a href="<?php echo site_url();?>/edit-profile/">
											Edit Profile
										</a>
									</li>
									<li>
										<a href="<?php echo site_url();?>/change-password/">
											Change Password
										</a>
									</li>
									<li>
										<a href="<?php echo site_url().'/access-log/';?>">
											Access Log
										</a>
									</li>
								</ul>
							</li>

							<?php if( user_can('view_user') || user_can('edit_user') || user_can('add_user')): ?>
							<li>
								<a>
									<i class="fa fa-user">
									</i>Users
									<span class="fa fa-chevron-down">
									</span>
								</a>
								<ul class="nav child_menu">
									<?php if( user_can('view_user') ): ?>
									<li>
										<a href="<?php echo site_url().'/users/';?>">
											All Users
										</a>
									</li>
									<?php endif;?>
									<?php if( user_can('edit_user') || user_can('add_user')): ?>
									<li>
										<a href="<?php echo site_url();?>/add-new-user/">
											Add New User
										</a>
									</li>
									<li class="hidden">
										<a href="<?php echo site_url();?>/edit-user/">
										</a>
									</li>
									<?php endif;?>
									<?php if( user_can('view_user') ): ?>
									<li class="hidden">
										<a href="<?php echo site_url();?>/view-user/">
										</a>
									</li>
									<?php endif;?>
								</ul>
							</li>
							<?php endif; ?>

							<?php if( user_can('view_centre') || user_can('edit_centre') || user_can('add_centre') || user_can('view_region') || user_can('edit_region') || user_can('add_region') || user_can('view_region_body') || user_can('edit_region_body') || user_can('add_region_body')): ?>
							<li>
								<a>
									<i class="fa fa-cubes">
									</i>Centres
									<span class="fa fa-chevron-down">
									</span>
								</a>
								<ul class="nav child_menu">
									<?php if( user_can('view_centre') || user_can('edit_centre') || user_can('add_centre')): ?>
									<li>
										<a>
											Centres
											<span class="fa fa-chevron-down">
											</span>
										</a>
										<ul class="nav child_menu">
											<?php if( user_can('view_centre') ): ?>
											<li>
												<a href="<?php echo site_url();?>/centres/">
													All Centres
												</a>
											</li>
											<?php endif;?>

											<?php if( user_can('edit_centre') || user_can('add_centre')): ?>
											<li>
												<a href="<?php echo site_url();?>/add-new-centre/">
													Add New Centre
												</a>
											</li>
											<li class="hidden">
												<a href="<?php echo site_url();?>/edit-centre/">
												</a>
											</li>
											<?php endif;?>
										</ul>
									</li>
									<?php endif;?>

									<?php if( user_can('view_region') || user_can('edit_region') || user_can('add_region')): ?>
									<li>
										<a>
											Regions
											<span class="fa fa-chevron-down">
											</span>
										</a>
										<ul class="nav child_menu">
											<?php if( user_can('view_region') ): ?>
											<li>
												<a href="<?php echo site_url();?>/regions/">
													All Regions
												</a>
											</li>
											<?php endif;?>

											<?php if( user_can('edit_region') || user_can('add_region')): ?>
											<li>
												<a href="<?php echo site_url();?>/add-new-region/">
													Add New Region
												</a>
											</li>
											<li class="hidden">
												<a href="<?php echo site_url();?>/edit-region/">
												</a>
											</li>
											<?php endif;?>
										</ul>
									</li>
									<?php endif;?>

									<?php if( user_can('view_region_body') || user_can('edit_region_body') || user_can('add_region_body')): ?>
									<li>
										<a>
											Region Body
											<span class="fa fa-chevron-down">
											</span>
										</a>
										<ul class="nav child_menu">
											<?php if( user_can('view_region_body') ): ?>
											<li>
												<a href="<?php echo site_url();?>/region-body/">
													All Region Body
												</a>
											</li>
											<?php endif;?>

											<?php if( user_can('edit_region_body') || user_can('add_region_body')): ?>
											<li>
												<a href="<?php echo site_url();?>/add-new-region-body/">
													Add New Region Body
												</a>
											</li>
											<li class="hidden">
												<a href="<?php echo site_url();?>/edit-region-body/">
												</a>
											</li>
											<?php endif;?>
										</ul>
									</li>
									<?php endif;?>
								</ul>
							</li>
							<?php endif;?>

							<?php if( user_can('view_equipment') || user_can('edit_equipment') || user_can('add_equipment') || user_can('view_equipment_type') || user_can('edit_equipment_type') || user_can('add_equipment_type') || user_can('view_service_agent') || user_can('edit_service_agent') || user_can('add_service_agent') || user_can('edit_manufacturer') || user_can('add_manufacturer') || user_can('view_manufacturer') || user_can('edit_model') || user_can('add_model') || user_can('view_model') || user_can('edit_supplier') || user_can('add_supplier') || user_can('view_supplier')): ?>
							<li>
								<a>
									<i class="fa fa-certificate">
									</i>Manage Equipment
									<span class="fa fa-chevron-down">
									</span>
								</a>
								<ul class="nav child_menu">
									<?php
		
		if(is_admin()){
									if( user_can('view_equipment') || user_can('edit_equipment') || user_can('add_equipment') ): ?>
									<li>
										<a>
											Equipment
											<span class="fa fa-chevron-down">
											</span>
										</a>
										<ul class="nav child_menu">
											<?php if( user_can('view_equipment') ): ?>
											<li>
												<a href="<?php echo site_url();?>/equipments/">
													All Equipment
												</a>
											</li>
											<li class="hidden">
												<a href="<?php echo site_url();?>/view-equipment/">
													View Equipment
												</a>
											</li>
											<?php endif;?>

											<?php if( user_can('edit_equipment') || user_can('add_equipment') ): ?>
											<li>
												<a href="<?php echo site_url();?>/add-new-equipment/">
													Add New Equipment
												</a>
											</li>
											<li class="hidden">
												<a href="<?php echo site_url();?>/edit-equipment/">
													Edit Equipment
												</a>
											</li>

											<?php endif;?>
										</ul>
									</li>
									<?php endif;?>
									<?php } else{
			
												if( user_can('view_equipment') || user_can('edit_equipment') || user_can('add_equipment') ): ?>
									<li>
										
											<?php if( user_can('view_equipment') ): ?>
											<li>
												<a href="<?php echo site_url();?>/equipments/">
													All Equipment
												</a>
											</li>
											<li class="hidden">
												<a href="<?php echo site_url();?>/view-equipment/">
													View Equipment
												</a>
											</li>
											<?php endif;?>

											<?php if( user_can('edit_equipment') || user_can('add_equipment') ): ?>
											<li>
												<a href="<?php echo site_url();?>/add-new-equipment/">
													Add New Equipment
												</a>
											</li>
											<li class="hidden">
												<a href="<?php echo site_url();?>/edit-equipment/">
													Edit Equipment
												</a>
											</li>

											<?php endif;?>
									</li>
									<?php endif;
		}?>
								
									
									

									<?php if( user_can('view_equipment_type') || user_can('edit_equipment_type') || user_can('add_equipment_type') ): ?>
									<li>
										<a>
											Equipment Types
											<span class="fa fa-chevron-down">
											</span>
										</a>
										<ul class="nav child_menu">
											<?php if( user_can('view_equipment_type') ): ?>
											<li>
												<a href="<?php echo site_url();?>/equipment-types/">
													All Equipment Types
												</a>
											</li>
											<?php endif;?>

											<?php if( user_can('edit_equipment_type') || user_can('add_equipment_type') ): ?>
											<li>
												<a href="<?php echo site_url();?>/add-new-equipment-type/">
													Add New Equipment Type
												</a>
											</li>
											<li class="hidden">
												<a href="<?php echo site_url();?>/edit-equipment-type/">
													Edit Equipment Type
												</a>
											</li>
											<?php endif;?>
										</ul>
									</li>
									<?php endif;?>

									<?php if( user_can('view_service_agent') || user_can('edit_service_agent') || user_can('add_service_agent') ): ?>
									<li>
										<a>
											Service Agents
											<span class="fa fa-chevron-down">
											</span>
										</a>
										<ul class="nav child_menu">
											<?php if( user_can('view_service_agent') ): ?>
											<li>
												<a href="<?php echo site_url();?>/service-agents/">
													All Service Agents
												</a>
											</li>
											<?php endif;?>

											<?php if( user_can('edit_service_agent') || user_can('add_service_agent') ): ?>
											<li>
												<a href="<?php echo site_url();?>/add-new-service-agent/">
													Add New Service Agent
												</a>
											</li>
											<li class="hidden">
												<a href="<?php echo site_url();?>/edit-service-agent/">
													Edit Service Agent
												</a>
											</li>
											<?php endif;?>
										</ul>
									</li>
									<?php endif;?>

									<?php if( user_can('edit_manufacturer') || user_can('add_manufacturer') || user_can('view_manufacturer') ): ?>
									<li>
										<a>
											Manufacturers
											<span class="fa fa-chevron-down">
											</span>
										</a>
										<ul class="nav child_menu">
											<?php if( user_can('view_manufacturer') ): ?>
											<li>
												<a href="<?php echo site_url();?>/manufacturers/">
													All Manufacturers
												</a>
											</li>
											<?php endif;?>

											<?php if( user_can('edit_manufacturer') || user_can('add_manufacturer') ): ?>
											<li>
												<a href="<?php echo site_url();?>/add-new-manufacturer/">
													Add New Manufacturer
												</a>
											</li>
											<li class="hidden">
												<a href="<?php echo site_url();?>/edit-manufacturer/">
													Edit Manufacturer
												</a>
											</li>
											<?php endif;?>
										</ul>
									</li>
									<?php endif;?>

									<?php if( user_can('edit_model') || user_can('add_model') || user_can('view_model') ): ?>
									<li>
										<a>
											Models
											<span class="fa fa-chevron-down">
											</span>
										</a>
										<ul class="nav child_menu">
											<?php if( user_can('view_model') ): ?>
											<li>
												<a href="<?php echo site_url();?>/models/">
													All Models
												</a>
											</li>
											<?php endif;?>

											<?php if( user_can('edit_model') || user_can('add_model') ): ?>
											<li>
												<a href="<?php echo site_url();?>/add-new-model/">
													Add New Model
												</a>
											</li>
											<li class="hidden">
												<a href="<?php echo site_url();?>/edit-model/">
													Edit Model
												</a>
											</li>
											<?php endif;?>
										</ul>
									</li>
									<?php endif;?>

									<?php if( user_can('edit_supplier') || user_can('add_supplier') || user_can('view_supplier') ): ?>
									<li>
										<a>
											Suppliers
											<span class="fa fa-chevron-down">
											</span>
										</a>
										<ul class="nav child_menu">
											<?php if( user_can('view_supplier') ): ?>
											<li>
												<a href="<?php echo site_url();?>/suppliers/">
													All Suppliers
												</a>
											</li>
											<?php endif;?>

											<?php if( user_can('edit_supplier') || user_can('add_supplier') ): ?>
											<li>
												<a href="<?php echo site_url();?>/add-new-supplier/">
													Add New Supplier
												</a>
											</li>
											<li class="hidden">
												<a href="<?php echo site_url();?>/edit-supplier/">
													Edit Supplier
												</a>
											</li>
											<?php endif;?>
										</ul>
									</li>
									<?php endif;?>
								</ul>
							</li>
							<?php endif;?>

							
							
														<?php if(is_admin()){ ?>
							<?php if( user_can('view_fault') || user_can('edit_fault') || user_can('add_fault') || user_can('view_fault_type') || user_can('edit_fault_type') || user_can('add_fault_type') ): ?>
							<li>
								<a>
									<i class="fa fa-exclamation-circle">
									</i>Faults
									<span class="fa fa-chevron-down">
									</span>
								</a>
								<ul class="nav child_menu">
									<?php if( user_can('view_fault') || user_can('edit_fault') || user_can('add_fault')): ?>
									<li>
										<a>
											Faults
											<span class="fa fa-chevron-down">
											</span>
										</a>
										<ul class="nav child_menu">
											<?php if( user_can('view_fault') ): ?>
											<li>
												<a href="<?php echo site_url();?>/faults/">
													Review Faults
												</a>
											</li>
											<li class="hidden">
												<a href="<?php echo site_url();?>/view-fault/">
												</a>
											</li>
											<?php endif;?>

											<?php if( user_can('edit_fault') || user_can('add_fault')): ?>
											<li>
												<a href="<?php echo site_url();?>/add-new-fault/">
													Add New Fault
												</a>
											</li>
											<li class="hidden">
												<a href="<?php echo site_url();?>/edit-fault/">
												</a>
											</li>
											<?php endif;?>
										</ul>
									</li>
									<?php endif;?>

									<?php if( user_can('view_fault_type') || user_can('edit_fault_type') || user_can('add_fault_type')): ?>
									<li>
										<a>
											Fault Types
											<span class="fa fa-chevron-down">
											</span>
										</a>
										<ul class="nav child_menu">
											<?php if( user_can('view_fault_type') ): ?>
											<li>
												<a href="<?php echo site_url();?>/fault-types/">
													All Fault Types
												</a>
											</li>
											<?php endif;?>

											<?php if( user_can('edit_fault_type') || user_can('add_fault_type')): ?>
											<li>
												<a href="<?php echo site_url();?>/add-new-fault-type/">
													Add New Fault Type
												</a>
											</li>
											<li class="hidden">
												<a href="<?php echo site_url();?>/edit-fault-type/">
												</a>
											</li>
											<?php endif;?>
										</ul>
									</li>
									<?php endif;?>
								</ul>
								
								
							</li>
							<?php endif;?>
							<?php }else{?>
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							<?php if( user_can('view_fault') || user_can('edit_fault') || user_can('add_fault') || user_can('view_fault_type') || user_can('edit_fault_type') || user_can('add_fault_type') ): ?>
							<li>
								<a>
									<i class="fa fa-exclamation-circle">
									</i>Faults
									<span class="fa fa-chevron-down">
									</span>
								</a>
								<ul class="nav child_menu">
									<?php if( user_can('view_fault') || user_can('edit_fault') || user_can('add_fault')): ?>
									<li>
											<?php if( user_can('view_fault') ): ?>
											<li>
												<a href="<?php echo site_url();?>/faults/">
													All Faults
												</a>
											</li>
											<li class="hidden">
												<a href="<?php echo site_url();?>/view-fault/">
												</a>
											</li>
											<?php endif;?>

											<?php if( user_can('edit_fault') || user_can('add_fault')): ?>
											<li>
												<a href="<?php echo site_url();?>/add-new-fault/">
													Add New Fault
												</a>
											</li>
											<li class="hidden">
												<a href="<?php echo site_url();?>/edit-fault/">
												</a>
											</li>
											<?php endif;?>
									</li>
									<?php endif;?>

									<?php if( user_can('view_fault_type') || user_can('edit_fault_type') || user_can('add_fault_type')): ?>
									<li>
										<a>
											Fault Types
											<span class="fa fa-chevron-down">
											</span>
										</a>
										<ul class="nav child_menu">
											<?php if( user_can('view_fault_type') ): ?>
											<li>
												<a href="<?php echo site_url();?>/fault-types/">
													All Fault Types
												</a>
											</li>
											<?php endif;?>

											<?php if( user_can('edit_fault_type') || user_can('add_fault_type')): ?>
											<li>
												<a href="<?php echo site_url();?>/add-new-fault-type/">
													Add New Fault Type
												</a>
											</li>
											<li class="hidden">
												<a href="<?php echo site_url();?>/edit-fault-type/">
												</a>
											</li>
											<?php endif;?>
										</ul>
									</li>
									<?php endif;?>
								</ul>
								
								
							</li>
							<?php endif;?>
							<?php }?>
							
							

							<?php if(is_admin()): ?>
							<li>
								<a>
									<i class="fa fa-cog">
									</i>Setting
									<span class="fa fa-chevron-down">
									</span>
								</a>
								<ul class="nav child_menu">
									<li>
										<a href="<?php echo site_url();?>/general-setting/">
											General
										</a>
									</li>
									<li>
										<a href="<?php echo site_url();?>/manage-roles/">
											Manage Roles
										</a>
									</li>
									<li>
										<a href="<?php echo site_url();?>/import/">
											Import from access
										</a>
									</li>
								</ul>
							</li>
							<?php endif; ?>
			
			
										<li>
								<a>
									<i class="fa fa-cog">
									</i>Help
									<span class="fa fa-chevron-down">
									</span>
								</a>
								<ul class="nav child_menu">
									<li>
										<a href="<?php echo site_url();?>/help/">
											General Help
										</a>
									</li>
								</ul>
							</li>
			
			
			
						</ul>
					</div>
				</div>
				<!-- /sidebar menu -->
			</div>
		</div><!--Sidebar end-->
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function top_bar(){
		ob_start();
		?>
		<div class="top_nav">
			<div class="nav_menu">
				<nav class="" role="navigation">
					<div class="nav toggle">
						<a id="menu_toggle">
							<i class="fa fa-bars">
							</i>
						</a>
					</div>

					<ul class="nav navbar-nav navbar-right">
						<li class="">
							<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<img src="<?php echo get_current_user_profile_image();?>" alt=""><?php echo get_current_user_name();?>
								<span class=" fa fa-angle-down">
								</span>
							</a>
							<ul class="dropdown-menu dropdown-usermenu pull-right">
								<li>
									<a href="<?php echo site_url();?>/profile/">
										Profile
									</a>
								</li>
								<li>
									<a href="<?php echo site_url();?>/change-password/">
										Change Password
									</a>
								</li>
								<li>
									<a href="<?php echo site_url();?>/logout/" class="link-logout">
										<i class="fa fa-sign-out pull-right">
										</i>Log Out
									</a>
								</li>
							</ul>
						</li>

						<?php echo $this->profile->notifications__top__bar(); ?>
					</ul>
				</nav>
			</div>
		</div>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function page__header($title,$status = true){
		ob_start();
		?>
		<div class="page-title">
			<div class="title_left">
				<h3>
					<?php _e($title);?>
				</h3>
			</div>

			<?php if($status === true): ?>

			<?php endif; ?>
		</div>
		<div class="clearfix"></div>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function home__page__header(){
		ob_start();
		?>
		<nav>
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<h1>
							<?php echo get_site_name();?>
						</h1>
						<p>
							<?php echo get_site_description();?>
						</p>
					</div>
				</div>
			</div>
		</nav>
		<?php
		$content = ob_get_clean();
		return $content;
	}
}
endif;
?>