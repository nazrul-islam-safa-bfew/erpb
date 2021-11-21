<?php 
//project main
// echo "Project >> Ongoing project main<br><br>";
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
$as="SELECT * FROM project ";
$bbv = mysqli_query($db,$as);
?>

<table align="center" width="80%" height="10" border="1" bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#EEEEEE">
  <td align="center"> Project Code</td>
  <td align="center"> Project Name</td>
  <td align="center"> Project Manager Name</td>  
  <td align="center"> Project Starting Date</td>    
</tr>  
<? while($result=mysqli_fetch_array($bbv)){?>
<tr>
  <td align="center">  <?= $result[pcode] ?></td>  
  <td align="left"><? echo "<a href='./index.php?keyword=view+iow+detail&selectedPcode=$result[pcode]'>$result[pname]</a><br>";?></td>
  <td align="left">  Manager Name</td>  
  <td align="center"><?php 
if($result[sdate]){
	$sdate_exp=explode("-",$result[sdate]);
	echo $old_sdate=$sdate_exp[2]."/".$sdate_exp[1]."/".$sdate_exp[0];
} ?></td>    
  <td align="center"><? echo "<a href='./index.php?keyword=create+new+project&selectedPcode=$result[pcode]&e=1'>Edit</a><br>";?></td>  
</tr>  
<? }

?>
</table>