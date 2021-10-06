<?php
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
include_once("../includes/myFunction.php");
include_once("../includes/myFunction1.php");
$todat=todat();
$dateOfDay=todat_new_format("D");


//hiliday 
$hsql="select pcode from projectcalender where hdate='$todat'";
$hq=mysqli_query($db,$hsql);
while($Hrow=mysqli_fetch_array($hq)){$calender[]=$Hrow[pcode];}



$p_sql="insert into attendance (empId,edate,action,stime,etime,todat,location) values ";
//end holiday
$sql="select empId,location from employee where salaryType in ('Salary','Consolidated') and status=0 and empId not in (select empId from attendance where edate='$todat' group by empId) and location!=''";
 $q=mysqli_query($db,$sql);
echo "$todat<br>";
echo "Total employee found:#".mysqli_affected_rows($db);
echo "<br>Calendar contain has:<br>";
if(is_array($calender)){
  foreach($calender as $cal)
     echo "Project #".$cal." Holiday Absence<br>";
}
else
  echo "No holiday";

 while($row=mysqli_fetch_array($q)){
  $action=is_array($calender) ? (in_array($row[location],$calender)==true ? "HA" : "A") : ($dateOfDay=="Fri" ? "HA" : "A");   
  $p_sql.=" ($row[empId],'$todat','$action','00:00:00','00:00:00','$todat','$row[location]'),";
 }
$p_sql=trim($p_sql,",");
mysqli_query($db,$p_sql);
if(mysqli_affected_rows($db)>0)echo "<p>#".mysqli_affected_rows($db)." Employee was presented</p>";
else "<p>Error in: ".mysqli_error($db)."</p>";
?>
