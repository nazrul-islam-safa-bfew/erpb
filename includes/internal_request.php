<?php
/* You should implement error checking, but for simplicity, we avoid it here */

if($_GET['action'] == 'get_products'){
    /* We're here to get the product listing...
        You can obviously change this file to include many
        different actions based on the request.
    */
$vvid=$_GET['id'];
if($vvid){

include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
$sqlp = "SELECT DISTINCT posl from `porder` WHERE vid='$vvid' ORDER by posl ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$out="<select name=posl2>
 <option value=''>All Purchase order</option>";
 while($typel= mysqli_fetch_array($sqlrunp))
{
 $out.="<option value='".$typel[posl]."'";
 if($posl2==$typel[posl])  $out.=" SELECTED";
 $out.=">".$typel[posl]."</option>  ";
 }
$out.="</select>";
echo $out;
}
}
?>