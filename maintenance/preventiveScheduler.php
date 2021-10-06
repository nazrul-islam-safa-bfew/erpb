<?php
include("../includes/config.inc.php");
$db=mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
include("../includes/myFunction.php");
include("../includes/eqFunction.inc.php");

$eqIOWCODE=array();
$allPreventive_sql="select * from eqmaintenance where maintenanceType='p' and iowCode in (select iowCode from iow where iowProjectCode='004') group by iowCode";
$allPreventive_q=mysqli_query($db,$allPreventive_sql);
while($allPreventive_r=mysqli_fetch_array($allPreventive_q)){
  
  $iowCode=$allPreventive_r[iowCode];  
  $eqIOWCODE_c=uniqueMaintenanceIOW_code($iowCode);
  if(in_array($eqIOWCODE_c,$allPreventive_r)===0 || in_array($eqIOWCODE_c,$allPreventive_r))return false;
  $eqIOWCODE[]=$eqIOWCODE_c;
  
  $eqItemCode=$allPreventive_r[eqItemCode];
  $allSimilarEq_sql="select * from equipment where itemCode='$eqItemCode'";
  $allSimilar_q=mysqli_query($db,$allSimilarEq_sql);
  while($allSimilar_r=mysqli_fetch_array($allSimilar_q)){
    print_r($allSimilar_r);
  }
}







?>