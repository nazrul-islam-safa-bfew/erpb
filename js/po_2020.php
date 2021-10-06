<?php
$SESS_DBHOST = "mysql.bfew.net";			/* database server hostname */
$SESS_DBNAME = "bfew2";				/* database name */
$SESS_DBUSER = "dbbfew";				/* database user */
$SESS_DBPASS = "dbbfew007";			/* database password */
$SESS_DBH = "";

$db=mysqli_connect($SESS_DBHOST, $SESS_DBUSER, $SESS_DBPASS, $SESS_DBNAME);
$po=GET["the_po_number"];
$sql="SELECT * FROM `porder` WHERE `posl` LIKE '$po' limit 1";
$q=mysqli_query($db,$sql);
while($row=mysqli_fetch_array($q)){
    // print_r($row);
    $sql2="update poschedule set sdate='2020-01-31' where posl='$po'";
    mysqli_query($db,$sql2);
    $sql2=" update poscheduletemp set sdate='2020-01-31' where posl='$po' ";
    mysqli_query($db,$sql2);
}
?>