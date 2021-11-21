<? 
$dmaQty = array();
$dmasDate =  array();
$dmacDate =  array();
$dateRange = array();
?>

<table align="center" width="90%" border="2" bordercolor="#000000" cellspacing="0" cellpadding="5" style="border-collapse:collapse" >
<form  action="index.php?keyword=site+employee" method="post">
<tr bgcolor="#FF9933">
 <td>Report Date</td>
 <td>Start Date : <input type="text" name="sdate" value="<? echo $sdate;?>"></td>
 <td>End Date : <input type="text" name="edate" value="<? echo $edate;?>"></td> 
 <td>Equipment ID: <input type="text" name="eqid" value="<? echo $eqid; ?>"> 
 <input type="submit" value="Go"><br></td> 
</tr>
</form>
<tr bgcolor="#EEEEEE">
  <th>Date</th>  
  <th>Employee Hour Available</th>
  <th>Qty of Work (HOUR)</th>
  <th>Employee Booked</th>
</tr>
<tr bgcolor="#EEEEEE">
  <th></th>  
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
	
$sql="SELECT * FROM `iow` WHERE `iowSdate`<= '$sdate1' AND `iowCdate`>= '$edate1' AND iowProjectCode=$loginProject";
//echo $sql.'<br>';	
$sqlQuery=mysqli_query($db, $sql);
while($eq=mysqli_fetch_array($sqlQuery)){

	//$sql1="SELECT * FROM `siow` WHERE siowCode=$eq[iowId]  AND (`siowCdate`>= '$sdate1' AND `siowSdate`<= '$edate1')";
	$sql1="SELECT * FROM `siow` WHERE siowCode=$eq[iowId] ";
	//echo $sql1.'<br>';	
	$sqlQuery1=mysqli_query($db, $sql1);
	while($eq1=mysqli_fetch_array($sqlQuery1)){
		$sql2="SELECT * FROM `dma` WHERE dmasiow=$eq1[siowId]  AND dmaType=3 AND dmaItemCode LIKE '$eqid'";	
		//echo $sql2.'<br>';	
		$sqlQuery2=mysqli_query($db, $sql2);
		while($eq2=mysqli_fetch_array($sqlQuery2)){
		//$qt= $eq2[dmaQty]; //echo 'Eqaaaaaaaaaaaaa::'.$qt.'<br>';
		//$sqe = $eq1[siowSdate];
		//$eqe = $eq1[siowSdate];
		  echo "<td width='50'>$eq2[dmaiow].$eq2[dmasiow]</td>";
		  $dmaQty[] = $eq2[dmaQty];
		  $dmasDate[] = $eq1[siowSdate];
		  $dmacDate[] = $eq1[siowCdate];
		  $dmaQtyDay[] =sprintf("%01.2f",$eq2[dmaQty]/((strtotime($eq1[siowCdate]) -strtotime($eq1[siowSdate]))/(3600*24)));
//		  sprintf("%01.2f", $money);

	       }
	 }
}

?>         <td width="50" bgcolor="FFCCCC">Total</td> 
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
  <td><? echo $dateRange[$i];?></td>  
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
  <td><? 
 // $ss = date("Y-m-d",mktime(0,0,0,$temp[1],$temp[0]+$i,$temp[2]));
  //echo "$sqe >=  $ss OR $eqe <= $ss";
  //if($sqe >=  $ss OR $eqe <= $ss )
  //echo $qt;?></td>
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
		 echo "<td width='50' bgcolor='CCFFCC'>$dmaQtyDay[$j]</td>";
	     $total += $dmaQtyDay[$j];
		 }
		 		 else  echo "<td width='50'> NO </td>";
		 }// for
	  ?>
	  <td width="50" bgcolor="FFCCCC"><? echo $total;?></td>
	</tr>
  </table>
  
  </td>
  <td ></td>
</tr>

<? } }?>
</table> 
<a href="./index.php?keyword=site+employee+req&eqid=<? echo $eqid;?>">Site Employee Requisition Form</a>
