<?php
// if accessed directly than exit
if(!defined('ABSPATH')) exit;
date_default_timezone_set('Europe/London');
error_reporting(1);

if( !class_exists('Exports') ):
class Exports{
	private $database;
	private $current__user__id;
	private $current__user;
	function __construct(){
		global $db;
		$this->database = $db;
		$this->current__user__id = get_current_user_id();
		$this->current__user = get_userdata($this->current__user__id);
	}

	public function export_page(){
		ob_start();
		$query = '';
		$filters = $_SESSION['filters'];	
		if(!isset($filters->{'fault_date_from'})) {
			$filters->{'fault_date_from'} = date('F d,Y');
		}
		if(!isset($filters->{'fault_date_to'})) {
			$filters->{'fault_date_to'} = date('F d,Y');
		}
		if(!is_admin()):
		$centres = maybe_unserialize($this->current__user->centre);
		if(!empty($centres)){
			$centres = implode(',',$centres);
			$query = "WHERE `centre` IN (".$centres.")";
		}
		endif;
		$faults = get_tabledata(TBL_FAULTS,false,array(), $query, 'ID');
		if( !user_can('view_fault') ):
		echo page_not_found('You are not allowed to view this page.',' ');
		elseif(!$faults):
		echo page_not_found("There are no new faults record found",' ',false);
		else:
?>
<form action="<?php echo site_url();?>/main_export/" method="POST">
	<div class="row custom-filters">
		<div class="form-group col-sm-2 col-xs-6">
			<label for="exportcentre">Centre</label>
			<select name="exportcentre" class="form-control select_single" tabindex="-1" data-placeholder="Choose centre">
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
		$data = get_tabledata(TBL_CENTRES,false,array(),$query,' ID, CONCAT_WS(" | ", name , region_name, centre_code) AS name');
		$option_data = get_option_data($data,array('ID','name'));
		echo get_options_list($option_data, $filters->{'centre'});
				?>
			</select>
		</div>
	</div>
	<div class="row custom-filters">
		<fieldset class='scheduler-border'>
			<legend class='scheduler-border'>Equipment/Fault Specific Filters</legend>
			<div class="form-group col-sm-2 col-xs-6">
				<label for="exportequipment-type">Equipment Type</label>
				<select name="exportequipment_type" class="form-control select_single fetch-equipment-type-data" tabindex="-1" data-placeholder="Choose equipment type">
				<?php
				$data = get_tabledata(TBL_EQUIPMENT_TYPES,false,array('approved'=> '1'), 'ORDER BY `name` ASC');
				$option_data = get_option_data($data,array('ID','name'));
				echo get_options_list($option_data, $filters->{'eq'});
				?>
				</select>
			</div>
		
			<div class="form-group col-sm-2 col-xs-6">
				<label for="exportmanufacturer">Manufacturer</label>
					<select name="exportmanufacturer" class="form-control select_single select_manufacturer" tabindex="-1" data-placeholder="Choose manufacturer">
						<?php
		
						$data = get_tabledata(TBL_MANUFACTURERS,false,array('approved'=> '1'), 'ORDER BY `name` ASC');
						$option_data = get_option_data($data,array('ID','name'));
						echo get_options_list($option_data, $filters->{'man'});
						?>
					</select>
			</div>
			<!--
			<div class="form-group col-sm-2 col-xs-6">
				<label for="exportequipment">Equipment</label>
				<select name="exportequipment" class="form-control select_single" tabindex="-1" data-placeholder="Choose equipment">
				<?php
				$query = '';
				if(!is_admin()):
				$centres = maybe_unserialize($this->current__user->centre);
				if(!empty($centres)){
					$centres = implode(',',$centres);
					$query = "WHERE `centre` IN (".$centres.")";
				}
				endif;
				$query .= ($query != '') ? ' AND ' : ' WHERE ';

				if(isset($_POST['equipment_type']) && $_POST['equipment_type'] != ''  && $_POST['equipment_type'] != 'undefined'){

					if(isset($_POST['centre']) && $_POST['centre'] != '' && $_POST['centre'] != 'undefined'){
						$query = " WHERE `equipment_type` = '".$_POST['equipment_type']."' AND `centre` = '".$_POST['centre']."' AND `approved` = '1' ORDER BY `name` ASC";
						$data = get_tabledata(TBL_EQUIPMENTS,false,array(),$query);
						$option_data = get_option_data($data,array('ID','name'));
						echo get_options_list($option_data, $filters->{'equipment'});	
					}else{
						$query .= " `equipment_type` = '".$_POST['equipment_type']."' AND `approved` = '1' ORDER BY `name` ASC";
						$data = get_tabledata(TBL_EQUIPMENTS,false,array(),$query);
						$option_data = get_option_data($data,array('ID','name'));
						echo get_options_list($option_data, $filters->{'equipment'});	
					}
				}else{
					$query .= " `approved` = '1' ORDER BY `name` ASC";
					$data = get_tabledata(TBL_EQUIPMENTS,false,array(),$query);
					$option_data = get_option_data($data,array('ID','name'));
					echo get_options_list($option_data, $filters->{'equipment'});	
				}
				?>
				</select>
			</div>
			-->
			<div class="form-group col-sm-2 col-xs-6">
				<label for="exportdecommed">Decommisioned</label>
				<select name="exportdecommed" class="form-control select_single" tabindex="-1" data-placeholder="Choose decomisioned value">
				<?php
				$option_data = array( '1' => 'yes' , '0' => 'no');
				echo get_options_list($option_data, $filters->{'decom'});
				?>
				</select>
			</div>
		</fieldset>
	</div>

	<div class="row custom-filters">
	<fieldset class='scheduler-border'>
		<legend class='scheduler-border'>Fault Specific Filters</legend>

			<div class="form-group col-sm-2 col-xs-6">
				<label for="exportfault-type">Fault Type</label>
				<select name="exportfault_type" class="form-control select_single" tabindex="-1" data-placeholder="Choose fault type">
					<?php
			$data = get_tabledata(TBL_FAULT_TYPES,false,array('approved'=> '1'), 'ORDER BY `name` ASC');
			$option_data = get_option_data($data,array('ID','name'));
			echo get_options_list($option_data, $filters->{'fault_type'});
					?>
				</select>
			</div>
			<div class="form-group col-sm-2 col-xs-6">
				<label for="exportapproved">Approval Status</label>
				<select name="exportapproved" class="form-control select_single" tabindex="-1" data-placeholder="Choose status">
					<?php
			$option_data = array( '1' => 'Approved' , '0' => 'Unapproved');
			echo get_options_list($option_data, $filters->{'approved'});
					?>
				</select>
			</div>

		<div class="form-group col-sm-2 col-xs-6 col">
			<label for="exportdate_of_fault">
				<?php _e('Fault Date From');?>
			</label>
			<input type="text" name="exportfault_date_from" class="form-control input-datepicker-today" value="<?php echo($filters->{'fault_date_from'}) ?>"/> </div>
		<div class="form-group col-sm-2 col-xs-6 ">
			<label for="exportdate_of_fault">
				<?php _e('Fault Date To');?>
			</label>
			<input type="text" name="exportfault_date_to" class="form-control input-datepicker-today" value="<?php echo($filters->{'fault_date_to'}) ?>"/> </div>
	</fieldset>
	</div>
	<div class="row custom-filters">
		<div >
			<?php if(is_admin()){ ?>
			<input type="submit" value="Export Report" name="exportSubmitButton" class="btn btn-dark btn-sm custom-export-btn" />
			<?php } ?>
		</div>
	</div>
</form>
<?php endif; 
		$content = ob_get_clean();
		return $content;
	}

	public function fetch_all_faults_process(){
		if(is_admin()){
			$orders_columns = array(
				1 => 'ID',
				2 => 'centre_name',
				3 => 'e_type_name',
				4 => 'equipment_name',
				5 => 'f_type_name',
				6 => 'date_of_fault',
				7 => 'last_modified',
				0 => 'approved',
			);
		}else{
			$orders_columns = array(
				0 => 'ID',
				1 => 'centre_name',
				2 => 'e_type_name',
				3 => 'equipment_name',
				4 => 'f_type_name',
				5 => 'date_of_fault',
			);
		}

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

		$sql = sprintf(" ORDER BY %s %s LIMIT %d , %d ", $orderBy, $orderType ,$start , $length);
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

		if(isset($_POST['centre']) && $_POST['centre'] != '' && $_POST['centre'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " `centre` = '".$_POST['centre']."' ";
		}

		if(isset($_POST['equipment']) && $_POST['equipment'] != '' &&  $_POST['equipment'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " `equipment` = '".$_POST['equipment']."' ";
		}

		if(isset($_POST['equipment_type']) && $_POST['equipment_type'] != '' && $_POST['equipment_type'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " `equipment_type` = '".$_POST['equipment_type']."' ";
		}

		if(isset($_POST['fault_type']) && $_POST['fault_type'] != '' && $_POST['fault_type'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " `fault_type` = '".$_POST['fault_type']."' ";
		}

		if(isset($_POST['approved']) && $_POST['approved'] != '' &&  $_POST['approved'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " `approved` = '".$_POST['approved']."' ";
		}
		
		if(isset($_POST['manufacturer']) && $_POST['manufacturer'] != '' &&  $_POST['manufacturer'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " `eq_manufac` = '".$_POST['manufacturer']."' ";
		}

		if(isset($_POST['fault_date_from']) && $_POST['fault_date_from'] != '' && $_POST['fault_date_from'] != 'undefined' && isset($_POST['fault_date_to']) && $_POST['fault_date_to'] != '' &&  $_POST['fault_date_to'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " ( `date_of_fault` >= '".date( 'Y-m-d', strtotime($_POST['fault_date_from']) )."' AND `date_of_fault` <= '".date( 'Y-m-d', strtotime($_POST['fault_date_to']) )."' ) ";
		}else if(isset($_POST['fault_date_from']) && $_POST['fault_date_from'] != '' &&  $_POST['fault_date_from'] != 'undefined' && ( !isset($_POST['fault_date_to']) || $_POST['fault_date_to'] == '' ||  $_POST['fault_date_to'] == 'undefined' ) ){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= "  `date_of_fault` >= '".date( 'Y-m-d', strtotime($_POST['fault_date_from']) )."' ";
		}else if( (!isset($_POST['fault_date_from']) || $_POST['fault_date_from'] == '' || $_POST['fault_date_from'] == 'undefined' ) && isset($_POST['fault_date_to']) && $_POST['fault_date_to'] != '' &&  $_POST['fault_date_to'] != 'undefined'){
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= "  `date_of_fault` <= '".date( 'Y-m-d', strtotime($_POST['fault_date_to']) )."' ";
		}			

		$recordsTotal = get_tabledata(TBL_FAULTS,true,array(), $query, 'COUNT(ID) as count');
		$recordsTotal = $recordsTotal->count;
		$data_list = get_tabledata(TBL_FAULTS,false,array(),$query.$sql);
		$recordsFiltered = $recordsTotal;

		if($data_list):
		foreach($data_list as $fault):
		$centre = get_tabledata(TBL_CENTRES,true,array('ID'=> $fault->centre));
		$equipment_type = get_tabledata(TBL_EQUIPMENT_TYPES,true,array('ID'=> $fault->equipment_type));
		$equipment = get_tabledata(TBL_EQUIPMENTS,true,array('ID'=> $fault->equipment));
		$fault_type = get_tabledata(TBL_FAULT_TYPES,true,array('ID'=> $fault->fault_type));
		$row = array();
		if(is_admin()):
		ob_start();
?>
<div class="text-center">
	<label>
		<input type="checkbox" class="js-switch" <?php checked($fault->approved, 1);?> onclick="approve_switch(this);"data-id="<?php echo $fault->ID;?>" data-action="fault_approve_change"/></label>
	<div style="display:none;">
		<?php echo $fault->approved; ?>
	</div>
</div>
<?php 
		$checkbox = ob_get_clean();
		array_push($row, $checkbox);
		endif;
		array_push($row, __($fault->ID));

		if($fault->centre_name != ""){
			array_push($row, __($fault->centre_name));
		}else{
			array_push($row, __($centre->name));
		}

		if($fault->e_type_name != ""){
			array_push($row, __($fault->e_type_name));	
		}else{
			array_push($row, __($equipment_type->name));
		}	

		if($fault->equipment_name != ""){
			array_push($row, __($fault->equipment_name));	
		}else{
			array_push($row, __($equipment->name));
		}

		if($fault->f_type_name != ""){
			array_push($row, __($fault->f_type_name));	
		}else{
			array_push($row, __($fault_type->name));
		}
		

		array_push($row, date('d M,Y',strtotime($fault->date_of_fault)));
		//array_push($row, date('d M, Y',$fault->date_of_fault));
if(is_admin()){
		array_push($row, date('d M,Y',strtotime($fault->last_modified)));
}
		ob_start();
?>
<div class="text-center">
	<?php if(is_admin()): ?>
	<a href="#" onclick="view_function(this); return false;" data-id="<?php echo $fault->ID;?>" data-action="view_fault" class="btn btn-dark btn-xs"> <i class="fa fa-edit"></i> View </a>
	<a href="#" onclick="edit_function(this); return false;" data-id="<?php echo $fault->ID;?>" data-action="edit_fault" class="btn btn-dark btn-xs"> <i class="fa fa-edit"></i> Edit </a>
	<a href="#" class="btn btn-danger btn-xs" onclick="delete_function(this);" data-id="<?php echo $fault->ID;?>" data-action="delete_fault"> <i class="fa fa-trash"></i> Delete </a>
	<?php else:
		$future = date('d-m-Y',strtotime(' + 2 day', strtotime($fault->created_on)));
		$today = date('d-m-Y');
		if($today == $future):
		if( user_can('view_fault') ): ?>
	<a href="#" onclick="view_function(this); return false;" data-id="<?php echo $fault->ID;?>" data-action="view_fault" class="btn btn-dark btn-xs"> <i class="fa fa-edit"></i> View </a>
	<?php endif; ?>
	
	<?php else: ?>
	<?php if($this->current__user__id == $fault->user_id):
		if( user_can('edit_fault') ): ?>
	<a href="#" onclick="edit_function(this); return false;" data-id="<?php echo $fault->ID;?>" data-action="edit_fault" class="btn btn-dark btn-xs"> <i class="fa fa-edit"></i> Edit </a>
	<?php endif; ?>
		<?php if( user_can('view_fault') ): ?>
	<a href="#" onclick="view_function(this); return false;" data-id="<?php echo $fault->ID;?>" data-action="view_fault" class="btn btn-dark btn-xs"> <i class="fa fa-edit"></i> View </a>
	<?php endif; ?>
	
	<?php if( user_can('delete_fault') ): ?> <a href="#" class="btn btn-danger btn-xs" onclick="javascript:delete_function(this);" data-id="<?php echo $fault->ID;?>" data-action="delete_fault"><i class="fa fa-trash"></i> Delete</a>
	<?php endif; ?>
	<?php else: ?>
	<?php if( user_can('view_fault') ): ?>
	<a href="#" onclick="view_function(this); return false;" data-id="<?php echo $fault->ID;?>" data-action="view_fault" class="btn btn-dark btn-xs"> <i class="fa fa-edit"></i> View </a>
	<?php endif; ?>
	<?php endif; ?>
	<?php endif; ?>
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
			'draw' => intval($draw),
			'recordsTotal' => $recordsTotal,
			'recordsFiltered'=> $recordsFiltered,
			'data' => $data,
		);
		return json_encode($response);
	}

	public function fetch_all_faults_process2(){
		if(is_admin()){
			$orders_columns = array(
				2 => 'ID',
				3 => 'centre_name',
				4 => 'e_type_name',
				5 => 'equipment_name',
				6 => 'f_type_name',
				7 => 'date_of_fault',
				0 => 'approved',
			);
		}


		$orders_columns = array(
			0 => 'centre_name',
			1 => 'e_type_name',
			2 => 'equipment_name',
			3 => 'f_type_name',
			4 => 'date_of_fault',
			5 => 'ID',
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
		$recordsTotal = count(get_tabledata(TBL_FAULTS,false,array('approved'=>'0'), $query, 'ID'));
		$sql = sprintf(" ORDER BY %s %s LIMIT %d , %d ", $orderBy,$orderType ,$start , $length);
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
			$data_list = get_tabledata(TBL_FAULTS,false,array('approved'=>'0'),$query.$sql);
			$recordsFiltered = $recordsTotal;
		}

		if($data_list): foreach($data_list as $fault):
		$centre = get_tabledata(TBL_CENTRES,true,array('ID'=> $fault->centre));	
		$equipment_type = get_tabledata(TBL_EQUIPMENT_TYPES,true,array('ID'=> $fault->equipment_type));
		$equipment = get_tabledata(TBL_EQUIPMENTS,true,array('ID'=> $fault->equipment));
		$fault_type = get_tabledata(TBL_FAULT_TYPES,true,array('ID'=> $fault->fault_type));	
		$row = array();
		if(is_admin()):
		ob_start();
?>
<div class="text-center">
	<label>
		<input type="checkbox" class="js-switch" <?php checked($fault->approved, 1);?> onclick="approve_switch(this);" data-id="
																																<?php echo $fault->ID;?>" data-action="fault_approve_change"/></label>
	<div style="display:none;">
		<?php echo $fault->approved; ?>
	</div>
</div>
<div style="display:none;">
	<?php echo $fault->approved; ?>
</div>
<?php 
		$checkbox = ob_get_clean();
		array_push($row, $checkbox);
		endif;			
		array_push($row, __($fault->ID));
		array_push($row, __($fault->centre_name));
		array_push($row, __($fault->e_type_name));
		array_push($row, __($fault->equipment_name));
		array_push($row, __($fault->f_type_name));
		array_push($row, date('M d,Y',strtotime($fault->date_of_fault)));
		ob_start();
?>
<div class="text-center">
	<?php if(is_admin()): ?>
	<a href="#" onclick="view_function(this); return false;" data-id="<?php echo $fault->ID;?>" data-action="view_fault" class="btn btn-dark btn-xs"> <i class="fa fa-edit"></i> View </a>
	<a href="#" onclick="edit_function(this); return false;" data-id="<?php echo $fault->ID;?>" data-action="edit_fault" class="btn btn-dark btn-xs"> <i class="fa fa-edit"></i> Edit </a>
	<a href="#" class="btn btn-danger btn-xs" onclick="delete_function(this);" data-id="<?php echo $fault->ID;?>" data-action="delete_fault"> <i class="fa fa-trash"></i> Delete </a>
	<?php else:
		$future = date('d-m-Y',strtotime(' + 2 day', strtotime($fault->created_on)));
		$today = date('d-m-Y');
		if($today == $future):
		if( user_can('view_fault') ): ?>
	<a href="#" onclick="view_function(this); return false;" data-id="<?php echo $fault->ID;?>" data-action="view_fault" class="btn btn-dark btn-xs"> <i class="fa fa-edit"></i> View </a>
	<?php endif; ?>
	<?php else: ?>
	<?php if($this->current__user__id == $fault->user_id):
		if( user_can('edit_fault') ): ?>
	<a href="#" onclick="edit_function(this); return false;" data-id="<?php echo $fault->ID;?>" data-action="edit_fault" class="btn btn-dark btn-xs"> <i class="fa fa-edit"></i> Edit </a>
	<?php endif; ?>
	<?php if( user_can('delete_fault') ): ?> <a href="#" class="btn btn-danger btn-xs" onclick="javascript:delete_function(this);" data-id="<?php echo $fault->ID;?>" data-action="delete_fault"><i class="fa fa-trash"></i> Delete</a>
	<?php endif; ?>
	<?php if( user_can('view_fault') ): ?>
	<a href="#" onclick="view_function(this); return false;" data-id="<?php echo $fault->ID;?>" data-action="view_fault" class="btn btn-dark btn-xs"> <i class="fa fa-edit"></i> View </a>
	<?php endif; ?>

	<?php endif; ?>
	<?php endif; ?>
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
