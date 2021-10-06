<? if($e==1){?>
<form name="sreturn" action="./store/storeReturn.sql.php?save=Update" method="post">
<table width="90%" align="center" border="1" bordercolor="#CCCCCC" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
<td colspan="3">Transfer Date: <? echo myDate($edate);?>
  Transfer SL#: <? $t=$rsl;echo $t;?>
 <input  type="hidden" name="rsl" value="<? echo $t;?>">   
</td>
<td colspan="3"> <font class='englishhead'>material return form</font></td></tr>
<tr bgcolor="#EEEEEE">
 <th height="35">ItemCode</th>
 <th>Description</th> 
 <th>Unit</th>
 <th>tarnsfer qty</th>
 <th>Quality remarks</th>

</tr>
<? 
$i=1;
include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
$sql="SELECT SUM(receiveQty) as qty, ROUND(AVG(rate),2) as rate,itemCode,remark,delivery FROM storet WHERE rsl LIKE '$rsl' AND currentQty <> 0 GROUP by ItemCode";
//echo $sql;	
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){
$temp=itemDes($re[itemCode]);
?>
<tr>
	<td><? echo $re[itemCode];?>
    <input  type="hidden" name="itemCode<? echo $i;?>" value="<? echo $re[itemCode];?>">
	<input  type="hidden" name="rate<? echo $i;?>" value="<? echo $re[rate];?>">		
	
	</td>
	<td><? echo $temp[des].', '.$temp[spc];?></td>
	<td align="center"><? echo $temp[unit];?></td>
	<td align="right"><? echo number_format($re[qty],3);?></td>
	<td align="center"><input type="text" name="quality<? echo $i;?>" value="<? echo $re[remark];?>" ></td>
<!--	<td align="right"><input type="text" name="rqty<? echo $i;?>" size="10" class="number" onBlur="if(this.value><? echo $re[qty];?>){ alert('Given qty is higher then stock at hand!!'); this.value=''}"></td>-->
    
</tr>
<? $i++;
$delivery=$re[delivery];
}?>
<tr>
 <td colspan="6">Delivery details: <? echo $delivery;?></td>
</tr>
<tr><td colspan="6" align="center"><input type="button" name="save" value="Update" onClick="sreturn.submit();">
<input type="hidden" name="n" value="<? echo $i;?>"></td></tr>
</table>
</form>
<? }
 else {?>

	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<form name="sreturn" action="./store/storeReturn.sql.php?save=Save" method="post">
<table width="90%" align="center" border="1" bordercolor="#CCCCCC" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
<td colspan="3">
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
Transfer Date: 
 <input class="yel" type="text" maxlength="10" name="edate"  value="<? echo $edate;?>"> <a id="anchor" href="#"
   onClick="cal.select(document.forms['sreturn'].edate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
Transfer SL#: <? $t=storeReturnsl($loginProject);echo $t;?>
 <input  type="hidden" name="rsl" value="<? echo $t;?>">   
</td>
<td colspan="3"> <font class='englishhead'>material return form</font></td></tr>
<tr bgcolor="#EEEEEE">
 <th height="35">ItemCode</th>
 <th>Description</th> 
 <th>Unit</th>
 <th>stock at hand</th>
 <th>Quality remarks</th>
 <th>transfer Qty.</th>
</tr>
<? 
$i=1;
include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
$sql="SELECT SUM(currentQty) as qty, AVG(rate) as rate,itemCode FROM store$loginProject WHERE 1 AND currentQty <> 0 GROUP by ItemCode";
//echo $sql;	
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){
$temp=itemDes($re[itemCode]);
?>
<tr>
	<td><? echo $re[itemCode];?>
    <input  type="hidden" name="itemCode<? echo $i;?>" value="<? echo $re[itemCode];?>">
	<input  type="hidden" name="rate<? echo $i;?>" value="<? echo $re[rate];?>">		
	
	</td>
	<td><? echo $temp[des].', '.$temp[spc];?></td>
	<td align="center"><? echo $temp[unit];?></td>
	<td align="right"><? echo number_format($re[qty],3);?></td>
	<td align="center"><input type="text" name="quality<? echo $i;?>" ></td>
	<td align="right"><input type="text" name="rqty<? echo $i;?>" size="10" class="number" onBlur="if(this.value><? echo $re[qty];?>){ alert('Given qty is higher then stock at hand!!'); this.value=''}"></td>

</tr>
<? $i++;}?>
<tr>
 <td colspan="6">Delivery details: <textarea cols="60" rows="2" name="delivery"></textarea></td>
</tr>
<tr><td colspan="6" align="center"><input type="button" name="save" value="Save" onClick="sreturn.submit();">
<input type="hidden" name="n" value="<? echo $i;?>"></td></tr>
</table>
</form>
<? }?>
<table align="center" width="90%" border="1" bordercolor="#000000">
<tr>
 <th>Transfer SL#</th>
 <th>Date</th>
 <th>Delivery details</th>
</tr>
<? include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
$sql="SELECT * from storet WHERE returnFrom='$loginProject' AND currentQty > 0 GROUP by rsl";
//echo $sql;	
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){
$temp=itemDes($re[itemCode]);
?>
<tr>
 <td><? echo $re[rsl];?> [ <a href="./index.php?keyword=store+return&e=1&rsl=<? echo $re[rsl];?>&edate=<? echo $re[edate];?>">Edit</a> ]</td>
 <td><? echo $re[edate];?></td> 
 <td><? echo $re[delivery];?></td>  
</tr>
<? }?>
</table>
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>