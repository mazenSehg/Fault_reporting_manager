#!/usr/bin/perl -w
 
use Data::Dumper;
use DBI;
use DBD::mysql;
use File::Copy;
use Cwd;
use diagnostics;
use sigtrap;


my $commit = 0;

#######################################
#------------ QUESTIONS--------------#
# Fault Type
# 1) image quality - digital has not been copied over. Should it?
#
# Centres
# 1) 9 extra (minial infomration) centres
#
# Manufacters and Models
# 1) About 10 or so new ones?
#
###################################### 


my @table_names = ('fault_types', 'equipment_types', 'incident_reporting_body', 'region', 'roles', 'centre', 'designation', 'users', 'manufacturer', 'servicing_agency', 'equipment_use_status', 'equipment', 'allowable_fault_types', 'faults', 'service_agent_tracking', 'region_tracking');

sub sQuote {
    $s = $_[0];
    $s =~ s/'/''/g;
    return($s);			
}

my $mysql_db = "DBI:mysql:database=FaultReportingDB;host=10.161.128.194:3306";
my $mysql_con = DBI->connect($mysql_db, 'admin', 'ore28gon') ||
        die "Could not connect to database: $DBI::errstr";

############# LOOKUPS
my %lookup_ft;
my %lookup_old_ft;
my %body_lookup;
my %man_lookup;
my %mod_lookup;
my %cen_lookup;
my %eq_lookup;
my %et_lookup;
my %sa_lookup;

my %eq_lookup_string;
my %et_lookup_string;
my %man_lookup_string;
my %mod_lookup_string;

############# FAULT TYPE
my %existing_ft;
my %existing_ft_lookup;
my $sql = "select * FROM fault_management.tbl_fault_type";
my $sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
	$existing_ft{$data[1]} = [@data];
	$existing_ft_lookup{$data[0]} = $data[1];
}
$sth->finish();

$sql = "select * FROM fault_types";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
	if(!exists($existing_ft{$data[1]})) {
		$temp = "INSERT INTO fault_management.tbl_fault_type values ('".$data[0]."', '".sQuote($data[1])."', null, now(), '".sQuote($data[2])."')";
		print $temp."\n";
	}	
	$lookup_old_ft{$data[0]} = $existing_ft{$data[1]}[0];
}
$sth->finish();

my %ft_lookup;
my %ft_mapping;
$sql = "select * FROM fault_management.tbl_fault_type";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
	$lookup_ft{$data[1]} = \@data;
	$ft_lookup{$data[0]} = $data[1];
}
$sth->finish();
#########################

############# EQUIPMENT TYPE
my %current_eq_type;
my %current_eq_type_name;
%existing_ft = ();
$sql = "select * FROM fault_management.tbl_equipment_type";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
        $existing_ft{$data[1]} = \@data;
	$current_eq_type{$data[0]} = $data[2];
	$current_eq_type_name{$data[2]} = $data[0];
}
$sth->finish();

$sql = "select * FROM equipment_types";
$sth = $mysql_con->prepare($sql);
$sth->execute();

while (@data = $sth->fetchrow_array()) {
	if(!exists($existing_ft{$data[2]})) {
		$temp = "INSERT INTO fault_management.tbl_equipment_type values ('".$data[0]."', '".sQuote($data[2])."', '".sQuote($data[1])."', null, 1, now())";
		print $temp."\n";
	}	
	$et_lookup_string{$data[0]} = $data[1];
	$et_lookup{$data[0]} = $existing_ft{$data[2]}[0];
}
#########################

print "\n";
############# INCIDENT BODY
%existing_ft = ();
$sql = "select * FROM fault_management.tbl_region_body";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data2 = $sth->fetchrow_array()) {
        $existing_ft{$data2[1]} = [@data2];
}
$sth->finish();

$sql = "select * FROM incident_reporting_body";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (my @data = $sth->fetchrow_array()) {
        if(!exists($existing_ft{$data[1]})) {
		$temp = "MISSING: Incident body missing (".$data[1].")";
		print $temp."\n";
        } else {
		my @t =  @{$existing_ft{$data[1]}};
		$body_lookup{$data[0]} = $t[0];
	}
}
#########################


############# EQUIPMENT TYPE
%existing_ft = ();
$sql = "select * FROM fault_management.tbl_region";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
        $existing_ft{$data[1]} = \@data;
}
$sth->finish();

$sql = "select * FROM region";
$sth = $mysql_con->prepare($sql);
$sth->execute();

while (@data = $sth->fetchrow_array()) {
	if(!exists($existing_ft{$data[1]})) {
		$temp = "INSERT INTO fault_management.tbl_region values ('".$data[0]."', '".sQuote($data[1])."', '".$body_lookup{$data[2]}."', 1, now())";
		print $temp."\n";
	}	
}
#########################



print "\n";
############# CENTRES
%existing_ft = ();
my %cen_name;
$sql = "select * FROM fault_management.tbl_centres";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
        $existing_ft{$data[6]} = [@data];
	$cen_name{$data[0]} = $data[1];
}
$sth->finish();

$sql = "select * FROM centre";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
	$centre_code = $data[2];
	$supt_rad = $data[12];
	$supt_rade = $data[13];
	$active = $data[16];
	$comment = $data[17];
	if($comment) {
		$comment =~ s/[\n\r']//g;
	}
	$trust = $data[18];
	$trust_id = $data[19];
		
	if(!exists($existing_ft{$data[2]})) {
		$temp = "INSERT INTO fault_management.tbl_centres VALUES ('".$data[0]."', '".$data[1]."', '".$trust."', '".$trust_id."', '".$data[3]."', '".$data[4]."', '".$data[2]."', 1, '".$data[5]."', '".$data[6]."', '".$data[7]."', '".$data[8]."', '".$data[9]."', '".$data[10]."', '".$data[11]."', '".$data[12]."', '".$data[13]."', '".$data[14]."', '".$data[15]."', '".$comment."', now(), null, now() )";
		#print $temp."\n";
	} else {
		$matched_id = $existing_ft{$data[2]}[0];
		
		my $temp = "UPDATE fault_management.tbl_centres SET centre_code = '$centre_code', support_Rad = '$supt_rad', support_Rad_email = '$supt_rade', approved= '$active', comment = '$comment', trust = \"$trust\", trust_id = '$trust_id' WHERE id = $matched_id";
		#print $temp."\n";
		#my $sth2 = $mysql_con->prepare($temp);
		#$sth2->execute();
		#$sth2->finish();
	}	
	$cen_lookup{$data[0]} = $existing_ft{$data[2]}[0];
	### UPDATE STUFF IN HERE
	#$odbc->Run("INSERT INTO centre values ('".$data[0]."', '".sQuote($data[1])."', '".sQuote($data[2])."', '".sQuote($data[3])."', '".sQuote($data[4])."', '".sQuote($data[5])."', '".sQuote($data[6])."', '".sQuote($data[7])."', '".sQuote($data[8])."', '".sQuote($data[9])."', '".sQuote($data[10])."', '".sQuote($data[11])."', '".sQuote($data[12])."', '".sQuote($data[13])."', '".sQuote($data[14])."', '".sQuote($data[15])."', '".$data[16]."')");
}
#########################


print "\n";
############# MANUFACTURERS
my %man_name_lookup;
%existing_ft = ();
$sql = "select * FROM fault_management.tbl_manufacturer";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
        $existing_ft{$data[1]} = [@data];
	$man_name_lookup{$data[0]} = $data[1];
}
$sth->finish();

$sql = "select * FROM manufacturer";
$sth = $mysql_con->prepare($sql);
$sth->execute();

while (@data = $sth->fetchrow_array()) {
	if(!exists($existing_ft{$data[1]})) {
		$temp = "Missing Manufacturer: ".$data[1]." ( ".$data[0];
		print $temp."\n";
		$temp = "INSERT INTO fault_management.tbl_manufacturer values (null, '".sQuote($data[1])."', null, 1, now())";
		print $temp."\n";
		$last_id = 'PLACEHOLDER';
		if($commit) {
			my $sth2 = $mysql_con->prepare($temp);
			$sth2->execute();
			$last_id = $sth2->{mysql_insertid};
			$sth2->finish();
		}
		$man_lookup{$data[0]} = $last_id;
	} else {
		$man_lookup{$data[0]} = $existing_ft{$data[1]}[0];
	}
	$man_lookup_string{$data[0]} = $data[1];
}
$sth->finish();
#########################


print "\n";
############# MODELS
%existing_ft = ();
$sql = "select * FROM fault_management.tbl_model";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
	$data[1] = lc($data[1]);
        $existing_ft{$data[1]} = [@data];
}
$sth->finish();

$sql = "select * FROM model";
$sth = $mysql_con->prepare($sql);
$sth->execute();

while (@data = $sth->fetchrow_array()) {
	$data[1] = lc($data[1]);
	if(!exists($existing_ft{$data[1]})) {
		$temp = "Missing Model: ".$data[1]." (".$data[0].")";
		print $temp."\n";
		$temp = "INSERT INTO fault_management.tbl_model values (null, '".sQuote($data[1])."', null, 1, now())";
                print $temp."\n";
                $last_id = 'PLACEHOLDER';
                if($commit) {
                        my $sth2 = $mysql_con->prepare($temp);
                        $sth2->execute();
                        $last_id = $sth2->{mysql_insertid};
                        $sth2->finish();
                }
                $mod_lookup{$data[0]} = $last_id;
	} else {
                $mod_lookup{$data[0]} = $existing_ft{$data[1]}[0];
                #print $data[0]." maps to ".$existing_ft{$data[1]}[0]."\n";
	}	
	$mod_lookup_string{$data[0]} = $data[1];
}
#########################


print "\n";
############# SERVICE AGENCIES
%existing_ft = ();
$sql = "select * FROM fault_management.tbl_service_agent";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
        $existing_ft{$data[1]} = [@data];
}
$sth->finish();

$sql = "select * FROM servicing_agency";
$sth = $mysql_con->prepare($sql);
$sth->execute();

while (@data = $sth->fetchrow_array()) {
	if(!exists($existing_ft{$data[1]})) {
		$temp = "Missing SA: ".$data[1];
		print $temp."\n";
	} else {
                $sa_lookup{$data[0]} = $existing_ft{$data[1]}[0];
                #print $data[0]." maps to ".$existing_ft{$data[1]}[0]."\n";
	}	
}
#########################


############# equipment

my $man_needs_fixing;
%existing_ft = ();
my %existing_eq = ();
my %existing_serial = ();
$sql = "select * FROM fault_management.tbl_equipment";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
        $existing_ft{$data[3]} = [@data];
        $existing_eq{$data[0]} = [@data];
        $existing_serial{$data[11]} = [@data];
	$man_id = $data[5];
	my $eq_code = $data[3];
	if(!$eq_code) {
		print "NO CODE\n";
	}
	if($man_id) {
		if($man_id == 0) {
			$man_needs_fixing{$data[0]} = 1;
		}
	} else {
		$man_needs_fixing{$data[0]} = 1;
	}
}
$sth->finish();


$sql = "select * FROM equipment";
$sth = $mysql_con->prepare($sql);
$sth->execute();
my $counter  = 0;

#$commit = 1;

while (@data = $sth->fetchrow_array()) {
	my $sa_id = '';
	if($data[16]) {
		$sa_id = $sa_lookup{$data[16]};
	}
	if(!exists($existing_ft{$data[2]})) {
		if($data[2] =~ /CDO.*/) {
			if(exists($existing_serial{$data[1]})) {
				$temp = "Needs Updating  ".$data[2];
				print $temp."\n";
				my $sql = "UPDATE fault_management.tbl_equipment SET equipment_code = '".$data[2]."' WHERE ID = ".$existing_serial{$data[1]}[0];
				print $sql."\n";
					#my $sth2 = $mysql_con->prepare($sql);
					#$sth2->execute();
					#$sth2->finish();
			} else {
				$temp = " Missing Equipment: ".$data[2];
				print $temp."\n";
			}
		} else {
			$temp = " Missing Equipment: ".$data[2]."  (".$data[11].")";
			print $temp."\n";

		my $centre_id = $cen_lookup{$data[4]};
		my $eq_type = $et_lookup{$data[3]};
		my $type_name = $et_lookup_string{$data[3]};
		my $man_name = $man_lookup_string{$data[5]};
		my $mod_name = $mod_lookup_string{$data[6]};
		my $sup_id = '';
		my $name = $man_name." | ".$mod_name." | ".$data[1]." | ".$data[11]." | ".$data[7]." | ".$data[8];

		$temp = "INSERT INTO fault_management.tbl_equipment values ('".$data[0]."', '".sQuote($name)."', '$centre_id', '".$data[2]."', '$eq_type', '".$man_lookup{$data[5]}."', '".$mod_lookup{$data[6]}."', null, '$sa_id', '".$data[7]."', '".$data[8]."', '".$data[1]."', '".$data[9]."', '".$data[11]."', '".$data[13]."', '".$data[12]."', '".$data[14]."', 0, '".$data[15]."', '".$data[10]."', 1, '".$data[19]."', '".$type_name."', '".$data[21]."')";
                print $temp."\n";
                        #my $sth2 = $mysql_con->prepare($temp);
                        #$sth2->execute();
                        #$last_id = $sth2->{mysql_insertid};
                        #$sth2->finish();
                $eq_lookup{$data[0]} = $last_id;
		}
        } else {
		my $match_eq_id = $existing_ft{$data[2]}[0];
		my $match_eq_type_id = $existing_ft{$data[2]}[4];
		my $match_eq_type_name = $current_eq_type{$match_eq_type_id};
		my $old_old_eq_type = $data[3];
		my $eq_type = $et_lookup{$data[3]};
		my $type_name = $et_lookup_string{$data[3]};
		if($match_eq_type_name ne $type_name) {
			my $should_be = $current_eq_type_name{$type_name};
			print "Matched Equipment ID: $match_eq_id, Old Equipment ID: ".$data[0].", Matched Eq Type ID: $match_eq_type_id ($match_eq_type_name), Old Eq Type ID: $old_old_eq_type ($type_name) - Should be eq_type_id: $should_be\n";
			my $sql = "UPDATE fault_management.tbl_equipment SET equipment_type = '$should_be', type_name = '$type_name' WHERE ID = $match_eq_id";
			print $sql."\n";
				#my $sth2 = $mysql_con->prepare($sql);
				#$sth2->execute();
				#$sth2->finish();
			$sql = "UPDATE fault_management.tbl_fault SET equipment_type = '$should_be', e_type_name = '$type_name' WHERE equipment = $match_eq_id";
				#my $sth2 = $mysql_con->prepare($sql);
				#$sth2->execute();
				#$sth2->finish();
		}
		if(exists($man_needs_fixing{$existing_ft{$data[2]}[0]})) {
			my $name = $man_name." | ".$mod_name." | ".$data[1]." | ".$data[11]." | ".$data[7]." | ".$data[8];
			my $old_man_id = $data[5];
			my $eq_id = $existing_ft{$data[2]}[0];
			my $new_man_id = $man_lookup{$old_man_id};
			#if($old_man_id) {
			#	my $sql = "UPDATE fault_management.tbl_equipment SET manufacturer = '$new_man_id' WHERE ID = $eq_id";
			#	print $sql."\n";
			#	if($commit) {
			#		my $sth2 = $mysql_con->prepare($sql);
			#		$sth2->execute();
			#		$sth2->finish();
			#	}
			#}
			if($old_man_id && $new_man_id ne 'PLACEHOLDER') {
				print "THIS EQ (MAN) needs fixing: ".$existing_ft{$data[2]}[0]." ($old_man_id) - $name [$data[0]] - $new_man_id\n";
			}
		}
		my $old_eq_id = $data[0];
		my $eq_id = $existing_ft{$data[2]}[0];

		if($type_name ne $existing_ft{$data[2]}[22]) {
			$e_type_name = $existing_ft{$data[2]}[22];
			my $should_be = $current_eq_type_name{$type_name};
			print "Matched Equipment ID: $match_eq_id, Old Equipment ID: ".$data[0].", Matched Eq Type ID: $match_eq_type_id ($match_eq_type_name), Old Eq Type ID: $old_old_eq_type ($type_name) - Should be eq_type_id: $should_be --------- $type_name : $e_type_name\n";
			$sql = "UPDATE fault_management.tbl_fault SET equipment_type = '$should_be', e_type_name = '$type_name' WHERE equipment = $match_eq_id";
			print $sql."\n";
			exit();
		}

		my $sn = $data[1];
		if($sn ne $existing_ft{$data[2]}[11]) {
			$sn_new = $existing_ft{$data[2]}[11];
			print "SN Differ: $sn - $sn_new ($old_eq_id : $eq_id)\n";
			$counter++;
			my $sql = "UPDATE fault_management.tbl_equipment SET serial_number = '$sn' WHERE ID = $eq_id";
			print $sql."\n";
			my $sth2 = $mysql_con->prepare($sql);
			$sth2->execute();
			$sth2->finish();
		}

		my $de = $data[12];
                if($de ne $existing_ft{$data[2]}[15]) {
                        $de_new = $existing_ft{$data[2]}[15];
                        $yde = $data[13];
                        print "DE Differ: $de - $de_new ($old_eq_id : $eq_id)\n";
                        $counter++;
                        my $sql = "UPDATE fault_management.tbl_equipment SET decommed = '$de', year_decommisoned = '$yde' WHERE ID = $eq_id";
                        print $sql."\n";
                        my $sth2 = $mysql_con->prepare($sql);
                        $sth2->execute();
                        $sth2->finish();
                }

		my $de = $data[13];
                if($de ne $existing_ft{$data[2]}[14]) {
                        $de_new = $existing_ft{$data[2]}[14];
                        print "DE Differ: $de - $de_new ($old_eq_id : $eq_id)\n";
                        $counter++;
			if($de eq '') {
				$de = 'null';
			} else {
				$de = "'$de'";
			}
                        my $sql = "UPDATE fault_management.tbl_equipment SET year_decommisoned = $de WHERE ID = $eq_id";
                        print $sql."\n";
                        my $sth2 = $mysql_con->prepare($sql);
                        $sth2->execute();
                        $sth2->finish();
                }

		my $co = $data[16];
                if($co ne $existing_ft{$data[2]}[18]) {
                        $co_new = $existing_ft{$data[2]}[18];
                        print "CO Differ: $co - $co_new ($old_eq_id : $eq_id)\n";
                        $counter++;
			$co =~ s/"//g;
                        my $sql = "UPDATE fault_management.tbl_equipment SET comment = \"$co\" WHERE ID = $eq_id";
                        print $sql."\n";
                        my $sth2 = $mysql_con->prepare($sql);
                        $sth2->execute();
                        $sth2->finish();
                }

		my $li = $data[7];
                if($li ne $existing_ft{$data[2]}[9]) {
                        $li_new = $existing_ft{$data[2]}[9];
                        print "LI Differ: $li - $li_new ($old_eq_id : $eq_id)\n";
                        $counter++;
                        my $sql = "UPDATE fault_management.tbl_equipment SET location_id = \"$li\" WHERE ID = $eq_id";
                        print $sql."\n";
                        my $sth2 = $mysql_con->prepare($sql);
                        $sth2->execute();
                        $sth2->finish();
                }

		my $lo = $data[8];
                if($lo ne $existing_ft{$data[2]}[10]) {
                        $lo_new = $existing_ft{$data[2]}[10];
                        print "LO Differ: $lo - $lo_new ($old_eq_id : $eq_id)\n";
                        $counter++;
                        my $sql = "UPDATE fault_management.tbl_equipment SET location = \"$lo\" WHERE ID = $eq_id";
                        print $sql."\n";
                        my $sth2 = $mysql_con->prepare($sql);
                        $sth2->execute();
                        $sth2->finish();
                }

		###### UPDATE  decommed, comment tomo etc
                $eq_lookup{$data[0]} = $existing_ft{$data[2]}[0];
                #print $data[0]." maps to ".$existing_ft{$data[2]}[0]."\n";
		if($sa_id) {
			#print "\tUPDATE SA to be $sa_id\n";
		}
	}	
}
#########################
print $counter. " equipment missing\n";


print "\n\n\n\n";
#############  faults
my %fault_names;
my %fault_names_old;
my %fault_names_dup;
my %fault_names_count;
my %fault_dates;
my $max = 0;
my $max = 53095;
%existing_ft = ();
$sql = "select * FROM fault_management.tbl_fault";
$sth = $mysql_con->prepare($sql);
$sth->execute();
my $ft_count = 0;
while (@data = $sth->fetchrow_array()) {
        $existing_ft{$data[0]} = [@data];
	$data[12] =~ s/[\n\r]/ /g;
	$data[9] =~ s/[\n\r]/ /g;
	$data[14] =~ s/[\n\r]/ /g;
	$data[12] =~ s/['"]//g;
	$data[9] =~ s/['"]//g;
	$data[14] =~ s/['"]//g;
	my $ft = $data[8];
	my $ft_name = $data[36];
	$ft_look = $existing_ft_lookup{$ft}; 

	$eq_id = $data[7];
	$eq_type_from_fault = $data[6];
	my @ex_eq = @{$existing_eq{$eq_id}};
	$eq_type_from_eq = $ex_eq[4];
	$ttt = $current_eq_type{$eq_type_from_eq};
	$eq_type_name = $data[34];
	if($eq_type_name ne $ttt) {
		if($ttt) {
			my $temp = "UPDATE fault_management.tbl_fault set e_type_name = '".$ttt."' WHERE ID = ".$data[0];
			print "$temp\n";
			my $sth2 = $mysql_con->prepare($temp);
			$sth2->execute();
			$sth2->finish();
		}
		#exit();
	}

	if($ft_name ne $ft_look) {
		my $temp = "UPDATE fault_management.tbl_fault set f_type_name = '".$ft_look."' WHERE ID = ".$data[0];
		if(1) {
			my $sth2 = $mysql_con->prepare($temp);
			$sth2->execute();
			$sth2->finish();
		}
		print "\n$temp";
		$ft_count++;
	}
	if($data[0] > 99999) {
		$max++;
		$theid = $max;
		$temp = "UPDATE fault_management.tbl_fault SET id = $theid  WHERE id = ".$data[0];
		print $temp."\n";
		if(0) {
			my $sth2 = $mysql_con->prepare($temp);
			$sth2->execute();
			$sth2->finish();
		}
	}
	#$fault_names{$data[12]}{$data[9]} = [@data];
	$fault_names{$data[12]}{$data[9]}{$data[14]} = [@data];
	$fault_names_dup{$data[12]}{$data[9]}{$data[14]}{$data[0]} = [@data];
	$fault_names_count{$data[12]}{$data[9]}{$data[14]}++;
	if($data[0] > $max) {
		#$max = $data[0];
	}
}
$sth->finish();

exit();


print "\nTotal: $ft_count\n";

$sql = "select * FROM faults";
$sth = $mysql_con->prepare($sql);
$sth->execute();
$counter  = 0;

while (@data = $sth->fetchrow_array()) {
        #if(!exists($existing_ft{$data[0]})) {
		$data[4] =~ s/['"]//g;
		$data[3] =~ s/['"]//g;
		$data[7] =~ s/['"]//g;
		$data[4] =~ s/[\n\r]/ /g;
		$data[3] =~ s/[\n\r]/ /g;
		$data[7] =~ s/[\n\r]/ /g;
			if($data[0] == 182) {
				#print "DEBUG: a$data[4]a\na$data[7]a\n";
				#exit();
			}
		$fault_names_old{$data[4]}{$data[3]}{$data[7]} = [@data];
		#if(exists($fault_names{$data[4]}{$data[3]})) {
		if(exists($fault_names{$data[4]}{$data[3]}{$data[7]})) {
			my $old_fault_id = $data[0];
			my $old_ft_id = $data[2];
			my $old_created_on = $data[24];
			my $new_created_on = $fault_names{$data[4]}{$data[3]}{$data[7]}[1];
			my $should_be_ft_id = $lookup_old_ft{$data[2]};
			my $ft_name  = $ft_lookup{$should_be_ft_id};
			#my $ft_id = $fault_names{$data[4]}{$data[3]}[8];
			my $ft_id = $fault_names{$data[4]}{$data[3]}{$data[7]}[8];
			my $matched_id = $fault_names{$data[4]}{$data[3]}{$data[7]}[0];
			if($old_created_on ne $new_created_on) {
				my $temp = "UPDATE fault_management.tbl_fault set last_modified = '$old_created_on', created_on = '$old_created_on' WHERE ID = '$matched_id'";
				#print $temp."\n";
				#$commit = 1;
				if(0) {
					my $sth2 = $mysql_con->prepare($temp);
					$sth2->execute();
					$sth2->finish();
				}
				$commit = 0;
			} else {
				#print "Matched $matched_id ($old_ft_id) - $old_created_on = $new_created_on\n";
			}
			my $sat_so = $data[18];
			my $sat_se = $data[19];
			my $sat_eq = $data[20];
			my $temp = "UPDATE fault_management.tbl_fault set satisfied_servicing_organisation = '$sat_so', satisfied_service_engineer = '$sat_se', satisfied_equipment = '$sat_eq' WHERE ID = '$matched_id'";
			if(0) {
				print "$temp\n";
				my $sth2 = $mysql_con->prepare($temp);
				$sth2->execute();
				$sth2->finish();
			}

			
			if($matched_id != $old_fault_id) {
				if($matched_id > 99999) {
					if(!exists($existing_ft{$data[0]})) {
						$temp = "UPDATE fault_management.tbl_fault SET id = $old_fault_id  WHERE id = $matched_id";
						print "$temp\n";
						if(0) {
							my $sth2 = $mysql_con->prepare($temp);
							$sth2->execute();
							$sth2->finish();
						}
					} else {
						#$temp = "DELETE FROM fault_management.tbl_fault WHERE id = $old_fault_id";
						#print $temp."\n";
						$max++;
						$theid = $max;
						$temp = "UPDATE fault_management.tbl_fault SET id = $theid  WHERE id = $old_fault_id";
						print $temp."\n";
						#my $sth2 = $mysql_con->prepare($temp);
						#$sth2->execute();
						#$sth2->finish();
						$temp = "UPDATE fault_management.tbl_fault SET id = $old_fault_id  WHERE id = $matched_id";
						print $temp."\n";
						if(0) {
							my $sth2 = $mysql_con->prepare($temp);
							$sth2->execute();
							$sth2->finish();
						}
					}
				} else {
					if(!exists($existing_ft{$data[0]})) {
						#print "UHOH: $matched_id should be $old_fault_id\n";
						#$counter++;
					} else {
					}
				}
			
			}
			if($should_be_ft_id != $ft_id) {
				#print "UHOH!!!!!: $matched_id has the wrong FT (Old: $old_ft_id, Current: $ft_id, Should be: $should_be_ft_id) - Old f_id: $data[0], New f_id: $matched_id\n";
				my $temp = "UPDATE fault_management.tbl_fault set fault_type = '$should_be_ft_id' WHERE ID = '$matched_id'";
				print $temp."\n";
				#$counter++;
				if(0) {
					my $sth2 = $mysql_con->prepare($temp);
					$sth2->execute();
					$sth2->finish();
				}
			}

			#print "\tFault exists, with name/date matching (Old: ".$data[0].", New: ".$matched_id.")\n";
			if(!exists($existing_ft{$data[0]})) {
				#print "\tOld ID is not in the new DB, so I could change the ID....\n";
				my $temp = "UPDATE fault_management.tbl_fault set ID = '".$data[0]."' WHERE ID = '$matched_id'";
				#print $temp."\n";
				#$counter++;
				if(0) {
					my $sth2 = $mysql_con->prepare($temp);
					$sth2->execute();
					$sth2->finish();
				}
			}
		} else {
			my $olf_ft_id = $data[2];
			my $old_eq_id = $data[1];
			my $eq_id = $eq_lookup{$old_eq_id};
			my @ex_eq = @{$existing_eq{$eq_id}};
			my $centre_id = $ex_eq[2];
			my $centre_name = $cen_name{$ex_eq[2]};
			if(!$centre_name) {
				next;
			}
			my $eq_type_id = $ex_eq[4];
			my $eq_type_name = $ex_eq[21];
			my $eq_name = $ex_eq[1];
			my $eq_code = $ex_eq[3];
			my $man_name = $man_name_lookup{$ex_eq[5]};
			my $desc = $data[4];
			$desc =~ s/"//g;
			$desc =~ s/'//g;
			$desc =~ s/[\n\r]/ /g;
			my $act_desc = $data[7];
			$act_desc =~ s/"//g;
			$act_desc =~ s/'//g;
			$act_desc =~ s/[\n\r]/ /g;
			$centre_name =~ s/'//g;
			$eq_name =~ s/'//g;
			$data[16] =~ s/'//g;
			$data[17] =~ s/'//g;
			$data[6] =~ s/'//g;
			if(!$man_name) {
				#print "DEBUG: $ex_eq[5] $data[0] ($eq_id)\n";
			}

			my $ft_id = $lookup_old_ft{$data[2]};
			my $ft_name  = $ft_lookup{$ft_id};
			if(!$ft_name) {
				#print "DEBUG: ($ft_id) ($data[2] $olf_ft_id) ($ft_name)\n";
			}

			my $theid;
			if(!exists($existing_ft{$data[0]})) {
				$theid = $data[0];		
			} else {
				$max++;
				$theid = $max;
			}
			my $sql = "INSERT INTO fault_management.tbl_fault VALUES ($theid, '".$data[24]."', '".$centre_id."', '".$data[23]."', '".$data[23]."', '', '$eq_type_id', '$eq_id', '$ft_id', '".$data[3]."', '".$data[5]."', '', \"".$desc."\", '".$data[6]."', \"".$act_desc."\", '".$data[27]."', '".$data[28]."', '".$data[29]."', '".$data[8]."', '".$data[9]."', '".$data[10]."', '".$data[11]."', '".$data[12]."', '".$data[13]."', '".$data[14]."', '".$data[18]."', '".$data[19]."', '".$data[20]."', '".$data[15]."', '".$data[16]."', '', '".$data[17]."', '".$data[22]."', '$eq_name', '$eq_type_name', '$centre_name', '$ft_name', '$eq_code', '$man_name', '".$data[26]."')";
			print $sql."\n";
			$counter++;
			if(0) {
				my $sth2 = $mysql_con->prepare($sql);
				$sth2->execute();
				$sth2->finish();
			}
			#$fault_names{$data[4]}{$data[3]}{$data[7]} = [@data];
		}
        #}
}
#########################
print $counter. " faults missing\n";


my $county = 0;
foreach $name (keys %fault_names) {
	foreach $date (keys %{$fault_names{$name}}) {
		foreach $act (keys %{$fault_names{$name}{$date}}) {
			if(!exists($fault_names_old{$name}{$date}{$act})) {
				my @temp = keys %{$fault_names_dup{$name}{$date}{$act}};
				$f_id = join(', ', @temp);
				my $centre_id = $fault_names{$name}{$date}{$act}[2];
				my $date = $fault_names{$name}{$date}{$act}[9];
				my $eq = $fault_names{$name}{$date}{$act}[7];
				my $ft = $fault_names{$name}{$date}{$act}[8];
				$sql = "SELECT * FROM fault_management.tbl_fault WHERE centre = '$centre_id' AND date_of_fault = '$date' AND equipment = '$eq'";
				$sth = $mysql_con->prepare($sql);
				$sth->execute();
				my $ft_count = 0;
				my %temper;
				while (@data = $sth->fetchrow_array()) {
					$temper{$data[0]} = 1;	
					print $data[3]." : ".$data[12]."\n";
					$ft_count++;
				}
				$sth->finish();
				if($ft_count > 0) {
					print "IN NEW, NOT OLD: $f_id ($centre_id - $date) - $ft_count - ".join(",", keys %temper)."\n";
				}
				
				$county++;
			}
		}
	}
}
#//LOOP THORUGH EACH AND check none are > 1
foreach $name (keys %fault_names_count) {
	foreach $date (keys %{$fault_names_count{$name}}) {
		foreach $act (keys %{$fault_names_count{$name}{$date}}) {
			if($fault_names_count{$name}{$date}{$act} > 1) {
				my @temp = keys %{$fault_names_dup{$name}{$date}{$act}};
				pop(@temp);
				$f_id = join(', ', @temp);
				my $temp = "DELETE FROM fault_management.tbl_fault WHERE ID in ($f_id)";
				print $temp."\n";
				if(0) {
					my $sth2 = $mysql_con->prepare($temp);
					$sth2->execute();
					$sth2->finish();
				}
			}
		}
	}
}
print "\n$county duplicates\n";
#fault_names_count
exit();



$sql = "select * FROM roles";
$sth = $mysql_con->prepare($sql);
$sth->execute();

while (@data = $sth->fetchrow_array()) {
	#$odbc->Run("INSERT INTO roles values ('".$data[0]."', '".sQuote($data[1])."')");
}
$sql = "select * FROM designation";
$sth = $mysql_con->prepare($sql);
$sth->execute();

while (@data = $sth->fetchrow_array()) {
	#$odbc->Run("INSERT INTO designation values ('".$data[0]."', '".sQuote($data[1])."')");
}

$sql = "select * FROM users";
$sth = $mysql_con->prepare($sql);
$sth->execute();

while (@data = $sth->fetchrow_array()) {
	#$odbc->Run("INSERT INTO users values ('".$data[0]."', '".sQuote($data[1])."', '".sQuote($data[2])."', '".sQuote($data[3])."', '".sQuote($data[4])."', '".sQuote($data[5])."', '".sQuote($data[6])."', '".sQuote($data[7])."', '".sQuote($data[8])."', '".sQuote($data[9])."')");
}

$sql = "select * FROM equipment_status";
$sth = $mysql_con->prepare($sql);
$sth->execute();

while (@data = $sth->fetchrow_array()) {
	#$odbc->Run("INSERT INTO equipment_status values ('".$data[0]."', '".sQuote($data[1])."')");
}

$sql = "select * FROM equipment_use_status";
$sth = $mysql_con->prepare($sql);
$sth->execute();

while (@data = $sth->fetchrow_array()) {
	#$odbc->Run("INSERT INTO equipment_use_status values ('".$data[0]."', '".sQuote($data[1])."')");
}

$sql = "select * FROM equipment";
$sth = $mysql_con->prepare($sql);
$sth->execute();

#$service_agent='1';
#$odbc->Run("INSERT INTO equipment values ('1', '', 'JBA1S', '28', '63', '71', '491', '0', '', 'N.Hants satellite', '1990', '0', '1990', '1', '2001', '0', 'To be replaced by NOF.', ".$service_agent.", '1')");


while (@data = $sth->fetchrow_array()) {
	if (!defined $data[16]){
		$service_agent = 'Null';
	}else{
		$service_agent = $data[16];
	}
	
	if (!defined $data[5]){
		$manuf = 'Null';
	}else{
		$manuf = $data[5];
	}
	
	if (!defined $data[6]){
		$model = 'Null';
	}else{
		$model = $data[6];
	}
	
	if (!defined $data[17]){
		$eqp_status = 'Null';
	}else{
		$eqp_status = $data[17];
	}
	if (!defined $data[13]){
		$d_year = 'Null';
	}else{
		$d_year = $data[13];
	}
	#$odbc->Run("INSERT INTO equipment values ('".$data[0]."', '".sQuote($data[1])."', '".sQuote($data[2])."', '".sQuote($data[3])."', '".sQuote($data[4])."', ".$manuf.", ".$model.", '".sQuote($data[7])."', '".sQuote($data[8])."', '".sQuote($data[9])."', '".sQuote($data[10])."', '".sQuote($data[11])."', '".sQuote($data[12])."', ".$d_year.", '".$data[14]."', '".sQuote($data[15])."', ".$service_agent.", ".$eqp_status.")");
}

$sql = "select * FROM allowable_fault_types";	
$sth = $mysql_con->prepare($sql);
$sth->execute();

while (@data = $sth->fetchrow_array()) {
	#$odbc->Run("INSERT INTO allowable_fault_types values ('".$data[0]."', '".sQuote($data[1])."')");
}

$sql = "select * FROM faults";
$sth = $mysql_con->prepare($sql);
$sth->execute();

while (@data = $sth->fetchrow_array()) {
	#$odbc->Run("INSERT INTO faults values ('".$data[0]."', '".sQuote($data[1])."', '".sQuote($data[2])."', '".sQuote($data[3])."', '".sQuote($data[4])."', '".sQuote($data[5])."', '".sQuote($data[6])."', '".sQuote($data[7])."', '".sQuote($data[8])."', '".sQuote($data[9])."', '".sQuote($data[10])."', '".sQuote($data[11])."', '".sQuote($data[12])."', '".sQuote($data[13])."', '".sQuote($data[14])."', '".sQuote($data[15])."', '".sQuote($data[16])."', '".sQuote($data[17])."', '".sQuote($data[18])."', '".sQuote($data[19])."', '".sQuote($data[20])."', '".sQuote($data[21])."', '".sQuote($data[22])."', '".sQuote($data[23])."', '".$data[24]."', '".$data[25]."', '".$data[26]."',  '".$data[27]."',  '".$data[28]."',  '".$data[29]."')");
}

$sql = "select * FROM service_agent_tracking";
$sth = $mysql_con->prepare($sql);
$sth->execute();

while (@data = $sth->fetchrow_array()) {
	#$odbc->Run("INSERT INTO service_agent_tracking values ('".$data[0]."', '".sQuote($data[1])."', '".sQuote($data[2])."')");
}


exit();
