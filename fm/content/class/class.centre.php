<?php
// if accessed directly than exit
if(!defined('ABSPATH')) exit;

if( !class_exists('Centre') ):
class Centre{
	private $database;
	function __construct(){
		global $db;
		$this->database = $db;
	}

	public function add__centre__page(){
		ob_start();
		if( !user_can( 'add_centre') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		else:
		?>
		<form class="add-centre submit-form" method="post" autocomplete="off">
			<div class="form-group">
				<label for="screening-centre">
					Screening Centre
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="name" class="form-control require" />
			</div>
			<div class="form-group">
				<label for="programme">
					Programme
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="programme" class="form-control require" />
			</div>
			<div class="form-group">
				<label for="region">
					Region
					<span class="required">
						*
					</span>
				</label>
				<select name="region" class="form-control select_single require" tabindex="-1" data-placeholder="Choose region">
					<?php
					$data = get_tabledata(TBL_REGIONS,false,array('approved'=> '1'));
					$option_data = get_option_data($data,array('ID','name'));
					echo get_options_list($option_data);
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="centre-code">
					Centre Code
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="centre_code" class="form-control require"/>
			</div>
			<div class="form-group">
				<label for="centre-code">
					Address Line 1
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="ad1" class="form-control require" />
			</div>
			<div class="form-group">
				<label for="centre-code">
					Address Line 2
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="ad2" class="form-control require" />
			</div>
			<div class="form-group">
				<label for="centre-code">
					Address Line 3
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="ad3" class="form-control require" />
			</div>
			<div class="form-group">
				<label for="centre-code">
					Address Line 4
				</label>
				<input type="text" name="ad4" class="form-control require" />
			</div>
			<div class="form-group">
				<label for="centre-code">
					Postcode
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="postcode" class="form-control require"/>
			</div>
			<div class="form-group">
				<label for="centre-code">
					Telephone
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="phone" class="form-control require" />
			</div>
			<div class="form-group">
				<label for="centre-code">
					Fax
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="fax" class="form-control require" />
			</div>
			<div class="form-group">
				<label for="centre-code">
					Support Radiologist
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="suppRad" class="form-control require" />
			</div>
			<div class="form-group">
				<label for="centre-code">
					Support Radiologist email
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="suppRadE" class="form-control require" />
			</div>
			<div class="form-group">
				<label for="centre-code">
					Programme Manager
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="proMan" class="form-control require" />
			</div>
			
						<div class="form-group">
				<label for="centre-code">
					Programme Manager Email
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="proManE" class="form-control require" />
			</div>
			<div class="ln_solid">
			</div>
			<div class="form-group">
				<input type="hidden" name="action" value="add_new_centre" />
				<button class="btn btn-success btn-md" type="submit">
					Create New Centre
				</button>
			</div>
		</form>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function edit__centre__page(){
		ob_start();
		$centre__id = $_GET['id'];
			$centre = get_tabledata(TBL_CENTRES,true,array('ID'=> $centre__id));
		if( !user_can( 'edit_centre') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$centre):
			echo page_not_found('Oops ! Centre Details Not Found.','Please go back and check again !');
		else:
		?>
		<form class="edit-centre submit-form" method="post" autocomplete="off">
			<div class="form-group">
				<label for="screening-centre">
					Screening Centre
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="name" class="form-control require" value="<?php _e($centre->name);?>" />
			</div>
			<div class="form-group">
				<label for="programme">
					Programme
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="programme" class="form-control require" value="<?php _e($centre->programme);?>" />
			</div>
			<div class="form-group">
				<label for="region">
					Region
					<span class="required">
						*
					</span>
				</label>
				<select name="region" class="form-control select_single require" tabindex="-1" data-placeholder="Choose region">
					<?php
					$data = get_tabledata(TBL_REGIONS,false,array('approved'=> '1'));
					$option_data = get_option_data($data,array('ID','name'));
					echo get_options_list($option_data,maybe_unserialize($centre->region));
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="centre-code">
					Centre Code
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="centre_code" class="form-control require" value="<?php _e($centre->centre_code);?>" />
			</div>
			<div class="form-group">
				<label for="centre-code">
					Address Line 1
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="ad1" class="form-control require" value="<?php _e($centre->ad1);?>" />
			</div>
			<div class="form-group">
				<label for="centre-code">
					Address Line 2
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="ad2" class="form-control require" value="<?php _e($centre->ad2);?>" />
			</div>
			<div class="form-group">
				<label for="centre-code">
					Address Line 3
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="ad3" class="form-control require" value="<?php _e($centre->ad3);?>" />
			</div>
			<div class="form-group">
				<label for="centre-code">
					Address Line 4
				</label>
				<input type="text" name="ad4" class="form-control require" value="<?php _e($centre->ad4);?>" />
			</div>
			<div class="form-group">
				<label for="centre-code">
					Postcode
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="postcode" class="form-control require" value="<?php _e($centre->postcode);?>" />
			</div>
			<div class="form-group">
				<label for="centre-code">
					Telephone
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="phone" class="form-control require" value="<?php _e($centre->phone);?>" />
			</div>
			<div class="form-group">
				<label for="centre-code">
					Fax
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="fax" class="form-control require" value="<?php _e($centre->fax);?>" />
			</div>
			<div class="form-group">
				<label for="centre-code">
					Support Radiologist
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="suppRad" class="form-control require" value="<?php _e($centre->support_Rad);?>" />
			</div>
			<div class="form-group">
				<label for="centre-code">
					Support Radiologist email
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="suppRadE" class="form-control require" value="<?php _e($centre->support_Rad_email);?>" />
			</div>
			<div class="form-group">
				<label for="centre-code">
					Programme Manager
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="proMan" class="form-control require" value="<?php _e($centre->programme_manag);?>" />
			</div>
			<div class="form-group">
				<label for="centre-code">
					Programme Manager Email
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="proManE" class="form-control require" value = "<?php _e($centre->programme_manage_e);?>" />
			</div>
			<div class="ln_solid">
			</div>
			<div class="form-group">
				<input type="hidden" name="action" value="update_centre" />
				<input type="hidden" name="centre_id" value="<?php echo $centre->ID;?>" />
				<button class="btn btn-success btn-md" type="submit">
					Update Centre
				</button>
			</div>
		</form>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function all__centres__page(){
		ob_start();
		$args = array();
		$centres = get_tabledata(TBL_CENTRES,false,$args);
		if( !user_can('view_centre') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$centres):
			echo page_not_found("Oops! There is no New centres record found",' ',false);
		else:
		?>
		<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap datatable-buttons" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>
						Name
					</th>
					<th>
						Programme
					</th>
					<th>
						Region
					</th>
					<th>
						Centre Code
					</th>
					<th>
						Created On
					</th>
					<?php if(is_admin()): ?>
					<th>
						Approved
					</th>
					<?php endif; ?>
					<th class="text-center">
						Actions
					</th>
				</tr>
			</thead>
			<tbody>
				<?php if($centres): foreach($centres as $centre):
				$region = get_tabledata(TBL_REGIONS,true,array('ID'=>$centre->region));
				?>
				<tr>
					<td>
						<?php _e($centre->name);?>
					</td>
					<td>
						<?php _e($centre->programme);?>
					</td>
					<td>
						<?php _e($region->name);?>
					</td>
					<td>
						<?php _e($centre->centre_code);?>
					</td>
					<td>
						<?php echo date('M d,Y',strtotime($centre->created_on));?>
					</td>
					<?php if(is_admin()): ?>
					<td class="text-center">
						<label>
							<input type="checkbox" class="js-switch" <?php checked($centre->approved, 1);?> onClick="javascript:approve_switch(this);" data-id="<?php echo $centre->ID;?>" data-action="centre_approve_change"/>
						</label>
					</td>
					<?php endif; ?>
					<td class="text-center">
						<?php
						if( user_can('edit_centre') ): ?>
						<a href="<?php echo site_url();?>/edit-centre/?id=<?php echo $centre->ID;?>" class="btn btn-dark btn-xs">
							<i class="fa fa-edit">
							</i>Edit
						</a>
						<?php endif; ?>
						<?php
						if( user_can('delete_centre') ): ?>
						<a href="#" class="btn btn-danger btn-xs" onclick="javascript:delete_function(this);" data-id="<?php echo $centre->ID;?>" data-action="delete_centre">
							<i class="fa fa-trash">
							</i>Delete
						</a>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; endif; ?>
			</tbody>
		</table>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function add__region__page()
	{
		ob_start();
		if( !user_can( 'add_region') ):
		echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		else:
		?>
		<form class="add-region submit-form" method="post" autocomplete="off">
			<div class="form-group">
				<label for="screening-region">
					Name
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="name" class="form-control require" />
			</div>
			<div class="form-group">
				<label for="body">
					Body
					<span class="required">
						*
					</span>
				</label>
				<select name="body" class="form-control select_single require" tabindex="-1" data-placeholder="Choose body">
					<?php
					$data = get_tabledata(TBL_REGION_BODY,false,array('approved'=> '1'));
					$option_data = get_option_data($data,array('ID','name'));
					echo get_options_list($option_data);
					?>
				</select>
			</div>
			<div class="ln_solid">
			</div>
			<div class="form-group">
				<input type="hidden" name="action" value="add_new_region" />
				<button class="btn btn-success btn-md" type="submit">
					Create New Region
				</button>
			</div>
		</form>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function edit__region__page()
	{
		ob_start();
		$region__id = $_GET['id'];
		$region = get_tabledata(TBL_REGIONS,true,array('ID'=> $region__id));
		if( !user_can( 'edit_region') ):
		echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$region):
		echo page_not_found('Oops ! Region Details Not Found.','Please go back and check again !');
		else:
		?>
		<form class="edit-region submit-form" method="post" autocomplete="off">
			<div class="form-group">
				<label for="screening-region">
					Name
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="name" class="form-control require" value="<?php _e($region->name);?>" />
			</div>
			<div class="form-group">
				<label for="body">
					Body
					<span class="required">
						*
					</span>
				</label>
				<select name="body" class="form-control select_single require" tabindex="-1" data-placeholder="Choose body">
					<?php
					$data = get_tabledata(TBL_REGION_BODY,false,array('approved'=> '1'));
					$option_data = get_option_data($data,array('ID','name'));
					echo get_options_list($option_data,maybe_unserialize($region->body));
					?>
				</select>
			</div>
			<div class="ln_solid">
			</div>
			<div class="form-group">
				<input type="hidden" name="action" value="update_region" />
				<input type="hidden" name="region_id" value="<?php echo $region->ID;?>" />
				<button class="btn btn-success btn-md" type="submit">
					Update Region
				</button>
			</div>
		</form>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function all__regions__page()
	{
		ob_start();
		$args = array();
		$regions = get_tabledata(TBL_REGIONS,false,$args);

		if( !user_can('view_region') ):
		echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$regions):
		echo page_not_found("Oops! There is no New regions record found",' ',false);
		else:
		?>
		<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap datatable-buttons" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>
						Name
					</th>
					<th>
						Body
					</th>
					<th>
						Created On
					</th>
					<?php if(is_admin()): ?>
					<th>
						Approved
					</th>
					<?php endif; ?>
					<th class="text-center">
						Actions
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($regions):
				foreach($regions as $region):
				$body = get_tabledata(TBL_REGION_BODY,true,array('ID'=> $region->body));
				?>
				<tr>
					<td>
						<?php _e($region->name);?>
					</td>
					<td>
						<?php _e($body->name);?>
					</td>
					<td>
						<?php echo date('M d,Y',strtotime($region->created_on));?>
					</td>
					<?php if(is_admin()): ?>
					<td class="text-center">
						<label>
							<input type="checkbox" class="js-switch" <?php checked($region->approved, 1);?> onClick="javascript:approve_switch(this);" data-id="
							<?php echo $region->ID;?>" data-action="region_approve_change"/>
						</label>
					</td>
					<?php endif; ?>
					<td class="text-center">
						<?php
						if( user_can('edit_region') ): ?>
						<a href="<?php echo site_url();?>/edit-region/?id=<?php echo $region->ID;?>" class="btn btn-dark btn-xs">
							<i class="fa fa-edit">
							</i>Edit
						</a>
						<?php endif; ?>
						<?php
						if( user_can('delete_region') ): ?>
						<a href="#" class="btn btn-danger btn-xs" onclick="javascript:delete_function(this);" data-id="<?php echo $region->ID;?>" data-action="delete_region">
							<i class="fa fa-trash">
							</i>Delete
						</a>
						<?php endif; ?>
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

	public function add__region__body__page()
	{
		ob_start();
		if( !user_can( 'add_region_body') ):
		echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		else:
		?>
		<form class="add-region-body submit-form" method="post" autocomplete="off">
			<div class="form-group">
				<label for="screening-region_body">
					Name
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="name" class="form-control require" />
			</div>
			<div class="ln_solid">
			</div>
			<div class="form-group">
				<input type="hidden" name="action" value="add_new_region_body" />
				<button class="btn btn-success btn-md" type="submit">
					Create New Region Body
				</button>
			</div>
		</form>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function edit__region__body__page()
	{
		ob_start();
		$region__body__id = $_GET['id'];
		$region__body = get_tabledata(TBL_REGION_BODY,true,array('ID'=> $region__body__id));
		if( !user_can( 'edit_region_body') ):
		echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$region__body):
		echo page_not_found('Oops ! Region Body Details Not Found.','Please go back and check again !');
		else:
		?>
		<form class="edit-region_body submit-form" method="post" autocomplete="off">
			<div class="form-group">
				<label for="screening-region_body">
					Name
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="name" class="form-control require" value="<?php _e($region__body->name);?>" />
			</div>
			<div class="ln_solid">
			</div>
			<div class="form-group">
				<input type="hidden" name="action" value="update_region_body" />
				<input type="hidden" name="region_body_id" value="<?php echo $region__body->ID;?>" />
				<button class="btn btn-success btn-md" type="submit">
					Update Region Body
				</button>
			</div>
		</form>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function all__region__body__page()
	{
		ob_start();
		$args = array();
		$region__body = get_tabledata(TBL_REGION_BODY,false,$args);

		if( !user_can('view_region_body') ):
		echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$region__body):
		echo page_not_found("Oops! There is no New region_bodys record found",' ',false);
		else:
		?>
		<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap datatable-buttons" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>
						Name
					</th>
					<th>
						Created On
					</th>
					<?php if(is_admin()): ?>
					<th>
						Approved
					</th>
					<?php endif; ?>
					<th class="text-center">
						Actions
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($region__body):
				foreach($region__body as $region_body):?>
				<tr>
					<td>
						<?php _e($region_body->name);?>
					</td>
					<td>
						<?php echo date('M d,Y',strtotime($region_body->created_on));?>
					</td>
					<?php if(is_admin()): ?>
					<td class="text-center">
						<label>
							<input type="checkbox" class="js-switch" <?php checked($region_body->approved, 1);?> onClick="javascript:approve_switch(this);" data-id="
							<?php echo $region_body->ID;?>" data-action="region_body_approve_change"/>
						</label>
					</td>
					<?php endif; ?>
					<td class="text-center">
						<?php
						if( user_can('edit_region_body') ): ?>
						<a href="<?php echo site_url();?>/edit-region-body/?id=<?php echo $region_body->ID;?>" class="btn btn-dark btn-xs">
							<i class="fa fa-edit">
							</i>Edit
						</a>
						<?php endif; ?>
						<?php
						if( user_can('delete_region_body') ): ?>
						<a href="#" class="btn btn-danger btn-xs" onclick="javascript:delete_function(this);" data-id="<?php echo $region_body->ID;?>" data-action="delete_region_body">
							<i class="fa fa-trash">
							</i>Delete
						</a>
						<?php endif; ?>
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
	public function add__centre__process()
	{
		extract($_POST);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not create centre, Please try again.',
			'reset_form' => 0
		);
		if( user_can('add_centre') ):
		$validation_args = array(
			'name'=> $name,
		);

		if(is_value_exists(TBL_CENTRES,$validation_args)):
		$return['status'] = 2;
		$return['message_heading'] = 'Failed !';
		$return['message'] = 'Centre name you entered is already exists, please try another name.';
		$return['fields'] = array('name');
		else:
		$guid = get_guid(TBL_CENTRES);
		$result = $this->database->insert(TBL_CENTRES,
			array(
				'ID' => $guid,
				'name' => $name,
				'programme' => $programme,
				'region' => $region,
				'centre_code' => $centre_code,
				'approved' => 1,
				'ad1' => $ad1,
				'ad2' =>$ad2,
				'ad3' => $ad3,
				'ad4' => $ad4,
				'postcode' => $postcode,
				'phone' => $phone,
				'fax' => $fax,
				'support_Rad' => $suppRad,
				'support_Rad_email'=> $suppRadE,
				'programme_manag' => $proMan,
				'programme_manage_e' => $proManE,

			)
		);
		if($result):
		$notification_args = array(
			'title' => 'New centre created',
			'notification'=> 'You have successfully created a new centre ('.$name.').',
		);

		add_user_notification($notification_args);
		$return['status'] = 1;
		$return['message_heading'] = 'Success !';
		$return['message'] = 'Centre has been created successfully.';
		$return['reset_form'] = 1;
		endif;
		endif;
		endif;

		return json_encode($return);
	}

	public function update__centre__process(){
		extract($_POST);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not update centre, Please try again.',
			'reset_form' => 0
		);
		if( user_can('edit_centre') ):
		$validation_args = array(
			'name'=> $name,
		);

		if(is_value_exists(TBL_CENTRES,$validation_args,$centre_id)):
		$return['status'] = 2;
		$return['message_heading'] = 'Failed !';
		$return['message'] = 'Centre name you entered is already exists, please try another name.';
		$return['fields'] = array('name');
		else:
		$result = $this->database->update(TBL_CENTRES,
			array(
				'name' => $name,
				'programme' => $programme,
				'region' => $region,
				'centre_code' => $centre_code,
				'approved' => 1,
				'ad1' => $ad1,
				'ad2' =>$ad2,
				'ad3' => $ad3,
				'ad4' => $ad4,
				'postcode' => $postcode,
				'phone' => $phone,
				'fax' => $fax,
				'support_Rad' => $suppRad,
				'support_Rad_email'=> $suppRadE,
				'programme_manag' => $proMan,
				'programme_manage_e' => $proManE,
			),
			array(
				'ID'=> $centre_id
			)
		);

		if($result):
		$notification_args = array(
			'title' => 'Centre updated',
			'notification'=> 'You have successfully updated centre ('.$name.').',
		);

		add_user_notification($notification_args);
		$return['status'] = 1;
		$return['message_heading'] = 'Success !';
		$return['message'] = 'Centre has been updated successfully.';
		endif;
		endif;
		endif;

		return json_encode($return);
	}

	public function delete__centre__process()
	{
		extract($_POST);
		$id = trim($id);
		if( user_can('delete_centre') ):
		$data = get_tabledata(TBL_CENTRES,true,array('ID'=> $id) ) ;
		$args = array('ID'=> $id);
		$result = $this->database->delete(TBL_CENTRES,$args);
		if($result):
		$notification_args = array(
			'title' => 'Centre deleted',
			'notification'=> 'You have successfully deleted ('.$data->name.') centre.',
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

	public function add__region__process()
	{
		extract($_POST);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not create region, Please try again.',
			'reset_form' => 0
		);
		if( user_can('add_region') ):
		$validation_args = array(
			'name'=> $name,
		);

		if(is_value_exists(TBL_REGIONS,$validation_args)):
		$return['status'] = 2;
		$return['message_heading'] = 'Failed !';
		$return['message'] = 'Region name you entered is already exists, please try another name.';
		$return['fields'] = array('name');
		else:
		$guid = get_guid(TBL_REGIONS);
		$result = $this->database->insert(TBL_REGIONS,
			array(
				'ID' => $guid,
				'name' => $name,
				'body' => $body,
				'approved'=> 1,
			)
		);
		if($result):
		$notification_args = array(
			'title' => 'New region created',
			'notification'=> 'You have successfully created a new region ('.$name.').',
		);

		add_user_notification($notification_args);
		$return['status'] = 1;
		$return['message_heading'] = 'Success !';
		$return['message'] = 'Region has been created successfully.';
		$return['reset_form'] = 1;
		endif;
		endif;
		endif;

		return json_encode($return);
	}

	public function update__region__process()
	{
		extract($_POST);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not update region, Please try again.',
			'reset_form' => 0
		);
		if( user_can('edit_region') ):
		$validation_args = array(
			'name'=> $name,
		);

		if(is_value_exists(TBL_REGIONS,$validation_args,$region_id)):
		$return['status'] = 2;
		$return['message_heading'] = 'Failed !';
		$return['message'] = 'Region name you entered is already exists, please try another name.';
		$return['fields'] = array('name');
		else:
		$result = $this->database->update(TBL_REGIONS,
			array(
				'name'=> $name,
				'body'=> $body
			),
			array(
				'ID'=> $region_id
			)
		);

		if($result):
		$notification_args = array(
			'title' => 'Region updated',
			'notification'=> 'You have successfully updated region ('.$name.').',
		);

		add_user_notification($notification_args);
		$return['status'] = 1;
		$return['message_heading'] = 'Success !';
		$return['message'] = 'Region has been updated successfully.';
		endif;
		endif;
		endif;

		return json_encode($return);
	}

	public function delete__region__process()
	{
		extract($_POST);
		$id = trim($id);
		if( user_can('delete_region') ):
		$data = get_tabledata(TBL_REGIONS,true,array('ID'=> $id) ) ;
		$args = array('ID'=> $id);
		$result = $this->database->delete(TBL_REGIONS,$args);
		if($result):
		$notification_args = array(
			'title' => 'Region deleted',
			'notification'=> 'You have successfully deleted ('.$data->name.') region.',
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

	public function add__region__body__process()
	{
		extract($_POST);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not create region body, Please try again.',
			'reset_form' => 0
		);
		if( user_can('add_region_body') ):
		$validation_args = array(
			'name'=> $name,
		);

		if(is_value_exists(TBL_REGION_BODY,$validation_args)):
		$return['status'] = 2;
		$return['message_heading'] = 'Failed !';
		$return['message'] = 'Region Body name you entered is already exists, please try another name.';
		$return['fields'] = array('name');
		else:
		$guid = get_guid(TBL_REGION_BODY);
		$result = $this->database->insert(TBL_REGION_BODY,
			array(
				'ID' => $guid,
				'name' => $name,
				'approved'=> 1,
			)
		);
		if($result):
		$notification_args = array(
			'title' => 'New region body created ',
			'notification'=> 'You have successfully created a new region body ('.$name.').',
		);

		add_user_notification($notification_args);
		$return['status'] = 1;
		$return['message_heading'] = 'Success !';
		$return['message'] = 'Region Body has been created successfully.';
		$return['reset_form'] = 1;
		endif;
		endif;
		endif;

		return json_encode($return);
	}

	public function update__region__body__process()
	{
		extract($_POST);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not update region body, Please try again.',
			'reset_form' => 0
		);
		if( user_can('edit_region_body') ):
		$validation_args = array(
			'name'=> $name,
		);

		if(is_value_exists(TBL_REGION_BODY,$validation_args,$region_body_id)):
		$return['status'] = 2;
		$return['message_heading'] = 'Failed !';
		$return['message'] = 'Region Body name you entered is already exists, please try another name.';
		$return['fields'] = array('name');
		else:
		$result = $this->database->update(TBL_REGION_BODY,
			array(
				'name'=> $name,
			),
			array(
				'ID'=> $region_body_id
			)
		);

		if($result):
		$notification_args = array(
			'title' => 'Region body updated',
			'notification'=> 'You have successfully updated region body ('.$name.').',
		);

		add_user_notification($notification_args);
		$return['status'] = 1;
		$return['message_heading'] = 'Success !';
		$return['message'] = 'Region body has been updated successfully.';
		endif;
		endif;
		endif;

		return json_encode($return);
	}

	public function delete__region_body__process()
	{
		extract($_POST);
		$id = trim($id);
		if( user_can('delete_region_body') ):
		$data = get_tabledata(TBL_REGION_BODY,true,array('ID'=> $id) ) ;
		$args = array('ID'=> $id);
		$result = $this->database->delete(TBL_REGION_BODY,$args);
		if($result):
		$notification_args = array(
			'title' => 'Region body deleted',
			'notification'=> 'You have successfully deleted ('.$data->name.') region body.',
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

	public function centre__approve__change__process()
	{
		extract($_POST);
		$id = trim($id);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not update centre details, Please try again ',
			'reset_form' => 0
		);
		if(user_can('edit_centre')):
		$centre = get_tabledata(TBL_CENTRES, true, array('ID'=> $id) );
		$args = array('ID'=> $id);
		$result = $this->database->update(TBL_CENTRES,array('approved'=> $status),$args);

		if($result):
		if($status == 0)
		{
			$notification_args = array(
				'title' => 'Centre (' .$centre->name.') is disables now',
				'notification'=> 'You have successfully disabled (' .$centre->name.') centre.',
			);
			$return['message'] = 'You have successfully disabled (' .$centre->name.') centre.';
		}
		else
		{
			$notification_args = array(
				'title' => 'Centre (' .$centre->name.') is approved now',
				'notification'=> 'You have successfully approved (' .$centre->name.') centre.',
			);
			$return['message'] = 'You have successfully approved (' .$centre->name.') centre.';
		}
		add_user_notification($notification_args);
		$return['status'] = 1;
		$return['message_heading'] = 'Success !';
		endif;
		endif;
		return json_encode($return);
	}

	public function region__approve__change__process()
	{
		extract($_POST);
		$id = trim($id);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not update region details, Please try again ',
			'reset_form' => 0
		);
		if(user_can('edit_region')):
		$region = get_tabledata(TBL_REGIONS, true, array('ID'=> $id) );
		$args = array('ID'=> $id);
		$result = $this->database->update(TBL_REGIONS,array('approved'=> $status),$args);

		if($result):
		if($status == 0)
		{
			$notification_args = array(
				'title' => 'Region (' .$region->name.') is disabled now',
				'notification'=> 'You have successfully disabled (' .$region->name.') region.',
			);
			$return['message'] = 'You have successfully disabled (' .$region->name.') region.';
		}
		else
		{
			$notification_args = array(
				'title' => 'Region (' .$region->name.') is approved now',
				'notification'=> 'You have successfully approved (' .$region->name.') region.',
			);
			$return['message'] = 'You have successfully approved (' .$region->name.') region.';
		}
		add_user_notification($notification_args);
		$return['status'] = 1;
		$return['message_heading'] = 'Success !';
		endif;
		endif;
		return json_encode($return);
	}

	public function region__body__approve__change__process()
	{
		extract($_POST);
		$id = trim($id);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not update region body details, Please try again ',
			'reset_form' => 0
		);
		if(user_can('edit_region_body')):
		$region_body = get_tabledata(TBL_REGION_BODY, true, array('ID'=> $id) );
		$args = array('ID'=> $id);
		$result = $this->database->update(TBL_REGION_BODY,array('approved'=> $status),$args);

		if($result):
		if($status == 0)
		{
			$notification_args = array(
				'title' => 'Region body(' .$region_body->name.') is disabled now',
				'notification'=> 'You have successfully disabled (' .$region_body->name.') region body.',
			);
			$return['message'] = 'You have successfully disabled (' .$region_body->name.') region body.';
		}
		else
		{
			$notification_args = array(
				'title' => 'Region body (' .$region_body->name.') is approved now',
				'notification'=> 'You have successfully approved (' .$region_body->name.') region body.',
			);
			$return['message'] = 'You have successfully approved (' .$region_body->name.') region body.';
		}
		add_user_notification($notification_args);
		$return['status'] = 1;
		$return['message_heading'] = 'Success !';
		endif;
		endif;
		return json_encode($return);
	}
}
endif;
?>