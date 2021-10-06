<?php
include("../includes/session.inc.php");
include("../includes/config.inc.php");
include("../includes/myFunction.php");
include("../includes/myFunction1.php");
include("../includes/empFunction.inc.php");

$db=mysqli_connect($SESS_DBHOST,$SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$monthSelector=$_GET["monthSelector"];
$sortBy=$_GET["sortBy"];
$employeeSelector=$_GET["employeeSelector"];
$empId=$_GET["empSelected"];
$project=$_GET["project"];

if($sortBy=="designation"){
  $sqlp = "SELECT i.itemCode,i.itemDes from
   employee as e,`itemlist` as i,attendance as a Where
   a.empId=e.empId and e.status='0' AND i.itemCode >= '87-00-000' AND i.itemCode < '98-01-000' AND i.itemCode=designation AND e.location='$project' ";
  
  if($monthSelector)$sqlp.=" and a.edate like '$monthSelector' ";  
  $sqlp.=" group by e.designation ORDER by e.designation,e.empId ASC";
//   echo $sqlp;
  
  $sqlrunp=mysqli_query($db, $sqlp);
   while($typel=mysqli_fetch_array($sqlrunp))
  {
     echo "<option value='".$typel[itemCode]."'";
     if($selected==$typel[itemCode]) echo "SELECTED";
     echo ">$typel[itemDes]--$typel[itemCode]</option>";
   }
  
}elseif($sortBy=="employee"){
  $sqlp = "SELECT i.itemCode,i.itemDes,e.empId,e.name from
   employee as e,`itemlist` as i,attendance as a Where
   a.empId=e.empId and e.status='0' AND i.itemCode >= '87-00-000' AND i.itemCode < '98-01-000' AND i.itemCode=designation AND e.location='$project' ";
  
  if($monthSelector)$sqlp.=" and a.edate like '$monthSelector' ";  
  $sqlp.=" group by a.empId ORDER by e.designation,e.empId ASC";
//   echo $sqlp;
  
  $sqlrunp=mysqli_query($db, $sqlp);
   while($typel=mysqli_fetch_array($sqlrunp))
  {
     echo "<option value='".$typel[empId]."'";
     if($selected==$typel[empId]) echo "SELECTED";
     echo ">".empId($typel[empId],$typel[itemCode])."--$typel[itemDes]--$typel[name]</option>";
   }
}

?>