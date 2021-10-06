<?
//project main



if($nproject){
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "INSERT INTO `project` (`id`, `pname`, `pcode`,contact_amount,status,tax,vat,retentionTaka,retentionPer)".
" values (' ', '$pname','$pcode',$contact_amount,'0','$tax','$vat','$retentionTaka','$retentionPer')";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
echo " >> New Project Created<br>";

include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);



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
mysql_query($sql);
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
mysql_query($sql);
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
mysql_query($sql);
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
$sqlrunp= mysql_query($sql);
/* create Construction Manager*/
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

$sid=uniqid("");
$userName='cm'.$pcode;
$password='cm'.$pcode;
$userFullName='cm'.$pcode;
$userDesignation='Construction Manager';
	  $sql="INSERT INTO `user` (`id`, `uname`, `password`, `fullName`, `designation`, `projectCode`,`permission`, `datet`)".
	  " VALUES ('$sid', '$userName','$password', '$userFullName', '$userDesignation','$pcode', '$permission','$todat')";
//echo $sql.'<br>';
$sqlrunp= mysql_query($sql);


/* create project Site Cashier*/
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

$sid=uniqid("");
$userName='acc'.$pcode;
$password='acc'.$pcode;
$userFullName='acc'.$pcode;
$userDesignation='Site Cashier';
	  $sql1="INSERT INTO `user` (`id`, `uname`, `password`, `fullName`, `designation`, `projectCode`,`permission`, `datet`)".
	  " VALUES ('$sid', '$userName','$password', '$userFullName', '$userDesignation','$pcode', '$permission','$todat')";
//echo $sql1.'<br>';
$sqlrunp1= mysql_query($sql1);

/* create project Store Officer*/
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

$sid=uniqid("");
$userName='store'.$pcode;
$password='store'.$pcode;
$userFullName='store'.$pcode;
$userDesignation='Store Officer';
	  $sql2="INSERT INTO `user` (`id`, `uname`, `password`, `fullName`, `designation`, `projectCode`,`permission`, `datet`)".
	  " VALUES ('$sid', '$userName','$password', '$userFullName', '$userDesignation','$pcode', '$permission','$todat')";
//echo $sql2.'<br>';
$sqlrunp2= mysql_query($sql2);

echo " >> New USERS Created for project $pcode<br>";
echo " >> New Project Create Completed <br> You can use this project completely";

}
else if($eproject) {
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "UPDATE `project` SET `pname` = '$pname', `pcode` = '$pcode',contact_amount=$contact_amount WHERE id=$pid";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
echo " >> Edit Project Created";

}
else {
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "SELECT * FROM `project` WHERE `pcode` = '$selectedPcode'";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
$re=mysql_fetch_array($sqlrunp);
echo " >> Edit Project Created";

}
?>
<form name="createProject" action="./index.php?keyword=create+new+project&pid=<? echo $re[id];?>"  method="post">
<table align="center" width="50%" height="100" border="2" bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>  
  <td  colspan="2" align="center" bgcolor="#EEEEEE" height="30"><font class="englishheadBlack">Create New Project: </font></td> </td>
</tr>  

<tr>  
  <td width="150" > Project Name: </td>  <td > <input type="text" name="pname" value="<? echo $re[pname];?>"></td>
</tr>  
<tr>
  <td > Project Code: </td>  <td > <input type="text" name="pcode" value="<? echo $re[pcode];?>" size="3" maxlength="3"></td>
</tr>  
<tr>
  <td > Contact Amount: </td>  <td > <input type="text" name="contact_amount" value="<? echo $re[contact_amount];?>"></td>
</tr>  

<tr>
  <td > Tax: </td>  <td ><input type="text" name="tax" value="<? echo $re[tax];?>" size="3"> %</td>
</tr>  
<tr>
  <td > VAT: </td>  <td ><input type="text" name="vat" value="<? echo $re[vat];?>" size="3"> %</td>
</tr>  
<tr>
  <td > Retention: </td>  <td ><input type="text" name="retentionTaka" value="<? echo $re[retentionTaka];?>" size="3">
   % receivable after <input type="text" name="reatentionPer" size="3" width="3"> days of submission of Final Invoice</td>
</tr>  

<tr>  

<? if($e==1){?>  <td colspan="2" align="center"><input type="submit" name="eproject" value="Edit Project"></td>    <? } else {?>
  <td colspan="2" align="center"><input type="submit" name="nproject" value="Create New Project"></td>    <? }?>
</tr>

</table>
</form>