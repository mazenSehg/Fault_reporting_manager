<?php
// if accessed directly than exit
if(!defined('ABSPATH')) exit;

if( !class_exists('Footer') ):
class Footer{
	private $database;
	private $profile;
	function __construct(){
		global $db,$Profile;
		$this->database = $db;
		$this->profile = $Profile;
	}

	public function footer(){
		ob_start();
		?>
		<footer>
			<div class="pull-right">
				Copyright &copy; <?php echo date('Y');?> <?php echo get_site_name();?> &ndash; Developed by Royal Surrey County Hospital
				<strong>
					| Scientific Computing
				</strong>
			</div>
			<div class="clearfix">
			</div>
		</footer>
		<?php echo $this->scripts();?>
		<?php
		$content = ob_get_clean();
		return $content;
	}


	public function scripts(){
		ob_start();
		?>
		<!-- Custom Theme Scripts -->
		<script src="<?php echo JS_URL;?>custom.js">
		</script>
		<script src="<?php echo JS_URL;?>styles.js">
		</script>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function home__page__footer($fixed = ''){
		ob_start();
		?>
		<div class="home-footer <?php echo $fixed; ?>">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="pull-left">
							<small>
								NCCPM - <?php echo get_site_name();?> &ndash; All copyrights reserved
							</small>
						</div>
						<div class="pull-right">
							<small>
								Website Developed by Royal Surrey County Hospital
								<strong>
									| Scientific Computing
								</strong>
							</small>
						</div>
						<div class="clearfix">
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		$content = ob_get_clean();
		return $content;
	}
}
endif;
?>