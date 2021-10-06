<?
include("../includes/session.inc.php");
include("../includes/config.inc.php");
$db=mysqli_connect($SESS_DBHOST, $SESS_DBUSER, $SESS_DBPASS, $SESS_DBNAME);
include_once("../includes/myFunction.php");
include_once("../includes/myFunction1.php");
include_once("../includes/empFunction.inc.php");
require_once("../keys.php");

// if(appStatus($appId)!='0'){
// 	echo 'Please check carefully <br> if do not find any solution then <br>please contact with Shimul'; exit;
// }
?>

<html>
<head>

<LINK href="../style/indexstyle.css" type=text/css rel=stylesheet>
<link href="style/basestyles.css" rel="stylesheet" type="text/css">
<link href="js/fValidate/screen.css" rel="stylesheet" type="text/css">

<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<title>BFEW ::</title>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >
<? 
// echo "radioapp=$radioapp<br>";
if($save){

$todat = todat();
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($radioapp=='5'){
$details=$bonusAmount;
$date1 ="$bonus_year-$bonus_month-01";
}
elseif($radioapp=='4'){
$details=$incAmount;
$date1 ="$increment_year-$increment_month-01" ;
}
elseif($radioapp=='6'){
$details=$incentiveAmount;
$date1 ="$incentive_year-$incentive_month-01" ;
$incentive_month=$incentive_month+$incentive_duration;
if($incentive_month>12){
$incentive_year=$incentive_year+1; $incentive_month=$incentive_month-12;}
$date2="$incentive_year-$incentive_month-01" ;
}
elseif($radioapp=='3'){
$details=$itemCode;
$date1="$promotion_year-$promotion_month-01" ;
}
elseif($radioapp=='2'){
$details='Suspend'; 
$date1=formatDate($sdate1,'Y-m-d');
$date2=formatDate($sdate2,'Y-m-d');
}
elseif($radioapp=='1'){
$details='Termination from Job'; 
$date1=formatDate($jdate,'Y-m-d');
}
	
	

$sql="insert into appaction (id,appid,empId,action,details, date1, date2,todat,actionStatus)
 VALUES ('','$appId','$empId','$radioapp','$details','$date1','$date2','$todat','1')";
// echo $sql.'<br>';
$mysqlq=mysqli_query($db, $sql);

$sql1="UPDATE appraisal set astatus='2' WHERE appId='$appId'"; 
//echo $sql1.'<br>';
$mysqlq=mysqli_query($db, $sql1);
}
?>
<? 
include_once("../includes/myFunction1.php");
include("../includes/config.inc.php");
include_once("../includes/myFunction.php");
include_once("../includes/empFunction.inc.php");
$todat=todat();
?>


	<SCRIPT LANGUAGE="JavaScript" SRC="../js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 0;
		cal.offsetY = 0;
		
	</SCRIPT>
	
<form name="appaction" action="<? echo $PHP_SELF;?>">
<table align="center" width="700" border="3"  bordercolor="CC9999" bgcolor="#FFFFFF" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="10" align="right" valign="top">
	 <font class='englishhead'>appraisal action</font>
	</td>
</tr>

<tr>
	<td>
		
	</td>
</tr>


<tr>
	<td><input type="radio" name="radioapp" value="1" >Termination from Job on 
	<? 
	$designation=hrDesignationCode($empId);
	$empIdt=empId($empId,$designation);
	if(isSupervisor($empIdt)){ echo "<br>Assigned as Task Supervisor [ <font class=out>Cann't transfer</font>]"; } 
	else{?>
	<input type="text" maxlength="10" name="jdate"  > <a id="anchor1" href="#"
   onClick="cal.select(document.forms['appaction'].jdate,'anchor1','dd/MM/yyyy'); return false;"
   name="anchor1" ><img src="../images/b_calendar.png" alt="calender" border="0"></a> 
	<? }?>	</td>
</tr>

<tr bgcolor="#FFCCCC">
	<td><input type="radio" name="radioapp" value="4">
        Suspend 
        <input type="text" maxlength="10" name="sdate1" >
        <a id="anchor6" href="#"
   onClick="cal.select(document.forms['appaction'].sdate1,'anchor6','dd/MM/yyyy'); return false;"
   name="anchor6" ><img src="../images/b_calendar.png" alt="calender" border="0"></a> 
        to 
        <input type="text" maxlength="10" name="sdate2"  > <a id="anchor7" href="#"
   onClick="cal.select(document.forms['appaction'].sdate2,'anchor7','dd/MM/yyyy'); return false;"
   name="anchor7" ><img src="../images/b_calendar.png" alt="calender" border="0"></a> </td>
</tr>
<tr>
	<td><input type="radio" name="radioapp" value="3" >Promoted to 
	<? 	include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($loginProject=='000')$sqlp = "SELECT * from `itemlist` WHERE itemCode BETWEEN '74-00-000' AND '97-99-999'";
else $sqlp = "SELECT * from `itemlist` WHERE itemCode BETWEEN '74-00-000' AND '97-99-999'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$plist= "<select name='itemCode'> ";
$plist.= "<option value=''>Select One</option> ";

 while($typel= mysqli_fetch_array($sqlrunp))
{
 $plist.= "<option value='".$typel[itemCode]."'";
 if($itemCode==$typel[itemCode])  $plist.= " SELECTED";
 $plist.= ">$typel[itemCode]--$typel[itemDes]</option>  ";
 }
 $plist.= '</select>';
echo $plist;
 ?>
Valid From :  <select name="promotion_month" size="1" >
   <option  value="">Select Month</option>
   <option value="01" <? if($month=='01') echo 'selected';?> >January</option>
   <option value="02" <? if($month=='02') echo 'selected';?>>February</option>
   <option value="03" <? if($month=='03') echo 'selected';?>>March</option>
   <option value="04" <? if($month=='04') echo 'selected';?>>April</option>
   <option value="05" <? if($month=='05') echo 'selected';?>>May</option>
   <option value="06" <? if($month=='06') echo 'selected';?>>June</option>
   <option value="07" <? if($month=='07') echo 'selected';?>>July</option>
   <option value="08" <? if($month=='08') echo 'selected';?>>August</option>
   <option value="09" <? if($month=='09') echo 'selected';?>>September</option>
   <option value="10" <? if($month=='10') echo 'selected';?>>October</option>
   <option value="11" <? if($month=='11') echo 'selected';?>>November</option>
   <option value="12" <? if($month=='12') echo 'selected';?>>December</option>
</select>
<select  name="promotion_year">
  <!--<option value="2010" <? if($year=='2010') echo 'selected';?> >2010</option>
  <option value="2009" <? if($year=='2009') echo 'selected';?> >2009</option>
  <!--lasy time it was ? if($promotion_year=='2009') echo 'selected';?  
  <option value="2008" <? if($year=='2008') echo 'selected';?> >2008</option>
  <option value="2007" <? if($year=='2007') echo 'selected';?> >2007</option>
  <option value="2006" <? if($year=='2006') echo 'selected';?> >2006</option>-->
  <?php
	$start = date('Y');
	$end = date('2000');
	for($i=$start;$i>=$end;$i--){
	echo '<option value="'.$i.'"'.($year == $i ? ' selected="selected"' : '').'>' . $i . '</option>';
	}
	?>	  
</select></td>
</tr>
<tr bgcolor="#FFCCCC">
	<td><input type="radio" name="radioapp" value="4" >
	Increment <input type="text" name="incAmount" size="5" width="5" maxlength="5" > number(s)
	Valid From :  <select name="increment_month" size="1" >
   <option  value="">Select Month</option>
   <option value="01" <? if($month=='01') echo 'selected';?> >January</option>
   <option value="02" <? if($month=='02') echo 'selected';?>>February</option>
   <option value="03" <? if($month=='03') echo 'selected';?>>March</option>
   <option value="04" <? if($month=='04') echo 'selected';?>>April</option>
   <option value="05" <? if($month=='05') echo 'selected';?>>May</option>
   <option value="06" <? if($month=='06') echo 'selected';?>>June</option>
   <option value="07" <? if($month=='07') echo 'selected';?>>July</option>
   <option value="08" <? if($month=='08') echo 'selected';?>>August</option>
   <option value="09" <? if($month=='09') echo 'selected';?>>September</option>
   <option value="10" <? if($month=='10') echo 'selected';?>>October</option>
   <option value="11" <? if($month=='11') echo 'selected';?>>November</option>
   <option value="12" <? if($month=='12') echo 'selected';?>>December</option>
</select>
  <select  name="increment_year">
   <!-- <option value="2010" <? if($year=='2010') echo 'selected';?> >2010</option>
    <option value="2009" <? if($year=='2009') echo 'selected';?> >2009</option>
	<option value="2008" <? if($year=='2008') echo 'selected';?> >2008</option>
    <option value="2007" <? if($year=='2007') echo 'selected';?> >2007</option>
    <option value="2006" <? if($year=='2006') echo 'selected';?> >2006</option>-->
	<?php
	$start = date('Y');
	$end = date('2000');
	for($i=$start;$i>=$end;$i--){
	echo '<option value="'.$i.'"'.($year == $i ? ' selected="selected"' : '').'>' . $i . '</option>';
	}
	?>	  
   </select>  </td>
</tr>
<tr>
	<td><input type="radio" name="radioapp" value="5" >
	Bonus Tk. <input type="text" name="bonusAmount" size="10" width="10" maxlength="10"> 
	Due with the salary of:   
  <select name="bonus_month" size="1" >
   <option  value="">Select Month</option>
   <option value="01" <? if($month=='01') echo 'selected';?> >January</option>
   <option value="02" <? if($month=='02') echo 'selected';?>>February</option>
   <option value="03" <? if($month=='03') echo 'selected';?>>March</option>
   <option value="04" <? if($month=='04') echo 'selected';?>>April</option>
   <option value="05" <? if($month=='05') echo 'selected';?>>May</option>
   <option value="06" <? if($month=='06') echo 'selected';?>>June</option>
   <option value="07" <? if($month=='07') echo 'selected';?>>July</option>
   <option value="08" <? if($month=='08') echo 'selected';?>>August</option>
   <option value="09" <? if($month=='09') echo 'selected';?>>September</option>
   <option value="10" <? if($month=='10') echo 'selected';?>>October</option>
   <option value="11" <? if($month=='11') echo 'selected';?>>November</option>
   <option value="12" <? if($month=='12') echo 'selected';?>>December</option>
</select>
  <select  name="bonus_year">
    <!--<option value="2010" <? if($year=='2010') echo 'selected';?> >2010</option>  
    <option value="2009" <? if($year=='2009') echo 'selected';?> >2009</option>
	<option value="2008" <? if($year=='2008') echo 'selected';?> >2008</option>
    <option value="2007" <? if($year=='2007') echo 'selected';?> >2007</option>
    <option value="2006" <? if($year=='2006') echo 'selected';?> >2006</option>-->
	<?php
	$start = date('Y');
	$end = date('2000');
	for($i=$start;$i>=$end;$i--){
	echo '<option value="'.$i.'"'.($year == $i ? ' selected="selected"' : '').'>' . $i . '</option>';
	}
	?>	  
   </select>  </td>
</tr>

<tr bgcolor="#FFCCCC">
	<td><input type="radio" name="radioapp" value="6" >
	Incentive Tk. <input type="text" name="incentiveAmount" size="10" width="10" maxlength="10"> 
	Form : 
  <select name="incentive_month" size="1" >
   <option  value="">Select Month</option>
   <option value="01" <? if($month=='01') echo 'selected';?> >January</option>
   <option value="02" <? if($month=='02') echo 'selected';?>>February</option>
   <option value="03" <? if($month=='03') echo 'selected';?>>March</option>
   <option value="04" <? if($month=='04') echo 'selected';?>>April</option>
   <option value="05" <? if($month=='05') echo 'selected';?>>May</option>
   <option value="06" <? if($month=='06') echo 'selected';?>>June</option>
   <option value="07" <? if($month=='07') echo 'selected';?>>July</option>
   <option value="08" <? if($month=='08') echo 'selected';?>>August</option>
   <option value="09" <? if($month=='09') echo 'selected';?>>September</option>
   <option value="10" <? if($month=='10') echo 'selected';?>>October</option>
   <option value="11" <? if($month=='11') echo 'selected';?>>November</option>
   <option value="12" <? if($month=='12') echo 'selected';?>>December</option>
</select>
  <select  name="incentive_year">
    <!--<option value="2010" <? if($year=='2010') echo 'selected';?> >2010</option>  
    <option value="2009" <? if($year=='2009') echo 'selected';?> >2009</option>
	<option value="2008" <? if($year=='2008') echo 'selected';?> >2008</option>
    <option value="2007" <? if($year=='2007') echo 'selected';?> >2007</option>
    <option value="2006" <? if($year=='2006') echo 'selected';?> >2006</option>-->
	<?php
	$start = date('Y');
	$end = date('2000');
	for($i=$start;$i>=$end;$i--){
	echo '<option value="'.$i.'"'.($year == $i ? ' selected="selected"' : '').'>' . $i . '</option>';
	}
	?>
   </select> 
   For Next <select name="incentive_duration">
   <option>1</option>
   <option>2</option>
   <option>3</option>
   <option>4</option>         
   <option>5</option>
   <option>6</option>         
   </select> Month(s)  </td>
</tr>
<tr bgcolor="#FFCCCC">
	<td><input type="radio" name="radioapp" value="7">Comment 
    <input type="text" maxlength="20" size="50" name="comment" ></tr>


<tr><td align="center">
<?php
  
  if($_SESSION['loginDesignation']=="Chairman & managing Director"){
    echo '<input type="button"  value="Save" onClick="appaction.save.value=1; appaction.submit();">';
  }
  else{
    echo '<input type="button"  value="Forward to MD" onClick="appaction.save.value=1; appaction.submit();">';
  }
?>
<input type="hidden" name="save" value="0">
</td></tr>
</table>
<input type="hidden" name="appId" value="<? echo $appId;?>">
<input type="hidden" name="empId" value="<? echo $empId;?>">
</form>

note: Suspend - Employee will not get any Work and Salary during the Suspend period but Attendance is must.

<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
  <br>
  <br>
<? include('../bottom.php');?>
</body>

</html>