<?php
include('../includes/config.inc.php');
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
mysql_select_db($SESS_DBNAME,$db);

//this is the php file called from JS function
$ptype=$_GET['d']; //get the value sended from JS function
$selected_value=$_GET['s'];

if($ptype==0)
{
$query1="select district.dist_des, district.div_id, division.div_id, division.div_des from division,district where district.div_id=division.div_id order by district.dist_des";
$result1=mysql_query($query1);
print '<select id="inputtext3" name="pcity" style="width:200px;" onChange="changetextbox();">
		<option value="0">Select Division</option>';
while ($row1=mysql_fetch_array($result1)) 
{
$dist_des=$row1['dist_des'];
print "<option value='$dist_des'>$dist_des</option>";
}
}
else
{
 $query="select distinct dist_des,dist_id from district where div_id='$ptype' order by dist_des";
$result=mysql_query($query);
print '<select id="inputtext3" name="pcity" style="width:200px;" onChange="changetextbox();">
		<option value="0">Select City</option>';
while ($row=mysql_fetch_array($result)) 
{
$dist_des=$row['dist_des'];
$dist_id=$row['dist_id'];
$selected="";

if($selected_value==$dist_id)
	$selected="selected";

print "<option value='$dist_id' ".$selected.">$dist_des</option>";
}
print "</select>";
}

?> 