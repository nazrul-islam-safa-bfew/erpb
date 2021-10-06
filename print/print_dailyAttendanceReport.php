<? 
include_once("../includes/myFunction1.php");
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

include_once("../includes/myFunction.php");
include_once("../includes/empFunction.inc.php");

$todat=todat();
?>
<html>
<head>

<LINK href="../style/print.css" type=text/css rel=stylesheet>
<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<title>BFEW :: Print IOW</title>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >
<? if($dd){?>
<table width="700">
 <tr>
  <td> 

<table align="left" width="700" height="100%" border="0"   cellpadding="0" cellspacing="0" style="border-collapse:collapse">
 <tr>
  <td> 
	<table align="left" width="700" border="0"  cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	<tr>
	 <td align="center"><font class="he">Bangladesh Foundry & Engineering Works Ltd.</font></td>
	</tr>
	<tr><td align="center"><font class="he"><? echo myprojectName($project);?></font></td></tr>
	<tr><td align="center"><font class="he">Project Code: <? echo $project;?></font></td></tr>
	<tr><td align="right">Employee Attendance</td></tr>
	<tr><td align="right">Report Date: <? echo date('d-m-Y',strtotime($dd));?></td></tr>
	</table>
   </td>
 </tr>
 <tr><td height="15"></td></tr>

<? 

include("../includes/config.inc.php");
  $sqlq="SELECT * FROM employee WHERE  location='$project' AND status=0 ";
 if($type=='sal') {$sqlq.= " AND  salaryType in ('Salary','Wages Monthly') "; }
 if($type=='wag') {$sqlq.= " AND  salaryType in ('Wages Monthly Master Roll') "; }
 $sqlq.=" and designation not like '70%' ";
 $sqlq.="   ORDER by designation";
// echo $sqlq;
 $sql=mysqli_query($db, $sqlq);
 $i=1;
 while($typel= mysqli_fetch_array($sql)){?>
<? if($i%20==1){?>
 <tr>
   <td>
	<table align="left" width="700" border="2"  bordercolor="#999999" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
	<tr bgcolor="#E4E4E4">
	<th>Sl No.</th>
	 <th width="200" height="30">Name</th>
	 <th width="200">Designation</th>
	 <th width="100">Attendance</th>
	 <th>Remarks</th>
	</tr>
<? }?>

  <?
$sql1="select * from attendance WHERE empId='$typel[empId]' and edate='$dd'";
//echo $sql1;
 $sqlqq=mysqli_query($db, $sql1);
 $sqlq1=mysqli_fetch_array($sqlqq);
 if($sqlq1){
  if( $pre!=$typel[designation])
 echo "<tr><td height=10 colspan=4 bgcolor=#FFFFCC></td></tr>";
?>

<tr >
 <td align="center"><? echo $i;?></td> 
 <td><? echo $typel[name];?></td>
 <td>
   <?  echo hrDesignation($typel[designation]);?><div align="right" ><? echo empId($typel[empId],$typel[designation]);?></div>
 </td>
 <td align="center">

 <? if($sqlq1[action]=='P' OR $sqlq1[action]=='HP' ) echo 'Present<br>'.$sqlq1[stime];
 elseif($sqlq1[action]=='A' OR $sqlq1[action]=='HA' ) echo '<u><b>Absent</b></u>';
  else if($sqlq1[action]=='L' ) echo 'Leave';
 ?></td>
 <td><?php

$sql22q="select * from attremarks where attId='$sqlq1[id]' ";
$q1=mysqli_query($db,$sql22q);
$row22=mysqli_fetch_array($q1);

echo $row22[remarks];

 ?></td>
</tr>
<? $i++;} //if
 
 $pre=$typel[designation];
 ?>
 <? if($i%20==1){?>
</table>
   </td>
 </tr>

<? }?> 
<? }//while?>

 </table>

    </td>
 </tr>

</table>
<? }//if d?>
  <br>
  <br>
<div style="clear:both"   >
<? include('../bottom.php');?>
</div>
</body>

</html>
 