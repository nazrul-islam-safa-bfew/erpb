<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<style>
.bg{
background:#EEEEEE;
}
</style>
<? ?>
<form name="gl" action="./index.php?keyword=lander+ledger" method="post">
<table  width="600" align="center" border="0" class="blue" >
 <tr bgcolor="#CCCCFF">
 <td align="right" valign="top" height="30" colspan="4"><font class='englishheadblack'>lander ledger</font></td>
</tr>
 <tr>
    <td>Account Id From </td>
	<td colspan="3">
 <select name='accIdFrom'>
<?
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php"); //datbase_connection
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
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
		echo  "<option value='".$typel['accountID'].'-'.$typel2['id']."'";
		if($account=="$typel2[accountId]-$typel2[id]")  echo  " SELECTED";
		echo  ">$typel2[accountId]-$typel[description]-$typel2[landerName]</option>";
		}//while2
	}//while1
?>
</select>
</td>
</tr>	  
<tr>
    <td>Account Id To </td>
	<td colspan="3">
 <select name='accIdTo'>
        <?   $localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php"); //datbase_connection
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$plist='';
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
		echo  "<option value='".$typel['accountID'].'-'.$typel2['id']."'";
		if($account=="$typel2[accountId]-$typel2[id]")  echo  " SELECTED";
		echo  ">$typel2[accountId]-$typel[description]-$typel2[landerName]</option>";
		}//while2
	}//while1?>
</select>
</td>
 </tr>
 <tr>
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
    <td>From </td>
      <td><input type="text" maxlength="10" name="fromDate" value="<? echo $fromDate;?>" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['gl'].fromDate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
      </td>
    <td>To </td>
      <td><input type="text" maxlength="10" name="toDate" value="<? echo $toDate;?>" > <a id="anchor2" href="#"
   onClick="cal.select(document.forms['gl'].toDate,'anchor2','dd/MM/yyyy'); return false;"
   name="anchor2" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
      </td>
 </tr>

 <tr><td colspan="4" align="center"><input type="button" name="go" value="Go" onClick="gl.submit();"></td></tr>
</table>

<input type="hidden" name="ck" value="1">
</form>
<? if($fromDate AND $toDate){
  $fromDate=formatDate($fromDate,'Y-m-d');
  $toDate=formatDate($toDate,'Y-m-d'); 
  //$pcode=$pcode;
  
 $sql="SELECT * from lander  ORDER by accountId ASC";
// echo "$sql<br>";
 $sqlq=mysqli_query($db, $sql);
 $i=1;
 while($acc=mysqli_fetch_array($sqlq)){
 $accountId[$i]="$acc[accountId]-$acc[id]"; $i++;}//WHILE
 
function myarray_search ($needle, $haystick) {
//echo "<br> ##  $needle, $haystick <br>";
   foreach($haystick as $key => $val) {
       if ($needle === $val) {
           return($key);
       }
   }
   return(false);
}
//print_r($accountId);
//$dd= myarray_search ('5001000',  $accountId);

?>

<table  width="850" align="center" border="1" bordercolor="#F4F4F4" cellpadding="0" cellspacing="0"  style="border-collapse:collapse;font-size: 10px;" >
 <tr bgcolor="#CCFF99">
   <th align="center" valign="top" width="200">Account ID</th>   
   <th align="center" valign="top" width="100">Date</th>
   <th align="center" valign="top">Reference</th>
   <th align="center" valign="top">Jrnl</th>   
   <th align="center" valign="top" width="200">Description</th>   
   <th align="right" valign="top" width="100">Debit Amount</th>   
   <th align="right" valign="top" width="100">Credit Amount</th> 
   <th align="center" valign="top" width="100">Balance</th>
 </tr>
 
 <?  

$sql="select * from lander ORDER by accountId ASC";
$i=1;
//echo $sql;
$sqlq=mysqli_query($db, $sql);
while($ree=mysqli_fetch_array($sqlq)){
$array_date=array();
$openingBalance=0;
$baseOpening=0;
$q_accountId="$ree[accountId]-$ree[id]";

 if(myarray_search ($q_accountId,  $accountId)){ $crAmount=0;$drAmount=0;
 
 $openingBalance=$baseOpening+openingBalance($ree['accountID'],$fromDate,$pcode);

 ?> 
  <tr class="bg">
    <td colspan='7' align='left' >Opening Balance</td>
    <td  align='right' ><? echo number_format($openingBalance,2);?></td>
  </tr> 

 <?
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql1="select * from `receivecash` WHERE receiveDate between '$fromDate' AND '$toDate' 
       AND (receiveFrom LIKE '$q_accountId' OR receiveAccount LIKE '$q_accountId') ORDER by receiveDate ASC";
 //echo $sql1.'<br>';
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
$array_date[$i][0]=$st['receiveDate'];
$array_date[$i][1]=$st['receiveSL'];
$array_date[$i][2]=$st['reff'];
$array_date[$i][3]=$st['receiveAmount'];
if($st['receiveFrom'] ='$q_accountId') $array_date[$i][4]=2;
else if($st['receiveAccount'] ='$q_accountId') $array_date[$i][4]=1;
  $i++;
  }  

   $sql2="select * from `ex130` WHERE  exDate between '$fromDate' and '$toDate' 
        AND (paymentSL LIKE 'ct_%' OR paymentSL LIKE 'CT_%')
  	    AND  (exgl LIKE '$q_accountId' OR account LIKE '$q_accountId') 
  	    order by exDate ASC";  

//echo "$sql2<br>";
  $sqlQ=mysqli_query($db, $sql2);
  while($re=mysqli_fetch_array($sqlQ)){
//  echo "<br>***$re[exgl]==$ree[accountID] ***<br>";
  $array_date[$i][0]=$re['exDate'];
  $array_date[$i][1]=$re['paymentSL'];  
  $array_date[$i][2]=$re['exDescription']; 
  $array_date[$i][3]=$re['examount'];  
  if($re['exgl']=="$q_accountId") $array_date[$i][4]=1;  
   else  $array_date[$i][4]=2;  
        
  $i++;
  }//while

  ?>
<? 
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
$ro=$r+1;?>
 <tr>
   <td valign="top" class="bg" <? echo " rowspan=$ro";?> > 
   	<? echo "$q_accountId<br>".accountName($q_accountId);?>
   </td>
 </tr>  
<? for($i=0;$i<$r;$i++){?>
 <tr>
   <td valign="top"><? echo mydate($array_date[$i][0]);?></td>
   <td valign="top"><? echo $array_date[$i][1];?></td>   
   <td valign="top"> CDJ</td>      
   <td valign="top" align="left"><? echo $array_date[$i][2];?></td> 
   <td valign="top" align="right"><? if($array_date[$i][4]=='1') {
   echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?></td>   
   <td valign="top" align="right"><? if($array_date[$i][4]=='2') {
   echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?></td>   
 </tr>

<?   $k=1; }//for ?>
<tr class="bg">
 <td colspan='6' align='right' ><? echo number_format($drAmount,2); $drTotal+=$drAmount?></td>
 <td  align='right' ><? echo number_format($crAmount,2); $crTotal+=$crAmount?></td>
 <td  align="right"><? echo number_format($drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr  bgcolor='#66CCFF'>
 <td colspan='7' > Closing Balance</td>
<td bgcolor="#FFFF99" align="right"><? echo number_format($openingBalance+$drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr><td colspan='8' height='20' bgcolor='#FFFFFF'></td></tr>

<? 
}//if array search
}//while
?>

 <tr><td colspan="8" height="3" bgcolor="#FFCC66"></td></tr>

<tr bgcolor="#33CC66">
 <td colspan="5"></td>
 <td align="right"><?  echo number_format($drTotal,2);?></td>
 <td align="right"><?  echo number_format($crTotal,2);?></td>
 <td bgcolor="#FFFF66" align="right"><? echo number_format($drTotal-$crTotal,2)?></td>
</tr>  

</table>
<? }//if($fromDate AND $toDate){?>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>