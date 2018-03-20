<?php
// if accessed directly than exit
if(!defined('ABSPATH')) exit;

if( !class_exists('User') ):
	class User{
		private $database;
		private $current__user__id;
		private $current__user;
		
		function __construct(){
			global $db;
			$this->database = $db;
			$this->current__user__id = get_current_user_id();
			$this->current__user = get_userdata($this->current__user__id);
		}

		public function demo__page(){
			ob_start();
			?>
    <?php
			$content = ob_get_clean();
			return $content;
		} 

		public function login__page(){
			ob_start();
			?>
        <div class="row">
            <div class=" main-box">
                <div class="col-md-4 col-xs-12 pull-right">
                    <form class="login-form" method="get" autocomplete="off">
                        <h3 class="form-title">Sign In <i class="fa fa-lock"></i></h3>
                        <div class="form-group">
                            <label for="user_name">Username <span class="required">*</span></label>
                            <input type="text" name="user_name" class="form-control input-sm" placeholder="" /> </div>
                        <div class="form-group">
                            <label for="user_pass">Password <span class="required">*</span></label>
                            <input type="password" name="user_pass" class="form-control input-sm" placeholder="" /> </div> <span style="height:5px;display: block;">&nbsp;</span>
                        <div class="form-group">
                            <input type="hidden" name="action" value="user_login" />
                            <button class="btn btn-block btn-success btn-sm" type="submit"><i class="fa fa-lock"></i> Login</button>
                        </div>
                        <div class="form-group">
                            <div class="alert alert-success">Welcome Back, Successfully logged in.</div>
                            <div class="alert alert-danger"></div>
                        </div>
                        <div class="form-group">
                            <div class="text-center"> 
								<strong>OR</strong> </div> <span style="height:5px;display: block;">&nbsp;</span> <a href="<?php echo site_url();?>/reset_password/" <button class="btn btn-block btn-warning btn-sm" type="button"><i class="fa fa-question-circle"></i>  Forgot your password ?</button></a> 
				</div>
                    </form>
                </div>
                <div class="col-md-7 col-xs-12 text-center hidden-xs ">
                    <h1 class=" big-title">Welcome to the NCCPM online Fault Reporting System.</h1>
                    <div class="ln_solid"></div>
                    <h3>This service is part of the NHS breast screening programme (NHSBSP)</h3>
                    <p>Please login to access the equipment and fault management services.</p>
<script>
	navigator.sayswho= (function(){
    var ua= navigator.userAgent, tem, 
    M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
    if(/trident/i.test(M[1])){
        tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
        return 'IE '+(tem[1] || '');
    }
    if(M[1]=== 'Chrome'){
        tem= ua.match(/\b(OPR|Edge)\/(\d+)/);
        if(tem!= null) return tem.slice(1).join(' ').replace('OPR', 'Opera');
    }
    M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
    if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
    return M.join(' ');
})();


	if(navigator.sayswho=="MSIE 7"||navigator.sayswho=="MSIE 8"){
		alert("Your browser is outdated and certain features may not work, please update you internet browser.");	
	}
	if (navigator.sayswho.indexOf('Chrome') >= 0){
		console.log(navigator.sayswho);
		num = navigator.sayswho.replace(/^\D+/g, "");
		console.log(num);
		if(num<=49){
			alert("Your browser is outdated and certain features may not work, please update you internet browser.");	
		}
	}
	
					</script>                

</div>
                <div class="col-md-1"></div>
            </div>
        </div>
        <?php
			$content = ob_get_clean();
			return $content;
		}

		
		
		
		
				public function forgot__page(){
			ob_start();
			?>
            <div class="row">
                <div class=" main-box">
                    <div class="col-md-4 col-xs-12 pull-right">
                        <form class="forgot-form" method="get" autocomplete="off">
                            <h3 class="form-title">Forgot Password <i class="fa fa-lock"></i></h3>
                            <p>Please input your email in the form below and an email will be sent with a new password</p>
                            <p>Once you have logged in with the new password you are free to change it.</p>
                            <br>
                            <br>
                            <div class="form-group">
                                <label for="user_name">email address: <span class="required">*</span></label>
                                <input type="text" name="user_name" class="form-control input-sm" placeholder="" /> </div> <span style="height:5px;display: block;">&nbsp;</span>
                            <div class="form-group">
                                <input type="hidden" name="action" value="pword_login" />
                                <button class="btn btn-block btn-success btn-sm" type="submit"><i class="fa fa-lock"></i> Reset password</button>
                            </div>
                            <div class="form-group">
                                <div class="alert alert-success">Please allow a few minutes for a new password to be generated and sent to your email address provided.</div>
                                <div class="alert alert-danger"></div>
                            </div>
                            <div class="form-group"> <span style="height:5px;display: block;">&nbsp;</span> <a href="<?php echo site_url();?>/login/" <button class="btn btn-block btn-warning btn-sm" type="button">  Back to Login page </button></a> </div>
                        </form>
                    </div>
                    <div class="col-md-7 col-xs-12 text-center hidden-xs ">
                        <h1 class=" big-title">Welcome to the NCCPM online Fault Reporting System.</h1>
                        <div class="ln_solid"></div>
                        <p>Please login to access the equipment and fault management services.</p>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
            <?php
			$content = ob_get_clean();
			return $content;
		}
		public function upload__image__section(){
			ob_start();
			?>
                <div class="modal fade" id="upload-image-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"> <span aria-hidden="true">&times;</span> </button>
                                <h4 class="modal-title green" id="myModalLabel">Upload Profile Image</h4> </div>
                            <form class="upload-profile-image" method="post" autocomplete="off">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="question">Choose an image for upload <span class="required">*</span></label>
                                        <input type="file" name="photo" accept="image/*" /> <span class="help-block green">Supported image formats: jpeg, png, jpg</span> <span class="help-block green">Recommended profile image size: 300 x 300 pixels</span> </div>
                                    <div class="form-group">
                                        <div class="alert alert-success"><i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i> Image is being upload, please do not close upload box ..</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="action" value="upload_profile_image" />
                                    <!--<button class="btn btn-success" type="submit">Submit</button>-->
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
			$content = ob_get_clean();
			return $content;
		}

		public function activity__and__access__log__section( $user__id ){
			ob_start();
			global $db;
			$user = get_user_by('id',$user__id);

			/*Notifications Query*/
			$notifications__query = " ORDER BY `ID` DESC LIMIT 0, 5";
			$notifications__args = array('user_id'=> $user__id);
			$notifications__result = get_tabledata(TBL_NOTIFICATIONS,false,$notifications__args,$notifications__query);

			/*Access Log Query*/
			$access__log__query = " ORDER BY `ID` DESC LIMIT 0, 10";
			$access__log__args = array('user_id'=> $user__id);
			$access__log__result = get_tabledata(TBL_ACCESS_LOG,false,$access__log__args,$access__log__query);
			?>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <div class="profile_title">
                            <div class="col-md-6">
                                <h2>User Activity Report</h2> </div>
                        </div>
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="active"> <a href="#tab_content1" role="tab" data-toggle="tab" aria-expanded="true">Recent Activity</a> </li>
                                <li role="presentation" class=""> <a href="#tab_content2" role="tab" data-toggle="tab" aria-expanded="false">Recent Access Log</a> </li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                    <!-- start recent activity -->
                                    <ul class="messages list-unstyled">
                                        <?php if($notifications__result): foreach($notifications__result as $user__notifications): ?>
                                            <li> <img src="<?php echo get_user_profile_image($user__notifications->user_id);?>" class="avatar" alt="Avatar">
                                                <div class="message_date">
                                                    <h3 class="date text-info">
											<?php echo date('d',strtotime($user__notifications->date));?>
										</h3>
                                                    <p class="month">
                                                        <?php echo date('M',strtotime($user__notifications->date));?>
                                                    </p>
                                                </div>
                                                <div class="message_wrapper">
                                                    <h4 class="heading">
											<?php echo $user__notifications->title;?>
											<small><?php echo date('M d, Y h:i a',strtotime($user__notifications->date));?></small>
										</h4>
                                                    <blockquote class="message">
                                                        <?php _e(htmlspecialchars_decode($user__notifications->notification));?>
                                                    </blockquote>
                                                    <br /> </div>
                                            </li>
                                            <?php endforeach; else: ?>
                                                <li>
                                                    <h5>There is no recent activity details</h5> </li>
                                                <?php endif; ?>
                                    </ul>
                                    <!-- end recent activity -->
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                    <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Last Login</th>
                                                <th>Location</th>
                                                <th>Device</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
									if($access__log__result):
									foreach($access__log__result as $access__log__row): ?>
                                                <tr>
                                                    <td>
                                                        <?php echo date('M d, Y h:i A',strtotime($access__log__row->date));?>
                                                    </td>
                                                    <td>
                                                        <?php echo $access__log__row->ip_address;?>
                                                    </td>
                                                    <td>
                                                        <a href="#" data-toggle="tooltip" title="<?php echo $access__log__row->user_agent;?>">
                                                            <?php echo $access__log__row->device;?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php endforeach; endif;
									?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
			$content = ob_get_clean();
			return $content;
		}

		public function view__profile__page(){
			ob_start();
			global $db;
			$user__id = $_GET['user_id'];
			$user = get_userdata($user__id);
			if(!user_can('view_user')):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
			elseif(!$user):
			echo page_not_found('Oops ! User Details Not Found.','Please go back and check again !');
			else:
			?>
                        <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                            <div class="profile_img">
                                <div id="crop-avatar">
                                    <!-- Current avatar --><img class="img-responsive avatar-view" src="<?php echo get_user_profile_image($user__id);?>" alt="Avatar"> </div>
                            </div>
                            <h3>
					<?php echo $user->first_name.' '.$user->last_name;?>
				</h3>
                            <ul class="list-unstyled user_data">
                                <li> <i class="fa fa-envelope-o">
						</i>
                                    <?php _e($user->user_email);?>
                                </li>
                                <?php
					if(get_user_meta($user->ID,'gender') == 'Male'): ?>
                                    <li> <i class="fa fa-male">
						</i>Male </li>
                                    <?php
					elseif(get_user_meta($user->ID,'gender') == 'Female'): ?>
                                        <li> <i class="fa fa-female">
						</i>Female </li>
                                        <?php endif; ?>
                                            <?php
					if(get_user_meta($user__id,'user_phone') != ''): ?>
                                                <li> <i class="fa fa-phone">
						</i>
                                                    <?php echo get_user_meta($user__id,'user_phone');?>
                                                </li>
                                                <?php endif; ?>
                                                    <li class="m-top-xs"> <i class="fa fa-child">
						</i>
                                                        <?php echo date('M d,Y',strtotime(get_user_meta($user->ID,'dob')));?>
                                                    </li>
                            </ul>
                            <br />
                            <a class="btn btn-success btn-sm" href="<?php echo site_url();?>/edit-user/?user_id=<?php echo $user__id;?>"> <i class="fa fa-edit m-right-xs">
					</i>&nbsp;Edit User </a>
                        </div>
                        <?php echo $this->activity__and__access__log__section( $user->ID );
			endif;
			$content = ob_get_clean();
			return $content;
		}

		public function add__user__page(){
			ob_start();
			if(!user_can('add_user')):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
			else:
			?>
                            <form class="add-user user-form" method="post" autocomplete="off">
                                <div class="row">
                                    <div class="form-group col-sm-6 col-xs-12">
                                        <label for="first_name"> Username <span class="required">
								*
							</span> </label>
                                        <input type="text" name="username" class="form-control require" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6 col-xs-12">
                                        <label for="first_name"> First Name <span class="required">
								*
							</span> </label>
                                        <input type="text" name="first_name" class="form-control require" /> </div>
                                    <div class="form-group col-sm-6 col-xs-12">
                                        <label for="last_name"> Last Name <span class="required">
								*
							</span> </label>
                                        <input type="text" name="last_name" class="form-control require" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6 col-xs-12">
                                        <label for="email"> Email <span class="required">
								*
							</span> </label>
                                        <input type="text" name="user_email" class="form-control require" /> </div>
                                    <div class="form-group col-sm-6 col-xs-12" style='display:none;'>
                                        <label for="dob"> Date of birth </label>
                                        <input type="text" name="dob" class="form-control input-datepicker" readonly="readonly" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6 col-xs-12">
                                        <label for="gender"> Gender <span class="required">
								*
							</span> </label>
                                        <select name="gender" class="form-control select_single require" tabindex="-1" data-placeholder="Choose a gender">
                                            <option value=""> </option>
                                            <option value="Male"> Male </option>
                                            <option value="Female"> Female </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6 col-xs-12">
                                        <label for="phone"> Phone </label>
                                        <input type="text" name="user_phone" class="form-control" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6 col-xs-12">
                                        <label for="company"> User Type <span class="required">
								*
							</span> </label>
                                        <?php
			if(is_admin()){
			?>
                                            <select name="user_role" class="form-control select_single require" tabindex="-1" data-placeholder="Choose role">
                                                <?php echo get_options_list(get_roles()); ?>
                                            </select>
                                            <?php
			}else{
				?>
                                                <select name="user_role" class="form-control select_single require" tabindex="-1" data-placeholder="Choose role">
                                                    <?php echo get_options_list(get_roles2()); ?>
                                                </select>
                                                <?php
			}
				?>
                                    </div>
                                    <div class="form-group col-sm-6 col-xs-12">
                                        <label for="hostipals"> Designation <span class="required">
								*
							</span> </label>
                                        <select name="designation" class="form-control select_single require" tabindex="-1" data-placeholder="Choose designation">
                                            <?php $option_data = get_designations(); echo get_options_list($option_data); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6 col-xs-12">
                                        <label for="eentre">Centre <span class="required"> *</span></label>
                                        <select name="centre" class="form-control select_single fetch-centre-equipment-data" tabindex="-1" data-placeholder="Choose centre">
                                            <?php
							$query = '';
							if(!is_admin()):
								$centres = maybe_unserialize($this->current__user->centre);
								if(!empty($centres)){
									$centres = implode(',',$centres);
									$query = "WHERE `ID` IN (".$centres.")";
								}
							endif;
							$query .= ($query != '') ? ' AND ' : ' WHERE ';
							$query .= " `approved` = '1' ORDER BY `name` ASC";
							$data = get_tabledata(TBL_CENTRES,false,array(),$query);
							$option_data = get_option_data($data,array('ID','name'));
							echo get_options_list($option_data);
							?>
                                        </select>
                                    </div>
                                </div>
                                <?php
			
			?>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 form-goup">
                                            <label> Upload Profile Image </label>
                                            <input type="text" name="profile_img" class="form-control" value="" placeholder="Uploaded image url" readonly="readonly" />
                                            <br/>
                                            <a href="#" class="btn btn-default btn-sm" data-toggle="modal" data-target="#upload-image-modal"> <i class="fa fa-camera">
							</i>&nbsp;Upload Image </a>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 form-group">
                                            <div class="profile-image-preview-box"> <img src="" class="img-responsive img-thumbnail" /> </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6 col-xs-12">
                                            <label for=""> Disable Account </label>
                                            <br/>
                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" class="flata" name="user_status" value="0"> Yes </label>
                                            </div>
                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" class="flata" name="user_status" value="1" checked> No </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ln_solid"> </div>
                                    <div class="form-group">
                                        <input type="hidden" name="action" value="add_new_user" />
                                        <button class="btn btn-success btn-md" type="submit"> Add New User </button>
                                    </div>
                            </form>
                            <?php echo $this->upload__image__section();?>
                                <?php
			endif;
			$content = ob_get_clean();
			return $content;
		}

		public function edit__user__page(){
			ob_start();
			$user__id = $_GET['user_id'];
			$user = get_userdata($user__id);
			if(!user_can('edit_user')):
				echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
			elseif(!$user):
				echo page_not_found('Oops ! User Details Not Found.','Please go back and check again !');
			else:
			?>
                                    <form class="edit-user user-form" method="post" autocomplete="off">
                                        <div class="row">
                                            <div class="form-group col-sm-6 col-xs-12">
                                                <label for="first_name"> Username <span class="required">
								*
							</span> </label>
                                                <input type="text" name="username" class="form-control require" value="<?php _e($user->username);?>" /> </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-6 col-xs-12">
                                                <label for="first_name">First Name <span class="required">*</span></label>
                                                <input type="text" name="first_name" class="form-control require" value="<?php _e($user->first_name);?>" /> </div>
                                            <div class="form-group col-sm-6 col-xs-12">
                                                <label for="last_name">Last Name <span class="required">*</span></label>
                                                <input type="text" name="last_name" class="form-control require" value="<?php _e($user->last_name);?>" /> </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-6 col-xs-12">
                                                <label for="email">Email <span class="required">*</span></label>
                                                <input type="text" name="user_email" class="form-control require" value="<?php _e($user->user_email);?>" /> </div>
                                            <div class="form-group col-sm-6 col-xs-12" style='display:none;'>
                                                <label for="dob">Date of birth</label>
                                                <?php
						$dob = trim(get_user_meta($user->ID,'dob'));
						if($dob != ''){
							$dob = date('M d, Y', strtotime($dob));
						}
						?>
                                                    <input type="text" name="dob" class="form-control input-datepicker" readonly="readonly" value="<?php echo $dob;?>" /> </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-6 col-xs-12">
                                                <label for="gender">Gender <span class="required">*</span> </label>
                                                <select name="gender" class="form-control select_single require" tabindex="-1" data-placeholder="Choose a gender">
                                                    <option value=""></option>
                                                    <option value="Male" <?php if(trim(get_user_meta($user->ID,'gender')) == 'Male') { echo 'selected'; } ?>>Male</option>
                                                    <option value="Female" <?php if(trim(get_user_meta($user->ID,'gender')) == 'Female') { echo 'selected'; } ?>>Female</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6 col-xs-12">
                                                <label for="user_phone">Phone</label>
                                                <input type="text" name="user_phone" class="form-control" value="<?php echo get_user_meta($user__id,'user_phone');?>" /> </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-6 col-xs-12">
                                                <label for="company">User Type <span class="required">*</span></label>
                                                <?php
			if(is_admin()){
			?>
                                                    <select name="user_role" class="form-control select_single require" tabindex="-1" data-placeholder="Choose role">
                                                        <?php echo get_options_list(get_roles(),array($user->user_role)); ?>
                                                    </select>
                                                    <?php
			}else{
				?>
                                                        <select name="user_role" class="form-control select_single require" tabindex="-1" data-placeholder="Choose role">
                                                            <?php echo get_options_list(get_roles2(),array($user->user_role)); ?>
                                                        </select>
                                                        <?php
			}
				?>
                                            </div>
                                            <div class="form-group col-sm-6 col-xs-12">
                                                <label for="hostipals">Designation <span class="required">*</span></label>
                                                <select name="designation" class="form-control select_single require" tabindex="-1" data-placeholder="Choose designation">
                                                    <?php $option_data = get_designations(); echo get_options_list($option_data , array(trim ( get_user_meta($user->ID,'designation') ) ) ); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-12 col-xs-12">
                                                <label for="centre">Centre <span class="required">*</span> <a href='#' onclick="addAllCentres('all'); return false;" >[Add all centres]</a>
						<?php
							$data = get_tabledata(TBL_REGIONS,false,array('approved'=> '1'));
							foreach($data as $row) {
								echo(" : <a href='#' onclick=\"addAllCentres('".$row->ID."'); return false;\" >[Add region (".$row->name.")]</a>");
							}
						?>
						: <a href='#' onclick="$('#edit_user_centre').val([]); $('#edit_user_centre').trigger('change'); return false;" >[Clear]</a>
                                                </label>
                                                <select name="centre[]" id="edit_user_centre" class="form-control select_single require" tabindex="-1" data-placeholder="Choose centre" multiple="multiple">
                                                    <?php
							$query = '';
							if(!is_admin()):
								$centres = maybe_unserialize($this->current__user->centre);
								if(!empty($centres)){
									$centres = implode(',',$centres);
									$query = "WHERE `ID` IN (".$centres.")";
								}
							endif;

							$query .= ($query != '') ? ' AND ' : ' WHERE ';
							$query .= " `approved` = '1' ORDER BY `name` ASC";
							$data = get_tabledata(TBL_CENTRES,false,array(),$query);
							$option_data = get_option_data($data,array('ID','name'));
							echo get_options_list($option_data , maybe_unserialize($user->centre));
							?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 form-goup">
                                                <label>Upload Profile Image</label>
                                                <input type="text" name="profile_img" class="form-control" value="<?php echo get_user_profile_image($user->ID,false);?>" placeholder="Uploaded image url" readonly="readonly" />
                                                <br/>
                                                <a href="#" class="btn btn-default btn-sm" data-toggle="modal" data-target="#upload-image-modal"> <i class="fa fa-camera"></i>&nbsp;Upload Image </a>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 form-group">
                                                <div class="profile-image-preview-box"> <img src="<?php echo get_user_profile_image($user->ID);?>" class="img-responsive img-thumbnail" /> </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-6 col-xs-12">
                                                <label for="user_pass">Reset Password</label>
                                                <input type="text" name="user_pass" value="" class="form-control" />
                                                <div>&nbsp;</div>
                                                <button class="btn btn-default generate-password">Generate Password</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-6 col-xs-12">
                                                <label for="">Disable Account</label>
                                                <br/>
                                                <div class="radio-inline">
                                                    <label>
                                                        <input type="radio" class="flata" name="user_status" value="0" <?php echo ($user->user_status == 0) ? 'checked' : '';?>> Yes </label>
                                                </div>
                                                <div class="radio-inline">
                                                    <label>
                                                        <input type="radio" class="flata" name="user_status" value="1" <?php echo ($user->user_status == 1) ? 'checked' : '';?>> No </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div>&nbsp;</div>
                                            <input type="hidden" name="action" value="edit_user" />
                                            <input type="hidden" name="user_id" value="<?php echo $user__id;?>" />
                                            <button class="btn btn-success btn-md" type="submit">Update User</button>
                                        </div>
                                    </form>
                                    <?php echo $this->upload__image__section();?>
                                        <?php
			endif;
			$content = ob_get_clean();
			return $content;
		}
		
		
		public function help__page(){
			
		}
		

		public function all__users__page(){
			ob_start();
			
			$centres = maybe_unserialize($this->current__user->centre);
			$args = (!is_admin()) ? array('created_by'=> $this->current__user__id) : array();
			$users_list = get_tabledata(TBL_USERS,false,$args);
			if(!user_can('view_user')):
				echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
			elseif(!$users_list):
				echo page_not_found("THERE ARE NO  New Users in website",' ',false);
			else:
			?>
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap datatable-buttons" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Registered On</th>
                                                        <?php if(is_admin()): ?>
                                                            <th class="text-center">Status</th>
                                                            <?php endif; ?>
                                                                <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
					if($users_list):
					foreach($users_list as $single_user):
					$admin_label = ($single_user->user_role == 'admin') ? '<label class="label label-success">admin</label>' : '';
					?>
                                                        <tr>
                                                            <td class="text-center"> <img src="<?php echo get_user_profile_image($single_user->ID);?>" class="avatar center-block" alt="Avatar"> </td>
                                                            <td>
                                                                <?php _e($single_user->first_name.' '.$single_user->last_name);?>
                                                                    <?php echo ' '.$admin_label;?>
                                                            </td>
                                                            <td>
                                                                <?php _e($single_user->user_email);?>
                                                            </td>
                                                            <td>
                                                                <?php echo date('M d,Y',strtotime($single_user->registered_at));?>
                                                            </td>
                                                            <?php if(is_admin()): ?>
                                                                <td class="text-center">
                                                                    <label>
                                                                        <input type="checkbox" class="js-switch" <?php checked($single_user->user_status , 1);?> onClick="javascript:approve_switch(this);" data-id="
                                                                        <?php echo $single_user->ID;?>" data-action="user_account_status_change"/> </label>
                                                                </td>
                                                                <?php endif; ?>
                                                                    <td class="text-center">
                                                                        <a href="<?php echo site_url();?>/view-user/?user_id=<?php echo $single_user->ID;?>" class="btn btn-success btn-xs"> <i class="fa fa-eye">
								</i>View </a>
                                                                        <a href="<?php echo site_url();?>/edit-user/?user_id=<?php echo $single_user->ID;?>" class="btn btn-dark btn-xs"> <i class="fa fa-edit">
								</i>Edit </a>
                                                                        <a href="#" class="btn btn-danger btn-xs" onclick="javascript:delete_function(this);" data-id="<?php echo $single_user->ID;?>" data-action="delete_user"> <i class="fa fa-trash">
								</i>Delete </a>
                                                                    </td>
                                                        </tr>
                                                        <?php
					endforeach;
					endif;
					?>
                                                </tbody>
                                            </table>
                                            <?php endif; ?>
                                                <?php
			$content = ob_get_clean();
			return $content;
		}

		//Process functions starts here
public function user__login__process(){
			global $device;
			extract($_POST);
			
if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $user_name)) { 

				if(email_exists($user_name)){
				$user = get_user_by('email',$user_name);
				error_log($user_pass." : ".$user->ID);
				if(check_password($user_pass,$user->ID)){
					if(!is_user_active($user->ID)){
						return 2;
					}else{
						set_current_user($user->ID);
						$this->database->insert(TBL_ACCESS_LOG,
							array(
								'user_id' => $user->ID,
								'ip_address'=> $_SERVER['REMOTE_ADDR'],
								'device' => $device,
								'user_agent'=> $_SERVER ['HTTP_USER_AGENT']
							)
						);
						return 1;
					}
				}else{
					return 0;
				}
			}else{
				return 0;
			}
	
	
} 
else { 
			if(username_exists($user_name)){
				$user = get_user_by('username',$user_name);
				if(check_password($user_pass,$user->ID)){
					if(!is_user_active($user->ID)){
						return 2;
					}else{
						set_current_user($user->ID);
						$this->database->insert(TBL_ACCESS_LOG,
							array(
								'user_id' => $user->ID,
								'ip_address'=> $_SERVER['REMOTE_ADDR'],
								'device' => $device,
								'user_agent'=> $_SERVER ['HTTP_USER_AGENT']
							)
						);
						return 1;
					}
				}else{
					return 0;
				}
			}else{
				return 0;
			}
} 

			

		}
		
		
		
		public function reset__login__process(){
			global $device;
			extract($_POST);
			if(email_exists($user_name)){
				$user = get_user_by('email',$user_name);
				
			$user_pass = password_generator();
			$record_pass = $user_pass;
			$salt = generateSalt();
			$user_pass = hash('SHA256', encrypt($user_pass, $salt));
			$salt = base64_encode($salt);
			//$pword = set_password($user_pass);
				
			$result1 = $this->database->update(TBL_USERS,array('user_pass'=> $user_pass, 'user_salt' => $salt),array('user_email'=> $user_name));
				
				//MAILER 
			$subject = "NCCPM Fault Management System - Login Details";
			$body = "Welcome, your login email address is: ". $user_name . " and your password is: " . $record_pass . ". The password can be changed once logged in.";
			 $admn = "admin@admin.com";
			send_email($admn,$user_name,$user_name, $subject, $body);
				
				return 1;
			}else{
				return 0;
			}
		}

		public function add__user__process(){
			extract($_POST);
			$return = array(
				'status' => 0,
				'message_heading' => 'Failed !',
				'message' => 'Could not create account, Please try again.',
				'reset_form' => 0
			);
			
			if(user_can('add_user')):
				if(email_exists($user_email)):
					$return['status'] = 2;
					$return['message_heading'] = 'Email Already Exist';
					$return['message'] = 'Email address you entered is already exists, please try another email address.';
					$return['fields'] = array('user_email');
				else:
					if(!isset($centre))
						$centre = '';
						
					//$user_pass = password_generator();
					$user_pass = 'passw0rd1234';;
					$record_pass = $user_pass;
					$salt = generateSalt();
					$user_pass = hash('SHA256', encrypt($user_pass, $salt));
					$salt = base64_encode($salt);

					$guid = get_guid(TBL_USERS);
					$result = $this->database->insert(TBL_USERS,
						array(
							'ID' => $guid,
							'first_name' => $first_name,
							'username' => $username,
							'last_name' => $last_name,
							'user_email' => $user_email,
							'user_role' => $user_role,
							'user_status' => 1,
						'centre' => $centre,
							'user_pass' => $user_pass,
							'user_salt' => $salt,
							'created_by' => $this->current__user__id,
						)
					);
					if($result):
						$subject = "NCCPM Fault Management System - Login Details";
						$body = "Welcome, your login email address is: ". $user_name . " and your password is: " . $record_pass . ". The password can be changed once logged in.";
						 $admn = "admin@admin.com";
						send_email($admn,$user_name,$user_name, $subject, $body);
						$user__id = $guid;
						update_user_meta($user__id,'designation',$designation);
						update_user_meta($user__id,'gender',$gender);
						update_user_meta($user__id,'dob',date('Y-m-d h:i:s',strtotime($dob) ) );
						update_user_meta($user__id,'user_phone',$user_phone);
						update_user_meta($user__id,'profile_img',$profile_img);
						$notification_args = array(
							'title' => 'New Account Created',
							'notification' => 'You have successfully created a new account ('.ucfirst($first_name).' '.ucfirst($last_name).').',
						);
						add_user_notification($notification_args);
						$return['status'] = 1;
						$return['message_heading'] = 'Success !';
						$return['message'] = 'Account has been successfully created.';
						$return['reset_form'] = 1;
					endif;
				endif;
			endif;
			
			return json_encode($return);
		}

		public function update__user__process(){
			extract($_POST);
			
			$return = array(
				'status' => 0,
				'message_heading' => 'Failed !',
				'message' => 'Could not update account details, Please try again ',
				'reset_form' => 0
			);
			
			if(user_can('edit_user')):
				$user = get_userdata($user_id);
				if( is_value_exists(TBL_USERS,array('user_email' => $user_email),$user_id) ):
					$return['status'] = 2;
					$return['message_heading'] = 'Email Already Exist';
					$return['message'] = 'Email address you entered is already exists, please try another email address.';
					$return['fields'] = array('user_email');
				else:
					$check = false;
					if(!isset($centre))
						$centre = '';
					
					
					$result = $this->database->update(TBL_USERS,
						array(
							'username' => $username,
							'first_name' => $first_name,
							'last_name' => $last_name,
							'user_email' => $user_email,
							'user_status' => $user_status,
							'user_role' => $user_role,
							'centre' => $centre,

						),
						array('ID' => $user_id)
					);
					$check = ($result) ? true : false;
					$check = true;
				
					$result1 = false;
					if($user_pass != ''){
						$salt = generateSalt();
						$user_pass = hash('SHA256', encrypt($user_pass, $salt));
						$salt = base64_encode($salt);
						$result1 = $this->database->update(TBL_USERS,array('user_pass' => $user_pass, 'user_salt' => $salt),array('ID' => $user_id));
					}
					$check = ($result1) ? true : $check;
					if($result1){
						$notification_args = array(
							'title' => 'User Password Reset',
							'notification' => 'You have successfully changed ('.ucfirst($first_name).' '.ucfirst($last_name).') account password.',
						);
						add_user_notification($notification_args);
					}
			
					if($check):
						update_user_meta($user_id,'designation',$designation);
						update_user_meta($user_id,'gender',$gender);
						update_user_meta($user_id,'dob',date('Y-m-d h:i:s',strtotime($dob) ) );
						update_user_meta($user_id,'user_phone',$user_phone);
						update_user_meta($user_id,'profile_img',$profile_img);
						$notification_args = array(
							'title' => 'Account Details updated',
							'notification' => 'You have successfully updated ('.ucfirst($first_name).' '.ucfirst($last_name).') account details.',
						);
						add_user_notification($notification_args);
						$return['status'] = 1;
						$return['message_heading'] = 'Success !';
						$return['message'] = 'Account has been successfully updated.';
					endif;
				endif;
			endif;
			
			return json_encode($return);
		}

		public function upload__image__process(){
			$upload_str = '/uploads/profile_images/'.date('Y').'/'.date('m').'/';
			$upload_img = ABSPATH . CONTENT . $upload_str;
			$upload_url = '/content/'.$upload_str;
			if(!file_exists($upload_img))
			mkdir($upload_img, 0755, true);
			if(isset($_FILES["photo"]) && $_FILES["photo"]["size"] > 0){
				$sourcePath = $_FILES["photo"]["tmp_name"];
				$file = pathinfo($_FILES['photo']['name']);
				$fileType = $file["extension"];
				$full_img = 'profile-img-'.time().'.'.$fileType;
				createThumb($sourcePath, $upload_img.$full_img,$fileType,300,300,300);
				return $upload_url.$full_img;
			}else{
				return 0;
			}
		}

		public function account__status__change__process(){
			extract($_POST);
			$return = array(
				'status' => 0,
				'message_heading' => 'Failed !',
				'message' => 'Could not update user account details, Please try again ',
				'reset_form' => 0
			);
			if(is_admin() && $this->current__user__id != $id):
				$user = get_userdata($id);	
				$args = array('ID' => $id);
				$result = $this->database->update(TBL_USERS,array('user_status' => $status),$args);
			
				if($result):
					if($status == 0){
						$notification_args = array(
							'title' => ucfirst($user->user_role).' Account Disabled',
							'notification' => 'You have successfully disbled ('.ucfirst($user->first_name).' '.ucfirst($user->last_name).') account.',
						);
						$return['message'] = 'You have successfully disbled ('.ucfirst($user->first_name).' '.ucfirst($user->last_name).') account.';
					}else{
						$notification_args = array(
							'title' => ucfirst($user->user_role).' Account Enabled',
							'notification' => 'You have successfully enabled ('.ucfirst($user->first_name).' '.ucfirst($user->last_name).') account.',
						);
						$return['message'] = 'You have successfully enabled ('.ucfirst($user->first_name).' '.ucfirst($user->last_name).') account.';
					}
					add_user_notification($notification_args);
					$return['status'] = 1;
					$return['message_heading'] = 'Success !';
				endif;
			endif;
			return json_encode($return);
		}

		public function delete__user__process(){
			extract($_POST);
			if(is_admin() && $this->current__user__id != $id):
				$user = get_userdata($id);	
				$args  = array('ID' => $id);
				$result = $this->database->delete(TBL_USERS,$args);
				if($result):
					$this->database->delete(TBL_USERMETA,array('user_id' => $id));
					$notification_args = array(
						'title' => 'Account deleted',
						'notification' => 'You have successfully deleted ('.ucfirst($user->first_name).' '.ucfirst($user->last_name).') account.',
					);
					add_user_notification($notification_args);
					return 1;
				else:
					return 0;
				endif;
			else:
				return 0;
			endif;
		}
	}

endif;
?>
