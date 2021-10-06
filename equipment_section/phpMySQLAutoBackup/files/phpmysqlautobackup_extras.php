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
require('./db_details_common.php');
require('./db_details_db_info.php');
// -----------------------------------------------------------------------
// pre-set variables required by the phpMyAdmin export library
if (!isset($table_select)) $table_select = get_table_names($num_tables, $tables);
$lang = "en-iso-8859-1";
$save_on_server = "1";
$server = "1";
$export_type = "database";
$csv_data = "csv_data";
$excel_data = "excel_data";
$xml_data = "xml_data";
$what = "sql";
$sql_structure = "structure";
$drop = "1";
$auto_increment = "1";
$use_backquotes = "1";
$sql_data = "data";
$extended_ins = "yes";
$sql_type = "insert";
$latex_caption = "yes";
$latex_structure = "structure";
$latex_structure_caption = "Structure of table __TABLE__";
$latex_structure_continued_caption = "Structure of table __TABLE__ (continued)";
$latex_structure_label = "tab:__TABLE__-structure";
$latex_data = "data";
$latex_showcolumns = "yes";
$latex_data_caption = "Content of table __TABLE__";
$latex_data_continued_caption = "Content of table __TABLE__ (continued)";
$latex_data_label = "tab:__TABLE__-data";
$latex_replace_null = "\textit{NULL}";
$separator = ";";
$enclosed = "\"";
$escaped = '\\';
$add_character = "\r\n";
$csv_replace_null = "NULL";
$excel_replace_null = "NULL";
$excel_edition = "win";
$filename_template = "__DB__";
$remember_template = "ON";
$compression = "none";
// -----------------------------------------------------------------------

function get_table_names($num_tables, $tables)
{
 if ($num_tables > 1)
 {
    $i=0;
    while ($i < $num_tables)
    {
     $table_select[$i] = $tables[$i]['Name'];
     $i++;
    }
 }
 else $table_select = array();
 return $table_select;
}

function xmail ($emailaddress, $subject, $content, $file_name, $backup_type)
{
 $mail_attached = "";
 $boundary = "----=_NextPart_000_01FB_010".md5($emailaddress);
 $mail_attached.="--".$boundary."\n"
                       ."Content-Type: application/octet-stream;\n name=\"$file_name\"\n"
                       ."Content-Transfer-Encoding: base64\n"
                       ."Content-Disposition: attachment; \n filename=\"$file_name\"\n\n"
                       .chunk_split(base64_encode($content))."\n";
 $mail_attached .= "--".$boundary."--\n";
 $add_header ="MIME-Version: 1.0\nContent-Type: multipart/mixed;\n        boundary=\"$boundary\" \n\n";
 $mail_content="--".$boundary."\n"."Content-Type: text/plain; \n charset=\"iso-8859-1\"\n"."Content-Transfer-Encoding: 7bit\n\nBACKUP Successful...\n\nPlease see attached for your zipped Backup file; $backup_type \nIf this is the first backup then you should test it restores correctly to a test server.\n\n phpMySQLAutoBackup is developed by http://www.dwalker.co.uk/ \n\n Have a good day now you have a backup of your MySQL db  ;-) \n\nPlease consider making a donation at: \n http://www.dwalker.co.uk/make_a_donation.php \n (any amount is gratefully received)\n".$mail_attached;
// return mail($emailaddress, $subject, $mail_content, "From: $emailaddress\nReply-To:$emailaddress\n".$add_header);
}

function write_backup($gzdata, $backup_file_name)
{
 $fp = fopen("../backups/".$backup_file_name, "w");
 fwrite($fp, $gzdata);
 fclose($fp);
}
?>
