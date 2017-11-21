#!/usr/bin/perl -w
 
use Data::Dumper;
use DBI;
use DBD::mysql;
use File::Copy;
use Cwd;
use diagnostics;
use sigtrap;


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
		$temp = "INSERT INTO equipment_types values ('".$data[0]."', '".sQuote($data[2])."', '".sQuote($data[1])."', null, 1, now())";
		print $temp."\n";
	}	
}
#########################

print "\n";
############# INCIDENT BODY
%existing_ft = ();
my %body_lookup;
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
$sql = "select * FROM fault_management.tbl_centres";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
        $existing_ft{$data[1]} = [@data];
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
	#$odbc->Run("INSERT INTO centre values ('".$data[0]."', '".sQuote($data[1])."', '".sQuote($data[2])."', '".sQuote($data[3])."', '".sQuote($data[4])."', '".sQuote($data[5])."', '".sQuote($data[6])."', '".sQuote($data[7])."', '".sQuote($data[8])."', '".sQuote($data[9])."', '".sQuote($data[10])."', '".sQuote($data[11])."', '".sQuote($data[12])."', '".sQuote($data[13])."', '".sQuote($data[14])."', '".sQuote($data[15])."', '".$data[16]."')");
}
#########################

print "\n";
############# MANUFACTURERS
%existing_ft = ();
$sql = "select * FROM fault_management.tbl_manufacturer";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
        $existing_ft{$data[1]} = [@data];
}
$sth->finish();

$sql = "select * FROM manufacturer";
$sth = $mysql_con->prepare($sql);
$sth->execute();

while (@data = $sth->fetchrow_array()) {
	if(!exists($existing_ft{$data[1]})) {
		$temp = "Missing Manufacturer: ".$data[1];
		print $temp."\n";
	}	
}
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
		$temp = "Missing Model: ".$data[1];
		print $temp."\n";
	}	
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
	}	
}
#########################



print "\n";
############# equipment
%existing_ft = ();
$sql = "select * FROM fault_management.tbl_equipment";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
        $existing_ft{$data[3]} = [@data];
}
$sth->finish();

$sql = "select * FROM equipment";
$sth = $mysql_con->prepare($sql);
$sth->execute();
my $counter  = 0;

while (@data = $sth->fetchrow_array()) {
	if(!exists($existing_ft{$data[2]})) {
		$temp = "Missing Equipment: ".$data[2];
		print $temp."\n";
		$counter++;
	}	
}
#########################

print $counter. " equipment missing\n";

#############  faults
%existing_ft = ();
$sql = "select * FROM fault_management.tbl_fault";
$sth = $mysql_con->prepare($sql);
$sth->execute();
while (@data = $sth->fetchrow_array()) {
        $existing_ft{$data[0]} = [@data];
}
$sth->finish();

$sql = "select * FROM faults";
$sth = $mysql_con->prepare($sql);
$sth->execute();
$counter  = 0;

while (@data = $sth->fetchrow_array()) {
        if(!exists($existing_ft{$data[0]})) {
                $temp = "Missing Fault: ".$data[0];
                print $temp."\n";
		$counter++;
        }
}
#########################
print $counter. " faults missing\n";

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
