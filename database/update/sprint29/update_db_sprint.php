<?php
$sprintDir = dirname(__FILE__);
require_once "$sprintDir/../../../lib/share.php";

// -----------------------------------------------------------------------------------------
// Synopsis: migrate DB GINCO from sprint 28 to sprint 29 (Nothing to do because it's the same)
// -----------------------------------------------------------------------------------------
function usage($mess = NULL) {
	echo "------------------------------------------------------------------------\n";
	echo ("\nUpdate DB from sprint 27 to 28\n");
	echo ("> php update_db_sprint.php -f <configFile> [{-D<propertiesName>=<Value>}]\n\n");
	echo "o <configFile>: a java style properties file for the instance on which you work\n";
	echo "o -D : inline options to complete or override the config file.\n";
	echo "------------------------------------------------------------------------\n";
	if (!is_null($mess)) {
		echo ("$mess\n\n");
		exit(1);
	}
	exit();
}

if (count($argv) == 1)
	usage();
$config = loadPropertiesFromArgs();

try {
	/* patch code here*/
	execCustSQLFile("$sprintDir/ogam_update_script_v4.0.0_to_v4.1.0.sql", $config);
	execCustSQLFile("$sprintDir/predefined_request_delete_cascade.sql", $config);
	execCustSQLFile("$sprintDir/ref_deefloutagevalue.sql", $config);
	execCustSQLFile("$sprintDir/add_en_wfs_and_legend.sql", $config);
	execCustSQLFile("$sprintDir/update_bbox_params.sql", $config);
	execCustSQLFile("$sprintDir/change_time_case.sql", $config);

} catch (Exception $e) {
	echo "$sprintDir/update_db_sprint.php\n";
	echo "exception: " . $e->getMessage() . "\n";
	exit(1);
}


$CLIParams = implode(' ', array_slice($argv, 1));
/* patch user raw_data here */
  system("php $sprintDir/change_datedetermination_and_jourdate_type_to_date.php $CLIParams", $returnCode1);

if ($returnCode1 != 0) {
	echo "$sprintDir/update_db_sprint.php\n";
	echo "exception: " . $e->getMessage() . "\n";
	exit(1);
}
