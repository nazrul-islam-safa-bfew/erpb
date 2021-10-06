<?php
if($appactionID){
	$sql="update appaction set actionStatus='0' where id='$appactionID'";
	mysqli_query($db,$sql);
	if(mysqli_affected_rows($db)>0)
		echo "<p>Your information has been updated!</p>";
}
?>
<table align="center" width="95%" border="3"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="5" align="right" valign="top"><font class='englishhead'><?php echo appraisalData($aa,"text"); ?></font></td>
</tr>
<? include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
$sql="SELECT a.*,e.* FROM appaction a,employee e WHERE a.empId=e.empId AND a.actionStatus=2 and action=$aa ";
// echo $sql;
	$sqlquery= mysqli_query($db, $sql);
/* END */
?>
	
	
<tr>
 <td align="center" >
 <?   echo '<b>ID</b>';?>
 </td>
 <td align="center" > 
 <?   echo '<b>Name</b>';?>
 </td>
 <td align="center" >
 <?   echo '<b>Designation</b>';?>
 </td>
 <td align="center" > 
 <?   echo '<b>Date</b>';?>
 </td>
 <td align="center">
 <?   echo '<b>Action</b>';?>
 </td>
</tr>
	
	
	<?php
	
$i=0;
while($sqlresult=mysqli_fetch_array($sqlquery)){
$designation = hrDesignationCode($sqlresult[empId]);?>
<tr bgcolor=#EEEEEE><td height=0 colspan=5></td></tr>
<tr>
 <td align="left" >
 <?   echo empId($sqlresult[empId],$sqlresult[designation]);?>
</td>
 <td align="left" > 
 <?   echo $sqlresult[name];?>
</td>
 <td align="left" >
 <?   echo hrDesignation($designation);?>
</td>
 <td align="left" > 
 <?   echo date("d/m/Y",strtotime($sqlresult[date1]));?>
</td>
  <td  bgcolor="#CCCCFF" valign="middle" align="center">
		<a href="./index.php?keyword=appraisal+action+md&aa=<?php echo $aa; ?>&appactionID=<?php echo $sqlresult[id]; ?>" onClick="if(confirm('<?php echo $sqlresult[name]; ?> will be <?php echo appraisalData($aa,null); ?> from employment from <?   echo date("d/m/Y",strtotime($sqlresult[date1]));?>')!=true)return false;">Approved</a>
	</td>
</tr>



<? $i++;
$testp= $test;
}?>

</table>
