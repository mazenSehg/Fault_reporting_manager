<?php
	session_start();
	//Load all functions
	require_once('../load.php');

	global $db;
	
	if( isset($_POST['action']) ):
		switch($_POST['action']):
			case 'fetch_all_equipments':
				echo $Equipment->fetch_all_equipments_process();
				break;
			case 'fetch_all_equipments2':
				echo $Equipment->fetch_all_equipments_process2();
				break;
			case 'fetch_all_faults':
				echo $Fault->fetch_all_faults_process();
				break;

			case 'fetch_all_faults2':
				echo $Fault->fetch_all_faults_process2();
				break;
			default:

				$response = array(
					"draw" => 0,
					"recordsTotal" => 0,
					"recordsFiltered"=> 0,
					"data" => array()
				);
				echo json_encode($response);
				break;
		endswitch;
	else:
		$response = array(
			"draw" => 0,
			"recordsTotal" => 0,
			"recordsFiltered"=> 0,
			"data" => array()
		);
		echo json_encode($response);
	endif;
exit();
?>