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

if(($db=="")OR($mysql_username=="")OR($emailaddress==""))
{
 echo "Configure your installation BEFORE running, add your details to the file /phpMySQLAutoBackup/run.php";
 exit;
}

if (isset($table_select))
{
 $backup_type="\nBACKUP Type: partial, includes tables:\n";
 foreach ($table_select as $key => $value) $backup_type.= "$value;\n";
}
else $backup_type="\nBACKUP Type: Full database backup (all tables included)\n\n";

include "phpmysqlautobackup_extras.php";

// Get phpMyAdmin functions to export MySQL data and structures
//  library from: http://www.phpmyadmin.net
include "phpmyadmin_export.php";

// zip the backup and email it
$backup_file_name = 'mysql_'.$db.strftime("_%d_%b_%Y_time_%H_%M_%S.sql",time()).'.gz';
$dump_buffer = "#Backup automated by phpMySQLAutoBackup\r\n#  from: http://www.DWalker.co.uk\r\n#\r\n".$dump_buffer;
$dump_buffer = gzencode($dump_buffer);

xmail ($emailaddress, "phpMySQLAutoBackup: $backup_file_name", $dump_buffer, $backup_file_name, $backup_type);

if ($save_backup_zip_file_to_server) write_backup($dump_buffer, $backup_file_name);

// get that broom out and clean up
$dump_buffer="";
$dump_buffer_len = 0;
?>
