<?php
/**********************************************************
 *               phpMySQLAutoBackup                       *
 *         (uses the MySQL export library from            *
 *        the excellent http://www.phpmyadmin.net)        *
 *                                                        *
 *           Author:  http://www.DWalker.co.uk            *
 *            Now released under GPL License              *
 *                                                        *
 **********************************************************
 *     Version    Date              Comment               *
 *     0.2.0      7th July 2005     GPL release           *
 *     0.3.0      19th June 2006  Upgrade                 *
 *           - added ability to backup separate tables    *
 *     0.4.0      Dec 2006   removed bugs/improved code   *
 **********************************************************/
$phpMySQLAutoBackup_version="0.4.0";
// ---------------------------------------------------------
// For support and help please try the forum at: http://www.dwalker.co.uk/forum/

// variables you need add your details below:
$db = "equipment_section"; // your MySQL database name
$mysql_username = "root";  // your MySQL username
$mysql_password = "";  // your MySQL password
$emailaddress = "uniqueraihan007@yahoo.com";  // your email address to send backup files to
            //best to specify an email address on a different server than the MySQL db  ;-)

$save_backup_zip_file_to_server = 1; // if set to 1 then the backup files will be saved in the folder: /phpMySQLAutoBackup/backups/
                                    //(you must also chmod this folder for write access to allow for file creation)

// Below you can uncomment the variables to specify separate tables to backup,
// leave commented out and ALL tables will be included in the backup.
//$table_select[0]="MyFirstTableName";
//$table_select[1]="mySecondTableName";
//$table_select[2]="myThirdTableName";
//note: when you uncomment $table_select only the named tables will be backed up.

$limit_to=10000000; //total rows to export - IF YOU ARE NOT SURE LEAVE AS IS
$limit_from=0; //record number to start from - IF YOU ARE NOT SURE LEAVE AS IS
//the above variables are used in this formnat:
//  SELECT * FROM tablename LIMIT $limit_from , $limit_to

// Turn off all error reporting
error_reporting(0);

// For debugging uncomment line below:
error_reporting(E_ALL);

// No more changes required below here
// ---------------------------------------------------------
chdir("files");
include("phpmysqlautobackup.php");
?>
