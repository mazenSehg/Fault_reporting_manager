<?php
	session_start();
	//Load all functions
	require_once('../load.php');
	
	global $db;
	$device = get_device_name();
	$website_link_shortcode = '<a href="'.site_url().'" target="_blank" style="color:#26B99A;text-decoration:none;">'.get_site_name().'</a>';
	$login_url_shortcode = '<a href="'.site_url().'/login/" target="_blank" style="color:#26B99A;text-decoration:none;">Click here for login url</a>';
	$contact_url_shortcode = '<a href="'.site_url().'/contact/" target="_blank" style="color:#26B99A;text-decoration:none;">click here</a>';
	$current_time_shortcode = date('M d, Y h:i A');
	$admin_email_shortcode = get_option('admin_email');
	$no_reply_email_shortcode = 'no-reply@example.com';
	
	
	if( isset($_POST['action']) ):
		switch($_POST['action']):
			case 'user_login' : 
				echo $User->user__login__process();
				break;	

			case 'pword_login' : 
				echo $User->reset__login__process();
				break;
			
			case 'logout_request':
				remove_current_user();
				break;
			
			case 'update_general_setting':
				echo $Settings->update__general__setting();
				break;
				
			case 'update_manage_roles':
				echo $Settings->update__manage__roles();
				break;
			
			case 'user_password_change':
				echo $Profile->profile__password__change__process();	
				break;
			
			case 'edit_user_profile':
				echo $Profile->update__profile__process();
				break;
				
			case 'add_new_user':
				echo $User->add__user__process();
				break;
				
			case 'edit_user':
				echo $User->update__user__process();
				break;
			
			case 'generate_password':
				echo password_generator();
				break;
			
			case 'upload_profile_image':
				echo $User->upload__image__process();
				break;
				
			case 'user_account_status_change':
				echo $User->account__status__change__process();
				break;


            case 'fault_approve_change_via_modal':
				echo $Fault->fault__approve__change__via__modal__process();
				break;

			case 'fetch_fault_data_for_modal':
				echo $Fault->fault__data__for__modal__process();
				break;	


			case 'delete_user':
				echo $User->delete__user__process();
				break;
				
			case 'read_notification':
				echo $Profile->read__notification__process();
				break;
			
			case 'hide_notification':
				echo $Profile->hide__notification__process();
				break;
			
			case 'add_new_centre':
				echo $Centre->add__centre__process();
				break;
				
			case 'update_centre':
				echo $Centre->update__centre__process();
				break;
				
			case 'delete_centre':
				echo $Centre->delete__centre__process();
				break;	
			
			case 'add_new_region':
				echo $Centre->add__region__process();
				break;
				
			case 'update_region':
				echo $Centre->update__region__process();
				break;
				
			case 'delete_region':
				echo $Centre->delete__region__process();
				break;
			
			case 'add_new_region_body':
				echo $Centre->add__region__body__process();
				break;
				
			case 'update_region_body':
				echo $Centre->update__region__body__process();
				break;
				
			case 'delete_region_body':
				echo $Centre->delete__region__body__process();
				break;
					
			case 'add_new_equipment_type':
				echo $Equipment->add__equipment__type__process();
				break;
				
			case 'update_equipment_type':
				echo $Equipment->update__equipment__type__process();
				break;
				
			case 'delete_equipment_type':
				echo $Equipment->delete__equipment__type__process();
				break;
			
			case 'add_new_service_agent':
				echo $Equipment->add__service__agent__process();
				break;
				
			case 'update_service_agent':
				echo $Equipment->update__service__agent__process();
				break;
				
			case 'delete_service_agent':
				echo $Equipment->delete__service__agent__process();
				break;
			
			case 'add_new_manufacturer':
				echo $Equipment->add__manufacturer__process();
				break;
				
			case 'update_manufacturer':
				echo $Equipment->update__manufacturer__process();
				break;
				
			case 'delete_manufacturer':
				echo $Equipment->delete__manufacturer__process();
				break;
			
			case 'add_new_model':
				echo $Equipment->add__model__process();
				break;
				
			case 'update_model':
				echo $Equipment->update__model__process();
				break;
				
			case 'delete_model':
				echo $Equipment->delete__model__process();
				break;
			
			case 'add_new_supplier':
				echo $Equipment->add__supplier__process();
				break;
				
			case 'update_supplier':
				echo $Equipment->update__supplier__process();
				break;
				
			case 'delete_supplier':
				echo $Equipment->delete__supplier__process();
				break;
					
			case 'fetch_equipment_type_data':
				echo $Equipment->fetch__equipment__type__data__process();
				break;
			
			case 'fetch_manufacturer_data':
				echo $Equipment->fetch__manufacturer__data__process();
				break;
				
			case 'add_new_equipment':
				echo $Equipment->add__equipment__process();
				break;
				
			case 'update_equipment':
				echo $Equipment->update__equipment__process();
				break;
				
			case 'delete_equipment':
				echo $Equipment->delete__equipment__process();
				break;
			
			case 'add_new_fault_type':
				echo $Fault->add__fault__type__process();
				break;
				
			case 'update_fault_type':
				echo $Fault->update__fault__type__process();
				break;
				
			case 'delete_fault_type':
				echo $Fault->delete__fault__type__process();
				break;
				
			case 'add_new_fault':
				echo $Fault->add__fault__process();
				break;
				
			case 'update_fault':
				echo $Fault->update__fault__process();
				break;
				
			case 'delete_fault':
				echo $Fault->delete__fault__process();
				break;
				
			case 'fetch_centre_equipment_data':
				echo $Fault->fetch__centre__equipment__data__process();
				break;
				
			case 'fetch_equipment_data':
				echo $Fault->fetch__equipment__data__process();
				break;

			case 'fetch_service_agent_data':
				echo $Fault->fetch__service__agent__data__process();
				break;	

			case 'fetch_service_agent_data2':
				echo $Fault->fetch__service__agent__data__process2();
				break;	
				
			case 'fault_approve_change':
				echo $Fault->fault__approve__change__process();
				break;
			
			case 'fault_type_approve_change':
				echo $Fault->fault__type__approve__change__process();
				break;
				
			case 'centre_approve_change':
				echo $Centre->centre__approve__change__process();
				break;
			
			case 'region_approve_change':
				echo $Centre->region__approve__change__process();
				break;
			
			case 'region_body_approve_change':
				echo $Centre->region__body__approve__change__process();
				break;
			
			case 'equipment_approve_change':
				echo $Equipment->equipment__approve__change__process();
				break;
				
			case 'equipment_type_approve_change':
				echo $Equipment->equipment__type__approve__change__process();
				break;
				
			case 'service_agent_approve_change':
				echo $Equipment->service__agent__approve__change__process();
				break;
				
			case 'manufacturer_approve_change':
				echo $Equipment->manufacturer__approve__change__process();
				break;
			
			case 'model_approve_change':
				echo $Equipment->model__approve__change__process();
				break;
			
			case 'supplier_approve_change':
				echo $Equipment->supplier__approve__change__process();
				break;
				
		endswitch;
	else:
		print_r($_POST);
	endif;
	
	exit();
?>