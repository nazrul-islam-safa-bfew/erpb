<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<? include('./account/receive.sql.php');
if($loginProject=='000'){
?>
<table  width="600" align="center" border="0" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border-collapse:collapse">

  <tr>
  <td><input type="radio" name="w"  value="1"   <? if($w==1) echo "checked";?> onClick="location.href='./index.php?keyword=receive&w=1'">Clients</td>
  <td><input type="radio" name="w"  value="2"   <? if($w==2) echo "checked";?> onClick="location.href='./index.php?keyword=receive&w=2'">Lenders</td>
  <td><input type="radio" name="w"  value="4"   <? if($w==4) echo "checked";?> onClick="location.href='./index.php?keyword=receive&w=4'">Vendors</td>  
  <td><input type="radio" name="w" value="3"   <? if($w==3) echo "checked";?> onClick="location.href='./index.php?keyword=receive&w=3'">Others</td>
  </tr>
</table>
<? }?>
<form action="./index.php?keyword=receive&w=<? echo $w;?>&client=<? echo $client;?>" name="receive" method="post">
<table  class="blue" width="500" align="center">
 <tr>
   <td class="blueAlertHd" colspan="4">Receive</td>
 </tr>
 <tr>
   <td>Receive SL.</td>
   <td><input type="text" name="receiveSL" value="<? if($expencess) echo ''; else echo receiveSL($receiveSL,$w);?>" 
   size="15" maxlength="12" alt="req" title="Reeive Serial Number" readonly="" /></td>
	
	 <SCRIPT LANGUAGE="JavaScript">
	var now = new Date();
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd"));
		cal.setCssPrefix("TEST");
		cal.offsetX = 0;
		cal.offsetY = 0;
	</SCRIPT>

   <td>Date </td>
      <td><input type="text" maxlength="10" name="receiveDate" value="<? echo $receiveDate; ?>" alt="req" title="Receive Date"> <a id="anchor" href="#"
   onClick="cal.select(document.forms['receive'].receiveDate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>      </td>
</tr>
<? if($w==1){?>
<tr>
  <td>Select Client</td>
  <td colspan="3">
  <select name="client" onChange="location.href='index.php?keyword=receive&w=<? echo $w;?>&client='+receive.client.options[document.receive.client.selectedIndex].value";>	
<?  	include("./includes/config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT `pcode`,pname from `project` ORDER by pcode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[pcode]."'";
 if($client==$typel[pcode])  echo " SELECTED";
 echo ">$typel[pcode]--$typel[pname]</option>  ";
 }
?>
  </select>   </td>
</tr>
<? }//w==1?>
<? if($w==4){?>
 <tr>
   <td>Select Vendor</td>
 <td colspan="3"> <select name="vid" onChange="location.href='index.php?keyword=receive&w=<? echo $w;?>&vid='+receive.vid.options[document.receive.vid.selectedIndex].value";>
 <option value="">Select </option>
<?
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT distinct vendor.vid,vendor.vname,porder.vid from `vendor`,porder WHERE vendor.vid=porder.vid";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[vid]."'";
 if($vid==$typel[vid]) echo " SELECTED ";
 echo ">$typel[vname]</option>  ";
 }
?>
	</select></td>
 </tr>
<? }//w==1?>

<? if($w==2){?>
<tr>
  <td>Select Lender</td>
      <td colspan="3"> <select name="lender" onChange="location.href='index.php?keyword=receive&w=<? echo $w;?>&lender='+receive.lender.options[document.receive.lender.selectedIndex].value";>
          <?  	include("./includes/config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
/*	
$sqlp = "SELECT accountId,description from `accounts` WHERE accountType in ('14','12') ORDER by accountId ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[accountId]."'";
 if($lender==$typel[accountId])  echo " SELECTED";
 echo ">$typel[accountId]--$typel[description]</option>  ";
 }
 
*/
	$sqlp = "SELECT * from `accounts` WHERE accountType IN('12')  order by accountId ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	while($typel= mysqli_fetch_array($sqlrunp))
	{
		$sqlp2 = "SELECT * from `lander` where accountId='$typel[accountID]' order by landerName ASC";
		//echo $sqlp;
		$sqlrunp2= mysqli_query($db, $sqlp2);
		while($typel2= mysqli_fetch_array($sqlrunp2))
		{
		echo  "<option value='".$typel[accountID].'-'.$typel2[id]."'";
		if($lender=="$typel2[accountId]-$typel2[id]")  echo  " SELECTED";
		echo  ">$typel2[accountId]-$typel[description]-$typel2[landerName]</option>";
		}//while2
	}//while1 
?>
        </select></td>
</tr>
<? 
//echo $sqlp;
}//w=2?>

<? if($w==1){?><tr><td> Account Receivable</td>
<td>5000000 SUNDRY DEBTORS</td></tr><? }?>
 
 <? if($w==3){?>
<tr>
  <td>Select Income Code</td>
  <td colspan="3"> <select name="incomeAccount" onChange="location.href='index.php?keyword=receive&w=<? echo $w;?>&incomeAccount='+receive.incomeAccount.options[document.receive.incomeAccount.selectedIndex].value";>
          <?  	include("./includes/config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
 
$sqlp = "SELECT * from `accounts` WHERE accountType IN('21') order by accountID ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
 while($typel= mysqli_fetch_array($sqlrunp))
{
if($loginProject<>'000')$sqlp2 = "SELECT `pcode`,pname from `project` WHERE pcode='$loginProject' order by pcode ASC";
else $sqlp2 = "SELECT `pcode`,pname from `project` order by pcode ASC";
//echo $sqlp;
$sqlrunp2= mysqli_query($db, $sqlp2);
 while($typel2= mysqli_fetch_array($sqlrunp2))
{

 echo  "<option value='".$typel[accountID].'-'.$typel2[pcode]."'";
 if($incomeAccount=="$typel[accountID]-$typel2[pcode]")  echo  " SELECTED";
 echo  ">$typel[accountID]-$typel2[pcode]-$typel[description]</option>  ";
   }//while2
 }//while1
?>
        </select></td>
</tr>

<? 
//echo $sqlp;
}//w=2?>
<tr><td> Cash Account</td>
 <td colspan="3"> <select name="receiveAccount" size="1" >
         
<option value="5501000">5501000--Head Office Cash</option>		 
		  <?  	include("./includes/config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT accountId,description from `accounts` WHERE accountType in ('3')";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[accountId]."'";
 if($lender==$typel[accountId])  echo " SELECTED";
 echo ">$typel[accountId]--$typel[description]</option>  ";
 }
?>
        </select></td>
</tr>
</table>
<br>
<br>
<? if($w==1 AND $client) include('receive_clients.php');?>
<? if($w==2) include('receive_lender.php');?>
<? if($w==3) include('receive_other.php');?>
<? if($w==4) include('receive_vendor.php');?>
</form>


<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>