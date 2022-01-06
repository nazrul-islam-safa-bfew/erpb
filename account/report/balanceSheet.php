
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.dropbtn {
  background-color: blue;
  color: white;
  padding: 10px;
  font-size: 10px;
  border: none;
}

.dropdown {
  position: relative;
  display: inline-block;

}
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  max-height: 400px;
  width: 300px;
  overflow-y: auto;
  overflow-x: hidden;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}

.scrollable-menu {
    height: auto;
    max-height: 200px;
    overflow-x: hidden;
}

</style>



<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<SCRIPT LANGUAGE="JavaScript">
	var now = new Date();
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd"));
		cal.setCssPrefix("TEST");
		cal.offsetX = 0;
		cal.offsetY = -150;

	</SCRIPT>
<form name="search" action="./index.php?keyword=balance+sheet" method="post"> 
	As of 
<input type="text" maxlength="10" name="edate" value="<? echo $edate;?>" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['search'].edate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
   <br>
   <br>
  <select name="pcode" size="1">
	  <option value="1">BFEW</option>  
	<? 
	include("config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
		
	$sqlp = "SELECT * from `project` ORDER by pcode ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	
	 while($typel= mysqli_fetch_array($sqlrunp))
	{
	 echo "<option value='".$typel[pcode]."'";
	 if($pcode==$typel[pcode]) echo "SELECTED";
	 echo ">$typel[pcode]--$typel[pname]</option>  ";
	 }
	 ?>
	</select>
	<input type="submit" name="search" value="search">
</form>		
<br>
<? if($search){
 $edate1=formatDate($edate,'Y-m-j');
if($pcode=='1'){
	$sqlp = "SELECT * from `project` where status='0' ORDER by pcode ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	$i=0;
	while($typel= mysqli_fetch_array($sqlrunp))
	{
	$pcodeList[$i]=$typel[pcode];
	$i++;
	}
	$pcodeListSize=sizeof($pcodeList);
	//print_r($pcodeList);
}
else {$pcodeList[0]=$pcode; $pcodeListSize=1;}

?>
<table width="100%" border="1" bordercolor="#EEEEEE" bgcolor="#FFFFFF" cellpadding="5" cellspacing="0" style="border-collapse:collapse"><tr><th colspan="3" bgcolor="#CCCCCC">ASSETS</th>
</tr>
<tr>
 <td colspan="3"><b>Current Assets</b></td>
</tr>
<tr>
 <td>
 Cash on Hand
 <?   
for($i=0;$i<$pcodeListSize;$i++){ 
 $project_cashonHand=cashonHand($pcodeList[$i],'2000-01-01',$edate1,'2'); 
// echo $pcodeList[$i]."=$project_cashonHand<br>";
 $cashonHand+=$project_cashonHand;
 }
  $totalCurrentAssets+=$cashonHand;
 ?> </td>
 <td width="200" align="right"><? echo number_format($cashonHand,2);?></td>
 <td width="200"></td>
</tr>
<?
echo "Testtttttt---".  test('2000-01-01',$edate1);

// $sqlp = "SELECT * from `project` ORDER by pcode ASC";
// 	//echo $sqlp;
// 	$sqlrunp= mysqli_query($db, $sqlp);
	
// 	 while($typel= mysqli_fetch_array($sqlrunp))
// 	{
//     echo "<br>";
// 	 echo $typel[pcode] ;
// 	 }


?>
<tr>
  
 <td>
 <div class="dropdown">
  <button class="dropbtn">+</button>
  <div class="dropdown-content">
    <?
    include("config.inc.php");
    $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
    $sql="select * from `accounts` WHERE  accountID BETWEEN '5601001' AND '5611002'";  	
    //$sql="select * from accounts where accountID in (select account from `purchase` WHERE paymentDate between '2000-01-01' and '2021-12-13' AND account BETWEEN '5601001' AND '5611002')";
   
		// echo "$sql<br>";
		$sqlQ=mysqli_query($db, $sql);
    while($r=mysqli_fetch_array($sqlQ)){
    ?>
    <a href="#"><?echo $r['description'];?></a>
    <?}?>
  </div>
</div>  



<!-- <select size="1">
  <option  selected>+</option>
  <?
    include("config.inc.php");
    $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
    $sql="select * from `accounts` 
    WHERE  accountID BETWEEN '5601001' AND '5611002'";  	 
		// echo "$sql<br>";
		$sqlQ=mysqli_query($db, $sql);
    while($r=mysqli_fetch_array($sqlQ)){
    ?>
     <option value="1"><?echo $r['description'];?></option>
    <?}?>
</select> -->

  Cash at Bank  <? $cashonBank=cashonBank('2000-01-01',$edate1);
 
 ?></td>
 <td width="200" align="right"><? echo number_format($cashonBank,2);?></td>
 <td width="200"></td>
</tr>

<tr>
 <td>Accounts Receivable
 <? 
 for($i=0;$i<$pcodeListSize;$i++){ 
 $subaccountsReceivable=accountReceivable($pcodeList[$i],'2000-01-01',$edate1); 
 $accountsReceivable+=$subaccountsReceivable;
 }
 $totalCurrentAssets+=$accountsReceivable;?></td>
 <td width="200" align="right"><? echo number_format($accountsReceivable,2);?></td>
 <td></td> 
</tr>
<tr>
 <td>Work in Process</td>
 <td></td>
 <td></td> 
</tr>
<tr>
 <td>Other current Assets</td>
 <td></td>
 <td></td> 
</tr>
<tr>
 <td>Inventory <?
 
 for($i=0;$i<$pcodeListSize;$i++){ 
  $balance1=totalMaterialReceive('2000-01-01',$edate1,$pcodeList[$i]);
  $balance2=total_mat_issueAmount_date($pcodeList[$i], '2000-01-01',$edate1);
  $subinventory=$balance1-$balance2; $balance1=0;$balance2=0;
  $inventory+=$subinventory;
  //echo $pcodeList[$i]."=$subinventory<br>";
  }
    if($pcode=='1')$inventory+=centerStoreBalance();
    $totalCurrentAssets+=$inventory;
  ?></td>
 <td width="200" align="right"><? echo number_format($inventory,2);?></td>
 <td></td> 
</tr>

<tr><td></td><td colspan="2" height="5" bgcolor="#000000"></td></tr>
<tr bgcolor="#FFFFCC">
 <td><i>Total current Assets</i></td>
 <td></td> 
 <td width="200" align="right"><b><? echo number_format( $totalCurrentAssets,2);?></b></td>
</tr>
<tr>
 <td colspan="3"><b>Property and Equipment</b></td>
</tr>
<tr>
 <td>land <? ?>
  </td>
  <td width="200"></td>
 <td width="200"></td>
</tr>
<tr>
 <td>Equipment <? if($pcode=='004' OR $pcode=='1'){
  $equipment_value=total_equipment_value($fromDate,$toDate,$pcode); 
   $totalProperty+=$equipment_value;
   }?>
  </td>
 <td width="200" align="right"><? echo number_format($equipment_value,2);?></td>
 <td width="200"></td>
</tr>
<tr>
 <td>Tools <?  if($pcode=='000' OR $pcode=='1'){
     $tools_value=total_tools_value($fromDate,$toDate,$pcode);
     $totalProperty+=$tools_value;
   }?>
  </td>
 <td width="200" align="right"><? echo number_format($tools_value,2);?></td>
 <td width="200"></td>
</tr>
<tr>
 <td>Office Tools <? if($pcode=='000' OR $pcode=='1'){
 for($i=0;$i<$pcodeListSize;$i++){ 
   $sub_total_officetools_value=total_officetools_value($fromDate,$toDate,$pcodeList[$i]);  
   $total_officetools_value+=$sub_total_officetools_value;
   }
   $totalProperty+=$total_officetools_value;
   }?>
  </td>
 <td width="200" align="right"><? echo number_format($total_officetools_value,2);?></td>
 <td width="200"></td>
</tr>
<tr>
 <td>Furniture<?  if($pcode=='000' OR $pcode=='1'){
	 $total_furniture_value=total_furniture_value($fromDate,$toDate,$pcode);  
	 $totalProperty+=$total_furniture_value;
   }?>
  </td>
 <td width="200" align="right"><? echo number_format($total_furniture_value,2);?></td>
 <td width="200"></td>
</tr>

<tr><td></td><td colspan="2" height="5" bgcolor="#000000"></td></tr>
<tr bgcolor="#FFFFCC">
 <td><i>Total Property and Equipment</i></td>
 <td width="200"></td>
<td width="200" align="right"><? echo number_format($totalProperty,2);?></td>
</tr>
<tr>
 <td colspan="3"><b>Other Assets</b></td>
</tr>
<tr>
 <td><i>Total Assets</i></td>
 <td width="200"></td>
 <td width="200"></td>
</tr>
<tr>
 <th colspan="3">LIABILITIES AND CAPITAL</th>
</tr>
<tr>
 <td colspan="3"><b>Current Liabilities</b></td>
</tr>
<tr>
 <td>Accounts Payable <? /* for($i=0;$i<$pcodeListSize;$i++){  
  $sub_accountPayable=accountPayable($pcodeList[$i],'2000-01-01',$edate1);
  $accountPayable+=$sub_accountPayable;
  
  }*/
  $totalCurrentLiabilities+=$accountPayable;?>
  </td>
 <td width="200" align="right"><? echo number_format($accountPayable,2);?></td>
 <td width="200"></td>
</tr>
<tr>
 <td>Other Current Liabilities</td>
 <td width="200"></td>
 <td width="200"></td>
</tr>
<tr><td></td><td colspan="2" height="5" bgcolor="#000000"></td></tr>
<tr bgcolor="#FFFFCC">
 <td><i>Total Current Liabilities</i></td>
 <td width="200" align="right"><? echo number_format( $totalCurrentLiabilities,2);?></td> 
</tr>
<tr>
 <td colspan="3"><b>Long-Term Liabilities</b></td>
</tr>
<tr>
 <td>Notes Payable-Noncurrent</td>
 <td width="200"></td>
 <td width="200"></td>
</tr>
<tr>
 <td>Total Long-Term Liabilities</td>
 <td width="200"></td>
 <td width="200"></td>
</tr>

<tr>
 <td>Total Liabilities</td>
 <td width="200"></td>
 <td width="200"></td>
</tr>
<tr>
 <td colspan="3"><b>Capital</b></td>
</tr>
<tr>
 <td>Paid-in Capital</td>
  <td width="200" align="right"><? $paid_in_capital=paid_in_capital(); 
  echo number_format($paid_in_capital,2);?></td>
 <td width="200"></td>
</tr>
<tr>
 <td>Retained Earnings</td>
  <td width="200"></td>
 <td width="200"></td>
</tr>
<tr bgcolor="#FFFFCC">
 <td><i>Net Income</i></td>
</tr>
</table>
<? }?>
  <div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>