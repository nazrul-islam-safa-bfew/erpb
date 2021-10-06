<?php
include("common.php");
CreateConnection();
$trk_id = $_GET['item_trk'];
//retreive equipments cirrent meter reading based on the selected equipment tracking id
$qry="SELECT item_curr_kilometer FROM track_equipments WHERE itm_track_id='$trk_id'";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_fetch_row($qryexecute);
$curr_meter_reading=$rs[0];
echo"$curr_meter_reading";
 ?>