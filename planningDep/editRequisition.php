
<!-- Store Purches Requisition -->
<? echo "Purchase Requisition >> Planning Department<br><br>";

?>
<? if(!$submit){

include("./config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
 
 $sqlshow="SELECT * from `purchaseReq` where `prId` = '$rid'";
 //echo $sqlshow;
 $sqlshowrun=mysql_query($sqlshow);
 $pr=mysql_fetch_array($sqlshowrun);
 
 include("./config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
 
 $sqlshow1="SELECT * from `itemlist` where `itemCode` like '$pr[itemCode]'";
// echo $sqlshow;
 $sqlshowrun1=mysql_query($sqlshow1);
 $item=mysql_fetch_array($sqlshowrun1);

?>

<form name="spr" action="./index.php?keyword=edit+purchase+requisition" method="post">
  <table align="center" width="400" height="10" border="1" bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
    <tr> 
      <td colspan="2" bgcolor="#EEEEEE" align="center"><b>Purchase Requisition</b></td>
    </tr>

    <tr bgcolor="#FFFFEE"> 
      <td width="140">Item Code No.</td>
      <td width="154"><input type="text" name="itemCode" size="9" maxlength="9" value="<? echo $pr[itemCode]?>" readonly=""></td>
    </tr>
    <tr bgcolor="#FFFFEE"> 
      <td width="140">Item Description</td>
      <td width="154"><? echo "$item[itemDes],<br> $item[itemSpec], $item[itemType]";?></td>
    </tr>

    <tr bgcolor="#FFFFEE"> 
	  <td>Current Requirement</td>
      <td><input type="text" name="currentReq" size="10" maxlength="10" value="<? echo $pr[currentReq]?>" readonly=""></td>
    </tr>
    <tr> 
      <td>Unit Price</td>
      <td><input type="text" name="unitPrice"size="10" maxlength="10" value="<? echo $pr[unitPrice]?>" onBlur="spr.totalPrice.value=spr.currentReq.value*spr.unitPrice.value" ></td>
    </tr>
    <tr> 
      <td>Total Price</td>
      <td><input type="text" name="totalPrice"size="10" maxlength="10" value="<? echo $pr[totalPrice]?>"></td>
    </tr>
    <tr bgcolor="#FFFFEE"> 
      <td >Receivable deadline(dd/mm/yyyy)</td>
      <td><input type="text" name="deadLine"size="10" maxlength="10" value="<? echo $pr[deadLine]?> " readonly=""></td>
    </tr>
    <tr bgcolor="#FFFFEE"> 
      <td>Priority</td>
      <td><input type="text" name="priority"size="10" maxlength="10" value="<? if($pr[priority]==0) echo 'Low'; elseif($pr[priority]==1) echo 'Normal'; elseif($pr[priority]==2) echo 'High';?>" readonly=""></td>
    </tr>
    <tr bgcolor="#FFFFEE"> 
     <td>Item of work</td>
     <td><input type="text" name="itemofWork" value="<? echo $pr[itemofWork]?>"readonly=""></td>
    </tr>
    <tr> 
     <td>Preferred Source</td>
     <td><select name="preferredSource" onChange="if(spr.preferredSource.selectedIndex==1)alert('Please Put Unti Price');">
          <option <? if($pr[preferredSource]=='Head office Purchase') echo 'selected';?>>Head office Purchase</option>
          <option <? if($pr[preferredSource]=='Site Purchase') echo 'selected';?>>Site Purchase</option>
        </select> 
	</td>
    </tr>
    <tr> 
      <td>Approval Status</td>
      <td><select name="approvalStatus" onChange="if(spr.approvalStatus.selectedIndex==0 || spr.approvalStatus.selectedIndex==3){alert('Please Put Message'); div1.className= 'visible' ;div2.className= 'visible'}if(spr.approvalStatus.selectedIndex==1 || spr.approvalStatus.selectedIndex==2){div1.className= 'hidden' ;div2.className= 'hidden'}">
          <option>Hold By Mngr. P&C</option>
          <option>Approved By Mngr. P&C</option>
          <option>Forwarded to MD</option>
          <option>Rejected By Mngr. P&C</option>		  
        </select> 
 	 </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td><DIV  id=div1 class=hidden>Reason for Rejection</div></td>
      <td><DIV  id=div2 class=hidden><input type="text" name="reason"size="25" maxlength="100" value="<? echo $pr[reason];?>" ></div></td>
    </tr>
	
    <tr>
      <td align="center" colspan="2"> 
	  <input type="hidden" name="rid" value="<? echo $rid;?>">
	  <input type="submit" name="submit" value="submit"></td>
    </tr>
  </table>
</form>
<? }?>
<? 
if($confirm){
$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$lastUpdate = date("Y-m-j",$time);

include("./session.inc.php");
include("./config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
 


 $sqlp = "UPDATE `purchaseReq` SET `itemCode`='$itemCode', `currentReq`='$currentReq', `unitPrice`='$unitPrice', `totalPrice`='$totalPrice', `deadLine`='$deadLine',`priority`='$priority', `itemofWork`='$itemofWork',`preferredSouce`='$preferredSource',`lastUpdate`='$lastUpdate', `approvalStatus`='$approvalStatus' WHERE `prid`='$rid'";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
//save message
$todatTime = date("Y-m-d H:i:s"); 

include("./config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
 
$message="<b>$approvalStatus</b>";
if($reason) $message.=" >> <b>Reason: $reason</b>";
$sqlmsg="INSERT INTO message (id,prID, name,msg,sdate) VALUES ('','$rid', '$loginFullName', '$message','$todatTime')";
//echo $sqlmsg;
mysql_query($sqlmsg);
}//confirm
?>
<? 
if($submit){
include("./config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
 
 $sqlshow="SELECT * from `itemlist` where `itemCode` like '$itemCode'";
// echo $sqlshow;
 $sqlshowrun=mysql_query($sqlshow);
 $pr=mysql_fetch_array($sqlshowrun);
?>

<table width="700" align="left" border="0"  cellspacing="0" cellpadding="10">
<tr><td align="center">Bangladesg Foundry & Engineering Works Ltd.<br><u><font size="1">PURCHASE REQUISITION FORM</font></u></td></tr>
<tr>
 <td>
 <table width="600">
   <tr>
	<td> Project Name.<u><? echo $loginProjectName;?> </u><td><td align="right">Checked By <u><? echo $loginFullName;?></u></td>
    </tr>
   <tr>
    <td> Project Code.<u><? echo $loginProject;?> </u><td>	<td align="right">Date.<u><? echo $today;?> </u></td>
  </tr>
 </table></td>
 </tr>

<tr><td>
    <table width="100%" border="1" bordercolor="#EEEEEE" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
        <tr> 
          <td width="180" > Item Code No. :<? echo $itemCode;?></td>
          <td colspan="3"> Item Description : <? echo $pr[itemDes];?></td>
        </tr>
        <tr> 
          <td> Stock in Hand : </td>
          <td> Current Requirement: <? echo "$currentReq, $pr[itemUnit]";?></td>
          <td> Unit Price : <? echo $unitPrice;?></td>
          <td> Total Price: <? echo $totalPrice;?></td>
        </tr>
        <tr> 
          <td colspan="4"> Item of Work : <? echo $itemofWork;?></td>
        </tr>
        <tr> 
          <td colspan="2"> Preferred Source: <? echo $preferredSource;?></td>
          <td colspan="2"> Approval Status : <? echo $approvalStatus;?></td>
        </tr>
      </table>
</td></tr>
<tr><td><form name="confirm" action="./index.php?keyword=edit+purchase+requisition" method="post">
<input type="hidden"  name="itemCode"   value="<? echo $itemCode;?>">
<input type="hidden" name="currentReq"  value="<? echo $currentReq?>" >
<input type="hidden" name="stockinHand"   value="<? echo $stockinHand?>">
<input type="hidden" name="unitPrice"  value="<? echo $unitPrice?>">
<input type="hidden" name="totalPrice" value="<? echo $totalPrice?>" >
<input type="hidden" name="deadLine" value="<? echo $deadLine?>">
<input type="hidden" name="priority" value="<? echo $priority?>">
<input type="hidden" name="itemofWork" value="<? echo $itemofWork?>">
<input type="hidden" name="preferredSource" value="<? echo $preferredSource; ?>"> 
<input type="hidden" name="approvalStatus" value="<? echo $approvalStatus ?>">
<input type="hidden" name="reason" value="<? echo $reason ?>">
<input type="hidden" name="rid" value="<? echo $rid;?>">
 <input type="submit" name="confirm" value="Confirm">
 </form>
 </td></tr> 
 
</table>
<? }?>