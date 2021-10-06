<? 
include_once("../includes/myFunction1.php");
include("../includes/config.inc.php");
include_once("../includes/myFunction.php");
$todat=todat();
?>
<?		 
function nl2any($string, $tag = 'li', $feed = '') {
  // making tags
  $start_tag = "<$tag list-style: square inside; style='margin-bottom:.075in;'" . ($feed ? ' '.$feed : '') . '>' ;
  $end_tag = "</$tag>" ;
  
  // exploding string to lines
  $lines = preg_split('`[\n\r]+`', trim($string)) ;
  
  // making new string
  $string = '' ;
  $i=1;
  foreach($lines as $line)
   {$string .= "$start_tag $line$end_tag\n" ; $i++;}
  
  return $string ;
}
?>

<html>
<head>

<LINK href="../style/print.css" type=text/css rel=stylesheet>
<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<title>BFEW :: Print Employee Job Description</title>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >
<div class="dialog">
<table width="500" border="0"  align="center" cellpadding="5" cellspacing="5">
<tr>
 <th><font class="englishheadBlack">Bangladesh Foundry and Engineering Works Ltd.</font></th>
</tr>

</table>
</div>
<br>
<br>

<? 
if($designation){
	include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "SELECT * from `jobdetails` WHERE itemCode='$designation'";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
$app= mysql_fetch_array($sqlrunp);
}
?>
<div class="dialog">
<table align="left" width="650" border="0"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
    <tr>
	 <td colspan="2"><div class="border">
	   <table width="100%" cellpadding="5" cellspacing="0">
			<tr bgcolor="#CC9999">
			<td align="right" colspan="2"><font class='englishhead'> Entry Level Job Requirements</font></td>
			</tr>
			<tr><td valign="top">Desgination</td>
			<td><? echo $designation?></td>
			</tr>
			<tr>
			<td width="200" valign="top">Job Title </td>
			<td><? $temp=itemDes($designation);echo $temp[des];?></td>
			</tr>
			<tr>
			<td width="200" valign="top">Job Level </td>
			<td><? echo $app[level];?></td>
			</tr>
			<tr>
			<td width="200" valign="top">Job Summary</td>
			<td><p align=justify><? echo nl2br($app[summary]);?></p></td>
			</tr>
			</table>
	 </div></td>
	</tr>

	<tr>
	<td colspan="2" valign="top">
	<fieldset class="border"><legend class="englishheadBlue">Job Duties</legend>
	 <table width="100%" cellpadding="0" cellspacing="0" border="0">
	   <tr>
	     <td valign="top" width="120"><li style="list-style: square inside">Job Tasks</li></td>
 	 	 <td><? if($app[dduties]){?><ul><? echo  nl2any($app[dduties]);?></ul><? }?></td>
	   </tr>
	 </table>
	 
	 </fieldset>
	 </td>
	 </tr>
	 <tr>
	<td colspan="2" valign="top">
	 <fieldset class="border"><legend class="englishheadBlue">Job Duties</legend>
	 <table width="100%" cellpadding="0" cellspacing="0" border="0">
	   <tr>
	     <td  valign="top" width="120"><li style="list-style: square inside">Job Activities</li></td>
		 <td><? if($app[pduties]){?><ul><? echo  nl2any($app[pduties]);?></ul><? }?></td>
	   </tr>

	 </table>
	 
	 </fieldset>
	</td>
	</tr>	
	
	<tr>
	<td colspan="2" valign="top">
	<fieldset class="border"><legend class="englishheadBlue">Job Requirements</legend>

	 <table width="100%" cellpadding="0" cellspacing="0" border="0">
	   <tr>
	     <td width="120" valign="top"><li style="list-style: square inside">Education</li></td>
		 <td><? if($app[education]){?><ul><?  echo nl2any($app[education]);?></ul><? }?></td>
	   </tr>
	 </table>
	</fieldset>
	</td>
	</tr>
	<tr>
	<td colspan="2" valign="top">
	<fieldset class="border"><legend class="englishheadBlue">Job Requirements</legend>

	 <table width="100%" cellpadding="0" cellspacing="0" border="0">
	  
	   <tr>
	     <td width="120" valign="top"><li style="list-style: square inside">Experience</li></td>
		 <td><? if($app[experience]){?><ul><? echo nl2any($app[experience]);?></ul><? }?></td>
	   </tr>
	 </table>
	</fieldset>
	</td>
	</tr>
	<tr>
	<td colspan="2" valign="top">
	<fieldset class="border"><legend class="englishheadBlue">Job Requirements</legend>

	 <table width="100%" cellpadding="0" cellspacing="0" border="0">
	   <tr>
	     <td width="120" valign="top"><li style="list-style: square inside">Knowledge</li></td>
		 <td><? if($app[training]){?><ul><? echo nl2any($app[training]);?></ul><? }?></td>
	   </tr>
	 </table>
	</fieldset>
	</td>
	</tr>
	<tr>
	<td colspan="2" valign="top">
	<fieldset class="border"><legend class="englishheadBlue">Job Requirements</legend>

	 <table width="100%" cellpadding="0" cellspacing="0" border="0">
	   <tr>
	     <td width="120" valign="top"><li style="list-style: square inside">Skills</li></td>
		 <td><? if($app[skill]){?><ul><? echo nl2any($app[skill]);?></ul><? }?></td>
	   </tr>
	 </table>
	</fieldset>
	</td>
	</tr>
	<tr>
	<td colspan="2" valign="top">
	<fieldset class="border"><legend class="englishheadBlue">Job Requirements</legend>
	 <table width="100%" cellpadding="0" cellspacing="0" border="0">
	   <tr>
	     <td width="120" valign="top"><li style="list-style: square inside">Ability</li></td>
		 <td><? if($app[ability]){?><ul><? echo nl2any($app[ability]);?></ul><? }?></td>
	   </tr>
	 </table>
	</fieldset>
	</td>
	</tr>
	   <tr>
	     <td width="200">Authority of incumbent</td>		 
		 <td ><? $temp=itemDes($app[incumbent]);echo $temp[des];?></td>
	   </tr>
	<tr>
	<td colspan="2" valign="top">
	<fieldset class="border"><legend class="englishheadBlue">Limits of Authority</legend>
	 <table width="100%" cellpadding="5" cellspacing="0">
	   <tr>
	     <td width="120" valign="top"><li style="list-style: square inside">Administrative</li></td>
		 <td><? if($app[administrative]){?><ul><? echo  nl2any($app[administrative]);?></ul><? }?></td>
	   </tr>
   	  
	 </table>
	</fieldset>
	</td>
	</tr>
	<tr>
	<td colspan="2" valign="top">
	<fieldset class="border"><legend class="englishheadBlue">Limits of Authority</legend>
	 <table width="100%" cellpadding="5" cellspacing="0">
	   <tr>
	     <td width="120" valign="top"><li style="list-style: square inside">Financial</li></td>
		 <td><? if($app[financial]){?><ul><? echo  nl2any($app[financial]);?></ul><? }?></td>
	   </tr>
	 </table>
	</fieldset>
	</td>
	</tr>
   <tr>
	 <td width="200" valign="top"><li style="list-style: square inside">Standard of Performance</li></td>
	 <td><? if($app[performance]){?> <ul> <? echo nl2any($app[performance]);?></ul> <? } ?></td>
   </tr>
   <tr>
	 <td width="200" valign="top"><li style="list-style: square inside">Working condition</li></td>
	 <td><? if($app[conditions]){?> <ul> <? echo nl2any($app[conditions]);?></ul><? } ?></td>
   </tr>
   <tr>
	 <td width="100%" valign="top" colspan="2"><fieldset class="border"><legend class="englishheadBlue">Job nature</legend>
	 <? if($app[nature]=='') $ck1=' checked';
	 else if($app[nature]=='Temporary') $ck1=' checked';
	  else  if($app[nature]=='Part-time') $ck2=' checked';
	    else if($app[nature]=='Project') $ck3=' checked';
		  else if($app[nature]=='Permanent') $ck4=' checked';
	 ?>
	 <input type="radio" name="nature" value="Temporary" <?  echo $ck1;?>  >Temporary 
	 <input type="radio" name="nature" value="Part-time" <?  echo $ck2;?>>Part-time
	 <input type="radio" name="nature" value="Project" <?  echo $ck3;?>>Project
	 <input type="radio" name="nature" value="Permanent" <?  echo $ck4;?>>Permanent
	 </fieldset></td>
   </tr>
	<!--<tr>
	 <td colspan="2"><fieldset class="border"><legend class="englishheadBlue">Salary Structure:</legend>
	 <table width="100%" cellpadding="5" cellspacing="0">
	   <tr> <td width="200">Starting Basic</td><td>Tk. <? echo number_format($app[startingBasic],2);?> per Month</td> </tr>
	   <tr> <td>House Rent</td><td><? echo $app[houseRent];?> % of Basic per Month</td> </tr>
	   <tr> <td>Medical</td><td><? echo $app[medical];?> % of Basic per Month</td> </tr>
	   <tr> <td>Convence</td><td><? echo $app[convence];?> % of Basic per Month</td> </tr>	   	  
	   <tr> <td>Provident Fund Deduction</td><td><? echo $app[proFund];?> % of Basic per Month</td> </tr>	 
	   <tr> <td>Increment</td><td>Tk. <? echo $app[increment];?> per Increment</td> </tr>	   	  	 
	   <tr> <td>Maximum Increment</td><td> <? echo $app[maxIncrement];?> numbers</td> </tr>	   	  	     	  	   
	    	   
	 </table>
	 </fieldset></td>
	</tr>-->
</table>
</div>

 <br>
  <br>
<? include('../bottom.php');?>
</body>

</html>
 