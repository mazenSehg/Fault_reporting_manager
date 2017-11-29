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
my $sql = "select * FROM fault_management.tbl_fault_type";
my $sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
	$existing_ft{$data[1]} = \@data;
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
%existing_ft = ();
$sql = "select * FROM fault_management.tbl_equipment_type";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
        $existing_ft{$data[1]} = \@data;
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
        $existing_ft{$data[1]} = [@data];
	$cen_name{$data[0]} = $data[1];
}
$sth->finish();

$sql = "select * FROM centre";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
	if(!exists($existing_ft{$data[1]})) {
		$temp = "Missing Centre: ".$data[1];
		print $temp."\n";
	}	
	$cen_lookup{$data[0]} = $existing_ft{$data[1]}[0];
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
        $existing_ft{$data[1]} = [@data];
}
$sth->finish();

$sql = "select * FROM model";
$sth = $mysql_con->prepare($sql);
$sth->execute();

while (@data = $sth->fetchrow_array()) {
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
%existing_ft = ();
my %existing_eq = ();
$sql = "select * FROM fault_management.tbl_equipment";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
        $existing_ft{$data[3]} = [@data];
        $existing_eq{$data[0]} = [@data];
}
$sth->finish();

$sql = "select * FROM equipment";
$sth = $mysql_con->prepare($sql);
$sth->execute();
my $counter  = 0;

while (@data = $sth->fetchrow_array()) {
	my $sa_id;
	if($data[16]) {
		$sa_id = $sa_lookup{$data[16]};
	}
	if(!exists($existing_ft{$data[2]})) {
		$temp = "Missing Equipment: ".$data[2];
		print $temp."\n";

		my $centre_id = $cen_lookup{$data[4]};
		my $eq_type = $et_lookup{$data[3]};
		my $type_name = $et_lookup_string{$data[3]};
		my $man_name = $man_lookup_string{$data[5]};
		my $mod_name = $mod_lookup_string{$data[6]};
		my $sup_id;
		my $name = $man_name." | ".$mod_name." | ".$data[1]." | ".$data[11]." | ".$data[7]." | ".$data[8];

		$temp = "INSERT INTO fault_management.tbl_equipment values (null, '".sQuote($name)."', '$centre_id', '".$data[2]."', '$eq_type', '".$man_lookup{$data[5]}."', '".$mod_lookup{$data[6]}."', '$sup_id', '$sa_id', '".$data[7]."', '".$data[8]."', '".$data[1]."', '".$data[9]."', '".$data[11]."', '".$data[13]."', '".$data[12]."', '".$data[14]."', '".$data[15]."', '".$data[10]."', 1, '".$data[19]."', '".$type_name."', '".$data[21]."')";
                print $temp."\n";
                $last_id = 'PLACEHOLDER';
                if($commit) {
                        my $sth2 = $mysql_con->prepare($temp);
                        $sth2->execute();
                        $last_id = $sth2->{mysql_insertid};
                        $sth2->finish();
                }
                $eq_lookup{$data[0]} = $last_id;
		$counter++;
        } else {
                $eq_lookup{$data[0]} = $existing_ft{$data[2]}[0];
                #print $data[0]." maps to ".$existing_ft{$data[2]}[0]."\n";
		if($sa_id) {
			#print "\tUPDATE SA to be $sa_id\n";
		}
	}	
}
#########################
print $counter. " equipment missing\n";


#############  faults
my %fault_names;
my %fault_names_count;
my %fault_dates;
%existing_ft = ();
$sql = "select * FROM fault_management.tbl_fault";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
        $existing_ft{$data[0]} = [@data];
	$fault_names{$data[12]}{$data[9]} = [@data];
}
$sth->finish();

$sql = "select * FROM faults";
$sth = $mysql_con->prepare($sql);
$sth->execute();
$counter  = 0;
$commit = 0;

while (@data = $sth->fetchrow_array()) {
	$fault_names_count{$data[4]}{$data[3]}++;
        #if(!exists($existing_ft{$data[0]})) {
		if(exists($fault_names{$data[4]}{$data[3]})) {
			my $matched_id = $fault_names{$data[4]}{$data[3]}[0];
			#print "\tFault exists, with name/date matching (Old: ".$data[0].", New: ".$matched_id.")\n";
			if(!exists($existing_ft{$data[0]})) {
				print "\tOld ID is not in the new DB, so I could change the ID....\n";
				my $temp = "UPDATE tbl_fault set ID = '".$data[0]."' WHERE ID = '$matched_id'";
				#print $temp."\n";
				if($commit) {
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
			my $eq_type_id = $ex_eq[4];
			my $eq_type_name = $ex_eq[21];
			my $eq_name = $ex_eq[1];
			my $eq_code = $ex_eq[3];
			my $man_name = $man_name_lookup{$ex_eq[5]};

			my $ft_id = $lookup_old_ft{$data[2]};
			my $ft_name  = $ft_lookup{$ft_id};

			my $sql = "INSERT INTO tbl_faults VALUES (null, '".$data[24]."', '".$centre_id."', '".$data[23]."', '".$data[23]."', '', '$eq_type_id', '$eq_id', '$ft_id, '".$data[3]."', '".$data[5]."', '', '".$data[4]."', '".$data[6]."', '".$data[7]."', '".$data[27]."', '".$data[28]."', '".$data[29]."', '".$data[8]."', '".$data[9]."', '".$data[10]."', '".$data[11]."', '".$data[12]."', '".$data[13]."', '".$data[14]."', '".$data[18]."', '".$data[19]."', '".$data[20]."', '".$data[15]."', '".$data[16]."', '', '".$data[17]."', '".$data[22]."', '$eq_name', '$eq_type_name', '$centre_name', '$ft_name', '$eq_code', '$man_name', '".$data[26]."')";

			print $sql."\n";
			$counter++;
			exit();
		}
        #}
}
#########################
print $counter. " faults missing\n";

#//LOOP THORUGH EACH AND check none are > 1
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
