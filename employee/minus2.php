<?php
  include("../includes/session.inc.php");
  include("../includes/config.inc.php");

  $db=mysqli_connect($SESS_DBHOST,$SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

  $sql="update quotation set advance_req='0' where advance_req='-2'";
  $q=mysqli_query($db,$sql);
?>
<h1>
  Done
</h1>