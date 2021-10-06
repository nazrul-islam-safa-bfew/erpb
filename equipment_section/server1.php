<?php 
include("common.php");
CreateConnection();
//assigning value passed by xmlhttp
$emp_id = intval($_GET['empployee_id']);
//....query ti retreive labor cost from the add_new_employee table based on the $emp_id value......
$qry="SELECT emp_labor_rate FROM add_new_employee WHERE emp_id='$emp_id'";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_result($qryexecute,0,0);
echo("$rs");
?>