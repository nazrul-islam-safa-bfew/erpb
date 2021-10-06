
<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<script language="javascript" type="text/javascript" src="./js/internal_request.js"></script>
<form name="searchBy" action="./index.php?keyword=ep+ledger" method="post">
<table width="600" align="center" class="ablue">
<tr><td colspan="3" align="right" class="ablueAlertHd">emergency purchase ladger</td></tr>
  <tr>
   <th align="left">Select Project</th>
 <td>

<select name="pcode">
<?php if($_SESSION["loginDesignation"]!="Procurement Executive"){?>
<?php } ?>	
<?
	include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT `pcode`,pname from `project`";
if($_SESSION["loginDesignation"]=="Procurement Executive")$sqlp.=" where pcode='".$_SESSION["loginProject"]."'";
$sqlp.=" ORDER by pcode ASC";
//echo $sqlp;

$sqlrunp= mysqli_query($db, $sqlp);
 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[pcode]."'";
 if($pcode==$typel[pcode])  echo " SELECTED";
 echo ">$typel[pcode]--$typel[pname]</option> ";
}
?>
	</select>
</td>
		
 </tr>
	<tr>
		<td>
			<b>From</b>
		</td>
		<td align='left'>
			<input type="text" name="fdate" value="<?php echo $fdate; ?>">
			
  <SCRIPT LANGUAGE="JavaScript">
	var now = new Date();
	var cal = new CalendarPopup("testdiv1");
    cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd"));
		cal.setCssPrefix("TEST");
		cal.offsetX = 10;
		cal.offsetY = 0;
	</SCRIPT>
			
        <a id="anchor" href="#"
   onClick="cal.select(document.forms['searchBy'].fdate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
			
		</td>
	</tr>
	<tr>
		<td>
			<b>To</b>
		</td>
		<td align='left'>
			<input type="text" name="tdate" value='<?php echo $tdate; ?>'>
        <a id="anchor" href="#"
   onClick="cal.select(document.forms['searchBy'].tdate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
		</td>

 </tr>


<tr><td colspan="2" align="right" class="ablueAlertHd_small2" >
<input type="submit" name="search" value="Search" class="ablue_btn"  onmouseover="this.className='ablue_btnhover'" onmouseout="this.className='ablue_btn'"></td>
</tr>
</table>
</form>
<? if($search OR $page>1){
if($vid=='') $vid='%';
if($pcode=='') $pcode='%';
?>
<table align="center" class="dblue" border="1" width="95%">
<tr class="dblueAlertHd_small">
 <td height="30">Date</td>
 <td >MR/Payment SL.</td> 
 <td >Amount Paid</td>
</tr>

<? 
$total_result=1;
	
	$expDate=explode("/",$tdate);
	$tdate1=$expDate[2]."-".$expDate[1]."-".$expDate[0];
	
	$expDate=explode("/",$fdate);
	$fdate1=$expDate[2]."-".$expDate[1]."-".$expDate[0];
	
	$sql="SELECT sum(receiveQty*rate) as totalAmount,sum(receiveQty) as receiveQty,paymentSL,reference,pdf_files from store$pcode 
	WHERE paymentSL Like 'EP_%' and todat between '$fdate1' and '$tdate1'";
	$sql.=" group by paymentSL ORDER by paymentSL ASC";

// echo $sql.'<br>';
$sqlq=mysqli_query($db, $sql);
/* PAge */
/*
$total_result=mysqli_affected_rows();
$total_per_page=5;

if($page<=0)
	{
	$page=1;
	}
$curr=($page-1)*$total_per_page;
$sql.=" LIMIT $curr,$total_per_page";
//echo " <br>$sql<br>";
$sqlq=mysqli_query($db, $sql);
*/
while($mr=mysqli_fetch_array($sqlq)){
$data=array();
$tt=1;
$receiveQty=$mr[receiveQty];
$totalAmount_paid=$mr[totalAmount];
$location=$pcode;
$posl=$mr[paymentSL];
$ref=$mr[reference];
$pdf=$mr[pdf_files];
?>
<tr><td colspan="5" height="10"></td></tr>
<tr><td colspan="5" height="2" bgcolor="#0099FF"></td></tr>
<tr bgcolor="#CCE6FF">
 <td colspan="5"> 
 [<a target="_blank" href="./planningDep/printpurchaseOrder1.php?posl=<? echo $mr[paymentSL];?>"><? echo $mr[paymentSL];?></a>]
 <br>PO Amount: <? echo number_format($totalAmount_paid).' dated '.mydate($mr[todat]);
echo myDate($data[$i][0]);
$ii=0;
if(check_posl_approved($posl)){
	$ii++;
	echo " <a href='".get_posl_approved_row($posl)."' target='_blank'>[#$ii PDF]</a> ";
}
?>
	</td> 
</tr>
<? 
if($poType==1 OR $poType==3 OR $poType==4){
if($poType==1){
 if($vid=='99') $sql1="SELECT SUM(ROUND(receiveQty,3)*ROUND(rate,2)) as subAmount,todat,reference,paymentSL from storet$location WHERE
 reference='$posl' GROUP by reference ORDER by reference ASC";
  else $sql1="SELECT SUM(ROUND(receiveQty,3)*ROUND(rate,2)) as subAmount,todat,reference from store$location WHERE paymentSL='$posl' GROUP by reference ORDER by reference ASC";
}
else if($poType==3){
 $sql1="SELECT SUM(ROUND(qty,3)*ROUND(rate,2)) as subAmount,edate as todat from subut WHERE".
" posl='$posl' GROUP by edate ORDER by edate ASC";
}
else if($poType==4){
 $sql1="SELECT SUM(price) as subAmount,edate as todat from equipment WHERE".
" reference LIKE '$posl' GROUP by edate ORDER by edate ASC";
}
//echo $sql1.'<br>'.$poType;
$sqlq1=mysqli_query($db, $sql1);
$i=0;
while($st=mysqli_fetch_array($sqlq1)){

$data[$i][0]=$st[todat];
$data[$i][1]='';
if($vid=='99')$data[$i][2]=$st[paymentSL];
else $data[$i][2]=$st[reference];
if($poType==2){
	$rate=eqpoRate($st[itemCode],$st[posl]);
	$data[$i][3]=$rate;
	$st[subAmount]=$rate;
}
else $data[$i][3]=$st[subAmount];
$data[$i][4]='1';

$totoalAmount=$totoalAmount+$st[subAmount];
$i++;

 }//while
}// if
elseif($poType==2){

    $sql="select edate, posl from eqattendance 
	 WHERE posl ='$posl' and action='P' GROUP by edate,posl order by edate ASC ";
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
$i=0;  
  while($st2=mysqli_fetch_array($sqlQ)){
	$pamount=0;
	$wamount=0;
	$dailyworkBreakt=0;
	$toDaypresent=0;
	$toDaypresent=0;
	$workt=0;
	$rate=0;

	$sql2="select * from eqattendance".
	"  WHERE edate ='$st2[edate]'".
	" AND posl='$st2[posl]' order by eqId ASC ";
	//echo "$sql2<br>";
	$sqlQ2=mysqli_query($db, $sql2);
	while($re=mysqli_fetch_array($sqlQ2)){
		if(isMaintenanceBreakSkipTheDay($posl,$re[eqId],$st2[edate],$re[itemCode]))continue;
		$dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$st2[edate],$re[eqType],$location);
		//$dailyBreakDown=eq_dailyBreakDown($re[eqId],$re[itemCode],$st[edate],$re[eqType],$pcode);
		$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$st2[edate],$re[eqType],$location);
		$toDaypresent=($toDaypresent-$dailyworkBreakt);
		
		$rate=eqpoRate($re[itemCode],$st2[posl])/(8*3600);
	//	echo eqpoRate($re[itemCode],$st2[posl]) ."p:-". $toDaypresent ."break:-". $dailyworkBreakt ."\ ";
		$pamount+=$toDaypresent*$rate;

		//$workt= eq_dailywork($re[eqId],$re[itemCode],$st[edate],$re[eqType],$pcode);	
		//$wamount+=$workt*$rate;		
		//echo "PP=$toDaypresent--$rate<br>";	
	}//while re
$data[$i][0]=$st2[edate];
$data[$i][1]='';
$data[$i][2]='equipment present';
$data[$i][3]=$pamount;
$data[$i][4]='1';

$totoalAmount=$totoalAmount+$pamount;
$i++;
  
  }//while st
   
}//else
?>
<?
$sqlv="select * from vendorpayment WHERE posl='$posl'";

$sqlqv=mysqli_query($db, $sqlv);
$i++;
while($vp=mysqli_fetch_array($sqlqv)){ 
$data[$i][0]=$vp[paymentDate];
$data[$i][1]='';
$data[$i][2]=$vp[paymentSL];
$data[$i][3]=$vp[paidAmount];
$data[$i][4]='2';
$totalPaid+=$vp[paidAmount];
$i++;
 }?>
 
 <? 
// print_r($data);
 
 sort($data);
 //echo "Size of".sizeof($data).'*<br>';
 for($i=0;$i<sizeof($data);$i++){?>
 
<tr <? if($data[$i][4]=='1') echo " bgcolor=#EEEEEE";?>>
 <td><?
echo "<b>".date("d/m/Y",strtotime($data[$i][0]))."</b>";
if(poType($posl)==1){
					$allChalan=getChalanBillDoc($posl,$data[$i][2]);
					foreach($allChalan as $chalanRow){
						if(!$chalanRow[0])continue;
						$ii++;
						$pdf=json_decode($chalanRow[0]);
						echo " <a href='https://win4win.biz/erp/bfew/$pdf[0]' target='_blank'>[#$ii PDF]</a> ";
					}
}
	 ?></td>
 <td><? echo $data[$i][2];?></td>
 <? if($data[$i][4]=='1'){?> <td align="right"><? echo number_format($data[$i][3],2);?></td><td></td><? }?>
 <? if($data[$i][4]=='2'){?> <td></td><td align="right"><? echo number_format($data[$i][3],2);?></td> <? }?>
</tr> 
 
<?  }//for 
	$eqSql="select itemCode,receiveQty,reference,todat,rate,pdf_files from store$pcode where paymentSL='$mr[paymentSL]' group by receiveQty order by todat asc";
	$q=mysqli_query($db,$eqSql);
	while($row_mat=mysqli_fetch_array($q)){
	$row_mat_pdf=json_decode($row_mat[pdf_files]);
	?>
		<tr bgcolor="#FFFFCC">
		 <td colspan="" align="left"><? $ii++; echo date("d/m/Y",strtotime($row_mat[todat])); echo strlen($row_mat_pdf[0])<1 ?:" <a href='https://win4win.biz/erp/bfew$row_mat_pdf[0]' target='_blank'>[#$ii PDF]</a>";?></td>
		 <td colspan="" align="right"><? echo $row_mat[reference];?></td>
		 <td align="right"><? echo number_format($row_mat[receiveQty]*$row_mat[rate],2);?></td>
		</tr>
<?php	}
	
	?>
<tr><td colspan="3" height="2" bgcolor="#0099FF"></td></tr>



<? 
 $gtotoalAmount+=$totoalAmount;
 $totoalAmount=0;
 $gttotalPaid+=$totalPaid;
 $totalPaid=0;
}//while?>

<!-- <tr bgcolor="#DFFFDF">
 <td colspan="" align="right" height="30"><? echo number_format($gtotoalAmount,2);?></td>
 <td align="right" height="30"><? echo number_format($gttotalPaid,2);?></td> 
 <td align="right" height="30"><? echo number_format($gtotoalAmount-$gttotalPaid,2);?></td>  
</tr> -->

</table>
<? }?>


 <?php
/*
        include("./includes/PageNavigation.php");
        if($total_result<=0) $total_result=1;
        if($total_per_page<=0) $total_per_page=1;		
        $totalResults= $total_result;
        $resultsPerPage= $total_per_page;
        $page= $_GET[page];
        $startHTML= "<b>Showing Page {page} of {pages}</b>: Go to Page ";
        $appendSearch= "&pcode=$pcode&vid=$vid";
        $range= 5;
		$rootLink="./index.php?keyword=po+ledger";
        $link_on= "<a href='$rootLink&page={num}{appendSearch}' class='hd'><b>{num}</b></a>";
        $link_off= "<a href='$rootLink&page={num}{appendSearch}'>{num}</a>";
        $back= " <a href='$rootLink&page=1{appendSearch}'><<</a> ";
        $forward= " <a href='$rootLink&page={pages}{appendSearch}'>>></a> ";

        $myNavigation = New PageNavigation($totalResults, $resultsPerPage, $page, $startHTML, $appendSearch, $range, $link_on, $link_off, $back, $forward);

        echo $myNavigation->getHTML();
*/
?>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>