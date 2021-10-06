<?php
include("common.php");
CreateConnection();
//store hidden variable value
$hid= $_GET['hidField'];
if($hid==1)
{
//store work order id
$wo_id = $_GET['wo_id'];
$qry2="SELECT grand_total FROM new_work_order_main WHERE work_order_id='$wo_id'";
$qryexecute2=mysqli_query($db, $qry2);
$grand_total=mysql_result($qryexecute2,0,0);
echo"$grand_total";
}
else if($hid==2)
{
//store customer id
$customer_id = $_GET['cust_id'];
$qry="SELECT cust_phone,cust_mobile,cust_fax,cust_country FROM customer_setup WHERE cust_id='$customer_id'";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_fetch_row($qryexecute);
$cust_phone=$rs[0];
$cust_mobile=$rs[1];
$cust_fax=$rs[2];
$cust_country=$rs[3];

echo"Phone: $cust_phone  ";
echo"Mobile: $cust_mobile ";
echo"Fax: $cust_fax ";
echo"Country: $cust_country";
}
 ?>