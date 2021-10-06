<?php
$folder="../includes/";
include($folder."config.inc.php");
$db=mysqli_connect($SESS_DBHOST,$SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);


if($_GET[action]!="rollback" && ($_GET[iowID] || $_GET[des] || $_GET[iowCode]) && $_GET[p]){
  $sql="select * from iowback where iowProjectCode='$_GET[p]' and ";

  if($_GET[des])
    $sql.=" iowDes like '$_GET[des]' ";
  elseif($_GET[iowID])
    $sql.=" iowId='$_GET[iowID]' ";
  elseif($_GET[iowCode])
    $sql.=" iowCode like '$_GET[iowCode]' ";

  $sql.=" order by revisionNo desc";
  
  $q=mysqli_query($db,$sql);
  echo "<ol>";
  while($data=mysqli_fetch_array($q)){
    echo "<li><a href='./systemTools.php?iowId=$data[iowId]&revisionNo=$data[revisionNo]&action=rollback&p=$data[iowProjectCode]'>$data[iowCode]: $data[iowDes] : $data[iowProjectCode] ($data[revisionNo])</a></li>";
  }
  echo "</ol>";
}

if($_GET[action]=="rollback" && $_GET[iowId] && $_GET[revisionNo] && $_GET[p]){
  
  mysqli_query($db,"insert into iow (select * from iowback where iowId='$_GET[iowId]' and revisionNo='$_GET[revisionNo]')");
  if(mysqli_affected_rows($db)>0)echo "<br>Iow backed!<br>";
  else echo "<br>Error in iow back".mysqli_error($db);
  
  
  mysqli_query($db,"insert into siow (select * from siowback where iowId='$_GET[iowId]' and revisionNo='$_GET[revisionNo]')");
  if(mysqli_affected_rows($db)>0)echo "<br>SIow backed<br>";
  else echo "<br>Error in siow back".mysqli_error($db);
  
  
  mysqli_query($db,"insert into dma (select * from dmaback where dmaiow='$_GET[iowId]' and revisionNo='$_GET[revisionNo]')");
  if(mysqli_affected_rows($db)>0)echo "<br>Resource backed<br>";
  else echo "<br>Error in resource back".mysqli_error($db);
}



?>