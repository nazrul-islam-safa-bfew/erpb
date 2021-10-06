
<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<?
//project main

if($paymentDate){	
	$date_exp=explode("/",$paymentDate);
	$sdate=$date_exp[2]."-".$date_exp[1]."-".$date_exp[0];
}

if($nproject){
	
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
$sqlp = "INSERT INTO `project` (`id`, `pname`, `pcode`,contact_amount,status,tax,vat,retentionTaka,retentionPer,paymentTerms,projectDuration,sdate,workingCapital)".
" values (' ', '$pname','$pcode',$contact_amount,'0','$tax','$vat','$retentionTaka','$retentionPer','$paymentTerms','$projectDuration','$sdate','$workingCapital')";
// echo $sqlp;
// exit;	
$sqlrunp= mysqli_query($db, $sqlp);
echo " >> New Project Created<br>";




/*CREATE STORE*/



 
/* Table structure for table `issue$pcode`*/
 
$sql="
CREATE TABLE `issue$pcode` (
  `issueSL` int(11) NOT NULL auto_increment,
  `itemCode` varchar(10) NOT NULL default '',
  `iowId` int(11) NOT NULL default '0',
  `siowId` int(11) NOT NULL default '0',
  `issuedQty` double NOT NULL default '0',
  `issueRate` double NOT NULL default '0',
  `issueDate` date NOT NULL default '0000-00-00',
  `reference` varchar(200) NOT NULL default '',  
  `supervisor` varchar(20) NOT NULL default '',
  KEY `issueSL` (`issueSL`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
";
mysqli_query($db, $sql);
//-- --------------------------------------------------------

 
/* Table structure for table `store`*/
 
$sql="
CREATE TABLE `store$pcode` (
 `rsid` int(11) NOT NULL auto_increment,
  `itemCode` varchar(10) NOT NULL default '',
  `receiveQty` double NOT NULL default '0',
  `currentQty` double NOT NULL default '0',
  `rate` double NOT NULL default '0',
  `paymentSL` varchar(100) NOT NULL default '',
  `reference` varchar(100) NOT NULL default '',
  `remark` varchar(100) NOT NULL default '',
  `todat` date NOT NULL default '0000-00-00',
  KEY `sid` (`rsid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
";
mysqli_query($db, $sql);
//-- --------------------------------------------------------

 
//Table structure for table `storet124`

$sql="
CREATE TABLE `storet$pcode` (
`rsid` int(11) NOT NULL auto_increment,
  `itemCode` varchar(10) NOT NULL default '',
  `receiveQty` double NOT NULL default '0',
  `currentQty` double NOT NULL default '0',
  `rate` double NOT NULL default '0',
  `paymentSL` varchar(100) NOT NULL default '',
  `reference` varchar(100) NOT NULL default '',
  `remark` varchar(100) NOT NULL default '',
  `todat` date NOT NULL default '0000-00-00',
  KEY `sid` (`rsid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
";
mysqli_query($db,$sql);
echo " >> New STORE Created for project $pcode<br>";
/* END CREATE STORE*/
$sid=uniqid("");
$userName='pm'.$pcode;
$password='pm'.$pcode;
$userFullName='pm'.$pcode;
$userDesignation='Project Manager';
	  $sql="INSERT INTO `user` (`id`, `uname`, `password`, `fullName`, `designation`, `projectCode`,`permission`, `datet`)".
	  " VALUES ('$sid', '$userName','$password', '$userFullName', '$userDesignation','$pcode', '$permission','$todat')";
//echo $sql.'<br>';
$sqlrunp= mysqli_query($db, $sql);
/* create Construction Manager*/
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sid=uniqid("");
$userName='cm'.$pcode;
$password='cm'.$pcode;
$userFullName='cm'.$pcode;
$userDesignation='Construction Manager';
	  $sql="INSERT INTO `user` (`id`, `uname`, `password`, `fullName`, `designation`, `projectCode`,`permission`, `datet`)".
	  " VALUES ('$sid', '$userName','$password', '$userFullName', '$userDesignation','$pcode', '$permission','$todat')";
//echo $sql.'<br>';
$sqlrunp= mysqli_query($db, $sql);


/* create project Site Cashier*/
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sid=uniqid("");
$userName='acc'.$pcode;
$password='acc'.$pcode;
$userFullName='acc'.$pcode;
$userDesignation='Site Cashier';
	  $sql1="INSERT INTO `user` (`id`, `uname`, `password`, `fullName`, `designation`, `projectCode`,`permission`, `datet`)".
	  " VALUES ('$sid', '$userName','$password', '$userFullName', '$userDesignation','$pcode', '$permission','$todat')";
//echo $sql1.'<br>';
$sqlrunp1= mysqli_query($db, $sql1);
	
// 	non invoiceable task created section
$sql_nonInvoiceableIow="INSERT INTO `iowtemp` (`iowId`, `iowProjectCode`, `itemCode`, `iowCode`, `iowDes`, `iowQty`, `iowUnit`, `iowPrice`, `iowTotal`, `iowType`, `iowSdate`, `iowCdate`, `iowStatus`, `iowDate`, `Prepared`, `Checked`, `Approved`, `siow`, `revisionNo`, `revision`, `supervisor`, `position`) VALUES (NULL, '$pcode', '', '999.000.000.000', 'Non Invoice-able Task ', '0', '0', '0', '0', '1', '0000-00-00', '0000-00-00', 'noStatus', '0000-00-00', NULL, NULL, NULL, '', '0', '', '', '999.000.000.000');

INSERT INTO `iow` (`iowId`, `iowProjectCode`, `itemCode`, `iowCode`, `iowDes`, `iowQty`, `iowUnit`, `iowPrice`, `iowTotal`, `iowType`, `iowSdate`, `iowCdate`, `iowStatus`, `iowDate`, `Prepared`, `Checked`, `Approved`, `siow`, `revisionNo`, `revision`, `supervisor`, `position`) VALUES (NULL, '$pcode', '', '999.000.000.000', 'Non Invoice-able Task ', '0', '0', '0', '0', '1', '0000-00-00', '0000-00-00', 'noStatus', '0000-00-00', NULL, NULL, NULL, '', '0', '', '', '999.000.000.000')
";
	mysqli_query($db,$sql_nonInvoiceableIow);
	if(mysqli_affected_rows($db)>0)echo "<p>Non invoiceable task head 999.000.000.000 has been created.</p>";
	else echo "<p>Error while Non invoiceable task create</p>";
//end of non invoiceable iow section
	

/* create project Store Officer*/
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sid=uniqid("");
$userName='store'.$pcode;
$password='store'.$pcode;
$userFullName='store'.$pcode;
$userDesignation='Store Officer';
	  $sql2="INSERT INTO `user` (`id`, `uname`, `password`, `fullName`, `designation`, `projectCode`,`permission`, `datet`)".
	  " VALUES ('$sid', '$userName','$password', '$userFullName', '$userDesignation','$pcode', '$permission','$todat')";
//echo $sql2.'<br>';
$sqlrunp2= mysqli_query($db, $sql2);

echo " >> New USERS Created for project $pcode<br>";
echo " >> New Project Create Completed <br> You can use this project completely";

}
else if($eproject) {
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "UPDATE `project` SET `pname` = '$pname', `pcode` = '$pcode',contact_amount='$contact_amount',paymentTerms='$paymentTerms',projectDuration='$projectDuration',sdate='$sdate',workingCapital='$workingCapital' WHERE id=$pid";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
echo " >> Edit Project Created";

}
else {
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * FROM `project` WHERE `pcode` = '$selectedPcode'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$re=mysqli_fetch_array($sqlrunp);
echo " >> Edit Project Created";

}
?>
<form name="createProject" action="./index.php?keyword=create+new+project&pid=<? echo $re[id];?>"  method="post">
<table align="center" width="50%" height="100" border="2" bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>  
  <td  colspan="2" align="center" bgcolor="#EEEEEE" height="30"><font class="englishheadBlack">Create New Project: </font></td> </td>
</tr>  
<?php
if($selectedPcode){
	$selectedPcodeText="readonly";
}
?>
<tr>  
  <td width="150">Project Name: </td><td><input type="text" name="pname" value="<? echo $re[pname];?>" <?php echo $selectedPcodeText; ?>></td>
</tr>  
<tr>
  <td>Project Code: </td>  <td><input type="text" name="pcode" value="<? echo $re[pcode];?>" size="3" maxlength="3" <?php echo $selectedPcodeText; ?>></td>
</tr>  
<tr>
  <td > Contact Amount: </td>  <td > <input type="text" name="contact_amount" value="<? echo $re[contact_amount];?>"> Tk.</td>
</tr> 

<tr>
  <td > Payment Terms: </td>  <td > <input type="text" name="paymentTerms" value="<? echo $re[paymentTerms];?>"></td>
</tr>  
<tr>
  <td > Start Date: </td>  <td > 
	<?php
	$sdate_exp=explode("-",$re[sdate]);
	$old_sdate=$sdate_exp[2]."/".$sdate_exp[1]."/".$sdate_exp[0];
	?>
<input type="text" maxlength="10" name="paymentDate" value="<? echo $old_sdate; ?>" alt="req" title="Payment Date" readonly="" id="the_selected_date"> 
        <a id="anchor" href="#"
   onClick="cal.select(document.forms['createProject'].paymentDate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
	
	   	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date();
	var cal = new CalendarPopup("testdiv1");
    cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd"));
		cal.setCssPrefix("TEST");
		cal.offsetX = 50;
		cal.offsetY = -150;
	</SCRIPT>
	
	</td>
</tr>  
<tr>
  <td > Project Duration: </td>  <td > <input type="number" name="projectDuration" value="<? echo $re[projectDuration];?>"> Months</td>
</tr>  
<tr>
  <td > Working Capital Amount: </td>  <td > <input type="number" name="workingCapital" value="<? echo $re[workingCapital];?>"> Tk.</td>
</tr>  

<!-- <tr>
  <td > Tax: </td>  <td > -->
	<input type="hidden" name="tax" value="<? echo $re[tax] ? $re[tax] : "";?>" size="3">
<!-- 	%</td>
</tr>  
<tr>
  <td > VAT: </td>  <td > -->
	<input type="hidden" name="vat" value="<? echo $re[vat];?>" size="3">
<!-- 	%</td>
</tr>   -->
<!-- <tr>
  <td > Retention: </td>  <td > -->
<input type="hidden" name="retentionTaka" value="<? echo $re[retentionTaka] ? $re[retentionTaka] : "";?>" size="3">
<!--   % receivable after <input type="text" name="reatentionPer" size="3" width="3"> days of submission of Final Invoice</td>
</tr>   -->

<tr>  

<? if($e==1){?>  <td colspan="2" align="center"><input type="submit" name="eproject" value="Edit Project"></td>    <? } else {?>
  <td colspan="2" align="center"><input type="submit" name="nproject" value="Create New Project"></td>    <? }?>
</tr>

</table>
</form>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>