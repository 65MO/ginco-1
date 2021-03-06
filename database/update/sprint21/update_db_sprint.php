<?php
$sprintDir = dirname(__FILE__);
require_once "$sprintDir/../../../lib/share.php";

#-------------------------------------------------------------------------------
# Synopsis: migrate DB GINCO from sprint 20 to sprint 21
#-------------------------------------------------------------------------------
function usage($mess = NULL)
{
	echo "------------------------------------------------------------------------\n";
	echo("\nUpdate DB from sprint 20 to sprint 21\n");
	echo("> php update_db_sprint.php -f <configFile> [{-D<propertiesName>=<Value>}]\n\n");
	echo "o <configFile>: a java style properties file for the instance on which you work\n";
	echo "o -D : inline options to complete or override the config file.\n";
	echo "------------------------------------------------------------------------\n";
	if (!is_null($mess)) {
	echo("$mess\n\n");
		exit(1);
	}
	exit;
}

if (count($argv) == 1) usage();
$config = loadPropertiesFromArgs();


try {
	/* patch code here */
    execCustSQLFile("$sprintDir/layers_adapted_to_radio_buttons.sql", $config);
    execCustSQLFile("$sprintDir/export_file.sql", $config);
    execCustSQLFile("$sprintDir/default_bounding_box.sql", $config);
    execCustSQLFile("$sprintDir/add_en_layers.sql", $config);
    execCustSQLFile("$sprintDir/update_ref_espece_sensible.sql", $config);
    execCustSQLFile("$sprintDir/delete_permission_access_geosource.sql", $config);
    execCustSQLFile("$sprintDir/increase_columns_lengths_for_dee_export.sql", $config);
} catch(Exception $e){
	echo "$sprintDir/update_db_sprint.php\n";
	echo "exception: ". $e->getMessage() . "\n" ;
	exit(1);
}
