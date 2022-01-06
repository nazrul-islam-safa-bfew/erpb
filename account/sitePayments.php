<?
//include("./account/payments.sql.php");

include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

?>
<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<? 
$sql = "SELECT * FROM accounts WHERE accountID='$accountID'";
//echo $sql;
$sqlQuery = mysqli_query($db,$sql);
$sqlResult=mysqli_fetch_array($sqlQuery)?>

<form <? if($w!=2 || 1==1)echo 'action="./account/sitePayments.sql.php"'; ?> name="payments" method="post">
<table  width="800" align="center" border="0" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
  <tr>
  <td><input type="radio" name="w"  value="2"   <? if($w==2) echo "checked";?> onClick="location.href='./index.php?keyword=site+payments&w=2&exfor=000'">Cash Payment</td>
  <td><input type="radio" name="w"  value="3"   <? if($w==3) echo "checked";?> onClick="location.href='./index.php?keyword=site+payments&w=3&exfor=000'">Fuel Purchase</td>
  <td><input type="radio" name="w"  value="1"   <? if($w==1) echo "checked";?> onClick="location.href='./index.php?keyword=site+payments&w=1&exfor=<? echo  $loginProject;?>'">Emergency Cash Purchase</td>
	</tr>
	<tr>
  <td><input type="radio" name="w" value="4"   <? if($w==4) echo "checked";?> onClick="location.href='./index.php?keyword=site+payments&w=4'">Fooding Payment</td>  
  <td><input type="radio" name="w" value="5"   <? if($w==5) echo "checked";?> onClick="location.href='./index.php?keyword=<?php 
		if($loginProject=='000')echo "payments";
		else echo "site+payments";
		?>&w=5'">Salary</td>
  <td><input type="radio" name="w"  value="7"   <? if($w==7) echo "checked";?> onClick="location.href='./index.php?keyword=site+payments&w=7'">Wages (Master Roll) Payment</td>
  </tr>

</table>

<? echo inwornMsg('IF there is no Positive Balance IN Site Office Cash THEN YOU cannot Make any Expenses!! ');?>
<br>
<br>
<? 
if($w){?>
<table  class="blue" width="500" align="center" onmouseover="check_lock(document.getElementById('the_selected_date').value);">
 <tr>
   <td class="blueAlertHd" colspan="4">payments</td>
 </tr>
	
	
	
 <tr>
   <td width="39">Payment date 
   	<SCRIPT LANGUAGE="JavaScript">
			
			
		function makeBlank(){
			$(document).ready(function(){
				$("#paidToS").html('<option value="">Select one</option>');
			});
		}
			
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
      <td width="203"><input type="text" maxlength="10" name="paymentDate" value="<? echo $paymentDate; ?>" alt="req" title="Payment Date" readonly="" id="the_selected_date">
				<a id="anchor" href="#"
   onClick="cal.select(document.forms['payments'].paymentDate,'anchor','dd/MM/yyyy'); makeBlank(); return false;"
   name="anchor"><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      </td>
</tr>
	
	
<? if($w==2){?>
 <tr>
		 <td width="39">Voucher date 
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
      <td width="203"><input type="text" maxlength="10" name="voucherDate" value="<? echo $voucherDate; ?>" alt="req" title="Voucher Date" readonly="" id="voucherDate"> 
        <a id="anchor" href="#"
   onClick="cal.select(document.forms['payments'].voucherDate,'anchor','dd/MM/yyyy');  makeBlank(); return false;" 
   name="anchor"><img src="./images/b_calendar.png" alt="calender" border="0"></a> (Optional)
      </td>
</tr>
	
	<script>
		function reloadPage(){
			$(document).ready(function(){
				var previousVoucherDate="<?php echo $voucherDate; ?>";
				var previousPaymentDate="<?php echo $paymentDate; ?>";
				var paymentDate=$("#the_selected_date").val();
				var voucherDate=$("#voucherDate").val();
				var url="./index.php?keyword=site+payments&w=2&exfor=<?php echo $loginProject; ?>";
				var newUrl="";
// 				console.log(voucherDate);
				if(previousVoucherDate!=voucherDate || previousPaymentDate!=paymentDate){
// 				console.log(previousVoucherDate+paymentDate+previousPaymentDate+paymentDate);
					newUrl=url+"&paymentDate="+paymentDate+"&voucherDate="+voucherDate;
					window.location.href=(newUrl);
				}
			});
		}
	</script>
	
	<?php } ?>
	
	
	
<? if($w==10){?>
<tr>
<td>Select Purchase Order</td>
<td>
<select name="posl" onChange="location.href='index.php?keyword=site+payments&w=<? echo $w;?>&posl='+payments.posl.options[document.payments.posl.selectedIndex].value";>
	<option value="">Select one</option>
	<?
	$i=1;
	include("./includes/config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

	if($loginProject=='000')
	$sqlp = "SELECT distinct posl from `porder` WHERE posl LIke 'PO_%' ORDER by location ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);

	 while($typel= mysqli_fetch_array($sqlrunp))
	{
	 echo "<option value='".$typel[posl]."'";
	 if($posl==$typel[posl]) echo "SELECTED";
	 echo ">".viewPosl($typel[posl])."</option>  ";
	 }
	?>
</select>

</td></tr>
<? 

$t=explode('_',$posl);
if($t[0]=='EP') $exfor=$t[1];
?>
<input type="hidden" name="exfor" value="<? echo $exfor;?>">
<? }?>
 <? if($w==4){?>
 <tr>
   <td>Select Vendor</td>
   <td colspan="3"><select name="vid" onChange="location.href='index.php?keyword=site+payments&w=<? echo $w;?>&vid='+payments.vid.options[document.payments.vid.selectedIndex].value";>
 <option value="">Select </option>
<?
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT distinct vendor.vid,vendor.vname,porder.vid from `vendor`,porder WHERE vendor.vid=porder.vid AND porder.location='$loginProject' AND porder.itemCode>='99-00-000' ORDER by vendor.vname ASC ";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[vid]."'";
 if($vid==$typel[vid]) echo " SELECTED ";
 echo ">$typel[vname]</option>  ";
}
?>
	 </select>
   </td>
 </tr>

<? } if($w==1) {?>
 <tr>
   <td>Select Vendor</td>
   <td>Open Market</td>
</tr>
<? } ?>
	
<? if($w!=2){?>	
 <tr>
   <td>Paid to</td>
   <td colspan="3"><input type="text" name="paidTo" value="<? if($expencess) echo ''; else echo $paidTo;?>" size="50"></td>
 </tr>
<?php }else{ ?>
 <tr>
   <td>Paid to</td>
	 <td colspan="3">
	<?php 
	?>
		<select name="paidTo" id="paidToS" required onclick="reloadPage();">
	<option value=''>Select Employee</option>
<?php
	if($paymentDate){
		$ccDate=explode("/",$paymentDate);
		$ssDate=$ccDate[2]."-".$ccDate[1]."-".$ccDate[0];

		if($voucherDate){
			$ccDate=explode("/",$voucherDate);
			$ssDate=$ccDate[2]."-".$ccDate[1]."-".$ccDate[0];
		}
		
		$sql="select e.*,i.itemDes from employee as e,itemlist as i where e.location='$loginProject' and e.empId in (select empId from attendance where  location='$loginProject'
		and (designation like '72%')
		
		group by empId) and e.designation=i.itemCode order by e.designation asc";
		//echo $sql;
		$q=mysqli_query($db,$sql);
		while($row=mysqli_fetch_array($q)){
			echo "<option value='$row[designation]$row[empId] $row[name], $row[itemDes]'>$row[designation] $row[name], $row[itemDes]</option>";
		}
	}
?>
			<option value=""></option>
		</select>
		 <?php //echo $sql; ?>
	</td>
 </tr>
  
<?php } ?>
	
<? if($w==5 OR $w==51 OR $w==7) {?>
 <tr>
   <td>For The month Of</td>
   <td colspan="3">
   <select  name="year">
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
  <select name="month" size="1" onChange="location.href='index.php?keyword=site+payments&w=<? echo $w;?>&year='+
   payments.year.options[document.payments.year.selectedIndex].value+
  '&month='+payments.month.options[document.payments.month.selectedIndex].value";>
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
   </td>
 </tr>
<? }?>


 <tr>
   <td>Cash Account</td><td>5502000-Site Cash<? echo $loginProjectName;?></td>
   <input type="hidden" name="account" value="5502000-<? echo $loginProject;?>">
   <input type="hidden" name="exfor" value="<? echo $loginProject;?>">   
   
   <?  $exfor=$loginProject; }   ?>
</tr>
  
  
  <?php if($w==2){ ?> 
  
  <tr>
    <td>Select Iow</td>
    <td>
    <select style="width:300px" name='iowId_cp'>
      <option style='background:#f00;color:#fff'>Non IOW</option>
  <?php
  $sql="select iowCode,iowDes,iowId from iow where iowProjectcode='$loginProject' and iowStatus='Approved by MD' ";
  $q=mysqli_query($db,$sql);
  while($row=mysqli_fetch_array($q)){
    $iowDes=substr($row[iowDes],0,50);
    echo "<option value='$row[iowId]'>$row[iowCode]: $iowDes</option>";
  }
  ?>     
      </select>   
    </td> 
  </tr>
  
  <?php } ?>

</table>

<br>
<br>
<br>
<br>
<? if($w==1 AND $cashPurchase==0){include("./account/ep.php");$paidAmount=$extotal;} 
else if($w==2 ){include("./account/ex.php");} 
else if($w==3 ){include("./account/ex_fuel.php");} 
 else if($w==8){include("./account/ct.php");} 
  else if($w==4 ){include('./account/vendor_payment.php');}
   else if(($w=='5' OR $w=='51' )AND $month!='' AND $exfor!=''){ include('./account/salary.php');}
	  else if($w==6){   include('./account/advanceSalary.php'); }// else ifw=6
	   else if($w==7 and $month)include('./account/wages.php');?>




<input type="hidden" name="paidAmount" value="<? echo $paidAmount;?>">
	<input type="hidden" name="calculate" value="1">	
</form>



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
	try{
		for(i=0;i<=all_month.length;i++)
		{
			if(all_month[i][0]+","+all_month[i][1]==get_selected_date_value[2]+","+get_selected_date_value[1])
			document.getElementById('the_selected_date').value="";
		}		
	}catch(e){
		
	}
}
</script>


<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>