<?php
// if accessed directly than exit
if(!defined('ABSPATH')) exit;

if( !class_exists('Fault') ):
	class Fault{
		private $database;
		private $current__user__id;
		private $current__user;
		function __construct(){
			global $db;
			$this->database = $db;
			$this->current__user__id = get_current_user_id();
			$this->current__user = get_userdata($this->current__user__id);
		}

		public function add__fault__page(){
			ob_start();
			if( !user_can( 'add_fault') ):
				echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
			else:
			?>
			<form class="add-fault submit-form" method="post" autocomplete="off">
				<div class="row">
					<div class="col-xs-12">
						<h3>
							<?php _e('Centre with Fault');?>
						</h3>
						<hr>
					</div>
					<div class="form-group col-sm-6 col-xs-12">
						<label for="centre">Centre <span class="required"> *</span></label>
						<select name="centre" class="form-control select_single require fetch-centre-equipment-data" tabindex="-1" data-placeholder="Choose centre">
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
					<div class="form-group col-sm-6 col-xs-12">
						<label for="name">Name <span class="required">*</span></label>
						<input type="text" name="name" class="form-control require" value="<?php _e($this->current__user->first_name .' '.$this->current__user->last_name);?>" readonly="readonly" />
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-xs-12">
						<label for="equipment-type">Equipment Type <span class="required"> *</span></label>
						<select name="equipment_type" class="form-control select_single require fetch-equipment-data select-equipment-type" tabindex="-1" data-placeholder="Choose equipment type">
							<?php
							$data = get_tabledata(TBL_EQUIPMENT_TYPES,false,array('approved'=> '1'), 'ORDER BY `name` ASC');
							$option_data = get_option_data($data,array('ID','name'));
							echo get_options_list($option_data);
							?>
						</select>
					</div>
					<div class="form-group col-sm-6 col-xs-12">
						<label for="equipment">Equipment <span class="required"> *</span></label>
						<select name="equipment" class="form-control select_single require select-equipment fetch-service-agent-data" tabindex="-1" data-placeholder="Choose equipment">
							<option value="">Choose equipment</option>
						</select>
					</div>
					<div class="form-group col-sm-12 col-xs-12">
						<label for="decommed">Show Decommed Equipment</label>
						<br/>
						<label><input type="checkbox" class="js-switch show-decommed" /></label>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<h3><?php _e('Fault');?></h3><hr>
					</div>
					<div class="form-group col-sm-6 col-xs-12">
						<label for="fault-type">Fault Type <span class="required"> *</span></label>
						<select name="fault_type" class="form-control select_single require select-fault-type" tabindex="-1" data-placeholder="Choose fault type">
							<option value="">Choose fault type</option>
						</select>
					</div>
					<div class="form-group col-sm-6 col-xs-12">
						<label for="date-of-fault">Date of Fault</label>
						<input type="text" name="date_of_fault" class="form-control input-datepicker" readonly="readonly" />
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-xs-12">
						<label for="current-servicing-agency">Current servicing agency <span class="required"> *</span></label>
						<select name="current_servicing_agency" class="form-control select_single require select-servicing-agency" tabindex="-1" data-placeholder="Choose servicing agency">
							<option value="">Choose servicing agency</option>
						</select>
					</div>
					<div class="form-group col-sm-6 col-xs-12">
						<label for="time-of-fault">Servicing agency at time of fault <span class="required"> *</span></label>
						<input type="text" name="time_of_fault" class="form-control require" />
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-12 col-xs-12">
						<label for="description-of-fault">Description of Fault</label>
						<textarea name="description_of_fault" class="form-control" rows="3">
						</textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<h3><?php _e('Action');?></h3><hr>
					</div>
					<div class="form-group col-sm-6 col-xs-12">
						<label for="">Service Call No</label>
						<br/>
						<input type="text" name="service_call_no" class="form-control require" />
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-12 col-xs-12">
						<label for="">Please details action taken</label>
						<textarea name="action_taken" class="form-control" rows="3">
						</textarea>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-12 col-xs-12">
						<label for="">Fault corrected by user?</label>
						<br/>
						<label><input type="radio" class="flat" name="fault_corrected_by_user" value="1" /> Yes</label>
						<label>&nbsp;</label>
						<label><input type="radio" class="flat" name="fault_corrected_by_user" value="0" checked/> No</label>
					</div>
					<div class="form-group col-sm-12 col-xs-12">
						<label for="">To fix at next service visit?</label>
						<br/>
						<label><input type="radio" class="flat" name="to_fix_at_next_service_visit" value="1" /> Yes</label>
						<label>&nbsp;</label>
						<label><input type="radio" class="flat" name="to_fix_at_next_service_visit" value="0" checked/> No</label>
					</div>
					<div class="form-group col-sm-12 col-xs-12">
						<label for="">Engineer called out?</label>
						<br/>
						<label><input type="radio" class="flat" name="engineer_called_out" value="1" /> Yes</label>
						<label>&nbsp;</label>
						<label><input type="radio" class="flat" name="engineer_called_out" value="0" checked/> No</label>
					</div>
					<div class="form-group col-sm-12 col-xs-12">
						<label for="">Has an adverse incident report been sent to MHRA pr appropriate devolved adminstration?</label>
						<br/>
						<label><input type="radio" class="flat" name="adverse_incident_report" value="1" /> Yes</label>
						<label>&nbsp;</label>
						<label><input type="radio" class="flat" name="adverse_incident_report" value="0" checked/> No</label>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<h3><?php _e('Fault Severity');?></h3>
						<hr>
					</div>
					<div class="form-group col-sm-6 col-xs-12">
						<label for="">Equipment Status</label>
						<br/>
						<select name="equipment_status" class="form-control select_single require" tabindex="-1" data-placeholder="Choose equipment status">
							<?php
							$option_data = get_equipment_status();
							echo get_options_list($option_data);
							?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-xs-12">
						<label for="">Total equipment downtime (days)</label>
						<br/>
						<input type="number" name="equipment_downtime" class="form-control require" min="0" />
					</div>
					<div class="form-group col-sm-6 col-xs-12">
						<label for="">Total screening downtime (days)</label>
						<br/>
						<input type="number" name="screening_downtime" class="form-control require" min="0" />
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-xs-12">
						<label for="">Number of repeat images</label>
						<br/>
						<input type="number" name="repeat_images" class="form-control require" min="0" />
					</div>
					<div class="form-group col-sm-6 col-xs-12">
						<label for="">Number of cancelled women</label>
						<br/>
						<input type="number" name="cancelled_women" class="form-control require" min="0" />
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-xs-12">
						<label for="">Number of technical recalls</label>
						<br/>
						<input type="number" name="technical_recalls" class="form-control require" min="0" />
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-12 col-xs-12">
						<label for="">Are you satisfied with response of the servicing organisation?</label>
						<br/>
						<label><input type="radio" class="flat" name="satisfied_servicing_organisation" value="1" /> Yes</label>
						<label>&nbsp;</label>
						<label><input type="radio" class="flat" name="satisfied_servicing_organisation" value="0" /> No</label>
						<label>&nbsp;</label>
						<label><input type="radio" class="flat" name="satisfied_servicing_organisation" value="2" checked/> N/A</label>
					</div>
					<div class="form-group col-sm-12 col-xs-12">
						<label for="">Are you satisfied with the performance of the service engineer?</label>
						<br/>
						<label><input type="radio" class="flat" name="satisfied_service_engineer" value="1" /> Yes</label>
						<label>&nbsp;</label>
						<label><input type="radio" class="flat" name="satisfied_service_engineer" value="0" /> No</label>
						<label>&nbsp;</label>
						<label><input type="radio" class="flat" name="satisfied_service_engineer" value="2" checked/> N/A</label>
					</div>
					<div class="form-group col-sm-12 col-xs-12">
						<label for="">Are you generally satisfied withe the reliability/performance of the equipment?</label>
						<br/>
						<label><input type="radio" class="flat" name="satisfied_equipment" value="1" /> Yes</label>
						<label>&nbsp;</label>
						<label><input type="radio" class="flat" name="satisfied_equipment" value="0" /> No</label>
						<label>&nbsp;</label>
						<label><input type="radio" class="flat" name="satisfied_equipment" value="2" checked/> N/A</label>
					</div>
				</div>
				<div class="ln_solid"></div>
				<div class="form-group">
					<input type="hidden" name="action" value="add_new_fault" />
					<button class="btn btn-success btn-md" type="submit">Create New Fault</button>
				</div>
			</form>
			<?php endif; ?>
			<?php
			$content = ob_get_clean();
			return $content;
		}

		public function edit__fault__page(){
			ob_start();
			$fault__id = $_GET['id'];
			$fault = get_tabledata(TBL_FAULTS,true,array('ID'=> $fault__id));
			if( !user_can( 'edit_fault') ):
				echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
			elseif(!$fault):
				echo page_not_found('Oops ! Fault details Not Found.','Please go back and check again !');
			else:
			?>
			<form class="edit-fault submit-form" method="post" autocomplete="off">
				<div class="row">
					<div class="col-xs-12">
						<h3><?php _e('Centre with Fault');?></h3>
						<hr>
					</div>
					<div class="form-group col-sm-6 col-xs-12">
						<label for="centre">Centre <span class="required"> *</span></label>
						<select name="centre" class="form-control select_single require fetch-centre-equipment-data" tabindex="-1" data-placeholder="Choose centre">
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
							echo get_options_list($option_data, maybe_unserialize($fault->centre));
							?>
						</select>
					</div>
					<div class="form-group col-sm-6 col-xs-12">
						<label for="name">Name <span class="required">*</span></label>
						<input type="text" name="name" class="form-control require" value="<?php _e($fault->name);?>" readonly="readonly" />
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-xs-12">
						<label for="equipment-type">Equipment Type <span class="required"> *</span></label>
						<select name="equipment_type" class="form-control select_single require fetch-equipment-data select-equipment-type" tabindex="-1" data-placeholder="Choose equipment type">
							<?php
							$data = get_tabledata(TBL_EQUIPMENT_TYPES,false,array('approved'=> '1'), 'ORDER BY `name` ASC');
							$option_data = get_option_data($data,array('ID','name'));
							echo get_options_list($option_data, maybe_unserialize($fault->equipment_type));
							?>
						</select>
					</div>
					<div class="form-group col-sm-6 col-xs-12">
						<label for="equipment">Equipment <span class="required"> *</span></label>
						<select name="equipment" class="form-control select_single require select-equipment fetch-service-agent-data" tabindex="-1" data-placeholder="Choose equipment">
							<?php
							$data = get_tabledata(TBL_EQUIPMENTS,false,array( 'equipment_type' => $fault->equipment_type, 'centre'=> $fault->centre ,'approved' => '1'), 'ORDER BY `name` ASC');
							$option_data = get_option_data($data,array('ID','name'));
							echo get_options_list($option_data, maybe_unserialize($fault->equipment));
							?>
						</select>
					</div>
					<div class="form-group col-sm-12 col-xs-12">
						<label for="decommed">Show Decommed Equipment</label>
						<br/>
						<label><input type="checkbox" class="js-switch show-decommed" /></label>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<h3><?php _e('Fault');?></h3>
						<hr>
					</div>
					<div class="form-group col-sm-6 col-xs-12">
						<label for="fault-type">Fault Type <span class="required">*</span></label>
						<select name="fault_type" class="form-control select_single require select-fault-type" tabindex="-1" data-placeholder="Choose fault type">
							<?php
							$query= "where `equipment_type` LIKE '%".$fault->equipment_type."%' AND `approved` = '1' ORDER BY `name` ASC";
							$data = get_tabledata(TBL_FAULT_TYPES, false, array() , $query);
							$option_data = get_option_data($data,array('ID','name'));
							echo get_options_list($option_data ,maybe_unserialize($fault->fault_type));
							?>
						</select>
					</div>
					<div class="form-group col-sm-6 col-xs-12">
						<label for="date-of-fault">Date of Fault</label>
						<input type="text" name="date_of_fault" class="form-control input-datepicker" readonly="readonly" value="<?php echo ($fault->date_of_fault != '') ? date('M d, Y', strtotime($fault->date_of_fault)) : '';?>" />
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-xs-12">
						<label for="current-servicing-agency">Current servicing agency <span class="required">*</span></label>
						<select name="current_servicing_agency" class="form-control select_single require select-servicing-agency" tabindex="-1" data-placeholder="Choose servicing agency">
							<?php
							$equipment = get_tabledata(TBL_EQUIPMENTS, true, array('ID'=>$fault->equipment) );
							$data = get_tabledata(TBL_SERVICE_AGENTS, false, array('ID'=> $equipment->service_agent ));
							$option_data = get_option_data($data,array('ID','name'));
							echo get_options_list($option_data ,maybe_unserialize($fault->current_servicing_agency));
							?>
						</select>
					</div>
					<div class="form-group col-sm-6 col-xs-12">
						<label for="time-of-fault">Servicing agency at time of fault <span class="required">*</span></label>
						<input type="text" name="time_of_fault" class="form-control require" value="<?php _e($fault->time_of_fault);?>" />
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-12 col-xs-12">
						<label for="description-of-fault">Description of Fault</label>
						<textarea name="description_of_fault" class="form-control" rows="3">
							<?php _e($fault->description_of_fault);?>
						</textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<h3><?php _e('Action');?></h3>
						<hr>
					</div>
					<div class="form-group col-sm-6 col-xs-12">
						<label for="">Service Call No</label>
						<br/>
						<input type="text" name="service_call_no" class="form-control require" value="<?php _e($fault->service_call_no);?>" />
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-12 col-xs-12">
						<label for="">Please details action taken</label>
						<textarea name="action_taken" class="form-control" rows="3"><?php _e($fault->action_taken);?></textarea>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-12 col-xs-12">
						<label for="">Fault corrected by user?</label>
						<br/>
						<label>
							<input type="radio" class="flat" name="fault_corrected_by_user" value="1" <?php checked($fault->fault_corrected_by_user,'1');?> /> Yes
						</label>
						<label>
							&nbsp;
						</label>
						<label>
							<input type="radio" class="flat" name="fault_corrected_by_user" value="0" <?php checked($fault->fault_corrected_by_user,'0');?> /> No
						</label>
					</div>
					<div class="form-group col-sm-12 col-xs-12">
						<label for="">To fix at next service visit?</label>
						<br/>
						<label>
							<input type="radio" class="flat" name="to_fix_at_next_service_visit" value="1" <?php checked($fault->to_fix_at_next_service_visit,'1');?> /> Yes
						</label>
						<label>
							&nbsp;
						</label>
						<label>
							<input type="radio" class="flat" name="to_fix_at_next_service_visit" value="0" <?php checked($fault->to_fix_at_next_service_visit,'0');?> /> No
						</label>
					</div>
					<div class="form-group col-sm-12 col-xs-12">
						<label for="">Engineer called out?</label>
						<br/>
						<label>
							<input type="radio" class="flat" name="engineer_called_out" value="1" <?php checked($fault->engineer_called_out,'1');?> /> Yes
						</label>
						<label>
							&nbsp;
						</label>
						<label>
							<input type="radio" class="flat" name="engineer_called_out" value="0" <?php checked($fault->engineer_called_out,'0');?> /> No
						</label>
					</div>
					<div class="form-group col-sm-12 col-xs-12">
						<label for="">
							Has an adverse incident report been sent to MHRA pr appropriate devolved adminstration?
						</label>
						<br/>
						<label>
							<input type="radio" class="flat" name="adverse_incident_report" value="1" <?php checked($fault->adverse_incident_report,'1');?> /> Yes
						</label>
						<label>
							&nbsp;
						</label>
						<label>
							<input type="radio" class="flat" name="adverse_incident_report" value="0" <?php checked($fault->adverse_incident_report,'0');?> /> No
						</label>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<h3><?php _e('Fault Severity');?></h3>
						<hr>
					</div>
					<div class="form-group col-sm-6 col-xs-12">
						<label for="">Equipment Status</label>
						<br/>
						<select name="equipment_status" class="form-control select_single require" tabindex="-1" data-placeholder="Choose equipment status">
							<?php
							$option_data = get_equipment_status();
							echo get_options_list($option_data ,maybe_unserialize($fault->equipment_status));
							?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-xs-12">
						<label for="">Total equipment downtime (days)</label>
						<br/>
						<input type="number" name="equipment_downtime" class="form-control require" min="0" value="<?php _e($fault->equipment_downtime);?>" />
					</div>
					<div class="form-group col-sm-6 col-xs-12">
						<label for="">Total screening downtime (days)</label>
						<br/>
						<input type="number" name="screening_downtime" class="form-control require" min="0" value="<?php _e($fault->screening_downtime);?>" />
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-xs-12">
						<label for="">Number of repeat images</label>
						<br/>
						<input type="number" name="repeat_images" class="form-control require" min="0" value="<?php _e($fault->repeat_images);?>" />
					</div>
					<div class="form-group col-sm-6 col-xs-12">
						<label for="">Number of cancelled women</label>
						<br/>
						<input type="number" name="cancelled_women" class="form-control require" min="0" value="<?php _e($fault->cancelled_women);?>" />
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-xs-12">
						<label for="">Number of technical recalls</label>
						<br/>
						<input type="number" name="technical_recalls" class="form-control require" min="0" value="<?php _e($fault->technical_recalls);?>" />
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-12 col-xs-12">
						<label for="">Are you satisfied with response of the servicing organisation?</label>
						<br/>
						<label>
							<input type="radio" class="flat" name="satisfied_servicing_organisation" value="1" <?php checked($fault->satisfied_servicing_organisation,'1');?> /> Yes
						</label>
						<label>
							&nbsp;
						</label>
						<label>
							<input type="radio" class="flat" name="satisfied_servicing_organisation" value="0" <?php checked($fault->satisfied_servicing_organisation,'0');?> /> No
						</label>
						<label>
							&nbsp;
						</label>
						<label>
							<input type="radio" class="flat" name="satisfied_servicing_organisation" value="2" <?php checked($fault->satisfied_servicing_organisation,'2');?> /> N/A
						</label>
					</div>
					<div class="form-group col-sm-12 col-xs-12">
						<label for="">Are you satisfied with the performance of the service engineer?</label>
						<br/>
						<label>
							<input type="radio" class="flat" name="satisfied_service_engineer" value="1" <?php checked($fault->satisfied_service_engineer,'1');?> /> Yes
						</label>
						<label>
							&nbsp;
						</label>
						<label>
							<input type="radio" class="flat" name="satisfied_service_engineer" value="0" <?php checked($fault->satisfied_service_engineer,'0');?> /> No
						</label>
						<label>
							&nbsp;
						</label>
						<label>
							<input type="radio" class="flat" name="satisfied_service_engineer" value="2" <?php checked($fault->satisfied_service_engineer,'2');?> /> N/A
						</label>
					</div>
					<div class="form-group col-sm-12 col-xs-12">
						<label for="">Are you generally satisfied withe the reliability/performance of the equipment?</label>
						<br/>
						<label>
							<input type="radio" class="flat" name="satisfied_equipment" value="1" <?php checked($fault->satisfied_equipment,'1');?> /> Yes
						</label>
						<label>
							&nbsp;
						</label>
						<label>
							<input type="radio" class="flat" name="satisfied_equipment" value="0" <?php checked($fault->satisfied_equipment,'0');?> /> No
						</label>
						<label>
							&nbsp;
						</label>
						<label>
							<input type="radio" class="flat" name="satisfied_equipment" value="2" <?php checked($fault->satisfied_equipment,'2');?> /> N/A
						</label>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<h3><?php _e('Approved');?></h3>
						<hr>
					</div>
					<div class="form-group col-sm-12 col-xs-12">
						<label for="">Approved?</label>
						<br/>
						<label>
							<input type="radio" class="flat" name="approved" value="1" <?php checked($fault->approved,'1');?> /> Yes
						</label>
						<label>
							&nbsp;
						</label>
						<label>
							<input type="radio" class="flat" name="approved" value="0" <?php checked($fault->approved,'0');?> /> No
						</label>
					</div>
				</div>
				<div class="ln_solid">
				</div>
				<div class="form-group">
					<input type="hidden" name="action" value="update_fault" />
					<input type="hidden" name="fault_id" value="<?php echo $fault->ID;?>" />
					<button class="btn btn-success btn-md" type="submit">Update Fault</button>
				</div>
			</form>
			<?php endif; ?>
			<?php
			$content = ob_get_clean();
			return $content;
		}

		public function view__fault__page(){
			ob_start();
			$fault__id = $_GET['id'];
			$query = '';
			if(!is_admin()):
			$centres = maybe_unserialize($this->current__user->centre);
			if(!empty($centres))
			{
				$centres = implode(',',$centres);
				$query = "WHERE `centre` IN (".$centres.")";
			}
			endif;
			$query .= ($query != '') ? ' AND ' : ' WHERE ';
			$query .= " `ID` = ".$fault__id." ";
			$fault = get_tabledata(TBL_FAULTS,true,array(), $query);
			if( !user_can( 'edit_fault') ):
			echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
			elseif(!$fault):
			echo page_not_found('Oops ! Fault details not found.','Please go back and check again !');
			else:
			$centre = get_tabledata(TBL_CENTRES,true, array('ID'=> $fault->centre));
			$equipment_type = get_tabledata(TBL_EQUIPMENT_TYPES,true, array('ID'=> $fault->equipment_type));
			$equipment = get_tabledata(TBL_EQUIPMENTS,true, array('ID'=> $fault->equipment));
			$fault_type = get_tabledata(TBL_FAULT_TYPES,true, array('ID'=> $fault->fault_type));
			$service_agent = get_tabledata(TBL_SERVICE_AGENTS, true, array('ID'=> $fault->current_servicing_agency));
			?>
			<div class="text-center">
				<h3>
					<?php _e('Fault Report');?>
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
							<?php _e($fault->name);?>
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
							<?php _e('Equipment Type');?>
						</td>
						<td>
							<?php _e($equipment_type->name);?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Equipment');?>
						</td>
						<td>
							<?php _e($equipment->name);?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Fault Type');?>
						</td>
						<td>
							<?php _e($fault_type->name);?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Date of Fault');?>
						</td>
						<td>
							<?php echo ($fault->date_of_fault != '') ? date('M d, Y', strtotime($fault->date_of_fault)) : '';?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Current servicing agency');?>
						</td>
						<td>
							<?php _e($service_agent->name);?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Servicing agency at time of fault');?>
						</td>
						<td>
							<?php _e($fault->time_of_fault);?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Description of Fault');?>
						</td>
						<td>
							<?php _e($fault->description_of_fault);?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Service Call No');?>
						</td>
						<td>
							<?php _e($fault->service_call_no);?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Action Taken');?>
						</td>
						<td>
							<?php _e($fault->action_taken);?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Fault corrected by user?');?>
						</td>
						<td>
							<?php echo ($fault->fault_corrected_by_user == 1) ? 'Yes' : 'No'; ?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('To fix at next service visit?');?>
						</td>
						<td>
							<?php echo ($fault->to_fix_at_next_service_visit == 1) ? 'Yes' : 'No'; ?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Engineer called out?');?>
						</td>
						<td>
							<?php echo ($fault->engineer_called_out == 1) ? 'Yes' : 'No'; ?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Has an adverse incident report been sent to MHRA pr appropriate devolved adminstration?');?>
						</td>
						<td>
							<?php echo ($fault->adverse_incident_report == 1) ? 'Yes' : 'No'; ?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Equipment Status');?>
						</td>
						<td>
							<?php echo get_equipment_status($fault->equipment_status);?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Total equipment downtime (days)');?>
						</td>
						<td>
							<?php _e($fault->equipment_downtime);?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Total screening downtime (days)');?>
						</td>
						<td>
							<?php _e($fault->screening_downtime);?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Number of repeat images');?>
						</td>
						<td>
							<?php _e($fault->repeat_images);?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Number of cancelled women');?>
						</td>
						<td>
							<?php _e($fault->cancelled_women);?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Number of technical recalls');?>
						</td>
						<td>
							<?php _e($fault->technical_recalls);?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Are you satisfied with response of the servicing organisation?');?>
						</td>
						<?php
						$satisfied_servicing_organisation = $fault->satisfied_servicing_organisation;
						$value = '';
						switch($satisfied_servicing_organisation):
						case '0' : $value = 'No'; break;
						case '1' : $value = 'Yes'; break;
						case '2' : $value = 'N/A'; break;
						endswitch;
						?>
						<td>
							<?php echo $value; ?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Are you satisfied with the performance of the service engineer?');?>
						</td>
						<?php
						$satisfied_service_engineer = $fault->satisfied_service_engineer;
						$value = '';
						switch($satisfied_service_engineer):
						case '0' : $value = 'No'; break;
						case '1' : $value = 'Yes'; break;
						case '2' : $value = 'N/A'; break;
						endswitch;
						?>
						<td>
							<?php echo $value; ?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Are you generally satisfied withe the reliability/performance of the equipment?');?>
						</td>
						<?php
						$satisfied_equipment = $fault->satisfied_equipment;
						$value = '';
						switch($satisfied_equipment):
						case '0' : $value = 'No'; break;
						case '1' : $value = 'Yes'; break;
						case '2' : $value = 'N/A'; break;
						endswitch;
						?>
						<td>
							<?php echo $value; ?>
						</td>
					</tr>
					<tr>
						<td>
							<?php _e('Approved');?>
						</td>
						<td>
							<?php echo ($fault->approved == 1) ? 'Yes' : 'No'; ?>
						</td>
					</tr>
				</tbody>
			</table>
			<?php endif; ?>
			<?php
			$content = ob_get_clean();
			return $content;
		}

		public function all__faults__page(){
			ob_start();
			$query = '';
			if(!is_admin()):
				$centres = maybe_unserialize($this->current__user->centre);
				if(!empty($centres)){
					$centres = implode(',',$centres);
					$query = "WHERE `centre` IN (".$centres.")";
				}
			endif;
			$faults = get_tabledata(TBL_FAULTS,false,array(), $query);
			if( !user_can('view_fault') ):
				echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
			elseif(!$faults):
				echo page_not_found("There are no new faults record found",' ',false);
			else:
			?>
			<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap datatable-buttons" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Name</th>
						<th>Centre</th>
						<th>Equipment Type</th>
						<th>Equipment</th>
						<th>Fault Type</th>
						<th>Date of Fault</th>
						<th>Created On</th>
						<?php if(is_admin()): ?>
						<th>Approved</th>
						<?php endif; ?>
						<th class="text-center">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php if($faults): foreach($faults as $fault):
						$centre = get_tabledata(TBL_CENTRES,true,array('ID'=> $fault->centre));
						$equipment_type = get_tabledata(TBL_EQUIPMENT_TYPES,true,array('ID'=> $fault->equipment_type));
						$equipment = get_tabledata(TBL_EQUIPMENTS,true,array('ID'=> $fault->equipment));
						$fault_type = get_tabledata(TBL_FAULT_TYPES,true,array('ID'=> $fault->fault_type));
					?>
					<tr>
						<td><?php _e($fault->name);?></td>
						<td><?php _e($centre->name);?></td>
						<td><?php _e($equipment_type->name);?></td>
						<td><?php _e($equipment->name);?></td>
						<td><?php _e($fault_type->name);?></td>
						<td><?php echo date('M d,Y',strtotime($fault->date_of_fault));?></td>
						<td><?php echo date('M d,Y',strtotime($fault->created_on));?></td>
						<?php if(is_admin()): ?>
						<td class="text-center">
							<label><input type="checkbox" class="js-switch" <?php checked($fault->approved, 1);?> onClick="javascript:approve_switch(this);" data-id="<?php echo $fault->ID;?>" data-action="fault_approve_change"/></label>
						</td>
						<?php endif; ?>
						<td class="text-center">
							<?php if(is_admin()): ?>
								<a href="<?php echo site_url();?>/view-fault/?id=<?php echo $fault->ID;?>" class="btn btn-dark btn-xs">
									<i class="fa fa-edit"></i> View
								</a>
								<a href="<?php echo site_url();?>/edit-fault/?id=<?php echo $fault->ID;?>" class="btn btn-dark btn-xs">
									<i class="fa fa-edit"></i> Edit
								</a>
								<a href="#" class="btn btn-danger btn-xs" onclick="javascript:delete_function(this);" data-id="<?php echo $fault->ID;?>" data-action="delete_fault"><i class="fa fa-trash"></i> Delete
								</a>
							<?php else: ?>
								<?php 
								$future = date('d-m-Y',strtotime(' + 2 day', strtotime($fault->created_on)));
								$today = date('d-m-Y');
								if($today == $future):
									if( user_can('view_fault') ): ?>
									<p>Overdue </p>
									<a href="<?php echo site_url();?>/view-fault/?id=<?php echo $fault->ID;?>" class="btn btn-dark btn-xs"><i class="fa fa-edit"></i> View</a>
									<?php endif; ?>
								<?php else: ?>
									<?php if($this->current__user__id == $fault->user_id):
										if( user_can('edit_fault') ): ?>
										<a href="<?php echo site_url();?>/edit-fault/?id=<?php echo $fault->ID;?>" class="btn btn-dark btn-xs">
											<i class="fa fa-edit"></i> Edit
										</a>
										<?php endif; ?>
										<?php if( user_can('delete_fault') ): ?>
										<a href="#" class="btn btn-danger btn-xs" onclick="javascript:delete_function(this);" data-id="<?php echo $fault->ID;?>" data-action="delete_fault"><i class="fa fa-trash"></i> Delete</a>
										<?php endif; ?>
									<?php else: ?>
										<?php if( user_can('view_fault') ): ?>
										<a href="<?php echo site_url();?>/view-fault/?id=<?php echo $fault->ID;?>" class="btn btn-dark btn-xs">
											<i class="fa fa-edit">
											</i>View
										</a>
										<?php endif; ?>
									<?php endif; ?>
								<?php endif; ?>
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
        
        
        
        
        
        
        
        
        		public function all__faults__page__off(){
			ob_start();
			$query = '';
			if(!is_admin()):
				$centres = maybe_unserialize($this->current__user->centre);
				if(!empty($centres)){
					$centres = implode(',',$centres);
					$query = "WHERE `centre` IN (".$centres.")";
                    
				}
			endif;
			$faults = get_tabledata(TBL_FAULTS,false,array('approved'=>0), $query);
			if( !user_can('view_fault') ):
				echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
			elseif(!$faults):
				echo page_not_found("There are no new faults record found",' ',false);
			else:
			?>
			<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap datatable-buttons" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Name</th>
						<th>Centre</th>
						<th>Equipment Type</th>
						<th>Equipment</th>
						<th>Fault Type</th>
						<th>Date of Fault</th>
						<th>Created On</th>
						<?php if(is_admin()): ?>
						<th>Approved</th>
						<?php endif; ?>
						<th class="text-center">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php if($faults): foreach($faults as $fault):
						$centre = get_tabledata(TBL_CENTRES,true,array('ID'=> $fault->centre));
						$equipment_type = get_tabledata(TBL_EQUIPMENT_TYPES,true,array('ID'=> $fault->equipment_type));
						$equipment = get_tabledata(TBL_EQUIPMENTS,true,array('ID'=> $fault->equipment));
						$fault_type = get_tabledata(TBL_FAULT_TYPES,true,array('ID'=> $fault->fault_type));
					?>
					<tr>
						<td><?php _e($fault->name);?></td>
						<td><?php _e($centre->name);?></td>
						<td><?php _e($equipment_type->name);?></td>
						<td><?php _e($equipment->name);?></td>
						<td><?php _e($fault_type->name);?></td>
						<td><?php echo date('M d,Y',strtotime($fault->date_of_fault));?></td>
						<td><?php echo date('M d,Y',strtotime($fault->created_on));?></td>
						<?php if(is_admin()): ?>
						<td class="text-center">
							<label><input type="checkbox" class="js-switch" <?php checked($fault->approved, 1);?> onClick="javascript:approve_switch(this);" data-id="<?php echo $fault->ID;?>" data-action="fault_approve_change"/></label>
						</td>
						<?php endif; ?>
						<td class="text-center">
							<?php if(is_admin()): ?>
								<a href="<?php echo site_url();?>/view-fault/?id=<?php echo $fault->ID;?>" class="btn btn-dark btn-xs">
									<i class="fa fa-edit"></i> View
								</a>
								<a href="<?php echo site_url();?>/edit-fault/?id=<?php echo $fault->ID;?>" class="btn btn-dark btn-xs">
									<i class="fa fa-edit"></i> Edit
								</a>
								<a href="#" class="btn btn-danger btn-xs" onclick="javascript:delete_function(this);" data-id="<?php echo $fault->ID;?>" data-action="delete_fault"><i class="fa fa-trash"></i> Delete
								</a>
							<?php else: ?>
								<?php 
								$future = date('d-m-Y',strtotime(' + 2 day', strtotime($fault->created_on)));
								$today = date('d-m-Y');
								if($today == $future):
									if( user_can('view_fault') ): ?>
									<p>Overdue </p>
									<a href="<?php echo site_url();?>/view-fault/?id=<?php echo $fault->ID;?>" class="btn btn-dark btn-xs"><i class="fa fa-edit"></i> View</a>
									<?php endif; ?>
								<?php else: ?>
									<?php if($this->current__user__id == $fault->user_id):
										if( user_can('edit_fault') ): ?>
										<a href="<?php echo site_url();?>/edit-fault/?id=<?php echo $fault->ID;?>" class="btn btn-dark btn-xs">
											<i class="fa fa-edit"></i> Edit
										</a>
										<?php endif; ?>
										<?php if( user_can('delete_fault') ): ?>
										<a href="#" class="btn btn-danger btn-xs" onclick="javascript:delete_function(this);" data-id="<?php echo $fault->ID;?>" data-action="delete_fault"><i class="fa fa-trash"></i> Delete</a>
										<?php endif; ?>
									<?php else: ?>
										<?php if( user_can('view_fault') ): ?>
										<a href="<?php echo site_url();?>/view-fault/?id=<?php echo $fault->ID;?>" class="btn btn-dark btn-xs">
											<i class="fa fa-edit">
											</i>View
										</a>
										<?php endif; ?>
									<?php endif; ?>
								<?php endif; ?>
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

		public function add__fault__type__page(){
			ob_start();
			if( !user_can( 'add_fault_type') ):
				echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
			else:
			?>
			<form class="add-fault_type submit-form" method="post" autocomplete="off">
				<div class="form-group">
					<label for="name">Name <span class="required">*</span></label>
					<input type="text" name="name" class="form-control require" />
				</div>
				<div class="form-group">
					<label for="equipment-type">Equipment Type <span class="required">*</span></label>
					<select name="equipment_type[]" class="form-control select_single require" tabindex="-1" data-placeholder="Choose equipment type" multiple="multiple">
						<?php
						$data = get_tabledata(TBL_EQUIPMENT_TYPES,false,array('approved'=> '1'), 'ORDER BY `name` ASC');
						$option_data = get_option_data($data,array('ID','name'));
						echo get_options_list($option_data);
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="description">Description</label>
					<textarea name="description" class="form-control" rows="5"></textarea>
				</div>
				<div class="ln_solid">
				</div>
				<div class="form-group">
					<input type="hidden" name="action" value="add_new_fault_type" />
					<button class="btn btn-success btn-md" type="submit">Create New Fault Type</button>
				</div>
			</form>
			<?php endif; ?>
			<?php
			$content = ob_get_clean();
			return $content;
		}

		public function edit__fault__type__page(){
			ob_start();
			$fault__type__id = $_GET['id'];
			$fault__type = get_tabledata(TBL_FAULT_TYPES,true,array('ID'=> $fault__type__id));
			if( !user_can( 'edit_fault_type') ):
				echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
			elseif(!$fault__type):
				echo page_not_found('Oops ! Fault type details Not Found.','Please go back and check again !');
			else:
			?>
			<form class="edit-fault-type submit-form" method="post" autocomplete="off">
				<div class="form-group">
					<label for="name">Name <span class="required">*</span></label>
					<input type="text" name="name" class="form-control require" value="<?php _e($fault__type->name);?>" />
				</div>
				<div class="form-group">
					<label for="equipment-type">Equipment Type<span class="required">*</span></label>
					<select name="equipment_type[]" class="form-control select_single require" tabindex="-1" data-placeholder="Choose equipment type" multiple="multiple">
						<?php
						$data = get_tabledata(TBL_EQUIPMENT_TYPES,false,array('approved'=> '1'), 'ORDER BY `name` ASC');
						$option_data = get_option_data($data,array('ID','name'));
						echo get_options_list($option_data,maybe_unserialize($fault__type->equipment_type));
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="description">Description</label>
					<textarea name="description" class="form-control" rows="5"><?php _e($fault__type->description);?></textarea>
				</div>
				<div class="ln_solid"></div>
				<div class="form-group">
					<input type="hidden" name="action" value="update_fault_type" />
					<input type="hidden" name="fault_type_id" value="<?php echo $fault__type->ID;?>" />
					<button class="btn btn-success btn-md" type="submit">Update Fault Type</button>
				</div>
			</form>
			<?php endif; ?>
			<?php
			$content = ob_get_clean();
			return $content;
		}

		public function all__fault__types__page(){
			ob_start();
			$args = array();
			$fault_types = get_tabledata(TBL_FAULT_TYPES,false,$args);

			if( !user_can('view_fault_type') ):
				echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
			elseif(!$fault_types):
				echo page_not_found("There are no new fault types record found",' ',false);
			else:
			?>
			<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap datatable-buttons" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Fault Type</th>
						<th>Fault Type Description</th>
						<th>Created On</th>
						<?php if(is_admin()): ?>
						<th>Approved</th>
						<?php endif; ?>
						<th class="text-center">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php if($fault_types): foreach($fault_types as $fault_type):
					?>
					<tr>
						<td><?php _e($fault_type->name);?></td>
                        <td><?php _e($fault_type->description);?></td>
						<td><?php echo date('M d,Y',strtotime($fault_type->created_on));?></td>
						<?php if(is_admin()): ?>
						<td class="text-center">
							<label><input type="checkbox" class="js-switch" <?php checked($fault_type->approved, 1);?> onClick="javascript:approve_switch(this);" data-id="<?php echo $fault_type->ID;?>" data-action="fault_type_approve_change"/></label>
						</td>
						<?php endif; ?>
						<td class="text-center">
							<?php if( user_can('edit_fault_type') ): ?>
								<a href="<?php echo site_url();?>/edit-fault-type/?id=<?php echo $fault_type->ID;?>" class="btn btn-dark btn-xs"> <i class="fa fa-edit"></i> Edit</a>
							<?php endif; ?>
							<?php if( user_can('delete_fault_type') ): ?>
							<a href="#" class="btn btn-danger btn-xs" onclick="javascript:delete_function(this);" data-id="<?php echo $fault_type->ID;?>" data-action="delete_fault_type"><i class="fa fa-trash"></i> Delete</a>
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
		public function add__fault__process(){
			extract($_POST);
			$return = array(
				'status' => 0,
				'message_heading'=> 'Failed !',
				'message' => 'Could not create fault, Please try again.',
				'reset_form' => 0
			);
			if( user_can('add_fault') ):
				$guid = get_guid(TBL_FAULTS);
				$result = $this->database->insert(TBL_FAULTS,
					array(
						'ID' => $guid,
						'centre' => $centre,
						'name' => $name,
						'user_id' => $this->current__user__id,
						'equipment_type' => $equipment_type,
						'equipment' => $equipment,
						'fault_type' => $fault_type,
						'date_of_fault' => date('Y-m-d h:i:s',strtotime($date_of_fault) ) ,
						'current_servicing_agency' => $current_servicing_agency,
						'time_of_fault' => $time_of_fault,
						'description_of_fault' => $description_of_fault,
						'service_call_no' => $service_call_no,
						'action_taken' => $action_taken,
						'fault_corrected_by_user' => $fault_corrected_by_user,
						'to_fix_at_next_service_visit' => $to_fix_at_next_service_visit,
						'to_fix_at_next_service_visit' => $to_fix_at_next_service_visit,
						'engineer_called_out' => $engineer_called_out,
						'adverse_incident_report' => $adverse_incident_report,
						'equipment_status' => $equipment_status,
						'equipment_downtime' => $equipment_downtime,
						'screening_downtime' => $screening_downtime,
						'repeat_images' => $repeat_images,
						'cancelled_women' => $cancelled_women,
						'technical_recalls' => $technical_recalls,
						'satisfied_servicing_organisation'=> $satisfied_servicing_organisation,
						'satisfied_service_engineer' => $satisfied_service_engineer,
						'satisfied_equipment' => $satisfied_equipment,
						'approved' => 0
					)
				);
				if($result):
					$notification_args = array(
						'title' => 'New fault created',
						'notification'=> 'You have successfully created a new fault ('.$name.').',
					);

					add_user_notification($notification_args);
					$return['status'] = 1;
					$return['message_heading'] = 'Success !';
					$return['message'] = 'Fault has been created successfully.';
					$return['reset_form'] = 1;
				endif;
			endif;

			return json_encode($return);
		}

		public function update__fault__process(){
			extract($_POST);
			$return = array(
				'status' => 0,
				'message_heading'=> 'Failed !',
				'message' => 'Could not update fault, Please try again.',
				'reset_form' => 0
			);
			if( user_can('edit_fault') ):
				$result = $this->database->update(TBL_FAULTS,
					array(
						'centre' => $centre,
						'name' => $name,
						'equipment_type' => $equipment_type,
						'equipment' => $equipment,
						'fault_type' => $fault_type,
						'date_of_fault' => date('Y-m-d h:i:s',strtotime($date_of_fault) ) ,
						'current_servicing_agency' => $current_servicing_agency,
						'time_of_fault' => $time_of_fault,
						'description_of_fault' => $description_of_fault,
						'service_call_no' => $service_call_no,
						'action_taken' => $action_taken,
						'fault_corrected_by_user' => $fault_corrected_by_user,
						'to_fix_at_next_service_visit' => $to_fix_at_next_service_visit,
						'to_fix_at_next_service_visit' => $to_fix_at_next_service_visit,
						'engineer_called_out' => $engineer_called_out,
						'adverse_incident_report' => $adverse_incident_report,
						'equipment_status' => $equipment_status,
						'equipment_downtime' => $equipment_downtime,
						'screening_downtime' => $screening_downtime,
						'repeat_images' => $repeat_images,
						'cancelled_women' => $cancelled_women,
						'technical_recalls' => $technical_recalls,
						'satisfied_servicing_organisation'=> $satisfied_servicing_organisation,
						'satisfied_service_engineer' => $satisfied_service_engineer,
						'satisfied_equipment' => $satisfied_equipment,
						'approved' => $approved
					),
					array(
						'ID'=> $fault_id
					)
				);

				if($result):
					$notification_args = array(
						'title' => 'Fault updated',
						'notification'=> 'You have successfully updated fault ('.$name.').',
					);

					add_user_notification($notification_args);
					$return['status'] = 1;
					$return['message_heading'] = 'Success !';
					$return['message'] = 'Fault has been updated successfully.';
				endif;
			endif;
			return json_encode($return);
		}

		public function delete__fault__process(){
			extract($_POST);
			$id = trim($id);
			if( user_can('delete_fault') ):
				$data = get_tabledata(TBL_FAULTS,true,array('ID'=> $id) ) ;
				$args = array('ID'=> $id);
				$result = $this->database->delete(TBL_FAULTS,$args);
				if($result):
					$notification_args = array(
						'title' => 'Fault deleted',
						'notification'=> 'You have successfully deleted ('.$data->name.') fault.',
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

		public function add__fault__type__process(){
			extract($_POST);
			$return = array(
				'status' => 0,
				'message_heading'=> 'Failed !',
				'message' => 'Could not create fault type, Please try again.',
				'reset_form' => 0
			);
			if( user_can('add_fault_type') ):
				$validation_args = array(
					'name'=> $name,
				);

				if(is_value_exists(TBL_FAULT_TYPES,$validation_args)):
					$return['status'] = 2;
					$return['message_heading'] = 'Failed !';
					$return['message'] = 'Fault type name you entered is already exists, please try another name.';
					$return['fields'] = array('name');
				else:
					$guid = get_guid(TBL_FAULT_TYPES);
					$result = $this->database->insert(TBL_FAULT_TYPES,
						array(
							'ID' => $guid,
							'name' => $name,
							'description' => $description,
							'equipment_type'=> $equipment_type,
							'approved' => 1
						)
					);
					if($result):
						$notification_args = array(
							'title' => 'New fault type created',
							'notification'=> 'You have successfully created a new fault type ('.$name.').',
						);

						add_user_notification($notification_args);
						$return['status'] = 1;
						$return['message_heading'] = 'Success !';
						$return['message'] = 'Fault Type has been created successfully.';
						$return['reset_form'] = 1;
					endif;
				endif;
			endif;

			return json_encode($return);
		}

		public function update__fault__type__process(){
			extract($_POST);
			$return = array(
				'status' => 0,
				'message_heading'=> 'Failed !',
				'message' => 'Could not update fault_type, Please try again.',
				'reset_form' => 0
			);
			if( user_can('edit_fault_type') ):
				$validation_args = array(
					'name'=> $name,
				);

				if(is_value_exists(TBL_FAULT_TYPES,$validation_args,$fault_type_id)):
					$return['status'] = 2;
					$return['message_heading'] = 'Failed !';
					$return['message'] = 'Fault Type name you entered is already exists, please try another name.';
					$return['fields'] = array('name');
				else:
					$result = $this->database->update(TBL_FAULT_TYPES,
						array(
							'name' => $name,
							'description' => $description,
							'equipment_type'=> $equipment_type
						),
						array(
							'ID'=> $fault_type_id
						)
					);

					if($result):
					$notification_args = array(
						'title' => 'Fault Type updated',
						'notification'=> 'You have successfully updated fault_type ('.$name.').',
					);

					add_user_notification($notification_args);
					$return['status'] = 1;
					$return['message_heading'] = 'Success !';
					$return['message'] = 'Fault Type has been updated successfully.';
					endif;
				endif;
			endif;

			return json_encode($return);
		}

		public function delete__fault__type__process(){
			extract($_POST);
			$id = trim($id);
			if( user_can('delete_fault_type') ):
				$data = get_tabledata(TBL_FAULT_TYPES,true,array('ID'=> $id) ) ;
				$args = array('ID'=> $id);
				$result = $this->database->delete(TBL_FAULT_TYPES,$args);
				if($result):
				$notification_args = array(
					'title' => 'Fault Type deleted',
					'notification'=> 'You have successfully deleted ('.$data->name.') fault_type.',
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

		public function fetch__centre__equipment__data__process(){
			extract($_POST);
			$id = trim($id);
			$return = array();

			$data = '';
			$args = array('approved' => '1');
			if(isset($decommed) && $decommed != '')
				$args['decommed'] = $decommed;
			
			if(isset($id) && $id != '')
				$args['centre'] = $id;
				
			if(isset($equipment_type) && $equipment_type != '')
				$args['equipment_type'] = $equipment_type;
				
			$data = get_tabledata(TBL_EQUIPMENTS,false,$args, 'ORDER BY `name` ASC');
			$option_data = get_option_data($data,array('ID','name'));
			$return['equipment_html'] = get_options_list($option_data);

			return json_encode($return);
		}

		public function fetch__equipment__data__process(){
			extract($_POST);
			$id = trim($id);
			$return = array();
			if($id != ''):
				$data = '';
				$args = array('approved' => '1');
				if(isset($decommed) && $decommed != '')
					$args['decommed'] = $decommed;
				
				if(isset($id) && $id != '')
					$args['equipment_type'] = $id;
					
				if(isset($centre) && $centre != '')
					$args['centre'] = $centre;
					
				$data = get_tabledata(TBL_EQUIPMENTS,false,$args, 'ORDER BY `name` ASC');
				$option_data = get_option_data($data,array('ID','name'));
				$return['equipment_html'] = get_options_list($option_data);

				$data = '';
				$query= "where `equipment_type` LIKE '%".$id."%' AND `approved` = '1' ORDER BY `name` ASC";
				$data = get_tabledata(TBL_FAULT_TYPES, false, array() , $query);
				$option_data = get_option_data($data,array('ID','name'));
				$return['fault_type_html'] = get_options_list($option_data);
			endif;
			return json_encode($return);
		}

		public function fetch__service__agent__data__process(){
			extract($_POST);
			$id = trim($id);
			$return = array();
			if($id != ''):
				$data = '';
				$equipment = get_tabledata(TBL_EQUIPMENTS, true, array('ID'=> $id) );
				$data = get_tabledata(TBL_SERVICE_AGENTS, false, array('ID'=> $equipment->service_agent ));
				$option_data = get_option_data($data,array('ID','name'));
				$return['servicing_agency_html'] = get_options_list($option_data);
			endif;
			return json_encode($return);
		}

		public function fault__approve__change__process(){
			extract($_POST);
			$id = trim($id);
			$return = array(
				'status' => 0,
				'message_heading'=> 'Failed !',
				'message' => 'Could not update fault details, Please try again ',
				'reset_form' => 0
			);
			$return['dd'] = $_POST;
			if(user_can('edit_fault')):
				$fault = get_tabledata(TBL_FAULTS, true, array('ID'=> $id) );
				$args = array('ID'=> $id);
				$result = $this->database->update(TBL_FAULTS,array('approved'=> $status),$args);

				if($result):
					if($status == 0){
						$notification_args = array(
							'title' => 'Fault (' .$fault->ID.') is disabled now',
							'notification'=> 'You have successfully disabled (' .$fault->ID.') fault.',
						);
						$return['message'] = 'You have successfully disabled (' .$fault->ID.') fault.';
					}else{
						$notification_args = array(
							'title' => 'Fault (' .$fault->ID.') is approved now',
							'notification'=> 'You have successfully approved (' .$fault->ID.') fault.',
						);
						$return['message'] = 'You have successfully approved (' .$fault->ID.') fault.';
					}
					add_user_notification($notification_args);
					$return['status'] = 1;
					$return['message_heading'] = 'Success !';
				endif;
			endif;
			return json_encode($return);
		}

		public function fault__type__approve__change__process(){
			extract($_POST);
			$id = trim($id);
			$return = array(
				'status' => 0,
				'message_heading'=> 'Failed !',
				'message' => 'Could not update fault type details, Please try again ',
				'reset_form' => 0
			);
			if(user_can('edit_fault_type')):
				$fault_type = get_tabledata(TBL_FAULT_TYPES, true, array('ID'=> $id) );
				$args = array('ID'=> $id);
				$result = $this->database->update(TBL_FAULT_TYPES,array('approved'=> $status),$args);

				if($result):
					if($status == 0){
						$notification_args = array(
							'title' => 'Fault Type (' .$fault_type->name.') is disabled now',
							'notification'=> 'You have successfully disabled (' .$fault_type->name.') fault type.',
						);
						$return['message'] = 'You have successfully disabled (' .$fault_type->name.') fault type.';
					}else{
						$notification_args = array(
							'title' => 'Fault Type (' .$fault_type->name.') is approved now',
							'notification'=> 'You have successfully approved (' .$fault->name.') fault type.',
						);
						$return['message'] = 'You have successfully approved (' .$fault_type->name.') fault type.';
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