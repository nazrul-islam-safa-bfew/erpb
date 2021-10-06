<?
//include("./account/payments.sql.php");
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
?>
<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>


<script type="text/javascript">	
var all_month=new Array();

<?php 
	$location=$exfor;
		
	$query=mysqli_query($db, "select * from account_locker where pcode='$location'");
	$comma=0;
echo 'all_month=[';
	while($ress=mysqli_fetch_array($query))
	{
		
		for($month_counter=1;$month_counter<=12;$month_counter++)
		{
			$comma++;
			if($ress[$month_counter+2])
				{
					
					echo '['.$ress['l_year'].',"'.$ress[$month_counter+2] .'"],';
					
				}
			
		}			


	}



?>];	
function check_lock(get_selected_date_value){
	get_selected_date_value=get_selected_date_value.split("/");
	
	for(i=0;i<=all_month.length;i++)
	{
		if(all_month[i][0]+","+all_month[i][1]==get_selected_date_value[2]+","+get_selected_date_value[1])
			document.getElementById('the_selected_date').value="";
	}
	
}
</script>

 <?
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sql = "SELECT * FROM accounts WHERE accountID='$accountID'";
//echo $sql;
$sqlQuery = mysqli_query($db, $sql);
$sqlResult=mysqli_fetch_array($sqlQuery);
$hcash_balance=balance_hcash('000', '2013-01-01',$toDate);
?>

<form action="./account/payments.sql.php?hcash_balance=<? echo $hcash_balance;?>" name="payments" method="post">
<table  width="800" align="center" >
  <tr>
  <td><input type="radio" name="w"  value="2"   <? if($w==2) echo "checked";?> onClick="location.href='./index.php?keyword=payments&w=2&exfor=000'">Cash Payment</td>
  <td><input type="radio" name="w"  value="8"   <? if($w==8) echo "checked";?> onClick="location.href='./index.php?keyword=payments&w=8'">Cash Transfer</td>  
  <td><input type="radio" name="w"  value="1"   <? if($w==1) echo "checked";?> onClick="location.href='./index.php?keyword=payments&w=1&exfor=<? echo  $loginProject;?>'">Emergency Cash Purchase</td>
  <td><input type="radio" name="w"  value="4"   <? if($w==4) echo "checked";?> onClick="location.href='./index.php?keyword=payments&w=4'">Payment against Purchase Order</td>
  </tr>
  <tr>
  <td><input type="radio" name="w" value="5"   <? if($w==5) echo "checked";?> onClick="location.href='./index.php?keyword=payments&w=5'">Salary</td>
  <td><input type="radio" name="w" value="6"   <? if($w==6) echo "checked";?> onClick="location.href='./index.php?keyword=payments&w=6'">Advance Salary Payment</td>
  <!--<td><input type="radio" name="w" value="51"   <? if($w==51) echo "checked";?> onClick="location.href='./index.php?keyword=payments&w=51'">Wages (Monthly) Payment </td>-->
  <td><input type="radio" name="w"  value="7"   <? if($w==7) echo "checked";?> onClick="location.href='./index.php?keyword=payments&w=7'">Wages Payment</td>
  </tr>
</table>
<? echo inwornMsg('IF there is no Positive Balance IN Head Office Cash THEN YOU cannot Make any Expenses!! ');?>
<br>
<br>
<? 
if($w){?>
<table  class="blue" width="500" align="center" onmouseover="check_lock(document.getElementById('the_selected_date').value);">
 <tr>
   <td class="blueAlertHd" colspan="4">payments</td>
 </tr>
 <tr>

   <td width="39">Date 
   	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date();
	var cal = new CalendarPopup("testdiv1");
    cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd"));
		cal.setCssPrefix("TEST");
		cal.offsetX = 50;
		cal.offsetY = -150;
	</SCRIPT></td>
      <td width="203"><input type="text" maxlength="10" name="paymentDate" value="<? echo $paymentDate; ?>" alt="req" title="Payment Date" readonly="" id="the_selected_date"> 
        <a id="anchor" href="#"
   onClick="cal.select(document.forms['payments'].paymentDate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>      </td>
</tr>
<? if($w==4){?>
 <!--<tr>
   <td>Select Vendor</td>
 <td colspan="3"><select name="vid" >
   <option value="">Select </option>
   <?
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT distinct vendor.vid,vendor.vname,porder.vid from `vendor`,porder WHERE".
" vendor.vid=porder.vid ORDER by vendor.vname ASC ";
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
 </tr>-->
 <? }
 else if($w==1) {?>
 <tr>
   <td>Select Vendor</td>
   <td>Open Market</td>
</tr>

 <tr>
   <td>Paid to</td>
   <td colspan="3"><input type="text" name="paidTo" value="<? echo $paidTo;?>" size="50"></td>
 </tr>

<? } else if($w==2) {?>
 <tr>
   <td>Paid to</td>
   <td colspan="3"><input type="text" name="paidTo" value="<? if($expencess) echo ''; else echo $paidTo;?>" size="50"></td>
 </tr>
<? } else if($w==5 OR $w==51 OR $w==7) {?>
 <tr>
   <td>For The month Of</td>
   <td colspan="3"><select  name="year">
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
     <select name="month" size="1" >
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
</select>   </td>
 </tr>
 
<? }?>

<? if($w==8){?>
 <tr>
   <td>Paid to</td>
   <td colspan="3"><input type="text" name="paidTo" value="<? echo $paidTo;?>" size="50"></td>
 </tr>

 <tr>
   <td>Transfer from</td>
      <td colspan="3"> 
<? echo "<select name='ct_from_account'> ";	  
   include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

	$sqlp = "SELECT * from `accounts` WHERE accountType IN('12') and active='1' order by accountId ASC";
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
		if($account=="$typel2[accountId]-$typel2[id]")  echo  " SELECTED";
		echo  ">$typel2[accountId]-$typel[description]-$typel2[landerName]</option>";
		}//while2
	}//while1
	echo "<option value='5501000-000'>5501000-HeadOffice Cash</option>";

	$sqlp = "SELECT `pcode`,pname from `project` order by pcode ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	while($typel= mysqli_fetch_array($sqlrunp))
	{
	if($typel[pcode]!='000'){
	echo "<option value='5502000-$typel[pcode]'";
	if($account=='5502000-'.$typel[pcode])  echo " SELECTED";
	echo ">5502000-$typel[pcode]--$typel[pname]</option>  ";
	}
	}
	
	$sqlp = "SELECT * from `accounts` WHERE accountType IN('3') and active='1' order by accountID asc";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	while($typel= mysqli_fetch_array($sqlrunp))
	{
	echo  "<option value='".$typel[accountID]."'";
	if($account=="$typel[accountID]")  echo  " SELECTED ";
	echo  ">$typel[accountID]-$typel[description]</option>  ";
	}//while1
 
	$sqlp = "SELECT * from `accounts` WHERE accountType IN('4') and active='1'";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	while($typel= mysqli_fetch_array($sqlrunp))
	{
		$sqlp2 = "SELECT `pcode`,pname from `project` order by pcode ASC";
		//echo $sqlp;
		$sqlrunp2= mysqli_query($db, $sqlp2);
		while($typel2= mysqli_fetch_array($sqlrunp2))
		{
		echo  "<option value='".$typel[accountID].'-'.$typel2[pcode]."'";
		if($account=="$typel[accountID]-$typel2[pcode]")  echo  " SELECTED";
		echo  ">$typel[accountID]-$typel2[pcode]-$typel[description]</option>  ";
		}//while2
	}//while1
	// $sqlp = "SELECT `empId` from `employee` where designation BETWEEN '72-00-000' AND  '74-99-999' ORDER by empId ASC"; //stop by salma
	$sqlp = "SELECT `empId` from `employee` where designation like '71-%-%' ORDER by empId ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	while($typel= mysqli_fetch_array($sqlrunp))
	{
	echo "<option value='5700000-$typel[empId]'"; if($account=="5700000-$typel[empId]") echo " SELECTED "; 
	echo ">5700000-DIRECTORS ACCOUNTS-".empName($typel[empId])."</option>";
	}
	
echo '</select>';?></td></tr>
 <tr>
   <td>transfer to</td>
      <td colspan="3"> 
<? echo "<select name='ct_to_account'>";	  
   include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	$sqlp = "SELECT * from `accounts` WHERE accountType IN('12') and active='1' order by accountId ASC";
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
		if($ct_to_account=="$typel2[accountId]-$typel2[id]")  echo  " SELECTED";
		echo  ">$typel2[accountId]-$typel[description]-$typel2[landerName]</option>";
		}//while2
	}//while1
     
	 echo "<option value='5501000-000'>5501000-HeadOffice Cash</option>";
	$sqlp = "SELECT `pcode`,pname from `project` order by pcode ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	while($typel= mysqli_fetch_array($sqlrunp))
	{
	if($typel[pcode]!='000'){
	echo "<option value='5502000-$typel[pcode]'";
	if($account=="5502000-$typel[pcode]")  echo " SELECTED";
	echo ">5502000-$typel[pcode]--$typel[pname]</option>  ";
	}
	}
	$sqlp = "SELECT * from `accounts` WHERE accountType IN('3') and active='1' order by accountID asc";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	while($typel= mysqli_fetch_array($sqlrunp))
	{
	echo  "<option value='".$typel[accountID]."'";
	if($account=="$typel[accountID]")  echo  " SELECTED ";
	echo  ">$typel[accountID]-$typel[description]</option>  ";
	}//while1
 
	$sqlp = "SELECT * from `accounts` WHERE accountType IN('4') and active='1'";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	while($typel= mysqli_fetch_array($sqlrunp))
	{
		$sqlp2 = "SELECT `pcode`,pname from `project` order by pcode ASC";
		//echo $sqlp;
		$sqlrunp2= mysqli_query($db, $sqlp2);
		while($typel2= mysqli_fetch_array($sqlrunp2))
		{
		echo  "<option value='".$typel[accountID].'-'.$typel2[pcode]."'";
		if($account=="$typel[accountID]-$typel2[pcode]")  echo  " SELECTED";
		echo  ">$typel[accountID]-$typel2[pcode]-$typel[description]</option>  ";
		}//while2
	}//while1
	//$sqlp = "SELECT `empId` from `employee` where designation BETWEEN '72-00-000' AND  '74-99-999' ORDER by empId ASC"; //stop by salma
	$sqlp = "SELECT `empId` from `employee` where designation like '71-%-%' ORDER by empId ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	while($typel= mysqli_fetch_array($sqlrunp))
	{
	echo "<option value='5700000-$typel[empId]'"; if($account=="5700000-$typel[empId]") echo " SELECTED "; 
	echo ">5700000-DIRECTORS ACCOUNTS-".empName($typel[empId])."</option>";
	}
	
echo '</select>';?></td></tr>

<? }else{?>
 <tr>
   <td>Cash Account</td>
      <td colspan="3"> 
	<?   if($loginProject=='000') {   
	include("./includes/config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
		
	
	echo "<select name='account'>"; 
    echo "<option value='5501000-000'>5501000-HeadOffice Cash</option>";
	$sqlp = "SELECT * from `accounts` WHERE accountType IN('3') and active='1'";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	while($typel= mysqli_fetch_array($sqlrunp))
	{
	echo  "<option value='".$typel[accountID]."'";
	if($account==$typel[accountID])  echo  " SELECTED";
	echo  ">$typel[accountID]--$typel[description]</option>  ";
	}
	//
	
	echo '</select>';
	}// if($loginProject=='000') 	
	?>      </td>
    </tr>
<? }//else w=8?>	
<? if($w!=8 ){?>

<tr><td><? if($w==1) echo "Purchase For"; 
            else if($w==2 OR $w==4){ echo 'Expense For'; }
		      else if($w==5  OR $w=='51' ){ echo 'Salary For'; }
		       else if($w==7){ echo 'Wages For'; }			  
			?>
	</td>
      <td colspan="3"> 
<? if($w==4){?>	
	  <select name='exfor' 
	  onChange="location.href='index.php?keyword=payments&w=<? echo $w;?>&exfor='+
	payments.exfor.options[document.payments.exfor.selectedIndex].value+	
	'&account='+payments.account.options[document.payments.account.selectedIndex].value
	">
  <? } else {?>
<!--	  

<select name='exfor' 
	  onChange="location.href='index.php?keyword=payments&w=<? echo $w;?>&exfor='+
	payments.exfor.options[document.payments.exfor.selectedIndex].value+'&year='+
	payments.year.options[document.payments.year.selectedIndex].value+'&month='+
    payments.month.options[document.payments.month.selectedIndex].value+	
	'&account='+payments.account.options[document.payments.account.selectedIndex].value">
	-->
	
	<select name='exfor' 
	  onChange="location.href='index.php?keyword=payments&w=<? echo $w;?>&exfor='+
	payments.exfor.options[document.payments.exfor.selectedIndex].value+'&year='+
	payments.year.options[document.payments.year.selectedIndex].value+'&month='+
    payments.month.options[document.payments.month.selectedIndex].value+	
	'&account='+payments.account.options[document.payments.account.selectedIndex].value">
	
	<? }?>
  <? 
	include("./includes/config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	echo "<option>select One</option>";	
	$sqlp = "SELECT `pcode`,pname from `project` ORDER by pcode ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	while($typel= mysqli_fetch_array($sqlrunp))
	{
	echo "<option value='".$typel[pcode]."'";
	if($exfor==$typel[pcode])  echo " SELECTED";
	echo ">$typel[pcode]--$typel[pname]</option>  ";
	}
  } // else w=4
} //if($w<>8)  ?>
  </select>
</table>

<br>
<br>
<? if($w==1 AND $cashPurchase==0){include("./account/ep.php");$paidAmount=$extotal;} 
else if($w==2 ){include("./account/ex.php");} 
 else if($w==8){include("./account/ct.php");} 
  else if($w==4 ){include('./account/vendor_payment.php');}
   else if(($w=='5' OR $w=='51' )AND $month!='' AND $exfor!=''){ include('./account/salary.php');}
	else if($w==6){   include('./account/advanceSalary.php'); }// else ifw=6
	 else if($w==7 and $month)include('./account/wages.php');?>



<input type="hidden" name="paidAmount" value="<? echo $paidAmount;?>">
<input type="hidden" name="calculate" value="1">	
</form>


<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>