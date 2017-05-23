<?php
// if accessed directly than exit
if(!defined('ABSPATH')) exit;

if( !class_exists('Profile') ):
class Profile{
	public $user__id;
	private $user;
	private $user__class;
	private $database;

	function __construct(){
		global $db,$User;
		$this->user__class = $User;
		$this->user__id = get_current_user_id();
		$this->user = get_user_by( 'id' ,$this->user__id);
		$this->database = $db;
	}

	public function change__password__page(){
		ob_start();
		?>
		<form class="change-password" method="post" autocomplete="off">
			<div class="form-group">
				<label for="current_password">
					Current Password
					<span class="required">
						*
					</span>
				</label>
				<input type="password" name="current_password" class="form-control required"/>
			</div>
			<div class="form-group">
				<label for="new_password">
					New Password
					<span class="required">
						*
					</span>
				</label>
				<input type="password" name="new_password" class="form-control required"/>
			</div>
			<div class="form-group">
				<label for="confirm_password">
					Confirm Password
					<span class="required">
						*
					</span>
				</label>
				<input type="password" name="confirm_password" class="form-control required"/>
			</div>
			<div class="ln_solid">
			</div>
			<div class="form-group">
				<input type="hidden" name="action" value="user_password_change"/>
				<button class="btn btn-success btn-md" type="submit">
					Change Password
				</button>
			</div>
		</form>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function profile__page()
	{
		ob_start();
		?>
		<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
			<div class="profile_img">
				<div id="crop-avatar">
					<!-- Current avatar -->
					<img class="img-responsive avatar-view" src="<?php echo get_current_user_profile_image();?>" alt="Avatar">
				</div>
			</div>

			<h3>
				<?php echo get_current_user_name();?>
			</h3>

			<ul class="list-unstyled user_data">
				<li>
					<i class="fa fa-envelope-o">
					</i><?php _e($this->user->user_email);?>
				</li>
				<?php
				if(get_user_meta($this->user->ID,'gender',true) == 'Male'): ?>
				<li>
					<i class="fa fa-male">
					</i>Male
				</li>
				<?php
				elseif(get_user_meta($this->user->ID,'gender',true) == 'Female'): ?>
				<li>
					<i class="fa fa-female">
					</i>Female
				</li>
				<?php endif; ?>
				<?php
				if(get_user_meta($this->user->ID,'user_phone',true) != ''): ?>
				<li>
					<i class="fa fa-phone">
					</i><?php echo get_user_meta($this->user->ID,'user_phone',true);?>
				</li>
				<?php endif; ?>
				<li class="m-top-xs">
					<i class="fa fa-child">
					</i>
					<?php echo date('M d,Y',strtotime(get_user_meta($this->user->ID,'dob',true)));?>
				</li>
			</ul>

			<a class="btn btn-success btn-sm" href="<?php echo site_url();?>/edit-profile/">
				<i class="fa fa-edit m-right-xs">
				</i>&nbsp;Edit Profile
			</a>
			<br />
		</div>

		<?php echo $this->user__class->activity__and__access__log__section( $this->user->ID );?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function edit__profile__page()
	{
		ob_start();
		?>
		<form class="edit-profile user-form" method="post" autocomplete="off">
			<div class="row">
				<div class="form-group col-sm-6 col-xs-12">
					<label for="first_name">
						First Name
						<span class="required">
							*
						</span>
					</label>
					<input type="text" name="first_name" class="form-control require" value="<?php _e($this->user->first_name);?>"/>
				</div>
				<div class="form-group col-sm-6 col-xs-12">
					<label for="last_name">
						Last Name
						<span class="required">
							*
						</span>
					</label>
					<input type="text" name="last_name" class="form-control require" value="<?php _e($this->user->last_name);?>"/>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-sm-6 col-xs-12">
					<label for="email">
						Email
						<span class="required">
							*
						</span>
					</label>
					<input type="text" name="user_email" class="form-control require" value="<?php _e($this->user->user_email);?>" />
				</div>
				<div class="form-group col-sm-6 col-xs-12">
					<label for="dob">
						Date of birth
					</label>
					<?php  $dob = trim(get_user_meta($this->user->ID,'dob')); $dob = ($dob != '') ? date('M d, Y', strtotime($dob) ) : ''; ?>
					<input type="text" name="dob" class="form-control input-datepicker" readonly="readonly" value="<?php echo $dob;?>"/>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-sm-6 col-xs-12">
					<label for="gender">
						Gender
						<span class="required">
							*
						</span>
					</label>
					<select name="gender" class="form-control select_single require" tabindex="-1" data-placeholder="Choose a gender">
						<option value="">
						</option>
						<option value="Male" <?php
 if(trim(get_user_meta($this->user->ID,'gender')) == 'Male')
{ echo 'selected'; } ?>>
							Male
						</option>
						<option value="Female" <?php
 if(trim(get_user_meta($this->user->ID,'gender')) == 'Female')
{ echo 'selected'; } ?>>
							Female
						</option>
					</select>
				</div>
				<div class="form-group col-sm-6 col-xs-12">
					<label for="user_phone">
						Phone
					</label>
					<input type="text" name="user_phone" class="form-control" value="<?php echo get_user_meta($this->user->ID,'user_phone');?>"/>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12 col-sm-6 form-goup">
					<label>
						Upload Profile Image
					</label>
					<input  type="text" name="profile_img"  class="form-control" value="<?php echo get_user_profile_image($this->user->ID,false);?>" placeholder="Uploaded image url" readonly="readonly"/>
					<br/>
					<a href="#" class="btn btn-default btn-sm" data-toggle="modal" data-target="#upload-image-modal">
						<i class="fa fa-camera">
						</i>&nbsp;Upload Image
					</a>
				</div>
				<div class="col-xs-12 col-sm-6 form-group">
					<div class="profile-image-preview-box">
						<img src="<?php echo get_user_profile_image($this->user->ID);?>" class="img-responsive img-thumbnail" />
					</div>
				</div>
			</div>

			<div class="ln_solid">
			</div>

			<div class="form-group">
				<div>
					&nbsp;
				</div>
				<input type="hidden" name="action" value="edit_user_profile"/>
				<button class="btn btn-success btn-md" type="submit">
					Update Profile
				</button>
			</div>
		</form>
		<?php echo $this->user__class->upload__image__section();?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function notifications__page(){
		ob_start();
		$notifications__args = array('user_id'=> $this->user__id ,'hide'   => 0);
		$notifications__result1 = get_tabledata(TBL_NOTIFICATIONS,false,$notifications__args);

		$per_page      = 10;         // NUMBER OF RESULT SHOW PER PAGE
		$total_results = count($notifications__result1); 	// GET TOTAL RECORDS
		$total_pages   = ceil($total_results / $per_page); 	// TOTAL PAGES

		//-------------if page is setcheck------------------//
		if(isset($_GET['page'])):
		$show_page = $_GET['page'];
		$show_page = ($show_page <= 0) ? 1 : $show_page;
		$show_page = ($show_page > $total_pages) ? $total_pages : $show_page;
		//it will telles the current page
		if($show_page > 0 && $show_page <= $total_pages):
		$start = ($show_page - 1) * $per_page;
		$end   = $per_page;
		else:
		// error - show first set of results
		$start = 0;
		$end   = $per_page;
		endif;
		else:
		// if page isn't set, show first set of results
		$start     = 0;
		$end       = $per_page;
		$show_page = 1;

		endif;

		//PAGINATIONH QUERY
		$pagination_query      = " ORDER BY `ID` DESC LIMIT $start, $end ";
		$notifications__result = get_tabledata(TBL_NOTIFICATIONS,false,$notifications__args,$pagination_query );
		$paginate_url = site_url().'/notifications';
		if($notifications__result):
		?>
		<div>
			<button class="btn btn-dark btn-sm read-notification" data-id="0" data-type="all">
				Mark all read
			</button>
			<button class="btn btn-dark btn-sm hide-notification" data-id="0" data-type="all">
				Hide all notifications
			</button>
			<div class="ln_solid">
			</div>
			<h2>
				Showing <?php echo $start + 1;?> - <?php echo $start + $end;?> notifications from <?php echo $total_results;?>
			</h2>
			<div class="ln_solid">
			</div>
		</div>

		<ul class="messages">
			<?php
			foreach($notifications__result as $notifications):
			echo ($notifications->read == 0) ? '<li class="unread">' : '<li class="read">';
			?>
			<img src="<?php echo get_user_profile_image($notifications->user_id);?>" class="avatar" alt="Avatar">
			<div class="message_date">
				<h3 class="date text-info">
					<?php echo date('d',strtotime($notifications->date));?>
				</h3>
				<p class="month">
					<?php echo date('M',strtotime($notifications->date));?>
				</p>
			</div>
			<div class="message_wrapper">
				<h4 class="heading">
					<?php _e($notifications->title);?>
					<small>
						<?php echo date('M d, Y h:i a',strtotime($notifications->date));?>
					</small>
				</h4>
				<blockquote class="message">
					<?php _e(htmlspecialchars_decode($notifications->notification));?>
				</blockquote>
				<br/>
				<?php
				if($notifications->read == 0): ?>
				<button class="btn btn-xs btn-dark read-notification" data-id="<?php echo $notifications->ID;?>" data-type="single">
					<i class="fa fa-check">
					</i>&nbsp;Mark as read
				</button>
				<?php endif; ?>
				<button class="btn btn-xs btn-dark hide-notification" data-id="<?php echo $notifications->ID;?>" data-type="single">
					<i class="fa fa-dot-circle-o">
					</i>&nbsp;Hide Notification
				</button>
			</div>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php
		if($total_results > $per_page): ?>
		<ul class="pagination pagination-split">
			<?php echo paginate($paginate_url,$show_page, $total_pages); ?>
		</ul>
		<?php endif;
		else:
		echo page_not_found("Oops! There is no New Notifications",'  ',false);
		endif;
		$content = ob_get_clean();
		return $content;
	}

	public function notifications__top__bar()
	{
		ob_start();
		$notifications__query = " ORDER BY `ID` DESC LIMIT 0, 5";
		$notifications__args  = array('user_id'=> $this->user__id,'hide'   => 0 ,'read'   => 0);
		$notifications__result = get_tabledata(TBL_NOTIFICATIONS,false,$notifications__args,$notifications__query);
		?>
		<li role="presentation" class="dropdown">
			<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
				<i class="fa fa-envelope-o">
				</i>
				<?php  $notifications__count = get_unread_notification_count();
				if($notifications__count != ''): ?>
				<span class="badge bg-green">
					<?php echo $notifications__count;?>
				</span>
				<?php endif; ?>
			</a>
			<ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
				<?php
				if($notifications__result):
				foreach($notifications__result as $notifications): ?>
				<li>
					<a>
						<span class="image">
							<img src="<?php echo get_user_profile_image($notifications->user_id);?>" alt="Profile Image" />
						</span>
						<span>
							<span>
								You
							</span>
							<span class="time">
								<small>
									<?php echo date('M d, Y h:i a',strtotime($notifications->date));?>
								</small>
							</span>
						</span>
						<span class="message">
							<?php echo strip_tags(stripslashes(htmlspecialchars_decode($notifications->notification)));?>
						</span>
					</a>
				</li>
				<?php endforeach; ?>
				<li>
					<div class="text-center">
						<a href="<?php echo site_url();?>/notifications/">
							<strong>
								See All Notifications
							</strong>
							<i class="fa fa-angle-right">
							</i>
						</a>
					</div>
				</li>
				<?php
				else: ?>
				<li>
					<h5 class="text-uppercase">
						There is no new notifications
					</h5>
				</li>
				<?php endif; ?>
			</ul>
		</li>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function access__logs__page()
	{
		ob_start();
		$access__log__query = "ORDER BY `ID` DESC";
		$access__logs__args = array('user_id'=> $this->user__id);
		$access__logs__result = get_tabledata(TBL_ACCESS_LOG,false,$access__logs__args,$access__log__query);
		?>
		<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap datatable-buttons" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>
						Last Login
					</th>
					<th>
						Location
					</th>
					<th>
						Device
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($access__logs__result):
				foreach($access__logs__result as $access__log):
				?>
				<tr>
					<td>
						<?php echo date('M d, Y h:i A',strtotime($access__log->date));?>
					</td>
					<td>
						<?php echo $access__log->ip_address;?>
					</td>
					<td>
						<a href="#" data-toggle="tooltip" title="<?php echo $access__log->user_agent;?>">
							<?php echo $access__log->device;?>
						</a>
					</td>
				</tr>
				<?php
				endforeach;
				endif;
				?>
			</tbody>
		</table>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function profile__password__change__process()
	{
		extract($_POST);
		$password = set_password($current_password);
		$args     = array('ID'       => $this->user__id,'user_pass'=> $password);
		$check = get_tabledata(TBL_USERS,true,$args);
		if($check):
			$this->user = get_userdata($current_user_id);
			$salt = generateSalt();
			$new_password = hash('SHA256', encrypt($new_password, $salt));
			$salt = base64_encode($salt);
			$this->database->update(TBL_USERS,array('user_pass' => $new_password, 'user_salt' => $salt),array('ID' => $this->user__id));
		update_user_meta($this->user__id,'reset_password',0);

		$notification_args = array(
			'title'       => 'Password Changed',
			'notification'=> 'You have successfully changed your account password.',
		);
		add_user_notification($notification_args);
		return 1;
		else:
		return 0;
		endif;
	}

	
	
	
	
	
	public function update__profile__process()
	{
		extract($_POST);
		
		$return = array(
			'status'         => 0,
			'message_heading'=> 'Failed !',
			'message'        => 'Could not update profile details, Please try again.',
			'reset_form'     => 0
		);

		$check = false;
		if(is_value_exists(TBL_USERS,array('user_email' => $user_email),$this->user__id))
		{
			
			$return['status'] = 2;
			$return['message_heading'] = 'Email Already Exist';
			$return['message'] = 'Email address you entered is already exists, please try another email address.';
			$return['fields'] = array('user_email');
		}
		else
		{
			if(1!=0)
			{
				$check = true;
			}
			else
			{
				$result = $this->database->update(TBL_USERS,
					array(
						'first_name'=> $first_name,
						'last_name' => $last_name,
					),
					array('ID'=> $this->user__id)
				);

				$check = ($result) ? true : false;
			}

			if($check):
			update_user_meta($this->user__id,'gender',$gender);
			update_user_meta($this->user__id,'dob',date('Y-m-d h:i:s',strtotime($dob) ) );
			update_user_meta($this->user__id,'user_phone',$user_phone);
			update_user_meta($this->user__id,'profile_img',$profile_img);
			$notification_args = array(
				'title'       => 'Account Details updated',
				'notification'=> 'You have successfully update your account details.',
			);
			add_user_notification($notification_args);
			$return['status'] = 1;
			$return['message_heading'] = 'Success !';
			$return['message'] = 'Profile details has been successfully updated.';
			endif;
		}

		return json_encode($return);
	}

	public function read__notification__process()
	{
		extract($_POST);
		$update_args = array('read'=> 1);
		$where_args = ($type == 'all') ? array('user_id'=> $this->user__id) : array('ID'     => $id,'user_id'=> $this->user__id);
		$result = $this->database->update(TBL_NOTIFICATIONS,$update_args,$where_args);
		return ($result) ? 1 : 0 ;
	}

	public function hide__notification__process()
	{
		extract($_POST);
		$update_args = array('read'=> 1,'hide'=> 1);
		$where_args = ($type == 'all') ? array('user_id'=> $this->user__id) : array('ID'     => $id,'user_id'=> $this->user__id);
		$result = $this->database->update(TBL_NOTIFICATIONS,$update_args,$where_args);
		return ($result) ? 1 : 0 ;
	}
}
endif;
?>
