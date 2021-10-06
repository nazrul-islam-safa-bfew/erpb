<?

function get_daily_iow_progress($ed1,$project){
	global $db;
	$ed2=date("Y-m-d",strtotime(date("Y-m-d"))-86400);
	$sql="select sum(actual_progress) actual_progress, sum(planned_progress) planned_progress from daily_iow_progress where edate='$ed2' and project='$project'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	
	$sql1="select sum(actual_progress) actual_progress, sum(planned_progress) planned_progress from daily_iow_progress where edate='$ed1' and project='$project'";
	$q1=mysqli_query($db,$sql1);
	$row1=mysqli_fetch_array($q1);
	return array(abs($row1[actual_progress]-$row[actual_progress]),abs($row1[planned_progress]-$row[planned_progress]));
}

function iowCounter($project,$Status,$extra=null){
	global $db;
	$today=todat();
	$sqlp = "SELECT count(*) as result from `iow` WHERE iowProjectCode='$project' ";

	if($Status=='completed'){$sqlp.=" AND (iowStatus ='Completed') ";}
	if($Status=='Not-Started')$sqlp.=" AND iowStatus != 'Completed' and iowSdate>'$today' ";
	elseif($Status=='Started')$sqlp.=" AND ((iowStatus != 'Completed' and iowSdate<='$today' )) ";
	$sqlp.=" and iowStatus != 'noStatus' $extra ";
// 	echo $sqlp;
	$q=mysqli_query($db,$sqlp);
	$a= mysqli_fetch_array($q);
	return $a[result];
}

// generate newAssetID
// depend upon project of last equipment id
// new assetID "R" for rent "N" for equipment purchase
function newAssetID_EQP($itemCode,$type="R",$loginProject){
	global $db;
	$sql_equipment="select assetID from equipment where location='$loginProject' and itemCode='$itemCode' ";
	if($type=="N")$sql_equipment.=" and assetID not like '%R' ";
	elseif($type=="R") $sql_equipment.=" and assetID like '%R' ";
	$sql_equipment.=" order by assetID desc limit 1";
	$sql_query=mysqli_query($db,$sql_equipment);
	$sql_equipment_row=mysqli_fetch_array($sql_query);
	$last_assetID=$sql_equipment_row["assetID"];
	$last_assetID=intval($last_assetID);
	$new_assetID=$last_assetID+1; //new asset ID generated
// 	print_r($last_assetID);
	$newAssetIDLength=count($new_assetID);
	while($newAssetIDLength++<3){
		$new_assetID="0".$new_assetID;
	}	
	if($type=="R")$new_assetID.="R";
	return $new_assetID;
}

// generate newAssetID
// depend upon project of last equipment id
// new assetID "R" for rent "N" for equipment purchase
function newAssetID($itemCode,$type="R",$loginProject){
	global $db;
	if($type=="N")$sql_equipment="select assetID from equipment where itemCode='$itemCode'  and assetID not like '%R'  order by eqid desc limit 1";
	elseif($type=="R") $sql_equipment="select assetID from eqproject where pCode='$loginProject' and itemCode='$itemCode' and assetID like '%R' order by id desc limit 1";
// 	echo $sql_equipment;
	$sql_query=mysqli_query($db,$sql_equipment);
	$sql_equipment_row=mysqli_fetch_array($sql_query);
	$last_assetID=$sql_equipment_row["assetID"];
	$last_assetID=str_replace("R","",$last_assetID);
	$last_assetID=intval($last_assetID);
	$new_assetID=$last_assetID+1; //new asset ID generated
	$newAssetIDLength=strlen($new_assetID);
	while($newAssetIDLength++<3){
		$new_assetID="0".$new_assetID;
	}
	if($type=="R")$new_assetID.="R";
	return $new_assetID;
}

function get_MRsl($project){
	global $db;
$sql="SELECT reference from store$project ORDER by reference DESC";
//echo $sql.'<br>';
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
$sl=explode('_',$sqlr[reference]);
$slr=1+$sl[2];
$mrsl=generate_MRsl($slr,$project);
return $mrsl;
}?>

<? 

/*
return material receive(MR) serial number for given project
*/

function generate_MRsl($id,$p){
if($id<10) $sl="0000000$id";
else if($id<100) $sl="000000$id";
else if($id<1000) $sl="00000$id";
else if($id<10000) $sl="0000$id";
else if($id<100000) $sl="000$id";
else if($id<1000000) $sl="00$id";
else if($id<10000000) $sl="0$id";
else $sl=$id;
return "MR_".$p."_".$sl;
}
?>
<? 
/*
return material issue serial number for given project
*/

function generate_ISsl($id,$p){
if($id<10) $sl="0000000$id";
else if($id<100) $sl="000000$id";
else if($id<1000) $sl="00000$id";
else if($id<10000) $sl="0000$id";
else if($id<100000) $sl="000$id";
else if($id<1000000) $sl="00$id";
else if($id<10000000) $sl="0$id";
else $sl=$id;
return "IS_".$p."_".$sl;
}
?>
<?
/* return TRUE if dates is in between siowSdate AND siowCdate*/
function isValidDate($siowSdate,$siowCdate,$dates){
if((strtotime($siowSdate)<=strtotime($dates)) AND (strtotime($siowCdate)>=strtotime($dates)))
return 1;
else return 0;
}?>

<? 
/* return TRUE if siow complete date is lase then given date*/
function isExpiredSIOW($siow,$ed){
global $db;
$sql="SELECT siowCdate from siow where siowId=$siow";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);

 $siowCdate = $rr[siowCdate];
// echo "<br>++$siowCdate=$ed+++<br>";
 if(strtotime($siowCdate)<strtotime($ed))
  return 1; 
  else return 0;
}
?>


<?
/* return  total emergency purchase qty in given date , itemcode, project*/
 function epPurchaseQty($itemCode,$d,$p){
	global $db;
 $sql="SELECT SUM(receiveQty) as totalQty FROM `store$p` WHERE (paymentSL  LIKE 'cash_%' or paymentSL  LIKE 'ep_%') and itemCode='$itemCode' AND todat='$d'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
if(mysqli_affected_rows($db)<=0)return false;
 $rr=mysqli_fetch_array($sqlQuery);
 $totalQty = $rr[totalQty];
  return $totalQty; 
}
?>


<? 
/* return total emergency purchabe qty*/
function epPurchasableQty($itemCode,$d,$p){
 global $db;
 $sql="SELECT SUM(receiveQty) as totalQty FROM `store$p` WHERE paymentSL  LIKE 'EP_%' AND itemCode='$itemCode' AND todat<'$d'";
// echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalQty=$rr[totalQty]; 
 $sql="SELECT SUM(qty) as eptotalQty FROM `porder` WHERE posl LIKE 'EP_$p_%' AND itemCode='$itemCode' AND dat<='$d'";
// echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $eptotalQty=$rr[eptotalQty]; 
 $epPurchasableQty=$eptotalQty-$totalQty; 
 return $epPurchasableQty; 
}
?>

<? 
/* return iow progress variance*/
function iow_progerss_variance($id,$d){
	global $db;
 $sql="SELECT des FROM `iowdaily` WHERE iowId=$id AND edate='$d'";
// echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $des = $rr[des];
  return $des;
}
?>
<? 
/* return iow progress variance before provided date*/
function iow_progerss_variance_before($id,$d){
 global $db;
 $sql="SELECT des,edate FROM `iowdaily` WHERE iowId=$id AND edate<'$d' and des!='' order by edate desc limit 1";
// echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $des = array($rr[des],$rr[edate]);
 return $des;
}
?>
<? 
/* return iow supervisor in give date */
function iow_progerss_supervisor($id,$d){
	global $db;
 $sql="SELECT supervisor FROM `iowdaily` WHERE iowId=$id AND edate='$d'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $des = supervisorDetails($rr[supervisor]);
  return $des;
}
?>


<? 
/* return iow progress changeOrder*/
function iow_progerss_changeOrder($id,$d,$type="co",$closed=0){ //closed=0 means open
 global $db;
 $sql="SELECT text,edate FROM `change_order` WHERE iowId=$id AND edate='$d'";
// echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $clientdes = $rr[text];
 return $clientdes;
}
?>

<? 
/* return iow progress changeOrder*/
function iow_progerss_changeOrder_before($id,$d){
 global $db;
 $sql="SELECT text,edate FROM `change_order` WHERE iowId=$id AND edate<'$d' order by edate desc limit 1";
// echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $clientdes = array($rr[text],$rr[edate]);
 return $clientdes;
}
?>

<? 
/* return iow progress Description*/
function iow_progerss_Description($id,$d){
	global $db;
 $sql="SELECT des FROM `iowdaily` WHERE iowId=$id AND edate='$d'";
// echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $des = $rr[des];
  return $des; 
}
?>
<?
/*---------------------------------
OUTPUT: 
---------------------------------*/
function iowTargetProgress($d,$id,$p){
$worked=0;
$d=formatDate($d,'Y-m-j');
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	 

 $sql="SELECT SUM(qty) as total FROM `iowdaily` WHERE iowId=$id AND edate<='$d'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $worked = $rr[total];
 
  $sql1="SELECT iowQty,iowUnit,(to_days(iowCdate)-to_days(iowSdate))+1 as duration, (to_days('$d')-to_days(iowSdate)) as pass".
  ", (to_days(iowCdate)-to_days('$d')) as remain FROM `iow` WHERE iowId=$id";
 
//echo $sql1;
 $sqlQuery1=mysqli_query($db, $sql1);
 $rr1=mysqli_fetch_array($sqlQuery1);
 if($rr1[pass]>0 AND $rr1[remain]>0){
	 if($rr1[iowUnit]=='L.S' OR $rr1[iowUnit]=='LS' OR $rr1[iowUnit]=='l.s' OR $rr1[iowUnit]=='l.s') 
	{
	 $actqty= 100;
	 $unit='';
	} 
	else {	
		 $actqty= $rr1[iowQty];
		 $unit=$rr1[iowUnit];
		 }
      $esperday=$actqty/$rr1[duration]; //per day have to work
	  $estotal=$esperday*$rr1[pass]; // already have to work
	  $esremain=$estotal-$worked; //

	 /*$remainQty=$actqty-$worked;
	 //$perday=$remainQty/$rr1[remain];
	 //$perday=$perday*$rr1[pass];
	 $perday1=$remainQty/$rr1[duration];
	 $perday=$perday1*$rr1[pass]+$perday1;
	 */
	 if($esremain>0) $perday=$esremain;
	  else $perday=0;
	 //echo "<br>$actqty-$worked-$rr1[remain]-$perday<br>";
	 if($unit)$perday  =number_format($perday,2);
	      else $perday  =number_format($perday,2).'%';

      return $perday." <font class=out>$unit</font>";

}//if
else if($rr1[pass]<0){
   return 0;
}

else if($rr1[remain]<0){
	 if($rr1[iowUnit]=='L.S' OR $rr1[iowUnit]=='LS' OR $rr1[iowUnit]=='l.s' OR $rr1[iowUnit]=='l.s') 
	{
	 $actqty= 100;
	 $unit='';
	} 
	else {	
		 $actqty=$rr1[iowQty];
		 $unit=$rr1[iowUnit];		 
		 	}
	 $remainQty=$actqty-$worked;
	 if($unit)$perday  =number_format($remainQty,2);
	      else $perday  =$remainQty.'%';
      return $perday." <font class=out>$unit</font>";

}

//  echo "$worked  <font class=out>$rr1[iowUnit]</font> ($pworked%)";
  
// if($p) printiowTargetProgress($rr1[iowUnit],$worked,$pworked);
  
//return  0;
}


function printiowTargetProgress($unit,$worked,$qt)
{
echo "
<table width=100% cellpadding=5 cellspacing=0 >
<tr>
 <td width=70% align=right> $worked <font class=out>$unit</font></td>
 <td width=30% align=right> ($qt%)</td> 
</tr>
</table>
";	 

}
?>

<?
/*---------------------------------
OUTPUT: 
---------------------------------*/
function siowTargetProgress($d,$id,$p){
$worked=0;
$d=formatDate($d,'Y-m-j');
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	 

 $sql="SELECT SUM(qty) as total FROM `siowdaily` WHERE siowId=$id AND edate<='$d'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $worked = $rr[total];
 
  $sql1="SELECT siowQty,siowUnit,(to_days(siowCdate)-to_days(siowSdate))+1 as duration, (to_days('$d')-to_days(siowSdate)) as pass".
  ", (to_days(siowCdate)-to_days('$d')) as remain FROM `siow` WHERE siowId=$id";
 
//echo $sql1;
 $sqlQuery1=mysqli_query($db, $sql1);
 $rr1=mysqli_fetch_array($sqlQuery1);
 

 if($rr1[pass]>0 AND $rr1[remain]>0){
	 if($rr1[siowUnit]=='L.S' OR $rr1[siowUnit]=='LS' OR $rr1[siowUnit]=='l.s' OR $rr1[siowUnit]=='l.s') 
	{
	 $actqty= 100;
	 $unit='';
	} 
	else {	
		 $actqty= $rr1[siowQty];
 	     $unit=$rr1[siowUnit];	
		 	 }
    $esperday=$actqty/$rr1[duration];
	  $estotal=$esperday*$rr1[pass];
	  $esremain=$estotal-$worked;
	/* $remainQty=$actqty-$worked;
	// $perday  = $remainQty/$rr1[remain];
	 
	 $perday1=$remainQty/$rr1[duration];
	 $perday=$perday1*$rr1[pass]+$perday1;
*/
//echo "$esperday--$estotal--$esremain";
	 if($esremain>0) $perday=$esremain;
	  else $perday=0;

	  if($unit=='')	 $perday  =number_format($perday,2).'%';
		  else 	 $perday =number_format($perday,2);

      return $perday." <font class=out>$unit</font>";

}//if
else if($rr1[pass]<0){
   return "0 <font class=out>$rr1[siowUnit]</font>";
}

else if($rr1[remain]<0){
	 if($rr1[siowUnit]=='L.S' OR $rr1[siowUnit]=='LS' OR $rr1[siowUnit]=='l.s' OR $rr1[siowUnit]=='l.s') 
	{
	 $actqty= 100;
	 $unit='';
	} 
	else {	
		 $actqty=$rr1[siowQty];
	     $unit=$rr1[siowUnit];		 
		 	}
	 $remainQty=$actqty-$worked;
  if($unit=='')	 $perday  =$remainQty.'%';
	  else 	 $perday  =$remainQty;

      return $perday." <font class=out>$unit</font>";

}

//  echo "$worked  <font class=out>$rr1[iowUnit]</font> ($pworked%)";
  
// if($p) printiowTargetProgress($rr1[iowUnit],$worked,$pworked);
  
//return  0;
}


function printsiowTargetProgress($unit,$worked,$qt)
{
echo "
<table width=100% cellpadding=5 cellspacing=0 >
<tr>
 <td width=70% align=right> $worked <font class=out>$unit</font></td>
 <td width=30% align=right> ($qt%)</td> 
</tr>
</table>
";	 

}
?>


<? 
/* return estimate total issue amount of given period in a siow of one item*/
function estimated_issue_s_to_e($s,$e,$item,$siow){
	global $db;
$sql = "SELECT (to_days(siowCdate)-to_days(siowSdate)) as duration,".
	"(dmaQty/(to_days(siowCdate)-to_days(siowSdate))) as perday,dmaQty from siow,dma ".
	" WHERE siowId=$siow".
	" AND dmasiow=$siow AND dmaItemCode LIKE '$item'";
//echo $sql;
$sqlruns= mysqli_query($db, $sql);
$siow=mysqli_fetch_array($sqlruns);
$perday=$siow[perday];
$estimatedtotalIssue=$perday*$duration;
return $estimatedtotalIssue;
}
?>


<?
function eqdailyReceive($d,$item,$p,$posl){
	global $db;
 $sql="SELECT COUNT(*) as totalReceive From eqproject where itemCode LIKE '$item'".
" AND (('$d' BETWEEN sdate AND edate) OR (sdate<='$d' AND edate='0000-00-00'))AND posl='$posl'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalReceive=$rr[totalReceive];
 return $totalReceive;

}

?>

<? 
function estimated_Receive_s_to_e($s,$e,$posl,$itemCode){
	global $db;
 $sql="SELECT SUM(qty) as totalReceive 
 From poschedule 
 where posl='$posl' 
 AND itemCode='$itemCode' AND sdate BETWEEN '$s' AND '$e'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalReceive=$rr[totalReceive];
 return $totalReceive;
}
?>

<? 
function eqestimated_Receive_s_to_e($s,$e,$poid){
	global $db;
$sql="SELECT qty From porder where poid='$poid' AND dstart BETWEEN '$s' AND '$e'"; 
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalReceive=$rr[qty];
 // echo "---estotalReceive: $totalReceive--";
 return $totalReceive;

}
?>

<? 
function actual_Receive_s_to_e($s,$e,$item,$p,$posl){
//$d=formatDate($d,'Y-m-d');
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	 

 $sql="SELECT SUM(receiveQty) as totalReceive
  From store$p where itemCode='$item' 
  AND todat BETWEEN '$s' AND '$e' 
  AND paymentSL='$posl'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalReceive=$rr[totalReceive];

 return $totalReceive;

}

?>

<? 
function eqactual_Receive_s_to_e($s,$e,$item,$p,$posl){
//$d=formatDate($d,'Y-m-d');
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	 

  $sql="SELECT COUNT(*) as totalReceive From eqproject where itemCode ='$item' AND sdate BETWEEN '$s' AND '$e' AND posl='$posl'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalReceive=$rr[totalReceive];
// echo "---totalReceive: $totalReceive--";
 return $totalReceive;

}

?>


<? 
function workshop_stock_athand($item){
	global $db;
//$d=formatDate($d,'Y-m-d');
$sendQty=0;
 $sql="SELECT SUM(qty) as total FROM `iowdaily`,`iow` WHERE itemCode='$item' AND iow.iowId=iowdaily.iowId";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalQty=$rr[total];
 //echo $totalQty;
$sqlp = "SELECT  posl from `porder` WHERE posl LIKE 'PO_%_114' AND itemCode='$item' AND status <> 0";
//echo $sqlp.'<br>';
$sqlrunp12= mysqli_query($db, $sqlp);
while($as=mysqli_fetch_array($sqlrunp12)){
$p=explode('_',$as[posl]);
$project=$p[1];

$sqls="SELECT SUM(receiveQty) as totalqty From storet$project where itemCode='$item' AND paymentSL='$as[posl]'";
//echo $sqls.' aa<br>';
$sqlqs=mysqli_query($db, $sqls);
$sqlf=mysqli_fetch_array($sqlqs);
$sendQty=$sendQty+$sqlf[totalqty];

}//while

$remainQty=$totalQty-$sendQty;
  
return $remainQty;
}
?>

<? 
function subnext10daysReq($sd,$ed,$itemCode,$project){
	global $db;
$todat=todat();
putenv ('TZ=Asia/Dacca'); 
for($j=0,$i=-7;$j<30;$i++,$j++){
$padd = time()+(86400*$i);
$dates[$j]=date('Y-m-d', $padd);
}//for


$sql1="SELECT * from iow where iowProjectCode='$project'".
        "   AND (('$dates[0]' BETWEEN iowSdate AND iowCdate) OR ('$dates[29]' BETWEEN iowSdate AND iowCdate))". 
		"	AND  iowStatus IN ('Approved by Mngr P&C','Approved by MD')";
$sqlq11=mysqli_query($db, $sql1);
$r=1;
while($iow=mysqli_fetch_array($sqlq11)){
//echo $r;
$siows=array();
$siowsid=array();	

$sqls00 = "SELECT siow.siowId,siow.siowCode,siow.siowName,siow.siowSdate,siow.siowCdate,dma.dmaQty,iow.iowCode from siow,dma,iow WHERE ".
        "   ((siow.siowSdate BETWEEN '$dates[0]' AND '$dates[29]') OR (siow.siowCdate BETWEEN '$dates[0]' AND '$dates[29]') OR". 
        "   ('$dates[0]' BETWEEN siow.siowSdate AND siow.siowCdate) OR ('$dates[29]' BETWEEN siow.siowSdate AND siow.siowCdate)) AND ". 
 		" iow.iowId='$iow[iowId]' AND siow.iowId='$iow[iowId]' AND dmaItemCode='$itemCode' AND siow.iowId=dma.dmaiow AND siow.siowId=dma.dmasiow";

//echo $sqls00.'<br>';

 $sqlruns= mysqli_query($db, $sqls00);
 $i=0;
 while($siow=mysqli_fetch_array($sqlruns)){
 $siows[$i]="$siow[iowCode].$siow[siowCode]. ($siow[siowName])";
 $siowsid[$i]=$siow[siowId]; 
 $siowsd[$i]=$siow[siowSdate];  
 $siowcd[$i]=$siow[siowCdate];   
 $dmaQty[$i]=$siow[dmaQty];     
 $i++;}

for($j=0;$j<sizeof($siows);$j++){
$sub_perdayRequired=sub_perdayRequired($siowsid[$j],$itemCode,$dates[7],$project);
		for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
		$dailyIssue=subWork_dailyIssued($itemCode,$siowsid[$j],$dates[$i]);
		$totalQty[$i]+=$dailyIssue;

		}
		else {
		     if(isValidDate($siowsd[$j],$siowcd[$j],$dates[$i]))
             {$totalQty[$i]+=$sub_perdayRequired; }
		 }//if i<7	
		}//siows

}//dates

$r++;}//iow


$sqlpo1="SELECT * from porder where posl LIKE 'PO_".$project."_%' AND itemCode='$itemCode' AND status=1";// AND dstart BETWEEN '$dates[0]' AND '$dates[29]'";
//echo $sqlpo1;
$sqlqpo1=mysqli_query($db, $sqlpo1);
while($po1=mysqli_fetch_array($sqlqpo1)){


 $tt= explode('_',$po1[posl]);
 $temp = vendorName($tt[3]);

 
for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
			$dailyReceive=subWork_dailyPo($itemCode,$po1[posl],$dates[$i]);
		  $pototalQty[$i]+=$dailyReceive;
					
		}
         else { 
				$sqlpo="SELECT * from poschedule where posl = '$po1[posl]' AND itemCode='$itemCode' AND sdate='$dates[$i]'";
				//echo $sqlpo;
				$sqlqpo=mysqli_query($db, $sqlpo);
				$po=mysqli_fetch_array($sqlqpo);
				$pototalQty[$i]+=$po[qty];


		}//else

}//for


}//while
for($i=0;$i<8;$i++){
	if($i<7){
		$epPurchaseQty=epPurchaseQty($itemCode,$dates[$i],$project);
		$pototalQty[$i]=$pototalQty[$i]+$epPurchaseQty;
		//echo "<td align=right>".number_format($epPurchaseQty,3)."</td>";
	}
	else if($i==7){
		//echo "<td width='1px'  bgcolor=#FF3333></td>";
		$epPurchaseQty =epPurchasableQty($itemCode,$dates[$i],$project);
		$pototalQty[$i]=$pototalQty[$i]+$epPurchaseQty;
		//echo "<td align=right>".number_format($epPurchaseQty,3)."</td>";
	}

}
$remainTotal = $pototalQty[0]-$totalQty[0];

				$sqlpor="SELECT SUM(receiveQty-currentQty) as  remainQty from store$project where todat < '$dates[0]'";
				//echo $sqlpor;
				$sqlqpor=mysqli_query($db, $sqlpor);
				$por=mysqli_fetch_array($sqlqpor);
                $remainTotal+= $por[remainQty];
$remainTotal=0;
for($i=1;$i<17;$i++){
$remainTotal = ($remainTotal+$pototalQty[$i])-$totalQty[$i];
//echo "<br>($remainTotal+$pototalQty[$i])-$totalQty[$i]--<br>";
//if($i==18) echo abs($remainTotal);
}
//echo "<br>**remainTotal:$remainTotal**<br>";
if($remainTotal<0)
return abs($remainTotal);
else return 0;
}
?>


<? 
function subnextXdaysReq($sd,$ed,$itemCode,$project,$days){
	global $db;
$todat=todat();
putenv ('TZ=Asia/Dacca'); 
for($j=0,$i=-7;$j<30;$i++,$j++){
$padd = time()+(86400*$i);
$dates[$j]=date('Y-m-d', $padd);
}//for


$sql1="SELECT * from iow where iowProjectCode='$project'".
        "   AND (('$dates[0]' BETWEEN iowSdate AND iowCdate) OR ('$dates[29]' BETWEEN iowSdate AND iowCdate))". 
		"	AND  iowStatus IN ('Approved by Mngr P&C','Approved by MD')";
$sqlq11=mysqli_query($db, $sql1);
$r=1;
while($iow=mysqli_fetch_array($sqlq11)){
//echo $r;
$siows=array();
$siowsid=array();	

$sqls00 = "SELECT siow.siowId,siow.siowCode,siow.siowName,siow.siowSdate,siow.siowCdate,dma.dmaQty,iow.iowCode from siow,dma,iow WHERE ".
        "   ((siow.siowSdate BETWEEN '$dates[0]' AND '$dates[29]') OR (siow.siowCdate BETWEEN '$dates[0]' AND '$dates[29]') OR". 
        "   ('$dates[0]' BETWEEN siow.siowSdate AND siow.siowCdate) OR ('$dates[29]' BETWEEN siow.siowSdate AND siow.siowCdate)) AND ". 
 		" iow.iowId='$iow[iowId]' AND siow.iowId='$iow[iowId]' AND dmaItemCode='$itemCode' AND siow.iowId=dma.dmaiow AND siow.siowId=dma.dmasiow";

//echo $sqls00.'<br>';

 $sqlruns= mysqli_query($db, $sqls00);
 $i=0;
 while($siow=mysqli_fetch_array($sqlruns)){
 $siows[$i]="$siow[iowCode].$siow[siowCode]. ($siow[siowName])";
 $siowsid[$i]=$siow[siowId]; 
 $siowsd[$i]=$siow[siowSdate];  
 $siowcd[$i]=$siow[siowCdate];   
 $dmaQty[$i]=$siow[dmaQty];     
 $i++;}

for($j=0;$j<sizeof($siows);$j++){
$sub_perdayRequired=sub_perdayRequired($siowsid[$j],$itemCode,$dates[7],$project);
		for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
		$dailyIssue=subWork_dailyIssued($itemCode,$siowsid[$j],$dates[$i]);
		$totalQty[$i]+=$dailyIssue;

		}
		else {
		     if(isValidDate($siowsd[$j],$siowcd[$j],$dates[$i]))
             {$totalQty[$i]+=$sub_perdayRequired; }
		 }//if i<7	
		}//siows

}//dates

$r++;}//iow


$sqlpo1="SELECT * from porder where posl LIKE 'PO_".$project."_%' AND itemCode='$itemCode' AND status=1";// AND dstart BETWEEN '$dates[0]' AND '$dates[29]'";
//echo $sqlpo1;
$sqlqpo1=mysqli_query($db, $sqlpo1);
while($po1=mysqli_fetch_array($sqlqpo1)){


 $tt= explode('_',$po1[posl]);
 $temp = vendorName($tt[3]);

 
for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
			$dailyReceive=subWork_dailyPo($itemCode,$po1[posl],$dates[$i]);
		  $pototalQty[$i]+=$dailyReceive;
					
		}
         else { 
				$sqlpo="SELECT * from poschedule where posl = '$po1[posl]' AND itemCode='$itemCode' AND sdate='$dates[$i]'";
				//echo $sqlpo;
				$sqlqpo=mysqli_query($db, $sqlpo);
				$po=mysqli_fetch_array($sqlqpo);
				$pototalQty[$i]+=$po[qty];


		}//else

}//for


}//while
for($i=0;$i<8;$i++){
	if($i<7){
		$epPurchaseQty=epPurchaseQty($itemCode,$dates[$i],$project);
		$pototalQty[$i]=$pototalQty[$i]+$epPurchaseQty;
		//echo "<td align=right>".number_format($epPurchaseQty,3)."</td>";
	}
	else if($i==7){
		//echo "<td width='1px'  bgcolor=#FF3333></td>";
		$epPurchaseQty =epPurchasableQty($itemCode,$dates[$i],$project);
		$pototalQty[$i]=$pototalQty[$i]+$epPurchaseQty;
		//echo "<td align=right>".number_format($epPurchaseQty,3)."</td>";
	}

}
$remainTotal = $pototalQty[0]-$totalQty[0];

				$sqlpor="SELECT SUM(receiveQty-currentQty) as  remainQty from store$project where todat < '$dates[0]'";
				//echo $sqlpor;
				$sqlqpor=mysqli_query($db, $sqlpor);
				$por=mysqli_fetch_array($sqlqpor);
                $remainTotal+= $por[remainQty];
$remainTotal=0;
for($i=1;$i<$days+7;$i++){
$remainTotal = ($remainTotal+$pototalQty[$i])-$totalQty[$i];
//echo "<br>($remainTotal+$pototalQty[$i])-$totalQty[$i]--<br>";
//if($i==18) echo abs($remainTotal);
}
//echo "<br>**remainTotal:$remainTotal**<br>";
if($remainTotal<0)
return abs($remainTotal);
else return 0;
}
?>


<? 
function subnextXdaysReq1($sd,$ed,$itemCode,$project,$days){
	global $db;
$todat=todat();
putenv ('TZ=Asia/Dacca'); 
for($j=0,$i=-7;$j<$days;$i++,$j++){
$padd = time()+(86400*$i);
$dates[$j]=date('Y-m-d', $padd);
}//for


$sql1="SELECT * from iow where iowProjectCode='$project'".
        "   AND (('$dates[0]' BETWEEN iowSdate AND iowCdate) OR ('$dates[$days]' BETWEEN iowSdate AND iowCdate))". 
		"	AND  iowStatus IN ('Approved by Mngr P&C','Approved by MD')";
$sqlq11=mysqli_query($db, $sql1);
$r=1;
while($iow=mysqli_fetch_array($sqlq11)){
//echo $r;
$siows=array();
$siowsid=array();	

$sqls00 = "SELECT siow.siowId,siow.siowCode,siow.siowName,siow.siowSdate,siow.siowCdate,dma.dmaQty,iow.iowCode from siow,dma,iow WHERE ".
        "   ((siow.siowSdate BETWEEN '$dates[0]' AND '$dates[$days]') OR (siow.siowCdate BETWEEN '$dates[0]' AND '$dates[$days]') OR". 
        "   ('$dates[0]' BETWEEN siow.siowSdate AND siow.siowCdate) OR ('$dates[$days]' BETWEEN siow.siowSdate AND siow.siowCdate)) AND ". 
 		" iow.iowId='$iow[iowId]' AND siow.iowId='$iow[iowId]' AND dmaItemCode='$itemCode' AND siow.iowId=dma.dmaiow AND siow.siowId=dma.dmasiow";

//echo $sqls00.'<br>';

 $sqlruns= mysqli_query($db, $sqls00);
 $i=0;
 while($siow=mysqli_fetch_array($sqlruns)){
 $siows[$i]="$siow[iowCode].$siow[siowCode]. ($siow[siowName])";
 $siowsid[$i]=$siow[siowId]; 
 $siowsd[$i]=$siow[siowSdate];  
 $siowcd[$i]=$siow[siowCdate];   
 $dmaQty[$i]=$siow[dmaQty];     
 $i++;}

for($j=0;$j<sizeof($siows);$j++){
$sub_perdayRequired=sub_perdayRequired($siowsid[$j],$itemCode,$dates[7],$project);
		for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
		$dailyIssue=subWork_dailyIssued($itemCode,$siowsid[$j],$dates[$i]);
		$totalQty[$i]+=$dailyIssue;

		}
		else {
		     if(isValidDate($siowsd[$j],$siowcd[$j],$dates[$i]))
             {$totalQty[$i]+=$sub_perdayRequired; }
		 }//if i<7	
		}//siows

}//dates

$r++;}//iow


$sqlpo1="SELECT * from porder where posl LIKE 'PO_".$project."_%' AND itemCode='$itemCode' AND status=1";// AND dstart BETWEEN '$dates[0]' AND '$dates[29]'";
//echo $sqlpo1;
$sqlqpo1=mysqli_query($db, $sqlpo1);
while($po1=mysqli_fetch_array($sqlqpo1)){


 $tt= explode('_',$po1[posl]);
 $temp = vendorName($tt[3]);

 
for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
			$dailyReceive=subWork_dailyPo($itemCode,$po1[posl],$dates[$i]);
		  $pototalQty[$i]+=$dailyReceive;
					
		}
         else { 
				$sqlpo="SELECT * from poschedule where posl = '$po1[posl]' AND itemCode='$itemCode' AND sdate='$dates[$i]'";
				//echo $sqlpo;
				$sqlqpo=mysqli_query($db, $sqlpo);
				$po=mysqli_fetch_array($sqlqpo);
				$pototalQty[$i]+=$po[qty];


		}//else

}//for


}//while
for($i=0;$i<8;$i++){
	if($i<7){
		$epPurchaseQty=epPurchaseQty($itemCode,$dates[$i],$project);
		$pototalQty[$i]=$pototalQty[$i]+$epPurchaseQty;
		//echo "<td align=right>".number_format($epPurchaseQty,3)."</td>";
	}
	else if($i==7){
		//echo "<td width='1px'  bgcolor=#FF3333></td>";
		$epPurchaseQty =epPurchasableQty($itemCode,$dates[$i],$project);
		$pototalQty[$i]=$pototalQty[$i]+$epPurchaseQty;
		//echo "<td align=right>".number_format($epPurchaseQty,3)."</td>";
	}

}
$remainTotal = $pototalQty[0]-$totalQty[0];

				$sqlpor="SELECT SUM(receiveQty-currentQty) as  remainQty from store$project where todat < '$dates[0]'";
				//echo $sqlpor;
				$sqlqpor=mysqli_query($db, $sqlpor);
				$por=mysqli_fetch_array($sqlqpor);
                $remainTotal+= $por[remainQty];
$remainTotal=0;
for($i=1;$i<17;$i++){
$remainTotal = ($remainTotal+$pototalQty[$i])-$totalQty[$i];
//echo "<br>($remainTotal+$pototalQty[$i])-$totalQty[$i]--<br>";
//if($i==18) echo abs($remainTotal);
}
//echo "<br>**remainTotal:$remainTotal**<br>";
if($remainTotal<0)
return abs($remainTotal);
else return 0;
}
?>

<? 
function next10daysReq($sd,$ed,$itemCode,$project){
$todat=todat();
putenv ('TZ=Asia/Dacca'); 
for($j=0,$i=-7;$j<30;$i++,$j++){
	$padd = time()+(86400*$i);
	$dates[$j]=date('Y-m-d', $padd);
}//for
	



global $db;
$sql1="SELECT * from iow where iowProjectCode='$project'".
        "   AND (('$dates[0]' BETWEEN iowSdate AND iowCdate) OR ('$dates[29]' BETWEEN iowSdate AND iowCdate))". 
		"	AND  iowStatus IN ('Approved by Mngr P&C','Approved by MD')";
$sqlq11=mysqli_query($db, $sql1);
//  	echo $sql1;exit();
$r=1;
while($iow=mysqli_fetch_array($sqlq11)){
//echo $r;
$siows=array();
$siowsid=array();	

$sqls00 = "SELECT siow.siowId,siow.siowCode,siow.siowName,siow.siowSdate,siow.siowCdate,dma.dmaQty,iow.iowCode 
from siow,dma,iow 
WHERE ((siow.siowSdate BETWEEN '$dates[0]' AND '$dates[29]') 
 OR (siow.siowCdate BETWEEN '$dates[0]' AND '$dates[29]') 
 OR ('$dates[0]' BETWEEN siow.siowSdate AND siow.siowCdate) 
 OR ('$dates[29]' BETWEEN siow.siowSdate AND siow.siowCdate)) 
 AND iow.iowId='$iow[iowId]' AND siow.iowId='$iow[iowId]' 
 AND dmaItemCode='$itemCode' AND siow.iowId=dma.dmaiow 
 AND siow.siowId=dma.dmasiow";

// echo $sqls00.'<br>';exit;

 $sqlruns= mysqli_query($db, $sqls00);
 $i=0;
 while($siow=mysqli_fetch_array($sqlruns)){
 $siows[$i]="$siow[iowCode].$siow[siowCode]. ($siow[siowName])";
 $siowsid[$i]=$siow[siowId]; 
 $siowsd[$i]=$siow[siowSdate];  
 $siowcd[$i]=$siow[siowCdate];   
 $dmaQty[$i]=$siow[dmaQty];     
 $i++;}

for($j=0;$j<sizeof($siows);$j++){
$mat_perdayRequired=mat_perdayRequired($siowsid[$j],$itemCode,$dates[7],$project);
		for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
			$dailyIssue=dailyIssue($dates[$i],$itemCode,$project,$siowsid[$j]);
			$totalQty[$i]+=$dailyIssue;
		}
		else {
		     if(isValidDate($siowsd[$j],$siowcd[$j],$dates[$i]))
             {$totalQty[$i]+=$mat_perdayRequired; }
		 }//if i<7	
		}//siows

}//dates

$r++;}//iow


$sqlpo1="SELECT * from porder where posl LIKE 'PO_".$project."_%' AND itemCode='$itemCode' AND status=1";// AND dstart BETWEEN '$dates[0]' AND '$dates[29]'";
//echo $sqlpo1;
$sqlqpo1=mysqli_query($db, $sqlpo1);
while($po1=mysqli_fetch_array($sqlqpo1)){
 $tt= explode('_',$po1[posl]);
 $temp = vendorName($tt[3]);

for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
			$dailyReceive = dailyReceive($dates[$i],$itemCode,$project,$po1[posl]);
		  $pototalQty[$i]+=$dailyReceive;
		}
		else if($i==7) {
		        $posdate=$po1[dstart]; 
				$estimated_Receive = estimated_Receive_s_to_e($posdate,$dates[6],$po1[posl],$itemCode);
				$actual_Receive = actual_Receive_s_to_e($posdate,$dates[6],$itemCode,$project,$po1[posl]);
				$overHead = $estimated_Receive-$actual_Receive;
				
				//$sqlpo="SELECT * from poschedule where poid = '$po1[poid]' AND sdate='$dates[$i]'";
				$sqlpo="SELECT * from poschedule where posl = '$po1[posl]' AND itemCode='$itemCode' AND sdate='$dates[$i]'";				
				//echo $sqlpo;
				$sqlqpo=mysqli_query($db, $sqlpo);
				$po=mysqli_fetch_array($sqlqpo);
				$current= $po[qty]+$overHead;
				$pototalQty[$i]+=$po[qty]+$overHead;				

		  }
      else { 
				//$sqlpo="SELECT * from poschedule where poid = '$po1[poid]' AND sdate='$dates[$i]'";
				$sqlpo="SELECT * from poschedule where posl = '$po1[posl]' AND itemCode='$itemCode' AND sdate='$dates[$i]'";				
				//echo $sqlpo;
				$sqlqpo=mysqli_query($db, $sqlpo);
				$po=mysqli_fetch_array($sqlqpo);
				$pototalQty[$i]+=$po[qty];
		}//else
}//for
}//while
for($i=0;$i<8;$i++){
	if($i<7){
		$epPurchaseQty=epPurchaseQty($itemCode,$dates[$i],$project);
		$pototalQty[$i]=$pototalQty[$i]+$epPurchaseQty;
		//echo "<td align=right>".number_format($epPurchaseQty,3)."</td>";
	}
	else if($i==7){
		//echo "<td width='1px'  bgcolor=#FF3333></td>";
		$epPurchaseQty =epPurchasableQty($itemCode,$dates[$i],$project);
		$pototalQty[$i]=$pototalQty[$i]+$epPurchaseQty;
		//echo "<td align=right>".number_format($epPurchaseQty,3)."</td>";
	}

}
$remainTotal = $pototalQty[0]-$totalQty[0];

/*				$sqlpor="SELECT SUM(receiveQty-currentQty) as  remainQty from store$project where todat < '$dates[0]'";
				//echo $sqlpor;
				$sqlqpor=mysqli_query($db, $sqlpor);
				$por=mysqli_fetch_array($sqlqpor);
                $remainTotal+= $por[remainQty];*/
$remainTotal+=mat_stock($project,$itemCode,$dates[0],'');				
//$remainTotal=0;
for($i=1;$i<17;$i++){
$remainTotal = ($remainTotal+$pototalQty[$i])-$totalQty[$i];
//echo "<br>++($remainTotal+$pototalQty[$i])-$totalQty[$i]++<br>";
//if($i==18) echo abs($remainTotal);
}
//echo "<br>**remainTotal:$remainTotal**<br>";
if($remainTotal<0)
return abs($remainTotal);
else return 0;
}
?>


<? 
function getResourceType($itemCode){
	global $db;
	$sql="select resourceType from itemlist where itemCode='$itemCode'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	if($row["resourceType"])return $row["resourceType"];
	return "prorated";
}
function resourceTypeStart($itemCode,$project){
	global $db;
	$order=orderQty($project,$itemCode,3);
	$totalRequired=matTotalRequired($project,$itemCode);
	$nowReq=$totalRequired-$order;
	return $nowReq<0 ? 0 : $nowReq;
}

function nextXdaysReq($sd,$ed,$itemCode,$project,$days,$skip_eqable=false){
$resourceType=getResourceType($itemCode);
if($resourceType=="start"){
	return resourceTypeStart($itemCode,$project);
}
$todat=todat();
putenv ('TZ=Asia/Dacca'); 
for($j=0,$i=-7;$j<30;$i++,$j++){
$padd = time()+(86400*$i);
$dates[$j]=date('Y-m-d', $padd);
}//for


global $db;
$sql1="SELECT iowId from iow where iowProjectCode='$project'".
        "/*   AND (('$dates[0]' <= iowSdate AND '$dates[29]' >= iowCdate)) */". 
		"	AND  iowStatus IN ('Approved by Mngr P&C','Approved by MD')";
$sqlq11=mysqli_query($db, $sql1);
 	// echo $sql1;
$r=1;
while($iow=mysqli_fetch_array($sqlq11)){
//echo $r;
$siows=array();
$siowsid=array();	

$sqls00 = "SELECT siow.siowId,siow.siowCode,siow.siowName,siow.siowSdate,siow.siowCdate,dma.dmaQty,iow.iowCode 
from siow,dma,iow 
WHERE 
/*
(
	(siow.siowSdate BETWEEN '$dates[0]' AND '$dates[29]') 
 OR (siow.siowCdate BETWEEN '$dates[0]' AND '$dates[29]') 
 OR ('$dates[0]' BETWEEN siow.siowSdate AND siow.siowCdate) 
 OR ('$dates[29]' BETWEEN siow.siowSdate AND siow.siowCdate)

 ) AND  */

 iow.iowId='$iow[iowId]' AND siow.iowId='$iow[iowId]' 
 AND dmaItemCode='$itemCode' AND siow.iowId=dma.dmaiow 
 AND siow.siowId=dma.dmasiow";

// echo $sqls00.'<br>';

 $sqlruns= mysqli_query($db, $sqls00);
 $i=0;
 while($siow=mysqli_fetch_array($sqlruns)){
 $siows[$i]="$siow[iowCode].$siow[siowCode]. ($siow[siowName])";
 $siowsid[$i]=$siow[siowId]; 
 $siowsd[$i]=$siow[siowSdate];  
 $siowcd[$i]=$siow[siowCdate];   
 $dmaQty[$i]=$siow[dmaQty];     
 $i++;}

for($j=0;$j<sizeof($siows);$j++){
$mat_perdayRequired=mat_perdayRequired($siowsid[$j],$itemCode,$dates[7],$project);
		for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
		$dailyIssue=dailyIssue($dates[$i],$itemCode,$project,$siowsid[$j]);
		$totalQty[$i]+=$dailyIssue;

		}
		else {
		     if(isValidDate($siowsd[$j],$siowcd[$j],$dates[$i]))
             {$totalQty[$i]+=$mat_perdayRequired; }
		 }//if i<7	
		}//siows

}//dates

$r++;}//iow


$sqlpo1="SELECT * from porder where posl LIKE 'PO_".$project."_%' AND itemCode='$itemCode' AND status=1";// AND dstart BETWEEN '$dates[0]' AND '$dates[29]'";
//echo $sqlpo1;
$sqlqpo1=mysqli_query($db, $sqlpo1);
while($po1=mysqli_fetch_array($sqlqpo1)){
 $tt= explode('_',$po1[posl]);
 $temp = vendorName($tt[3]);

for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
			$dailyReceive = dailyReceive($dates[$i],$itemCode,$project,$po1[posl]);
		  $pototalQty[$i]+=$dailyReceive;
		}
		else if($i==7) {
		        $posdate=$po1[dstart]; 
				$estimated_Receive = estimated_Receive_s_to_e($posdate,$dates[6],$po1[posl],$itemCode);
				$actual_Receive = actual_Receive_s_to_e($posdate,$dates[6],$itemCode,$project,$po1[posl]);
				$overHead = $estimated_Receive-$actual_Receive;
				
				//$sqlpo="SELECT * from poschedule where poid = '$po1[poid]' AND sdate='$dates[$i]'";
				$sqlpo="SELECT * from poschedule where posl = '$po1[posl]' AND itemCode='$itemCode' AND sdate='$dates[$i]'";				
				//echo $sqlpo;
				$sqlqpo=mysqli_query($db, $sqlpo);
				$po=mysqli_fetch_array($sqlqpo);
				$current= $po[qty]+$overHead;
				$pototalQty[$i]+=$po[qty]+$overHead;				

		  }
      else {
				//$sqlpo="SELECT * from poschedule where poid = '$po1[poid]' AND sdate='$dates[$i]'";
				$sqlpo="SELECT * from poschedule where posl = '$po1[posl]' AND itemCode='$itemCode' AND sdate='$dates[$i]'";				
				//echo $sqlpo;
				$sqlqpo=mysqli_query($db, $sqlpo);
				$po=mysqli_fetch_array($sqlqpo);
				$pototalQty[$i]+=$po[qty];
		}//else
}//for
}//while
for($i=0;$i<8;$i++){
	if($i<7){
		$epPurchaseQty=epPurchaseQty($itemCode,$dates[$i],$project);
		$pototalQty[$i]=$pototalQty[$i]+$epPurchaseQty;
		//echo "<td align=right>".number_format($epPurchaseQty,3)."</td>";
	}
	else if($i==7){
		$epPurchaseQty=0;
		if($skip_eqable==false){
			//echo "<td width='1px'  bgcolor=#FF3333></td>";
			$epPurchaseQty=epPurchasableQty($itemCode,$dates[$i],$project);
			//echo "<td align=right>".number_format($epPurchaseQty,3)."</td>";
		}
		$pototalQty[$i]=$pototalQty[$i]+$epPurchaseQty;
	}

}
$remainTotal = $pototalQty[0]-$totalQty[0];

/*				$sqlpor="SELECT SUM(receiveQty-currentQty) as  remainQty from store$project where todat < '$dates[0]'";
				//echo $sqlpor;
				$sqlqpor=mysqli_query($db, $sqlpor);
				$por=mysqli_fetch_array($sqlqpor);
                $remainTotal+= $por[remainQty];*/
$remainTotal+=mat_stock($project,$itemCode,$dates[0],'');				
//$remainTotal=0;
for($i=1;$i<$days+7;$i++){
$remainTotal = ($remainTotal+$pototalQty[$i])-$totalQty[$i];
// echo "<br>++($remainTotal+$pototalQty[$i])-$totalQty[$i]++<br>";
//if($i==18) echo abs($remainTotal);
}
//echo "<br>**remainTotal:$remainTotal**<br>";
if($remainTotal<0)
return abs($remainTotal);
else return 0;
}
?>


<? 
function eqnext10daysReq($itemCode,$project){


	global $db;
$tt=explode('-',$itemCode);
	
 
putenv ('TZ=Asia/Dacca'); 
$myTime=strtotime(todat());
$toalQty=array();
$dates=array();	
for($j=0,$i=-7;$j<30;$i++,$j++){
//$padd = $myTime+(84600*$i);
$padd = time()+(86400*$i);
$dates[$j]=date('Y-m-d', $padd);
}//for
//print_r($dates);

$sql1="SELECT * from iow where iowProjectCode='$project'".
        "   AND (((iowSdate BETWEEN '$dates[0]' AND '$dates[29]') OR (iowCdate BETWEEN '$dates[0]' AND '$dates[29]'))". 
        "   OR (('$dates[0]' BETWEEN  iowSdate AND iowCdate) OR ('$dates[29]' BETWEEN  iowSdate AND iowCdate)) )". 				
		"	AND  iowStatus IN ('Approved by Mngr P&C','Approved by MD')";
//echo $sql1.'<br>';

$sqlq11=mysqli_query($db, $sql1);
$r=1;
while($iow=mysqli_fetch_array($sqlq11)){
//echo $r;
$siows=array();
$siowsid=array();	


$sqls00 = "SELECT siow.siowId,siow.siowCode,siow.siowName,siow.siowSdate,siow.siowCdate,dma.dmaQty,iow.iowCode from siow,dma,iow WHERE ".
        "   (((siow.siowSdate BETWEEN '$dates[0]' AND '$dates[29]') OR (siow.siowCdate BETWEEN '$dates[0]' AND '$dates[29]')) ".
        "   OR (('$dates[0]' BETWEEN  siow.siowSdate AND siow.siowCdate) OR ('$dates[29]' BETWEEN  siow.siowSdate AND siow.siowCdate)) )". 				
		" AND iow.iowId='$iow[iowId]' AND siow.iowId='$iow[iowId]' AND dmaItemCode='$itemCode' AND siow.iowId=dma.dmaiow AND siow.siowId=dma.dmasiow";

//echo $sqls00.'<br>';

 $sqlruns= mysqli_query($db, $sqls00);
 $i=0;
 while($siow=mysqli_fetch_array($sqlruns)){
	$siows[$i]="$siow[iowCode].$siow[siowCode]. ($siow[siowName])";
	$siowsid[$i]=$siow[siowId]; 
	$siowsd[$i]=$siow[siowSdate];  
	$siowcd[$i]=$siow[siowCdate];   
	$dmaQty[$i]=$siow[dmaQty];    
 $i++;}

?>

<? 
for($j=0;$j<sizeof($siows);$j++){
$eq_perdayRequired=eq_perdayRequired($siowsid[$j],$itemCode,$dates[7],$project);
		for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
		$dailyIssue=eqTodayWorksiow($itemCode,$dates[$i],$siowsid[$j]);
		$totalQty[$i]+=$dailyIssue;
		$issuedQty+=$dailyIssue;
		}
		else {
		     if(isValidDate($siowsd[$j],$siowcd[$j],$dates[$i]))
             {//echo sec2hms($eq_perdayRequired,$padHours=false); 
			 $totalQty[$i]+=$eq_perdayRequired*3600;}
		//echo 
		 }//if i<7	
		}//siows

}//dates

$r++;}//iow
?>
<? 

$sqlpo1="SELECT * from eqproject where pCode='$project' AND itemCode='$itemCode' AND status<>0 ";
//echo $sqlpo1;
$sqlqpo1=mysqli_query($db, $sqlpo1);
while($po1=mysqli_fetch_array($sqlqpo1)){
 if($po1[assetId]{0}=='A'){
  //echo eqpId_local($po1[assetId],$itemCode); 
  $type='L';
  }
else {
//echo eqpId($po1[assetId],$itemCode); 
$type='H'; 
}


$planDispatchDate=planDispatchDate($po1[posl],$itemCode); 
 $duration=(strtotime($planDispatchDate)-strtotime($po1[receiveDate]))/(24*3600);
 $hour=$duration*8;
for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
			$workt= eq_dailywork($po1[assetId],$itemCode,$dates[$i],$type,$project);

			$pototalQty[$i]+=$workt;			
		}
		else if($i==7) {
		 if(strtotime($planDispatchDate)>=strtotime($dates[$i]))				
			$pototalQty[$i]+=8*3600;
			  }
             else { 
		 if(strtotime($planDispatchDate)>=strtotime($dates[$i]))				
			$pototalQty[$i]+=8*3600;
				}//else

}//for
//echo "</tr>";

}//while
?>
<? 
for($i=7;$i<17;$i++){
//echo "--pototalQty=$dates[$i]:".sec2hms($pototalQty[$i]/3600,$padHours=false).'=='.sec2hms($totalQty[$i]/3600,$padHours=false);

$remainTotal = $pototalQty[$i]-$totalQty[$i];
//echo "--$remainTotal = $pototalQty[$i]-$totalQty[$i]--";
$remainQty[$i]=$remainTotal;
if($remainTotal<0){
$remainTotalGT+= abs($remainTotal);
}

//sec2hms(($siow[perday]*3600)/3600,$padHours=false);
}

return sec2hms($remainTotalGT/3600,$padHours=false);
}


?>


<? 
function eqnextXdaysReq($itemCode,$project,$days){


	global $db;
$tt=explode('-',$itemCode);
	
 
putenv ('TZ=Asia/Dacca'); 
$myTime=strtotime(todat());
$toalQty=array();
$dates=array();	
for($j=0,$i=-7;$j<30;$i++,$j++){
//$padd = $myTime+(84600*$i);
$padd = time()+(86400*$i);
$dates[$j]=date('Y-m-d', $padd);
}//for
//print_r($dates);

$sql1="SELECT * from iow where iowProjectCode='$project'".
        "   AND (((iowSdate BETWEEN '$dates[0]' AND '$dates[30]') OR (iowCdate BETWEEN '$dates[0]' AND '$dates[30]'))". 
        "   OR (('$dates[0]' BETWEEN  iowSdate AND iowCdate) OR ('$dates[30]' BETWEEN  iowSdate AND iowCdate)) )". 				
		"	AND  iowStatus IN ('Approved by Mngr P&C','Approved by MD')";
//echo $sql1.'<br>';

$sqlq11=mysqli_query($db, $sql1);
$r=1;
while($iow=mysqli_fetch_array($sqlq11)){
//echo $r;
$siows=array();
$siowsid=array();	


$sqls00 = "SELECT siow.siowId,siow.siowCode,siow.siowName,siow.siowSdate,siow.siowCdate,dma.dmaQty,iow.iowCode from siow,dma,iow WHERE ".
        "   (((siow.siowSdate BETWEEN '$dates[0]' AND '$dates[30]') OR (siow.siowCdate BETWEEN '$dates[0]' AND '$dates[30]')) ".
        "   OR (('$dates[0]' BETWEEN  siow.siowSdate AND siow.siowCdate) OR ('$dates[30]' BETWEEN  siow.siowSdate AND siow.siowCdate)) )". 				
		" AND iow.iowId='$iow[iowId]' AND siow.iowId='$iow[iowId]' AND dmaItemCode='$itemCode' AND siow.iowId=dma.dmaiow AND siow.siowId=dma.dmasiow";

//echo $sqls00.'<br>';

 $sqlruns= mysqli_query($db, $sqls00);
 $i=0;
 while($siow=mysqli_fetch_array($sqlruns)){
	$siows[$i]="$siow[iowCode].$siow[siowCode]. ($siow[siowName])";
	$siowsid[$i]=$siow[siowId]; 
	$siowsd[$i]=$siow[siowSdate];  
	$siowcd[$i]=$siow[siowCdate];   
	$dmaQty[$i]=$siow[dmaQty];    
 $i++;}

?>

<? 
for($j=0;$j<sizeof($siows);$j++){
$eq_perdayRequired=eq_perdayRequired($siowsid[$j],$itemCode,$dates[7],$project);
		for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
		$dailyIssue=eqTodayWorksiow($itemCode,$dates[$i],$siowsid[$j]);
		$totalQty[$i]+=$dailyIssue;
		$issuedQty+=$dailyIssue;
		}
		else {
		     if(isValidDate($siowsd[$j],$siowcd[$j],$dates[$i]))
             {//echo sec2hms($eq_perdayRequired,$padHours=false); 
			 $totalQty[$i]+=$eq_perdayRequired*3600;}
		//echo 
		 }//if i<7	
		}//siows

}//dates

$r++;}//iow
?>
<? 

$sqlpo1="SELECT * from eqproject where pCode='$project' AND itemCode='$itemCode' AND status<>0 ";
//echo $sqlpo1;
$sqlqpo1=mysqli_query($db, $sqlpo1);
while($po1=mysqli_fetch_array($sqlqpo1)){
 if($po1[assetId]{0}=='A'){
  //echo eqpId_local($po1[assetId],$itemCode); 
  $type='L';
  }
else {
//echo eqpId($po1[assetId],$itemCode); 
$type='H'; 
}


$planDispatchDate=planDispatchDate($po1[posl],$itemCode); 
 $duration=(strtotime($planDispatchDate)-strtotime($po1[receiveDate]))/(24*3600);
 $hour=$duration*8;
for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
			$workt= eq_dailywork($po1[assetId],$itemCode,$dates[$i],$type,$project);

			$pototalQty[$i]+=$workt;			
		}
		else if($i==7) {
		 if(strtotime($planDispatchDate)>=strtotime($dates[$i]))				
			$pototalQty[$i]+=8*3600;
			  }
             else { 
		 if(strtotime($planDispatchDate)>=strtotime($dates[$i]))				
			$pototalQty[$i]+=8*3600;
				}//else

}//for
//echo "</tr>";

}//while
?>
<? 
for($i=7;$i<$days+7;$i++){
//echo "--pototalQty=$dates[$i]:".sec2hms($pototalQty[$i]/3600,$padHours=false).'=='.sec2hms($totalQty[$i]/3600,$padHours=false);

$remainTotal = $pototalQty[$i]-$totalQty[$i];
//echo "--$remainTotal = $pototalQty[$i]-$totalQty[$i]--";
$remainQty[$i]=$remainTotal;
if($remainTotal<0){
$remainTotalGT+= abs($remainTotal);
}

//sec2hms(($siow[perday]*3600)/3600,$padHours=false);
}

return sec2hms($remainTotalGT/3600,$padHours=false);
}


?>

<? 
function empnext10daysReq($itemCode,$project){
	global $db;
putenv ('TZ=Asia/Dacca'); 
$myTime=strtotime(todat());
$toalQty=array();
$dates=array();	
for($j=0,$i=-7;$j<30;$i++,$j++){
//$padd = $myTime+(84600*$i);
$padd = time()+(86400*$i);
$dates[$j]=date('Y-m-d', $padd);
}
$sql1="SELECT * from iow where iowProjectCode='$project'".
        "   AND (((iowSdate BETWEEN '$dates[0]' AND '$dates[29]') OR (iowCdate BETWEEN '$dates[0]' AND '$dates[29]'))". 
        "   OR (('$dates[0]' BETWEEN  iowSdate AND iowCdate) OR ('$dates[29]' BETWEEN  iowSdate AND iowCdate)) )". 				
		"	AND  iowStatus IN ('Approved by Mngr P&C','Approved by MD')";
//echo $sql1.'<br>';

$sqlq11=mysqli_query($db, $sql1);
$r=1;
while($iow=mysqli_fetch_array($sqlq11)){
//echo $r;
$siows=array();
$siowsid=array();	


$sqls00 = "SELECT siow.siowId,siow.siowCode,siow.siowName,siow.siowSdate,siow.siowCdate,dma.dmaQty,iow.iowCode from siow,dma,iow WHERE ".
        "   (((siow.siowSdate BETWEEN '$dates[0]' AND '$dates[29]') OR (siow.siowCdate BETWEEN '$dates[0]' AND '$dates[29]')) ". 
        "   OR (('$dates[0]' BETWEEN  siow.siowSdate AND siow.siowCdate) OR ('$dates[29]' BETWEEN  siow.siowSdate AND siow.siowCdate)) ) ". 				
		" AND iow.iowId='$iow[iowId]' AND siow.iowId='$iow[iowId]' AND dmaItemCode='$itemCode' AND siow.iowId=dma.dmaiow AND siow.siowId=dma.dmasiow";

//echo $sqls00.'<br>';

 $sqlruns= mysqli_query($db, $sqls00);
 $i=0;
 while($siow=mysqli_fetch_array($sqlruns)){
 $siows[$i]="$siow[iowCode].$siow[siowCode]. ($siow[siowName])";
 $siowsid[$i]=$siow[siowId]; 
 $siowsd[$i]=$siow[siowSdate];  
 $siowcd[$i]=$siow[siowCdate];   
 $dmaQty[$i]=$siow[dmaQty];     
 $i++;}
//print_r($siows);
?>

<? 
for($j=0;$j<sizeof($siows);$j++){
$emp_perdayRequired=0;
$emp_perdayRequired=emp_perdayRequired($siowsid[$j],$itemCode,$dates[7],$project);

		for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
		$dailyIssue=empTodayWorksiow($itemCode,$dates[$i],$siowsid[$j]);
		$totalQty[$i]+=$dailyIssue;
		}
		else {
		     if(isValidDate($siowsd[$j],$siowcd[$j],$dates[$i]))
             { $totalQty[$i]+=$emp_perdayRequired; }
		 }//if i<7	
		}//siows

}//dates

$r++;}//iow
?>

<? 

$sql1="SELECT distinct attendance . empId  from employee , attendance where".
" designation = '$itemCode' AND attendance.empId=employee.empId AND".
" attendance . location = '$project' AND attendance . edate between '$dates[0]' AND '$dates[29]'".
"  AND status = 0  ORDER BY `attendance` . `empId` ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($em=mysqli_fetch_array($sqlq1)){
$duration=0;
$empReportDate=empReportDate($em[empId]);
$empStayDate=empStayDate($em[empId]);
$duration=1+((strtotime($empStayDate)-strtotime($empReportDate))/(86400));
$duration=round($duration);
$hour=$duration*8;

	for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
		 $workt= dailywork($em[empId],$dates[$i],'H',$project);
		 $pototalQty[$i]+= $workt;
		}		
		else {
		 if(strtotime($empStayDate)>=strtotime($dates[$i]) AND strtotime($empReportDate)<=strtotime($dates[$i]))
		  {
		  $pototalQty[$i]+=8*3600;
		   }

		}//else
	
	}//for

}//while

?>

<? 
for($i=7;$i<17;$i++){
//echo "--Qty=$dates[$i]: ".sec2hms($pototalQty[$i]/3600,$padHours=false).'--';
//echo sec2hms($totalQty[$i]/3600,$padHours=false)."--<br>";
$remainTotal = $pototalQty[$i]-$totalQty[$i];
//echo "--Qty: $remainTotal = $pototalQty[$i]-$totalQty[$i]=";
//echo sec2hms(abs($remainTotal)/3600,$padHours=false)."--<br>";
//$remainQty[$i]=$remainTotal;
if($remainTotal<0){
	$remainTotalGT+= abs($remainTotal);
	}
}

return sec2hms($remainTotalGT/3600,$padHours=false);
}
?>

<?
/* return per day requirement */
function siowdmaPerDay($duration,$qty){
if($duration)
{
	$perday=$qty/$duration;
	return $perday;
}
else return 0;
}
?>

<? /* return SIOW duration */
function siowDuration($siow){
	global $db;
$sqlf="SELECT (to_days(siowCdate)-to_days(siowSdate))+1 as duration from siow where siowId=$siow";
$sqlqf=mysqli_query($db, $sqlf);
$ref= mysqli_fetch_array($sqlqf);
return $ref[duration];
}
?>
<? /* return IOW duration */
function iowDuration($siow){
$sqlf="SELECT (to_days(iowCdate)-to_days(iowSdate))+1 as duration from iow where siowId=$siow";
$sqlqf=mysqli_query($db, $sqlf);
$ref= mysqli_fetch_array($sqlqf);
return $ref[duration];
}
?>

<? /* return SIOW days remain */
function siowDaysRem($siow,$d){
	global $db;
$sqlf="SELECT (to_days(siowCdate)-to_days('$d'))+1 as duration from siow where siowId=$siow";
//echo $sqlf.'<br>';
$sqlqf=mysqli_query($db, $sqlf);
$ref= mysqli_fetch_array($sqlqf);
//echo "***$ref[duration]***";
if($ref[duration]>0) return $ref[duration];
 else return 0;
}
?>
<? /* return SIOW days gone  */
function siowDaysGan($siow,$d){
	global $db;
$sqlf="SELECT (to_days('$d')-to_days(siowSdate)) as duration from siow where siowId=$siow";
$sqlqf=mysqli_query($db, $sqlf);
$ref= mysqli_fetch_array($sqlqf);
if($ref[duration]>0) return $ref[duration];
 else return 0;
}
?>

<?
function direct_labour_no($itemCode,$project){
	global $db;
$sqlf="SELECT *  from employee where designation='$itemCode' AND location='$project'";
//echo $sqlf;
$sqlqf=mysqli_query($db, $sqlf);
$ref= mysqli_num_rows($sqlqf);
return $ref;

}
?>
<?
function viewPosl($po){
return $po;
// echo "<br>$po<br>";
// $fte=explode('_',$po);
// return "$fte[0]_$fte[1]_$fte[2]";
}
?>
<?
function viewInvoiceStatus($p){
  if($p==1) return "Raised";
     if($p==2) return "Received";
}
?>
<?
function invoicedQty($iowId){
	global $db;
$sqlf="SELECT sum(qty) as totalqty  from invoicedetail where".
" iowId=$iowId ";

//echo $sqlf;
$sqlqf=mysqli_query($db, $sqlf);
$ref= mysqli_fetch_row($sqlqf);
if($ref[0]==''){
return $ref[0]=0;}else{
return $ref[0];
}
}
?>

<?
function invoiceRemQty($iowId,$qty,$unit){
	global $db;
$sqlf="SELECT sum(qty) as totalqty  from invoicedetail where".
" iowId=$iowId ";

//echo $sqlf;
$sqlqf=mysqli_query($db, $sqlf);
$ref= mysqli_fetch_row($sqlqf);
if($unit=='L.S' OR $unit=='LS' OR $unit=='l.s' OR $unit=='l.s') 
$qty=100;
return $qty-$ref[0];
}
?>
<?
function iowStatus($iowId){
	global $db;
$sqlf="SELECT iowStatus from iow where iowId='$iowId' ";
//echo $sqlf;
$sqlqf=mysqli_query($db, $sqlf);
$ref= mysqli_fetch_array($sqlqf);
return $ref[iowStatus];
}
?>

<?
function approvedQty($siowId,$itemCode){
	global $db;
$sqlf="SELECT dmaQty from dma where dmasiow=$siowId AND dmaItemCode='$itemCode'";
// echo $sqlf;
$sqlqf=mysqli_query($db, $sqlf);
$ref= mysqli_fetch_array($sqlqf);
return $ref[dmaQty];
}
?>
<?
function approvedsiowQty($siowId){
	global $db;
$sqlf="SELECT siowQty from siow where siowId=$siowId ";
//echo $sqlf;
$sqlqf=mysqli_query($db, $sqlf);
$ref= mysqli_fetch_array($sqlqf);
return $ref[siowQty];
}
?>

<?
function approvedRate($siowId,$itemCode){
	global $db;
$sqlf="SELECT dmaRate from dma where dmasiow=$siowId AND dmaItemCode='$itemCode'";
//echo $sqlf;
$sqlqf=mysqli_query($db, $sqlf);
$ref= mysqli_fetch_array($sqlqf);
return $ref[dmaRate];
}
?>
<?
function approvedtotalcost($iowId){
	global $db;
$sqlf="SELECT iowQty*iowPrice as cost from iow where iowId=$iowId";
//echo $sqlf;
$sqlqf=mysqli_query($db, $sqlf);
$ref= mysqli_fetch_array($sqlqf);
return $ref[cost];
}
?>


<? 
function issuedQty1($siow,$item,$pp){
global $db;
$iss=0;
$issQty=0;
	 
$sqls1 = "SELECT sum(issuedQty) as total from `issue$pp` WHERE siowId='$siow' AND itemCode='$item'";
// echo $sqls1;
$sqlruns1= mysqli_query($db, $sqls1);
if(mysqli_affected_rows($db)>0){
$out = mysqli_fetch_array($sqlruns1);
if($out[total]) $issQty= $out[total];
return $issQty;
}
	else return 0.000;
}?>
