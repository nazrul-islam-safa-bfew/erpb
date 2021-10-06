	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<? 
$dmaQty = array();
$dmasDate =  array();
$dmacDate =  array();
$dateRange = array();
?>
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 25;
		cal.offsetY = -120;
		
	</SCRIPT>
<?
if($sdate and $edate){

$temp= explode('/',$edate);
//$edate =  mktime(0,0,0,$temp[1],$temp[0],$temp[2]);
$edate1 = date("Y-m-d",mktime(0,0,0,$temp[1],$temp[0],$temp[2]));

$temp= explode('/',$sdate);
//$sdate =  mktime(0,0,0,$temp[1],$temp[0],$temp[2]);
$sdate1 = date("Y-m-d",mktime(0,0,0,$temp[1],$temp[0],$temp[2]));
}


include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	$temp=explode("-",$eqid);
	$eq="$temp[0]-$temp[1]-000";
$sql="SELECT * FROM `equipmentreq` WHERE pcode='$loginProject' AND assetId LIKE '$eq' AND `rdate`<= '$sdate1' OR `ddate`>= '$edate1'";
//echo $sql.'<br>';	
$sqlQuery=mysqli_query($db, $sql);
$hand= array();
 $assdate =array();
 $asedate =array(); 
 $work =array(); 
$k=0;
$ar=array ('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
while($eq0=mysqli_fetch_array($sqlQuery)){
 echo "$ar[$k]==>$eq0[assetId]<br>";
 $hand[$k]=$eq0[assetId];
 $assdate[$k] =$eq0[rdate];
 $asedate[$k] =$eq0[ddate]; 
 $work[$k]=eqwork($eq0[assetId]);
 $k++;
}

?>

<table align="center" width="90%" border="2" bordercolor="#000000" cellspacing="0" cellpadding="5" style="border-collapse:collapse" >
<form  name="seq" action="index.php?keyword=site+equipment" method="post">
<tr bgcolor="#FF9933">
 <td>Report Date</td>
 <td>Start Date :  
 <input type="text" maxlength="10" name="sdate" value="<? echo $sdate;?>"> <a id="anchor" href="#"
   onClick="cal.select(document.forms['seq'].sdate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>  
 </td>
 <td>End Date : <input type="text" name="edate" value="<? echo $edate;?>"><a id="anchor1" href="#"
   onClick="cal.select(document.forms['seq'].edate,'anchor1','dd/MM/yyyy'); return false;"
   name="anchor1" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
 
 </td> 
 <td>Equipment ID: <input type="text" name="eqid" value="<? echo $eqid; ?>"> 
 <input type="submit" value="Go"><br></td> 
</tr>
</form>
<tr bgcolor="#EEEEEE">
  <th>Date</th>  
  <th>Qty of Work (HOUR)</th>
  <th>Equipment Hour Available</th>
  <th>Idle Hours</th>
</tr>
<tr bgcolor="#EEEEEE">
  <th></th>  
  <td>
      <table border="1" bordercolor="#FF0000" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
		    <tr>
			<? 
if($sdate and $edate){

$temp= explode('/',$edate);
//$edate =  mktime(0,0,0,$temp[1],$temp[0],$temp[2]);
$edate1 = date("Y-m-d",mktime(0,0,0,$temp[1],$temp[0],$temp[2]));

$temp= explode('/',$sdate);
//$sdate =  mktime(0,0,0,$temp[1],$temp[0],$temp[2]);
$sdate1 = date("Y-m-d",mktime(0,0,0,$temp[1],$temp[0],$temp[2]));
}
	

include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sql="SELECT * FROM `iow` WHERE `iowSdate`<= '$sdate1' OR `iowCdate`>= '$edate1'";
//echo $sql.'<br>';	
$sqlQuery=mysqli_query($db, $sql);
while($eq=mysqli_fetch_array($sqlQuery)){

	$sql1="SELECT * FROM `siow` WHERE iowId=$eq[iowId]  AND (`siowCdate`>= '$sdate1' OR `siowSdate`<= '$edate1')";
	//echo $sql1.'<br>';	
	$sqlQuery1=mysqli_query($db, $sql1);
	while($eq1=mysqli_fetch_array($sqlQuery1)){
	//echo $sql1.'<br>';	
		$sql2="SELECT * FROM `dma` WHERE dmasiow=$eq1[siowId]  AND dmaType=2 AND dmaItemCode LIKE '$eqid'";	
		//echo $sql2.'<br>';	
		$sqlQuery2=mysqli_query($db, $sql2);
		while($eq2=mysqli_fetch_array($sqlQuery2)){
		  echo "<td width='50' align=center>".iowCode($eq2[dmaiow]).'<b><font class=out>'.viewsiowCode($eq2[dmasiow])."</font></b></td>";
		  $dmaQty[] = $eq2[dmaQty];
		  $dmasDate[] = $eq1[siowSdate];
		  $dmacDate[] = $eq1[siowCdate];
		  $dmaQtyDay[] =sprintf("%01.2f",$eq2[dmaQty]/((strtotime($eq1[siowCdate]) -strtotime($eq1[siowSdate]))/(3600*24)));
	       }
	 }
}

?>         <td width="50" bgcolor="FFCCCC" align="center">Total</td> 
			</tr>
	  </table>
  </td>
  <td>
      <table border="1" bordercolor="#00FF00" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
		    <tr>
			  <? for($l=0;$l<=sizeof(hand);$l++) echo '<td width=50 align=center>'.$ar[$l].'</td>';?>
			  	  <td width="50" bgcolor="FFCCCC">Total</td> 
            </tr>
		</table>	    
    </td>
  <th></th>
</tr>



<? 
if($sdate and $edate){
$temp= explode('/',$edate);
$edate =  mktime(0,0,0,$temp[1],$temp[0],$temp[2]);
$edate1 = date("Y-m-d",mktime(0,0,0,$temp[1],$temp[0],$temp[2]));

$temp= explode('/',$sdate);
$sdate =  mktime(0,0,0,$temp[1],$temp[0],$temp[2]);
$sdate1 = date("Y-m-d",mktime(0,0,0,$temp[1],$temp[0],$temp[2]));

$n = $edate - $sdate;
$n = $n/(3600*24);


$date = $sdate;
for($i=0; $i<=$n; $i++)
 { 
 $dateRange[$i] = date("Y-m-d",$date);
  $date += 86400;

 }


for($i=0; $i<=$n; $i++) {?>
<tr>
  <td><? echo mydate($dateRange[$i]);?></td>  
<? 

include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sql="SELECT * FROM `iow` WHERE `iowSdate`<= '$sdate1' AND `iowCdate`>= '$edate1'";
//echo $sql.'<br>';	
$sqlQuery=mysqli_query($db, $sql);
while($eq=mysqli_fetch_array($sqlQuery)){

	$sql1="SELECT * FROM `siow` WHERE siowCode=$eq[iowId]  AND `siowSdate`<= '$sdate1'";
	//echo $sql1.'<br>';	
	$sqlQuery1=mysqli_query($db, $sql1);
	while($eq1=mysqli_fetch_array($sqlQuery1)){
		$sql2="SELECT * FROM `dma` WHERE dmasiow=$eq1[siowId]  AND dmaType=2 AND dmaItemCode LIKE '$eqid'";	
		//echo $sql2.'<br>';	
		$sqlQuery2=mysqli_query($db, $sql2);
		while($eq2=mysqli_fetch_array($sqlQuery2)){
		$qt= $eq2[dmaQty]; //echo 'Eqaaaaaaaaaaaaa::'.$qt.'<br>';
		$sqe = $eq1[siowSdate];
		$eqe = $eq1[siowSdate];
	       }
	 }
}

?>   

  <td>
            <table border="1" bordercolor="#FF9999" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
    <tr>
	  <? $total = 0; 
	   for($j=0; $j < sizeof($dmaQty); $j++) 
	     {
		 $key= strtotime($dateRange[$i]);
		 $s = strtotime($dmasDate[$j]);
		 $e = strtotime($dmacDate[$j]);
          
		 if($key>=$s AND $key<=$e){
		 echo "<td width='50' bgcolor='CCFFCC' align=center>".sec2hms($dmaQtyDay[$j],$padHours=false)."</td>";
	     $total += $dmaQtyDay[$j];
		 }
		 		 else  echo "<td width='50'  align=center> Nil </td>";
		 }// for
	  ?>
	  <td width="50" bgcolor="FFCCCC" align=right><? echo sec2hms($total,$padHours=false);?></td>
	</tr>
  </table>
  
  </td>
    <td>      <table border="1" bordercolor="#00FF00" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
			  <?  $totalHr=0;
			  for($l=0;$l<=sizeof(hand);$l++) {
				$s11= strtotime($assdate[$l]);
				$e11= strtotime($asedate[$l]); 
	
			   if($key>=$s11 AND $key<=$e11){  echo '<td width=50 align=center bgcolor=#CCFFCC>'.$work[$l].'</td>'; $totalHr+=$work[$l]; }
				   else echo "<td width=50  align=center>nil</td>";
				  }//for 
				 echo "<td width=50 align=right bgcolor=#FFCCCC>$totalHr</td>"; 
			   ?>
           
		</table>	    
   </td>
  <td align="center" ><? $idle=$totalHr-$total; if($idle<0) echo '-'; echo sec2hms(abs($idle),$padHours=false);
   if($totalHr){echo '<font class=out> ( '.number_format((($totalHr-$total)/$totalHr)*100);?> %)</font><? }?></td>
</tr>

<? } }?>
</table> 
<a href="./index.php?keyword=site+equipment+req&eqid=<? echo $eqid;?>">Site Equipment Requisition Form</a>

<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>