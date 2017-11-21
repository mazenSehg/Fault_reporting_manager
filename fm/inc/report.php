<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_start();
require_once('../load.php');
global $db;

$cmd = "";
if(!isset($_REQUEST["cmd"])){
    return "return false;";
}
if(isset($_REQUEST["cmd"])){
        $cmd = $_REQUEST["cmd"];
}
$cmd();

function printFaultReport() {
	global $db,$User;
	ob_start();
	$query = '';
	$fault__id = $_REQUEST['fault_id'];

	if(!is_admin()):
		$id = $_SESSION['current_user_id'];
		$current_user = get_userdata($id);
		$centres = maybe_unserialize($this->current__user->centre);
		if(!empty($centres)){
			$centres = implode(',',$centres);
			$query = "WHERE `centre` IN (".$centres.")";
		}
	endif;

	header("Content-type: application/pdf");
	$pdf = new PDF_AutoPrint('P', 'mm', 'A4');
	$pdf->SetAutoPageBreak(true, 10);
	$pdf->SetFont('Arial','B',10);
	$pdf->AddPage();
	
	$query .= ($query != '') ? ' AND ' : ' WHERE ';
	$query .= " `ID` = ".$fault__id." ";
	$fault = get_tabledata(TBL_FAULTS,true,array(), $query);
	if(!$fault) {
		echo page_not_found('Oops ! Fault details not found.','Please go back and check again !');
		$pdf->Cell(60,5, 'Oops ! Fault details not found.',1,0, 'R', true);
		$pdf->Output();
		return;
	}

	$centre = get_tabledata(TBL_CENTRES,true, array('ID'=> $fault->centre));
	$region = get_tabledata(TBL_REGIONS,true, array('ID'=> $centre->region));
	$equipment_type = get_tabledata(TBL_EQUIPMENT_TYPES,true, array('ID'=> $fault->equipment_type));
	$equipment = get_tabledata(TBL_EQUIPMENTS,true, array('ID'=> $fault->equipment));
	$model = get_tabledata(TBL_MODELS,true, array('ID'=>$equipment->model));
	$manufacturer = get_tabledata(TBL_MANUFACTURERS, true, array('ID'=>$equipment->manufacturer));
	$fault_type = get_tabledata(TBL_FAULT_TYPES,true, array('ID'=> $fault->fault_type));
	$service_agent = get_tabledata(TBL_SERVICE_AGENTS, true, array('ID'=> $fault->current_servicing_agency));
	
	header("Content-Disposition: inline; filename=fault_report_".$fault__id.".pdf");
	$val = $fault->name;
	$pdf->SetXY( 10, 15 );
	$pdf->Cell( 40, 8, "Reported By: $val", 0, 0, 'C');
	$num_fact = "Report for Fault ID: $fault__id (".date("Y-m-d H:i:s").")";
	$pdf->SetLineWidth(0.1); $pdf->SetFillColor(192); $pdf->Rect(90, 15, 115, 8, "DF");
	$pdf->SetXY( 105, 15 ); $pdf->SetFont( "Arial", "B", 12 ); $pdf->Cell( 85, 8, $num_fact, 0, 0, 'C');
	$pdf->SetXY( 10, 35 );
	$pdf->SetFillColor(242);
	$pdf->SetFillColor(192);

	$header_width = 25;
	$cell_width = 69;
	$pdf->SetFont('Arial','B',10);

	$pdf->Cell($header_width, 5, 'Centre',1,0, 'R', true);
	$val = checkSpacing($centre->name);
	$pdf->Cell($cell_width,5, "  ".$val,1,0,'L');
	$pdf->SetX($pdf->GetX()+2);
	$pdf->Cell($header_width, 5, 'Programme',1,0, 'R', true);
	$val = checkSpacing($centre->programme);
	$pdf->Cell($cell_width,5, "  ".$val,1,0,'L');
	$pdf->Ln(5); $pdf->SetX(10);

	$pdf->Cell($header_width, 5, 'Region',1,0, 'R', true);
        $val = checkSpacing($region->name);
        $pdf->Cell($cell_width,5, "  ".$val,1,0,'L');
        $pdf->SetX($pdf->GetX()+2);
        $pdf->Cell($header_width, 5, 'Centre Code',1,0, 'R', true);
        $val = checkSpacing($centre->centre_code);
        $pdf->Cell($cell_width,5, "  ".$val,1,0,'L');
        $pdf->Ln(5); 
        $pdf->Ln(5); $pdf->SetX(10);

	$pdf->Cell($header_width, 5, 'Equip Type',1,0, 'R', true);
        $val = checkSpacing($equipment_type->name);
        $pdf->Cell($cell_width,5, "  ".$val,1,0,'L');
        $pdf->SetX($pdf->GetX()+2);
        $pdf->Cell($header_width, 5, 'Model',1,0, 'R', true);
        $val = checkSpacing($model->name);
        $pdf->Cell($cell_width,5, "  ".$val,1,0,'L');
        $pdf->Ln(5); $pdf->SetX(10);

	$pdf->Cell($header_width, 5, 'Equip ID',1,0, 'R', true);
	$val = checkSpacing($equipment->ID." (".$equipment->equipment_code.")");
        $pdf->Cell($cell_width,5, "  ".$val,1,0,'L');
        $pdf->SetX($pdf->GetX()+2);
        $pdf->Cell($header_width, 5, 'Manufacturer',1,0, 'R', true);
        $val = checkSpacing($manufacturer->name);
        $pdf->Cell($cell_width,5, "  ".$val,1,0,'L');
        $pdf->Ln(5); $pdf->SetX(10);

	$pdf->Cell($header_width, 5, 'Serv Agency',1,0, 'R', true);
	$sa = $fault->current_servicing_agency !=  NULL ? $fault->current_servicing_agency : 'None selected.';
        $val = checkSpacing($sa);
        $pdf->Cell($cell_width,5, "  ".$val,1,0,'L');
	$pdf->SetX($pdf->GetX()+2);
        $pdf->Cell($header_width, 5, 'Install Year',1,0, 'R', true);
        $val = checkSpacing($equipment->year_installed);
        $pdf->Cell($cell_width,5, "  ".$val,1,0,'L');
        $pdf->Ln(5); $pdf->SetX(10);

	$pdf->Cell($header_width, 5, 'Equip Name',1,0, 'R', true);
        $val = checkSpacing($equipment->name);
        $pdf->Cell((($cell_width*2)+$header_width+2),5, "  ".$val,1,0,'L');
	$pdf->Ln(5); $pdf->Ln(5); $pdf->SetX(10);

	$pdf->Cell($header_width, 5, 'Fault Type',1,0, 'R', true);
	$val = checkSpacing($fault->f_type_name);
        $pdf->Cell($cell_width,5, "  ".$val,1,0,'L');
        $pdf->SetX($pdf->GetX()+2);
        $pdf->Cell($header_width, 5, 'Fault ID',1,0, 'R', true);
        $val = checkSpacing($fault->ID);
        $pdf->Cell($cell_width,5, "  ".$val,1,0,'L');
        $pdf->Ln(5); $pdf->SetX(10);

	$pdf->Cell($header_width, 5, 'Fault Date',1,0, 'R', true);
        $val = checkSpacing($fault->date_of_fault != '' ? date('d/m/Y', strtotime($fault->date_of_fault)) : '');
        $pdf->Cell($cell_width,5, "  ".$val,1,0,'L');
        $pdf->SetX($pdf->GetX()+2);
        $pdf->Ln(5); $pdf->SetX(10);

        $pdf->Cell($header_width, 5, 'Submit Date',1,0, 'R', true);
        $val = checkSpacing($fault->created_on != '' ? date('d/m/Y', strtotime($fault->created_on)) : '');
        $pdf->Cell($cell_width,5, "  ".$val,1,0,'L');
        $pdf->SetX($pdf->GetX()+2);
        $pdf->Ln(5); $pdf->SetX(10);

	$val = $fault->description_of_fault;
	$val = preg_replace("/[\n\r\t]/", " ", $val);
	$temp = wordwrap($val, 70, "-----");
	$output = preg_split("/-----/", $temp);
	//$output = str_split($val, 65);
	$count = 0;
	foreach($output as $val) {
		if($count == 0) {
			$pdf->Cell($header_width,5, 'Fault Desc',1,0, 'R', true);
		} else {
			$pdf->Cell($header_width,5, "",1,0, 'R', true);
		}
		$pdf->Cell((($cell_width*2)+$header_width+2),5, "  ".$val,1,0,'L');
		$pdf->Ln(5);
		$pdf->SetX( 10);
		$count++;
	}
	$pdf->Ln(5); $pdf->SetX(10);

	$pdf->Cell($header_width+27, 5, 'Fault Corrected by User?',1,0, 'R', true);
        $val = '';
        switch($fault->fault_corrected_by_user):
        case '0' : $val = 'No'; break;
        case '1' : $val = 'Yes'; break;
        case '2' : $val = 'N/A'; break;
        endswitch;
        $pdf->Cell($cell_width*2,5, "  ".$val,1,0,'L');
        $pdf->Ln(5); $pdf->SetX(10);
	$pdf->Cell($header_width+27, 5, 'To Fix at next service visit',1,0, 'R', true);
	$val = '';
	switch($fault->to_fix_at_next_service_visit):
	case '0' : $val = 'No'; break;
	case '1' : $val = 'Yes'; break;
	case '2' : $val = 'N/A'; break;
	endswitch;
        $pdf->Cell($cell_width*2,5, "  ".$val,1,0,'L');
        $pdf->Ln(5); $pdf->SetX(10);
	$pdf->Cell($header_width+27, 5, 'Engineer called out',1,0, 'R', true);
        $val = '';
        switch($fault->engineer_called_out):
        case '0' : $val = 'No'; break;
        case '1' : $val = 'Yes'; break;
        case '2' : $val = 'N/A'; break;
        endswitch;
        $pdf->Cell($cell_width*2,5, "  ".$val,1,0,'L');
        $pdf->Ln(5); $pdf->SetX(10);
	$pdf->Cell($header_width+27, 5, 'Service Call Number',1,0, 'R', true);
        $val = $fault->service_call_no;
        $pdf->Cell($cell_width*2,5, "  ".$val,1,0,'L');
        $pdf->Ln(5); $pdf->SetX(10);
	$pdf->Cell($header_width+27, 5, 'Report Sent to MHRA',1,0, 'R', true);
        $val = $fault->adverse_incident_report == 1 ? 'Yes' : 'No';
        $pdf->Cell($cell_width*2,5, "  ".$val,1,0,'L');
        $pdf->Ln(5); $pdf->SetX(10);

	$val = $fault->action_taken;
	$val = preg_replace("/[\n\r\t]/", " ", $val);
	$temp = wordwrap($val, 70, "-----");
	$output = preg_split("/-----/", $temp);
        $count = 0;
        foreach($output as $val) {
                if($count == 0) {
                        $pdf->Cell($header_width+27,5, 'Corrective Action Taken',1,0, 'R', true);
                } else {
                        $pdf->Cell($header_width+27,5, "",1,0, 'R', true);
                }
                $pdf->Cell(($cell_width*2),5, "  ".$val,1,0,'L');
                $pdf->Ln(5);
                $pdf->SetX( 10);
                $count++;
        }
        $pdf->Ln(5); $pdf->SetX(10);

	$pdf->Cell($header_width+27, 5, 'Equipment Status',1,0, 'R', true);
        $val = checkSpacing(get_equipment_status($fault->equipment_status));
        $pdf->Cell($cell_width*2,5, "  ".$val,1,0,'L');
        $pdf->Ln(5); $pdf->SetX(10);
        $pdf->Cell($header_width+27, 5, 'Equipment Downtime (days)',1,0, 'R', true);
        $val = checkSpacing($fault->equipment_downtime);
        $pdf->Cell($cell_width*2,5, "  ".$val,1,0,'L');
        $pdf->Ln(5); $pdf->SetX(10);
	$pdf->Cell($header_width+27, 5, 'Screening Downtime (days)',1,0, 'R', true);
        $val = checkSpacing($fault->screening_downtime);
        $pdf->Cell($cell_width*2,5, "  ".$val,1,0,'L');
        $pdf->Ln(5); $pdf->SetX(10);
        $pdf->Cell($header_width+27, 5, 'Number of Repeat Films',1,0, 'R', true);
        $val = checkSpacing($fault->repeat_images);
        $pdf->Cell($cell_width*2,5, "  ".$val,1,0,'L');
        $pdf->Ln(5); $pdf->SetX(10);
        $pdf->Cell($header_width+27, 5, 'Number of Cancelled Women',1,0, 'R', true);
        $val = checkSpacing($fault->cancelled_women);
        $pdf->Cell($cell_width*2,5, "  ".$val,1,0,'L');
        $pdf->Ln(5); $pdf->SetX(10);
        $pdf->Cell($header_width+27, 5, 'Number of Technical Recalls',1,0, 'R', true);
        $val = checkSpacing($fault->technical_recalls);
        $pdf->Cell($cell_width*2,5, "  ".$val,1,0,'L');
        $pdf->Ln(5); $pdf->SetX(10);

	$pdf->Cell($header_width+100, 5, 'Satisfied with the response of the servicing organisation',1,0, 'R', true);
        $val = '';
        switch($fault->satisfied_servicing_organisation):
        case '0' : $val = 'No'; break;
        case '1' : $val = 'Yes'; break;
        case '2' : $val = 'N/A'; break;
        endswitch;
        $pdf->Cell(($cell_width*2)-73,5, "  ".$val,1,0,'L');
        $pdf->Ln(5); $pdf->SetX(10);
	$pdf->Cell($header_width+100, 5, 'Satisfied with the performance of the service engineer',1,0, 'R', true);
        $val = '';
        switch($fault->satisfied_service_engineer):
        case '0' : $val = 'No'; break;
        case '1' : $val = 'Yes'; break;
        case '2' : $val = 'N/A'; break;
        endswitch;
        $pdf->Cell(($cell_width*2)-73,5, "  ".$val,1,0,'L');
        $pdf->Ln(5); $pdf->SetX(10);
	$pdf->Cell($header_width+100, 5, 'Satisfied with the reliability/performance of this equipment?',1,0, 'R', true);
        $val = '';
        switch($fault->satisfied_equipment):
        case '0' : $val = 'No'; break;
        case '1' : $val = 'Yes'; break;
        case '2' : $val = 'N/A'; break;
        endswitch;
        $pdf->Cell(($cell_width*2)-73,5, "  ".$val,1,0,'L');
        $pdf->Ln(5); $pdf->SetX(10);

	$pdf->Output();
}
?>
