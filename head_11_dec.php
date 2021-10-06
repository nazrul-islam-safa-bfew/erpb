<?php
error_reporting(1);
$mbox = imap_open ("{imap.dreamhost.com:110/pop3}INBOX", "webmaster@bfew.net", "Suvro2014");
$headers = imap_headers($mbox);
$last = imap_num_msg($mbox);
$header[] = imap_header($mbox, $last);
$header[] = imap_header($mbox, $last-1);
$header[] = imap_header($mbox, $last-2);

imap_close($mbox);
foreach($header as $h){
    $txt[] = str_split(trim($h->subject), 20)[0]."; ".str_split(trim($h->Date), 24)[0];
}



$myfile = fopen("last_email.txt", "w+") or die("Unable to open file!");
// fwrite($myfile, str_split($txt,10)[0]);
fwrite($myfile, json_encode($txt));
fclose($myfile);
?>
