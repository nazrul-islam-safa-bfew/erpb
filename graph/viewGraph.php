<?php include ("../includes/global_hack.php");


 //$iowStatus = $_GET['iowStatus'];
 //$iowId = $_GET['iowId'];
//$gproject = $_GET['gproject'];

?>
<table width="100%">
<? if($iowStatus=='Approved by MD'){?>
 <tr><td>
	<p align="center"><img align="middle" src="./iow.g.php?iowId=<? echo $iowId;?>&amp;gproject=<? echo $gproject;?>" alt="Graph"></p> 
 </td></tr>
<? } else {?>
 <tr><td>
	<p align="center"><img align="middle" src="./iow0.g.php?iowId=<? echo $iowId;?>&amp;gproject=<? echo $gproject;?>" alt="Graph"></p> 
 </td></tr>
<? }?>
</table>
