<?php
  include("../includes/session.inc.php");
  include("../includes/config.inc.php");

  $db=mysqli_connect($SESS_DBHOST,$SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

  $sql="select * from `leave` where status='3' and pdf!=''";
  $q=mysqli_query($db,$sql);
  while($row=mysqli_fetch_array($q)){

    $sql="update `attendance` set `action`='L' where empId='$row[empId]' and edate>='$row[sdate]' and  edate<='$row[edate]' limit $row[leavePeriod] ";
    mysqli_query($db,$sql);
//echo mysqli_error($db);

  }
//echo ("<meta http-equiv=\"refresh\" content=\"0;URL='/erp/bfew/index.php?keyword=all+staff+leave+report&status=0'\" />");
?>