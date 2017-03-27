<?php
// if accessed directly than exit
if(!defined('ABSPATH')) exit;

if( !class_exists('Equipment') ):
class Equipment{
	private $database;
	private $current__user__id;
	private $current__user;
	function __construct(){
		global $db;
		$this->database = $db;
		$this->current__user__id = get_current_user_id();
		$this->current__user = get_userdata($this->current__user__id);
	}

	public function all__equipments__page(){
		ob_start();
		$query = '';
		if(!is_admin()):
			$centres = maybe_unserialize($this->current__user->centre);
			if(!empty($centres)){
				$centres = implode(',',$centres);
				$query = "WHERE `centre` IN (".$centres.")";
			}
		endif;
		$equipments__list = get_tabledata(TBL_EQUIPMENTS,false,array(), $query);
		if( !user_can( 'view_equipment') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$equipments__list):
			echo page_not_found("THERE ARE NO  record found for Equipments",' ',false);
		else:
		?>
<div class="row custom-filters">
				<div class="form-group col-sm-3 col-xs-12">
					<label for="centre">Centre</label>
					<select name="centre" class="form-control select_single" tabindex="-1" data-placeholder="Choose centre">
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
				<div class="form-group col-sm-3 col-xs-12">
					<label for="equipment-type">Equipment Type</label>
					<select name="equipment_type" class="form-control select_single" tabindex="-1" data-placeholder="Choose equipment type">
						<?php
						$data = get_tabledata(TBL_EQUIPMENT_TYPES,false,array('approved'=> '1'), 'ORDER BY `name` ASC');
						$option_data = get_option_data($data,array('ID','name'));
						echo get_options_list($option_data);
						?>
					</select>
				</div>
				<div class="form-group col-sm-3 col-xs-12">
					<label for="manufacturer">Manufacturer</label>
					<select name="manufacturer" class="form-control select_single" tabindex="-1" data-placeholder="Choose manufacturer">
						<?php
						$data = get_tabledata(TBL_MANUFACTURERS,false,array('approved'=> '1'), 'ORDER BY `name` ASC');
						$option_data = get_option_data($data,array('ID','name'));
						echo get_options_list($option_data);
						?>
					</select>
				</div>
				<div class="form-group col-sm-3 col-xs-12">
					<label for="model">Model</label>
					<select name="model" class="form-control select_single" tabindex="-1" data-placeholder="Choose model">
						<?php
						$data = get_tabledata(TBL_MODELS,false,array('approved'=> '1'), 'ORDER BY `name` ASC');
						$option_data = get_option_data($data,array('ID','name'));
						echo get_options_list($option_data);
						?>
					</select>
				</div>
			</div>
<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap ajax-datatable-buttons" cellspacing="0" width="100%" data-table="fetch_all_equipments" data-order-column="7">
			<thead>
				<tr>
					<th>Name</th>
					<th>Centre</th>
					<th>Equipment Code</th>
					<th>Equipment Type</th>
					<th>Model</th>
					<th>Manufacturer</th>
					<th>Service Agent</th>
					<th>Created On</th>
					<?php if(is_admin()): ?>
					<th>Approved</th>
					<?php endif; ?>
					<th class="text-center">Actions</th>
				</tr>
			</thead>
		</table>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
		public function all__equipments__page__off(){
		ob_start();
		$query = '';
		if(!is_admin()):
			$centres = maybe_unserialize($this->current__user->centre);
			if(!empty($centres)){
				$centres = implode(',',$centres);
				$query = "WHERE `centre` IN (".$centres.")";
			}
		endif;
		$equipments__list = get_tabledata(TBL_EQUIPMENTS,false,array('approved'=>'0'), $query);
		if( !user_can( 'view_equipment') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$equipments__list):
			echo page_not_found("There are no equipments to authorise",' ',false);
		else:
		?>
<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap ajax-datatable-buttons" cellspacing="0" width="100%" data-table="fetch_all_equipments2" data-order-column="7">
			<thead>
				<tr>
					<th>Name</th>
					<th>Centre</th>
					<th>Equipment Code</th>
					<th>Equipment Type</th>
					<th>Model</th>
					<th>Manufacturer</th>
					<th>Service Agent</th>
					<th>Created On</th>
					<?php if(is_admin()): ?>
					<th>Approved</th>
					<?php endif; ?>
					<th class="text-center">Actions</th>
				</tr>
			</thead>
		</table>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}
	
	

	public function add__equipment__page(){
		ob_start();
		if( !user_can( 'add_equipment') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		else:
		?>
		<form class="add-equipment submit-form" method="post" autocomplete="off">
			<div class="row">

				<div class="form-group col-sm-6 col-xs-12">
					<label for="centre">
						Centre
						<span class="required">
							*
						</span>
					</label>
					<select name="centre" class="form-control select_single require" tabindex="-1" data-placeholder="Choose centre">
						<?php
						$query = '';
						if(!is_admin()):
						$centres = maybe_unserialize($this->current__user->centre);
						if(!empty($centres))
						{
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
				
				<div class="form-group col-sm-6 col-xs-12">
					<label for="equipment-type">
						Equipment Type
						<span class="required">
							*
						</span>
					</label>
					<select name="equipment_type" class="form-control select_single require select-equipment-type fetch-equipment-type-data" tabindex="-1" data-placeholder="Choose equipment type">
						<?php
						$data = get_tabledata(TBL_EQUIPMENT_TYPES,false,array('approved'=> '1'), 'ORDER BY `name` ASC');
						$option_data = get_option_data($data,array('ID','name'));
						echo get_options_list($option_data);
						?>
					</select>
				</div>
			</div>

			

			<div class="row">
				<div class="form-group col-sm-6 col-xs-12">
					<label for="manufacturer">
						Manufacturer
						<span class="required">
							*
						</span>
					</label>
					<select name="manufacturer" class="form-control select_manufacturer select_single fetch-manufacturer-data require" tabindex="-1" data-placeholder="Choose manufacturer">
						<option value="">
							Choose manufacturer
						</option>
					</select>
				</div>
				<div class="form-group col-sm-6 col-xs-12">
					<label for="model">
						Model
						<span class="required">
							*
						</span>
					</label>
					<select name="model" class="form-control select_model select_single" tabindex="-1" data-placeholder="Choose model">
						<option value="">
							Choose model
						</option>
					</select>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-sm-6 col-xs-12">
					<label for="supplier">
						Supplier
						<span class="required">
							*
						</span>
					</label>
					<select name="supplier" class="form-control select_supplier select_single" tabindex="-1" data-placeholder="Choose supplier">
						<option value="">
							Choose supplier
						</option>
					</select>
				</div>

				<div class="form-group col-sm-6 col-xs-12">
					<label for="service-agent">
						Service Agent
						<span class="required">
							*
						</span>
					</label>
					<select name="service_agent" class="form-control select-service-agent select_single" tabindex="-1" data-placeholder="Choose service agent">
						<option value="">
							Choose service agent
						</option>
					</select>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-sm-6 col-xs-12">
					<label for="location-id">
						Local ID
					</label>
					<input type="text" name="location_id" class="form-control"/>
				</div>

				<div class="form-group col-sm-6 col-xs-12">
					<label for="location">
						Location
					</label>
					<input type="text" name="location" class="form-control"/>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-sm-6 col-xs-12">
					<label for="serial-number">
						Serial Number
					</label>
					<input type="text" name="serial_number" class="form-control"/>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-sm-4 col-xs-12">
					<label for="year-manufacturered">
						Year Manufacturered
					</label>
					<input type="number" name="year_manufacturered" class="form-control" min="1000" max="9999"/>
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="year-installed">
						Year Installed
					</label>
					<input type="number" name="year_installed" class="form-control" min="1000" max="9999"/>
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="year-decomissioned">
						Year Decomissioned
					</label>
					<input type="number" name="year_decommisoned" class="form-control" min="1000" max="9999"/>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-sm-12 col-xs-12">
					<label for="comment">Comment
					</label>
					<textarea name="comment" class="form-control" rows="5"></textarea>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-sm-3 col-xs-6" required>
					<label for="decommed">
						Decommed
					</label><br/>
					<label>
						<input type="radio" class="flat" name="decommed" value="1"> Yes
					</label>
					<label>
						&nbsp;
					</label>
					<label>
						<input type="radio" class="flat" name="decommed" value="0"> No
					</label>
				</div>
				<div class="form-group col-sm-3 col-xs-6" required>
					<label for="spare">
						Spare
					</label><br/>
					<label>
						<input type="radio" class="flat" name="spare" value="1"> Yes
					</label>
					<label>
						&nbsp;
					</label>
					<label>
						<input type="radio" class="flat" name="spare" value="0"> No
					</label>
				</div>
				<div class="form-group col-sm-3 col-xs-6" required>
					<label for="x-ray">
						X-ray Subtype Digital
					</label><br/>
					<label>
						<input type="radio" class="flat" name="x_ray" value="1"> Yes
					</label>
					<label>
						&nbsp;
					</label>
					<label>
						<input type="radio" class="flat" name="x_ray" value="0"> No
					</label>
				</div>
				<div class="form-group col-sm-3 col-xs-6">
					<label for="approved">
						Approved
					</label><br/>
					<label>
						<input type="radio" class="flat" name="approved" value="1" required> Yes
					</label>
					<label>
						&nbsp;
					</label>
					<label>
						<input type="radio" class="flat" name="approved" value="0" required> No
					</label>
				</div>
			</div>

			<div class="ln_solid">
			</div>
			<div class="form-group">
				<input type="hidden" name="action" value="add_new_equipment"/>
				<button class="btn btn-success btn-md" type="submit">
					Create New Equipment
				</button>
			</div>
		</form>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function edit__equipment__page(){
		ob_start();
		$equipment__id = $_GET['id'];
		$equipment = get_tabledata(TBL_EQUIPMENTS,true,array('ID'=> $equipment__id));
		if( !user_can( 'edit_equipment') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$equipment):
			echo page_not_found('Oops ! Equipment details not found.','Please go back and check again !');
		else:
		?>
		<form class="edit-equipment submit-form" method="post" autocomplete="off">
			<div class="row">
				<div class="form-group col-sm-6 col-xs-12">
					<label for="centre">
						Centre
						<span class="required">
							*
						</span>
					</label>
					<select name="centre" class="form-control select_single require" tabindex="-1" data-placeholder="Choose centre">
						<?php
						$query = '';
						if(!is_admin()):
						$centres = maybe_unserialize($this->current__user->centre);
						if(!empty($centres))
						{
							$centres = implode(',',$centres);
							$query = "WHERE `ID` IN (".$centres.")";
						}
						endif;
						$query .= ($query != '') ? ' AND ' : ' WHERE ';
						$query .= " `approved` = '1' ORDER BY `name` ASC";
						$data = get_tabledata(TBL_CENTRES,false,array(),$query);
						$option_data = get_option_data($data,array('ID','name'));
						echo get_options_list($option_data, maybe_unserialize($equipment->centre));
						?>
					</select>
					</div>
					<div class="form-group col-sm-6 col-xs-12">
					<label for="equipment-type">
						Equipment Type
						<span class="required">
							*
						</span>
					</label>
					<select name="equipment_type" class="form-control select_single require select-equipment-type fetch-equipment-type-data" tabindex="-1" data-placeholder="Choose equipment type">
						<?php
						$data = get_tabledata(TBL_EQUIPMENT_TYPES,false,array('approved'=> '1'), 'ORDER BY `name` ASC');
						$option_data = get_option_data($data,array('ID','name'));
						echo get_options_list($option_data, maybe_unserialize($equipment->equipment_type));
						?>
					</select>
				</div>
				</div>
			</div>

			<div class="row">
				
			</div>

			<div class="row">
				<div class="form-group col-sm-6 col-xs-12">
					<label for="manufacturer">
						Manufacturer
						<span class="required">
							*
						</span>
					</label>
					<select name="manufacturer" class="form-control select_manufacturer select_single fetch-manufacturer-data require" tabindex="-1" data-placeholder="Choose manufacturer">
						<?php
						$query = "where `equipment_type` LIKE '%".$equipment->equipment_type."%' AND `approved` = '1' ";
						$data = get_tabledata(TBL_MANUFACTURERS, false, array() , $query);
						$option_data = get_option_data($data,array('ID','name'));
						echo get_options_list($option_data, maybe_unserialize($equipment->manufacturer));
						?>
					</select>
				</div>
				<div class="form-group col-sm-6 col-xs-12">
					<label for="model">
						Model
						<span class="required">
							*
						</span>
					</label>
					<select name="model" class="form-control select_model select_single require" tabindex="-1" data-placeholder="Choose model">
						<?php
						$data = get_tabledata(TBL_MODELS, false, array('manufacturer'=> $equipment->manufacturer ,'approved' => '1') );
						$option_data = get_option_data($data,array('ID','name'));
						echo get_options_list($option_data, maybe_unserialize($equipment->model));
						?>
					</select>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-sm-6 col-xs-12">
					<label for="supplier">
						Supplier
						<span class="required">
							*
						</span>
					</label>
					<select name="supplier" class="form-control select_supplier select_single require" tabindex="-1" data-placeholder="Choose supplier">
						<option value="">
							Choose supplier
						</option>

						<?php
						$equipment_type = get_tabledata(TBL_EQUIPMENT_TYPES, true, array('ID'=> $equipment->equipment_type ));
						$suppliers = maybe_unserialize($equipment_type->supplier);
						$suppliers = (!empty($suppliers)) ? implode(',',$suppliers) : '0';
						$query = "where `ID` IN (".$suppliers.") AND `approved` = '1' ";
						$data = get_tabledata(TBL_SUPPLIERS, false, array() , $query);
						$option_data = get_option_data($data,array('ID','name'));
						echo get_options_list($option_data , maybe_unserialize($equipment->supplier));
						?>
					</select>
				</div>
				<div class="form-group col-sm-6 col-xs-12">
					<label for="service-agent">
						Service Agent
						<span class="required">
							*
						</span>
					</label>
					<select name="service_agent" class="form-control select-service-agent select_single require" tabindex="-1" data-placeholder="Choose service agent">
						<?php
						$query = "WHERE `equipment_type` LIKE '%".$equipment->equipment_type."%' AND `approved` = '1' ";
						$data = get_tabledata(TBL_SERVICE_AGENTS, false, array(),$query);
						$option_data = get_option_data($data,array('ID','name'));
						echo get_options_list($option_data , maybe_unserialize($equipment->service_agent));
						?>
					</select>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-sm-6 col-xs-12">
					<label for="location-id">
						Local ID
					</label>
					<input type="text" name="location_id" class="form-control" value="<?php _e($equipment->location_id);?>"/>
				</div>

				<div class="form-group col-sm-6 col-xs-12">
					<label for="location">
						Location
					</label>
					<input type="text" name="location" class="form-control" value="<?php _e($equipment->location);?>"/>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-sm-6 col-xs-12">
					<label for="serial-number">
						Serial Number
					</label>
					<input type="text" name="serial_number" class="form-control" value="<?php _e($equipment->serial_number);?>"/>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-sm-4 col-xs-12">
					<label for="year-manufacturered">
						Year Manufacturered
					</label>
					<input type="number" name="year_manufacturered" class="form-control" min="1000" max="9999" value="<?php _e($equipment->year_manufacturered);?>"/>
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="year-installed">
						Year Installed
					</label>
					<input type="number" name="year_installed" class="form-control" min="1000" max="9999" value="<?php _e($equipment->year_installed);?>"/>
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<label for="year-decommisoned">
						Year Decomissioned
					</label>
					<input type="number" name="year_decommisoned" class="form-control" min="1000" max="9999" value="<?php _e($equipment->year_decommisoned);?>"/>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-sm-12 col-xs-12">
					<label for="comment">
						Comment
					</label>
					<textarea name="comment" class="form-control" rows="5"><?php _e($equipment->comment);?></textarea>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-sm-3 col-xs-6">
					<label for="decommed">
						Decommed
					</label><br/>
					<label>
						<input type="radio" class="flat" name="decommed" value="1" <?php echo ($equipment->decommed == 1) ? 'checked' : ''; ?>> Yes
					</label>
					<label>
						&nbsp;
					</label>
					<label>
						<input type="radio" class="flat" name="decommed" value="0" <?php echo ($equipment->decommed != 1) ? 'checked' : ''; ?>> No
					</label>
				</div>
				<div class="form-group col-sm-3 col-xs-6">
					<label for="spare">
						Spare
					</label><br/>
					<label>
						<input type="radio" class="flat" name="spare" value="1" <?php echo ($equipment->spare == 1) ? 'checked' : ''; ?>> Yes
					</label>
					<label>
						&nbsp;
					</label>
					<label>
						<input type="radio" class="flat" name="spare" value="0" <?php echo ($equipment->spare != 1) ? 'checked' : ''; ?>> No
					</label>
				</div>
				<div class="form-group col-sm-3 col-xs-6">
					<label for="x-ray">
						X-ray Subtype Digital
					</label><br/>
					<label>
						<input type="radio" class="flat" name="x_ray" value="1" <?php echo ($equipment->x_ray == 1) ? 'checked' : ''; ?>> Yes
					</label>
					<label>
						&nbsp;
					</label>
					<label>
						<input type="radio" class="flat" name="x_ray" value="0" <?php echo ($equipment->x_ray != 1) ? 'checked' : ''; ?>> No
					</label>
				</div>
				<div class="form-group col-sm-3 col-xs-6">
					<label for="approved">
						Approved
					</label><br/>
					<label>
						<input type="radio" class="flat" name="approved" value="1" <?php echo ($equipment->approved == 1) ? 'checked' : ''; ?>> Yes
					</label>
					<label>
						&nbsp;
					</label>
					<label>
						<input type="radio" class="flat" name="approved" value="0" <?php echo ($equipment->approved != 1) ? 'checked' : ''; ?>> No
					</label>
				</div>
			</div>

			<div class="ln_solid">
			</div>
			<div class="form-group">
				<input type="hidden" name="equipment_id" value="<?php echo $equipment->ID;?>"/>
				<input type="hidden" name="action" value="update_equipment"/>
				<button class="btn btn-success btn-md" type="submit">
					Update Equipment
				</button>
			</div>
		</form>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function view__equipment__page(){
		ob_start();
		$equipment__id = $_GET['id'];
		$query = '';
		if(!is_admin()):
			$centres = maybe_unserialize($this->current__user->centre);
			if(!empty($centres)){
				$centres = implode(',',$centres);
				$query = "WHERE `centre` IN (".$centres.")";
			}
		endif;
		$query .= ($query != '') ? ' AND ' : ' WHERE ';
		$query .= " `ID` = ".$equipment__id ." ";
		$equipment = get_tabledata(TBL_EQUIPMENTS,true,array(), $query);
		if( !user_can( 'edit_equipment') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$equipment):
			echo page_not_found('Oops ! Equipment details not found.','Please go back and check again !');
		else:
			$centre = get_tabledata(TBL_CENTRES,true, array('ID'=> $equipment->centre));
			$equipment_type = get_tabledata(TBL_EQUIPMENT_TYPES,true, array('ID'=> $equipment->equipment_type));
			$model = get_tabledata(TBL_MODELS, true, array('ID'=> $equipment->model) );
			$manufacturer = get_tabledata(TBL_MANUFACTURERS, true, array('ID'=> $equipment->manufacturer) );
			$service_agent = get_tabledata(TBL_SERVICE_AGENTS, true, array('ID'=> $equipment->service_agent) );
		?>
		<div class="text-center">
			<h3>
				<?php _e('Equipment Details');?>
			</h3>
		</div>
		<table class="table table-striped table-hover table-bordered">
			<thead>
				<tr>
					<td class="text-center">
						<?php _e('Field');?>
					</td>
					<td class="text-center">
						<?php _e('Value');?>
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<?php _e('Name');?>
					</td>
					<td>
						<?php _e($equipment->name);?>
					</td>
				</tr>
				<tr>
					<td>
						<?php _e('Centre');?>
					</td>
					<td>
						<?php _e($centre->name);?>
					</td>
				</tr>
				<tr>
					<td>
						<?php _e('Equipment Code');?>
					</td>
					<td>
						<?php _e($equipment->equipment_code);?>
					</td>
				</tr>
				<tr>
					<td>
						<?php _e('Equipment Type');?>
					</td>
					<td>
						<?php _e($equipment_type->name);?>
					</td>
				</tr>
				<tr>
					<td>
						<?php _e('Model');?>
					</td>
					<td>
						<?php _e($model->name);?>
					</td>
				</tr>
				<tr>
					<td>
						<?php _e('Manufacturer');?>
					</td>
					<td>
						<?php _e($manufacturer->name);?>
					</td>
				</tr>
				<tr>
					<td>
						<?php _e('Service Agent');?>
					</td>
					<td>
						<?php _e($service_agent->name);?>
					</td>
				</tr>
				<tr>
					<td>
						<?php _e('Location ID');?>
					</td>
					<td>
						<?php _e($equipment->location_id);?>
					</td>
				</tr>
				<tr>
					<td>
						<?php _e('Location');?>
					</td>
					<td>
						<?php _e($equipment->location);?>
					</td>
				</tr>
				<tr>
					<td>
						<?php _e('Serial Number');?>
					</td>
					<td>
						<?php _e($equipment->serial_number);?>
					</td>
				</tr>
				<tr>
					<td>
						<?php _e('Year Manufacturered');?>
					</td>
					<td>
						<?php _e($equipment->year_manufacturered);?>
					</td>
				</tr>
				<tr>
					<td>
						<?php _e('Year Installed');?>
					</td>
					<td>
						<?php _e($equipment->year_installed);?>
					</td>
				</tr>
				<tr>
					<td>
						<?php _e('Year Decomissioned');?>
					</td>
					<td>
						<?php _e($equipment->year_decommisoned);?>
					</td>
				</tr>
				<tr>
					<td>
						<?php _e('Comment');?>
					</td>
					<td>
						<?php _e($equipment->comment);?>
					</td>
				</tr>
				<tr>
					<td>
						<?php _e('Decommed');?>
					</td>
					<td>
						<?php echo ($equipment->decommed == 1) ? 'Yes' : 'No'; ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php _e('Spare');?>
					</td>
					<td>
						<?php echo ($equipment->spare == 1) ? 'Yes' : 'No'; ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php _e('X-ray Subtype Digital');?>
					</td>
					<td>
						<?php echo ($equipment->x_ray == 1) ? 'Yes' : 'No'; ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php _e('Approved');?>
					</td>
					<td>
						<?php echo ($equipment->approved == 1) ? 'Yes' : 'No'; ?>
					</td>
				</tr>
			</tbody>
		</table>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function all__equipment__types__page(){
		ob_start();
		$query = '';
		if(!is_admin()):
			$centres = maybe_unserialize($this->current__user->centre);
			if(!empty($centres)){
				$centres = implode(',',$centres);
				$query = "WHERE `centre` IN (".$centres.")";
			}
		endif;
		$equipment__types__list = get_tabledata(TBL_EQUIPMENT_TYPES,false,array(), $query);
		if( !user_can( 'view_equipment_type') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$equipment__types__list):
			echo page_not_found("THERE ARE NO  record found for Equipment Types",' ',false);
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
				<?php if($equipment__types__list): foreach($equipment__types__list as $equipment__type):
				?>
				<tr>
					<td>
						<?php _e($equipment__type->name);?>
					</td>
					<td>
						<?php echo date('M d,Y',strtotime($equipment__type->created_on));?>
					</td>
					<?php if(is_admin()): ?>
					<td class="text-center">
						<label>
							<input type="checkbox" class="js-switch" <?php checked($equipment__type->approved, 1);?> onClick="javascript:approve_switch(this);" data-id="<?php echo $equipment__type->ID;?>" data-action="equipment_type_approve_change"/>
						</label>
					</td>
					<?php endif; ?>
					<td class="text-center">
						<?php if( user_can( 'edit_equipment_type') ): ?>
						<a href="<?php echo site_url();?>/edit-equipment-type/?id=<?php echo $equipment__type->ID;?>" class="btn btn-dark btn-xs">
							<i class="fa fa-edit">
							</i>Edit
						</a>
						<?php endif; ?>
						<?php if( user_can( 'delete_equipment_type') ): ?>
						<a href="#" class="btn btn-danger btn-xs" onclick="javascript:delete_function(this);" data-id="<?php echo $equipment__type->ID;?>" data-action="delete_equipment_type">
							<i class="fa fa-trash">
							</i>Delete
						</a>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; endif;
				?>
			</tbody>
		</table>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function add__equipment__type__page(){
		ob_start();
		if( !user_can( 'add_equipment_type') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		else:
		?>
		<form class="add-equipment-type submit-form" method="post" autocomplete="off">
			<div class="form-group">
				<label for="screening-equipment_type">
					Equipment Type Name
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="name" class="form-control require"/>
			</div>

			<div class="form-group">
				<label for="screening-equipment_type">
					Equipment Type Code
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="code" class="form-control require"/>
			</div>


			<div class="form-group">
				<label for="supplier">
					Suppliers
					<span class="required">
						*
					</span>
				</label>
				<select name="supplier[]" class="form-control select_single require" tabindex="-1" data-placeholder="Choose supplier" multiple="multiple">
					<?php
					$data = get_tabledata(TBL_SUPPLIERS,false,array('approved'=> '1'));
					$option_data = get_option_data($data,array('ID','name'));
					echo get_options_list($option_data);
					?>
				</select>
			</div>
			<div class="ln_solid">
			</div>
			<div class="form-group">
				<input type="hidden" name="action" value="add_new_equipment_type"/>
				<button class="btn btn-success btn-md" type="submit">
					Create New Equipment Type
				</button>
			</div>
		</form>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function edit__equipment__type__page(){
		ob_start();
		$equipment__type__id = $_GET['id'];
		$equipment__type = get_tabledata(TBL_EQUIPMENT_TYPES,true,array('ID'=> $equipment__type__id));
		if( !user_can( 'edit_equipment_type') ):
		echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$equipment__type):
		echo page_not_found('Oops ! Equipment type details not found.','Please go back and check again !');
		else:
		?>
		<form class="edit-equipment-type submit-form" method="post" autocomplete="off">
			<div class="form-group">
				<label for="screening-equipment_type">
					Equipment Type Name
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="name" class="form-control require" value="<?php _e($equipment__type->name);?>"/>
			</div>
			
			<div class="form-group">
				<label for="supplier">
					Suppliers
					<span class="required">
						*
					</span>
				</label>
				<select name="supplier[]" class="form-control select_single require" tabindex="-1" data-placeholder="Choose supplier" multiple="multiple">
					<?php
					$data = get_tabledata(TBL_SUPPLIERS,false,array('approved'=> '1'));
					$option_data = get_option_data($data,array('ID','name'));
					echo get_options_list($option_data,maybe_unserialize($equipment__type->supplier));
					?>
				</select>
			</div>
			<div class="ln_solid">
			</div>
			<div class="form-group">
				<input type="hidden" name="equipment_type_id" value="<?php echo $equipment__type->ID;?>"/>
				<input type="hidden" name="action" value="update_equipment_type"/>
				<button class="btn btn-success btn-md" type="submit">
					Update Equipment Type
				</button>
			</div>
		</form>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function all__service__agents__page(){
		ob_start();
		$service__agents__list = get_tabledata(TBL_SERVICE_AGENTS,false);
		if( !user_can( 'view_service_agent') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$service__agents__list):
			echo page_not_found("THERE ARE NO  record found for Service Agents",' ',false);
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
				if($service__agents__list):
				foreach($service__agents__list as $service__agent):
				?>
				<tr>
					<td>
						<?php _e($service__agent->name);?>
					</td>
					<td>
						<?php echo date('M d,Y',strtotime($service__agent->created_on));?>
					</td>
					<?php if(is_admin()): ?>
					<td class="text-center">
						<label>
							<input type="checkbox" class="js-switch" <?php checked($service__agent->approved, 1);?> onClick="javascript:approve_switch(this);" data-id="<?php echo $service__agent->ID;?>" data-action="service_agent_approve_change"/>
						</label>
					</td>
					<?php endif; ?>
					
					<td class="text-center">
						<?php if( user_can( 'edit_service_agent') ): ?>
						<a href="<?php echo site_url();?>/edit-service-agent/?id=<?php echo $service__agent->ID;?>" class="btn btn-dark btn-xs">
							<i class="fa fa-edit">
							</i>Edit
						</a>
						<?php endif; ?>
						<?php if( user_can( 'delete_service_agent') ): ?>
						<a href="#" class="btn btn-danger btn-xs" onclick="javascript:delete_function(this);" data-id="<?php echo $service__agent->ID;?>" data-action="delete_service_agent">
							<i class="fa fa-trash">
							</i>Delete
						</a>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; endif;
				?>
			</tbody>
		</table>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function add__service__agent__page(){
		ob_start();
		if( !user_can( 'add_service_agent') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		else:
		?>
		<form class="add-service-agent submit-form" method="post" autocomplete="off">
			<div class="form-group">
				<label for="screening-service_agent">
					Service Agent Name
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="name" class="form-control require"/>
			</div>
			<div class="form-group">
				<label for="equipment-type">
					Equipment Type
					<span class="required">
						*
					</span>
				</label>
				<select name="equipment_type[]" class="form-control select_single require" tabindex="-1" data-placeholder="Choose equipment type" multiple="multiple">
					<?php
					$data = get_tabledata(TBL_EQUIPMENT_TYPES,false,array('approved'=> '1'));
					$option_data = get_option_data($data,array('ID','name'));
					echo get_options_list($option_data);
					?>
				</select>
			</div>
			<div class="ln_solid">
			</div>
			<div class="form-group">
				<input type="hidden" name="action" value="add_new_service_agent"/>
				<button class="btn btn-success btn-md" type="submit">
					Create New Service Agent
				</button>
			</div>
		</form>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function edit__service__agent__page(){
		ob_start();
		$service__agent__id = $_GET['id'];
		$service__agent = get_tabledata(TBL_SERVICE_AGENTS,true,array('ID'=> $service__agent__id));
		if( !user_can( 'edit_service_agent') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$service__agent):
			echo page_not_found('Oops ! Equipment type details not found.','Please go back and check again !');
		else:
		?>
		<form class="edit-service-agent submit-form" method="post" autocomplete="off">
			<div class="form-group">
				<label for="screening-service-agent">
					Service Agent Name
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="name" class="form-control require" value="<?php _e($service__agent->name);?>"/>
			</div>
			<div class="form-group">
				<label for="equipment-type">
					Equipment Type
					<span class="required">
						*
					</span>
				</label>
				<select name="equipment_type[]" class="form-control select_single require" tabindex="-1" data-placeholder="Choose equipment type" multiple="multiple">
					<?php
					$data = get_tabledata(TBL_EQUIPMENT_TYPES,false,array('approved'=> '1'));
					$option_data = get_option_data($data,array('ID','name'));
					echo get_options_list($option_data, maybe_unserialize($service__agent->equipment_type));
					?>
				</select>
			</div>
			<div class="ln_solid">
			</div>
			<div class="form-group">
				<input type="hidden" name="service_agent_id" value="<?php echo $service__agent->ID;?>"/>
				<input type="hidden" name="action" value="update_service_agent"/>
				<button class="btn btn-success btn-md" type="submit">
					Update Service Agent
				</button>
			</div>
		</form>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function all__manufacturers__page(){
		ob_start();
		$manufacturers__list = get_tabledata(TBL_MANUFACTURERS,false);
		if( !user_can( 'view_manufacturer') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$manufacturers__list):
			echo page_not_found("THERE ARE NO  record found for Manufacturers",' ',false);
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
				if($manufacturers__list):
				foreach($manufacturers__list as $manufacturer):
				?>
				<tr>
					<td>
						<?php _e($manufacturer->name);?>
					</td>
					<td>
						<?php echo date('M d,Y',strtotime($manufacturer->created_on));?>
					</td>
					<?php if(is_admin()): ?>
					<td class="text-center">
						<label>
							<input type="checkbox" class="js-switch" <?php checked($manufacturer->approved, 1);?> onClick="javascript:approve_switch(this);" data-id="<?php echo $manufacturer->ID;?>" data-action="manufacturer_approve_change"/>
						</label>
					</td>
					<?php endif; ?>
					<td class="text-center">
						<?php if( user_can( 'edit_manufacturer') ): ?>
						<a href="<?php echo site_url();?>/edit-manufacturer/?id=<?php echo $manufacturer->ID;?>" class="btn btn-dark btn-xs">
							<i class="fa fa-edit">
							</i>Edit
						</a>
						<?php endif; ?>
						<?php if( user_can( 'delete_manufacturer') ): ?>
						<a href="#" class="btn btn-danger btn-xs" onclick="javascript:delete_function(this);" data-id="<?php echo $manufacturer->ID;?>" data-action="delete_manufacturer">
							<i class="fa fa-trash">
							</i>Delete
						</a>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; endif;
				?>
			</tbody>
		</table>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function add__manufacturer__page(){
		ob_start();
		if( !user_can( 'add_manufacturer') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		else:
		?>
		<form class="add-manufacturer-form submit-form" method="post" autocomplete="off">
			<div class="form-group">
				<label for="manufacturer">Manufacturer Name <span class="required">*</span></label>
				<input type="text" name="name" class="form-control require"/>
			</div>
			<div class="form-group">
				<label for="equipment-type">Equipment Type <span class="required">*</span></label>
				<select name="equipment_type[]" class="form-control select_single require" tabindex="-1" data-placeholder="Choose equipment type" multiple="multiple">
					<?php
					$data = get_tabledata(TBL_EQUIPMENT_TYPES,false,array('approved'=> '1'));
					$option_data = get_option_data($data,array('ID','name'));
					echo get_options_list($option_data);
					?>
				</select>
			</div>
			<div class="ln_solid">
			</div>
			<div class="form-group">
				<input type="hidden" name="action" value="add_new_manufacturer"/>
				<button class="btn btn-success btn-md" type="submit">Create New Manufacturer</button>
			</div>
		</form>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function edit__manufacturer__page(){
		ob_start();
		$manufacturer__id = $_GET['id'];
		$manufacturer = get_tabledata(TBL_MANUFACTURERS,true,array('ID'=> $manufacturer__id));
		if( !user_can( 'edit_manufacturer') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$manufacturer):
			echo page_not_found('Oops ! Manufacturer details not found.','Please go back and check again !');
		else:
		?>
		<form class="edit-manufacturer submit-form" method="post" autocomplete="off">
			<div class="form-group">
				<label for="screening-manufacturer">Manufacturer Name <span class="required">*</span></label>
				<input type="text" name="name" class="form-control require" value="<?php _e($manufacturer->name);?>"/>
			</div>
			<div class="form-group">
				<label for="equipment-type">Equipment Type <span class="required">*</span></label>
				<select name="equipment_type[]" class="form-control select_single require" tabindex="-1" data-placeholder="Choose equipment type" multiple="multiple">
					<?php
					$data = get_tabledata(TBL_EQUIPMENT_TYPES,false,array('approved'=> '1'));
					$option_data = get_option_data($data,array('ID','name'));
					echo get_options_list($option_data, maybe_unserialize($manufacturer->equipment_type));
					?>
				</select>
			</div>
			<div class="ln_solid">
			</div>
			<div class="form-group">
				<input type="hidden" name="manufacturer_id" value="<?php echo $manufacturer->ID;?>"/>
				<input type="hidden" name="action" value="update_manufacturer"/>
				<button class="btn btn-success btn-md" type="submit">Update Manufacturer</button>
			</div>
		</form>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function all__models__page(){
		ob_start();
		$models__list = get_tabledata(TBL_MODELS,false);
		if( !user_can( 'view_model') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$models__list):
			echo page_not_found("THERE ARE NO  record found for models",' ',false);
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
				if($models__list):
				foreach($models__list as $model):
				?>
				<tr>
					<td>
						<?php _e($model->name);?>
					</td>
					<td>
						<?php echo date('M d,Y',strtotime($model->created_on));?>
					</td>
					<?php if(is_admin()): ?>
					<td class="text-center">
						<label>
							<input type="checkbox" class="js-switch" <?php checked($model->approved, 1);?> onClick="javascript:approve_switch(this);" data-id="<?php echo $model->ID;?>" data-action="model_approve_change"/>
						</label>
					</td>
					<?php endif; ?>
					<td class="text-center">
						<?php if( user_can( 'edit_model') ): ?>
						<a href="<?php echo site_url();?>/edit-model/?id=<?php echo $model->ID;?>" class="btn btn-dark btn-xs">
							<i class="fa fa-edit">
							</i>Edit
						</a>
						<?php endif; ?>
						<?php if( user_can( 'delete_model') ): ?>
						<a href="#" class="btn btn-danger btn-xs" onclick="javascript:delete_function(this);" data-id="<?php echo $model->ID;?>" data-action="delete_model">
							<i class="fa fa-trash">
							</i>Delete
						</a>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; endif;
				?>
			</tbody>
		</table>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function add__model__page(){
		ob_start();
		if( !user_can( 'add_model') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		else:
		?>
		<form class="add-model-form submit-form" method="post" autocomplete="off">
			<div class="form-group">
				<label for="model">
					Model Name
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="name" class="form-control require"/>
			</div>
			<div class="form-group">
				<label for="manufacturer">
					Manufacturer
					<span class="required">
						*
					</span>
				</label>
				<select name="manufacturer" class="form-control select_single require" tabindex="-1" data-placeholder="Choose manufacturer">
					<?php
					$data = get_tabledata(TBL_MANUFACTURERS,false,array('approved'=> '1'));
					$option_data = get_option_data($data,array('ID','name'));
					echo get_options_list($option_data);
					?>
				</select>
			</div>
			<div class="ln_solid">
			</div>
			<div class="form-group">
				<input type="hidden" name="action" value="add_new_model"/>
				<button class="btn btn-success btn-md" type="submit">
					Create New Model
				</button>
			</div>
		</form>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function edit__model__page(){
		ob_start();
		$model__id = $_GET['id'];
		$model = get_tabledata(TBL_MODELS,true,array('ID'=> $model__id));
		if( !user_can( 'edit_model') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$model):
			echo page_not_found('Oops ! Model details not found.','Please go back and check again !');
		else:
		?>
		<form class="edit-model submit-form" method="post" autocomplete="off">
			<div class="form-group">
				<label for="screening-model">
					Model Name
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="name" class="form-control require" value="<?php _e($model->name);?>"/>
			</div>
			<div class="form-group">
				<label for="manufacturer">
					Manufacturer
					<span class="required">
						*
					</span>
				</label>
				<select name="manufacturer" class="form-control select_single require" tabindex="-1" data-placeholder="Choose manufacturer">
					<?php
					$data = get_tabledata(TBL_MANUFACTURERS,false,array('approved'=> '1'));
					$option_data = get_option_data($data,array('ID','name'));
					echo get_options_list($option_data,maybe_unserialize($model->manufacturer));
					?>
				</select>
			</div>
			<div class="ln_solid">
			</div>
			<div class="form-group">
				<input type="hidden" name="model_id" value="<?php echo $model->ID;?>"/>
				<input type="hidden" name="action" value="update_model"/>
				<button class="btn btn-success btn-md" type="submit">
					Update Model
				</button>
			</div>
		</form>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function all__suppliers__page(){
		ob_start();
		$suppliers__list = get_tabledata(TBL_SUPPLIERS,false);
		if( !user_can( 'view_supplier') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$suppliers__list):
			echo page_not_found("THERE ARE NO  record found for suppliers",' ',false);
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
				<?php if($suppliers__list): foreach($suppliers__list as $supplier): ?>
				<tr>
					<td>
						<?php _e($supplier->name);?>
					</td>
					<td>
						<?php echo date('M d,Y',strtotime($supplier->created_on));?>
					</td>
					<?php if(is_admin()): ?>
					<td class="text-center">
						<label>
							<input type="checkbox" class="js-switch" <?php checked($supplier->approved, 1);?> onClick="javascript:approve_switch(this);" data-id="<?php echo $supplier->ID;?>" data-action="supplier_approve_change"/>
						</label>
					</td>
					<?php endif; ?>		
					<td class="text-center">
						<?php if( user_can( 'edit_supplier') ): ?>
						<a href="<?php echo site_url();?>/edit-supplier/?id=<?php echo $supplier->ID;?>" class="btn btn-dark btn-xs">
							<i class="fa fa-edit">
							</i>Edit
						</a>
						<?php endif; ?>
						<?php if( user_can( 'delete_supplier') ): ?>
						<a href="#" class="btn btn-danger btn-xs" onclick="javascript:delete_function(this);" data-id="<?php echo $supplier->ID;?>" data-action="delete_supplier">
							<i class="fa fa-trash"></i> Delete
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

	public function add__supplier__page(){
		ob_start();
		if( !user_can( 'add_supplier') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		else:
		?>
		<form class="add-supplier-form submit-form" method="post" autocomplete="off">
			<div class="form-group">
				<label for="supplier">
					Supplier Name
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="name" class="form-control require"/>
			</div>
			<div class="ln_solid">
			</div>
			<div class="form-group">
				<input type="hidden" name="action" value="add_new_supplier"/>
				<button class="btn btn-success btn-md" type="submit">
					Create New Supplier
				</button>
			</div>
		</form>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function edit__supplier__page(){
		ob_start();
		$supplier__id = $_GET['id'];
		$supplier = get_tabledata(TBL_SUPPLIERS,true,array('ID'=> $supplier__id));
		if( !user_can( 'edit_supplier') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
		elseif(!$supplier):
			echo page_not_found('Oops ! Supplier details not found.','Please go back and check again !');
		else:
		?>
		<form class="edit-supplier submit-form" method="post" autocomplete="off">
			<div class="form-group">
				<label for="screening-supplier">
					Supplier Name
					<span class="required">
						*
					</span>
				</label>
				<input type="text" name="name" class="form-control require" value="<?php _e($supplier->name);?>"/>
			</div>
			<div class="ln_solid">
			</div>
			<div class="form-group">
				<input type="hidden" name="supplier_id" value="<?php echo $supplier->ID;?>"/>
				<input type="hidden" name="action" value="update_supplier"/>
				<button class="btn btn-success btn-md" type="submit">
					Update Supplier
				</button>
			</div>
		</form>
		<?php endif; ?>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	//Process functions starts here
	public function add__equipment__process(){
		extract($_POST);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not create equipment, please try again.',
			'reset_form' => 0
		);
		if( user_can('add_equipment') ):
			$guid = get_guid(TBL_EQUIPMENTS);
		$byn = rand(0, 99);
			$equipment_code = sprintf( "%d%d%d", $centre, $byn,$equipment_type);

			$result = $this->database->insert(TBL_EQUIPMENTS,
				array(
					'ID' => $guid,
					'name' => 0,
					'centre' => $centre,
					'equipment_code' => NULL,
					'equipment_type' => $equipment_type,
					'manufacturer' => $manufacturer,
					'model' => $model,
					'supplier' => $supplier,
					'service_agent' => $service_agent,
					'location_id' => $location_id,
					'location' => $location,
					'serial_number' => $serial_number,
					'year_manufacturered'=> $year_manufacturered,
					'year_installed' => $year_installed,
					'year_decommisoned' => $year_decommisoned,
					'decommed' => $decommed,
					'spare' => $spare,
					'comment' => $comment,
					'x_ray' => $x_ray,
					'approved' => $approved
				)
			);
			if($result):
				$notification_args = array(
					'title' => 'New equipment created ',
					'notification'=> 'You have successfully created a new equipment.',
				);

				add_user_notification($notification_args);
				$return['status'] = 1;
				$return['message_heading'] = 'Success !';
				$return['message'] = 'Equipment has been created successfully.';
				$return['reset_form'] = 1;
			endif;
		endif;

		return json_encode($return);
		
		
		
	}

	public function update__equipment__process(){
		extract($_POST);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not update equipment, please try again.',
			'reset_form' => 0
		);

		if( user_can('edit_equipment') ):
		$result = $this->database->update(TBL_EQUIPMENTS,
			array(
					'name' => 0,
					'centre' => $centre,
					'equipment_type' => $equipment_type,
					'manufacturer' => $manufacturer,
					'model' => $model,
					'supplier' => $supplier,
					'service_agent' => $service_agent,
					'location_id' => $location_id,
					'location' => $location,
					'serial_number' => $serial_number,
					'year_manufacturered'=> $year_manufacturered,
					'year_installed' => $year_installed,
					'year_decommisoned' => $year_decommisoned,
					'decommed' => $decommed,
					'spare' => $spare,
					'comment' => $comment,
					'x_ray' => $x_ray,
					'approved' => $approved
			

			),
			array(
				'ID'=> $equipment_id
			)
		);

		if($result):
		$notification_args = array(
			'title' => 'Equipment updated',
			'notification'=> 'You have successfully updated equipment',
		);

		add_user_notification($notification_args);
		$return['status'] = 1;
		$return['message_heading'] = 'Success !';
		$return['message'] = 'Equipment has been updated successfully.';
		endif;
		endif;

		return json_encode($return);
	}

	public function delete__equipment__process(){
		extract($_POST);
		$id = trim($id);
		if( user_can('delete_equipment') ):
			$data = get_tabledata(TBL_EQUIPMENTS,true,array('ID'=> $id) ) ;
			$args = array('ID'=> $id);
			$result = $this->database->delete(TBL_EQUIPMENTS,$args);
			if($result):
				$notification_args = array(
					'title' => 'Equipment deleted',
					'notification'=> 'You have successfully deleted ('.$data->name.') equipment.',
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

	public function add__equipment__type__process(){
		extract($_POST);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not create equipment type',
			'reset_form' => 0
		);
		if( user_can('add_equipment_type') ):
			$validation_args = array(
				'name'=> $name,
			);

		if(is_value_exists(TBL_EQUIPMENT_TYPES,$validation_args)):
			$return['status'] = 2;
			$return['message_heading'] = 'Failed !';
			$return['message'] = 'Equipment Type name you entered is already exists, please try another name.';
			$return['fields'] = array('name');
		else:
			$guid = get_guid(TBL_EQUIPMENT_TYPES);
			$result = $this->database->insert(TBL_EQUIPMENT_TYPES,
				array(
					'ID' => $guid,
					'code' => $code,
					'name' => $name,
					'centre' => $centre,
					'supplier'=> $supplier,
					'approved'=> 1,
				)
			);
			if($result):
				$notification_args = array(
					'title' => 'New equipment type created',
					'notification'=> 'You have successfully created a new equipment type ('.$name.').',
				);

				add_user_notification($notification_args);
				$return['status'] = 1;
				$return['message_heading'] = 'Success !';
				$return['message'] = 'Equipment type has been created successfully.';
				$return['reset_form'] = 1;
				endif;
			endif;
		endif;

		return json_encode($return);
	}

	public function update__equipment__type__process(){
		extract($_POST);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not update equipment type',
			'reset_form' => 0
		);

		if( user_can('edit_equipment_type') ):
			$validation_args = array(
				'name'=> $name,
			);

			if(is_value_exists(TBL_EQUIPMENT_TYPES,$validation_args,$equipment_type_id)):
				$return['status'] = 2;
				$return['message_heading'] = 'Failed !';
				$return['message'] = 'Equipment Type name you entered is already exists, please try another name.';
				$return['fields'] = array('name');
			else:
				$result = $this->database->update(TBL_EQUIPMENT_TYPES,
					array(
						'name' => $name,
						'centre' => $centre,
						'supplier'=> $supplier,
					),
					array(
						'ID'=> $equipment_type_id
					)
				);

				if($result):
					$notification_args = array(
						'title' => 'Equipment Type updated',
						'notification'=> 'You have successfully updated equipment type ('.$name.').',
					);

					add_user_notification($notification_args);
					$return['status'] = 1;
					$return['message_heading'] = 'Success !';
					$return['message'] = 'Equipment type has been updated successfully.';
				endif;
			endif;
		endif;

		return json_encode($return);
	}

	public function delete__equipment__type__process(){
		extract($_POST);
		$id = trim($id);
		if( user_can('delete_equipment_type') ):
			$data = get_tabledata(TBL_EQUIPMENT_TYPES,true,array('ID'=> $id) ) ;
			$args = array('ID'=> $id);
			$result = $this->database->delete(TBL_EQUIPMENT_TYPES,$args);
			if($result):
				$notification_args = array(
					'title' => 'Equipment Type deleted',
					'notification'=> 'You have successfully deleted ('.$data->name.') equipment type.',
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

	public function add__service__agent__process(){
		extract($_POST);
		$id = trim($id);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not create manufacturer',
			'reset_form' => 0
		);
		if( user_can('add_service_agent') ):
			$validation_args = array(
				'name'=> $name,
			);

			if(is_value_exists(TBL_SERVICE_AGENTS,$validation_args)):
				$return['status'] = 2;
				$return['message_heading'] = 'Failed !';
				$return['message'] = 'Service agent name you entered is already exists, please try another name.';
				$return['fields'] = array('name');
			else:
				$guid = get_guid(TBL_SERVICE_AGENTS);
				$result = $this->database->insert(TBL_SERVICE_AGENTS,
					array(
						'ID' => $guid,
						'name' => $name,
						'equipment_type'=> $equipment_type,
						'approved' => 1,
					)
				);
				if($result):
					$notification_args = array(
						'title' => 'New service agent created ',
						'notification'=> 'You have successfully created a new service agent ('.$name.').',
					);

					add_user_notification($notification_args);
					$return['status'] = 1;
					$return['message_heading'] = 'Success !';
					$return['message'] = 'Service agent has been created successfully.';
					$return['reset_form'] = 1;
				endif;
			endif;
		endif;

		return json_encode($return);
	}

	public function update__service__agent__process(){
		extract($_POST);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not update manufacturer',
			'reset_form' => 0
		);
		if( user_can('edit_service_agent') ):
			$validation_args = array(
				'name'=> $name,
			);

			if(is_value_exists(TBL_SERVICE_AGENTS,$validation_args,$service_agent_id)):
				$return['status'] = 2;
				$return['message_heading'] = 'Failed !';
				$return['message'] = 'Service agent name you entered is already exists, please try another name.';
				$return['fields'] = array('name');
			else:
				$result = $this->database->update(TBL_SERVICE_AGENTS,
					array(
						'name' => $name,
						'equipment_type'=> $equipment_type
					),
					array(
						'ID'=> $service_agent_id
					)
				);

				if($result):
					$notification_args = array(
						'title' => 'Service agent details updated',
						'notification'=> 'You have successfully updated service agent ('.$name.').',
					);

					add_user_notification($notification_args);
					$return['status'] = 1;
					$return['message_heading'] = 'Success !';
					$return['message'] = 'Service agent has been updated successfully.';
				endif;
			endif;
		endif;

		return json_encode($return);
	}

	public function delete__service__agent__process(){
		extract($_POST);
		if( user_can('delete_service_agent') ):
			$data = get_tabledata(TBL_SERVICE_AGENTS,true,array('ID'=> $id) ) ;
			$args = array('ID'=> $id);
			$result = $this->database->delete(TBL_SERVICE_AGENTS,$args);
			if($result):
				$notification_args = array(
					'title' => 'Service agent record deleted',
					'notification'=> 'You have successfully deleted ('.$data->name.') service agent.',
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

	public function add__manufacturer__process(){
		extract($_POST);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not create manufacturer',
			'reset_form' => 0
		);

		if( user_can('add_manufacturer') ):
			$validation_args = array(
				'name'=> $name,
			);

			if(is_value_exists(TBL_MANUFACTURERS,$validation_args)):
				$return['status'] = 2;
				$return['message_heading'] = 'Failed !';
				$return['message'] = 'Manufacturer name you entered is already exists, please try another name.';
				$return['fields'] = array('name');
			else:
				$guid = get_guid(TBL_MANUFACTURERS);
				$result = $this->database->insert(TBL_MANUFACTURERS,
					array(
						'ID' => $guid,
						'name' => $name,
						'equipment_type'=> $equipment_type,
						'approved' => 1,
					)
				);
				if($result):
					$notification_args = array(
						'title' => 'New manufacturer created ',
						'notification'=> 'You have successfully created a new manufacturer ('.$name.').',
					);

					add_user_notification($notification_args);
					$return['status'] = 1;
					$return['message_heading'] = 'Success !';
					$return['message'] = 'Manufacturer has been created successfully.';
					$return['reset_form'] = 1;
				endif;
			endif;
		endif;

		return json_encode($return);
	}

	public function update__manufacturer__process(){
		extract($_POST);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not update manufacturer',
			'reset_form' => 0
		);
		if( user_can('edit_manufacturer') ):
			$validation_args = array(
				'name'=> $name,
			);

			if(is_value_exists(TBL_MANUFACTURERS,$validation_args,$manufacturer_id)):
				$return['status'] = 2;
				$return['message_heading'] = 'Failed !';
				$return['message'] = 'Manufacturer name you entered is already exists, please try another name.';
				$return['fields'] = array('name');
			else:
				$result = $this->database->update(TBL_MANUFACTURERS,
					array(
						'name' => $name,
						'equipment_type'=> $equipment_type
					),
					array(
						'ID'=> $manufacturer_id
					)
				);

				if($result):
					$notification_args = array(
						'title' => 'Manufacturer details updated',
						'notification'=> 'You have successfully updated manufacturer ('.$name.').',
					);

					add_user_notification($notification_args);
					$return['status'] = 1;
					$return['message_heading'] = 'Success !';
					$return['message'] = 'Manufacturer has been updated successfully.';
				endif;
			endif;
		endif;

		return json_encode($return);
	}

	public function delete__manufacturer__process(){
		extract($_POST);
		$id = trim($id);
		if( user_can('delete_manufacturer') ):
			$data = get_tabledata(TBL_MANUFACTURERS,true,array('ID'=> $id) ) ;
			$args = array('ID'=> $id);
			$result = $this->database->delete(TBL_MANUFACTURERS,$args);
			if($result):
				$notification_args = array(
					'title' => 'Manufacturer record deleted',
					'notification'=> 'You have successfully deleted ('.$data->name.') manufacturer.',
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

	public function add__model__process(){
		extract($_POST);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not create model',
			'reset_form' => 0
		);

		if( user_can('add_model') ):
			$validation_args = array(
				'name'=> $name,
			);

			if(is_value_exists(TBL_MODELS,$validation_args)):
				$return['status'] = 2;
				$return['message_heading'] = 'Failed !';
				$return['message'] = 'Model name you entered is already exists, please try another name.';
				$return['fields'] = array('name');
			else:
				$guid = get_guid(TBL_MODELS);
				$result = $this->database->insert(TBL_MODELS,
					array(
						'ID' => $guid,
						'name' => $name,
						'manufacturer'=> $manufacturer,
						'approved' => 1,
					)
				);
				if($result):
					$notification_args = array(
						'title' => 'New model created ',
						'notification'=> 'You have successfully created a new model ('.$name.').',
					);

					add_user_notification($notification_args);
					$return['status'] = 1;
					$return['message_heading'] = 'Success !';
					$return['message'] = 'Model has been created successfully.';
					$return['reset_form'] = 1;
				endif;
			endif;
		endif;

		return json_encode($return);
	}

	public function update__model__process(){
		extract($_POST);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not update model',
			'reset_form' => 0
		);
		if( user_can('edit_model') ):
			$validation_args = array(
				'name'=> $name,
			);

			if(is_value_exists(TBL_MODELS,$validation_args,$model_id)):
				$return['status'] = 2;
				$return['message_heading'] = 'Failed !';
				$return['message'] = 'Model name you entered is already exists, please try another name.';
				$return['fields'] = array('name');
			else:
				$result = $this->database->update(TBL_MODELS,
					array(
						'name' => $name,
						'manufacturer'=> $manufacturer
					),
					array(
						'ID'=> $model_id
					)
				);

				if($result):
					$notification_args = array(
						'title' => 'Model details updated',
						'notification'=> 'You have successfully updated model ('.$name.').',
					);

					add_user_notification($notification_args);
					$return['status'] = 1;
					$return['message_heading'] = 'Success !';
					$return['message'] = 'Model has been updated successfully.';
				endif;
			endif;
		endif;

		return json_encode($return);
	}

	public function delete__model__process(){
		extract($_POST);
		$id = trim($id);
		if( user_can('delete_model') ):
			$data = get_tabledata(TBL_MODELS,true,array('ID'=> $id) ) ;
			$args = array('ID'=> $id);
			$result = $this->database->delete(TBL_MODELS,$args);
			if($result):
				$notification_args = array(
					'title' => 'Model record deleted',
					'notification'=> 'You have successfully deleted ('.$data->name.') model.',
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

	public function add__supplier__process(){
		extract($_POST);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not create supplier',
			'reset_form' => 0
		);

		if( user_can('add_supplier') ):
			$validation_args = array(
				'name'=> $name,
			);

			if(is_value_exists(TBL_SUPPLIERS,$validation_args)):
				$return['status'] = 2;
				$return['message_heading'] = 'Failed !';
				$return['message'] = 'Supplier name you entered is already exists, please try another name.';
				$return['fields'] = array('name');
			else:
				$guid = get_guid(TBL_SUPPLIERS);
				$result = $this->database->insert(TBL_SUPPLIERS,
					array(
						'ID' => $guid,
						'name' => $name,
						'approved'=> 1,
					)
				);
				if($result):
					$notification_args = array(
						'title' => 'New supplier created ',
						'notification'=> 'You have successfully created a new supplier ('.$name.').',
					);

					add_user_notification($notification_args);
					$return['status'] = 1;
					$return['message_heading'] = 'Success !';
					$return['message'] = 'Supplier has been created successfully.';
					$return['reset_form'] = 1;
				endif;
			endif;
		endif;

		return json_encode($return);
	}

	public function update__supplier__process(){
		extract($_POST);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not update supplier',
			'reset_form' => 0
		);
		if( user_can('edit_supplier') ):
			$validation_args = array(
				'name'=> $name,
			);

			if(is_value_exists(TBL_SUPPLIERS,$validation_args,$supplier_id)):
				$return['status'] = 2;
				$return['message_heading'] = 'Failed !';
				$return['message'] = 'Supplier name you entered is already exists, please try another name.';
				$return['fields'] = array('name');
			else:
				$result = $this->database->update(TBL_SUPPLIERS,
					array(
						'name'=> $name,
					),
					array(
						'ID'=> $supplier_id
					)
				);

				if($result):
					$notification_args = array(
						'title' => 'Supplier details updated',
						'notification'=> 'You have successfully updated supplier ('.$name.').',
					);

					add_user_notification($notification_args);
					$return['status'] = 1;
					$return['message_heading'] = 'Success !';
					$return['message'] = 'Supplier has been updated successfully.';
				endif;
			endif;
		endif;

		return json_encode($return);
	}

	public function delete__supplier__process(){
		extract($_POST);
		$id = trim($id);
		if( user_can('delete_supplier') ):
			$data = get_tabledata(TBL_SUPPLIERS,true,array('ID'=> $id) ) ;
			$args = array('ID'=> $id);
			$result = $this->database->delete(TBL_SUPPLIERS,$args);
			if($result):
				$notification_args = array(
					'title' => 'supplier record deleted',
					'notification'=> 'You have successfully deleted ('.$data->name.') supplier.',
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

	public function fetch__equipment__type__data__process(){
		extract($_POST);
		$id = trim($id);
		$return = array();

		$data = '';

		$data = '';
		$query= "where `equipment_type` LIKE '%".$id."%' AND `approved` = '1' ";
		$data = get_tabledata(TBL_MANUFACTURERS, false, array() , $query);
		$option_data = get_option_data($data,array('ID','name'));
		$return['manufacturer_html'] = get_options_list($option_data);

		$data = '';
		$query= "where `equipment_type` LIKE '%".$id."%' AND `approved` = '1' ";
		$data = get_tabledata(TBL_SERVICE_AGENTS, false, array() , $query);
		$option_data = get_option_data($data,array('ID','name'));
		$return['service_agent_html'] = get_options_list($option_data);

		$data = '';
		$equipment_type = get_tabledata(TBL_EQUIPMENT_TYPES, true, array('ID'=> $id ));
		$suppliers = maybe_unserialize($equipment_type->supplier);
		$suppliers = (!empty($suppliers)) ? implode(',',$suppliers) : '0';
		$query = "where `ID` IN (".$suppliers.") AND `approved` = '1' ";
		$data = get_tabledata(TBL_SUPPLIERS, false, array() , $query);
		$option_data = get_option_data($data,array('ID','name'));
		$return['supplier_html'] = get_options_list($option_data);

		return json_encode($return);
	}

	public function fetch__manufacturer__data__process(){
		extract($_POST);
		$id = trim($id);
		$return = array();

		$data = get_tabledata(TBL_MODELS, false, array('manufacturer'=> $id ,'approved' => '1') );
		$option_data = get_option_data($data,array('ID','name'));
		$return['model_html'] = get_options_list($option_data);

		return json_encode($return);
	}

	public function equipment__approve__change__process(){
		extract($_POST);
		$id = trim($id);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not update equipment details, Please try again ',
			'reset_form' => 0
		);
		if(user_can('edit_equipment')):
			$equipment = get_tabledata(TBL_EQUIPMENTS, true, array('ID'=> $id) );
			$args = array('ID'=> $id);
			$result = $this->database->update(TBL_EQUIPMENTS,array('approved'=> $status),$args);

			if($result):
				if($status == 0){
					$notification_args = array(
						'title' => 'Equipment (' .$equipment->name.') is disabled now',
						'notification'=> 'You have successfully disabled (' .$equipment->name.') equipment.',
					);
					$return['message'] = 'You have successfully disabled (' .$equipment->name.') equipment.';
				}else{
					$notification_args = array(
						'title' => 'Equipment (' .$equipment->name.') is approved now',
						'notification'=> 'You have successfully approved (' .$equipment->name.') equipment.',
					);
					$return['message'] = 'You have successfully approved (' .$equipment->name.') equipment.';
				}
				add_user_notification($notification_args);
				$return['status'] = 1;
				$return['message_heading'] = 'Success !';
			endif;
		endif;
		return json_encode($return);
	}

	public function equipment__type__approve__change__process(){
		extract($_POST);
		$id = trim($id);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not update equipment type details, Please try again ',
			'reset_form' => 0
		);
		if(user_can('edit_equipment')):
			$equipment = get_tabledata(TBL_EQUIPMENT_TYPES, true, array('ID'=> $id) );
			$args = array('ID'=> $id);
			$result = $this->database->update(TBL_EQUIPMENT_TYPES,array('approved'=> $status),$args);

			if($result):
				if($status == 0){
					$notification_args = array(
						'title' => 'Equipment type (' .$equipment->ID.') is disabled now',
						'notification'=> 'You have successfully disabled (' .$equipment->ID.') equipment type.',
					);
					$return['message'] = 'You have successfully disabled (' .$equipment->ID.') equipment type.';
				}else{
					$notification_args = array(
						'title' => 'Equipment type (' .$equipment->ID.') is approved now',
						'notification'=> 'You have successfully approved (' .$equipment->ID.') equipment type.',
					);
					$return['message'] = 'You have successfully approved (' .$equipment->ID.') equipment type.';
				}
				add_user_notification($notification_args);
				$return['status'] = 1;
				$return['message_heading'] = 'Success !';
			endif;
		endif;
		return json_encode($return);
	}

	public function service__agent__approve__change__process(){
		extract($_POST);
		$id = trim($id);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not update service agent details, Please try again ',
			'reset_form' => 0
		);
		if(user_can('edit_service_agent')):
			$service_agent = get_tabledata(TBL_SERVICE_AGENTS, true, array('ID'=> $id) );
			$args = array('ID'=> $id);
			$result = $this->database->update(TBL_SERVICE_AGENTS,array('approved'=> $status),$args);

			if($result):
				if($status == 0){
					$notification_args = array(
						'title' => 'Service agent (' .$service_agent->name.') is disabled now',
						'notification'=> 'You have successfully disabled (' .$service_agent->name.') service agent.',
					);
					$return['message'] = 'You have successfully disabled (' .$service_agent->name.') service agent.';
				}else{
					$notification_args = array(
						'title' => 'Service agent (' .$service_agent->name.') is approved now',
						'notification'=> 'You have successfully approved (' .$service_agent->name.') service agent.',
					);
					$return['message'] = 'You have successfully approved (' .$service_agent->name.') service agent.';
				}
				add_user_notification($notification_args);
				$return['status'] = 1;
				$return['message_heading'] = 'Success !';
			endif;
		endif;
		return json_encode($return);
	}

	public function manufacturer__approve__change__process(){
		extract($_POST);
		$id = trim($id);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not update manufacturer details, Please try again ',
			'reset_form' => 0
		);
		if(user_can('edit_manufacturer')):
			$manufacturer = get_tabledata(TBL_MANUFACTURERS, true, array('ID'=> $id) );
			$args = array('ID'=> $id);
			$result = $this->database->update(TBL_MANUFACTURERS,array('approved'=> $status),$args);

			if($result):
				if($status == 0){
					$notification_args = array(
						'title' => 'Manufacturer (' .$manufacturer->name.') is disabled now',
						'notification'=> 'You have successfully disabled (' .$manufacturer->name.') manufacturer.',
					);
					$return['message'] = 'You have successfully disabled (' .$manufacturer->name.') manufacturer.';
				}else{
					$notification_args = array(
						'title' => 'Manufacturer (' .$manufacturer->name.') is approved now',
						'notification'=> 'You have successfully approved (' .$manufacturer->name.') manufacturer.',
					);
					$return['message'] = 'You have successfully approved (' .$manufacturer->name.') manufacturer.';
				}
				add_user_notification($notification_args);
				$return['status'] = 1;
				$return['message_heading'] = 'Success !';
			endif;
		endif;
		return json_encode($return);
	}

	public function model__approve__change__process(){
		$id = trim($id);
		extract($_POST);
		$return = array(
			'status' => 0,
			'message_heading'=> 'Failed !',
			'message' => 'Could not update model details, Please try again ',
			'reset_form' => 0
		);
		if(user_can('edit_model')):
			$model = get_tabledata(TBL_MODELS, true, array('ID'=> $id) );
			$args = array('ID'=> $id);
			$result = $this->database->update(TBL_MODELS,array('approved'=> $status),$args);

			if($result):
				if($status == 0){
					$notification_args = array(
						'title' => 'Model (' .$model->name.') is disabled now',
						'notification'=> 'You have successfully disabled (' .$model->name.') model.',
					);
					$return['message'] = 'You have successfully disabled (' .$model->name.') model.';
				}else{
					$notification_args = array(
						'title' => 'Model (' .$model->name.') is approved now',
						'notification'=> 'You have successfully approved (' .$model->name.') model.',
					);
					$return['message'] = 'You have successfully approved (' .$model->name.') model.';
				}
				add_user_notification($notification_args);
				$return['status'] = 1;
				$return['message_heading'] = 'Success !';
			endif;
		endif;
		return json_encode($return);
	}

		public function supplier__approve__change__process(){
			extract($_POST);
			$id = trim($id);
			$return = array(
				'status' => 0,
				'message_heading'=> 'Failed !',
				'message' => 'Could not update supplier details, Please try again ',
				'reset_form' => 0
			);
			if(user_can('edit_supplier')):
				$supplier = get_tabledata(TBL_SUPPLIERS, true, array('ID'=> $id) );
				$args = array('ID'=> $id);
				$result = $this->database->update(TBL_SUPPLIERS,array('approved'=> $status),$args);

				if($result):
					if($status == 0){
						$notification_args = array(
							'title' => 'Supplier (' .$supplier->name.') is disabled now',
							'notification'=> 'You have successfully disabled (' .$supplier->name.') supplier.',
						);
						$return['message'] = 'You have successfully disabled (' .$supplier->name.') supplier.';
					}else{
						$notification_args = array(
							'title' => 'Supplier (' .$supplier->name.') is approved now',
							'notification'=> 'You have successfully approved (' .$supplier->name.') supplier.',
						);
						$return['message'] = 'You have successfully approved (' .$supplier->name.') supplier.';
					}
					add_user_notification($notification_args);
					$return['status'] = 1;
					$return['message_heading'] = 'Success !';
				endif;
			endif;
			return json_encode($return);
		}

		public function fetch_all_equipments_process(){
			$orders_columns = array(
				0 => 'name',
				7 => 'created_on',
				8 => 'approved',
			);
			$recordsTotal = $recordsFiltered = 0;
			$draw = $_POST["draw"];
			$orderByColumnIndex = $_POST['order'][0]['column'];
			$orderBy = ( array_key_exists( $orderByColumnIndex , $orders_columns ) ) ? $orders_columns[$orderByColumnIndex] : 'created_on';
			$orderType = $_POST['order'][0]['dir'];
			$start = $_POST["start"];
			$length = $_POST['length'];
			
			$query = '';
			if(!is_admin()):
				$centres = maybe_unserialize($this->current__user->centre);
				if(!empty($centres)){
					$centres = implode(',',$centres);
					$query = "WHERE `centre` IN (".$centres.")";
				}
			endif;
			
			$sql = sprintf(" ORDER BY %s %s limit %d , %d ", $orderBy,$orderType ,$start , $length);
			$data = array();
			if(!empty($_POST['search']['value'])){
				$columns = array('ID','name');
				for($i = 0 ; $i < count($columns);$i++){
					$column = $columns[$i];
					$where[] = "$column LIKE '%".$_POST['search']['value']."%'";
				}
				$where = implode(" OR " , $where);
				$query .= ($query != '') ? ' AND ' : ' WHERE ';
				$query .= $where;	
			}
			
			if(!empty($_POST['centre']) && $_POST['centre'] != 'undefined'){
				$query .= ($query != '') ? ' AND ' : ' WHERE ';
				$query .= " `centre` = '".$_POST['centre']."' ";
			}
			
			if(!empty($_POST['equipment_type']) && $_POST['equipment_type'] != 'undefined'){
				$query .= ($query != '') ? ' AND ' : ' WHERE ';
				$query .= " `equipment_type` = '".$_POST['equipment_type']."' ";
			}
			
			if(!empty($_POST['manufacturer']) && $_POST['manufacturer'] != 'undefined'){
				$query .= ($query != '') ? ' AND ' : ' WHERE ';
				$query .= " `manufacturer` = '".$_POST['manufacturer']."' ";
			}
			
			if(!empty($_POST['model']) && $_POST['model'] != 'undefined'){
				$query .= ($query != '') ? ' AND ' : ' WHERE ';
				$query .= " `model` = '".$_POST['model']."' ";
			}
			
			$recordsTotal = count(get_tabledata(TBL_EQUIPMENTS,false,array(), $query));
			$data_list = get_tabledata(TBL_EQUIPMENTS,false ,array(), $query.$sql );
			//$recordsFiltered = count( $data_list );
			$recordsFiltered = $recordsTotal;	
			if($data_list): foreach($data_list as $equipment):
				$centre = get_tabledata(TBL_CENTRES,true,array('ID'=>$equipment->centre));
				$equipment_type = get_tabledata(TBL_EQUIPMENT_TYPES,true,array('ID'=>$equipment->equipment_type));
				$manufacturer = get_tabledata(TBL_MANUFACTURERS,true,array('ID'=>$equipment->manufacturer));
				$model = get_tabledata(TBL_MODELS,true,array('ID'=>$equipment->model));
				$service_agent = get_tabledata(TBL_SERVICE_AGENTS,true,array('ID'=>$equipment->service_agent));
				$row = array();
				array_push($row, __($equipment->name));
				array_push($row, __($centre->name));
				array_push($row, __($equipment->equipment_code));
				array_push($row, __($equipment_type->name));
				array_push($row, __($model->name));
				array_push($row, __($manufacturer->name));
				array_push($row, __($service_agent->name));

				
				array_push($row, date('M d,Y',strtotime($equipment->created_on)));
				if(is_admin()):
					ob_start();
					?>
					<div class="text-center">
						<label>
							<input type="checkbox" class="js-switch" <?php checked($equipment->approved, 1);?> onclick="approve_switch(this);" data-id="<?php echo $equipment->ID;?>" data-action="equipment_approve_change"/>
						</label>
					</div>
					<?php 
					$checkbox = ob_get_clean();
					array_push($row, $checkbox);
				endif;
				ob_start();
				?>
				<div class="text-center">
					<?php if( user_can( 'view_equipment') ): ?>
					<a href="<?php echo site_url();?>/view-equipment/?id=<?php echo $equipment->ID;?>" class="btn btn-dark btn-xs">
						<i class="fa fa-eye"></i> View
					</a>
					<?php endif; ?>
					<?php if( user_can( 'edit_equipment') ): ?>
					<a href="<?php echo site_url();?>/edit-equipment/?id=<?php echo $equipment->ID;?>" class="btn btn-dark btn-xs">
						<i class="fa fa-edit"></i> Edit
					</a>
					<?php endif; ?>
					<?php if( user_can( 'delete_equipment') ): ?>
					<a href="#" class="btn btn-danger btn-xs" onclick="delete_function(this);" data-id="<?php echo $equipment->ID;?>" data-action="delete_equipment">
						<i class="fa fa-trash"></i> Delete
					</a>
					<?php endif; ?>
				</div>
				<?php 
				$action = ob_get_clean();
				array_push($row, $action);
				$data[] = $row;
				endforeach;
			endif;
			
			/* Response to client before JSON encoding */
			$response = array(
				"draw" => intval($draw),
				"recordsTotal" => $recordsTotal,
				"recordsFiltered"=> $recordsFiltered,
				"data" => $data,
			);
			return json_encode($response);
		}

	
	
	
	
			public function fetch_all_equipments_process2(){
			$orders_columns = array(
				0 => 'name',
				7 => 'created_on',
				8 => 'approved',
			);
			$recordsTotal = $recordsFiltered = 0;
			$draw = $_POST["draw"];
			$orderByColumnIndex = $_POST['order'][0]['column'];
			$orderBy = ( array_key_exists( $orderByColumnIndex , $orders_columns ) ) ? $orders_columns[$orderByColumnIndex] : 'created_on';
			$orderType = $_POST['order'][0]['dir'];
			$start = $_POST["start"];
			$length = $_POST['length'];
			
			$query = '';
			if(!is_admin()):
				$centres = maybe_unserialize($this->current__user->centre);
				if(!empty($centres)){
					$centres = implode(',',$centres);
					$query = "WHERE `centre` IN (".$centres.")";
				}
			endif;
			$recordsTotal = count(get_tabledata(TBL_EQUIPMENTS,false,array(), $query));
			$sql = sprintf(" ORDER BY %s %s limit %d , %d ", $orderBy,$orderType ,$start , $length);
			$data = array();
			if(!empty($_POST['search']['value'])){
				$columns = array('ID','name');
				for($i = 0 ; $i < count($columns);$i++){
					$column = $columns[$i];
					$where[] = "$column LIKE '%".$_POST['search']['value']."%'";
				}
				$where = implode(" OR " , $where);
				$query .= ($query != '') ? ' AND ' : ' WHERE ';
				$query .= $where;
				$data_list = get_tabledata(TBL_EQUIPMENTS,false ,array('approved'=>'0'), $query.$sql );
				//$recordsFiltered = count( $data_list );
				$recordsFiltered = $recordsTotal;	
			}else{
				$data_list = get_tabledata(TBL_EQUIPMENTS,false,array('approved'=>'0'),$query.$sql);
				$recordsFiltered = $recordsTotal;
			}
			
			if($data_list): foreach($data_list as $equipment):
				$centre = get_tabledata(TBL_CENTRES,true,array('ID'=>$equipment->centre));
				$equipment_type = get_tabledata(TBL_EQUIPMENT_TYPES,true,array('ID'=>$equipment->equipment_type));
				$manufacturer = get_tabledata(TBL_MANUFACTURERS,true,array('ID'=>$equipment->manufacturer));
				$model = get_tabledata(TBL_MODELS,true,array('ID'=>$equipment->model));
				$service_agent = get_tabledata(TBL_SERVICE_AGENTS,true,array('ID'=>$equipment->service_agent));
				$row = array();
				array_push($row, __($equipment->name));
				array_push($row, __($centre->name));
				array_push($row, __($equipment->equipment_code));
				array_push($row, __($equipment_type->name));
				array_push($row, __($model->name));
				array_push($row, __($manufacturer->name));
				array_push($row, __($service_agent->name));

				
				array_push($row, date('M d,Y',strtotime($equipment->created_on)));
				if(is_admin()):
					ob_start();
					?>
					<div class="text-center">
						<label>
							<input type="checkbox" class="js-switch" <?php checked($equipment->approved, 1);?> onclick="approve_switch(this);" data-id="<?php echo $equipment->ID;?>" data-action="equipment_approve_change"/>
						</label>
					</div>
					<?php 
					$checkbox = ob_get_clean();
					array_push($row, $checkbox);
				endif;
				ob_start();
				?>
				<div class="text-center">
					<?php if( user_can( 'view_equipment') ): ?>
					<a href="<?php echo site_url();?>/view-equipment/?id=<?php echo $equipment->ID;?>" class="btn btn-dark btn-xs">
						<i class="fa fa-eye"></i> View
					</a>
					<?php endif; ?>
					<?php if( user_can( 'edit_equipment') ): ?>
					<a href="<?php echo site_url();?>/edit-equipment/?id=<?php echo $equipment->ID;?>" class="btn btn-dark btn-xs">
						<i class="fa fa-edit"></i> Edit
					</a>
					<?php endif; ?>
					<?php if( user_can( 'delete_equipment') ): ?>
					<a href="#" class="btn btn-danger btn-xs" onclick="delete_function(this);" data-id="<?php echo $equipment->ID;?>" data-action="delete_equipment">
						<i class="fa fa-trash"></i> Delete
					</a>
					<?php endif; ?>
				</div>
				<?php 
				$action = ob_get_clean();
				array_push($row, $action);
				$data[] = $row;
				endforeach;
			endif;
			
			/* Response to client before JSON encoding */
			$response = array(
				"draw" => intval($draw),
				"recordsTotal" => $recordsTotal,
				"recordsFiltered"=> $recordsFiltered,
				"data" => $data,
			);
			return json_encode($response);
		}	
	

	}
endif;
?>